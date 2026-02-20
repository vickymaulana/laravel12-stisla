<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class HakaksesController extends Controller
{
    /**
     * Display a listing of users with their roles.
     */
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $hakakses = $query->orderBy('name')->get();

        return view('layouts.hakakses.index', compact('hakakses'));
    }

    /**
     * Show the form for editing the specified user's role.
     */
    public function edit($id)
    {
        $hakakses = User::findOrFail($id);

        return view('layouts.hakakses.edit', compact('hakakses'));
    }

    /**
     * Update the specified user's role.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'role' => ['required', 'string', 'in:user,superadmin'],
        ]);

        $user = User::findOrFail($id);
        $user->role = $request->role;
        $user->save();

        ActivityLog::log(
            "Role updated for {$user->name} to {$user->role}",
            'Role Access',
            'updated',
            $user
        );

        return redirect()->route('hakakses.index')
            ->with('success', 'User role updated successfully.');
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Prevent deleting yourself
        if ($user->id === auth()->id()) {
            return redirect()->route('hakakses.index')
                ->with('error', 'You cannot delete your own account.');
        }

        $userName = $user->name;
        $user->delete();

        ActivityLog::log(
            "User deleted: {$userName}",
            'Role Access',
            'deleted'
        );

        return redirect()->route('hakakses.index')
            ->with('success', 'User deleted successfully.');
    }
}
