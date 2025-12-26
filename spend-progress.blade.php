@php
    $s = $getState() ?? [];
    $spent   = (float) ($s['spent'] ?? 0);
    $min     = (float) ($s['min'] ?? 0);
    $percent = (int)    ($s['percent'] ?? 0);
@endphp

<div class="w-56">
    {{-- Only "50/100" (no currency, no extra text) --}}
    <div class="text-xs text-gray-700 dark:text-gray-200 mb-1">
        {{ number_format($spent, 0) }}/{{ number_format($min, 0) }}
    </div>

    <div class="w-full h-2 rounded bg-gray-200 dark:bg-gray-700 overflow-hidden">
        <div
            class="h-2 bg-primary-500 dark:bg-primary-400"
            style="width: {{ $percent }}%;"
            role="progressbar"
            aria-valuenow="{{ $percent }}" aria-valuemin="0" aria-valuemax="100"
        ></div>
    </div>
</div>
