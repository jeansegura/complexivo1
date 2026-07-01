@extends('layouts.app')

@section('title', 'Panel SIPeIP')

@section('content')
    @include('partials.page-header', [
        'title' => 'Panel SIPeIP',
        'subtitle' => 'Base del modulo de planificacion institucional',
    ])

    <div class="grid gap-4 md:grid-cols-3">
        <section class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
            <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Sprint tecnico</p>
            <h2 class="mt-2 text-lg font-bold text-slate-900">Estructura base</h2>
            <p class="mt-2 text-sm text-slate-600">
                Layout, navegacion y parciales reutilizables siguiendo el estilo definido para el proyecto.
            </p>
        </section>

        <section class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
            <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Siguiente modulo</p>
            <h2 class="mt-2 text-lg font-bold text-slate-900">Usuarios y roles</h2>
            <p class="mt-2 text-sm text-slate-600">
                La primera funcionalidad del dominio sera la administracion de acceso institucional.
            </p>
        </section>

        <section class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
            <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Control de calidad</p>
            <h2 class="mt-2 text-lg font-bold text-slate-900">Workflow activo</h2>
            <p class="mt-2 text-sm text-slate-600">
                Cada avance debe pasar por instalacion, estilo, assets y pruebas automatizadas.
            </p>
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
                        <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Objetivo</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach ([
                        ['1', 'Usuarios y roles', 'Definir acceso, permisos y base de seguridad.'],
                        ['2', 'Entidades publicas', 'Registrar instituciones, sectores y unidades organizacionales.'],
                        ['3', 'Objetivos estrategicos', 'Gestionar objetivos institucionales, PND y ODS.'],
                        ['4', 'Planes institucionales', 'Registrar planes, estados, validaciones y observaciones.'],
                        ['5', 'Auditoria y reportes', 'Registrar acciones y generar salidas exportables.'],
                    ] as [$order, $module, $goal])
                        <tr class="transition hover:bg-slate-50/80">
                            <td class="px-5 py-4 font-medium text-slate-900">{{ $order }}</td>
                            <td class="px-5 py-4 text-slate-700">{{ $module }}</td>
                            <td class="px-5 py-4 text-slate-600">{{ $goal }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
