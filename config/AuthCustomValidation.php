<?php
return
[   "registermessages" => [
    "email.unique"=> " this email adress is used ",

        'email.required' => 'The email field is required.',
        'password.required' => 'The password field is required.',
        'name.required' => 'The name field is required.',
]
,
"registerRules" =>[
    "email" => "required|unique:users",
    "password" => "required",
    "name" => "required"

],
"loginMessages" => [
    'email.required' => 'The email field is required.',
    'password.required' => 'The password field is required.',
]
,
"loginRules" =>[
"email" => "required",
"password" => "required",

]
];



