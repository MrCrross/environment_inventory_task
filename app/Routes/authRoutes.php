<?php
return [
    'registration' => (object)[
        'method' => "POST",
        'controller' => 'Auth\RegistrationController',
        'action' => 'registration'
    ],
    'login' => (object)[
        'method' => "POST",
        'controller' => 'Auth\LoginController',
        'action' => 'login'
    ],
    'logout' => (object)[
        'method' => "GET",
        'controller' => 'Auth\LoginController',
        'action' => 'logout'
    ],
];