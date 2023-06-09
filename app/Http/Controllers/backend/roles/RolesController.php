<?php

namespace App\Http\Controllers\backend\roles;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;

class RolesController extends Controller
{
    // function __construct()
    // {
    //     $this->middleware('permission:role-list|role-create|role-edit|role-delete', ['only' => ['index','store']]);
    //     $this->middleware('permission:role-create', ['only' => ['create','store']]);
    //     $this->middleware('permission:role-edit', ['only' => ['edit','update']]);
    //     $this->middleware('permission:role-delete', ['only' => ['destroy']]);
    // }
    public function index(Request $request)
    {
        $roles = Role::orderBy('id','DESC')->paginate(5);
        return view('roles.index',compact('roles'))->with('i', ($request->input('page', 1) - 1) * 5);
    }

    public function create()
    {
        $permission = Permission::get();
        return view('roles.create',compact('permission'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:roles,name',
            'permission' => 'required',
        ],[
            'name.required' =>__('messagevalidation.users.namepermissionrequired'),
            'name.unique' =>__('messagevalidation.users.nameunique'),
            'permission.required' =>__('messagevalidation.users.permissionrequired'),
        ]);

        try{
            DB::beginTransaction();
            $role = Role::create(['name' => $request->input('name')]);
            $role->syncPermissions($request->input('permission'));
            DB::commit();
            toastr()->success(trans('message.create'));
            return redirect()->route('roles.index');
        }catch(\Exception $execption){
            DB::rollBack();
            toastr()->error(trans('message.error'));
            return redirect()->route('roles.index');
        }
    }

    public function show($id)
    {
        $role = Role::find($id);
        $rolePermissions = Permission::join('role_has_permissions','role_has_permissions.permission_id','=','permissions.id')
        ->where('role_has_permissions.role_id',$id)
        ->get();
        return view('roles.show',compact('role','rolePermissions'));
    }

    public function edit($id)
    {
        $role = Role::find($id);
        $permission = Permission::get();
        $rolePermissions = DB::table('role_has_permissions')->where('role_has_permissions.role_id',$id)
        ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')
        ->all();
        return view('roles.edit',compact('role','permission','rolePermissions'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'permission' => 'required',
        ],[
            'name.required' =>__('messagevalidation.users.namepermissionrequired'),
            'permission.required' =>__('messagevalidation.users.permissionrequired'),
        ]);

        try{
            DB::beginTransaction();
            $role = Role::findOrFail($id);
            $input = $request->all();
            $b_exists = Role::where('name', '=', $input['name'])->exists();
            if($b_exists){
                $role->syncPermissions($request->input('permission'));
                DB::commit();
                toastr()->success(trans('message.update'));
                return redirect()->route('roles.index');
            }
            else{
                $role->name = $request->input('name');
                $role->save();
                $role->syncPermissions($request->input('permission'));
                DB::commit();
                toastr()->success(trans('message.update'));
                return redirect()->route('roles.index');
            }
        }catch(\Exception $execption){
            DB::rollBack();
            toastr()->error(trans('message.error'));
            return redirect()->route('roles.index');
        }
    }

    public function destroy($id)
    {
        try{
            DB::beginTransaction();
            DB::table('roles')->where('id',$id)->delete();
            DB::commit();
            toastr()->success(trans('message.delete'));
            return redirect()->route('roles.index');
        }catch(\Exception $execption){
            DB::rollBack();
            toastr()->error(trans('message.error'));
            return redirect()->route('roles.index');
        }
    }
}

