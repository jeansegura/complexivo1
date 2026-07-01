<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RoleController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->only(['search', 'status']);

        $roles = Role::query()
            ->withCount('permissions')
            ->when($filters['search'] ?? null, function ($query, string $search) {
                $query->where(function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%")
                        ->orWhere('slug', 'like', "%{$search}%");
                });
            })
            ->when($filters['status'] ?? null, function ($query, string $status) {
                $query->where('is_active', $status === 'active');
            })
            ->latest()
            ->get();

        return view('roles.index', compact('roles', 'filters'));
    }

    public function create()
    {
        $permissions = $this->groupedPermissions();

        return view('roles.create', compact('permissions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->rules());

        $role = Role::create([
            'name' => $validated['name'],
            'slug' => $validated['slug'],
            'description' => $validated['description'] ?? null,
            'level' => $validated['level'],
            'is_active' => $request->boolean('is_active'),
        ]);

        $role->permissions()->sync($validated['permissions'] ?? []);

        return redirect()->route('roles.index')->with('success', 'Rol creado correctamente.');
    }

    public function show(Role $role)
    {
        $role->load('permissions');

        return view('roles.show', compact('role'));
    }

    public function edit(Role $role)
    {
        $role->load('permissions');
        $permissions = $this->groupedPermissions();

        return view('roles.edit', compact('role', 'permissions'));
    }

    public function update(Request $request, Role $role)
    {
        $validated = $request->validate($this->rules($role));

        $role->update([
            'name' => $validated['name'],
            'slug' => $validated['slug'],
            'description' => $validated['description'] ?? null,
            'level' => $validated['level'],
            'is_active' => $request->boolean('is_active'),
        ]);

        $role->permissions()->sync($validated['permissions'] ?? []);

        return redirect()->route('roles.index')->with('success', 'Rol actualizado correctamente.');
    }

    public function destroy(Role $role)
    {
        $role->update(['is_active' => false]);

        return redirect()->route('roles.index')->with('success', 'Rol desactivado correctamente.');
    }

    private function rules(?Role $role = null): array
    {
        return [
            'name' => 'required|string|max:120',
            'slug' => ['required', 'string', 'max:120', Rule::unique('roles', 'slug')->ignore($role?->id)],
            'description' => 'nullable|string|max:500',
            'level' => 'required|integer|min:1|max:99',
            'is_active' => 'sometimes|boolean',
            'permissions' => 'nullable|array',
            'permissions.*' => 'integer|exists:permissions,id',
        ];
    }

    private function groupedPermissions()
    {
        return Permission::query()
            ->orderBy('module')
            ->orderBy('action')
            ->get()
            ->groupBy('module');
    }
}
