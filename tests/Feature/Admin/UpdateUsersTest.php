<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;
use App\Models\User;
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

      $this->put("/usuarios/{$user->id}", [
          'name' => 'Danilo',
          'email' => 'danilo.vega@gmail.com',
          'password' => '123456'
      ])->assertRedirect("usuarios/{$user->id}");

      $this->assertCredentials([
          'name' => 'Danilo',
          'email' => 'danilo.vega@gmail.com',
          'password' => '123456'
      ]);
  }

  /** @test */

  function the_name_is_required()
  {
      $this->handleValidationExceptions();

      $user = User::factory()->create();

      $this->from("usuarios/{$user->id}/editar")
      ->put("/usuarios/{$user->id}", [
          'name' => '',
          'email' => 'danilo.vega@gmail.com',
          'password' => '123456'
      ])
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
      ->put("/usuarios/{$user->id}", [
          'name' => 'Danilo',
          'email' => 'correo-no-valido',
          'password' => '123456'
      ])
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
      ->put("usuarios/{$user->id}", [
          'name' => 'Danilo',
          'email' => 'existing-email@example.com',
          'password' => '123456'
      ])
      ->assertRedirect("usuarios/{$user->id}/editar")
      ->assertSessionHasErrors(['email']);

  }

  /** @test */

  function the_users_stay_the_same()
  {   
      $user = User::factory()->create([
          'email' => 'danilo.vega@gmail.com'
      ]);

      $this->from("usuarios/{$user->id}/editar")
      ->put("/usuarios/{$user->id}", [
          'name' => 'Danilo',
          'email' => 'danilo.vega@gmail.com',
          'password' => '123456789'
      ])
      ->assertRedirect("usuarios/{$user->id}");

      $this->assertDatabaseHas('users', [
          'name' => 'Danilo',
          'email' => 'danilo.vega@gmail.com'
      ]);      
  }

  /** @test */

  function the_password_is_optional()
  {   
      $oldPassword = 'CLAVE_ANTERIOR';

      $user = User::factory()->create([
          'password' => bcrypt($oldPassword)
      ]);

      $this->from("usuarios/{$user->id}/editar")
      ->put("/usuarios/{$user->id}", [
          'name' => 'Danilo',
          'email' => 'danilo.vega@gmail.com',
          'password' => ''
      ])
      ->assertRedirect("usuarios/{$user->id}");

      $this->assertCredentials([
          'name' => 'Danilo',
          'email' => 'danilo.vega@gmail.com',
          'password' => $oldPassword
      ]);      
  }

}
