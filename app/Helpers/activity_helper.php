<?php

use App\Models\ActivityLogModel;

if (!function_exists('log_activity')) {
    /**
     * Log user activity
     *
     * @param string $action Short action name (e.g., 'login', 'create_user')
     * @param string|null $description Detailed description
     * @return bool
     */
    function log_activity($action, $description = null)
    {
        $activityLogModel = new ActivityLogModel();
        
        $request = service('request');
        $agent = $request->getUserAgent();
        
        // Handle User Agent object or string
        $currentAgent = '';
        if ($agent->isBrowser()) {
            $currentAgent = $agent->getBrowser() . ' ' . $agent->getVersion();
        } elseif ($agent->isRobot()) {
            $currentAgent = $agent->getRobot();
        } elseif ($agent->isMobile()) {
            $currentAgent = $agent->getMobile();
        } else {
            $currentAgent = 'Unidentified User Agent';
        }
        
        $data = [
            'user_id'     => session()->get('user_id'), // Correct session key
            'action'      => $action,
            'description' => $description,
            'ip_address'  => $request->getIPAddress(),
            'user_agent'  => $currentAgent, // Simply storing browser info
        ];

        return $activityLogModel->insert($data);
    }
}
