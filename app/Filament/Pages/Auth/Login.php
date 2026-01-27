<?php

namespace App\Filament\Pages\Auth;

use App\Models\AdminLoginAudit;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use Filament\Facades\Filament;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\TextInput;
use Filament\Http\Responses\Auth\Contracts\LoginResponse;
use Filament\Models\Contracts\FilamentUser;
use Filament\Notifications\Notification;
use Filament\Pages\Auth\Login as BaseLogin;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class Login extends BaseLogin
{
    /**
     * Override the view to use our custom login view.
     */
    protected static string $view = 'filament-panels::pages.auth.login';

    /**
     * Get the maximum width of the login card.
     */
    public function getMaxWidth(): string
    {
        return 'md';
    }
    /**
     * Authenticate the user with rate limiting.
     * 
     * Rate limit: 5 attempts per minute per IP + per email address.
     * This prevents shared-IP lockouts while still protecting against brute force.
     * 
     * This method is called on POST requests to /admin/login
     */
    public function authenticate(): ?LoginResponse
    {
        // Get form data early to extract email for rate limiting
        $data = $this->form->getState();
        $email = $data['email'] ?? null;
        $ipAddress = request()->ip();
        $userAgent = request()->userAgent();

        // Rate limit: 5 attempts per 60 seconds (1 minute) per IP + per email
        // This triggers reliably on every POST request to /admin/login
        try {
            $this->rateLimitWithEmail(5, 60, $email);
        } catch (TooManyRequestsException $exception) {
            // Log rate limit failure
            $this->logLoginAttempt($email, null, $ipAddress, $userAgent, false, 'Rate limit exceeded');
            $this->getRateLimitedNotification($exception)?->send();

            return null;
        }

        // Attempt authentication (reusing parent logic but without its rate limiting)
        $credentials = $this->getCredentialsFromFormData($data);
        $authenticated = Filament::auth()->attempt($credentials, $data['remember'] ?? false);

        if (! $authenticated) {
            // Log failed authentication attempt
            $this->logLoginAttempt($email, null, $ipAddress, $userAgent, false, 'Invalid credentials');
            $this->throwFailureValidationException();
        }

        // Get authenticated user
        $user = Filament::auth()->user();

        // Strict admin check: Non-admin users are fully blocked
        if (
            ($user instanceof FilamentUser) &&
            (! $user->canAccessPanel(Filament::getCurrentPanel()))
        ) {
            // Log failed access due to insufficient permissions
            $this->logLoginAttempt($email, $user->id, $ipAddress, $userAgent, false, 'User does not have admin access');
            Filament::auth()->logout();

            $this->throwFailureValidationException();
        }

        // Regenerate session for security
        session()->regenerate();

        // Log successful login
        $this->logLoginAttempt($email, $user->id, $ipAddress, $userAgent, true, null);

        return app(LoginResponse::class);
    }

    /**
     * Log a login attempt to the audit table.
     * 
     * @param string|null $emailEntered The email address entered (never store password)
     * @param int|null $userId The authenticated user ID (null for failed attempts)
     * @param string $ipAddress The IP address of the request
     * @param string|null $userAgent The user agent string
     * @param bool $success Whether the login was successful
     * @param string|null $failureReason Reason for failure (null if successful)
     */
    protected function logLoginAttempt(
        ?string $emailEntered,
        ?int $userId,
        string $ipAddress,
        ?string $userAgent,
        bool $success,
        ?string $failureReason
    ): void {
        AdminLoginAudit::create([
            'email_entered' => $emailEntered ?? 'unknown',
            'user_id' => $userId,
            'ip_address' => $ipAddress,
            'user_agent' => $userAgent,
            'success' => $success,
            'failure_reason' => $failureReason,
            'logged_in_at' => $success ? now() : null,
        ]);
    }

    /**
     * Rate limit with both IP and email to avoid shared-IP lockouts.
     * 
     * @param int $maxAttempts Maximum number of attempts
     * @param int $decaySeconds Time window in seconds
     * @param string|null $email Email address from login form
     * @throws TooManyRequestsException
     */
    protected function rateLimitWithEmail(int $maxAttempts, int $decaySeconds, ?string $email): void
    {
        $ip = request()->ip();
        $emailKey = $email ? Str::lower(Str::transliterate($email)) : 'unknown';
        
        // Create rate limit key: IP + email combination
        $key = 'filament-admin-login:' . sha1($ip . '|' . $emailKey);
        
        // Check if rate limit exceeded
        if (RateLimiter::tooManyAttempts($key, $maxAttempts)) {
            $secondsUntilAvailable = RateLimiter::availableIn($key);
            
            throw new TooManyRequestsException(
                static::class,
                'authenticate',
                $ip,
                $secondsUntilAvailable
            );
        }
        
        // Hit the rate limiter
        RateLimiter::hit($key, $decaySeconds);
    }

    /**
     * Get the page title.
     */
    public function getTitle(): string | Htmlable
    {
        return 'Welcome Back';
    }

    /**
     * Get the page heading.
     */
    public function getHeading(): string | Htmlable
    {
        return 'Sign in to your account';
    }

    /**
     * Get the email form component with icon.
     */
    protected function getEmailFormComponent(): Component
    {
        return TextInput::make('email')
            ->label('Email address')
            ->email()
            ->required()
            ->autocomplete('email')
            ->autofocus()
            ->prefixIcon('heroicon-o-envelope')
            ->placeholder('Enter your email')
            ->extraInputAttributes(['tabindex' => 1]);
    }

    /**
     * Get the password form component with icon.
     * Only shows "Forgot password?" link if password reset is enabled.
     */
    protected function getPasswordFormComponent(): Component
    {
        $hint = null;
        
        // Only show "Forgot password?" if password reset route exists
        if (Filament::getCurrentPanel()->hasPasswordReset()) {
            $hint = new HtmlString(Blade::render(
                '<x-filament::link :href="filament()->getRequestPasswordResetUrl()" tabindex="3" class="text-sm">
                    {{ __(\'filament-panels::pages/auth/login.actions.request_password_reset.label\') }}
                </x-filament::link>'
            ));
        }

        return TextInput::make('password')
            ->label('Password')
            ->password()
            ->revealable(Filament::getCurrentPanel()->arePasswordsRevealable())
            ->autocomplete('current-password')
            ->required()
            ->prefixIcon('heroicon-o-lock-closed')
            ->placeholder('Enter your password')
            ->hint($hint)
            ->extraInputAttributes(['tabindex' => 2]);
    }

    /**
     * Get the remember me checkbox component.
     */
    protected function getRememberFormComponent(): Component
    {
        return Checkbox::make('remember')
            ->label('Remember me')
            ->default(false);
    }

    /**
     * Get the rate limited notification with improved messaging.
     */
    protected function getRateLimitedNotification(TooManyRequestsException $exception): ?Notification
    {
        $minutes = ceil($exception->secondsUntilAvailable / 60);
        $seconds = $exception->secondsUntilAvailable;
        
        return Notification::make()
            ->title('Too many login attempts')
            ->body("Please wait {$seconds} seconds ({$minutes} " . ($minutes === 1 ? 'minute' : 'minutes') . ") before trying again.")
            ->danger()
            ->persistent();
    }
}

