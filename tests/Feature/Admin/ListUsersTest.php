<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ListUsersTest extends TestCase
{
    use RefreshDatabase;

    /** @test */

    function it_shows_the_users_list() 
    {
        User::factory()->create([
            'name' => 'Joel'
        ]);

        User::factory()->create([
            'name' => 'Tess'
        ]);

        $this->get('/usuarios')
            ->assertStatus(200)
            ->assertSee('Listado de usuarios')
            ->assertSee('Joel')
            ->assertSee('Tess');

        $this->assertNotRepeatedQueries();
    }

    /** @test */

    function it_shows_pagination_the_users_list() 
    {
        User::factory()->create([
            'name' => 'Tercer Usuario',
            'created_at' => now()->subDays(5)
        ]);

        User::factory()->times(12)->create([
            'created_at' => now()->subDays(4)
        ]);

        User::factory()->create([
            'name' => 'Decimoseptimo Usuario',
            'created_at' => now()->subDays(2)
        ]);
        
        User::factory()->create([
            'name' => 'Segundo Usuario',
            'created_at' => now()->subDays(6)
        ]);

        User::factory()->create([
            'name' => 'Primer Usuario',
            'created_at' => now()->subWeek()
        ]);
        
        User::factory()->create([
            'name' => 'Decimosexto Usuario',
            'created_at' => now()->subDays(3)
        ]);

        $this->get('/usuarios')
            ->assertStatus(200)
            ->assertSeeInOrder([
                'Decimoseptimo Usuario',
                'Decimosexto Usuario',
                'Tercer Usuario'
            ])
            ->assertDontSee('Segundo Usuario')
            ->assertDontSee('Primer Usuario');
        
        $this->get('/usuarios?page=2')
            ->assertSeeInOrder([
                'Segundo Usuario',
                'Primer Usuario'
            ])
            ->assertDontSee('Tercer Usuario');    
    }

    /** @test */

    function it_a_shows_default_message_if_the_users_list_is_empty() 
    {
        // DB::table('users')->truncate();

        $this->get('/usuarios')
            ->assertStatus(200)
            ->assertSee('No hay usuarios registrados');
    }

    /** @test */

    function it_shows_the_deleted_users_list() 
    {
        User::factory()->create([
            'name' => 'Joel',
            'deleted_at' => now()
        ]);

        User::factory()->create([
            'name' => 'Tess'
        ]);

        $this->get(route('users.trashed'))
            ->assertStatus(200)
            ->assertSee('Papelera')
            ->assertSee('Joel')
            ->assertDontSee('Tess');

    }
}
