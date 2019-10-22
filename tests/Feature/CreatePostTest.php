<?php

namespace Tests\Feature;

use App\Post;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CreatePostTest extends TestCase
{
    use RefreshDatabase;

    /** @test **/
    public function a_user_authenticate_can_not_see_other_users_posts()
    {
        $this->withoutExceptionHandling();

        $john = $this->signIn();

        $david = factory(User::class)->create(['name' => 'David']);

        $post = factory(Post::class)->create(['owner_id' => $david->id]);

        $this->get('posts')->assertDontSee($post->path);
    }

    /** @test **/
    public function a_user_can_see_his_posts()
    {
        $this->withoutExceptionHandling();

        $john = $this->signIn();

        Storage::fake('public');

        $image = UploadedFile::fake()->image('test.jpg');

        $this->post('/posts', [
            'image' => $image
        ]);

        $this->get('/posts')->assertSee($image->hashName());
    }

    /** @test **/
    public function guest_can_not_create_new_a_post()
    {
        $this->post('/posts', [
            'image' => UploadedFile::fake()->image('test.jpg')
        ])->assertRedirect('login');
    }

    /** @test **/
    public function a_user_authenticated_can_upload_image_and_make_a_post()
    {
        $this->withoutExceptionHandling();

        $this->signIn();

        Storage::fake('public');
        $image = UploadedFile::fake()->image('test.jpg');

        $this->post('/posts', [
            'image' => $image
        ]);

        $this->assertCount(1, Storage::disk('public')->files('images'));

        $this->assertDatabaseHas('posts', [
            'path' => 'images/' . $image->hashName()
        ]);
    }

    /** @test **/
    public function an_image_is_required_for_create_a_new_post()
    {
        $this->signIn();

        $this->post('/posts', [
            'image' => null
        ])->assertSessionHasErrors();
    }

    /** @test **/
    public function an_image_should_have_a_proper_format()
    {
        $this->signIn();

        $this->post('/posts', [
            'image' => UploadedFile::fake()->create('test.pdf')
        ])->assertSessionHasErrors();
    }
}
