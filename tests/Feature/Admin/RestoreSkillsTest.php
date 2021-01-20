<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;
use App\Models\Skill;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RestoreSkillsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */

    function it_restore_a_skill_from_the_trash()
    {
        $skill = Skill::factory()->create();
        
        $this->patch("habilidades/{$skill->id}/papelera")
             ->assertRedirect('habilidades');

        // Option 1:    
        $this->assertSoftDeleted('skills', [
            'id' => $skill->id
        ]);

        $this->get("habilidades/{$skill->id}/restore")
            ->assertRedirect(route('skills.index'));

        $this->assertDatabaseHas('skills', [
            'id'=> $skill->id,
            'deleted_at' => null
        ]);

        
    }    
}
