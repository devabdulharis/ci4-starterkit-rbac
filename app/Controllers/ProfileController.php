<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;

class ProfileController extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $userId = session()->get('user_id');
        $data['user'] = $this->userModel->find($userId);
        return view('profile/index', $data);
    }

    public function update()
    {
        $userId = session()->get('user_id');
        
        $rules = [
            'name'  => 'required|min_length[3]',
            'email' => "required|valid_email|is_unique[users.email,id,$userId]",
        ];

        if ($this->request->getPost('password')) {
            $rules['password'] = 'min_length[6]';
        }

        // Avatar validation
        $rules['avatar'] = [
            'label' => 'Avatar',
            'rules' => 'permit_empty|is_image[avatar]|mime_in[avatar,image/jpg,image/jpeg,image/png]|max_size[avatar,2048]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'name'  => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
        ];

        if ($this->request->getPost('password')) {
            $data['password_hash'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
        }

        // Handle Avatar Upload
        $file = $this->request->getFile('avatar');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move(FCPATH . 'uploads/avatars', $newName);
            $data['avatar'] = $newName;
        }

        // Skip model validation since we handled it in controller (to avoid unique email collision with self)
        if (!$this->userModel->skipValidation(true)->update($userId, $data)) {
            log_message('error', 'Profile Update Failed: ' . json_encode($this->userModel->errors()));
            return redirect()->back()->withInput()->with('errors', $this->userModel->errors());
        }
        
        // Update session name/avatar if changed
        session()->set('name', $data['name']);
        if (isset($data['avatar'])) {
            session()->set('avatar', $data['avatar']);
        }

        log_activity('update_profile', 'User updated profile.');

        return redirect()->to('/profile')->with('message', 'Profile updated successfully');
    }
}
