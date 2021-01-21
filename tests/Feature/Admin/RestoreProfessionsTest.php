<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;
use App\Models\Profession;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RestoreProfessionsTest extends TestCase
{use RefreshDatabase;

    /** @test */

    function it_restore_a_profession_from_the_trash()
    {
        $profession = Profession::factory()->create();

        $this->patch("profesiones/{$profession->id}/papelera")
            ->assertRedirect('profesiones');
        
        // Option 1:    
        $this->assertSoftDeleted('professions', [
            'id' => $profession->id
        ]);

        $this->get("profesiones/{$profession->id}/restore")
            ->assertRedirect(route('professions.trashed'));

        $this->assertDatabaseHas('professions', [
            'id'=> $profession->id,
            'deleted_at' => null
        ]);
    }
}
