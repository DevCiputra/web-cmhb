<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\F;
use App\Models\FileSharingRootFolder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        // Buat role baru
        $role = Role::create([
            'name' => $request->name
        ]);

        // Secara otomatis buat root folder file sharing untuk role baru
        FileSharingRootFolder::create([
            'created_by' => Auth::id(),     // ID user yang membuat role (misalnya admin)
            'role'       => $role->name,     // Role file sharing sesuai dengan role yang baru dibuat
            'name'       => $role->name,     // Nama folder root, misalnya "HBD"
        ]);

        return redirect()->route('role.data.index')->with('success', 'Role created successfully and root folder created.');
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
        $oldName = $role->name;
        $role->update([
            'name' => $request->name
        ]);

        // Optional: Jika Anda ingin memperbarui root folder terkait ketika role di-update,
        // Anda bisa update record pada tabel file_sharing_root_folders.
        FileSharingRootFolder::where('role', $oldName)
            ->update(['role' => $role->name, 'name' => $role->name]);

        return redirect()->route('role.data.index')->with('success', 'Role updated successfully.');
    }

    // Remove the specified role from storage
    public function destroy($id)
    {
        $role = Role::findOrFail($id);

        // Hapus juga root folder terkait jika diperlukan
        FileSharingRootFolder::where('role', $role->name)->delete();

        $role->delete();

        return redirect()->route('role.data.index')->with('success', 'Role deleted successfully.');
    }
}
