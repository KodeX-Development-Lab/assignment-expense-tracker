<?php
namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = auth()->user();

        if ($user->role->name != 'Admin') {
            return abort(403);
        }

        $search   = $request->search ?? '';
        $per_page = $request->display ?? 10;
        $users    = User::where(function ($query) use ($search) {
            if ($search) {
                $query->where('name', 'LIKE', "%$search%")
                    ->orWhere('email', 'LIKE', "%$search%");
            }
        })
            ->paginate($per_page);

        return view('users.index', [
            'users'   => $users,
            'roles'   => Role::all(),
            'request' => $request,
        ]);
    }

    public function changeLockStatus(Request $request)
    {
        $user = auth()->user();

        if ($user->role->name != 'Admin') {
            return abort(403);
        }

        $user = User::findOrFail($request->id);
        $user->update(['is_locked' => ! $user->is_locked]);

        return response()->json([
            "success" => true,
        ]);
    }

    public function changeRole(Request $request)
    {
        $request->validate([
            'role_id' => 'required|exists:roles,id',
        ]);

        $user = auth()->user();

        if ($user->role->name != 'Admin') {
            return abort(403);
        }

        $user = User::findOrFail($request->user_id);
        $user->update(['role_id' => $request->role_id]);

        return redirect()->back()->with('flash_message', "success");
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
