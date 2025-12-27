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
        // STRICT: Only run in 'local' environment - NEVER in production
        // This middleware MUST NOT run in production, staging, or any non-local environment
        if (!app()->environment('local')) {
            // In non-local environments, this middleware does nothing
            return $next($request);
        }

        // EXTRA SAFETY: Host-based check - refuse to run on production-like hosts
        // This provides an additional layer of protection even if APP_ENV is misconfigured
        $host = $request->getHost();
        $isLocalHost = in_array($host, ['localhost', '127.0.0.1', '::1']) 
            || str_contains($host, '.local')
            || str_contains($host, '.test')
            || str_contains($host, '.dev');
        
        // If host looks like production (contains .com, .net, .org, or AWS-like domains), refuse
        $isProductionHost = str_contains($host, '.com') 
            || str_contains($host, '.net') 
            || str_contains($host, '.org')
            || str_contains($host, '.io')
            || str_contains($host, 'amazonaws.com')
            || str_contains($host, 'elasticbeanstalk.com')
            || str_contains($host, 'cloudfront.net');
        
        if ($isProductionHost && !$isLocalHost) {
            // Refuse to run on production-like hosts even if APP_ENV=local
            // This prevents accidental execution if environment is misconfigured
            return $next($request);
        }

        // Only proceed if explicitly in 'local' environment AND on local-like host
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
                    'password' => bcrypt(env('DEV_PASSWORD', 'password')),
                    'email_verified_at' => now(),
                    'game_id' => 1, // Default game
                    'wallet_balance' => '1000', // Default wallet balance
                ]);
                Auth::login($user);
            }
        }

        return $next($request);
    }
}
