<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all(); // Menghapus filter role

        return Inertia::render('Admin/User', [
            'users' => $users,
            'currentUser' => auth()->user()
        ]);
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8',
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];

        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'User updated successfully',
                'user' => $user->fresh()
            ]);
        }

        return redirect()->back()->with([
            'message' => 'User updated successfully',
            'users' => User::all()
        ]);
    }

    public function destroy(User $user)
    {
        $user->delete();

        // For JSON response
        if (request()->expectsJson()) {
            return response()->json([
                'message' => 'User deleted successfully'
            ]);
        }

        // For Inertia redirect
        return redirect()->back()->with([
            'message' => 'User deleted successfully',
            'users' => User::all()
        ]);
    }

    public function export()
    {
        $users = User::select('id', 'name', 'email', 'created_at')->get();

        $filename = 'users_export_' . date('Y-m-d_H-i-s') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($users) {
            $file = fopen('php://output', 'w');

            // Add CSV headers
            fputcsv($file, ['ID', 'Name', 'Email', 'Created At']);

            // Add user data
            foreach ($users as $user) {
                fputcsv($file, [
                    $user->id,
                    $user->name,
                    $user->email,
                    $user->created_at->format('Y-m-d H:i:s')
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Search users (for AJAX requests).
     */
    public function search(Request $request)
    {
        $query = $request->get('q');

        $users = User::where('name', 'LIKE', "%{$query}%")
            ->orWhere('email', 'LIKE', "%{$query}%")
            ->select('id', 'name', 'email', 'profile_photo_url')
            ->limit(10)
            ->get();

        return response()->json($users);
    }

    /**
     * Toggle user status (if you have status field).
     */
    public function toggleStatus(User $user)
    {
        $user->update([
            'status' => $user->status === 'Active' ? 'Inactive' : 'Active'
        ]);

        return back()->with('success', 'User status updated successfully.');
    }
}
