<?php
return[
    'arrival' => (object)[
        'method' => "POST",
        'controller' => 'ArrivalController',
        'action' => 'index'
    ],
    'arrival/\d{1,}' => (object)[
        'method' => "GET",
        'controller' => 'ArrivalController',
        'action' => 'show'
    ],
    'arrival/create' => (object)[
        'method' => "POST",
        'controller' => 'ArrivalController',
        'action' => 'create'
    ],
    'arrival/\d{1,}/update' => (object)[
        'method' => "PUT",
        'controller' => 'ArrivalController',
        'action' => 'update'
    ],
    'arrival/\d{1,}/delete' => (object)[
        'method' => "DELETE",
        'controller' => 'ArrivalController',
        'action' => 'delete'
    ],
];