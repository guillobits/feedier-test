<?php

namespace Tests\Feature;

use App\Models\Feedback;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateFeedbackTest extends TestCase
{
    use RefreshDatabase;

    public function test_feedback_form_can_be_rendered(): void
    {
        $response = $this->get('/feedbacks/create');
        $response->assertStatus(200);
    }

    public function test_feedback_form_can_be_rendered_by_user(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get('/feedbacks/create');
        $response->assertStatus(200);
    }

    public function test_store_feedback_success()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->post('/feedbacks', [
            'content' => 'Test feedback content'
        ]);

        $response->assertRedirect(route('feedbacks.create'));
        $this->assertDatabaseHas('feedbacks', [
            'content' => 'Test feedback content',
            'user_id' => $user->id,
            'email' => $user->email,
        ]);
    }

    public function test_store_feedback_already_created_within_hour()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        // Create a first feedback -30 minutes
        Feedback::factory()->create([
            'email' => $user->email,
            'created_at' => Carbon::now()->subMinutes(30),
        ]);

        $response = $this->post('/feedbacks', [
            'content' => 'Test feedback content'
        ]);

        $response->assertRedirect();
        // Only one feedback should be created
        $this->assertDatabaseCount('feedbacks', 1);
    }
}
