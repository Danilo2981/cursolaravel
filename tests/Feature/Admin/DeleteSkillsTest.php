<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;
use App\Models\Skill;
use App\Models\UserSkill;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeleteSkillsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */

    function it_sends_a_skill_to_the_trash()
    {
        $skill = Skill::factory()->create();
        
        $this->patch("habilidades/{$skill->id}/papelera")
             ->assertRedirect('habilidades');

        // Option 1:    
        $this->assertSoftDeleted('skills', [
            'id' => $skill->id
        ]);

        // Option 2:
        $skill->refresh();

        $this->assertTrue($skill->trashed());
    }    

    /** @test */

    function it_completely_deletes_a_skill()
    {
        $skill = Skill::factory()->create([
            'deleted_at' => now()
        ]);

        $this->delete("habilidades/{$skill->id}")
              ->assertRedirect(route('skills.trashed'));

        $this->assertDatabaseEmpty('skills');
    }


     /** @test */

     function a_skill_associated_to_a_profile_cannot_be_deleted()
     {
        $this->withExceptionHandling();
        
        $skill = Skill::factory()->create();

        $profile = UserSkill::factory()->create([
            'skill_id' => $skill->id, 
        ]);

        $response = $this->patch("habilidades/{$skill->id}/papelera");
 
        $response->assertStatus(400);
 
        $this->assertDatabaseHas('skills', [
             'id' => $skill->id
        ]);
     }
}
