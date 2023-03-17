<?php

namespace App\Http\Controllers;

use App\Models\category;
use App\Models\image;
use App\Models\mainimages;
use App\Models\product;
use App\Models\promotion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ShopController extends Controller
{
    //* Welcome
        public function welcome(){
            $categories = category::selectcategories()->withcategories()->parent()->get();
            $products = product::latest()->productselect()->productwith()->limit('4')->get();
            return Inertia::render('Welcome', [
                'categories' => $categories,
                'products' => $products,
            ]);
        }

    //* function index Product
        public function index(Request $request)
        {
            // Products
            $searchproduct = $request->searchproduct;
            $per_page = $request->per_page;
            $defaultshorting = $request->defaultshorting;
            $searchcategory = $request->searchcategory;
            $searchpriceone = $request->searchpriceone;
            $searchpricetwo = $request->searchpricetwo;

            $products = product::productselect()->productwith()
            ->where('status', '0')
            ->when($searchproduct, function($query) use($searchproduct){
                $query->where("title", 'LIKE', '%'.$searchproduct.'%');
                $query->orWhere("price", 'LIKE', '%'.$searchproduct.'%');
            })
            ->when($defaultshorting, function($query) use($defaultshorting){
                if($defaultshorting == '1') {
                    $query->OrderBy('price', 'ASC');
                }
                if($defaultshorting == '2') {
                    $query->OrderBy('price', 'DESC');
                }
                if($defaultshorting == '3') {
                    $query->OrderBy('id', 'DESC');
                }
                if($defaultshorting == '4') {
                    $query->OrderBy('id', 'ASC');
                }
            })
            ->when($searchcategory, function($query) use($searchcategory){
                $query->where("category_id", $searchcategory);
            })
            ->when($searchpriceone, function($query) use($searchpriceone){
                $query->where('price', '>=', $searchpriceone);
            })
            ->when($searchpricetwo, function($query) use($searchpricetwo){
                $query->where('price', '<=', $searchpricetwo);
            })
            ->latest()
            ->paginate($per_page ?? 5);

            // Categories
            $categories = category::query()->selectcategories()->withcategories()->parent()->get();

            return inertia("Shop", [
                "products" => $products,
                "filtres" => $request->all("per_page", "defaultshorting", "searchproduct", "searchcategory", "searchpriceone", "searchpricetwo"),
                'categories' => $categories
            ]);
        }

    //* function index Product
        public function indexbycategory(Request $request)
        {
          // Products
            $searchproduct = $request->searchproduct;
            $per_page = $request->per_page;
            $defaultshorting = $request->defaultshorting;
            $searchcategory = $request->searchcategory;
            $searchpriceone = $request->searchpriceone;
            $searchpricetwo = $request->searchpricetwo;
            $idbycategory = $request->idbycategory;

            $products = product::productselect()->productwith()
            ->where('status', '0')
            ->where("category_id", $idbycategory)
            ->when($searchproduct, function($query) use($searchproduct){
                $query->where("title", 'LIKE', '%'.$searchproduct.'%');
                $query->orWhere("price", 'LIKE', '%'.$searchproduct.'%');
            })
            ->when($defaultshorting, function($query) use($defaultshorting){
                if($defaultshorting == '1') {
                    $query->OrderBy('price', 'ASC');
                }
                if($defaultshorting == '2') {
                    $query->OrderBy('price', 'DESC');
                }
                if($defaultshorting == '3') {
                    $query->OrderBy('id', 'DESC');
                }
                if($defaultshorting == '4') {
                    $query->OrderBy('id', 'ASC');
                }
            })
            ->when($searchcategory, function($query) use($searchcategory){
                $query->where("parent_id", $searchcategory);
            })
            ->when($searchpriceone, function($query) use($searchpriceone){
                $query->where('price', '>=', $searchpriceone);
            })
            ->when($searchpricetwo, function($query) use($searchpricetwo){
                $query->where('price', '<=', $searchpricetwo);
            })
            ->latest()
            ->paginate($per_page ?? 5);

            // Categories
            $categories = category::query()->selectcategories()->withcategories()->child()
            ->where("parent_id", $idbycategory)
            ->get();

            return inertia("shopbycategory", [
                "products" => $products,
                "filtres" => $request->all("per_page", "defaultshorting", "searchproduct", "searchcategory", "searchpriceone", "searchpricetwo"),
                'categories' => $categories,
                'idbycategory' => $idbycategory
            ]);
        }

    //* function index Product
        public function indexbycategoryindex(Request $request)
        {
            // Products
            $searchproduct = $request->searchproduct;
            $per_page = $request->per_page;
            $defaultshorting = $request->defaultshorting;
            $searchcategory = $request->searchcategory;
            $searchpriceone = $request->searchpriceone;
            $searchpricetwo = $request->searchpricetwo;
            $idbycategory = $request->idbycategory;

            $products = product::productselect()->productwith()
            ->where('status', '0')
            ->where("category_id", $idbycategory)
            ->when($searchproduct, function($query) use($searchproduct){
                $query->where("title", 'LIKE', '%'.$searchproduct.'%');
                $query->orWhere("price", 'LIKE', '%'.$searchproduct.'%');
            })
            ->when($defaultshorting, function($query) use($defaultshorting){
                if($defaultshorting == '1') {
                    $query->OrderBy('price', 'ASC');
                }
                if($defaultshorting == '2') {
                    $query->OrderBy('price', 'DESC');
                }
                if($defaultshorting == '3') {
                    $query->OrderBy('id', 'DESC');
                }
                if($defaultshorting == '4') {
                    $query->OrderBy('id', 'ASC');
                }
            })
            ->when($searchcategory, function($query) use($searchcategory){
                $query->where("parent_id", $searchcategory);
            })
            ->when($searchpriceone, function($query) use($searchpriceone){
                $query->where('price', '>=', $searchpriceone);
            })
            ->when($searchpricetwo, function($query) use($searchpricetwo){
                $query->where('price', '<=', $searchpricetwo);
            })
            ->latest()
            ->paginate($per_page ?? 5);

            // Categories
            $categories = category::query()->selectcategories()->withcategories()->child()
            ->where("parent_id", $idbycategory)
            ->get();

            return inertia("shopbycategory", [
                "products" => $products,
                "filtres" => $request->all("per_page", "defaultshorting", "searchproduct", "searchcategory", "searchpriceone", "searchpricetwo"),
                'categories' => $categories,
                'idbycategory' => $idbycategory
            ]);
        }

    //* function view product
        public function view($id){
            $productview = product::productselect()->productwith()->findOrFail($id);
            $maincolor = mainimages::query()->selectmainimage()->where('product_id', $id)->get();
            $color = image::query()->selectimage()->where('product_id', $id)->get();
            $promotion = promotion::select('price')->selectpromotion()->where('product_id', $id)->first();
            $categories = category::selectcategories()->withcategories()->parent()->get();
            return Inertia::render('View', ['productview' => $productview, 'maincolor' => $maincolor, 'color' => $color, 'promotion' => $promotion, 'categories' => $categories]);
        }
}
