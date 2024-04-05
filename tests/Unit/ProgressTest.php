<?php

namespace Tests\Unit;

use App\Models\Progress;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProgressTest extends TestCase
{
    use RefreshDatabase;

    public function testStoreProgress()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $data = [
            'weight' => 70,
            'waist' => 30,
            'abs' => 3,
            'status' => 'incomplete',
            'created_at' => '2024-04-04T14:13:22.000000Z',
            'updated_at' => '2024-04-04T14:13:22.000000Z'


        ];

        $response = $this->postJson(route('progress.store'), $data);

        $response->assertCreated();
        $this->assertDatabaseHas('progress', [
            'user_id' => $user->id,
            'weight' => 70,
            'waist' => 30,
            'abs' => 3,

        ]);
    }

    public function testShowProgress()
    {
        $user = User::factory()->create();
        $progress = Progress::factory()->create(['user_id' => $user->id]);
        $this->actingAs($user);

        $response = $this->getJson(route('progress.show', $progress));

        $response->assertOk();
        $response->assertJson([
            'data' => [
                'weight' => $progress->weight,
                'waist' => $progress->waist,
                'abs' => $progress->abs,
                //'status' => 'incomplete',
                'created_at' => '2024-04-04T14:13:22.000000Z',
                'updated_at' => '2024-04-04T14:13:22.000000Z'


            ]
        ]);
    }

    public function testUpdateProgress()
    {
        $user = User::factory()->create();
        $progress = Progress::factory()->create(['user_id' => $user->id]);
        $this->actingAs($user);

        $data = [
            'weight' => 70,
            'waist' => 30,
            'abs' => 3,
            'status' => 'complete',
        ];

        $response = $this->putJson(route('progress.update', $progress), $data);

        $response->assertOk();
        $this->assertDatabaseHas('progress', [
            'id' => $progress->id,
            'user_id' => $user->id,
            'weight' => 70,
            'waist' => 30,
            'abs' => 3,
            'status' => 'complete',
        ]);
    }

    public function testDestroyProgress()
    {
        $user = User::factory()->create();
        $progress = Progress::factory()->create(['user_id' => $user->id]);
        $this->actingAs($user);

        $response = $this->deleteJson(route('progress.destroy', $progress));

        $response->assertNoContent();
        $this->assertDatabaseMissing('progress', [
            'id' => $progress->id,
        ]);
    }
}
