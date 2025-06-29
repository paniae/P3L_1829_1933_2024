<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        return response()->json(Role::all(), 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_role' => 'required|string|max:100|unique:roles,nama_role',
        ]);

        $role = Role::create([
            'nama_role' => $validated['nama_role'],
        ]);

        return response()->json(['message' => 'Role berhasil ditambahkan', 'role' => $role], 201);
    }

    public function show($id)
    {
        $role = Role::find($id);
        if (!$role) {
            return response()->json(['message' => 'Role tidak ditemukan'], 404);
        }
        return response()->json($role);
    }

    public function update(Request $request, $id)
    {
        $role = Role::find($id);
        if (!$role) {
            return response()->json(['message' => 'Role tidak ditemukan'], 404);
        }

        $validated = $request->validate([
            'nama_role' => 'required|string|max:100|unique:roles,nama_role,' . $id . ',id_role',
        ]);

        $role->update($validated);

        return response()->json(['message' => 'Role berhasil diperbarui', 'role' => $role]);
    }

    public function destroy($id)
    {
        $role = Role::find($id);
        if (!$role) {
            return response()->json(['message' => 'Role tidak ditemukan'], 404);
        }

        $role->delete();

        return response()->json(['message' => 'Role berhasil dihapus']);
    }
}
