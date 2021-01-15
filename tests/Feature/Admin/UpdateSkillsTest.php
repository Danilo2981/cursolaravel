<?php

namespace Tests\Feature\Admin;

use App\Models\Skill;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UpdateSkillsTest extends TestCase
{
    use RefreshDatabase;

    protected $defaultData = [
        'name' => 'PHP'
    ];

    /** @test */

   function it_loads_the_edit_skill_page() 
   {
      $skill = Skill::factory()->create();

      $this->get("/habilidades/{$skill->id}/editar") // habilidades/5/editar
           ->assertStatus(200)
           ->assertViewIs('skills.edit')
           ->assertSee('Editar habilidad')
           ->assertViewHas('skill', function ($viewSkill) use ($skill){ 
               return $viewSkill->id == $skill->id;
           }); 
   }

   /** @test */

   function it_updates_a_skill()
   {
       $skill = Skill::factory()->create();

       $this->put("/habilidades/{$skill->id}", [
           'name' => 'SASS'
       ])->assertRedirect("/habilidades/{$skill->id}");
      
       $this->assertDatabaseHas('skills', [
           'id' => $skill->id,
           'name' => 'SASS'
       ]);    
   }

   /** @test */

  function the_skills_stay_the_same()
  {   
      $skill = Skill::factory()->create([
          'name' => 'SASS'
      ]);

      $this->from("habilidades/{$skill->id}/editar")
      ->put("/habilidades/{$skill->id}", $this->withData([
          'name' => 'SASS',
      ]))
      ->assertRedirect("habilidades/{$skill->id}");

      $this->assertDatabaseHas('skills', [
          'name' => 'SASS',
      ]);      
  }

  /** @test */

  function the_name_is_required()
  {
      $this->handleValidationExceptions();

      $skill = Skill::factory()->create();

      $this->from("habilidades/{$skill->id}/editar")
      ->put("/habilidades/{$skill->id}", $this->withData([
          'name' => ''
      ]))
      ->assertRedirect("habilidades/{$skill->id}/editar")
      ->assertSessionHasErrors(['name']);

      $this->assertDatabaseMissing('skills', ['name' => 'SASS']);
  }

}
