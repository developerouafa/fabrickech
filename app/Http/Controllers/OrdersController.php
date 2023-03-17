<?php

namespace App\Http\Controllers;

use App\Mail\Order;
use App\Models\Buying_Selling_Bulk;
use App\Models\category;
use App\Models\orders;
use App\Models\orders_products;
use App\Models\product;
use App\Models\profileusers;
use App\Models\statusorder;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Inertia\Inertia;

class OrdersController extends Controller
{
    public function index()
    {
        $orders = orders_products::selecordersproducts()->get();
        $user = User::with('profileuser')->get();
        $statusorder = statusorder::selecstatusorder()->get();
        $products = product::query()->productselect()->productwith()->get();
        return view('orders.orders', compact('orders', 'user', 'statusorder', 'products'));
    }

    public function store(Request $request)
    {
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
        ]);
        try{
            DB::beginTransaction();
            orders::create([
                'user_id' => Auth::user()->id,
                'total' => $request->total,
                'statusorder_id' => '1',
            ]);

            $orders = orders::latest()->first()->id;
            $user = Auth::user()->id;
            $address = profileusers::findOrFail($user);

                $address->update([
                    'fullname' => $request->fullname,
                    'town' => $request->town,
                    'city' => $request->city,
                    'region' => $request->region,
                    'country' => 'Morroco',
                    'streetaddress' => $request->streetaddress,
                    'zipcode' => $request->zipcode,
                    'phone' => $request->phone,
                ]);

                orders_products::create([
                    'orders_id' => $orders,
                    'products' => $request->carts,
                    'quantity' => $request->cartTotalQuantity,
                    'total' => $request->total,
                ]);

            //* Notification Order
            // if($request->cartTotalQuantity >= '30'){
                $bulks = Buying_Selling_Bulk::with('user')->get();
                    foreach($bulks as $bulk){
                        Mail::to($bulk->user->email)->send(new Order($bulk->user->email, $orders, $request->cartTotalQuantity, $request->total
                    ));
                }
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
                $statusorders = orders::findOrFail($idorder);
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
                orders::findorFail($id)->delete();
                DB::commit();
                toastr()->success(trans('message.delete'));
                return redirect()->back();
            }catch(\Exception $execption){
                DB::rollBack();
                toastr()->error(trans('message.error'));
                return redirect()->back();
            }
        }

    //* function index Orders_Status
        public function ordersproduct($id)
        {
            $ordersproducts = orders::query()->selecorder()->where('statusorder_id', $id)->get();
            $statusorder = statusorder::selecstatusorder()->get();
            $products = product::query()->productselect()->productwith()->get();
            return view('ordersproduct.ordersproduct',compact('ordersproducts', 'statusorder', 'products'));
        }
}
