<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SearchTest extends TestCase
{
    use RefreshDatabase;

    /** @test **/
    public function a_user_can_search_for_other_users_by_their_username_name_or_email()
    {
        $this->withoutExceptionHandling();

        $this->signIn();

        $search= 'john';
        create(User::class, ['name' => 'Test', 'email' => 'test@gmail.com', 'username' => 'testuser']);
        create(User::class, ['name' => 'Mr. john']);
        create(User::class, ['email' => 'johndoe@gmail.com']);
        factory(User::class)->state('username')->create(['username' => 'retryJohn']);

        $result = $this->getJson("/users/search?q=$search")->json();

        $this->assertCount(3, $result);
    }
}
