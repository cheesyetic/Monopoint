<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasRole
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

        if( $user->type == 2){
            $response = [
                'message' => 'You have to be a financial staff or an admin to access this resources'
            ];
            return response()->json($response, Response::HTTP_UNAUTHORIZED);
        }

        return $next($request);
    }
}
