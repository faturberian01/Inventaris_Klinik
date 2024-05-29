<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:user-list|user-create|user-edit|user-delete', [
            'only' => ['index', 'show']
        ]);
        $this->middleware('permission:user-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:user-force-delete', ['only' => ['trash']]);
        $this->middleware('permission:user-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:user-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('users.index', [
            "title" => "Users Management",
            'users' => User::orderBy('created_at', 'desc')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.create', [
            "title" => "Tambah User Baru",
            "roles" => Role::pluck('name', 'name')->all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            "name" => "required",
            "email" => "required|email|unique:users,email",
            "password" => "required|min:5",
            "roles" => "required|array",
        ], [
            "roles" => "Roles (Hak Level)",
        ]);

        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
        ]);
        $user->assignRole($validatedData['roles']);

        return redirect()->route('users.index')->with('success', 'Data user baru berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $user->load('roles');

        return view('users.show', [
            "title" => "Detail User",
            "user" => $user,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('users.edit', [
            "title" => "Edit User",
            "user" => $user,
            "userRoles" => $user->roles()->pluck('name', 'name')->all(),
            "roles" => Role::pluck('name', 'name')->all()
        ]);
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
        $userEmailUniqueValidation = $user->email === $request->email ? '' : '|unique:users,email';

        $validatedData = $request->validate([
            "name" => "required",
            "email" => "required|email" . $userEmailUniqueValidation,
            "roles" => "required|array",
            "password" => $request->post('password') ? 'confirmed' : ''
        ], [
            "roles" => "Roles (Hak Level)",
        ]);

        if (array_key_exists('password', $validatedData)) {
            if ($validatedData['password']) {
                $validatedData['password'] = Hash::make($validatedData['password']);
            } else {
                $validatedData = array_filter($validatedData);
            }
        }

        $user->update($validatedData);

        DB::table('model_has_roles')->where('model_id', $user->id)->delete();

        $user->assignRole($request->input('roles'));


        return redirect()->route('users.index')->with('success', 'Data user berhasil diubah.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
    }
}
