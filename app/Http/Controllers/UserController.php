<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->only(['search', 'role', 'status']);

        $users = User::query()
            ->when($filters['search'] ?? null, function ($query, string $search) {
                $query->where(function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->when($filters['role'] ?? null, fn ($query, string $role) => $query->where('role', $role))
            ->when($filters['status'] ?? null, fn ($query, string $status) => $query->where('status', $status))
            ->latest()
            ->get();

        $roles = $this->roles();
        $statuses = $this->statuses();

        return view('users.index', compact('users', 'roles', 'statuses', 'filters'));
    }

    public function create()
    {
        $roles = $this->roles();
        $statuses = $this->statuses();

        return view('users.create', compact('roles', 'statuses'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => ['required', 'confirmed', Password::defaults()],
            'role' => ['required', Rule::in(array_keys($this->roles()))],
            'status' => ['nullable', Rule::in(array_keys($this->statuses()))],
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
            'status' => $validated['status'] ?? User::STATUS_ACTIVE,
        ]);

        return redirect()->route('users.index')->with('success', 'Usuario creado correctamente.');
    }

    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        $roles = $this->roles();
        $statuses = $this->statuses();

        return view('users.edit', compact('user', 'roles', 'statuses'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => ['nullable', 'confirmed', Password::defaults()],
            'role' => ['required', Rule::in(array_keys($this->roles()))],
            'status' => ['nullable', Rule::in(array_keys($this->statuses()))],
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->role = $validated['role'];
        $user->status = $validated['status'] ?? $user->status;

        if (! empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return redirect()->route('users.index')->with('success', 'Usuario actualizado correctamente.');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'No puedes desactivar tu propia cuenta desde este modulo.');
        }

        $user->update(['status' => User::STATUS_INACTIVE]);

        return redirect()->route('users.index')->with('success', 'Usuario desactivado correctamente.');
    }

    private function roles(): array
    {
        return [
            User::ROLE_SUPER_ADMIN => 'Super administrador',
            User::ROLE_ADMIN => 'Administrador',
            User::ROLE_PLANNER => 'Planificador',
        ];
    }

    private function statuses(): array
    {
        return [
            User::STATUS_ACTIVE => 'Activo',
            User::STATUS_INACTIVE => 'Inactivo',
        ];
    }
}
