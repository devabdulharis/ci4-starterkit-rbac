<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PermissionModel;

class PermissionController extends BaseController
{
    protected $permissionModel;

    public function __construct()
    {
        $this->permissionModel = new PermissionModel();
    }

    public function index()
    {
        $search = $this->request->getGet('search');
        
        if ($search) {
            $this->permissionModel->like('name', $search)
                ->orLike('description', $search);
        }
        
        $data = [
            'permissions' => $this->permissionModel->paginate(10),
            'pager' => $this->permissionModel->pager,
            'search' => $search
        ];
        
        return view('permissions/index', $data);
    }

    public function create()
    {
        return view('permissions/create');
    }

    public function store()
    {
        $rules = [
            'name' => 'required|is_unique[permissions.name]|min_length[3]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->permissionModel->insert([
            'name'        => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
        ]);

        log_activity('create_permission', 'Created permission: ' . $this->request->getPost('name'));
        return redirect()->to('/permissions')->with('message', 'Permission created successfully');
    }

    public function edit($id)
    {
        $data['permission'] = $this->permissionModel->find($id);
        if (!$data['permission']) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        return view('permissions/edit', $data);
    }

    public function update($id)
    {
        $rules = [
            'name' => "required|is_unique[permissions.name,id,$id]|min_length[3]",
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->permissionModel->update($id, [
            'name'        => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
        ]);

        log_activity('update_permission', 'Updated permission ID: ' . $id);
        return redirect()->to('/permissions')->with('message', 'Permission updated successfully');
    }

    public function delete($id)
    {
        $this->permissionModel->delete($id);
        log_activity('delete_permission', 'Deleted permission ID: ' . $id);
        return redirect()->to('/permissions')->with('message', 'Permission deleted successfully');
    }
}
