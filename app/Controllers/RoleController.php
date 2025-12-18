<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\RoleModel;
use App\Models\PermissionModel;
use App\Models\RolePermissionModel;

class RoleController extends BaseController
{
    protected $roleModel;
    protected $permissionModel;
    protected $rolePermissionModel;

    public function __construct()
    {
        $this->roleModel = new RoleModel();
        $this->permissionModel = new PermissionModel();
        $this->rolePermissionModel = new RolePermissionModel();
    }

    public function index()
    {
        $search = $this->request->getGet('search');
        
        if ($search) {
            $this->roleModel->like('name', $search)
                ->orLike('description', $search);
        }
        
        $data = [
            'roles' => $this->roleModel->paginate(10),
            'pager' => $this->roleModel->pager,
            'search' => $search
        ];
        
        return view('roles/index', $data);
    }

    public function create()
    {
        return view('roles/create');
    }

    public function store()
    {
        $rules = [
            'name' => 'required|is_unique[roles.name]|min_length[3]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->roleModel->insert([
            'name'        => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
        ]);

        log_activity('create_role', 'Created role: ' . $this->request->getPost('name'));
        return redirect()->to('/roles')->with('message', 'Role created successfully');
    }

    public function edit($id)
    {
        $data['role'] = $this->roleModel->find($id);
        if (!$data['role']) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        return view('roles/edit', $data);
    }

    public function update($id)
    {
        $rules = [
            'name' => "required|is_unique[roles.name,id,$id]|min_length[3]",
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->roleModel->update($id, [
            'name'        => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
        ]);

        log_activity('update_role', 'Updated role ID: ' . $id);
        return redirect()->to('/roles')->with('message', 'Role updated successfully');
    }

    public function delete($id)
    {
        $this->roleModel->delete($id);
        log_activity('delete_role', 'Deleted role ID: ' . $id);
        return redirect()->to('/roles')->with('message', 'Role deleted successfully');
    }

    public function permissions($roleId)
    {
        $data['role'] = $this->roleModel->find($roleId);
        $data['permissions'] = $this->permissionModel->findAll();
        $data['rolePermissions'] = array_column($this->roleModel->getPermissions($roleId), 'id');
        
        return view('roles/permissions', $data);
    }

    public function updatePermissions($roleId)
    {
        // First delete existing permissions
        $this->rolePermissionModel->where('role_id', $roleId)->delete();

        $permissions = $this->request->getPost('permissions');
        if (!empty($permissions)) {
            $data = [];
            foreach ($permissions as $permissionId) {
                $data[] = [
                    'role_id'       => $roleId,
                    'permission_id' => $permissionId,
                ];
            }
            $this->rolePermissionModel->insertBatch($data);
        }

        log_activity('update_role_permissions', 'Updated permissions for role ID: ' . $roleId);
        return redirect()->to('/roles')->with('message', 'Role permissions updated');
    }
}
