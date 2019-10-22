<?php

namespace Tests\Unit;

use App\Post;
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
    public function it_may_has_many_posts()
    {
        $john = $this->signIn();

        Storage::fake('public');

        $post = factory(Post::class)->create();

        $this->assertInstanceOf(Collection::class, $john->posts);
    }
}
