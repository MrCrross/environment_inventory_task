<?php
return [
    'category' => (object)[
        'method' => "GET",
        'controller' => 'CategoryController',
        'action' => 'index'
    ],
    'category/\d{1,}' => (object)[
        'method' => "GET",
        'controller' => 'CategoryController',
        'action' => 'show'
    ],
    'category/create' => (object)[
        'method' => "POST",
        'controller' => 'CategoryController',
        'action' => 'create'
    ],
    'category/\d{1,}/update' => (object)[
        'method' => "PUT",
        'controller' => 'CategoryController',
        'action' => 'update'
    ],
    'category/\d{1,}/delete' => (object)[
        'method' => "DELETE",
        'controller' => 'CategoryController',
        'action' => 'delete'
    ],
];