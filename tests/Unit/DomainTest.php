<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class DomainTest extends TestCase
{
    use DatabaseMigrations;

    public function test_domain_has_owner()
    {
        $domain = factory('App\Domain')->create();

        $this->assertInstanceOf('App\User', $domain->user);
    }
}
