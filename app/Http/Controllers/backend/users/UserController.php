<?php

namespace App\Http\Controllers\backend\users;

use App\Http\Controllers\Controller;
use App\Models\ImageUser;
use App\Models\profileusers;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
class UserController extends Controller
{
    public function index(Request $request)
    {
        $data = User::orderBy('id','DESC')->where('admin', '0')->with('profileuser')->paginate(5);
        return view('users.show_users',compact('data'))->with('i', ($request->input('page', 1) - 1) * 5);
    }
    public function create()
    {
        $roles = Role::pluck('name','name')->all();
        return view('users.Add_user',compact('roles'));
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password',
            'roles_name' => 'required',
            'firstname' => 'required',
            'firstnamear' => 'required',
            'lastname' => 'required',
            'lastnamear' => 'required',
            ]);
        try{
            DB::beginTransaction();
                $input = $request->all();
                $input['password'] = Hash::make($input['password']);
                $user = User::create($input);
                $user->assignRole($request->input('roles_name'));

                $user_id = User::latest()->first()->id;
                profileusers::create([
                    'user_id' => $user_id,
                    'firstname' => ['en' => $request->firstname, 'ar' => $request->firstnamear],
                    'lastname' => ['en' => $request->lastname, 'ar' => $request->lastnamear],
                    'designation' => ['en' => 'null', 'ar' => 'فارغ'],
                    'website' => 'null',
                    'Address' => 'null',
                    'twitter' => 'null',
                    'facebook' => 'null',
                    'google' => 'null',
                    'linkedin' => 'null',
                    'github' => 'null',
                    'biographicalinfo' => 'null',
                    'fullname' => 'null',
                    'town' => 'null',
                    'city' => 'null',
                    'region' => 'null',
                    'country' => 'null',
                    'streetaddress' => 'null',
                    'zipcode' => 'null',
                    'phone' => 'null',
                ]);
            DB::commit();
            toastr()->success(trans('message.create'));
            return redirect()->route('users.index');
        }catch(\Exception $execption){
            DB::rollBack();
            toastr()->error(trans('message.error'));
            return redirect()->route('users.index');
        }
    }
    public function show($id)
    {
        $user = User::find($id);
        return view('users.show',compact('user'));
    }
    public function edit($id)
    {
        $user = User::find($id);
        $roles = Role::pluck('name','name')->all();
        $userRole = $user->roles->pluck('name','name')->all();
        return view('users.edit',compact('user','roles','userRole'));
    }
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'email' => 'required|email|unique:users,email,'.$id,
            'password' => 'same:confirm-password',
            'roles' => 'required',
            'firstname_'.app()->getLocale() => 'required',
            'lastname_'.app()->getLocale() => 'required',
            ]);
        try{
            DB::beginTransaction();
                $user = User::find($id);

                $password = $user->password;
                $input = $request->all();
                if(!empty($input['password'])){
                    $input['password'] = Hash::make($input['password']);
                }else{
                    $input['password'] = $password;
                }

                $user->update($input);
                DB::table('model_has_roles')->where('model_id',$id)->delete();
                $user->assignRole($request->input('roles'));

                if(App::isLocale('en')){
                    $profileuser = profileusers::findOrFail($request->idprofile);
                    $profileuser->update([
                        'firstname' => $request->firstname_en,
                        'lastname' => $request->lastname_en,
                    ]);
                }
                elseif(App::isLocale('ar')){
                    $profileuser = profileusers::findOrFail($request->idprofile);
                    $profileuser->update([
                        'firstname' => $request->firstname_ar,
                        'lastname' => $request->lastname_ar,
                    ]);
                }

            DB::commit();
            toastr()->success(trans('message.update'));
            return redirect()->route('users.index');
        }catch(\Exception $execption){
            DB::rollBack();
            toastr()->error(trans('message.error'));
            return redirect()->route('users.index');
        }
    }
    public function destroy(Request $request)
    {
        try{
            $id = $request->user_id;

            $tableimageuser = ImageUser::where('user_id',$id)->first();
            $image = $tableimageuser->image;
            if(!$image) abort(404);
            unlink(public_path('storage/'.$image));

            DB::beginTransaction();
            User::find($id)->delete();

            DB::commit();
            toastr()->success(trans('message.delete'));
            return redirect()->route('users.index');
        }catch(\Exception $execption){
            DB::rollBack();
            toastr()->error(trans('message.error'));
            return redirect()->route('users.index');
        }
    }
}
