<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ActivityLogModel;

class LogsController extends BaseController
{
    protected $activityLogModel;

    public function __construct()
    {
        $this->activityLogModel = new ActivityLogModel();
    }

    public function index()
    {
        $search = $this->request->getGet('search');
        
        if ($search) {
            $this->activityLogModel->groupStart()
                ->like('action', $search)
                ->orLike('description', $search)
                ->orLike('ip_address', $search)
                ->groupEnd();
        }
        
        // Join with users to get names if possible
        $data = [
            'logs' => $this->activityLogModel->getLogsWithUser()->paginate(15),
            'pager' => $this->activityLogModel->pager,
            'search' => $search
        ];

        return view('logs/index', $data);
    }
}
