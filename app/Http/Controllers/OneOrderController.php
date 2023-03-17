<?php

namespace App\Http\Controllers;

use App\Models\Buying_Selling_Bulk;
use App\Models\category;
use App\Models\OneOrder;
use App\Models\product;
use App\Models\statusorder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Inertia\Inertia;

class OneOrderController extends Controller
{
    //* Function Index One Order
        public function index()
        {
            $orders = OneOrder::seleconeorder()->get();
            $statusorder = statusorder::selecstatusorder()->get();
            $products = product::query()->productselect()->productwith()->get();
            return view('orders.oneorder', compact('orders', 'statusorder', 'products'));
        }

    //* function Store One Order
        public function store(Request $request)
        {
            $total = $request->quantity * $request->price;
            $categories = category::selectcategories()->withcategories()->parent()->get();

            // validations
            $this->validate($request, [
                'fullname' => 'required',
                'town' => 'required',
                'city' => 'required',
                'region' => 'required',
                'streetaddress' => 'required',
                'zipcode' => 'required',
                'phone' => 'required',
                'quantity' => 'required',
            ]);
            try{
                DB::beginTransaction();
                OneOrder::create([
                    'fullname' => $request->fullname,
                    'town' => $request->town,
                    'city' => $request->city,
                    'region' => $request->region,
                    'streetaddress' => $request->streetaddress,
                    'zipcode' => $request->zipcode,
                    'phone' => $request->phone,
                    'products' => $request->products,
                    'quantity' => $request->quantity,
                    'total' => $total,
                    'statusorder_id' => '1',
                ]);

                //* Notification Order
                // if($request->cartTotalQuantity >= '30'){
                //     $bulks = Buying_Selling_Bulk::with('user')->get();
                //         foreach($bulks as $bulk){
                //             Mail::to($bulk->user->email)->send(new Order($bulk->user->email, $orders, $request->cartTotalQuantity, $request->total
                //         ));
                //     }
                // }

                DB::commit();
                return Inertia::render('order-complete', ["categories" => $categories,]);

            }
            catch(\Exception $exception){
                DB::rollBack();
                return redirect()->back();
            }
        }

    //* function update Status Order
        public function update(Request $request)
        {
            // validations
            $this->validate($request, [
                'status' => 'required',
            ]);
            try{
                $idorder = $request->id;
                $status = $request->status;
                $statusorders = OneOrder::findOrFail($idorder);
                    DB::beginTransaction();
                        $statusorders->update([
                            'statusorder_id' => $status
                        ]);
                    DB::commit();
                    toastr()->success(trans('message.update'));
                    return redirect()->back();
            }catch(\Exception $execption){
                DB::rollBack();
                toastr()->error(trans('message.error'));
                return redirect()->back();
            }
        }

    //* function delete Order
        public function delete(Request $request)
        {
            try{
                $id = $request->id;
                DB::beginTransaction();
                OneOrder::findorFail($id)->delete();
                DB::commit();
                toastr()->success(trans('message.delete'));
                return redirect()->back();
            }catch(\Exception $execption){
                DB::rollBack();
                toastr()->error(trans('message.error'));
                return redirect()->back();
            }
        }

    //* function index One_Orders_Status
        public function oneorderproduct($id)
        {
            $ordersproducts = OneOrder::query()->seleconeorder()->where('statusorder_id', $id)->get();
            $statusorder = statusorder::selecstatusorder()->get();
            $products = product::query()->productselect()->productwith()->get();
            return view('ordersproduct.onorderproduct',compact('ordersproducts', 'statusorder', 'products'));
        }
}
