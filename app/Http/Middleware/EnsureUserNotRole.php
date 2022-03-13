<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserNotRole
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
        if(! auth()->user()){
            $response = [
                'message' => 'Please do login first'
            ];
            return response()->json($response, Response::HTTP_FORBIDDEN);
        }

        $user = auth()->user();

        if( $user->type != 0 ){
            $response = [
                'message' => 'You are not an admin'
            ];
            return response()->json($response, Response::HTTP_FORBIDDEN);
        }

        return $next($request);
    }
}
