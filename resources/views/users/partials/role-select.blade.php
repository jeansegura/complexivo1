<div class="mb-5">
    <label for="role" class="mb-1.5 block text-sm font-semibold text-slate-700">
        Rol <span class="text-red-500">*</span>
    </label>
    <select id="role" name="role" required
            class="w-full rounded-lg border border-slate-300 bg-white px-3.5 py-2.5 text-sm text-slate-900 shadow-sm focus:border-slate-500 focus:outline-none focus:ring-2 focus:ring-slate-200">
        @foreach ($roles as $value => $label)
            <option value="{{ $value }}" @selected(($selected ?? null) === $value)>
                {{ $label }}
            </option>
        @endforeach
    </select>
    @error('role')
        <p class="mt-1.5 text-sm font-medium text-red-600">{{ $message }}</p>
    @enderror
</div>
