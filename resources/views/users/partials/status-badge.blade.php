@php
    $status = $user->status ?? \App\Models\User::STATUS_ACTIVE;
    $label = [
        \App\Models\User::STATUS_ACTIVE => 'Activo',
        \App\Models\User::STATUS_INACTIVE => 'Inactivo',
    ][$status] ?? 'Sin estado';
    $class = [
        \App\Models\User::STATUS_ACTIVE => 'bg-emerald-50 text-emerald-700 ring-emerald-600/20',
        \App\Models\User::STATUS_INACTIVE => 'bg-slate-100 text-slate-600 ring-slate-500/20',
    ][$status] ?? 'bg-slate-100 text-slate-600 ring-slate-500/20';
@endphp

<span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-semibold ring-1 ring-inset {{ $class }}">
    {{ $label }}
</span>
