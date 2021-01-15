<?php

namespace Tests\Feature\Admin;

use App\Models\Profession;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UpdateProfessionsTest extends TestCase
{
    use RefreshDatabase;

    protected $defaultData = [
        'title' => 'Programador Laravel'
    ];

    /** @test */

   function it_loads_the_edit_profession_page() 
   {
      $profession = Profession::factory()->create();

      $this->get("/profesiones/{$profession->id}/editar") // usuarios/5/editar
           ->assertStatus(200)
           ->assertViewIs('professions.edit')
           ->assertSee('Editar profesion')
           ->assertViewHas('profession', function ($viewProfession) use ($profession){ 
               return $viewProfession->id == $profession->id;
           }); 
   }


    /** @test */

    function it_updates_a_profession()
    {
        $profession = Profession::factory()->create();

        $this->put("/profesiones/{$profession->id}", [
            'title' => 'Programador Laravel'
        ])->assertRedirect("/profesiones/{$profession->id}");
       
        $this->assertDatabaseHas('professions', [
            'id' => $profession->id,
            'title' => 'Programador Laravel'
        ]);    
    }

    /** @test */

  function the_professions_stay_the_same()
  {   
      $profession = Profession::factory()->create([
          'title' => 'Programador Laravel'
      ]);

      $this->from("profesiones/{$profession->id}/editar")
      ->put("/profesiones/{$profession->id}", $this->withData([
          'title' => 'Programador Laravel',
      ]))
      ->assertRedirect("profesiones/{$profession->id}");

      $this->assertDatabaseHas('professions', [
          'title' => 'Programador Laravel',
      ]);      
  }

   /** @test */

   function the_title_is_required()
   {
       $this->handleValidationExceptions();
 
       $profession = Profession::factory()->create();
 
       $this->from("profesiones/{$profession->id}/editar")
       ->put("/profesiones/{$profession->id}", $this->withData([
           'title' => ''
       ]))
       ->assertRedirect("profesiones/{$profession->id}/editar")
       ->assertSessionHasErrors(['title']);
 
       $this->assertDatabaseMissing('professions', ['title' => 'Programador Laravel']);
   }

}
