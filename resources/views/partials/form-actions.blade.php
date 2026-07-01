<div class="mt-6 flex flex-wrap items-center justify-end gap-3">
    @if (!empty($cancelUrl))
        <a href="{{ $cancelUrl }}"
           class="rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50">
            Cancelar
        </a>
    @endif

    <button type="submit"
            class="rounded-lg bg-slate-900 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-slate-800">
        {{ $submitLabel ?? 'Guardar' }}
    </button>
</div>
