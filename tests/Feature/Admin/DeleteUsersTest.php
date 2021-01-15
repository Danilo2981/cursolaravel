<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeleteUsersTest extends TestCase
{
    use RefreshDatabase;


    /** @test */

    function it_sends_a_user_to_the_trash()
    {
        $user = User::factory()->create();

        $this->patch("usuarios/{$user->id}/papelera")
            ->assertRedirect('usuarios');
        
        // Option 1:    
        $this->assertSoftDeleted('users', [
            'id' => $user->id
        ]);

        // Option 2:
        $user->refresh();

        $this->assertTrue($user->trashed());
    }

    // /** @test */

    // function it_deletes_a_user()
    // {
    //     $user = User::factory()->create();

    //     $this->delete("usuarios/{$user->id}")
    //         ->assertRedirect('usuarios');
        
    //     $this->assertDatabaseMissing('users', [
    //         'id' => $user->id
    //     ]);
    // }
}
