<?php
use App\User;
use Illuminate\Database\Seeder;

class UserSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(User::class)->create([
            "email" => 'ejvrivas@gmail.com',
            "password" => bcrypt("12345678")
        ]);
    }
}
