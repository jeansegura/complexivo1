<div class="inline-flex flex-wrap items-center justify-end gap-1">
    @if (!empty($showUrl))
        <a href="{{ $showUrl }}"
           class="rounded-md px-2.5 py-1.5 text-xs font-medium text-slate-700 hover:bg-slate-100">
            Ver
        </a>
    @endif

    @if (!empty($editUrl))
        <a href="{{ $editUrl }}"
           class="rounded-md px-2.5 py-1.5 text-xs font-medium text-slate-700 hover:bg-slate-100">
            Editar
        </a>
    @endif

    @if (!empty($destroyUrl))
        <form action="{{ $destroyUrl }}" method="POST" class="inline"
              onsubmit="return confirm('{{ $confirmMessage ?? 'Eliminar este registro?' }}')">
            @csrf
            @method('DELETE')
            <button type="submit"
                    class="rounded-md px-2.5 py-1.5 text-xs font-medium text-red-600 hover:bg-red-50">
                Eliminar
            </button>
        </form>
    @endif
</div>
