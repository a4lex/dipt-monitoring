<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use App\Service\UserService;


class UserTest extends TestCase
{

    use DatabaseMigrations;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_a_user_can_be_created()
    {
        $userService = new UserService;

        $userData = factory('App\User')->make()->toArray();
        $userData['password'] = 'test_password';

        $this->assertInstanceOf('App\User', $userService->create($userData));
    }
}
