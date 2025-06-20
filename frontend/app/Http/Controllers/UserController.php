<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('name', 'asc')->get();

        return view('users', compact('users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'role' => 'required|in:admin,produsen,distributor,konsumen'
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make('password'),
            'role' => $validated['role']
        ]);

        return redirect()->back()->with('success', 'Created');
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'role' => 'required|in:admin,produsen,distributor,konsumen'
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;

        $user->save();

        return redirect()->route('user.index')->with('success', 'Updated');
    }

    public function reset($id)
    {
        $user = User::findOrFail($id);
        $user->password = Hash::make('password');
        $user->save();

        return redirect()->back()->with('success', 'Success');
    }

    public function destroy($id)
    {
        $dosen = User::findOrFail($id);
        $dosen->delete();

        return redirect()->route('user.index')->with('success', 'Deleted');
    }
}
