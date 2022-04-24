<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Inertia::render('Admin/Admins/Index', [
            'admins' => User::where('is_admin', 1)->paginate(5),
            'roles' => Role::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => ['required', 'max:50'],
            'username' => ['required', 'max:25', 'unique:users'],
            'email' => ['required', 'unique:users']
        ]);
        $admin = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make('123456'),
            'is_admin' => 0,
        ]);

        $role = Role::where('id', 5)->first();
        $admin->syncRoles($role);
        return back();
        $this->validate($request, [
            'name' => ['required', 'max:50'],
            'username' => ['required', 'max:25', 'unique:users'],
            'email' => ['required', 'unique:users']
        ]);
        $admin = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make('123456'),
            'is_admin' => 0,
        ]);

        $role = Role::where('id', 5)->first();
        $admin->syncRoles($role);
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        // $this->validate($request, [
        //     'name' => ['required', 'max:50'],
        //     'username' => ['required', 'max:25'],
        //     'email' => ['required', 'email']
        // ]);
        // if ($request->roles[0] === null) {
        //     return back()->withErrors(['roles' => 'The Role field is required']);
        // }
        if ($request->roles[0]['id'] != 5) {
            $adminRole = Role::where('id', $request->roles[0]['id'])->first();
            $user->syncRoles($adminRole);
            return back();
        } else {
            $userRole = Role::where('id', 5)->first();
            $user->update(['is_admin' => 0]);
            $user->syncRoles($userRole);
            return back();
        }
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}