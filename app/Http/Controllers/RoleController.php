<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Http\Requests\RoleRequest;
use Alert;
use Auth;
class RoleController extends Controller
{
    public function index()
    {
        $data = Role::orderBy('created_at','desc')->paginate(10);
        return view('dashboard.roles.index',compact('data'));
    }

    public function create()
    {
        $data = Permission::get();

        return view('dashboard.roles.create',compact('data'));
    }

    public function edit($id)
    {
       
        $data = Role::find($id);
        $allPermissions = Permission::get();
        $permissionIds = [];
       
        foreach($data->permissions as $item)
        {
            array_push($permissionIds,$item->id);
        }
        return view('dashboard.roles.edit',compact('data','permissionIds','allPermissions'));
    }

    public function update(RoleRequest $request , $id)
    {
        $role = Role::find($id);

        if($this->checkRoleNameUnique($request->name,$id)) return back();
        

        $role->name = $request->name;
        $role->save();

        $allPermissions = Permission::get();
        foreach($allPermissions as $per)
        {
            $role->revokePermissionTo($per);
        }


        foreach($request->permission as $per)
        {
            $chPer = Permission::find($per);
            $role->givePermissionTo($chPer);
        }
        activity()->log('Admin "'.Auth::user()->name.'" updated '. $role->name .' role');
        Alert::toast('Role was updated', 'success');
        return redirect()->route('dashboard.roles.index');
    }
    public function store(RoleRequest $request)
    {
        if($this->checkRoleNameUnique($request->name)) return back();

        $role = Role::create(['name'=>$request->name]);

        foreach($request->permission as $per)
        {
            $chPer = Permission::find($per);
            $role->givePermissionTo($chPer);
        }
        Alert::toast('Role was created', 'success');
        
        activity()->log('Admin "'.Auth::user()->name.'" created "'. $role->name .'" role');

        return redirect()->route('dashboard.roles.index');
    }

    private function checkRoleNameUnique($name , $id = null)
    {
        $role = Role::where(['name'=>$name])->first();
        if($role && $role->id != $id){
            Alert::toast('There is a role with the name '.$name.'', 'error');
            return true;
        };
        return false;
    }

    public function delete($id)
    {
        $role = Role::find($id);
        //$role->users()->detach();
        if(count($role->users) > 0)
        {
            Alert::toast('Please remove all the users belongs to this role to delete it!', 'error');
            activity()->log('Admin "'.Auth::user()->name.'" deleted "'. $role->name .'" role');
            return response()->json([
                'status'=>200,
                'err'=>'please remove all the users belongs to this role to delete it!'
            ],200);
        }
        $role->permissions()->detach();
        $role->delete();
        
        activity()->log('Admin "'.Auth::user()->name.'" created "'. $role->name .'" role');
        return response()->json([
            'status'=>200,
            'msg'=>'role was deleted'
        ],200);
    }
}
