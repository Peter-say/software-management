<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    User::insert([
      [
        'name' => 'Admin Sudo',
        'email' => 'sudosoftware@gmail.com',
        'role' => 'Admin',
        'avatar' => null,
        'email_verified_at' => now(),
        'password' => Hash::make('password'),
        'remember_token' => Str::random(10),
      ],

      [
        'name' => 'Peter Iriogbe',
        'email' => 'iriogbepeter22@gmail.com',
        'role' => 'Developer',
        'avatar' => null,
        'email_verified_at' => now(),
        'password' => Hash::make('password@devs.com'),
        'remember_token' => Str::random(10),
      ],
    ]);
  }
}
