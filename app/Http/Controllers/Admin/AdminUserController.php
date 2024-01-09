<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Models\VerifyUser;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Enums\RoleEnum;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Notifications\NewUserNotification;
use App\Notifications\PasswordResetNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AdminUserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['role:' . RoleEnum::Admin->value]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::query()
            ->when(request('search'), function ($query) {
                $query->where('name', 'like', '%' . request('search') . '%');
            })
            ->paginate(request('showing') ?? 10);
        $users = UserResource::collection($users);
        $roles = RoleEnum::cases();

        $filters = request()->only(['search', 'showing']);
        return inertia::render('admin/users/index', compact('users', 'filters', 'roles'));
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

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'role' => ['required']
        ]);
        DB::beginTransaction();
        try {
            $roles = [];
            foreach ($validated['role'] as $key => $value) {
                $role = Role::findByName($value);
                array_push($roles, $role);
            }
            $temp_pass = Str::random(8);
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($temp_pass),
                'first_login' => 1
            ]);
            $user->assignRole($roles);

            //event
            $user->notify(new NewUserNotification($temp_pass));

            DB::commit();
            return redirect()->back()->with('success', 'User Created Successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e);
            return redirect()->back()->with('status', 'User Not Created. Try again');
        }
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
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'role' => ['required']
        ]);

        User::findOrFail($id)->update([
            'name' => $validated['name'],
        ]);
        $user = User::find($id);
        $roles = [];
        foreach ($validated['role'] as $key => $value) {
            $role = Role::findByName($value);
            array_push($roles, $role);
        }

        if ($roles != $user->getRoleNames()) {
            //$user->removeRole($user->getRoleNames());
            $user->roles()->detach();
            $user->assignRole($roles);
        }
        return redirect()->back()->with('success', 'User Created Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            User::destroy($id);
            return redirect()->back()->with('success', 'User Deleted Successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('User Not Deleted. Try again Later');
        }
    }
}
