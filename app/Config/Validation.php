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
                'required' => 'email field is required.',
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
    public $docketStore = [
        'docket_no' => [
            'rules'  => 'required',
            'errors' => [
                'required' => 'Docket No field is required.',
            ],
        ],
    ];
    public $asignDocket = [
        'docket_id' => [
            'rules'  => 'required',
            'errors' => [
                'required' => 'Docket No field is required.',
            ],
        ],
        'employee_id' => [
            'rules'  => 'required',
            'errors' => [
                'required' => 'Employee field is required.',
            ],
        ],
    ];
    public $companyUpdate = [
        'company_name' => [
            'rules'  => 'required',
            'errors' => [
                'required' => 'Company Name field is required.',
            ],
        ],
        'owner_name' => [
            'rules'  => 'required',
            'errors' => [
                'required' => 'Owner Name field is required.',
            ],
        ],
        'phone'    => [
            'rules'  => 'required',
            'errors' => [
                'required' => 'Phone Number is required.',
            ],
        ],
        'email'    => [
            'rules'  => 'required|valid_email',
            'errors' => [
                'required' => 'Email field is required.',
                'valid_email' => 'Please check the Email field. It does not appear to be valid.',
            ],
        ],
        'address'    => [
            'rules'  => 'required',
            'errors' => [
                'required' => 'Address is required.',
            ],
        ],
        'city'    => [
            'rules'  => 'required',
            'errors' => [
                'required' => 'City is required.',
            ],
        ],
        'state'    => [
            'rules'  => 'required',
            'errors' => [
                'required' => 'State is required.',
            ],
        ],
        'zip'    => [
            'rules'  => 'required',
            'errors' => [
                'required' => 'Zip is required.',
            ],
        ],
    ];
    public $update_signature = [
        'signature' => [
            'rules'  => 'required',
            'errors' => [
                'required' => 'Signature field is required.',
            ],
        ],
    ];
    public $subscription_plan = [
        'name' => [
            'rules'  => 'required',
            'errors' => [
                'required' => 'Subscription name field is required.',
            ],
        ],
        'price' => [
            'rules'  => 'required',
            'errors' => [
                'required' => 'Subscription Price field is required.',
            ],
        ],
        'description' => [
            'rules'  => 'required',
            'errors' => [
                'required' => 'Description field is required.',
            ],
        ],
    ];

}
