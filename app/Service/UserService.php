<?php


namespace App\Service;


use App\Domain;
use App\User;
use Illuminate\Http\Request;

class UserService
{
//    protected $request;
//
//    public function __construct(Request $request)
//    {
//        $this->request = $request;
//    }

    public function create(array $data): User
    {
        $domain = Domain::where('name', request()->getHost())->first();
        $parent_id = $domain ? $domain->user->id : config('APP_ROOT_USER', 1);

        $user = new User();
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->password = $data['password'];
        $user->parent_id = $parent_id;
        $user->save();

        return $user;
    }
}
