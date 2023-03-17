<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Buying_Selling_Bulk;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BuyingSellingBulkController extends Controller
{
    //* function Display Person Bulk
    public function index()
    {
        $users = User::where('admin', '0')->with('Buying_Selling_Bulk')->get();
        $bulks = Buying_Selling_Bulk::with('user')->get();
        return view('bulk.bulk', compact('users', 'bulks'));
    }

    //* function Store Person Bulk
    public function store(Request $request)
    {
        // validations
        $this->validate($request, [
            'user' => 'required|unique:buying__selling__bulks,user_id',
        ]);
        try{
            DB::beginTransaction();
            Buying_Selling_Bulk::create([
                'user_id' => $request->user,
            ]);
            DB::commit();
            toastr()->success(trans('message.create'));
            return redirect()->route('bulk_index');
        }
        catch(\Exception $exception){
            DB::rollBack();
            toastr()->error(trans('message.error'));
            return redirect()->route('bulk_index');
        }
    }

    //* function delete Person Bulk
    public function delete(Request $request)
    {
        try{
            $id = $request->id;
            DB::beginTransaction();
            Buying_Selling_Bulk::findorFail($id)->delete();
            DB::commit();
            toastr()->success(trans('message.delete'));
            return redirect()->route('bulk_index');
        }catch(\Exception $execption){
            DB::rollBack();
            toastr()->error(trans('message.error'));
            return redirect()->route('bulk_index');
        }
    }
}
