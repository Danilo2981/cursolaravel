<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;
use App\Models\User;
use App\Models\Skill;
use App\Models\UserSkill;
use App\Models\UserProfile;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeleteUsersTest extends TestCase
{
    use RefreshDatabase;


    /** @test */

    function it_sends_a_user_to_the_trash()
    {
        $user = User::factory()->create();

        // Relacion uno a muchos
        $user->profile()->save(UserProfile::factory()->make());

        // Relacion muchos a muchos con la habilidad
        $user->skills()->attach(Skill::factory()->create());
        
        $this->patch("usuarios/{$user->id}/papelera")
            ->assertRedirect('usuarios');
        
        // Option 1:    
        $this->assertSoftDeleted('users', [
            'id' => $user->id
        ]);

        // Borra el perfil del usuario que va a la papelera
        $this->assertSoftDeleted('user_profiles', [
            'user_id' => $user->id
        ]);

        // Borra la habilidad del usuario que va a la papelera
        $this->assertSoftDeleted('user_skill', [
            'user_id' => $user->id
        ]);

        // Option 2:
        $user->refresh();

        $this->assertTrue($user->trashed());
    }

    /** @test */

    function it_completely_deletes_a_user()
    {
        $user = User::factory()->create([
            'deleted_at' => now()
        ]);
        
        UserProfile::factory()->create([
            'user_id' => $user->id
        ]);

        $this->delete("usuarios/{$user->id}")
            ->assertRedirect('usuarios/papelera');
        
        $this->assertDatabaseMissing('users', [
            'id' => $user->id
        ]);
    }

     /** @test */

     function it_cannot_delete_a_user_that_is_not_in_the_trash()
     {
        $this->withExceptionHandling();

         $user = User::factory()->create([
             'deleted_at' => null
         ]);
         
         UserProfile::factory()->create([
            'user_id' => $user->id
        ]);
 
         $this->delete("usuarios/{$user->id}")
             ->assertStatus(404);
         
         $this->assertDatabaseHas('users', [
             'id' => $user->id,
             'deleted_at' => null
         ]);
     }
}
