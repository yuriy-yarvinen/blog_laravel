<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$userCount = max((int)$this->command->ask('How many users do you want?',20), 1);
		factory(App\User::class)->states('test_new_user')->create();
		factory(App\User::class,$userCount)->create();		
    }
}
