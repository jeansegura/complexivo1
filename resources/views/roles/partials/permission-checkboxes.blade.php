<div class="mb-5">
    <p class="mb-2 block text-sm font-semibold text-slate-700">Permisos</p>

    @if ($permissions->isEmpty())
        <div class="rounded-lg border border-dashed border-slate-300 bg-slate-50 p-4 text-sm text-slate-600">
            Aun no hay permisos registrados. El rol puede guardarse sin permisos y asociarlos despues.
        </div>
    @else
        <div class="space-y-4 rounded-lg border border-slate-200 bg-slate-50 p-4">
            @foreach ($permissions as $module => $items)
                <div>
                    <p class="mb-2 text-xs font-semibold uppercase tracking-wide text-slate-500">{{ $module }}</p>
                    <div class="grid gap-2 sm:grid-cols-2">
                        @foreach ($items as $permission)
                            <label class="flex items-start gap-2 rounded-md bg-white p-3 text-sm text-slate-700 shadow-sm">
                                <input type="checkbox" name="permissions[]" value="{{ $permission->id }}"
                                       class="mt-1 rounded border-slate-300 text-slate-900 focus:ring-slate-500"
                                       @checked(in_array($permission->id, $selected ?? [], true))>
                                <span>
                                    <span class="block font-semibold text-slate-900">{{ $permission->action }}</span>
                                    <span class="block text-xs text-slate-500">{{ $permission->slug }}</span>
                                </span>
                            </label>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    @error('permissions')
        <p class="mt-1.5 text-sm font-medium text-red-600">{{ $message }}</p>
    @enderror
</div>
