<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(! User::where('email', 'info@super.admin')->exists()) {
            User::insertOrIgnore([
                'name'          => 'Super Admin',
                'email'         => 'info@super.admin',
                'phone'         => '00000000000',
                'type'          => 1,
                'password'      => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'created_at'    => now(),
                'updated_at'    => now(),
            ]);
        }
    }
}
