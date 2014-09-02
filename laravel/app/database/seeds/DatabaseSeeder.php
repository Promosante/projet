<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

		$this->call('AdministrateursTableSeeder');
	}

}


class AdministrateursTableSeeder extends Seeder {

    public function run()
    {
        DB::table('users')->delete();
        DB::table('administrateurs')->delete();

        $adminPass = 'ThisPassIsTheMostTreasured';

        $u=User::create([
	        	'login' => 'TheAdministrator',
	        	'password'=>Hash::make($adminPass),
	        	'email_compte'=>'adminEmail@admin.fr',
	        	'type_compte'=>'CompteAdmin'
        	]);

		Admin::create([
				'compte_id'=>$u->id,
				'nom'=>'The First seeded admin !'
			]);

		Membres::create([
				'user_id'=>$u->id,
				'nom'=>'admin',
				'prenom'=>'admin'
			]);
        
        $this->command->info('Admin account generated !');
    }

}