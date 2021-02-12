<?php

return [
    'plugin' => [
        'name' => 'SMS service settings',
        'description' => 'SMS service settings',
        'tab' => 'SMS Service',
        'access_sms' => 'SMS Service Management',
    ],
    'components' => [
        'verify' => [
            'title' => 'Tabbad Mobile Number',
            'desc' => 'You must confirm your mobile number to use the site features.',
            'desc_code' => 'Enter the code sent to confirm your mobile number.',
            'complete' => 'Mobile number verification is complete, you can now use the system.',
            'btn' => [
                'send' => 'Confirm and send SMS',
                'check' => 'Check code and confirm mobile number',
            ],
        ],
    ],
    'sms' => [
        'title' => 'SMS Service',
        'description' => 'SMS service settings',
        'mobile' => 'Mobile number:',
        'mobile_comment' => 'For example: 09123456789',
        'code' => 'SMS code:',
        'code_comment' => 'Enter verification code',
        'status' => [
            'active' => 'Active',
            'inactive' => 'Inactive',
        ]
    ],
    'options' => [
        'welcome' => 'Welcome',
        'verify' => 'Verify Mobile',
        'order' => [
            'paid' => 'Status Order (paid)',
            'sent' => 'Status Order (Sent)',
        ],
    ],
    'gateway' => [
        'title' => 'gateway SMS',
        'description' => 'Settings for sending SMS',
        'select' => 'Select SMS Port',
        'items' => [
            'global' => [
                'token' => 'Access key (Api Key)',
                'from_number' => 'Send Number',
                'from_number_pattern' => 'Send Number for Pattern',
                'footer' => 'Footer text message',
            ],
            'cuphost' => [
                'title' => 'Cup Host',
                'patterns' => [
                    'welcome' => 'Pattern Code Welcome',
                    'verify' => 'Pattern Code Verify Mobile',
                    'order' => [
                        'paid' => 'Pattern Code Status Order (paid)',
                        'sent' => 'Pattern Code Status Order (Sent)',
                    ],
                ]
            ],
            'kavenegar' => [
                'title' => 'Kave Negar',
            ]
        ]
    ]
];
