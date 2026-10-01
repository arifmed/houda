<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         $users = User::latest()->get();
         if ($users->isEmpty()) {
    return response()->json(); // OK, but no content
    }
    return response()->json($users,200);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:6',
        'role' => 'required|string',
        'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $avatarUrl = null;

    if ($request->hasFile('avatar')) {

        $path = $request->file('avatar')->store(
            'avatar',
            'public'
        );

        $avatarUrl = asset(
            'storage/' . $path
        );
    }

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => bcrypt($request->password),
        'role' => $request->role,
        'avatar' => $avatarUrl,
        
    ]);

    return response()->json(
        $user,
        201
    );
}

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::find($id);
        return response()->json($user,200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
{
    $user = User::find($id);

    $avatarUrl = null;
     if ($request->hasFile('avatar')) {
        $path = $request->file('avatar')->store(
            'avatar',
            'public'
        );
        $avatarUrl = asset(
            'storage/' . $path
        );
    }

    $user->name = $request->name;
    $user->email = $request->email;
    $user->role = $request->role;
    $user->avatar = $avatarUrl;
    
    

    if ($request->filled('password')) {
        $user->password = Hash::make($request->password);
    }
    $user->is_active = $request->boolean('is_active');
    $user->save();

    return response()->json([
        'message' => 'User updated successfully',
        'user' => $user,
    ]);
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);
        $user->delete();
        return response()->json($user,204);
    }
}
