<?php

namespace Tests\Unit;

use App\Models\User;
use App\Policies\FeedbackPolicy;
use Tests\TestCase;

class FeedbackPolicyTest extends TestCase
{
    public function test_user_with_staff_role_can_view_feedbacks()
    {
        $user = User::factory()->staff()->create();
        $policy = new FeedbackPolicy();

        $this->assertTrue(
            $policy->viewAny($user),
        );
    }

    public function test_user_without_staff_role_cannot_view_feedbacks()
    {
        $user = User::factory()->create();
        $policy = new FeedbackPolicy();

        $this->assertFalse(
            $policy->viewAny($user),
        );
    }

    public function test_user_can_create_feedback()
    {
        $user = User::factory()->create();
        $policy = new FeedbackPolicy();

        $this->assertTrue(
            $policy->create($user),
        );
    }

    public function test_user_with_staff_role_can_delete_feedback()
    {
        $user = User::factory()->staff()->create();
        $policy = new FeedbackPolicy();

        $this->assertTrue(
            $policy->delete($user),
        );
    }

    public function test_user_without_staff_role_cannot_delete_feedback()
    {
        $user = User::factory()->create();
        $policy = new FeedbackPolicy();

        $this->assertFalse(
            $policy->delete($user),
        );
    }

    public function test_user_with_staff_role_can_restore_feedback()
    {
        $user = User::factory()->staff()->create();
        $policy = new FeedbackPolicy();

        $this->assertTrue(
            $policy->restore($user),
        );
    }

    public function test_user_without_staff_role_cannot_restore_feedback()
    {
        $user = User::factory()->create();
        $policy = new FeedbackPolicy();

        $this->assertFalse(
            $policy->restore($user),
        );
    }
}
