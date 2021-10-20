<?php

namespace App\Filters;

use App\Controllers\AuthController;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AuthAdminFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        helper('auth');
        if (!logged_in()) {
            return redirect()->to('admin/login');
        } else if(logged_in() && user()->is_super_admin == 0) {
            return redirect()->to('admin/logout');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}