<?php

namespace Tests\Feature;

use App\Models\Feedback;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RestoreFeedbackTest extends TestCase
{
    use RefreshDatabase;

    public function test_feedback_can_be_restore_by_staff()
    {
        $user = User::factory()->staff()->create();
        $this->actingAs($user);

        $feedback = Feedback::factory()->create([
            'user_id' => $user->id,
            'deleted_at' => now(),
        ]);

        $response = $this->put('/feedbacks/' . $feedback->id . '/restore');
        $response->assertRedirect(route('feedbacks.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('feedbacks', [
            'id' => $feedback->id,
            'deleted_at' => null
        ]);
    }

    public function test_feedback_cannot_be_restore_by_user()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $feedback = Feedback::factory()->create([
            'user_id' => $user->id,
            'deleted_at' => now(),
        ]);

        $response = $this->put('/feedbacks/' . $feedback->id . '/restore');
        $response->assertStatus(403);
        $this->assertDatabaseHas('feedbacks', [
           'id' => $feedback->id,
           'deleted_at' => $feedback->deleted_at
        ]);
    }
}
