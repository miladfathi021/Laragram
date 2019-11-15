<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AvatarTest extends TestCase
{
    use RefreshDatabase;

    /** @test **/
    public function a_user_can_upload_an_avatar()
    {
        $this->withoutExceptionHandling();

        Storage::fake('public');
        $avatar = UploadedFile::fake()->image('avatar.jpg');

        $john = $this->signIn();

        $this->postJson($john->path() . '/avatars', [
            'avatar' => $avatar
        ])->assertJson(['status' => 201, 'user' => ['avatar' => 'avatars/' . $avatar->hashName()]]);

        $this->assertCount(1, Storage::disk('public')->files('avatars'));

        $this->assertDatabaseHas('users', [
            'avatar' => 'avatars/' . $avatar->hashName()
        ]);

        $this->get($john->path())->assertSee('avatars/' . $avatar->hashName());
    }

    /** @test **/
    public function an_avatar_should_be_a_valid_image()
    {
        $john = $this->signIn();

        Storage::fake('public');

        $file = UploadedFile::fake()->create('document.pdf');

        $this->postJson($john->path() . '/avatars', [
            'avatar' => $file
        ])->assertJsonValidationErrors(['avatar']);
    }

    /** @test **/
    public function avatar_is_required()
    {
        $john = $this->signIn();

        $this->postJson($john->path() . '/avatars', [
            'avatar' => null,
        ])->assertJsonValidationErrors(['avatar']);
    }
}
