<?php

namespace Tests\Feature\Admin;

use App\Models\Profession;
use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserProfileTest extends TestCase
{
    use RefreshDatabase;

    protected $defaultData = [
        'name' => 'Danilo',
        'email' => 'danilo.vega@gmail.com',
        'bio' => 'Programador de Laravel y Vue.js',
        'twitter' => 'https://twitter.com/danilo',
    ];

    /** @test */

    function a_user_can_edit_its_profile()
    {
        $user = User::factory()->create();
        $user->profile()->save(UserProfile::factory()->make());

        $newProfession = Profession::factory()->create();

        //Usuario conectado
        //$this->actingAs($user);

        $response = $this->get('/editar-perfil/');

        $response->assertStatus(200);

        $response = $this->put('/editar-perfil/', [
            'name' => 'Danilo',
            'email' => 'danilo.vega@gmail.com',
            'bio' => 'Programador de Laravel y Vue.js',
            'twitter' => 'https://twitter.com/danilo',
            'profession_id' => $newProfession->id,
        ]);

        $response->assertRedirect();

        $this->assertDatabaseHas('users', [
            'name' => 'Danilo',
            'email' => 'danilo.vega@gmail.com',
        ]);

        $this->assertDatabaseHas('user_profiles', [
            'bio' => 'Programador de Laravel y Vue.js',
            'twitter' => 'https://twitter.com/danilo',
            'profession_id' => $newProfession->id,
        ]);
    }

      /** @test */

      function the_user_cannot_change_its_role()
      {
          $user = User::factory()->create([
              'role' => 'user'
          ]);
  
          $response = $this->put('/editar-perfil/', $this->withData([
              'role' => 'admin',
          ]));
  
          $response->assertRedirect();
  
          $this->assertDatabaseHas('users', [
              'id' => $user->id,
              'role' => 'user',
          ]);
      }

       /** @test */

    function the_user_cannot_change_its_password()
    {
        User::factory()->create([
            'password' => bcrypt('old123'),
        ]);

        $response = $this->put('/editar-perfil/', $this->withData([
            'email' => 'danilo.vega@gmail.com',
            'password' => 'new456'
        ]));

        $response->assertRedirect();

        $this->assertCredentials([
            'email' => 'danilo.vega@gmail.com',
            'password' => 'old123',
        ]);
    }
}
