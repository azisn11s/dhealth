<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // factory(User::class, 10)->create();

        User::query()->updateOrCreate([
            'email'=> 'admin@mail.com'
        ], [
            'name'=> 'Admin',
            'email'=> 'admin@mail.com',
            'password'=> '12345', // bcrypt('password'), // '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
        ]);
    }
}
