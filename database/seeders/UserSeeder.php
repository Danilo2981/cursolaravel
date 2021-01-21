<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Profession;
use App\Models\UserProfile;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $professionId = Profession::where('title', 'Desarrollador back-end')->value('id');

        $user = User::factory()->create([
            'name' => 'Danilo Vega',
            'email' => 'danilo.vega@gmail.com',
            'password' => bcrypt('123456'),
            'role' => 'admin'
        ]);

        $user->profile()->create([
            'bio' => 'Programador, musico, poeta y loco',
            'profession_id' => $professionId
        ]);
        
        // Remplaza el user_id en UserProfileFactory evitando que no se creen mas usuarios
        User::factory(999)->create()->each(function($user){
            UserProfile::factory()->create([
                'user_id' => $user->id,
            ]);
        });
        
    }
}
