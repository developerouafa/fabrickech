<?php

namespace App\Http\Controllers;

use App\Models\stockproduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StockproductController extends Controller
{
    //* No Exist In Stock
    public function editstocknoexist($id)
    {
        try{
            $stock = stockproduct::findorFail($id);
            DB::beginTransaction();
            $stock->update([
                'stock' => 1,
            ]);
            DB::commit();
            return redirect()->back();
        }catch(\Exception $exception){
            DB::rollBack();
            toastr()->error(trans('message.error'));
            return redirect()->route('product_index');
        }
    }

    //* Exist In Stock
    public function editstockexist($id)
    {
        try{
            $stock = stockproduct::findorFail($id);
            DB::beginTransaction();
            $stock->update([
                'stock' => 0,
            ]);
            DB::commit();
            return redirect()->back();
        }catch(\Exception $exception){
            DB::rollBack();
            toastr()->error(trans('message.error'));
            return redirect()->route('product_index');
        }
    }
}
