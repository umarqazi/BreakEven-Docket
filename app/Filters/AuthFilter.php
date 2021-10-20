<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        helper('auth');
        if (!logged_in()) {
            return redirect()->to('login');
        } else if(logged_in() && user()->is_super_admin == 1) {
            return redirect()->to('user/logout')->with('error','Wrong Credentials');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}