<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\category;
use App\Models\mainimages;
use App\Models\product;
use App\Models\promotion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class CartController extends Controller
{
    //* Page Cart
    public function cart(){
        $user_id = Auth::user()->id;
        // view the cart items
            $carts = \Cart::session($user_id)->getContent();
            $cartTotalQuantity = \Cart::session($user_id)->getTotalQuantity();
            $subTotal = \Cart::session($user_id)->getSubTotal();
            $total = \Cart::session($user_id)->getTotal();
            $count = $carts->count();

            $mainimage = mainimages::selectmainimage()->get();
            $categories = category::selectcategories()->withcategories()->parent()->get();

        return Inertia::render('Cart', [
            "carts" => $carts,
            "cartTotalQuantity" => $cartTotalQuantity,
            "subTotal" => $subTotal,
            "total" => $total,
            "count" => $count,
            "mainimage" => $mainimage,
            "categories" => $categories,
        ]);
    }

    //* Checkout
    public function checkout(){
        $user_id = Auth::user()->id;
        // Checkout Cart
            $carts = \Cart::session($user_id)->getContent();
            foreach($carts as $cart){
                $products[] = $cart->associatedModel->id;
            }
            $cartTotalQuantity = \Cart::session($user_id)->getTotalQuantity();
            $subTotal = \Cart::session($user_id)->getSubTotal();
            $total = \Cart::session($user_id)->getTotal();
            $categories = category::selectcategories()->withcategories()->parent()->get();

        return Inertia::render('checkout', [
            "carts" => $carts,
            "products" => $products,
            "cartTotalQuantity" => $cartTotalQuantity,
            "subTotal" => $subTotal,
            "total" => $total,
            "categories" => $categories,

        ]);
    }

    //* Add product in cart
    public function addtocart($id)
    {
        // Auth::guard('web')->check()
        try{
            $Product = product::findOrFail($id);
            $rowId = time().rand(1,1000);
            $user_id = Auth::user()->id;
            // add the product to cart
            DB::beginTransaction();
            \Cart::session($user_id)->add(array(
                'id' => $rowId,
                'name' => $Product->title,
                'price' => $Product->price,
                'quantity' => '1',
                'attributes' => array(),
                'associatedModel' => $Product
            ));
            DB::commit();
            return redirect()->route('cart');
        }
        catch(\Exception $exception){
            DB::rollBack();
            return redirect()->back();
        }
    }

    public function addcartandquantity(Request $request){
        // return $request;
        try{
            $id = $request->product_id;
            $quantity = $request->quantity;
            $promotion =$request->promotion;
            $Product = product::findOrFail($id);
            $rowId = time().rand(1,1000);
            $user_id = Auth::user()->id;

            // add the product to cart
            DB::beginTransaction();
            \Cart::session($user_id)->add(array(
                'id' => $rowId,
                'name' => $Product->title,
                'price' => $Product->price,
                'quantity' => $quantity,
                'attributes' => array(
                    'promotion' => $promotion,
                ),
                'associatedModel' => $Product
            ));
            DB::commit();
            return redirect()->route('cart');
        }
        catch(\Exception $exception){
            DB::rollBack();
            return redirect()->back();
        }
    }

    //* Add product in cart
    public function store(Request $request, $id)
    {
        try{
            $Product = product::findOrFail($id);
            $rowId = time().rand(1,1000);
            $user_id = Auth::user()->id;

            // add the product to cart
            DB::beginTransaction();
            \Cart::session($user_id)->add(array(
                'id' => $rowId,
                'name' => $Product->title,
                'price' => $Product->price,
                'quantity' => $request->quantity,
                'attributes' => array(),
                'associatedModel' => $Product
            ));
            DB::commit();
            toastr()->success(trans('message.addincart'));
            return redirect()->back();
        }
        catch(\Exception $exception){
            DB::rollBack();
            toastr()->error(trans('message.error'));
            return redirect()->route('category_index');
        }
    }

    public function updatequantity(Request $request){
        try{
            $rowId = $request->id;
            $user_id = Auth::user()->id;
            DB::beginTransaction();
                \Cart::session($user_id)->update($rowId,[
                    'quantity' => $request->quantity
                ]);
            DB::commit();
            return redirect()->back();
        }catch(\Exception $execption){
            DB::rollBack();
            return redirect()->back();
        }
    }

    public function update(Request $request)
    {
        try{
            $rowId = $request->id;
            $user_id = Auth::user()->id;
            DB::beginTransaction();
                \Cart::session($user_id)->update($rowId,[
                    'quantity' => $request->quantity
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

    public function delete($id)
    {
        try{
            $rowId = $id;
            $user_id = Auth::user()->id;
            DB::beginTransaction();
                \Cart::session($user_id)->remove($rowId);
            DB::commit();
            return redirect()->back();
        }catch(\Exception $execption){
            DB::rollBack();
            toastr()->error(trans('message.error'));
            return redirect()->back();
        }
    }

    public function deleteoneproduct($id)
    {
        try{
            $rowId = $id;
            $user_id = Auth::user()->id;
            DB::beginTransaction();
                \Cart::session($user_id)->remove($rowId);
            DB::commit();
            return redirect()->route('cart');
        }catch(\Exception $execption){
            DB::rollBack();
            return redirect()->route('cart');
        }
    }

    public function deleteall(){
        try{
            $user_id = Auth::user()->id;
            DB::beginTransaction();
            \Cart::session($user_id)->clear();
            DB::commit();
            return redirect()->back();
        }catch(\Exception $execption){
            DB::rollBack();
            return redirect()->back();
        }
    }

    public function clearall(){
        try{
            $user_id = Auth::user()->id;
            DB::beginTransaction();
            \Cart::session($user_id)->clear();
            DB::commit();
            return redirect()->back();
        }catch(\Exception $execption){
            DB::rollBack();
            return redirect()->back();
        }
    }
}
