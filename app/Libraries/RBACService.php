<?php

namespace App\Libraries;

use App\Models\UserModel;

class RBACService
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function hasPermission($permissionName)
    {
        $userId = session()->get('user_id');

        if (!$userId) {
            return false;
        }

        // Super Admin Bypass (optional, but good practice)
        if ($this->userModel->hasRole($userId, 'Super Admin')) {
            return true;
        }

        return $this->userModel->hasPermission($userId, $permissionName);
    }

    public function hasRole($roleName)
    {
        $userId = session()->get('user_id');

        if (!$userId) {
            return false;
        }

        return $this->userModel->hasRole($userId, $roleName);
    }
}
