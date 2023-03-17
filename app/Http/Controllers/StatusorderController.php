<?php

namespace App\Http\Controllers;

use App\Models\statusorder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class StatusorderController extends Controller
{
    public function index()
    {
        $statusorder = statusorder::get();
        return view('statusorder.statusorder', compact('statusorder'));
    }

    public function store(Request $request)
    {
        // validations
        $this->validate($request, [
            'status_en' => 'required|unique:statusorders,status->en',
            'status_ar' => 'required|unique:statusorders,status->ar',
        ],[
            'status_en.required' =>__('messagevalidation.users.titleenrequired'),
            'status_en.unique' =>__('messagevalidation.users.titleaddenunique'),
            'status_ar.required' =>__('messagevalidation.users.titlearrequired'),
            'status_ar.unique' =>__('messagevalidation.users.titleaddarunique'),
        ]);
        try{
            DB::beginTransaction();
            statusorder::create([
                'status' => ['en' => $request->status_en, 'ar' => $request->status_ar]
            ]);
            DB::commit();
            toastr()->success(trans('message.create'));
            return redirect()->route('statusoreder_index');
        }
        catch(\Exception $exception){
            DB::rollBack();
            toastr()->error(trans('message.error'));
            return redirect()->route('statusoreder_index');
        }
    }

    //* function update Tag
        public function update(Request $request)
        {
            // validations
            $this->validate($request, [
                'status_'.app()->getLocale() => 'required|unique:statusorders,status->'.app()->getLocale().','.$request->id,
            ],[
                'status_'.app()->getLocale().'.required' =>__('messagevalidation.users.titlerequired'),
                'status_'.app()->getLocale().'.unique' =>__('messagevalidation.users.titlunique')
            ]);
            try{
                $statusorder = $request->id;
                $statusorders = statusorder::findOrFail($statusorder);
                    DB::beginTransaction();
                    if(App::isLocale('en')){
                        $statusorders->update([
                            'status' => $request->status_en
                        ]);
                    }
                    elseif(App::isLocale('ar')){
                        $statusorders->update([
                            'status' => $request->status_er
                        ]);
                    }
                    DB::commit();
                    toastr()->success(trans('message.update'));
                    return redirect()->route('statusoreder_index');
            }catch(\Exception $execption){
                DB::rollBack();
                toastr()->error(trans('message.error'));
                return redirect()->route('statusoreder_index');
            }
        }

    //* function delete Order Status
        public function delete(Request $request)
        {
            try{
                $id = $request->id;
                DB::beginTransaction();
                statusorder::findorFail($id)->delete();
                DB::commit();
                toastr()->success(trans('message.delete'));
                return redirect()->route('statusoreder_index');
            }catch(\Exception $execption){
                DB::rollBack();
                toastr()->error(trans('message.error'));
                return redirect()->route('statusoreder_index');
            }
        }
}
