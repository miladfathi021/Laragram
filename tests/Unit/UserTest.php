<?php

namespace Tests\Unit;

use App\Laragram\Following\FollowingStatusManager;
use App\Post;
use App\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test **/
    public function it_know_their_path()
    {
        $user = create(User::class);

        $this->assertEquals('/users/' . $user->id, $user->path());
    }

    /** @test **/
    public function it_may_has_many_posts()
    {
        $john = $this->signIn();

        Storage::fake('public');

        $post = factory(Post::class)->create();

        $this->assertInstanceOf(Collection::class, $john->posts);
    }

    /** @test **/
    public function it_may_has_many_followings()
    {
        $this->withoutExceptionHandling();

        $john = $this->signIn();
        $david = factory(User::class)->create(['name' => 'david']);

        $john->follow($david);

        $this->assertInstanceOf(Collection::class, $john->followings);
        $this->assertTrue($david->hasRequestedFollower($john));
    }

    /** @test **/
    public function it_may_has_many_followers()
    {
        $this->withoutExceptionHandling();

        $john = $this->signIn();
        $david = factory(User::class)->create(['name' => 'david']);

        $john->follow($david);

        $this->assertInstanceOf(Collection::class, $david->followers);
        $this->assertTrue($john->hasRequestedFollowing($david));
    }

    /** @test **/
    public function it_can_follow_other_user()
    {
        $this->withoutExceptionHandling();
        $john = $this->signIn();
        $david = factory(User::class)->create(['name' => 'david']);

        $john->follow($david);

        $this->assertTrue($john->followings->contains($david));
    }

    /** @test **/
    public function it_can_if_is_following_someone_else()
    {
        $this->withoutExceptionHandling();

        $john = $this->signIn();
        $david = factory(User::class)->create(['name' => 'david']);

        $john->follow($david);

        $this->assertTrue($john->hasRequestedFollowing($david));
    }

    /** @test **/
    public function it_can_decline_a_following_request()
    {
        $this->withoutExceptionHandling();

        $john = factory(User::class)->create();
        $david = $this->signIn();

        $john->follow($david);

        $david->decline($john);

        $this->assertDatabaseHas('followings', [
            'follower' => $john->id,
            'following' => $david->id,
            'status' => FollowingStatusManager::STATUS_DECLINED
        ]);
    }

    /** @test **/
    public function it_can_check_if_a_user_has_declined()
    {
        $john = factory(User::class)->create(['name' => 'john']);
        $david = $this->signIn();

        $john->follow($david);

        $david->decline($john);

        $this->assertTrue($david->hasDeclined($john));
    }

    /** @test **/
    public function it_can_accept_a_request_from_another_user()
    {
        $john = $this->signIn();
        $david = factory(User::class)->create();

        $david->follow($john);

        $john->accept($david);

        $this->assertDatabaseHas('followings', [
            'follower' => $david->id,
            'following' => $john->id,
            'status' => FollowingStatusManager::STATUS_ACCEPTED
        ]);

        $this->assertTrue($david->isFollowing($john));
    }

    /** @test **/
    public function it_can_check_if_a_user_is_following_them()
    {
        $john = $this->signIn();
        $david = factory(User::class)->create();

        $david->follow($john);

        $john->accept($david);

        $this->assertTrue($david->isFollowing($john));
    }
}
