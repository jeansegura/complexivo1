@extends('layouts.app')

@section('title', 'Editar usuario')

@section('content')
    @include('partials.page-header', [
        'title' => 'Editar usuario',
        'subtitle' => $user->name,
        'backUrl' => route('users.index'),
        'backLabel' => 'Volver a usuarios',
    ])

    <div class="max-w-2xl overflow-hidden rounded-lg border border-slate-200 bg-white shadow-sm">
        <div class="border-b border-slate-200 px-6 py-4">
            <h2 class="text-base font-semibold text-slate-900">Datos del usuario</h2>
            <p class="mt-0.5 text-sm text-slate-500">Deja el password vacio si no deseas cambiarlo.</p>
        </div>

        <form action="{{ route('users.update', $user) }}" method="POST" class="p-6">
            @csrf
            @method('PUT')

            @include('partials.form-field', [
                'label' => 'Nombre',
                'name' => 'name',
                'value' => old('name', $user->name),
                'required' => true,
            ])

            @include('partials.form-field', [
                'label' => 'Email',
                'name' => 'email',
                'type' => 'email',
                'value' => old('email', $user->email),
                'required' => true,
            ])

            @include('partials.form-field', [
                'label' => 'Nuevo password',
                'name' => 'password',
                'type' => 'password',
            ])

            @include('partials.form-field', [
                'label' => 'Confirmar nuevo password',
                'name' => 'password_confirmation',
                'type' => 'password',
            ])

            @include('users.partials.role-select', [
                'roles' => $roles,
                'selected' => old('role', $user->role),
            ])

            @include('partials.form-actions', [
                'cancelUrl' => route('users.index'),
                'submitLabel' => 'Actualizar usuario',
            ])
        </form>
    </div>
@endsection
