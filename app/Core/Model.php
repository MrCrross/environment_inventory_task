<?php

namespace App\Core;

use App\Modules\Database;

abstract class Model extends Database
{
    protected bool $deleted_at = false;
    protected bool $timestamps = true;
}