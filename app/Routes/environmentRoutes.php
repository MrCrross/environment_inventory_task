<?php
return [
    'environment' => (object)[
        'method' => "POST",
        'controller' => 'EnvironmentController',
        'action' => 'index'
    ],
    'environment/\d{1,}' => (object)[
        'method' => "GET",
        'controller' => 'EnvironmentController',
        'action' => 'show'
    ],
    'environment/create' => (object)[
        'method' => "POST",
        'controller' => 'EnvironmentController',
        'action' => 'create'
    ],
    'environment/\d{1,}/update' => (object)[
        'method' => "PUT",
        'controller' => 'EnvironmentController',
        'action' => 'update'
    ],
    'environment/\d{1,}/delete' => (object)[
        'method' => "DELETE",
        'controller' => 'EnvironmentController',
        'action' => 'delete'
    ],
];