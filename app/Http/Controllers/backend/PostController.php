<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\category;
use App\Models\image;
use App\Models\Post;
use App\Models\Post_tag;
use App\Models\product;
use App\Models\tag;
use App\Models\User;
use App\Notifications\postntf;
use App\Traits\UploadImageTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use App\Models\product_color;
use App\Models\promotion;
use App\Models\size;
use Inertia\Inertia;

class PostController extends Controller
{
    //* Page UploadImageTrait inside it function Image
    use UploadImageTrait;

    //* function index Post
    public function index()
    {
        $posts = Post::query()->selectposts()->get();
        $tags = tag::query()->selectags()->get();
        return view('posts.posts', compact('posts', 'tags'));
    }

    //* function create other Post
    public function create()
    {
        $tags = tag::query()->selectags()->get();
        return view('posts.postscreate', compact('tags'));
    }

    //* DropDown Children
    public function getchild($id)
    {
        $childrens = DB::table("categories")->where("parent_id", $id)->pluck('id', 'name_'.app()->getLocale());
        return json_encode($childrens);
    }

    //* Hide Post
    public function editstatusdéactive($id)
    {
        try{
            $post = Post::findorFail($id);
            DB::beginTransaction();
            $post->update([
                'status' => 1
            ]);
            DB::commit();
            return redirect()->back();
        }catch(\Exception $exception){
            DB::rollBack();
            toastr()->error(trans('message.error'));
            return redirect()->route('posts_index');
        }
    }

    //* Show Post
    public function editstatusactive($id)
    {
        try{
            $post = Post::findorFail($id);
            DB::beginTransaction();
            $post->update([
                'status' => 0
            ]);
            DB::commit();
            return redirect()->back();
        }catch(\Exception $exception){
            DB::rollBack();
            toastr()->error(trans('message.error'));
            return redirect()->route('posts_index');
        }
    }

    //* function create other Post
    public function store(Request $request)
    {
        // validations
        $this->validate($request, [
            'title_en' => 'required|unique:posts,title->en',
            'title_ar' => 'required|unique:posts,title->ar',
            'body_en' => 'required',
            'body_ar' => 'required',
            'image' => 'required',
        ],[
            'title_en.required' =>__('messagevalidation.users.titleenrequired'),
            'title_en.unique' =>__('messagevalidation.users.titleaddenunique'),
            'title_ar.required' =>__('messagevalidation.users.titlearrequired'),
            'title_ar.unique' =>__('messagevalidation.users.titleaddarunique'),
            'body_en.required' =>__('messagevalidation.users.bodyenrequired'),
            'body_ar.required' =>__('messagevalidation.users.bodyarrequired'),
            'image.required' =>__('messagevalidation.users.imagerequired'),
        ]);
        try{
            //Added photo
            if($request->has('image')){
                $image = $this->uploadImageposts($request, 'fileposts');
                DB::beginTransaction();
                    Post::create([
                        'title' => ['en' => $request->title_en, 'ar' => $request->title_ar],
                        'body' => ['en' => $request->body_en, 'ar' => $request->body_ar],
                        'image' => $image
                    ]);
                    foreach($request->tag_id as $tag)
                    {
                        $post_id = Post::latest()->first()->id;
                        $post_tag = new Post_tag();
                        $post_tag->post_id = $post_id;
                        $post_tag->tag_id = $tag;
                        $post_tag->save();
                    }

                    //* Notification database Post

                    $users = User::where('id', '!=', Auth::user()->id)->get();
                    $notif = Post::latest()->first();

                    Notification::send($users, new postntf($notif));

                DB::commit();
                toastr()->success(trans('message.create'));
                return redirect()->route('posts_index');
            }
            //No Added photo
            else{
                toastr()->error(trans('messagevalidation.users.imagerequired'));
                return redirect()->route('posts_index');
            }
        }
        catch(\Exception $exception){
            DB::rollBack();
            toastr()->error(trans('message.error'));
            return redirect()->route('posts_index');
        }
    }

