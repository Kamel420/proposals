<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;


class PermissionsWare
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $perm)
    {   

        if(Auth::user()->$perm != 1)
        {
            return response([
                'Error' => 'You dont have privileges to perform this action'], Response::HTTP_BAD_REQUEST);
        }
        return $next($request);
    }
}
