<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserManagementController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        // Filter by role
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Search by name or email
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        $users = $query->latest()->paginate(15)->withQueryString();

        $totalAdmin = User::where('role', 'admin')->count();
        $totalUser  = User::where('role', 'user')->count();
        $totalAktif = User::where('status', 'aktif')->count();

        return view('admin.users', compact('users', 'totalAdmin', 'totalUser', 'totalAktif'));
    }

    public function create()
    {
        return view('admin.users-create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'       => 'required|string|max:255',
            'email'      => 'required|email|unique:users,email',
            'password'   => 'required|string|min:8|confirmed',
            'role'       => 'required|in:admin,user',
            'status'     => 'required|in:aktif,nonaktif',
            'no_telepon' => 'nullable|string|max:20',
        ]);

        User::create([
            'name'       => $request->name,
            'email'      => $request->email,
            'password'   => Hash::make($request->password),
            'role'       => $request->role,
            'status'     => $request->status,
            'no_telepon' => $request->no_telepon,
        ]);

        return redirect()->route('admin.users')
            ->with('success', 'Akun berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users-edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name'       => 'required|string|max:255',
            'email'      => ['required', 'email', Rule::unique('users')->ignore($id)],
            'role'       => 'required|in:admin,user',
            'status'     => 'required|in:aktif,nonaktif',
            'no_telepon' => 'nullable|string|max:20',
        ]);

        // Cegah admin menonaktifkan/mengubah role akun sendiri
        if ($user->id === auth()->id() && $request->status === 'nonaktif') {
            return back()->with('error', 'Anda tidak dapat menonaktifkan akun Anda sendiri.');
        }

        $user->update([
            'name'       => $request->name,
            'email'      => $request->email,
            'role'       => $request->role,
            'status'     => $request->status,
            'no_telepon' => $request->no_telepon,
        ]);

        return redirect()->route('admin.users')
            ->with('success', 'Akun berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if ($user->id === auth()->id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $user->delete();
        return redirect()->route('admin.users')
            ->with('success', 'Akun berhasil dihapus.');
    }

    public function resetPassword(Request $request, $id)
    {
        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::findOrFail($id)->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('admin.users')
            ->with('success', 'Password berhasil direset!');
    }

    public function toggleStatus($id)
    {
        $user = User::findOrFail($id);

        if ($user->id === auth()->id()) {
            return back()->with('error', 'Anda tidak dapat mengubah status akun sendiri.');
        }

        $user->update([
            'status' => $user->status === 'aktif' ? 'nonaktif' : 'aktif',
        ]);

        return back()->with('success', 'Status akun berhasil diubah.');
    }
}
