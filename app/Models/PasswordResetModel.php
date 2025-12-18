<?php

namespace App\Models;

use CodeIgniter\Model;

class PasswordResetModel extends Model
{
    protected $table            = 'password_resets';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['email', 'token', 'created_at'];

    protected $useTimestamps = false; // We manage created_at manually or via default
    protected $dateFormat    = 'datetime';
}
