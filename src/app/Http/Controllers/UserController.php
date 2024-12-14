<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $user = auth()->user();
        $this->authorize('viewAny', $user);
        $users = User::all();
        return view('users.index', compact('users'));
    }

    public function search(Request $request)
    {
        $user = auth()->user();
        $this->authorize('viewAny', $user);
        $users = User::where('email', 'like', '%' . $request->search . '%')->get();
        return view('users.index', compact('users'));
    }

    public function updatePermissions(Request $request, $id)
    {
        $user = auth()->user();
        $this->authorize('viewAny', $user);
        $user = User::find($id);
        
        if ($request->has('permissions')) {
            $user->syncPermissions($request->permissions);
        }

        return redirect()->route('users.index');
    }

    public function toggleStatus($id)
    {
        $user = auth()->user();
        $this->authorize('viewAny', $user);
        $user = User::find($id);
        $user->is_active = !$user->is_active;
        $user->save();

        return redirect()->route('users.index');
    }
}
