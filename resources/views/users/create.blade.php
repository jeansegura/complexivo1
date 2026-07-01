@extends('layouts.app')

@section('title', 'Nuevo usuario')

@section('content')
    @include('partials.page-header', [
        'title' => 'Nuevo usuario',
        'subtitle' => 'Registra un usuario institucional',
        'backUrl' => route('users.index'),
        'backLabel' => 'Volver a usuarios',
    ])

    <div class="max-w-2xl overflow-hidden rounded-lg border border-slate-200 bg-white shadow-sm">
        <div class="border-b border-slate-200 px-6 py-4">
            <h2 class="text-base font-semibold text-slate-900">Datos del usuario</h2>
            <p class="mt-0.5 text-sm text-slate-500">Los campos con * son obligatorios.</p>
        </div>

        <form action="{{ route('users.store') }}" method="POST" class="p-6">
            @csrf

            @include('partials.form-field', [
                'label' => 'Nombre',
                'name' => 'name',
                'value' => old('name'),
                'required' => true,
            ])

            @include('partials.form-field', [
                'label' => 'Email',
                'name' => 'email',
                'type' => 'email',
                'value' => old('email'),
                'required' => true,
            ])

            @include('partials.form-field', [
                'label' => 'Password',
                'name' => 'password',
                'type' => 'password',
                'required' => true,
            ])

            @include('partials.form-field', [
                'label' => 'Confirmar password',
                'name' => 'password_confirmation',
                'type' => 'password',
                'required' => true,
            ])

            @include('users.partials.role-select', [
                'roles' => $roles,
                'selected' => old('role'),
            ])

            @include('partials.form-actions', [
                'cancelUrl' => route('users.index'),
                'submitLabel' => 'Guardar usuario',
            ])
        </form>
    </div>
@endsection
