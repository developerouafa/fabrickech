<?php

namespace App\Http\Controllers;

use App\Models\subscribe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class SubscribeController extends Controller
{
    //* function Subscribe 
    public function subscribe(Request $request)
    {
        // validations
        $this->validate($request, [
            'email' => 'required|unique:subscribes,email',
        ]);
        try{
            DB::beginTransaction();
                subscribe::create([
                    "email"=> $request->email,
                ]);
            DB::commit();
                return redirect()->back();
        }catch(\Exception $execption){
            DB::rollBack();
            return redirect()->back();
        }
    }
}
