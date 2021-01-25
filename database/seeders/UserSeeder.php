<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Profession;
use App\Models\Skill;
use App\Models\Team;
use App\Models\UserProfile;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use function GuzzleHttp\Promise\all;

class UserSeeder extends Seeder
{   
    protected $professions;

    protected $skills;

    protected $teams;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $professionId = Profession::where('title', 'Desarrollador back-end')->value('id');
        // para obtener profesion en especifico
        
        $this->fetchRelations();

        $this->createAdmin();
        
        foreach (range(1, 999) as $i) {
           $this->createRandomUser();
        }
        
    }

    protected function fetchRelations()
        {
            $this->professions = Profession::all();

            $this->skills = Skill::all();

            $this->teams = Team::all();
        }
       
    protected function createAdmin()
        {
            $admin = User::factory()->create([
                'team_id' => $this->teams->firstWhere('name', 'Styde'),
                'name' => 'Danilo Vega',
                'email' => 'danilo.vega@gmail.com',
                'password' => bcrypt('123456'),
                'role' => 'admin',
                'created_at' => now()->addDay()
            ]);

            $admin->skills()->attach($this->skills);

            $admin->profile()->create([
                'bio' => 'Programador, profesor, editor, escritor, social media manager',
                'profession_id' => $this->professions->firstWhere('title', 'Desarrollador back-end')->id,
            ]);
        }    
    
    protected function createRandomUser()
    {
         // Remplaza el user_id en UserProfileFactory evitando que no se creen mas usuarios
         $user = User::factory()->create([
            'team_id' => rand(0, 2) ? null : $this->teams->random()->id,
        ]);
        
        // Crea habilidades y las ata al usuario
        $user->skills()->attach($this->skills->random(rand(0, 7)));
        
        // Crea usuarios con esa profesion
        UserProfile::factory()->create([
            'user_id' => $user->id,
            // La mitad tiene profesion y el resto no, establece profesion aleatoria y luego el id
            'profession_id' => rand(0, 2) ? $this->professions->random()->id : null
        ]);
    }

}
