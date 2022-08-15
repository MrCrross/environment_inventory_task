<?php
return[
    'user' => (object)[
        'method' => "GET",
        'controller' => 'UserController',
        'action' => 'index'
    ],
    'user/get' => (object)[
        'method' => "GET",
        'controller' => 'UserController',
        'action' => 'get'
    ],
    'user/\d{1,}' => (object)[
        'method' => "GET",
        'controller' => 'UserController',
        'action' => 'show'
    ],
    'user/create' => (object)[
        'method' => "POST",
        'controller' => 'UserController',
        'action' => 'create'
    ],
    'user/\d{1,}/update' => (object)[
        'method' => "PUT",
        'controller' => 'UserController',
        'action' => 'update'
    ],
    'user/\d{1,}/delete' => (object)[
        'method' => "DELETE",
        'controller' => 'UserController',
        'action' => 'delete'
    ],
];