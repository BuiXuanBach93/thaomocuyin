<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Constant;
use App\Models\Tag;
use App\Models\Contact;
use App\Models\Notification;
use Laracasts\Flash\Flash;
use App\Models\Rating;
use App\Models\RatingNews;
use App\Models\ReceiveNews;
use App\Models\Order;
use phpDocumentor\Reflection\Types\Null_;
use Illuminate\Foundation\Console\Presets\None;
use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\NewsCategory;
use App\Models\Provider;
use App\Models\User;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\View;
use PhpParser\Node\Stmt\TryCatch;
use Illuminate\Support\Facades\Redis;
use Validator;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->categoryModel = new Category();
        $this->productModel = new Product();

        $menuCached = Redis::get('tmut_menus');
        if($menuCached) {
            $this->menuCategories = json_decode($menuCached, true);
        } else {
            $this->menuCategories = $this->categoryModel->getMenuCategory();
            Redis::set('tmut_menus', json_encode($this->menuCategories));
        }
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
        $featuredHomeProducts = $this->productModel->getFeaturedHome();
        $ignoreProductIDs = [];
        $isMobile = isMobile();
        foreach ($featuredHomeProducts as $featuredHomeProduct) {
            $ignoreProductIDs[] = $featuredHomeProduct['id'];
        }
        $newses = News::limit(4)->where('status', '=', News::STATUS_ACTIVE)
            ->orderBy('id', 'DESC')->get();

        return view('frontend/home', [
            'featuredHomeProducts' => $featuredHomeProducts,
            'newses'            => $newses,
            'isMobile'          => $isMobile,    
            'categoryProducts'  => $this->categoryModel->getCategoryProduct($ignoreProductIDs),
            'pageTitle'         => 'Thảo Mộc Uy Tín - An tâm mua thuốc chính hãng',
            'pageKeyword'       => 'nhà thuốc, nhà thuốc GPP, thuốc, nhà thuốc việt, nhà thuốc online, nhà thuốc online uy tín',
            'pageDesc'          => 'Hệ thống Thảo Mộc Uy Tín phân phối trực tuyến dược phẩm, thực phẩm chức năng, thuốc giảm cân chính hãng, giá tốt, nhiều ưu đãi.',
        ]);
    }


    /**
     *@param  \Throwable  $exception 
     * Product & News detail, if - else
     */
    public function productDetail($cateSlug, $productSlug)
    {
        // Check this url in canonical list
        try {
            $canonicalUrls = json_decode(Redis::get('tmut_canonical_urls'), true);
            if($canonicalUrls[$productSlug]) {
                header('Location: '.$canonicalUrls[$productSlug], true, 301);
                exit();
            }
        } catch (\Throwable $th) {
            //throw $th;
        }
        

        $isMobile = isMobile();
        if ($isMobile) {
            $cachedKey = "tmut_mobile_".$productSlug;
        } else {
            $cachedKey = "tmut_desktop_".$productSlug;
        }
        $dataCached = Redis::get($cachedKey);
        if($dataCached) {
            return $dataCached;
        }
        $category   = Category::where('slug', $cateSlug)->first();
        $product       = Product::where('slug', $productSlug)->first();
        
        if ($category && $product) {
            if($product->status > 1){
               return redirect('https://google.com');
            }
            $categoryParent = "";
            if ($category['parent_id']) {
                $categoryParent = Category::where('id', $category['parent_id'])->first();
                if (!$categoryParent) {
                    return redirect('/404');
                }
            }

            # Get rating of this product
            $productRatings = Rating::where(['product_id' => $product->id])
                ->whereNull('parent_id')->orderBy('id', 'DESC')->get();
            $ratingNumber = count($productRatings);
            if ($ratingNumber == 0) {
                $ratingTxt = 'Chưa có đánh giá';
                $currentRating = 0;
            } else {
                $totalScore = 0;
                foreach ($productRatings as $productRating) {
                    $totalScore += $productRating->rating;
                }
                $currentRating = $totalScore / $ratingNumber;
                $ratingTxt = $currentRating;
            }

            $author = null;
            if ($product->user_id) {
                try {
                    $author = User::where('id', $product->user_id)->first();
                } catch (\Throwable $e) {
                    // Do nothing
                }
            }

            $shipText = "Miễn phí ship";
            if($product->discount <= 0){
                if($product->price > 0 && $product->price < 500000){
                    $count = floor(500000/$product->price);
                    if($count * $product->price < 500000){
                       $count += 1;     
                    }
                    $shipText = "Mua ".$count." miễn phí ship";
                }
            }else{
                if($product->discount < 500000){
                    $count = floor(500000/$product->discount);
                    if($count * $product->discount < 500000){
                       $count += 1;     
                    }
                    $shipText = "Mua ".$count." miễn phí ship";
                }
            }
            if($product->promotion_type == 1){
                if($product->promotion_threshold > 0){
                    $count = $product->promotion_threshold;
                }else{
                    $count = 1;
                }
                $shipText = "Mua ".$count." miễn phí ship";
            }
            
            $result =  view('frontend/product-detail', [
                'category'          => $category,
                'categoryParent'    => $categoryParent,
                'product'           => $product,
                'pageTitle'         => $product->seo_title,
                'pageKeyword'       => $product->seo_keyword,
                'pageDesc'          => $product->seo_description,
                'ratingTxt'         => $ratingTxt,
                'currentRating'     => number_format($currentRating, 1, '.', '.'),
                'ratingNumber'      => $ratingNumber,
                'relatedProducts'   => $product->getRelated2($product, 6),
                'ratings'           => $productRatings,
                'pageImage'         => $product->seo_image,
                'author'            => $author,
                'shipText'          => $shipText,
                'cssFile'           => 'product.css'
            ])->render();
            Redis::set($cachedKey, $result);
            return $result;
        }

        # It's news detail
        $newsCategory   = NewsCategory::where('slug', $cateSlug)->first();
        $news           = News::where('slug', $productSlug)->where('status', '=', News::STATUS_ACTIVE)->first();
        if (!$newsCategory || !$news) {
            return redirect('/404');
        }
        $newsCategories = NewsCategory::get();
        $newsModel = new News();
        $newsRelated = $newsModel->getRelated($news, $newsCategory);

        $author = null;
        if ($news->user_id) {
            try {
                $author = User::where('id', $news->user_id)->first();
            } catch (\Throwable $e) {
                // Do nothing
            }
        }

        # Get rating of this product
        $newsRatings = RatingNews::where(['news_id' => $news->id])
                                ->orderBy('id', 'DESC')->get();

        $newsestNews = $newsModel->getNewsets($news, $newsCategory->id);
        
        $result = view('frontend/news/detail', [
            'news'          => $news,
            'newsCategories' => $newsCategories,
            'newsRelated'   => $newsRelated,
            'newsCategory'  => $newsCategory,
            'pageImage'     => $news->seo_image,
            'pageTitle'     => $news->seo_title,
            'pageKeyword'   => $news->seo_keyword,
            'pageDesc'      => $news->seo_description,
            'author'        => $author,
            'cssFile'       => 'news.css',
            'ratings'       => $newsRatings,
            'newsestNews'   => $newsestNews,
            'canonical'     => $news->canonical
        ])->render();
        Redis::set($cachedKey, $result);
        return $result;
    }

    public function category(Request $request, $cateSlug)
    {
        # It is category of product
        $category   = Category::where('slug', $cateSlug)->first();
        if ($category) {
            $price = $request->input('price');
            $nation = $request->input('nation');
            $provider = $request->input('provider');

            $categoryParent = $category; # Default is current category
            if ($category['parent_id']) {
                $categoryParent = Category::where('id', $category['parent_id'])->first();
                if (!$categoryParent) {
                    return redirect('/404');
                }
            }

            $newestProducts = $this->productModel->getNewest([], Constant::PAGE_NUMBER, $category['id']);

            if ($nation || $provider) {
                $newestProducts = $newestProducts->join('providers', 'providers.id', '=', 'products.provider_id');
            }
            if ($nation) {
                $newestProducts = $newestProducts->where('from_slug', $nation);
            }
            if ($provider) {
                $newestProducts = $newestProducts->where('providers.slug', $provider);
            }

            if ($price) {
                try {
                    $prices = explode('-', $price);
                    $min = $prices[0];
                    $max = $prices[1];
                    $newestProducts->whereBetween('price', [$min, $max]);
                } catch (\Throwable $th) {
                    # do nothing
                }
            }

            $newestProducts = $newestProducts->paginate(Constant::PAGE_NUMBER);
            
                $sameCategories = $this->menuCategories[$categoryParent['id']]['children'];
            
            
            // TODO: refactor this source code
            $providerModel = new Provider();
            $providers = $providerModel->getProviderByCate($category['id']);
            $fromProviders = getNationFromProviders($providers);

            return view('frontend/product-category', [
                'newestProducts'    => $newestProducts,
                'sameCategories'     => $sameCategories,
                'category'          => $category,
                'categoryParent'    => $categoryParent,
                'pageTitle'         => processCategorySeoTile($category->seo_title, $newestProducts->total()),
                'pageKeyword'       => $category->seo_keyword,
                'pageDesc'          => $category->seo_description,
                'providers'         => $providers,
                'fromProviders'     => $fromProviders
            ]);
        }

        # It is category of news
        $newsCategory = NewsCategory::where('slug', $cateSlug)->first();
        if (!$newsCategory) {
            return redirect('/404');
        }
        $newsCategories = NewsCategory::get();
        $newses = News::where('news_category_id', $newsCategory['id'])
            ->where('status', '=', News::STATUS_ACTIVE)->orderBy('id', 'DESC')->paginate(Constant::PAGE_NUMBER);
        return view('frontend/news/index', [
            'newses'        => $newses,
            'newsCategories' => $newsCategories,
            'pageTitle'     => $newsCategory->title,
            'pageKeyword'   => $newsCategory->seo_keyword,
            'pageDesc'      => $newsCategory->seo_description,
        ]);
    }

    public function tags(Request $request)
    {
        $tag = $request->input('tags');

        $categories = Category::whereNull('parent_id')->get();
        $providers = Provider::all();
        $fromProviders = getNationFromProviders($providers);

        $newestProducts = $this->productModel->getNewest([], 0);
        $newestProducts = $newestProducts
            ->where('tag_list', 'like', '%'.$tag.'%');

        return view('/frontend/product-tag', [
            'tag'               => $tag,
            'categories'        => $categories,
            'categoryProducts'  => $this->categoryModel->getCategoryProduct(),
            'newestProducts'    => $newestProducts->paginate(Constant::PAGE_NUMBER),
            'providers'         => $providers,
            'fromProviders'     => $fromProviders,
            'pageTitle'     => 'Tìm kiếm sản phẩm trên hệ thống Thảo Mộc Uy Tín',
            'pageKeyword'   => 'Tìm kiếm sản phẩm',
            'pageDesc'      => 'Hàng nghìn mặt hàng dược phẩm đang có mặt trên hệ thống website Thảo Mộc Uy Tín',
        ]);
    }


    public function contact(Request $request)
    {
        if ($request->isMethod('post')) {
            $contact = new Contact();
            if (!$request->name || !$request->phone_number || !$request->message) {
                $request->session()->flash('danger', 'Vui lòng điền đầy đủ thông tin');
                return redirect('/lien-he');
            }
            $contact->name = $request->name;
            $contact->email = $request->email;
            $contact->phone_number = $request->phone_number;
            $contact->message = $request->message;
            $contact->reply = 0;
            $contact->save();
            $request->session()->flash('success', 'Chúng tôi sẽ liên hệ lại với bạn trong 24h làm việc. Xin cảm ơn');
        }

        return view('contact', [
            'pageTitle'     => 'Liên hệ Thảo Mộc Uy Tín',
            'pageKeyword'   => 'Liên hệ Thảo Mộc Uy Tín',
            'pageDesc'      => 'Chúng tôi luôn ở đây để lắng nghe những phản hồi của quý khách về chất lượng sản phẩm, chất lượng dịch vụ',
        ]);
    }

    public function submitProductContact(Request $request) {
        $validation = Validator::make($request->all(), [
            'name' => 'required',
            'phone_number' => 'required'
        ]);

        // if validation fail return error
        if ($validation->fails()) {
            return response([
                'status' => 500,
                'message' => 'Bạn cần điền đầy đủ thông tin!',
            ])->header('Content-Type', 'text/plain');
        }
         
        //success
        $contact = new Contact();
        $name = $request->input('name');
        $name = str_replace("<","",$name);
        $name = str_replace(">","",$name);
        $name = str_replace(";","",$name);

        $phone = $request->input('phone_number');
        $phone = str_replace("<","",$phone);
        $phone = str_replace(">","",$phone);
        $phone = str_replace(";","",$phone);

        if (strpos($phone, "0") !== 0) {
            return redirect('/');
        }

        $email = $request->input('email');
        if(!$email){
            $email = "no-email@gmail.com";
        }
        $email = str_replace("<","",$email);
        $email = str_replace(">","",$email);
        $email = str_replace(";","",$email);

        $address = $request->input('address');
        $address = str_replace("<","",$address);
        $address = str_replace(">","",$address);
        $address = str_replace(";","",$address);

        $message = $request->input('message');
        $message = str_replace("<","",$message);
        $message = str_replace(">","",$message);
        $message = str_replace(";","",$message);

        $contact->insert([
            'name' => $name,
            'phone_number' => $phone,
            'email' => $email,
            'address' => $address,
            'message' => $message,
            'reply' => 0,
            'ip_customer' => get_client_ip(),
            'created_at' => new \DateTime(),
            'updated_at' => new \DateTime()
        ]);

        $notifyAdmin = new Notification();
           $notifyAdmin->insert([
               'title' => 'Liên hệ',
               'content' => 'Bạn vừa có liên hệ mới',
               'status' => '0',
               'slug' => '/admin/contacts',
               'created_at' => new \DateTime(),
               'updated_at' => new \DateTime()
        ]);
        
        return response([
             'status' => 200,
             'message' => 'Cảm ơn bạn đã yêu cầu tư vấn, Nhà thuốc sẽ phản hồi sớm nhất.',
         ])->header('Content-Type', 'text/plain');
    }

    /**
     * Customer rating a product
     */
    public function rating(Request $request)
    {
        $clientIP = request()->ip();
        $rating = Rating::firstOrNew(array('ip' => $clientIP));
        $rating->rating = $request->input('rating');
        $rating->product_id = $request->input('product_id');
        $rating->save();

        $productRatings = Rating::where('product_id', $request->input('product_id'))->get();
        $ratingNumber = count($productRatings);
        if ($ratingNumber == 0) {
            echo '';
            exit;
        }

        $totalScore = 0;

        foreach ($productRatings as $productRating) {
            $totalScore += $productRating->rating;
        }

        echo sprintf('Xếp hạng: %s - ‎%d phiếu bầu', $totalScore / $ratingNumber, $ratingNumber);
        exit;
    }


    /**
     * Customer register receive news
     */
    public function registerEmail(Request $request)
    {
        $clientIP = request()->ip();
        $receiveNews = new ReceiveNews();
        $receiveNews->ip = $clientIP;
        $receiveNews->email = $request->input('email');
        $receiveNews->save();

        echo 'Bạn đã đăng ký thành công';
    }


    /**
     * 404 error
     */
    public function error404(Request $request)
    {
        return view('404', []);
    }

    public function checkout(Request $request, $id, $quantity)
    {
        try {
            $product = Product::where('id', $id)->first();
            $orders[] = [
                'product_id' => $product['id'],
                'thumbnail' => $product['thumbnail'],
                'title'     => $product['title'],
                'price'     => $product['price'],
                'quantity'  => $quantity,
                'category_slug' => $product['category_slug'],
                'slug' => $product['slug'],
            ];

            return view('order', [
                'orders'            => $orders,
                'pageTitle'     => 'Thanh toán',
                'pageKeyword'   => 'Thanh toán',
                'pageDesc'      => 'Thanh toán',
            ]);
        } catch (\Throwable $th) {
            return redirect('/404');
        }
        
    }

    /**
     * Ajax add one product to cart
     */
    public function buyNow(Request $request)
    {
        $productID = (int) $request->input('product_id');
        $number = (int) $request->input('quantity');

        $data = new \stdClass();
        $cookies = Cookie::get('orders');
        if ($cookies) {
            $data = json_decode($cookies);
        }
        $data->data[] = ["product_id" => $productID, "quantity" => $number];
        Cookie::queue(Cookie::make('orders', json_encode($data), 30 * 24 * 60 * 60));
    }


    public function checkoutSubmit(Request $request, $id, $quantity)
    {
        $userName = $request->input('name');
        $phoneNumber = $request->input('phone_number');
        $address = $request->input('address');
        $note = $request->input('note', '');

        $productInfos = json_encode('{"data":[{"product_id":'.$id.',"quantity":'.$quantity.'}]}');
        if ($userName && $phoneNumber && $address && $productInfos) {
            $orderModel = new Order();
            $orderModel->user_name = $userName;
            $orderModel->phone_number = $phoneNumber;
            $orderModel->address = $address;
            $orderModel->note = $note;
            $orderModel->product_info = $productInfos;

            $result = $orderModel->save();

            // send an email
            try {
                $product = Product::where('id', $id)->first();
                $productLink = genProductLink($product->category->slug, $product->slug); 
                // $name = "Thảo Mộc Uy Tín";
                // $email = 'thaomocuytinvn@gmail.com';
                // $data = array('product_link'=> "https://thaomocuytin.com".$productLink, 'quantity'=>$quantity, 'user_name' => $userName, 'phone_number' => $phoneNumber, 'address' => $address, 'note' => $note);
                // Mail::send('frontend.email', $data, function ($message) use ($name, $email) {
                //     $message->to('vvt7193@gmail.com', 'CSKH Thảo Mộc Uy Tín')->subject('Có đơn hàng mới');
                //     $message->from($email, $name);
                // });
                $resultText = '<span class="text-success">Đặt hàng thành công. Chúng tôi sẽ gọi điện để tư vấn kỹ hơn cho quý khách.</span>';
            } catch (\Throwable $th) {
                dd($th);
            }
        } else{
            $resultText = '<span class="text-danger">Cần điền đầy đủ thông tin. Vui lòng thử lại</span>';
        }
        return view('order-result', [
            'pageTitle'     => 'Đặt hàng thành công',
            'pageKeyword'   => '',
            'pageDesc'      => 'Chúng tôi đã ghi nhận đơn hàng. Cảm ơn quý khách đã tin tưởng và sử dụng dịch vụ.',
            'resultText'    => $resultText
        ]);
    }

    public function search(Request $request)
    {
        $keyword = $request->input('keyword');
        $newestProducts = $this->productModel->getNewest([], Constant::PAGE_NUMBER, 0, false, $keyword);
        $categories = Category::whereNull('parent_id')->get();
        $providers = Provider::all();
        $fromProviders = getNationFromProviders($providers);

        return view('frontend/search', [
            'keyword'           => $keyword,
            'categories'        => $categories,
            'categoryProducts'  => $this->categoryModel->getCategoryProduct(),
            'newestProducts'    => $newestProducts->paginate(Constant::PAGE_NUMBER),
            'providers'         => $providers,
            'fromProviders'     => $fromProviders,
            'pageTitle'     => 'Tìm kiếm sản phẩm trên hệ thống Thảo Mộc Uy Tín',
            'pageKeyword'   => 'Tìm kiếm sản phẩm',
            'pageDesc'      => 'Hàng nghìn mặt hàng dược phẩm đang có mặt trên hệ thống website Thảo Mộc Uy Tín',
        ]);
    }


    public function aboutUs()
    {
        return view('frontend/about-us', [
            'pageTitle'     => 'Thảo Mộc Uy Tín - Nhà thuốc online đạt chuẩn GPP',
            'pageKeyword'   => 'Thông tin về Thảo Mộc Uy Tín',
            'pageDesc'      => 'Thảo Mộc Uy Tín tự hào là đơn vị phân phối dược phẩm trực tuyến đạt chuẩn số một về chất lượng và giá'
        ]);
    }

    public function faq()
    {
        return view('frontend/faq', [
            'pageTitle'     => 'Giải đáp thắc mắc của khách hàng',
            'pageKeyword'   => 'Câu hỏi thường gặp',
            'pageDesc'      => 'Những câu hỏi thường gặp khi mua hàng ở Thảo Mộc Uy Tín, nếu bạn không tìm thấy câu trả lời thỏa mãn, vui lòng liên hệ với chúng tôi để được tư vấn chi tiết',
        ]);
    }


    /**
     * List all items of a brand
     */
    public function provider($providerSlug)
    {
      //  header('Location: https://thaomocuytin.com/', true, 301);
      //  exit();
        try {
            $provider = Provider::where('slug', $providerSlug)->first();
            $newestProducts = $this->productModel->getNewest([], Constant::PAGE_NUMBER);
            $newestProducts = $newestProducts->where('provider_id', $provider->id);
            $newestProducts = $newestProducts->paginate(Constant::PAGE_NUMBER);

            $providers = Provider::all();
            $fromProviders = getNationFromProviders($providers);

            return view('frontend/provider', [
                'newestProducts'    => $newestProducts,
                'pageTitle'         => processCategorySeoTile($provider->seo_title, $newestProducts->total()),
                'pageKeyword'       => $provider->seo_keyword,
                'pageDesc'          => $provider->seo_description,
                'provider'          => $provider,
                'providers'         => $providers,
                'fromProviders'     => $fromProviders
            ]);
        } catch (\Throwable $th) {
            return redirect('/404');
        }
    }

    /**
     * Preview product or news
     */
    public function previewProductDetail($cateSlug, $productSlug)
    {
        $category   = Category::where('slug', $cateSlug)->first();
        $product       = Product::where('slug', $productSlug)->first();
        if ($category && $product) {
            $categoryParent = "";
            if ($category['parent_id']) {
                $categoryParent = Category::where('id', $category['parent_id'])->first();
                if (!$categoryParent) {
                    return redirect('/404');
                }
            }

            # Get rating of this product
            $productRatings = Rating::where('product_id', $product->id)->get();
            $ratingNumber = count($productRatings);
            if ($ratingNumber == 0) {
                $ratingTxt = 'Chưa có đánh giá';
                $currentRating = 0;
            } else {
                $totalScore = 0;
                foreach ($productRatings as $productRating) {
                    $totalScore += $productRating->rating;
                }
                $currentRating = $totalScore / $ratingNumber;
                $ratingTxt = $currentRating;
            }

            return view('frontend/preview-product-detail', [
                'category'          => $category,
                'categoryParent'    => $categoryParent,
                'product'           => $product,
                'pageTitle'         => $product->seo_title,
                'pageKeyword'       => $product->seo_keyword,
                'pageDesc'          => $product->seo_description,
                'ratingTxt'         => $ratingTxt,
                'currentRating'     => number_format($currentRating, 1, '.', '.'),
                'ratingNumber'      => $ratingNumber,
                'relatedProducts'   => $product->getRelated2($product, 3),
                'ratings'           => $productRatings,
                'pageImage'         => $product->seo_image,
            ]);
        }

        # It's news detail
        $newsCategory   = NewsCategory::where('slug', $cateSlug)->first();
        $news           = News::where('slug', $productSlug)->first();
        if (!$newsCategory || !$news) {
            dd($newsCategory['id']);
            return redirect('/404');
        }
        $newsCategories = NewsCategory::get();
        $newsModel = new News();
        $newsRelated = $newsModel->getRelated($news, $newsCategory);

        $author = null;
        if ($news->user_id) {
            try {
                $author = User::where('id', $news->user_id)->first();
            } catch (\Throwable $e) {
                // Do nothing
            }
        }

        return view('frontend/news/preview-detail', [
            'news'          => $news,
            'newsCategories' => $newsCategories,
            'newsRelated'   => $newsRelated,
            'newsCategory'  => $newsCategory,
            'pageImage'     => $news->seo_image,
        ]);
    }

    /**
     * Customer comment on a product
     */
    public function productComment(Request $request)
    {
        $productID = $request->input('product_id');
        $customerName = $request->input('customer_name');
        $phoneNumber = $request->input('phone_number');
        $content = $request->input('content');
       // $rating = (int) $request->input('rating');

        $product  = Product::where('id', $productID)->first();
        $productSlug = $product->slug;
        $isMobile = isMobile();
        if ($isMobile) {
            $cachedKey = "tmut_mobile_".$productSlug;
        } else {
            $cachedKey = "tmut_desktop_".$productSlug;
        }
        if (!$customerName || !$content) {
            return response([
                     'status' => 400,
                     'message' => 'Hãy điền đầy đủ thông tin!',
                 ])->header('Content-Type', 'text/plain');
        }

        if (strlen($content) > 2000) {
            return ['success' => false, 'msg' => 'Nội dung quá dài'];
        } else {
            try {
                Rating::create([
                    'product_id'  => (int) $productID,
                    'customer_name' => $customerName,
                    'phone_number'  => $request->input('phone_number'),
                    'content'       => strip_tags($content),
                    'rating'        => 5,
                    'ip'            => get_client_ip(),
                    'is_admin'      => Rating::IS_ADMIN_FALSE,
                ]);
                $notifyAdmin = new Notification();
               $notifyAdmin->insert([
                   'title' => 'Đánh giá',
                   'content' => 'Bạn vừa có đánh giá mới',
                   'status' => '0',
                   'slug' => '/admin/ratings',
                   'created_at' => new \DateTime(),
                   'updated_at' => new \DateTime()
               ]);
                Redis::del(Redis::keys($cachedKey));
                return response([
                     'status' => 200,
                     'message' => 'Cảm ơn bạn đã đánh giá sản phẩm!' . $request->input('phone_number'),
                 ])->header('Content-Type', 'text/plain');
            } catch (\Throwable $e) {
            }
        }
    }


    /**
     * Preview product or news
     */
    public function preview2ProductDetail($cateSlug, $productSlug)
    {
        $category   = Category::where('slug', $cateSlug)->first();
        $product       = Product::where('slug', $productSlug)->first();
        if ($category && $product) {
            $categoryParent = "";
            if ($category['parent_id']) {
                $categoryParent = Category::where('id', $category['parent_id'])->first();
                if (!$categoryParent) {
                    return redirect('/404');
                }
            }

            # Get rating of this product
            $productRatings = Rating::where('product_id', $product->id)->get();
            $ratingNumber = count($productRatings);
            if ($ratingNumber == 0) {
                $ratingTxt = 'Chưa có đánh giá';
                $currentRating = 0;
            } else {
                $totalScore = 0;
                foreach ($productRatings as $productRating) {
                    $totalScore += $productRating->rating;
                }
                $currentRating = $totalScore / $ratingNumber;
                $ratingTxt = $currentRating;
            }

            return view('frontend/preview2-product-detail', [
                'category'          => $category,
                'categoryParent'    => $categoryParent,
                'product'           => $product,
                'pageTitle'         => $product->seo_title,
                'pageKeyword'       => $product->seo_keyword,
                'pageDesc'          => $product->seo_description,
                'ratingTxt'         => $ratingTxt,
                'currentRating'     => number_format($currentRating, 1, '.', '.'),
                'ratingNumber'      => $ratingNumber,
                'relatedProducts'   => $product->getRelated2($product, 3),
                'ratings'           => $productRatings,
                'pageImage'         => $product->seo_image,
            ]);
        }

        # It's news detail
        $newsCategory   = NewsCategory::where('slug', $cateSlug)->first();
        $news           = News::where('slug', $productSlug)->first();
        if (!$newsCategory || !$news) {
            dd($newsCategory['id']);
            return redirect('/404');
        }
        $newsCategories = NewsCategory::get();
        $newsModel = new News();
        $newsRelated = $newsModel->getRelated($news, $newsCategory);

        $author = null;
        if ($news->user_id) {
            try {
                $author = User::where('id', $news->user_id)->first();
            } catch (\Throwable $e) {
                // Do nothing
            }
        }

        return view('frontend/news/preview2-detail', [
            'news'          => $news,
            'newsCategories' => $newsCategories,
            'newsRelated'   => $newsRelated,
            'newsCategory'  => $newsCategory,
            'pageImage'     => $news->seo_image,
        ]);
    }
}
