<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Profession;
use App\Models\Skill;
use App\Models\UserProfile;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use function GuzzleHttp\Promise\all;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $professionId = Profession::where('title', 'Desarrollador back-end')->value('id');
        // para obtener profesion en especifico
        
        $professions = Profession::all();

        $skills = Skill::all();

        $user = User::factory()->create([
            'name' => 'Danilo Vega',
            'email' => 'danilo.vega@gmail.com',
            'password' => bcrypt('123456'),
            'role' => 'admin',
            'created_at' => now()->addDay()
        ]);

        $user->profile()->create([
            'bio' => 'Programador, profesor, editor, escritor, social media manager',
            'profession_id' => $professions->firstWhere('title', 'Desarrollador back-end')->id,
        ]);
        
        // Remplaza el user_id en UserProfileFactory evitando que no se creen mas usuarios
        User::factory(50)->create()->each(function($user) use ($professions, $skills) {
            
            // Crea habilidades y las ata al usuario
            $randomSkills = $skills->random(rand(0, 7));
            $user->skills()->attach($randomSkills);
            
            // Crea usuarios con esa profesion
            UserProfile::factory()->create([
                'user_id' => $user->id,
                // La mitad tiene profesion y el resto no, establece profesion aleatoria y luego el id
                'profession_id' => rand(0, 2) ? $professions->random()->id : null
            ]);
        });
        
    }
}
