<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\image;
use App\Models\mainimages;
use App\Models\product;
use App\Models\product_color;
use App\Traits\UploadImageTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ImageController extends Controller
{
    use UploadImageTrait;
    //* function Index Image
    public function index($id)
    {
        $Product = product::where('id',$id)->firstOrFail();
        $multimg  = image::selectimage()->where('product_id',$id)->get();
        $images  = mainimages::selectmainimage()->where('product_id',$id)->get();
        return view('images.images',compact('Product', 'multimg','images'));
    }

    //* function store Image
    public function store(Request $request)
    {
        // validations
        $this->validate($request, [
            'image' => 'required',
            'color' => 'required',
        ],[
            'image.required' =>__('messagevalidation.users.imagerequired'),
            'color.required' =>__('messagevalidation.users.colorrequired'),
        ]);
        try{
            //Added photo
            if($request->has('image')){
                DB::beginTransaction();
                product_color::create([
                    'color'=>$request->color
                ]);

                $product_color_id = product_color::latest()->first()->id;

                $image = $this->uploadImageproducts($request, 'fileproducts');

                        image::create([
                            'product_id' => $request->product_id,
                            'product_color_id' => $product_color_id,
                            'multimg' => $image
                        ]);
                    DB::commit();
                    toastr()->success(trans('message.create'));
                    return redirect()->back();
            }
            // No Add photo
            else{
                toastr()->error(trans('messagevalidation.users.imagerequired'));
                return redirect()->back();
            }
        }
        catch(\Exception $exception){
            DB::rollBack();
            toastr()->error(trans('message.error'));
            return redirect()->back();
        }
    }

    //* function edit Image
    public function edit(Request $request)
    {
                // validations
                $this->validate($request, [
                    'image' => 'required',
                    'color' => 'required',
                ],[
                    'image.required' =>__('messagevalidation.users.imagerequired'),
                    'color.required' =>__('messagevalidation.users.colorrequired'),
                ]);
        try{
            $idcolor = $request->colorid;

            $colorid = product_color::findOrFail($idcolor);

            $colorid->update([
                'color' => $request->color
            ]);

            $id = $request->id;
            $mainimage = mainimages::findOrFail($id);
            if($request->has('image')){
                $image = $mainimage->mainimage;
                if(!$image) abort(404);
                unlink(public_path('storage/'.$image));
                $image = $this->uploadImageproducts($request, 'fileproducts');
                DB::beginTransaction();
                    $mainimage->update([
                        'mainimage' => $image
                    ]);

                DB::commit();
                toastr()->success(trans('message.update'));
                return redirect()->back();
            }
        }catch(\Exception $execption){
            DB::rollBack();
            toastr()->error(trans('message.error'));
            return redirect()->back();
        }
    }

    //* function delete Image
    public function delete(Request $request)
    {
        try{
            $id = $request->id;
            $img = image::findorFail($id);
            DB::beginTransaction();
                $img->delete();
                $image = $img->multimg;
                if(!$image) abort(404);
                unlink(public_path('storage/'.$image));
            DB::commit();
                toastr()->success(trans('message.delete'));
                return redirect()->back();
        }catch(\Exception $execption){
            DB::rollBack();
            toastr()->error(trans('message.error'));
            return redirect()->back();
        }
    }
}
