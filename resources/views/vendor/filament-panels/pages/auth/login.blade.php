<x-filament-panels::page.simple>
    @if (filament()->hasRegistration())
        <x-slot name="subheading">
            {{ __('filament-panels::pages/auth/login.actions.register.before') }}

            {{ $this->registerAction }}
        </x-slot>
    @endif

    {{ \Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::AUTH_LOGIN_FORM_BEFORE, scopes: $this->getRenderHookScopes()) }}

    <x-filament-panels::form id="form" wire:submit="authenticate">
        {{ $this->form }}

        <x-filament-panels::form.actions
            :actions="$this->getCachedFormActions()"
            :full-width="$this->hasFullWidthFormActions()"
        />
    </x-filament-panels::form>

    {{ \Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::AUTH_LOGIN_FORM_AFTER, scopes: $this->getRenderHookScopes()) }}
</x-filament-panels::page.simple>

@push('styles')
<style>
    /* RadarLeb Admin Login - Scoped to Filament only */
    /* Background gradient matching RadarLeb brand */
    .fi-simple-layout {
        background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f172a 100%);
        background-attachment: fixed;
        min-height: 100vh;
        padding: 1rem;
    }

    /* Login card styling - modern, centered */
    .fi-simple-main {
        background: rgba(30, 41, 59, 0.95) !important;
        backdrop-filter: blur(10px);
        border-radius: 16px !important;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.4), 0 0 0 1px rgba(107, 186, 206, 0.1) !important;
        border: 1px solid rgba(107, 186, 206, 0.2) !important;
        padding: 2.5rem 2rem !important;
        max-width: 28rem !important;
        margin: 0 auto !important;
    }

    /* Light mode support */
    html:not(.dark) .fi-simple-layout {
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 50%, #cbd5e1 100%);
    }

    html:not(.dark) .fi-simple-main {
        background: rgba(255, 255, 255, 0.95) !important;
        border: 1px solid rgba(102, 175, 219, 0.2) !important;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1), 0 0 0 1px rgba(102, 175, 219, 0.1) !important;
    }

    /* Ensure icons maintain proper size - scoped to Filament components only */
    .fi-simple-main .fi-icon,
    .fi-simple-main svg.fi-icon {
        width: 1.25rem !important;
        height: 1.25rem !important;
        flex-shrink: 0;
    }

    /* Form inputs - maintain Filament styling */
    .fi-simple-main .fi-input-wrp {
        margin-bottom: 1rem;
    }

    /* Rate limit notifications - ensure readability */
    .fi-simple-main .fi-notification {
        background: rgba(234, 51, 35, 0.1) !important;
        border: 1px solid rgba(234, 51, 35, 0.3) !important;
        color: rgb(254, 202, 202) !important;
    }

    html:not(.dark) .fi-simple-main .fi-notification {
        background: rgba(234, 51, 35, 0.1) !important;
        border: 1px solid rgba(234, 51, 35, 0.3) !important;
        color: rgb(153, 27, 27) !important;
    }

    /* Heading styling */
    .fi-simple-main h1,
    .fi-simple-main h2 {
        color: rgb(219, 234, 254) !important;
        font-weight: 600;
        letter-spacing: -0.02em;
    }

    html:not(.dark) .fi-simple-main h1,
    html:not(.dark) .fi-simple-main h2 {
        color: rgb(30, 58, 138) !important;
    }

    /* Brand logo area */
    .fi-simple-main .fi-logo {
        margin-bottom: 1.5rem;
    }
</style>
@endpush

