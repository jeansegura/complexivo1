<div class="mb-8">
    @if (!empty($backUrl))
        <a href="{{ $backUrl }}"
           class="mb-3 inline-flex items-center gap-1 text-sm font-medium text-slate-600 hover:text-slate-900">
            <span aria-hidden="true">&larr;</span> {{ $backLabel ?? 'Volver' }}
        </a>
    @endif

    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900">{{ $title }}</h1>
            @if (!empty($subtitle))
                <p class="mt-1 text-sm text-slate-500">{{ $subtitle }}</p>
            @endif
        </div>

        @if (!empty($actionUrl) && !empty($actionLabel))
            <a href="{{ $actionUrl }}"
               class="inline-flex shrink-0 items-center justify-center gap-1 rounded-lg bg-slate-900 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-slate-800">
                <span aria-hidden="true">+</span> {{ $actionLabel }}
            </a>
        @endif
    </div>
</div>
