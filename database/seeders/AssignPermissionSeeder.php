<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Permission;

class AssignPermissionSeeder extends Seeder
{
  /**
  * Run the database seeds.
  */
  public function run(): void
  {
    $email = 'argha@gmail.com';
    $user = User::where('email', $email)->first();
    $permission = Permission::findByName("view_user");
    $user->givePermissionTo($permission);
  }
}