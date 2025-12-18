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
                    'avatar'       => $user['avatar'], // Add avatar to session
                    'is_logged_in' => true,
                ];
                session()->set($sessionData);
                
                // Log Activity
                log_activity('login', 'User logged in successfully.');

                return redirect()->to('/dashboard');
            }
        }

        return redirect()->back()->withInput()->with('error', 'Invalid login credentials.');
    }

    public function logout()
    {
        // Log Activity before destroying session
        log_activity('logout', 'User logged out.');
        
        session()->destroy();
        return redirect()->to('/login');
    }

    // Forgot Password
    public function forgotPassword()
    {
        if ($this->request->getMethod() === 'post') {
            $email = $this->request->getPost('email');
            $userModel = new UserModel();
            $user = $userModel->where('email', $email)->first();

            if ($user) {
                $token = bin2hex(random_bytes(32));
                
                $resetModel = new \App\Models\PasswordResetModel();
                $resetModel->insert([
                    'email' => $email,
                    'token' => $token,
                    'created_at' => date('Y-m-d H:i:s')
                ]);

                // Send Email
                $this->sendResetEmail($email, $token);
                
                log_activity('forgot_password', 'Requested reset for: ' . $email);
            }

            // Always show success to prevent email enumeration
            return redirect()->back()->with('message', 'If your email is registered, you will receive a password reset link.');
        }

        return view('auth/forgot_password');
    }

    public function resetPassword($token)
    {
        $resetModel = new \App\Models\PasswordResetModel();
        
        // Simple expiry check (e.g., 1 hour)
        $reset = $resetModel->where('token', $token)
                            ->where('created_at >=', date('Y-m-d H:i:s', strtotime('-1 hour')))
                            ->first();

        if (!$reset) {
            return redirect()->to('/forgot-password')->with('error', 'Invalid or expired token.');
        }

        return view('auth/reset_password', ['token' => $token, 'email' => $reset['email']]);
    }

    public function attemptReset()
    {
        $token = $this->request->getPost('token');
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        $confpassword = $this->request->getPost('confpassword');

        if ($password !== $confpassword) {
            return redirect()->back()->with('error', 'Passwords do not match.');
        }

        $resetModel = new \App\Models\PasswordResetModel();
        $reset = $resetModel->where('token', $token)
                            ->where('email', $email)
                            ->first();

        if (!$reset) {
            return redirect()->to('/forgot-password')->with('error', 'Invalid token.');
        }

        // Update Password
        $userModel = new UserModel();
        $user = $userModel->where('email', $email)->first();
        if ($user) {
            $userModel->update($user['id'], [
                'password_hash' => password_hash($password, PASSWORD_DEFAULT)
            ]);
            
            // Delete token
            $resetModel->where('email', $email)->delete();

            log_activity('reset_password', 'Password reset successfully for: ' . $email);
            
            return redirect()->to('/login')->with('message', 'Password has been reset successfully. Please login.');
        }
        
        return redirect()->to('/forgot-password')->with('error', 'User not found.');
    }

    private function sendResetEmail($email, $token)
    {
        $emailService = \Config\Services::email();

        $emailService->setTo($email);
        $emailService->setSubject('Password Reset Request');
        $emailService->setMessage(
            "Hello,<br><br>" . 
            "You requested a password reset. Click the link below to reset it:<br>" .
            "<a href='" . base_url('reset-password/' . $token) . "'>Reset Password</a><br><br>" . 
            "If you did not request this, please ignore this email."
        );

        // Suppress errors if config is missing, user warned in Plan
        if (!$emailService->send()) {
            log_message('error', 'Email send failed: ' . $emailService->printDebugger(['headers']));
        }
    }
}
