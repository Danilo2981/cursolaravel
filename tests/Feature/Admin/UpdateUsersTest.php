<?php

namespace Tests\Feature\Admin;

use App\Models\Profession;
use App\Models\Skill;
use Tests\TestCase;
use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateUsersTest extends TestCase
{
    use RefreshDatabase;

    protected $defaultData = [
        'name' => 'Danilo',
        'email' => 'danilo.vega@gmail.com',
        'password' => '123456',
        'profession_id' => '',
        'bio' => 'Programador de Laravel y Vue.js',
        'twitter' => 'https://twitter.com/danilo',
        'role' => 'user'
    ]; 

   /** @test */

   function it_loads_the_edit_user_page() 
   {
      $user = User::factory()->create();

      $this->get("/usuarios/{$user->id}/editar") // usuarios/5/editar
           ->assertStatus(200)
           ->assertViewIs('users.edit')
           ->assertSee('Editar usuario')
           ->assertViewHas('user', function ($viewUser) use ($user){ 
               return $viewUser->id == $user->id;
           }); 
   }

   /** @test */

  function it_updates_a_user()
  {
      $user = User::factory()->create();
      $oldProfession = Profession::factory()->create();
      $user->profile()->save(UserProfile::factory()->make([
          'profession_id' => $oldProfession->id,
      ]));

      $oldSkill1 = Skill::factory()->create();
      $oldSkill2 = Skill::factory()->create();
      $user->skills()->attach([$oldSkill1->id, $oldSkill2->id]);

      $newProfession = Profession::factory()->create();
      $newSkill1 = Skill::factory()->create();
      $newSkill2 = Skill::factory()->create();

      $this->put("/usuarios/{$user->id}", [
          'name' => 'Danilo',
          'email' => 'danilo.vega@gmail.com',
          'password' => '123456',
          'bio' => 'Programador de Laravel y Vue.js',
          'twitter' => 'https://twitter.com/danilo',
          'role' => 'admin',
          'profession_id' => $newProfession->id,
          'skills' => [$newSkill1->id, $newSkill2->id],
      ])->assertRedirect("/usuarios/{$user->id}");

      $this->assertCredentials([
          'name' => 'Danilo',
          'email' => 'danilo.vega@gmail.com',
          'password' => '123456',
          'role' => 'admin'
      ]);
      
      $this->assertDatabaseHas('user_profiles', [
          'user_id' => $user->id,
          'bio' => 'Programador de Laravel y Vue.js',
          'twitter' => 'https://twitter.com/danilo',
          'profession_id' => $newProfession->id,
      ]);

      $this->assertDatabaseCount('user_skill', 2);

      $this->assertDatabaseHas('user_skill', [
          'user_id' => $user->id,
          'skill_id' => $newSkill1->id  
      ]);

      $this->assertDatabaseHas('user_skill', [
        'user_id' => $user->id,
        'skill_id' => $newSkill2->id  
    ]);
  }

  /** @test */

  function the_users_stay_the_same()
  {   
      $user = User::factory()->create([
          'email' => 'danilo.vega@gmail.com'
      ]);

      $this->from("usuarios/{$user->id}/editar")
      ->put("/usuarios/{$user->id}", $this->withData([
          'name' => 'Danilo',
          'email' => 'danilo.vega@gmail.com'
      ]))
      ->assertRedirect("usuarios/{$user->id}");

      $this->assertDatabaseHas('users', [
          'name' => 'Danilo',
          'email' => 'danilo.vega@gmail.com'
      ]);      
  }

  /** @test */

  function if_detaches_all_the_skills_if_none_is_checked()
  {
      $user = User::factory()->create();
      
      $oldSkill1 = Skill::factory()->create();
      $oldSkill2 = Skill::factory()->create();
      $user->skills()->attach([$oldSkill1->id, $oldSkill2->id]);

      $this->put("/usuarios/{$user->id}", $this->withData([]))
          ->assertRedirect("/usuarios/{$user->id}");

      $this->assertDatabaseEmpty('user_skill');
  }

  /** @test */

  function the_name_is_required()
  {
      $this->handleValidationExceptions();

      $user = User::factory()->create();

      $this->from("usuarios/{$user->id}/editar")
      ->put("/usuarios/{$user->id}", $this->withData([
          'name' => ''
      ]))
      ->assertRedirect("usuarios/{$user->id}/editar")
      ->assertSessionHasErrors(['name']);

      $this->assertDatabaseMissing('users', ['email' => 'danilo.vega@gmail.com']);
  }

  /** @test */

  function the_email_must_be_valid()
  {   
      $this->handleValidationExceptions();

      $user = User::factory()->create();

      $this->from("usuarios/{$user->id}/editar")
      ->put("/usuarios/{$user->id}", $this->withData([
        'email' => 'correo-no-valido',
      ]))
      ->assertRedirect("usuarios/{$user->id}/editar")
      ->assertSessionHasErrors(['email']);

      $this->assertDatabaseMissing('users', ['name' => 'Danilo']);    
  }

  /** @test */

  function the_email_must_be_unique()
  {    
    $this->handleValidationExceptions();

      User::factory()->create([
          'email' => 'existing-email@example.com'
      ]);

      $user = User::factory()->create([
          'email' => 'danilo.vega@gmail.com'
      ]);

      $this->from("usuarios/{$user->id}/editar")
      ->put("usuarios/{$user->id}", $this->withData([
            'email' => 'existing-email@example.com',
      ]))
      ->assertRedirect("usuarios/{$user->id}/editar")
      ->assertSessionHasErrors(['email']);

  }  

  /** @test */

  function the_password_is_optional()
  {   
      $oldPassword = 'CLAVE_ANTERIOR';

      $user = User::factory()->create([
          'password' => bcrypt($oldPassword)
      ]);

      $this->from("usuarios/{$user->id}/editar")
      ->put("/usuarios/{$user->id}", $this->withData([
          'password' => ''
      ]))
      ->assertRedirect("usuarios/{$user->id}");

      $this->assertCredentials([
          'name' => 'Danilo',
          'email' => 'danilo.vega@gmail.com',
          'password' => $oldPassword
      ]);      
  }

  /** @test */

  function the_role_is_required()
  {
      $this->handleValidationExceptions();

      $user = User::factory()->create();

      $this->from("usuarios/{$user->id}/editar")
      ->put("/usuarios/{$user->id}", $this->withData([
          'role' => ''
      ]))
      ->assertRedirect("usuarios/{$user->id}/editar")
      ->assertSessionHasErrors(['role']);

      $this->assertDatabaseMissing('users', ['email' => 'danilo.vega@gmail.com']);
  }
  
   /** @test */

   function the_role_must_be_valid()
   {
       $this->handleValidationExceptions();

       $this->post('/usuarios/', $this->withData([
           'role' => 'invalid-role'
       ]))->assertSessionHasErrors('role');

       $this->assertDatabaseEmpty('users');
   }

    /** @test */

   function the_bio_is_required()
   {   
       $this->handleValidationExceptions();

       $this->post('/usuarios/', $this->withData([
           'bio' => '',
       ]))->assertSessionHasErrors(['bio']);

       $this->assertDatabaseEmpty('user_profiles');    
   }

    /** @test */

    function the_twitter_field_is_optional()
    {
        $this->post('/usuarios/', $this->withData([
            'twitter' => null
        ]))->assertRedirect('usuarios');

        $this->assertCredentials([
            'name' => 'Danilo',
            'email' => 'danilo.vega@gmail.com',
            'password' => '123456'
        ]);
        
        $this->assertDatabaseHas('user_profiles', [
            'bio' => 'Programador de Laravel y Vue.js',
            'twitter' => null,
            'user_id' => User::findByEmail('danilo.vega@gmail.com')->id
        ]);
    }

     /** @test */

     function the_profession_field_is_optional()
     {
         $this->post('/usuarios/', $this->withData([
             'profession_id' => ''
         ]))->assertRedirect('usuarios');
 
         $this->assertCredentials([
             'name' => 'Danilo',
             'email' => 'danilo.vega@gmail.com',
             'password' => '123456',
         ]);
         
         $this->assertDatabaseHas('user_profiles', [
             'bio' => 'Programador de Laravel y Vue.js',
             'user_id' => User::findByEmail('danilo.vega@gmail.com')->id,
             'profession_id' => null,
         ]);
     }

    /** @test */

    function the_profession_must_be_valid()
    {   
       $this->handleValidationExceptions();

        $this->post('/usuarios/', $this->withData([
            'profession_id' => '999'
        ]))->assertSessionHasErrors(['profession_id']);

        $this->assertDatabaseEmpty('users');     
    }

    /** @test */

    function the_profession_selectable_is_the_one_valid()
    {   
       $deletedProfession = Profession::factory()->create([
           'deleted_at' => now()->format('Y-m-d'),
       ]);
       
       $this->handleValidationExceptions();

        $this->post('/usuarios/', $this->withData([
            'profession_id' => $deletedProfession->id
        ]))->assertSessionHasErrors(['profession_id']);

        $this->assertDatabaseEmpty('users');      
    }

    /** @test */

    function the_skills_must_be_an_array()
    {   
       $this->handleValidationExceptions();

        $this->post('/usuarios/', $this->withData([
            'skills' => 'PHP, JS'
        ]))->assertSessionHasErrors(['skills']);

        $this->assertDatabaseEmpty('users');    
    }

    /** @test */

    function the_skills_must_be_valid()
    {   
       $this->handleValidationExceptions();

       $skillA = Skill::factory()->create();
       $skillB = Skill::factory()->create();

        $this->post('/usuarios/', $this->withData([
            'skills' => [$skillA->id, $skillB->id+1]
        ]))->assertSessionHasErrors(['skills']);

        $this->assertDatabaseEmpty('users');      
    }
}
