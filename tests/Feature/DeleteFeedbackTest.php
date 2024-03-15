<?php

namespace Tests\Feature;

use App\Models\Feedback;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeleteFeedbackTest extends TestCase
{
    use RefreshDatabase;

    public function test_feedback_can_be_delete_by_staff(): void
    {
        $user = User::factory()->staff()->create();
        $this->actingAs($user);

        $feedback = Feedback::factory()->create();

        $response = $this->delete('/feedbacks/' . $feedback->id);
        $response->assertRedirect();
        $response->assertSessionHasNoErrors();
        $response->assertSessionHas('success');
        $this->assertSoftDeleted('feedbacks', [
            'id' => $feedback->id
        ]);
    }

    public function test_feedback_cannot_be_delete_by_user(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $feedback = Feedback::factory()->create();

        $response = $this->delete('/feedbacks/' . $feedback->id);
        $response->assertStatus(403);
    }
}
