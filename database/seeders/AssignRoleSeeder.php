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
    $email = 'argha@gmail.com';
    $user = User::where('email', $email)->first();
    $adminRole = Role::findByParam(["name" => 'admin']);
    $user->assignRole($adminRole);
  }
}