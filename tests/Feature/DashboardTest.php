<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    /** @test **/
    public function a_authenticated_user_can_have_a_panel()
    {
        $this->withoutExceptionHandling();

        $john = $this->signIn();

        $this->get($john->path())->assertSee($john->name);
    }
}
