<?php

namespace App\Models;

use CodeIgniter\Model;

class ActivityLogModel extends Model
{
    protected $table            = 'activity_logs';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['user_id', 'action', 'description', 'ip_address', 'user_agent'];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = '';
    protected $deletedField  = '';
    
    // Get activity logs with user info
    public function getLogsWithUser()
    {
        return $this->select('activity_logs.*, users.name as user_name, users.email as user_email')
                    ->join('users', 'users.id = activity_logs.user_id', 'left')
                    ->orderBy('activity_logs.created_at', 'DESC');
    }
}
