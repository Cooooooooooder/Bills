<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Hash;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;



class UserController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            // 1. صلاحية العرض
            new Middleware('permission:قائمة المستخدمين', only: ['index']),  ////

            // 2. صلاحية الإضافة
            new Middleware('permission:اضافة مستخدم', only: ['create', 'store']), ////

            // 3. صلاحية التعديل
            new Middleware('permission:تعديل مستخدم', only: ['edit', 'update']),

            // 4. صلاحية الحذف
            new Middleware('permission:حذف مستخدم', only: ['destroy']),
            // 2. صلاحية الإضافة


        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::select('id', 'name')->get();
        return view('users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // $request->validate([
        //     'name' => 'required|string|max:255',
        //     'email' => 'required|email|unique:users,email',
        //     'password' => 'required|min:8', // Add this to your form
        //     'status' => 'required|in:active,inactive',
        //     'roles_name' => 'required|string|exists:roles,name', // Single role as string
        // ]);
        $user = new User;

        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->roles_name = ["$request->roles_name"];
        $user->status = $request->status;

        $user->save();
        $user->assignRole($request->roles_name);
        return redirect()->route('users.index')->with('create.user', 'تم انشاء مستخدم بتجاح !');
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
        $user = User::findOrFail($id);
        $roles = Role::select('id', 'name')->get();
        return view('users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::find($id);

        $user->name = $request->name;
        $user->email = $request->email;
        if (!empty($request->password)) {
            $user->password = Hash::make($request->password);
        }
        $user->roles_name = $request->roles_name;
        $user->status = $request->status;

        $user->save();
        DB::table('model_has_roles')->where('model_id', $id)->delete();
        $user->assignRole($request->roles_name);
        return redirect()->route('users.index')->with('create.user', 'تم انشاء مستخدم بتجاح !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('users.index')
            ->with('user.delete', 'تم حذف المستخدم بنجاح');
    }
}
