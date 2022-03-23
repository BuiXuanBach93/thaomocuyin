<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\NewsCategory;
use App\Models\Page;
use Illuminate\Support\Facades\View;
use App\Constant;

class NewsController extends Controller
{
    /**
     * Create a news controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->categoryModel = new Category();
        $this->productModel = new Product();
        $this->menuCategories = $this->categoryModel->getMenuCategory();
        View::share([
            'cookieOrders' => Product::getOrderFromCookie(),
            'menuCategories'    => $this->menuCategories,
        ]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $newsCategories = NewsCategory::get();
        $newses = News::where('status', '=', News::STATUS_ACTIVE)->orderBy('id', 'DESC');
        $newses = $newses->paginate(Constant::PAGE_NUMBER);
        return view('frontend/news/index', [
            'newses'        => $newses,
            'newsCategories' => $newsCategories,
            'pageTitle'         => 'Tin tức về sức khoẻ, dinh dưỡng, làm đẹp',
            'pageKeyword'       => 'Tin sức khoẻ, tin tức về dinh dưỡng, tin tức về làm đẹp',
            'pageDesc'          => 'Tổng hợp các tin tức về sức khoẻ, dinh dưỡng, làm đẹp cho chị em phụ nữ',
        ]);
    }


    public function author($slug)
    {
        try {
            $author = User::where("slug", $slug)->first();
        } catch (\Throwable $th) {
            return redirect('/404');
        }
        $newsCategories = NewsCategory::get();
        $newses = News::where('status', '=', News::STATUS_ACTIVE)
            ->where('user_id', $author->id)
            ->orderBy('id', 'DESC')->get();
        return view('frontend/author', [
            'newses'        => $newses,
            'newsCategories' => $newsCategories,
            'author'        => $author,
            'pageTitle'         => "Thông tin về ".$author->nick_name,
            'pageKeyword'       => $author->nick_name,
            'pageDesc'          => $author->description,
        ]);
    }

    public function page()
    {
        $slug = Route::current()->uri;
        try {
            $page = Page::where('slug', $slug)->first();
            if (!$page) {
                return redirect('/404');
            }
        } catch (\Throwable $th) {
            return redirect('/404');
        }

        return view('frontend/news/page', [
            'page' => $page,
            'pageTitle'         => $page->title,
            'pageKeyword'       => $page->seo_keyword,
            'pageDesc'          => $page->seo_description,
            'pageImage'          => $page->seo_image
        ]);
    }

    public function test(){
        echo 1; exit;
    }
}
