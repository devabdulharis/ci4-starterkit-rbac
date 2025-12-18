<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\RoleModel;
use App\Models\UserRoleModel;

class UserController extends BaseController
{
    protected $userModel;
    protected $roleModel;
    protected $userRoleModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->roleModel = new RoleModel();
        $this->userRoleModel = new UserRoleModel();
    }

    public function index()
    {
        $search = $this->request->getGet('search');
        
        if ($search) {
            $this->userModel->groupStart()
                ->like('name', $search)
                ->orLike('email', $search)
                ->groupEnd();
        }
        
        $data = [
            'users' => $this->userModel->paginate(10),
            'pager' => $this->userModel->pager,
            'search' => $search
        ];
        
        return view('users/index', $data);
    }

    public function create()
    {
        return view('users/create');
    }

    public function store()
    {
        $rules = [
            'name'     => 'required|min_length[3]',
            'email'    => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[6]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'name'          => $this->request->getPost('name'),
            'email'         => $this->request->getPost('email'),
            'password_hash' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'is_active'     => $this->request->getPost('is_active') ? 1 : 0,
        ];

        $this->userModel->insert($data);
        log_activity('create_user', 'Created user: ' . $data['email']);
        return redirect()->to('/users')->with('message', 'User created successfully');
    }

    public function edit($id)
    {
        $data['user'] = $this->userModel->find($id);
        if (!$data['user']) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        return view('users/edit', $data);
    }

    public function update($id)
    {
        $rules = [
            'name'  => 'required|min_length[3]',
            'email' => "required|valid_email|is_unique[users.email,id,$id]",
        ];

        if ($this->request->getPost('password')) {
            $rules['password'] = 'min_length[6]';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'name'      => $this->request->getPost('name'),
            'email'     => $this->request->getPost('email'),
            'is_active' => $this->request->getPost('is_active') ? 1 : 0,
        ];

        if ($this->request->getPost('password')) {
            $data['password_hash'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
        }

        $this->userModel->update($id, $data);
        log_activity('update_user', 'Updated user ID: ' . $id);
        return redirect()->to('/users')->with('message', 'User updated successfully');
    }

    public function delete($id)
    {
        $this->userModel->delete($id);
        log_activity('delete_user', 'Deleted user ID: ' . $id);
        return redirect()->to('/users')->with('message', 'User deleted successfully');
    }

    public function roles($userId)
    {
        $data['user'] = $this->userModel->find($userId);
        $data['roles'] = $this->roleModel->findAll();
        $data['userRoles'] = array_column($this->userModel->getRoles($userId), 'id');
        
        return view('users/roles', $data);
    }
    
    public function updateRoles($userId)
    {
        // First remove all existing roles
        $this->userRoleModel->where('user_id', $userId)->delete();
        
        $roles = $this->request->getPost('roles');
        if (!empty($roles)) {
            $data = [];
            foreach ($roles as $roleId) {
                $data[] = [
                    'user_id' => $userId,
                    'role_id' => $roleId,
                ];
            }
            $this->userRoleModel->insertBatch($data);
        }
        
        
        log_activity('update_user_roles', 'Updated roles for user ID: ' . $userId);
        return redirect()->to('/users')->with('message', 'User roles updated');
    }
}
