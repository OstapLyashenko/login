<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolesTableSeder extends Seeder
{
    public function run()
    {
        $roles = collect(config('constants.db.roles'));
        $roles->each(fn($role) => Role::firstOrCreate(['name' => $role]));
    }
}
