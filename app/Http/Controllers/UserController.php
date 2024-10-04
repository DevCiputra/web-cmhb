<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // Display the list of users
    public function index()
    {
       $users = User::all(); // Get all users
        return view('management-data.master.user.index', compact('users'));
    } 

    // Show the form for creating a new user
    public function create()
    {
        $roles = Role::all(); // Mengambil semua data role
        return view('management-data.master.user.create', compact('roles'));
    }

    // Store a newly created user in the database
    public function store(Request $request)
    {
        // Validate the form inputs
        $validatedData = $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'role' => 'required|string',
        ]);

        // Create a new user record
        User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('user.data.index')->with('success', 'User berhasil ditambahkan!');
    }

    // Show the form for editing the specified user
    public function edit($id)
    {
        $user = User::findOrFail($id); // Find the user by ID
        $roles = Role::all(); // Mengambil semua data role
        return view('management-data.master.user.edit', compact('user', 'roles'));
    }

    // Update the specified user in the database
    public function update(Request $request, $id)
    {
        // Validate the form inputs
        $validatedData = $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|string|min:6',
            'role' => 'required|string',
        ]);

        // Find the user by ID and update the data
        $user = User::findOrFail($id);
        $user->username = $validatedData['username'];
        $user->email = $validatedData['email'];
        if (!empty($validatedData['password'])) {
            $user->password = Hash::make($validatedData['password']); // Hash the password if it's changed
        }
        $user->role = $validatedData['role'];
        $user->save();

        return redirect()->route('user.data.index')->with('success', 'User berhasil diperbarui!');
    }

    // Delete the specified user from the database
    public function destroy($id)
    {
        $user = User::findOrFail($id); // Find the user by ID
        $user->delete(); // Soft delete the user

        return redirect()->route('user.data.index')->with('success', 'User berhasil dihapus!');
    }
}
