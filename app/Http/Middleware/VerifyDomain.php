<?php

namespace App\Http\Middleware;

use App\Domain;
use Closure;
use Illuminate\Http\Request;

class VerifyDomain
{
    protected $domain;

    public function __construct(Request $request)
    {
        $this->domain = Domain::where('name', '=', $request->getHost())
            ->where('secure', $request->isSecure())
            ->first();
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (! isset($this->domain) ){
            abort(404);
        }

        if (auth()->check() and ! $this->domain->isAllowedUser(auth()->user())) {
                abort(404);
        }

        return $next($request);
    }
}
