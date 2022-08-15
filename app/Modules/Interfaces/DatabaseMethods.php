<?php

namespace App\Modules\Interfaces;

interface DatabaseMethods
{
    public function insert(array $data);

    public function select();

    public function update(array $data);

    public function delete();
}