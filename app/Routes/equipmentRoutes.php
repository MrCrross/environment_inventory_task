<?php
return [
    'equipment' => (object)[
        'method' => "POST",
        'controller' => 'EquipmentController',
        'action' => 'index'
    ],
    'equipment/\d{1,}' => (object)[
        'method' => "GET",
        'controller' => 'EquipmentController',
        'action' => 'show'
    ],
    'equipment/create' => (object)[
        'method' => "POST",
        'controller' => 'EquipmentController',
        'action' => 'create'
    ],
    'equipment/\d{1,}/update' => (object)[
        'method' => "PUT",
        'controller' => 'EquipmentController',
        'action' => 'update'
    ],
    'equipment/\d{1,}/delete' => (object)[
        'method' => "DELETE",
        'controller' => 'EquipmentController',
        'action' => 'delete'
    ],
];