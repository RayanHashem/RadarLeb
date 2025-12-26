<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class DevAutoAuth
{
    /**
     * Handle an incoming request.
     * Automatically authenticates a user in development mode.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Only run in development/local environment
        if (app()->environment('local', 'development') || config('app.debug')) {
            // If user is not authenticated, auto-login the first user
            if (!Auth::check()) {
                $user = User::first();
                
                if ($user) {
                    Auth::login($user);
                } else {
                    // If no user exists, create a dev user
                    $user = User::create([
                        'name' => 'Dev User',
                        'email' => 'dev@example.com',
                        'phone_number' => '1234567890',
                        'password' => bcrypt('password'),
                        'email_verified_at' => now(),
                        'game_id' => 1, // Default game
                        'wallet_balance' => '1000', // Default wallet balance
                    ]);
                    Auth::login($user);
                }
            }
        }

        return $next($request);
    }
}
