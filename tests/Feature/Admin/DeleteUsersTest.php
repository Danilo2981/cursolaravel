<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeleteUsersTest extends TestCase
{
    use RefreshDatabase;

    /** @test */

    function it_deletes_a_user()
    {
        $user = User::factory()->create();

        $this->delete("usuarios/{$user->id}")
            ->assertRedirect('usuarios');
        
        $this->assertDatabaseMissing('users', [
            'id' => $user->id
        ]);
    }
}
