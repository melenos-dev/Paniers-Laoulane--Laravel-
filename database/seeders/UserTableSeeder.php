<?php
namespace Database\Seeders;
Use DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
	public function run(){
		DB::table('users')->insert([
			'firstname'=>'Maiwenn',
			'lastname'=>'Ragui',
			'phone'=>'0000000000',
			'road'=>'Je sais plus',
			'postal_code'=>'56160',
			'city'=>'Langoelan',
			'email'=>'maikillah@hotmail.fr',
			'password' => Hash::make('Blah'),
			'admin'=>2
			]);
	}
}