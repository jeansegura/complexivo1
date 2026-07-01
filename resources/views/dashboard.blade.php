@extends('layouts.app')

@section('title', 'Panel SIPeIP')

@section('content')
    @include('partials.page-header', [
        'title' => 'Panel SIPeIP',
        'subtitle' => 'Base del modulo de planificacion institucional',
    ])

    <div class="grid gap-4 md:grid-cols-4">
        <section class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
            <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Epica 1</p>
            <h2 class="mt-2 text-lg font-bold text-slate-900">Usuarios</h2>
            <p class="mt-2 text-sm text-slate-600">Registro, filtros y desactivacion sin perder trazabilidad.</p>
        </section>

        <section class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
            <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Epica 2</p>
            <h2 class="mt-2 text-lg font-bold text-slate-900">Roles</h2>
            <p class="mt-2 text-sm text-slate-600">Roles funcionales, niveles de acceso y permisos por modulo.</p>
        </section>

        <section class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
            <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Epica 3</p>
            <h2 class="mt-2 text-lg font-bold text-slate-900">Entidades</h2>
            <p class="mt-2 text-sm text-slate-600">Instituciones, sectores, tipos y jerarquia institucional.</p>
        </section>

        <section class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
            <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Epica 4</p>
            <h2 class="mt-2 text-lg font-bold text-slate-900">Objetivos</h2>
            <p class="mt-2 text-sm text-slate-600">Objetivos estrategicos vinculados a entidad, PND y ODS.</p>
        </section>
    </div>

    <div class="mt-8 overflow-hidden rounded-lg border border-slate-200 bg-white shadow-sm">
        <div class="border-b border-slate-200 px-6 py-4">
            <h2 class="text-base font-semibold text-slate-900">Roadmap inicial</h2>
            <p class="mt-1 text-sm text-slate-500">Orden propuesto para construir el sistema paso a paso.</p>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200 text-sm">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Orden</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Modulo</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Estado</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Objetivo</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach ([
                        ['1', 'Usuarios institucionales', 'En desarrollo', 'Definir acceso, consulta, actualizacion y desactivacion.'],
                        ['2', 'Roles y permisos', 'En desarrollo', 'Gestionar roles funcionales y permisos por modulo.'],
                        ['3', 'Entidades publicas', 'En desarrollo', 'Registrar instituciones, sectores y unidades organizacionales.'],
                        ['4', 'Objetivos estrategicos', 'En desarrollo', 'Gestionar objetivos institucionales, PND y ODS.'],
                        ['5', 'Planes institucionales', 'Pendiente', 'Registrar planes, estados, validaciones y observaciones.'],
                        ['6', 'Auditoria y reportes', 'Pendiente', 'Registrar acciones y generar salidas exportables.'],
                    ] as [$order, $module, $status, $goal])
                        <tr class="transition hover:bg-slate-50/80">
                            <td class="px-5 py-4 font-medium text-slate-900">{{ $order }}</td>
                            <td class="px-5 py-4 text-slate-700">{{ $module }}</td>
                            <td class="px-5 py-4 text-slate-600">{{ $status }}</td>
                            <td class="px-5 py-4 text-slate-600">{{ $goal }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
