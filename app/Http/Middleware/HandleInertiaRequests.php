<?php

namespace App\Http\Middleware;

use App\Models\category;
use App\Models\wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Inertia\Middleware;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Tightenco\Ziggy\Ziggy;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): string|null
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        return array_merge(parent::share($request), [
            'auth' => [
                'user' => $request->user(),
            ],
            'ziggy' => function () use ($request) {
                return array_merge((new Ziggy)->toArray(), [
                    'location' => $request->url(),
                ]);
            },
            'categories' => [
                'categories' => category::query()->selectcategories()->withcategories()->parent()->get(),
            ],
            'wishlists' => [
                'wishlists' => wishlist::where('user_id', $request->user() ? $request->user()->id : '1')->count(),
            ],
            'carts' => [
                $carts = \Cart::session($request->user() ? $request->user()->id : '1')->getContent(),
                'countincart' => $carts->count(),
            ],
            'locale' => [
                'locale' => Session()->get('locale')
            ]
        ]);
    }
}
