<?php

namespace Database\Seeders;

use App\Models\User;
use Hash;
use Illuminate\Database\Seeder;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user=new User();
        $user->name="super admin";
        $user->email="admin@admin.com";
        $user->password=Hash::make("monstermash");
        $user->save();

       
    }
}
