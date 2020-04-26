<?php

namespace App\Policies;

use App\Represent\Represent;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class RepresentPolicy
{
    use HandlesAuthorization;
//
//    public function view(User $user, $represent)
//    {
//        return $represent->actions['view'];
//    }
//
//    public function create(User $user, $represent)
//    {
//        return $represent->actions['create'];
//    }
//
//    public function edit(User $user, $represent)
//    {
//        return $represent->actions['edit'];
//    }
//
//    public function delete(User $user, $represent)
//    {
//        return $represent->actions['delete'];
//    }
//
//
//    public function store(User $user, $represent)
//    {
//        return $this->create($user, $represent);
//    }
//
//    public function update(User $user, $represent)
//    {
//        return true;
//    }
//
//    public function destroy(User $user, Represent $represent)
//    {
//        return true;
//    }
}
