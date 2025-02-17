<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class ApiAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->header('Authorization');
        $authenticated = true;

        if (!$token) {
            $authenticated = false;
        }
        $token = substr($token, 7);
        // dd($token);
        $user = User::where('token', $token)->first();


        // $user = User::where('token', "c646e76c-5424-4cf6-bb7a-8e6ad9a02abf")->first();

        // dd($user);
        if (!$user) {
            $authenticated = false;
        }


        Auth::login($user);

        if ($authenticated) {
            return $next($request);
        } else {
            return response()->json([
                'errors' => [
                    "message" => [
                        'Unauthorize'
                    ],
                ]
            ])->setStatusCode(401);
        }
    }
}
