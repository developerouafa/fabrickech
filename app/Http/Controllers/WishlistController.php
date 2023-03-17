<?php

namespace App\Http\Controllers;

use App\Models\category;
use App\Models\mainimages;
use App\Models\product;
use App\Models\wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class WishlistController extends Controller
{
    //* function display Product In wishlist
    public function wishlist()
    {
        $user_id = Auth::user()->id;
            $wishlists = wishlist::latest()->where('user_id', $user_id)->paginate('5');
            $mainimage = mainimages::selectmainimage()->get();
            $products = product::query()->productselect()->productwith()->get();
            $categories = category::selectcategories()->withcategories()->parent()->get();

        return Inertia::render('Wishlist', [
            "wishlists" => $wishlists,
            "mainimage" => $mainimage,
            "products" => $products,
            "categories" => $categories,
        ]);
    }

    //* function Add Product In wishlist
    public function addwishlist($id)
    {
        $product_id = $id;
        $wishlists = wishlist::where('product_id', $id)->first();
        if($wishlists){
            return redirect()->route('wishlist');
        }
        else{
            try{
                    DB::beginTransaction();
                    wishlist::create([
                        'product_id' => $product_id,
                        'user_id' => Auth::user()->id
                    ]);
                    DB::commit();
                    return redirect()->route('wishlist');
            }
            catch(\Exception $exception){
                DB::rollBack();
                return redirect()->back();
            }
        }
    }

    //* function delete Product In wishlist
    public function deleteonewishlist($id)
    {
        try{
            $wishlist = wishlist::findorFail($id);
            DB::beginTransaction();
                $wishlist->delete();
            DB::commit();
            return redirect()->back();
        }catch(\Exception $execption){
            DB::rollBack();
            toastr()->error(trans('message.error'));
            return redirect()->back();
        }
    }
}