    //* update Post
    public function update(Request $request, Post $post)
    {
        // validations
        $this->validate($request, [
            'title_'.app()->getLocale() => 'required|unique:posts,title->'.app()->getLocale().','.$request->id,
            'body_'.app()->getLocale() => 'required',
        ],[
            'title_'.app()->getLocale().'.required' =>__('messagevalidation.users.titlerequired'),
            'title_'.app()->getLocale().'.unique' =>__('messagevalidation.users.titlunique'),
            'body_'.app()->getLocale().'.required' =>__('messagevalidation.users.bodyrequired'),
        ]);
        try{
            $post = $request->id;
            $posts = Post::findOrFail($post);
            //Added photo
            if($request->hasFile('image')){
                $image = $posts->image;
                if(!$image) abort(404);
                unlink(public_path('storage/'.$image));
                $image = $this->uploadImageposts($request, 'fileposts');
                DB::beginTransaction();
                    if(App::isLocale('en')){
                        $posts->update([
                            'title' => $request->title_en,
                            'body' => $request->body_en,
                            'image' => $image
                        ]);
                    }
                    elseif(App::isLocale('ar')){
                        $posts->update([
                            'title' => $request->title_ar,
                            'body' => $request->body_ar,
                            'image' => $image
                        ]);
                    }
                DB::commit();
                toastr()->success(trans('message.update'));
                return redirect()->route('posts_index');
            }
            //No Added photo
            else{
                    DB::beginTransaction();
                    if(App::isLocale('en')){
                        $posts->update([
                            'title' => $request->title_en,
                            'body' => $request->body_en,
                        ]);
                    }
                    elseif(App::isLocale('ar')){
                        $posts->update([
                            'title' => $request->title_ar,
                            'body' => $request->body_ar,
                        ]);
                    }
                    DB::commit();
                    toastr()->success(trans('message.update'));
                    return redirect()->route('posts_index');
            }
        }catch(\Exception $execption){
            DB::rollBack();
            toastr()->error(trans('message.error'));
            return redirect()->route('posts_index');
        }
    }

    //* delete Post
    public function delete(Request $request)
    {
        try{
            $id = $request->id;
            $Post = Post::findorFail($id);
            DB::beginTransaction();
                $Post->delete();
                $image = $Post->image;
                if(!$image) abort(404);
                unlink(public_path('storage/'.$Post->image));
            DB::commit();
            toastr()->success(trans('message.delete'));
            return redirect()->route('posts_index');
        }catch(\Exception $execption){
            DB::rollBack();
            toastr()->error(trans('message.error'));
            return redirect()->route('posts_index');
        }
    }

    //* Details|posts notification
    public function detailsposts($id){
        $posts = Post::query()->where('id', $id)->first();
        $tags = tag::query()->selectags()->get();
        $getID = DB::table('notifications')->where('data->idpost', $id)->pluck('id');
        DB::table('notifications')->where('id', $getID)->update(['read_at'=>now()]);
        return view('posts_ntf.post_detailsntf', compact('posts', 'tags'));
    }

    //* Details|posts
    public function page_details($id){
        $posts = Post::query()->where('id', $id)->first();
        $tags = tag::query()->selectags()->get();
        return view('posts_ntf.post_detailsntf', compact('posts', 'tags'));
    }

    //* function markeAsRead | Delete
    public function markeAsRead(){
        $user = User::find(auth()->user()->id);
        foreach ($user->unreadNotifications as $notification){
            $notification->delete();
        }
        return redirect()->back();
    }


    //* function index Post
        public function posts()
        {
            $posts = Post::query()->selectposts()->where('status', '0')->paginate(5);
            $post_tags = Post_tag::query()->with('post')->with('tag')->get();
            $categories = category::selectcategories()->withcategories()->parent()->get();
            return Inertia::render('Posts', [
                "posts" => $posts,
                "post_tags" => $post_tags,
                "categories" => $categories
            ]);
        }

    //* function index Post
        public function tags($id)
        {
            $categories = category::selectcategories()->withcategories()->parent()->get();
            $post_tags = Post_tag::query()->with('post')->with('tag')->where('tag_id', $id)->paginate(5);
            return Inertia::render('Tags', [
                "post_tags" => $post_tags,
                "categories" => $categories
            ]);
        }

    // public function deleteallpost()
    // {
    //     Post::truncate();
    //     return redirect()->back();
    // }
}
