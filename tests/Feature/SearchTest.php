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

        config(['scout.driver' => 'algolia']);

        $this->signIn();

        $search= 'foobar';
        create(User::class, ['name' => 'Test', 'email' => 'test@gmail.com', 'username' => 'testuser']);
        create(User::class, ['name' => 'Mr. foobar']);
        create(User::class, ['email' => 'foobar@gmail.com']);
        factory(User::class)->state('username')->create(['username' => 'foobar_24']);

        do {
            sleep(.25);

            $result = $this->getJson("/users/search?q=$search")->json()['data'];
        } while (count($result) !== 3);

        $this->assertCount(3, $result);

        User::latest()->take(3)->unsearchable();
    }
}
