<?php

namespace App\Http\Controllers;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;

class RoleController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            // 1. صلاحية العرض
            new Middleware('permission:صلاحيات المستخدمين', only: ['index']),  ////

            new Middleware('permission:عرض صلاحية', only: ['show']),  ////

            new Middleware('permission:اضافة صلاحية', only: ['create', 'store']), ////

            // 3. صلاحية التعديل
            new Middleware('permission:تعديل صلاحية', only: ['edit', 'update']),

            // 4. صلاحية الحذف
            new Middleware('permission:حذف صلاحية', only: ['destroy']),   ////////

        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::all();
        return view('roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $all_permissions = Permission::get();
        return view('roles.create', compact('all_permissions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $role = new Role;

        $role->name = $request->name;
        $role->save();

        $role->syncPermissions($request->input('permission'));

        return redirect()->route('roles.index')->with('roles.store', 'تم اضافة الصلاحية بنجاح');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $role = Role::findOrFail($id);

        $role_permissions = $role->permissions()->get();

        return view('roles.show', compact('role', 'role_permissions'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $role = Role::findOrFail($id);
        $all_permissions = Permission::get();
        $role_permissions = DB::table("role_has_permissions")->where("role_id", $id)
            ->pluck('permission_id', 'permission_id')
            ->all();
        return view('roles.edit', compact('all_permissions', 'role_permissions', 'role'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // $this->validate($request, [
        //     'name' => 'required|unique:roles,name,' . $id,
        //     'permission' => 'required',
        // ]);
        // return $request;
        $role = Role::find($id);

        $role->name = $request->input('name');
        $role->save();

        $role->syncPermissions($request->input('permission'));

        return redirect()->route('roles.index')->with('roles.edit', 'تم تحديث الصلاحية بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $role = Role::findOrFail($id);
        $role->delete();
        return redirect()->route('roles.index')
            ->with('roles.delete', 'تم حذف الصلاحية بنجاح');
    }
}
