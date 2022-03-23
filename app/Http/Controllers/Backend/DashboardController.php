<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Notification;
use App\Models\Product;
use App\Models\News;
use Laracasts\Flash\Flash;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Order;
use App\Models\Contact;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class DashboardController extends Controller
{

    public function __construct($countNotifi = 12){
        try {
            $countNotification = new Notification();
            $countReport = $countNotification->countReport();
            $notifications = Notification::orderBy('id', 'desc')
                ->offset(0)->limit($countNotifi)->get();

        } catch (\Exception $e) {
            $countReport = 0;
            $notifications = array();
            $typeSubPostsAdmin = array();
        } finally {
            view()->share([
                'countRp'=>$countReport,
                'notifications'=>$notifications
            ]);
        }
    }

    public function index()
    {
        $today = date('Y-m-d',strtotime("today"));
        $countPost = News::count();
        $countProduct = Product::count();
        $user = Auth::user();
        if(User::isEditor($user->role)){
            $countPost = News::where('assignee_id',$user->id)->count();
            $countProduct = Product::where('assignee_id',$user->id)->count();
        }
        $countOrder = Order::count();
        $countOrderNotDone = Order::where('status','=',1)->count();
        $countOrderNotDelivery = Order::where('status','=',2)->where('is_delivery','=',0)->count();

        $countContact = Contact::where('type',0)->count();
        $countContactNotDone = Contact::whereNull('reply')->where('type',0)->count() + Contact::where('reply',0)->where('type',0)->count();

        $countRemarketing = Contact::where('type',1)->count();
        $countRemarketingNotDone = Contact::whereNull('reply')->where('type',1)->count() + Contact::where('reply',0)->where('type',1)->count();
        $countAdvisorContact = Contact::where('type',0)->count();
        $countAdvisorContactNotDone = Contact::whereNull('reply')->where('type',0)->count();

        $countCartItem = CartItem::where('created_at','>=',$today)->count();
        $countOrderToday = Order::where('created_at','>=',$today)->count();
        return View('pages.dashboard.index', compact(
            'countPost',
            'countProduct',
            'countOrder',
            'countOrderNotDone',
            'countOrderNotDelivery',
            'countContact',
            'countCartItem',
            'countOrderToday',
            'countContactNotDone',
            'countAdvisorContact',
            'countAdvisorContactNotDone',
            'countRemarketing',
            'countRemarketingNotDone'
        ));
    }

    public function seenNotification() {
        try {
            $notification = new Notification();
            $notification->where('status',0)->update([
                'status' => 1
            ]);
        } catch (\Exception $e) {

        } finally {
            return response([
                'status' => 200,
            ])->header('Content-Type', 'text/plain');
        }

    }

    public function readNotification(Request $request){
        try {
            // lấy ra id truyền lên
            $id = $request->input('id');
            // đổi trạng thái id tương ứng là đã đọc
            $notifications = new Notification();
            $notifications->where('notify_id', $id)
                ->update(['status' => 2]);
        } catch (\Exception $e) {
        } finally {
            // tra ve ket qua
            return response([
                'status' => 200,
            ])->header('Content-Type', 'text/plain');
        }
    }

    public function siteMap($updateProduct = False, $updateNews = False)
    {
        # Update product site map
        if ($updateProduct) {
            $productModel = new Product();
            $products = $productModel->getNewest([], 10000)->get();

            $html = view('products.sitemap', [
                'products'      => $products
            ])->render();

            $fp = fopen(public_path() . '/sitemaps/products.xml', 'w');
            fwrite($fp, $html);
            fclose($fp);

            # Product categories
            $productCates = Category::where('status', 1)->orderBy('id', 'DESC')->get();

            $html = view('categories.sitemap', [
                'cates'      => $productCates
            ])->render();

            $fp = fopen(public_path() . '/sitemaps/product_categories.xml', 'w');
            fwrite($fp, $html);
            fclose($fp);
        }

        # Update news sitemap
        if ($updateNews) {
            # Update site map
            $newses = News::where('status', 1)->whereNull('canonical')->orderBy('id', 'DESC')->get();

            $html = view('news.sitemap', [
                'newses'      => $newses
            ])->render();

            $fp = fopen(public_path() . '/sitemaps/news.xml', 'w');
            fwrite($fp, $html);
            fclose($fp);
        }

        # Update sitemap
        $html = view('pages.dashboard.sitemap', [
            'updateProduct' => $updateProduct,
            'updateNews'    => $updateNews
        ])->render();

        $fp = fopen(public_path() . '/sitemap.xml', 'w');
        fwrite($fp, $html);
        fclose($fp);
    }

    public function uploadImage(Request $request)
    {
        if ($request->isMethod('post')) {
            if ($request->hasFile('image')) {
                $fileName = request()->file('image')->getClientOriginalName();
                #check exist file name
                $exist = Product::where('thumbnail', $fileName)->orWhere('thumbnail_home', $fileName)->exists();
                if ($exist) {
                    $request->session()->flash('danger', 'This file name has been existed in Database');
                    return redirect('/admin/upload-image');
                }

                $fileUploaded = uploadImage(request()->file('image'));

                if (!$fileUploaded) {
                    $request->session()->flash('danger', 'This file name has been existed in GCP');
                    return redirect('/admin/upload-image');
                }
                $strImgs = "<p>https://thaomocuytin.com/images/images/original/$fileUploaded</p>";
                $strImgs .= "<p>https://thaomocuytin.com/images/images/600/$fileUploaded</p>";
                $strImgs .= "<p>https://thaomocuytin.com/images/images/400/$fileUploaded</p>";
                $strImgs .= "<p>https://thaomocuytin.com/images/images/200/$fileUploaded</p>";
                $strImgs .= "<p>https://thaomocuytin.com/images/images/100/$fileUploaded</p>";
                $request->session()->flash('success', "Upload success:</br> $strImgs");
                return redirect('/admin/upload-image');
            }
        }
        return view('admin.upload');
    }
}
