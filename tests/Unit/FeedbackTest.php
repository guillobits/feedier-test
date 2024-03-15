<?php

namespace Tests\Unit;

use App\Models\Feedback;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FeedbackTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_feedback(): void
    {
        $feedback = Feedback::factory()->create([
            'content' => 'Test feedback content',
            'email' => 'test@example.com',
            'source' => 'dashboard',
        ]);
        $this->assertInstanceOf(Feedback::class, $feedback);
        $this->assertEquals('Test feedback content', $feedback->content);
        $this->assertEquals('test@example.com', $feedback->email);
        $this->assertEquals('dashboard', $feedback->source);
    }

    public function test_can_delete_feedback(): void
    {
        $feedback = Feedback::factory()->create();

        $feedback->delete();
        $this->assertNotNull($feedback->deleted_at);
    }

    public function test_can_restore_deleted_feedback(): void
    {
        $feedback = Feedback::factory()->create();

        $feedback->delete();
        $feedback->restore();
        $this->assertNull($feedback->deleted_at);
    }

    public function test_feedback_got_author(): void
    {
        $user = User::factory()->create();

        $feedback = Feedback::factory()->create([
            'user_id' => $user->id,
        ]);

        $this->assertInstanceOf(User::class, $feedback->author);
    }
}
