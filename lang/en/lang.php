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
        'auth' => [
            'title' => 'Login / Membership',
            'desc' => 'User authentication system',
            'send' => 'Login / Membership',
            'check' => 'Please enter the code sent to your mobile or email here.',
            'complete' => 'You have successfully logged in.',
            'btn' => [
                'send' => 'Send code',
                'again' => 'Resend Code',
                'check' => 'Validation',
            ],
            'fields' => [
                'receiver' => 'Enter mobile / email',
                'code' => 'Enter the validation code.'
            ]
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
            'active' => 'active',
            'inactive' => 'inactive',
        ]
    ],
    'options' => [
        'welcome' => 'Welcome',
        'verify' => 'Mobile Validation',
        'order' => [
            'paid' => 'Order status (paid)',
            'sent' => 'Order Status (sent)',
        ],
    ],
    'gateway' => [
        'title' => 'SMS Portal',
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
                    'welcome' => 'Welcome Pattern Code',
                    'verify' => 'Mobile Authentication Pattern Code',
                    'order' => [
                        'paid' => 'Order Pattern Code (Paid)',
                        'sent' => 'Code Pattern Status Order (Sent)',
                    ],
                ]
            ],
            'kavenegar' => [
                'title' => 'Kavenegar',
            ]
        ]
    ],
    'messages' => [
        'inactive' => 'This section is inactive.',
        'code' => [
            'sent' => 'Code sent successfully.',
            'unsent' => 'Code not sent.',
            'uncorrected' => 'The entered code is incorrect.',
            'different' => 'You must enter a different mobile number.',
            'has_verified' => 'The number has already been registered and verified for another user.',
            'verified_1h' => 'Wait at least one hour between each mobile number change and confirmation.',
            'sent_1m' => 'Wait at least one minute between each post and be patient.',
            'sent_3c_10m' => 'You sent the code three times and have to wait another ten minutes.',
            'expired' => 'Sorry, the code expired, please resend the code.',
        ],
        'auth' => [
            'logged' => 'You have been logged in successfully.',
            'registered' => 'Your registration was successful.',
            'notfound' => 'Your login information is incorrect.',
        ],
        'mobile' => [
            'not_entered' => 'Mobile number not entered.',
            'verified' => 'Your mobile number has been verified.',
        ]
    ],
    'patterns' => [
        'welcome' => "Hello, welcome to our site. \ nThanks for your registration",
        'verify' => "Your verification code:% code%",
        'order_paid' => "Your payment to invoice number% order% was paid successfully.",
        'order_sent' => "Your order has been successfully sent to the tracking number% code%. \ nTracking URL:% link%",
    ]
];
