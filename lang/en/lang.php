<?php

return [
    'plugin' => [
        'name' => 'SMS',
        'description' => 'SMS System',
        'tab' => 'SMS',
        'access_sms' => 'Manage SMS System',
    ],
    'components' => [
        'verify' => [
            'title' => 'Tabbad Mobile Number',
            'desc' => 'You must confirm your mobile number to use the sites features.',
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
        'setting' => 'bit code',
        'mobile' => 'Mobile number:',
        'mobile_comment' => 'For example: 09123456789',
        'code' => 'SMS code:',
        'code_comment' => 'Enter verification code',
    ],
    'kavenegar' => [
        'title' => 'Kavenegar',
        'token' => 'Access key (Api Key)',
        'from_number' => 'Submission Number (Optional)',
        'footer' => 'Footer text message',
    ],
];
