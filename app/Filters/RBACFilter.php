<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use App\Libraries\RBACService;

class RBACFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (!session()->get('is_logged_in')) {
            return redirect()->to('/login');
        }

        if (empty($arguments)) {
            return;
        }

        $permission = $arguments[0];
        $rbac = new RBACService();

        if (!$rbac->hasPermission($permission)) {
            // Return 403 Forbidden or redirect
            // For better UX, maybe redirect to a 403 page or show error
            // throw new \CodeIgniter\Exceptions\PageNotFoundException("Access Denied");
            // Or cleaner response:
            $response = service('response');
            $response->setStatusCode(403);
            $response->setBody('Access Denied: You do not have permission ' . $permission);
            return $response;
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do nothing here
    }
}
