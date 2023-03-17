<?php

use App\Http\Controllers\backend\BuyingSellingBulkController;
use App\Http\Controllers\backend\CartController;
use App\Http\Controllers\backend\roles\RolesController;
use App\Http\Controllers\backend\users\UserController;
use App\Http\Controllers\backend\CategoryController;
use App\Http\Controllers\backend\ChildrenCatController;
use App\Http\Controllers\backend\ImageController;
use App\Http\Controllers\backend\ImageUserController;
use App\Http\Controllers\backend\PostController;
use App\Http\Controllers\backend\PostTagController;
use App\Http\Controllers\backend\ProductColorController;
use App\Http\Controllers\backend\ProductController;
use App\Http\Controllers\backend\PromotionController;
use App\Http\Controllers\backend\SizeController;
use App\Http\Controllers\backend\TagController;
use App\Http\Controllers\ContactusController;
use App\Http\Controllers\OneOrderController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\StatusorderController;
use App\Http\Controllers\StockproductController;
use App\Http\Controllers\SubscribeController;
use App\Http\Controllers\WishlistController;
use App\Models\category;
use App\Models\orders;
use App\Models\Post;
use App\Models\product;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

    // Backend
    Route::group(['prefix' => LaravelLocalization::setLocale(), 'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'xss', 'UserStatus']], function(){
        //* The first page in the dashboard Admin
            Route::get('/admin', function () {
                return view('auth.login');
            })->name('admin');
            // use App\Models\product;

        //* The first page in the dashboard after logging in
            Route::get('/dashboardbackend', function () {
                if(Auth::guard('web')->check()){
                    if(Auth::user()->Status == "1" && Auth::user()->admin == "0"){
                        //* Start Statistical
                            $chartjs = app()->chartjs
                            ->name('barChartTest')
                            ->type('bar')
                            ->size(['width' => 1000, 'height' => 400])
                            ->labels(['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'])
                            ->datasets([
                                [
                                    "label" => "Orders",
                                    'backgroundColor' => "rgba(38, 185, 154, 0.31)",
                                    'borderColor' => "rgba(38, 185, 154, 0.7)",
                                    "pointBorderColor" => "rgba(38, 185, 154, 0.7)",
                                    "pointBackgroundColor" => "rgba(38, 185, 154, 0.7)",
                                    "pointHoverBackgroundColor" => "#fff",
                                    "pointHoverBorderColor" => "rgba(220,220,220,1)",
                                    'data' => [orders::whereYear('created_at', now()->format('Y'))->whereMonth('created_at', '=', '1')->count(), orders::whereYear('created_at', now()->format('Y'))->whereMonth('created_at', '=', '2')->count(), orders::whereYear('created_at', now()->format('Y'))->whereMonth('created_at', '=', '3')->count(), orders::whereYear('created_at', now()->format('Y'))->whereMonth('created_at', '=', '4')->count(), orders::whereYear('created_at', now()->format('Y'))->whereMonth('created_at', '=', '5')->count(), orders::whereYear('created_at', now()->format('Y'))->whereMonth('created_at', '=', '6')->count(), orders::whereYear('created_at', now()->format('Y'))->whereMonth('created_at', '=', '7')->count(), orders::whereYear('created_at', now()->format('Y'))->whereMonth('created_at', '=', '8')->count(), orders::whereYear('created_at', now()->format('Y'))->whereMonth('created_at', '=', '9')->count(), orders::whereYear('created_at', now()->format('Y'))->whereMonth('created_at', '=', '10')->count(), orders::whereYear('created_at', now()->format('Y'))->whereMonth('created_at', '=', '11')->count(), orders::whereYear('created_at', now()->format('Y'))->whereMonth('created_at', '=', '12')->count()]
                                ]
                            ])
                            ->options([]);

                        //* End Statistical
                        return view('index', ['chartjs' => $chartjs]);
                    }
                    else{
                        return redirect()->route('auth.destroybackend');
                    }
                }
            })->middleware(['authbackend'])->name('dashboardbackend');

        //* To access these pages, you must log in first
            Route::middleware(['authbackend'])->group(function () {

                Route::get('/profile', [App\Http\Controllers\backend\ProfileController::class, 'editbackend'])->name('profile.editbackend');
                Route::patch('/updateprofile', [App\Http\Controllers\backend\ProfileController::class, 'updateprofilebackend'])->name('profile.updateprofilebackend');
                Route::get('destroy', [App\Http\Controllers\backend\Auth\AuthenticatedSessionController::class, 'destroy'])->name('auth.destroybackend');
                Route::resource('roles', RolesController::class);
                Route::resource('users', UserController::class);

                Route::prefix('imageuser')->group(function (){
                    Route::post('/imageuser', [ImageUserController::class, 'store'])->name('imageuser.store');
                    Route::patch('/imageuser', [ImageUserController::class, 'update'])->name('imageuser.update');
                    Route::get('/imageuser', [ImageUserController::class, 'destroy'])->name('imageuser.delete');
                });

                Route::prefix('posts')->group(function (){
                    Route::get('/post', [PostController::class, 'index'])->name('posts_index');
                    Route::get('/linkcreatepost', [PostController::class, 'create'])->name('linkposts.createpost');
                    Route::post('/createpost', [PostController::class, 'store'])->name('posts.create');
                    Route::patch('/updatepost', [PostController::class, 'update'])->name('posts.update');
                    Route::delete('/deletepost', [PostController::class, 'delete'])->name('posts.delete');
                    Route::delete('/deleteallpost', [PostController::class, 'deleteallpost'])->name('post_tags.deleteallpost');
                });

                Route::prefix('tags')->group(function (){
                    Route::get('/tag', [TagController::class, 'index'])->name('tags_index');
                    Route::post('/createtag', [TagController::class, 'store'])->name('tags.create');
                    Route::patch('/updatetag', [TagController::class, 'update'])->name('tags.update');
                    Route::delete('/deletetag', [TagController::class, 'delete'])->name('tags.delete');
                    Route::get('/tag_posts/{id}', [TagController::class, 'tag_posts']);
                });

                Route::prefix('post_tags')->group(function (){
                    Route::get('/post_tags/{id}', [PostTagController::class, 'index']);
                    Route::get('/post_tagsupdate/{id}', [PostTagController::class, 'update']);
                    Route::post('/createpost_tags', [PostTagController::class, 'store'])->name('post_tags.create');
                    Route::patch('/updatepost_tags', [PostTagController::class, 'update'])->name('post_tags.update');
                    Route::delete('/deletepost_tags/{id}', [PostTagController::class, 'delete'])->name('post_tags.delete');
                });

                Route::prefix('status')->group(function (){
                    Route::get('/statusoreder', [StatusorderController::class, 'index'])->name('statusoreder_index');
                    Route::post('/statusorder', [StatusorderController::class, 'store'])->name('statusorder.create');
                    Route::patch('/statusorder', [StatusorderController::class, 'update'])->name('statusorder.update');
                    Route::delete('/statusorder', [StatusorderController::class, 'delete'])->name('statusorder.delete');
                });

                Route::prefix('categories')->group(function (){
                    Route::get('/category', [CategoryController::class, 'index'])->name('category_index');
                    Route::post('/createcat', [CategoryController::class, 'store'])->name('categories.create');
                    Route::get('/categories/editstatusdéactive/{id}', [CategoryController::class, 'editstatusdéactive'])->name('categories.editstatusdéactive');
                    Route::get('/categories/editstatusactive/{id}', [CategoryController::class, 'editstatusactive'])->name('categories.editstatusactive');
                    Route::patch('/updatecat', [CategoryController::class, 'update'])->name('categories.update');
                    Route::delete('/deletecat', [CategoryController::class, 'delete'])->name('categories.delete');
                });

                Route::prefix('children')->group(function (){
                    Route::get('/child', [ChildrenCatController::class, 'index'])->name('childcat_index');
                    Route::post('/createchild', [ChildrenCatController::class, 'store'])->name('childcat.create');
                    Route::patch('/updatechild', [ChildrenCatController::class, 'update'])->name('childcat.update');
                    Route::delete('/deletechild', [ChildrenCatController::class, 'delete'])->name('childcat.delete');
                });

                Route::prefix('posts')->group(function (){
                    Route::get('/post', [PostController::class, 'index'])->name('posts_index');
                    Route::get('/linkcreatepost', [PostController::class, 'create'])->name('linkposts.createpost');
                    Route::post('/createpost', [PostController::class, 'store'])->name('posts.create');
                    Route::patch('/updatepost', [PostController::class, 'update'])->name('posts.update');
                    Route::delete('/deletepost', [PostController::class, 'delete'])->name('posts.delete');
                    Route::get('/posts/editstatusdéactive/{id}', [PostController::class, 'editstatusdéactive'])->name('posts.editstatusdéactive');
                    Route::get('/posts/editstatusactive/{id}', [PostController::class, 'editstatusactive'])->name('posts.editstatusactive');
                    Route::get('/page_detailsposts/{id}', [PostController::class, 'detailsposts'])->name('page_detailsposts');
                    Route::get('/page_details/{id}', [PostController::class, 'page_details'])->name('page_details');
                    Route::get('Notification/markAdRead', [PostController::class, 'markeAsRead'])->name('Notification.Read');
                });
                Route::get('/category/{id}', [PostController::class, 'getchild']);

                Route::get('/contactus', [ContactusController::class, 'index'])->name('contactus_index');
                Route::delete('/contactus', [ContactusController::class, 'delete'])->name('contactus.delete');

                Route::prefix('products')->group(function (){
                    Route::get('/product', [ProductController::class, 'index'])->name('product_index');
                    Route::get('/linkcreateproduct', [ProductController::class, 'create'])->name('product.createprod');
                    Route::post('/createproduct', [ProductController::class, 'store'])->name('product.create');
                    Route::patch('/updateproduct', [ProductController::class, 'update'])->name('product.update');
                    Route::delete('/deleteproduct', [ProductController::class, 'delete'])->name('product.delete');
                    Route::get('/products/editstatusdéactive/{id}', [ProductController::class, 'editstatusdéactive'])->name('products.editstatusdéactive');
                    Route::get('/products/editstatusactive/{id}', [ProductController::class, 'editstatusactive'])->name('products.editstatusactive');
                    Route::get('/page_detailsproducts/{id}', [ProductController::class, 'detailsproducts'])->name('page_detailsproducts');
                    Route::get('/page_detailspr/{id}', [ProductController::class, 'page_details'])->name('page_detailspr');
                });

                Route::prefix('images')->group(function (){
                    Route::get('/images/{id}', [ImageController::class, 'index']);
                    Route::post('/createimage', [ImageController::class, 'store'])->name('image.create');
                    Route::patch('/imageuser', [ImageController::class, 'edit'])->name('image.edit');
                    Route::delete('/deleteimage', [ImageController::class, 'delete'])->name('image.delete');
                });

                Route::prefix('sizes')->group(function (){
                    Route::get('/sizes/{id}', [SizeController::class, 'index']);
                    Route::patch('/size', [SizeController::class, 'update'])->name('sizes.update');
                });

                Route::prefix('promotions')->group(function (){
                    Route::get('/promotions/{id}', [PromotionController::class, 'index']);
                    Route::post('/createpromotion', [PromotionController::class, 'store'])->name('promotions.create');
                    Route::patch('/promotionupdate', [PromotionController::class, 'update'])->name('promotions.update');
                    Route::get('/promotions/editstatusdéactive/{id}', [PromotionController::class, 'editstatusdéactive'])->name('promotions.editstatusdéactive');
                    Route::get('/promotions/editstatusactive/{id}', [PromotionController::class, 'editstatusactive'])->name('promotions.editstatusactive');
                    Route::delete('/deletepromotion', [PromotionController::class, 'delete'])->name('promotion.delete');
                });

                Route::prefix('page_cart')->group(function (){
                    Route::post('/page_cart/{id}', [CartController::class, 'store'])->name('page_add_cart');
                    Route::patch('/page_cart_update', [CartController::class, 'update'])->name('page_cart_update');
                    Route::get('/page_cart_delete/{id}', [CartController::class, 'delete'])->name('page_cart_delete');
                    Route::get('/page_cart_deleteall', [CartController::class, 'deleteall'])->name('page_cart_deleteall');
                });

                Route::get('stock/editstocknoexist/{id}', [StockproductController::class, 'editstocknoexist'])->name('stock.editstocknoexist');
                Route::get('stock/editstockexist/{id}', [StockproductController::class, 'editstockexist'])->name('stock.editstockexist');

                Route::get('/orders', [OrdersController::class, 'index'])->name('orders_index');
                Route::patch('/orders', [OrdersController::class, 'update'])->name('orderstatus.update');
                Route::delete('/orders', [OrdersController::class, 'delete'])->name('orderstatus.delete');
                Route::get('ordersproduct/{id}', [OrdersController::class, 'ordersproduct'])->name('ordersproduct');

                Route::get('/oneorder', [OneOrderController::class, 'index'])->name('oneorder_index');
                Route::patch('/oneorderstatus', [OneOrderController::class, 'update'])->name('oneorderstatus.update');
                Route::delete('/oneorderstatus', [OneOrderController::class, 'delete'])->name('oneorderstatus.delete');
                Route::get('oneorderproduct/{id}', [OneOrderController::class, 'oneorderproduct'])->name('oneorderproduct');

                Route::get('/bulk', [BuyingSellingBulkController::class, 'index'])->name('bulk_index');
                Route::post('/bulk', [BuyingSellingBulkController::class, 'store'])->name('bulk.create');
                Route::delete('/bulk', [BuyingSellingBulkController::class, 'delete'])->name('bulk.delete');

            });
            require __DIR__.'/auth.php';
    });

    // Frontend
    Route::group(['middleware' => [ 'setLocale']], function(){
        Route::get('/language/{language}', function ($language) {
            Session()->put('locale', $language);
            return redirect()->back();
        })->name('language');

        Route::get('/', [ShopController ::class, "welcome"])->name("welcome");

        Route::get('/shop', [ShopController::class, "index"])->name("shop");
        Route::get('/shopbycategory', [ShopController::class, "indexbycategory"])->name("shopbycategory");
        Route::get('/shopbycategoryindex', [ShopController::class, "indexbycategory"])->name("shopbycategoryindex");
        Route::get('/view/{id}', [ShopController::class, "view"])->name('view.product');

        Route::get('/checkout', [CartController::class, "checkout"])->name("checkout");

        Route::middleware('auth', 'verified')->group(function () {
            Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
            Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
            Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

            Route::get('/profileinformation', [ProfileController::class, 'profileinformation'])->name('profile.profileinformation');
            Route::get('/manageaccount', [ProfileController::class, 'changepassword'])->name('profile.manageaccount');
            Route::get('/manageaddress', [ProfileController::class, 'manageaddress'])->name('profile.manageaddress');
            Route::get('/changepassword', [ProfileController::class, 'changepassword'])->name('profile.changepassword');

            Route::get('/wishlist', [WishlistController::class, 'wishlist'])->name('wishlist');
            Route::get('/addwishlist/{id}', [WishlistController::class, 'addwishlist'])->name('addwishlist');
            Route::get('/deleteonewishlist/{id}', [WishlistController::class, 'deleteonewishlist'])->name('deleteonewishlist');

            Route::get('/cart', [CartController::class, 'cart'])->name('cart');
            Route::post('/addtocart/{id}', [CartController::class, 'addtocart'])->name('addtocart');
            Route::post('/addcartandquantity', [CartController::class, 'addcartandquantity'])->name('addcartandquantity');
            Route::get('/clearall', [CartController::class, 'clearall'])->name('clearall');
            Route::post('/updatequantity', [CartController::class, 'updatequantity'])->name('updatequantity');
            Route::get('/deleteoneproduct/{id}', [CartController::class, 'deleteoneproduct'])->name('deleteoneproduct');

            Route::post('/addorder', [OrdersController::class, 'store'])->name('addorder');

        });
        Route::post('/addoneorder', [OneOrderController::class, 'store'])->name('addoneorder');

        Route::post('/subscribe', [SubscribeController::class, 'subscribe'])->name('subscribe');

        Route::get('/contactus', [ContactusController::class, 'contactus'])->name('contactus');
        Route::post('/addcontactus', [ContactusController::class, 'addcontactus'])->name('addcontactus');

        Route::get('/posts', [PostController::class, 'posts'])->name('posts');
        Route::get('/postsw/{id}', [PostController::class, 'tags'])->name('view.tags');
        require __DIR__.'/auth.php';
    });
