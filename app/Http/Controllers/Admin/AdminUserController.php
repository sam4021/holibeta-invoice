<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Enums\RoleEnum;


class AdminUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = UserResource::collection(User::all());
        $roles = RoleEnum::cases();

        $filters=request()->only(['search','showing']);
        return inertia::render('admin/users/index',compact('users','filters','roles'));
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
        try{
            $validated=$request->validate([
                'name'=>['required', 'string', 'max:255'],
                'email'=>['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:8','confirmed'],
                'password_confirmation'=>['required'],
                'role' =>['required']
            ]);
            $role=Role::findByName($validated['role']);
               $user=User::create([
                   'name'=>$validated['name'],
                   'email'=>$validated['email'],
                   'password'=>Hash::make($validated['password']),
                   'first_login'=>1
               ]);
               $user->assignRole($role);
       
               //create email verification token
               $token=rand(111111,999999);
               VerifyUser::create([
                   'user_id'=>$user->id,
                   'otp_code'=>$token
               ]);
               //event for email verification
              $user->notify(new EmailVerificationNotification($token));

            return response('User Created Successfully', 200);
        }
        catch(\Exception $e){
            return response('User Not Created. Try again', 400);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            User::destroy($id);
            return response('User Deleted Successfully', 200);
        } catch (\Exception $e) {
            return response('User Not Deleted. Try again Later', 400);
        }
    }
}
