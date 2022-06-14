<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Models\User;
use App\Http\Requests\AdminRequest;
use App\Http\Requests\AdminUpdateRequest;
use App\Http\Requests\SuperAdminRequest;
use Alert;
use Auth;

class AdminController extends Controller
{
    public function index()
    {
        $data = User::with('roles')->whereHas('roles')->where('id','!=',1)->orderBy('created_at','desc')->paginate(10);
        return view('dashboard.admins.index',compact('data'));
    }

    public function create()
    {
        $roles = Role::where('id','!=',1)->get();
        
        return view('dashboard.admins.create',compact('roles'));
    }

    public function store(AdminRequest $request)
    {

        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();
        $role = Role::find($request->role);
        $user->assignRole($role);
        activity()->log('Admin "'.Auth::user()->name.'" created '. $user->name .' admin');
        Alert::toast('Admin was created', 'success');

        return redirect()->route('dashboard.admins.index');
    }

    public function edit($id)
    {
        $data = User::find($id);
        $roles = Role::where('id','!=',1)->get();
        return view('dashboard.admins.edit',compact('data','roles'));
    }

    public function update(AdminUpdateRequest $request,$id)
    {
        if($this->checkAdminEmailUnique($request->email,$id)) return back();

        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        if($request->password) $user->password = bcrypt($request->password);
        $user->save();
        $user->syncRoles([]);
        $role = Role::find($request->role);
        $user->assignRole($role);

        activity()->log('Admin "'.Auth::user()->name.'" updated "'. $user->name .'" admin');
        Alert::toast('Admin was updated', 'success');

        return redirect()->route('dashboard.admins.index');
    }
    public function updateSuperAdmin(SuperAdminRequest $request)
    {
        if($this->checkAdminEmailUnique($request->email,1)) return back();

        $user = User::find(1);
        $user->name = $request->name;
        $user->email = $request->email;
        if($request->password) $user->password = bcrypt($request->password);
        $user->save();
        if($request->hasFile('image'))
        {
            $user->clearMediaCollection('admin');
            $user->addMedia($request->file('image'))
            ->toMediaCollection('admin');
        }
        activity()->log('Super admin data was updated');
        Alert::toast('Super admin was updated', 'success');

        return back();
    }

    private function checkAdminEmailUnique($email , $id = null)
    {
        $role = User::where(['email'=>$email])->first();
        if($role && $role->id != $id){
            Alert::toast('There is an admin with the email '.$email.'', 'error');
            return true;
        };
        return false;
    }

    public function delete($id)
    {
        $data = User::find($id);
        if(!$data) return response()->json([
            'msg'=>'admin not found',
            'status'=> 200
        ]);
        $data->syncRoles([]);
        activity()->log('Admin "'.Auth::user()->name.'" deleted "'. $data->name .'" admin');
        $data->delete();
        Alert::toast('Admin was deleted', 'success');

        return response()->json([
            'msg'=>'admin was deleted',
            'status'=>200
        ]);
    }

    public function editSuperAdmin()
    {
        $data = User::find(1);
        return view('dashboard.admins.editSuperAdmin',compact('data'));
    }
}
