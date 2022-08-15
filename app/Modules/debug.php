<?php
ini_set('display_errors',1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

/**
 * @param string|object|array $data
 * @return void
 */
function dd($data){
    echo '<pre>';
    var_dump($data);
    echo '</pre>';
    exit;
}