<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class WelcomeUsersTest extends TestCase
{
    /** @test */

    function it_welcomes_users_with_nickname() 
    {
        $this->get('/saludo/danilo/dark')
            ->assertStatus(200)
            ->assertSee('Bienvenido danilo, tu apodo es dark');
    }

    /** @test */

    function it_welcomes_users_without_nickname() 
    {
        $this->get('/saludo/danilo')
            ->assertStatus(200)
            ->assertSee('Bienvenido danilo, no tienes apodo');
    }
}
