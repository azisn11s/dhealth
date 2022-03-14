<?php

return [
    'default_password'=> env('DEFAULT_USER_PASSWORD', '12345678'),

    'super_admin'=> [
        'email'=> env('SA_EMAIL', 'admin@mail.com')
    ]
];