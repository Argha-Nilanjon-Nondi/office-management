<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;

class AssignRoleSeeder extends Seeder
{
  /**
  * Run the database seeds.
  */
  public function run(): void
  {
    $email = 'alex_admin@gmail.com';
    $user = User::where('email', $email)->first();
    $role = Role::findByParam(["name" => 'admin']);
    $user->assignRole($role);
  }
}