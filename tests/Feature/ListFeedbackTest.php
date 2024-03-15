<?php

namespace Tests\Feature;

use App\Models\Feedback;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ListFeedbackTest extends TestCase
{
    use RefreshDatabase;

    public function test_feedback_list_can_be_rendered_by_staff(): void
    {
        $user = User::factory()->staff()->create();
        $this->actingAs($user);

        $response = $this->get('/feedbacks');
        $response->assertStatus(200);
    }

    public function test_feedback_list_cannot_be_rendered_by_not_staff(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get('/feedbacks');
        $response->assertStatus(403);
    }
}
