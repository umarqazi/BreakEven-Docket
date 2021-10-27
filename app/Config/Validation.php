<?php

namespace Config;

use CodeIgniter\Validation\CreditCardRules;
use CodeIgniter\Validation\FileRules;
use CodeIgniter\Validation\FormatRules;
use CodeIgniter\Validation\Rules;

class Validation
{
    //--------------------------------------------------------------------
    // Setup
    //--------------------------------------------------------------------

    /**
     * Stores the classes that contain the
     * rules that are available.
     *
     * @var string[]
     */
    public $ruleSets = [
        Rules::class,
        FormatRules::class,
        FileRules::class,
        CreditCardRules::class,
        \Myth\Auth\Authentication\Passwords\ValidationRules::class
    ];

    /**
     * Specifies the views that are used to display the
     * errors.
     *
     * @var array<string, string>
     */
    public $templates = [
        'list'   => 'CodeIgniter\Validation\Views\list',
        'single' => 'CodeIgniter\Validation\Views\single',
    ];

    //--------------------------------------------------------------------
    // Rules
    //--------------------------------------------------------------------

    // public $employeStore = [
    //         'first_name'    => 'required|min_length[3]',
    //         'last_name'     => 'required|min_length[3]',
    //         'email'         => 'required|valid_email',
    // ];
    public $employeStore = [
        'first_name' => [
            'rules'  => 'required',
            'errors' => [
                'required' => 'First Name field is required.',
            ],
        ],
        'last_name' => [
            'rules'  => 'required',
            'errors' => [
                'required' => 'Last Name field is required.',
            ],
        ],
        'email'    => [
            'rules'  => 'required|valid_email',
            'errors' => [
                'valid_email' => 'Please check the Email field. It does not appear to be valid.',
            ],
        ],
    ];
    public $setPassword = [
        'password' => [
            'rules'  => 'required',
            'errors' => [
                'required' => 'Password field is required.',
            ],
        ],
        'confirm_password' => [
            'rules'  => 'required|matches[password]',
            'errors' => [
                'required' => 'Confirm Password field is required.',
                'matches' => 'The Confirm Password field does not match the password field.',
            ],
        ],
    ];
}
