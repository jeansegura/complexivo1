@php
    $roleStyles = [
        \App\Models\User::ROLE_SUPER_ADMIN => 'bg-slate-900 text-white',
        \App\Models\User::ROLE_ADMIN => 'bg-blue-100 text-blue-800',
        \App\Models\User::ROLE_PLANNER => 'bg-emerald-100 text-emerald-800',
    ];

    $roleLabels = [
        \App\Models\User::ROLE_SUPER_ADMIN => 'Super administrador',
        \App\Models\User::ROLE_ADMIN => 'Administrador',
        \App\Models\User::ROLE_PLANNER => 'Planificador',
    ];
@endphp

<span class="inline-flex rounded-full px-2.5 py-1 text-xs font-semibold {{ $roleStyles[$user->role] ?? 'bg-slate-100 text-slate-700' }}">
    {{ $roleLabels[$user->role] ?? $user->role }}
</span>
