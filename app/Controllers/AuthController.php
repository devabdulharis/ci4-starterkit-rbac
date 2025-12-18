<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;

class AuthController extends BaseController
{
    public function login()
    {
        if (session()->get('is_logged_in')) {
            return redirect()->to('/dashboard');
        }
        return view('auth/login');
    }

    public function attemptLogin()
    {
        $log = \Config\Services::logger();
        
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $userModel = new UserModel();
        $user = $userModel->where('email', $email)->first();

        if ($user) {
            if (password_verify($password, $user['password_hash'])) {
                if (!$user['is_active']) {
                    return redirect()->back()->withInput()->with('error', 'Account is missing or inactive.');
                }
                
                $sessionData = [
                    'user_id'      => $user['id'],
                    'name'         => $user['name'],
                    'email'        => $user['email'],
                    'is_logged_in' => true,
                ];
                session()->set($sessionData);
                return redirect()->to('/dashboard');
            }
        }

        return redirect()->back()->withInput()->with('error', 'Invalid login credentials.');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}
