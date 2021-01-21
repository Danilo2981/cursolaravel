<?php

namespace Tests\Feature\Admin;

use App\Models\Profession;
use App\Models\UserProfile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeleteProfessionsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */

    function it_sends_a_profession_to_the_trash()
    {
        $profession = Profession::factory()->create();

        $this->patch("profesiones/{$profession->id}/papelera")
            ->assertRedirect('profesiones');
        
        // Option 1:    
        $this->assertSoftDeleted('professions', [
            'id' => $profession->id
        ]);

        // Option 2:
        $profession->refresh();

        $this->assertTrue($profession->trashed());
    }

    /** @test */

    function it_completely_deletes_a_profession()
    {
        $profession = Profession::factory()->create([
            'deleted_at' => now()
        ]);

        $this->delete("profesiones/{$profession->id}")
              ->assertRedirect(route('professions.trashed'));

        $this->assertDatabaseEmpty('professions');
    }

     /** @test */

     function a_profession_associated_to_a_profile_cannot_be_deleted()
     {
        $this->withExceptionHandling();
        
        $profession = Profession::factory()->create();

        $profile = UserProfile::factory()->create([
            'profession_id' => $profession->id, 
        ]);
 
         $response = $this->patch("profesiones/{$profession->id}/papelera");
 
         $response->assertStatus(400);
 
         $this->assertDatabaseHas('professions', [
             'id' => $profession->id
         ]);
     }
}
