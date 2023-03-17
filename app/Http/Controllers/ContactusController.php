<?php

namespace App\Http\Controllers;

use App\Models\category;
use App\Models\contactus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class ContactusController extends Controller
{
    //* function index Contact Us
        public function index()
        {
            $contactus = contactus::query()->get();
            return view('contactus.contactus', compact('contactus'));
        }

    public function contactus()
    {
        $categories = category::selectcategories()->withcategories()->parent()->get();
        return Inertia::render('Contactus', [
            "categories" => $categories
        ]);
    }

    //* Add Message Contact Us
    public function addcontactus(Request $request)
    {
        try{
            DB::beginTransaction();
                contactus::create([
                    "email"=> $request->email,
                    "phone"=> $request->phone,
                    "message"=> $request->message,
                ]);
            DB::commit();
                return redirect()->back();
        }catch(\Exception $execption){
            DB::rollBack();
            return redirect()->back();
        }
    }

    //* fucntion delete Contact Us
    public function delete(Request $request)
    {
        try{
            $id = $request->id;
            $contactus = contactus::findorFail($id);
            DB::beginTransaction();
                $contactus->delete();
            DB::commit();
                toastr()->success(trans('message.delete'));
                return redirect()->route('contactus_index');
        }catch(\Exception $execption){
            DB::rollBack();
                toastr()->error(trans('message.error'));
                return redirect()->route('contactus_index');
        }
    }
}
