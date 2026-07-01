<div class="mb-5">
    <label for="status" class="mb-1.5 block text-sm font-semibold text-slate-700">
        Estado
    </label>

    <select id="status" name="status"
            class="w-full rounded-lg border border-slate-300 bg-white px-3.5 py-2.5 text-sm text-slate-900 shadow-sm focus:border-slate-500 focus:outline-none focus:ring-2 focus:ring-slate-200">
        @foreach ($statuses as $value => $label)
            <option value="{{ $value }}" @selected($selected === $value)>{{ $label }}</option>
        @endforeach
    </select>

    @error('status')
        <p class="mt-1.5 text-sm font-medium text-red-600">{{ $message }}</p>
    @enderror
</div>
