<?php

namespace Tests\Feature\Admin;

use App\Models\Team;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SearchUsersTest extends TestCase
{
    use RefreshDatabase;

    /** @test */

    function it_searh_users_by_name() 
    {
        $joel = User::factory()->create([
            'name' => 'Joel'
        ]);

        $tess = User::factory()->create([
            'name' => 'Tess'
        ]);

        $this->get('/usuarios?search=Joel')
            ->assertStatus(200)
            ->assertViewHas('users', function($users) use ($joel, $tess) {

                return $users->contains($joel) && !$users->contains($tess);
            });
    }
    
    /** @test */

     function show_results_with_a_partial_searh_by_name() 
     {
         $joel = User::factory()->create([
             'name' => 'Joel'
         ]);
 
         $tess = User::factory()->create([
             'name' => 'Tess'
         ]);
 
         $this->get('/usuarios?search=Jo')
            ->assertStatus(200)
            ->assertViewHas('users', function($users) use ($joel, $tess) {
                return $users->contains($joel) && !$users->contains($tess);
            });
     }

     /** @test */

    function it_searh_users_by_email() 
    {
        $joel = User::factory()->create([
            'email' => 'joel@dot.com'
        ]);

        $tess = User::factory()->create([
            'email' => 'tess@dot.com'
        ]);

        $this->get('/usuarios?search=joel@dot.com')
            ->assertStatus(200)
            ->assertViewHas('users', function($users) use ($joel, $tess) {
                return $users->contains($joel) && !$users->contains($tess);
            });
    }

    /** @test */

    function show_results_with_a_partial_searh_by_email() 
    {
        $joel = User::factory()->create([
            'email' => 'joel@dot.com'
        ]);

        $tess = User::factory()->create([
            'email' => 'tess@dot.com'
        ]);

        $this->get('/usuarios?search=l@dot.com')
            ->assertStatus(200)
            ->assertViewHas('users', function($users) use ($joel, $tess) {
                return $users->contains($joel) && !$users->contains($tess);
            });
    }

    /** @test */

    function it_searh_users_by_team_name() 
    {
        $joel = User::factory()->create([
            'name' => 'Joel',
            'team_id' => Team::factory()->create(['name' => 'Smuggler'])->id,
        ]);

        $tess = User::factory()->create([
            'name' => 'Tess',
            'team_id' => null
        ]);

        $marlene = User::factory()->create([
            'name' => 'Marlene',
            'team_id' => Team::factory()->create(['name' => 'Fireflay'])->id,
        ]);

        $response = $this->get('/usuarios?search=Fireflay')
            ->assertStatus(200);
            // ->assertViewHas('users', function($users) use ($marlene, $joel, $tess) {
            //     return $users->contains($marlene) 
            //     && !$users->contains($joel)
            //     && !$users->contains($tess);
            // });

        $response->assertViewCollection('users')
            ->contains($marlene)
            ->notContains($joel)
            ->notContains($tess);
    }

    /** @test */

    function it_partial_searh_users_by_team_name() 
    {
        $joel = User::factory()->create([
            'name' => 'Joel',

            'team_id' => Team::factory()->create(['name' => 'Smuggler'])->id,
        ]);
        $tess = User::factory()->create([
            'name' => 'Tess',
            'team_id' => null
        ]);

        $marlene = User::factory()->create([
            'name' => 'Marlene',
            'team_id' => Team::factory()->create(['name' => 'Fireflay'])->id,
        ]);

        $response = $this->get('/usuarios?search=Fire')
            ->assertStatus(200);
            
        $response->assertViewCollection('users')
            ->contains($marlene)
            ->notContains($joel)
            ->notContains($tess);
    }
    

}
