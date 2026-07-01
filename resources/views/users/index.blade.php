@extends('layouts.app')

@section('title', 'Usuarios')

@section('content')
    @include('partials.page-header', [
        'title' => 'Usuarios',
        'subtitle' => 'Administracion de acceso institucional al SIPeIP',
        'actionUrl' => route('users.create'),
        'actionLabel' => 'Nuevo usuario',
    ])

    <div class="overflow-hidden rounded-lg border border-slate-200 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200 text-sm">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-5 py-3.5 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Nombre</th>
                        <th class="px-5 py-3.5 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Email</th>
                        <th class="px-5 py-3.5 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Rol</th>
                        <th class="px-5 py-3.5 text-right text-xs font-semibold uppercase tracking-wide text-slate-500">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($users as $user)
                        <tr class="transition hover:bg-slate-50/80">
                            <td class="px-5 py-4 font-medium text-slate-900">{{ $user->name }}</td>
                            <td class="px-5 py-4 text-slate-600">{{ $user->email }}</td>
                            <td class="px-5 py-4">
                                @include('users.partials.role-badge', ['user' => $user])
                            </td>
                            <td class="px-5 py-4 text-right">
                                @include('partials.action-buttons', [
                                    'showUrl' => route('users.show', $user),
                                    'editUrl' => route('users.edit', $user),
                                    'destroyUrl' => route('users.destroy', $user),
                                    'confirmMessage' => 'Eliminar este usuario?',
                                ])
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-5 py-12 text-center">
                                <p class="text-sm font-medium text-slate-900">No hay usuarios registrados</p>
                                <p class="mt-1 text-sm text-slate-500">Crea el primero desde el boton Nuevo usuario.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
