<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Zone;
use App\Models\Schedule;
use Laravel\Sanctum\Sanctum;
use Illuminate\Support\Facades\Mail;
use App\Mail\ScheduleNotification;

class ScheduleTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $zone;

    public function setUp(): void
    {
        parent::setUp();

        // Create and authenticate a user for testing
        $this->user = User::factory()->create();
        Sanctum::actingAs($this->user, ['*']);

        // Create a zone for testing
        $this->zone = Zone::factory()->create();
    }

    /** @test */
    public function it_can_create_a_schedule()
    {
        Mail::fake();

        $data = [
            'start_time' => '08:00',
            'duration' => '30 minutes',
            'days_of_week' => ['monday', 'wednesday', 'friday']
        ];

        $response = $this->postJson("/api/zones/{$this->zone->id}/schedules", $data);

        $response->assertStatus(201)
                 ->assertJsonFragment($data);

        $this->assertDatabaseHas('schedules', [
            'zone_id' => $this->zone->id,
            'start_time' => '08:00',
            'duration' => '30 minutes',
        ]);

        Mail::assertSent(ScheduleNotification::class, function ($mail) {
            return $mail->hasTo('admin@cashcardng.com');
        });
    }

    /** @test */
    public function it_can_update_a_schedule()
    {
        Mail::fake();

        $schedule = Schedule::factory()->create([
            'zone_id' => $this->zone->id
        ]);

        $data = [
            'start_time' => '10:00',
            'duration' => '45 minutes',
            'days_of_week' => ['tuesday', 'thursday']
        ];

        $response = $this->putJson("/api/zones/{$this->zone->id}/schedules/{$schedule->id}", $data);

        $response->assertStatus(200)
                 ->assertJsonFragment($data);

        $this->assertDatabaseHas('schedules', [
            'id' => $schedule->id,
            'start_time' => '10:00',
            'duration' => '45 minutes',
        ]);

        Mail::assertSent(ScheduleNotification::class, function ($mail) {
            return $mail->hasTo('admin@cashcardng.com');
        });
    }

    /** @test */
    public function it_can_delete_a_schedule()
    {
        $schedule = Schedule::factory()->create([
            'zone_id' => $this->zone->id
        ]);

        $response = $this->deleteJson("/api/zones/{$this->zone->id}/schedules/{$schedule->id}");

        $response->assertStatus(204);

        $this->assertDatabaseMissing('schedules', ['id' => $schedule->id]);
    }

    /** @test */
    public function it_can_list_all_schedules_for_a_zone()
    {
        $schedules = Schedule::factory()->count(3)->create([
            'zone_id' => $this->zone->id
        ]);

        $response = $this->getJson("/api/zones/{$this->zone->id}/schedules");

        $response->assertStatus(200)
                 ->assertJsonCount(3, 'data');
    }

    /** @test */
    public function it_can_show_a_schedule()
    {
        $schedule = Schedule::factory()->create([
            'zone_id' => $this->zone->id
        ]);

        $response = $this->getJson("/api/zones/{$this->zone->id}/schedules/{$schedule->id}");

        $response->assertStatus(200)
                 ->assertJsonFragment([
                     'id' => $schedule->id,
                     'zone_id' => $this->zone->id,
                     'start_time' => $schedule->start_time,
                     'duration' => $schedule->duration,
                 ]);
    }
}
