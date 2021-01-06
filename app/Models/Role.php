<?php

namespace App\Models;

class Role
{
    public static function getList()
    {
        return['admin','user'];
    }
}
