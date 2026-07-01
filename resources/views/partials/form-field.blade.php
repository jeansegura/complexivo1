@php
    $inputClass = 'w-full rounded-lg border border-slate-300 bg-white px-3.5 py-2.5 text-sm text-slate-900 shadow-sm placeholder:text-slate-400 focus:border-slate-500 focus:outline-none focus:ring-2 focus:ring-slate-200';
@endphp

<div class="mb-5">
    <label for="{{ $name }}" class="mb-1.5 block text-sm font-semibold text-slate-700">
        {{ $label }}
        @if (!empty($required))<span class="text-red-500">*</span>@endif
    </label>

    @if (($type ?? 'text') === 'textarea')
        <textarea id="{{ $name }}" name="{{ $name }}" rows="4"
                  class="{{ $inputClass }}"
                  @if (!empty($required)) required @endif>{{ $value ?? '' }}</textarea>
    @else
        <input type="{{ $type ?? 'text' }}" id="{{ $name }}" name="{{ $name }}"
               value="{{ $value ?? '' }}"
               class="{{ $inputClass }}"
               @if (!empty($required)) required @endif
               @if (!empty($step)) step="{{ $step }}" @endif
               @if (!empty($min)) min="{{ $min }}" @endif>
    @endif

    @error($name)
        <p class="mt-1.5 text-sm font-medium text-red-600">{{ $message }}</p>
    @enderror
</div>
