<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\category;
use App\Models\image;
use App\Models\mainimages;
use App\Models\Post;
use App\Models\product;
use App\Models\product_color;
use App\Models\promotion;
use App\Models\size;
use App\Models\stockproduct;
use App\Models\User;
use App\Notifications\productntf;
use App\Traits\UploadImageTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

class ProductController extends Controller
{
    use UploadImageTrait;

    //* function index Product
    public function index()
    {
        $products = product::query()->productselect()->productwith()->filter()->get();
        $childrens = category::query()->selectchildrens()->withchildrens()->child()->get();
        $categories = category::query()->selectcategories()->withcategories()->parent()->get();
        $stockproduct = stockproduct::selectstock()->get();
        return view('products.products', compact('products', 'categories', 'childrens', 'stockproduct'));
    }

    //* Hide Product
    public function editstatusdéactive($id)
    {
        try{
            $product = Product::findorFail($id);
            DB::beginTransaction();
            $product->update([
                'status' => 1,
            ]);
            DB::commit();
            return redirect()->back();
        }catch(\Exception $exception){
            DB::rollBack();
            toastr()->error(trans('message.error'));
            return redirect()->route('product_index');
        }
    }

    //* Show Product
    public function editstatusactive($id)
    {
        try{
            $product = Product::findorFail($id);
            DB::beginTransaction();
            $product->update([
                'status' => 0,
            ]);
            DB::commit();
            return redirect()->back();
        }catch(\Exception $exception){
            DB::rollBack();
            toastr()->error(trans('message.error'));
            return redirect()->route('product_index');
        }
    }

    //* Create Product
    public function create()
    {
        $products = product::query()->productselect()->productwith()->get();
        $childrens = category::query()->selectchildrens()->withchildrens()->child()->get();
        $categories = category::query()->selectcategories()->withcategories()->parent()->get();
        return view('products.productscreate', compact('products', 'categories', 'childrens'));
    }

    //* function create other Product
    public function store(Request $request)
    {
        // validations
        $this->validate($request, [
            'title_en' => 'required|unique:products,title->en',
            'title_ar' => 'required|unique:products,title->ar',
            'description_en' => 'required',
            'description_ar' => 'required',
            'image' => 'required',
            'Category'  => 'required',
            'children'  => 'required',
            'price' => 'required|between:1,99999999999999',
            'color' => 'required',
            'width' => 'required',
            'height' => 'required',
        ],[
            'title_en.required' =>__('messagevalidation.users.titleenrequired'),
            'title_en.unique' =>__('messagevalidation.users.titleaddenunique'),
            'title_ar.required' =>__('messagevalidation.users.titlearrequired'),
            'title_ar.unique' =>__('messagevalidation.users.titleaddarunique'),
            'description_en.required' =>__('messagevalidation.users.bodyenrequired'),
            'description_ar.required' =>__('messagevalidation.users.bodyarrequired'),
            'image.required' =>__('messagevalidation.users.imagerequired'),
            'Category.required' =>__('messagevalidation.users.categoryrequired'),
            'children.required' =>__('messagevalidation.users.childrenrequired'),
            'price.required' =>__('messagevalidation.users.priceisrequired'),
            'price.between' =>__('messagevalidation.users.priceislow'),
            'width.required' =>__('messagevalidation.users.widthisrequired'),
            'height.required' =>__('messagevalidation.users.heightisrequired')
        ]);
        try{
            //Added photo
            if($request->has('image')){
                DB::beginTransaction();
                product::create([
                    'title' => ['en' => $request->title_en, 'ar' => $request->title_ar],
                    'description' => ['en' => $request->description_en, 'ar' => $request->description_ar],
                    'category_id' => $request->Category,
                    'parent_id' => $request->children,
                    'status' => 0,
                    'price' => $request->price
                ]);

                product_color::create([
                    'color'=>$request->color
                ]);

                $product_id = product::latest()->first()->id;
                $product_color_id = product_color::latest()->first()->id;

                $image = $this->uploadImageproducts($request, 'fileproducts');

                    mainimages::create([
                        'product_id'=> $product_id,
                        'mainimage'=> $image,
                        'product_color_id' => $product_color_id
                    ]);

                    stockproduct::create([
                        'product_id'=> $product_id
                    ]);

                $size = new size();
                $size->product_id = $product_id;
                $size->height = $request->height;
                $size->width = $request->width;
                $size->save();

                //* Notification database Product
                $users = User::where('id', '!=', Auth::user()->id)->get();
                $notif = product::latest()->first();

                Notification::send($users, new productntf($notif));

                DB::commit();
                toastr()->success(trans('message.create'));
                return redirect()->route('product_index');
            }
            // No Added photo
            else{
                toastr()->error(trans('messagevalidation.users.imagerequired'));
                return redirect()->route('product_index');
            }
        }
        catch(\Exception $exception){
            DB::rollBack();
            toastr()->error(trans('message.error'));
            return redirect()->route('product_index');
        }
    }

