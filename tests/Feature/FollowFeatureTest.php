<?php

namespace Tests\Feature;

use App\Laragram\Following\FollowingStatusManager;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FollowFeatureTest extends TestCase
{
    use RefreshDatabase;

    /** @test **/
    public function a_member_can_follow_another_user()
    {
        $this->withoutExceptionHandling();

        $john = $this->signIn();
        $david = factory(User::class)->create(['name' => 'david']);

        $this->post('/followings/' . $david->id);

        $this->assertDatabaseHas('followings', [
            'following' => $david->id,
            'follower' => $john->id
        ]);
    }

    /** @test **/
    public function after_sending_a_follow_request_the_request_should_get_accepted_to_establish()
    {
        $this->withoutExceptionHandling();

        $john = $this->signIn();
        $david = factory(User::class)->create(['name' => 'david']);

        $this->post('/followings/' . $david->id);

        $this->assertDatabaseHas('followings', [
            'follower' => auth()->id(),
            'following' => $david->id,
            'status' => FollowingStatusManager::STATUS_SUSPENDED
        ]);
    }

    /** @test **/
    public function after_sending_a_follow_request_the_follower_may_decline_the_request()
    {
        $this->withoutExceptionHandling();

        $john = factory(User::class)->create(['name' => 'john']);
        $david = $this->signIn();

        $john->follow($david);

        $this->assertTrue($john->hasRequestedFollowing($david));

        $this->post('/followers/' . $john->id . '/decline');

        $this->assertFalse($john->hasRequestedFollowing($david));

    }

    /** @test **/
    public function a_user_can_accept_another_user_following_request()
    {
        $this->withoutExceptionHandling();

        $john = $this->signIn();
        $david = factory(User::class)->create();

        $david->follow($john);

        $this->post('/followers/' . $david->id . '/accept');

        $this->assertDatabaseHas('followings', [
            'follower' => $david->id,
            'following' => $john->id,
            'status' => FollowingStatusManager::STATUS_ACCEPTED
        ]);
    }

    /** @test **/
    public function a_user_can_cancel_his_follow_request()
    {
        $this->withoutExceptionHandling();

        $john = $this->signIn();
        $david = factory(User::class)->create();

        $john->follow($david);

        $this->post('/followings/' . $david->id . '/cancel');

        $this->assertDatabaseMissing('followings', [
            'follower' => $david->id,
            'following' => $john->id,
            'status' => FollowingStatusManager::STATUS_SUSPENDED
        ]);
    }

    /** @test **/
    public function a_users_can_not_follow_themselves()
    {
        $john = $this->signIn();

        $this->post('/followings/' . $john->id)->assertRedirect($john->path());
    }
}
