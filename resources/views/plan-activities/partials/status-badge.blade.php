@php
    $classes = [
        \App\Models\PlanActivity::STATUS_PENDING => 'bg-amber-50 text-amber-700 ring-amber-600/20',
        \App\Models\PlanActivity::STATUS_IN_PROGRESS => 'bg-sky-50 text-sky-700 ring-sky-600/20',
        \App\Models\PlanActivity::STATUS_COMPLETED => 'bg-emerald-50 text-emerald-700 ring-emerald-600/20',
        \App\Models\PlanActivity::STATUS_INACTIVE => 'bg-slate-100 text-slate-600 ring-slate-500/20',
    ];
    $labels = [
        \App\Models\PlanActivity::STATUS_PENDING => 'Pendiente',
        \App\Models\PlanActivity::STATUS_IN_PROGRESS => 'En ejecucion',
        \App\Models\PlanActivity::STATUS_COMPLETED => 'Completada',
        \App\Models\PlanActivity::STATUS_INACTIVE => 'Inactiva',
    ];
@endphp

<span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-semibold ring-1 ring-inset {{ $classes[$activity->status] ?? 'bg-slate-100 text-slate-600 ring-slate-500/20' }}">
    {{ $labels[$activity->status] ?? 'Sin estado' }}
</span>
