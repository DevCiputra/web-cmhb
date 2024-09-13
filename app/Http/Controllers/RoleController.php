<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::all(); // Mengambil semua data role dari database
        return view('management-data.master.role.index', compact('roles'));
    }

    // Show the form for creating a new role
    public function create()
    {
        return view('management-data.master.role.create');
    }

    // Store a newly created role in storage
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        Role::create([
            'name' => $request->name
        ]);

        return redirect()->route('role.data.index')->with('success', 'Role created successfully.');
    }

    // Show the form for editing the specified role
    public function edit($id)
    {
        $role = Role::findOrFail($id);
        return view('management-data.master.role.edit', compact('role'));
    }

    // Update the specified role in storage
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $role = Role::findOrFail($id);
        $role->update([
            'name' => $request->name
        ]);

        return redirect()->route('role.data.index')->with('success', 'Role updated successfully.');
    }

    // Remove the specified role from storage
    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();

        return redirect()->route('role.data.index')->with('success', 'Role deleted successfully.');
    }
}
