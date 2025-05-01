<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Zone;
use Laravel\Sanctum\Sanctum;

class ZoneTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        // Create and authenticate a user for testing
        Sanctum::actingAs(
            User::factory()->create(),
            ['*']
        );
    }

    /** @test */
    public function it_can_create_a_zone()
    {
        $data = [
            'name' => 'Front Yard',
            'area' => '1000 sq.ft'
        ];

        $response = $this->postJson('/api/zones', $data);

        $response->assertStatus(201)
                 ->assertJsonFragment($data);

        $this->assertDatabaseHas('zones', $data);
    }

    /** @test */
    public function it_can_update_a_zone()
    {
        $zone = Zone::factory()->create();

        $data = [
            'name' => 'Updated Zone',
            'area' => 'Updated Area'
        ];

        $response = $this->putJson("/api/zones/{$zone->id}", $data);

        $response->assertStatus(200)
                 ->assertJsonFragment($data);

        $this->assertDatabaseHas('zones', $data);
    }

    /** @test */
    public function it_can_delete_a_zone()
    {
        $zone = Zone::factory()->create();

        $response = $this->deleteJson("/api/zones/{$zone->id}");

        $response->assertStatus(204);

        $this->assertDatabaseMissing('zones', ['id' => $zone->id]);
    }

    /** @test */
    public function it_can_list_all_zones()
    {
        $zones = Zone::factory()->count(3)->create();

        $response = $this->getJson('/api/zones');

        $response->assertStatus(200)
                 ->assertJsonCount(3, 'data');
    }

    /** @test */
    public function it_can_show_a_zone()
    {
        $zone = Zone::factory()->create();

        $response = $this->getJson("/api/zones/{$zone->id}");

        $response->assertStatus(200)
                 ->assertJsonFragment([
                     'id' => $zone->id,
                     'name' => $zone->name,
                     'area' => $zone->area,
                 ]);
    }
}
