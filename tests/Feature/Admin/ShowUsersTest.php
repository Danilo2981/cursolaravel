<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ShowUsersTest extends TestCase
{
    use RefreshDatabase;

    /** @test */

    function it_loads_the_users_details_page() 
    {
        $user = User::factory()->create([
            'name' => 'Danilo Vega'
        ]);

        $this->get('/usuarios/' . $user->user)
            ->assertStatus(200)
            ->assertSee('Danilo Vega');
    }

    /** @test */

    function it_displarys_a_404_error_if_the_user_is_not_found() 
    {
        $this->withExceptionHandling();

        $this->get('/usuarios/999')
            ->assertStatus(404)
            ->assertSee('Pagina no encontrada');
    }
}
