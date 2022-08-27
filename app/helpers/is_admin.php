<?php

use App\Models\User;
use \App\helpers\enums\Roles;

if (!function_exists('isAdmin')){
    function isAdmin(User $user): bool
    {
        return  $user->role->name === Roles::Admin->value;
    }
}
