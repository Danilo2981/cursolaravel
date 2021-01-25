<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;
use App\Models\User;
use App\Models\Skill;
use App\Models\UserProfile;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RestoreUsersTest extends TestCase
{
    use RefreshDatabase;


    /** @test */

    function it_restore_a_user_from_the_trash()
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

        $this->get("usuarios/{$user->id}/restore")
            ->assertRedirect(route('users.trashed'));

        $this->assertDatabaseHas('users', [
            'id'=> $user->id,
            'deleted_at' => null
        ]);

        $this->assertDatabaseHas('user_profiles', [
            'user_id'=> $user->id,
            'deleted_at' => null
        ]);

        $this->assertDatabaseHas('user_skill', [
            'user_id'=> $user->id,
            'deleted_at' => null    
        ]);    
    }
}
