<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\EmailUpdateRequest;
use App\Http\Requests\ProfileUpdateRequest;
use App\Models\profileusers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class ProfileController extends Controller
{
    //* function Edit Information User
    public function editbackend(Request $request)
    {
        $id = Auth::user()->id;
        $imageuser = User::query()->select('id')->where('id', '=', $id)->with('image')->with('profileuser')->get();
        return view('profile.edit', ['user' => $request->user(),], compact('imageuser'));
    }

    //* function Update Information User
    public function updateprofilebackend(ProfileUpdateRequest $request)
    {
        try{
            $id = $request->profileid;
            $user_id = $request->user_id;
            $profileusers = profileusers::findOrFail($id);
                    DB::beginTransaction();
                    if(App::isLocale('en')){
                        $profileusers->update([
                            'user_id' => $user_id,
                            'firstname' =>  $request->firstname_en,
                            'lastname' => $request->lastname_en,
                            'designation' => $request->designation_en,
                            'website' => $request->website,
                            'phone' => $request->phone,
                            'Address' => $request->address,
                            'twitter' => $request->twitter,
                            'facebook' => $request->facebook,
                            'google' => $request->google,
                            'linkedin' => $request->linkedin,
                            'github' => $request->github,
                            'biographicalinfo' => $request->biographicalinfo,
                        ]);
                    }
                    elseif(App::isLocale('ar')){
                        $profileusers->update([
                            'user_id' => $user_id,
                            'firstname' =>  $request->firstname_ar,
                            'lastname' => $request->lastname_ar,
                            'designation' => $request->designation_ar,
                            'website' => $request->website,
                            'phone' => $request->phone,
                            'Address' => $request->Address,
                            'twitter' => $request->twitter,
                            'facebook' => $request->facebook,
                            'google' => $request->google,
                            'linkedin' => $request->linkedin,
                            'github' => $request->github,
                            'biographicalinfo' => $request->biographicalinfo,
                        ]);
                    }
                    DB::commit();
                    toastr()->success(trans('message.update'));
                    return redirect()->route('profile.editbackend');
        }catch(\Exception $execption){
            DB::rollBack();
            toastr()->error(trans('message.error'));
            return redirect()->route('profile.editbackend');
        }

        // try{
        //     DB::beginTransaction();
        //     $request->user()->fill($request->validated());

        //     $request->user()->save();
        //     DB::commit();
        //     toastr()->success(trans('message.update'));
        //     return redirect()->route('profile.edit');
        // }catch(\Exception $execption){
        //     DB::rollBack();
        //     toastr()->error(trans('message.error'));
        //     return redirect()->route('profile.edit');
        // }
    }

}
