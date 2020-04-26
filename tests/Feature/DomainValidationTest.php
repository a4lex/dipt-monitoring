<?php

namespace Tests\Feature;

use App\Domain;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class DomainValidationTest extends TestCase
{
    use DatabaseMigrations;

    public function test_domain_owner_and_childs_not_allowed_open_other_domain()
    {
        $this->withExceptionHandling();

        $alien_domain = factory('App\Domain')->create();

        $owner = factory('App\User')->create(['parent_id' => 2]);
        $child = factory('App\User')->create(['parent_id' => $owner->id]);

        $this->singIn($owner)->get($alien_domain->getUrl())
            ->assertStatus(404);

        $this->singIn($child)->get($alien_domain->getUrl())
            ->assertStatus(404);
    }

    public function test_domain_owner_and_childs_allowed_open_his_domain()
    {
        $this->withExceptionHandling();

        $own_domain = factory('App\Domain')->create();
        $owner = $own_domain->user;
        $child = factory('App\User')->create(['parent_id' => $owner->id]);

        $this->singIn($owner)
            ->get($own_domain->getUrl())
            ->assertStatus(200);

        $this->singIn($child)->get($own_domain->getUrl())
            ->assertStatus(200);
    }

    public function test_guest_allowed_open_any_domain()
    {
        $this->withExceptionHandling();

        $domain1 = factory('App\Domain')->create();
        $domain2 = factory('App\Domain')->create();

        $this->get($domain1->getUrl() . '/login')->assertStatus(200);
        $this->get($domain2->getUrl(). '/login')->assertStatus(200);
    }

    public function test_non_exist_domain_abort()
    {
        $this->withExceptionHandling()
            ->get('http://4lex.nonexist.domain.com/login')
            ->assertStatus(404);
    }
}
