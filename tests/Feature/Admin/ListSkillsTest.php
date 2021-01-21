<?php

namespace Tests\Feature\Admin;

use App\Models\Skill;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ListSkillsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */

    function it_shows_the_users_list()
    {
        Skill::factory()->create([
            'name' => 'HTML'
        ]);

        Skill::factory()->create([
            'name' => 'PHP'
        ]);    

        Skill::factory()->create([
            'name' => 'CSS'
        ]);
        
        $this->get('/habilidades')
            ->assertStatus(200)
            ->assertSeeInOrder([
                'CSS',
                'HTML',
                'PHP',
            ]);
    }
}
