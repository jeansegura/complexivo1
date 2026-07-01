@php
    $classes = [
        \App\Models\InstitutionalPlan::STATUS_DRAFT => 'bg-amber-50 text-amber-700 ring-amber-600/20',
        \App\Models\InstitutionalPlan::STATUS_REVIEW => 'bg-sky-50 text-sky-700 ring-sky-600/20',
        \App\Models\InstitutionalPlan::STATUS_APPROVED => 'bg-emerald-50 text-emerald-700 ring-emerald-600/20',
        \App\Models\InstitutionalPlan::STATUS_INACTIVE => 'bg-slate-100 text-slate-600 ring-slate-500/20',
    ];
    $labels = [
        \App\Models\InstitutionalPlan::STATUS_DRAFT => 'Borrador',
        \App\Models\InstitutionalPlan::STATUS_REVIEW => 'En revision',
        \App\Models\InstitutionalPlan::STATUS_APPROVED => 'Aprobado',
        \App\Models\InstitutionalPlan::STATUS_INACTIVE => 'Inactivo',
    ];
@endphp

<span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-semibold ring-1 ring-inset {{ $classes[$plan->status] ?? 'bg-slate-100 text-slate-600 ring-slate-500/20' }}">
    {{ $labels[$plan->status] ?? 'Sin estado' }}
</span>
