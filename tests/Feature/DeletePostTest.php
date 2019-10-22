<?php

namespace Tests\Feature;

use App\Post;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DeletePostTest extends TestCase
{
    use RefreshDatabase;

    /** @test **/
    public function guest_can_not_delete_a_post()
    {
        $post = factory(Post::class)->create();

        $this->delete('/posts/' . $post->id)->assertRedirect('/login');
    }

    /** @test **/
    public function a_user_authenticated_can_delete_his_own_post()
    {
        $this->withoutExceptionHandling();

        $this->signIn();

        $post = factory(Post::class)->create(['owner_id' => auth()->id()]);

        $this->delete('/posts/' . $post->id)->assertRedirect('/posts');

        $this->assertDatabaseMissing('posts', ['path' => $post->path]);
    }

    /** @test **/
    public function a_user_can_not_delete_other_user_post()
    {
        $john = $this->signIn();
        $david = factory(User::class)->create(['name' => 'david']);

        $post = factory(Post::class)->create(['owner_id' => $david->id]);

        $this->delete('/posts/' . $post->id)->assertStatus(403);
    }
}