    //* function ipdate Product
    public function update(Request $request)
    {
        $this->validate($request, [
            'title_'.app()->getLocale() => 'required|unique:products,title->'.app()->getLocale().','.$request->id,
            'description_'.app()->getLocale() => 'required',
            'price' => 'required|between:1,99999999999999',
            'Category'  => 'required',
            'children'  => 'required',
        ],[
            'title_'.app()->getLocale().'.required' =>__('messagevalidation.users.titlerequired'),
            'title_'.app()->getLocale().'.unique' =>__('messagevalidation.users.titlunique'),
            'description_'.app()->getLocale().'.required' =>__('messagevalidation.users.bodyrequired'),
            'price.required' =>__('messagevalidation.users.priceisrequired'),
            'price.between' =>__('messagevalidation.users.priceislow'),
            'Category.required' =>__('messagevalidation.users.categoryrequired'),
            'children.required' =>__('messagevalidation.users.childrenrequired')
        ]);
        try{
            $product = $request->id;
            $productupdate = product::findOrFail($product);
                DB::beginTransaction();
                if(App::isLocale('en')){
                    $productupdate->update([
                        'title' => $request->title_en,
                        'description' => $request->description_en,
                        'price' => $request->price,
                        'category_id' => $request->Category,
                        'parent_id' => $request->children
                    ]);
                }
                elseif(App::isLocale('ar')){
                    $productupdate->update([
                        'title' => $request->title_ar,
                        'description' => $request->description_ar,
                        'price' => $request->price,
                        'category_id' => $request->Category,
                        'parent_id' => $request->children
                    ]);
                }
                DB::commit();
                toastr()->success(trans('message.update'));
                return redirect()->route('product_index');
        }catch(\Exception $execption){
            DB::rollBack();
            toastr()->error(trans('message.error'));
            return redirect()->route('product_index');
        }
    }

    //* function delete Product
    public function delete(Request $request)
    {
        try{
            $id = $request->id;
            $images  = image::where('product_id',$id)->get();
            foreach($images as $x){
                if(!$x->multimg) abort(404);
                unlink(public_path('storage/'.$x->multimg));
            }

            $image  = mainimages::where('product_id',$id)->get();
            foreach($image as $x){
                if(!$x->mainimage) abort(404);
                unlink(public_path('storage/'.$x->mainimage));
            }

            $product = product::findorFail($id);
            DB::beginTransaction();
            $product->delete();
            DB::commit();
            toastr()->success(trans('message.delete'));
            return redirect()->route('product_index');
        }catch(\Exception $execption){
            DB::rollBack();
            toastr()->error(trans('message.error'));
            return redirect()->route('product_index');
        }
    }

    //* Details|products notification
    public function detailsproducts($id){
        $products = product::query()->where('id', $id)->productwith()->first();
        $images  = image::selectimage()->where('product_id',$id)->get();
        $sizes = size::query()->selectsize()->where('product_id', $id)->with('product')->get();
        $getID = DB::table('notifications')->where('data->idproduct', $id)->pluck('id');
        $promotion = promotion::query()->where('product_id', $id)->withPromotion()->get();
        $multimg  = image::selectimage()->where('product_id',$id)->get();
        $images  = mainimages::selectmainimage()->where('product_id',$id)->get();
        DB::table('notifications')->where('id', $getID)->update(['read_at'=>now()]);
        return view('products_ntf.product_detailsntf', compact('products', 'images', 'sizes', 'promotion', 'multimg', 'images'));
    }

    //* Details|products
    public function page_details($id){
        $products = product::query()->where('status','=','0')->where('id', $id)->productwith()->first();
        $images  = image::selectimage()->where('product_id',$id)->get();
        $promotion = promotion::query()->where('product_id', $id)->withPromotion()->get();
        $sizes = size::query()->selectsize()->where('product_id', $id)->with('product')->get();
        return view('products_ntf.product_detailsntf', compact('products', 'images', 'promotion', 'sizes'));
    }
}
