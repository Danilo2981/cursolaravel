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

    function it_deletes_a_skill()
    {
        $skill = Skill::factory()->create();
        
        $response = $this->delete("habilidadades/{$skill->id}");

        $response->assertRedirect();

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
 
         $response = $this->delete("habilidades/{$skill->id}");
 
         $response->assertStatus(400);
 
         $this->assertDatabaseHas('skills', [
             'id' => $skill->id
         ]);
     }
}
