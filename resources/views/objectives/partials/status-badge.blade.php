@php
    $classes = [
        \App\Models\StrategicObjective::STATUS_DRAFT => 'bg-amber-50 text-amber-700 ring-amber-600/20',
        \App\Models\StrategicObjective::STATUS_ACTIVE => 'bg-emerald-50 text-emerald-700 ring-emerald-600/20',
        \App\Models\StrategicObjective::STATUS_INACTIVE => 'bg-slate-100 text-slate-600 ring-slate-500/20',
    ];
    $labels = [
        \App\Models\StrategicObjective::STATUS_DRAFT => 'Borrador',
        \App\Models\StrategicObjective::STATUS_ACTIVE => 'Activo',
        \App\Models\StrategicObjective::STATUS_INACTIVE => 'Inactivo',
    ];
@endphp

<span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-semibold ring-1 ring-inset {{ $classes[$objective->status] ?? 'bg-slate-100 text-slate-600 ring-slate-500/20' }}">
    {{ $labels[$objective->status] ?? 'Sin estado' }}
</span>
