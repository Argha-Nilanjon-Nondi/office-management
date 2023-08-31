<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Permission;

class PermissionSeeder extends Seeder
{
  /**
  * Run the database seeds.
  */
  public function run(): void
  {
    Permission::create(['name' => 'view_user']);
    Permission::create(['name' => 'manage_users']);
  }
}