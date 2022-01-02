<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ProfileOwner
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        //Only the owner of post can access post resource
        $owner = auth()->user()->id;

        if($owner == $request->route("id")) return $next($request);
        else return back();
    }
}
