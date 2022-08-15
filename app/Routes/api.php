<?php

$apiRoutes = [
//    Template:
//    'login' => (object)[
//        'method' => 'GET' | 'POST',
//        'controller' => 'LoginController',
//        'action' => 'login'
//    ],
];
$authRoutes = require_once 'authRoutes.php';
$categoryRoutes = require_once 'categoryRoutes.php';
$equipmentRoutes = require_once 'equipmentRoutes.php';
$userRoutes = require_once 'userRoutes.php';
$arrivalRoutes = require_once 'arrivalRoutes.php';
return (object)array_merge($apiRoutes,$authRoutes,$categoryRoutes,$equipmentRoutes,$userRoutes,$arrivalRoutes);