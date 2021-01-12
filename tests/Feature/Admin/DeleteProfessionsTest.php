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

    function it_deletes_a_profession()
    {
        $profession = Profession::factory()->create();

        $response = $this->delete("profesiones/{$profession->id}");

        $response->assertRedirect();

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
 
         $response = $this->delete("profesiones/{$profession->id}");
 
         $response->assertStatus(400);
 
         $this->assertDatabaseHas('professions', [
             'id' => $profession->id
         ]);
     }
}
