<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\CreateNewsRequest;
use App\Http\Requests\UpdateNewsRequest;
use App\Repositories\ProductRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use App\Repositories\CategoryRepository;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Product;
use App\Models\Provider;
use App\Models\Rating;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\View;
use App\Models\Notification;

class ProductController extends AppBaseController
{
    /** @var  ProductRepository */
    private $productRepository;

    public function __construct(ProductRepository $productRepo)
    {
        $this->productRepository = $productRepo;
        try {
            $countNotification = new Notification();
            $countReport = $countNotification->countReport();
            $notifications = Notification::orderBy('id', 'desc')
                ->offset(0)->limit(10)->get();

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

    /**
     * Display a listing of the products.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $notPaidProduct = Product::where('pay_status', 0)->count();
        $editors = $this->getEditors();

        $this->productRepository->pushCriteria(new RequestCriteria($request));
        $products = $this->productRepository->all()->sortByDesc("id");

        return view('products.index',compact('products','notPaidProduct','editors'));
    }

    private function getEditors() {
            
            $userModel = new User();

            $advisors = $userModel->select(
                    'users.id',
                    'users.role',
                    'users.name'
                )->where('users.role', 2)->orderBy('id', 'desc')->get();

            foreach($advisors as $editor){
                $notPaidProduct = Product::where('pay_status', 0)
                ->where('assignee_id',$editor->id)
                ->whereNull('deleted_at')
                ->count();
                $editor->countNotPaid = $notPaidProduct;
            }
            
            return $advisors;
        }

    /**
     * Show the form for creating a new Product.
     *
     * @return Response
     */
    public function create()
    {
        $categoryModel = new Category();
        $listCategory = $categoryModel->getNameSubCategories();

        $providerModel = new Provider();
        $providers = $providerModel->getNameProviders();

        $userModel = new User();
        $listEditor = $userModel->getEditors();

        return view('products.create', [
            'listCategory'  => $listCategory,
            'providers'  => $providers,
            'listEditor' => $listEditor
        ]);
    }

    /**
     * Store a newly created News in storage.
     *
     * @param CreateNewsRequest $request
     *
     * @return Response
     */
    public function store(CreateNewsRequest $request)
    {
        DB::beginTransaction();
        try {
            $params = $request->all();
            if (isset($params['preview']) && (int) $params['preview'] == 1) {
                $params['status'] = Product::STATUS_UNACTIVE;
            } else {
                $params['status'] = Product::STATUS_ACTIVE;
            }

            $params['slug'] = str_replace(' ', '', $params['slug']);
            if($params['thumbnail']){
                $params['seo_image'] = genImage($params['thumbnail']);
            }

            # Process image content
            $params['content'] = processImageContent($params['content']);

            // Create a category if it is not existed
            if(!$params['provider_id']) {
                $provider = Provider::create([
                    'title'         => $params['provider_name'],
                    'slug'          => str_slug($params['provider_name'], '-', 'vi'),
                    'from'          => $params['nation'],
                    'from_slug'     => str_slug($params['nation'], '-', 'vi'),
                    'seo_title'     => $params['provider_name'],
                    'seo_keyword'   => $params['provider_name'],
                    'seo_description'   => $params['provider_name'],
                ]);
                $params['provider_id'] = $provider->id;
            }
            
            $featured = $request->get('featured', 0);
            if ($featured === 'on') {
                $featured = 1;
            }

            $featuredHome = $request->get('featured_home', 0);
            if ($featuredHome === 'on') {
                $featuredHome = 1;
            }

            $justView = $request->get('just_view', 0);
            if ($justView === 'on') {
                $justView = 1;
            }
            
            $freeGift = $request->get('is_free_gift', 0);
            if ($freeGift === 'on') {
                $freeGift = 1;
            }
            
            
            $paid = $request->get('pay_status', 0);
            if ($paid === 'on') {
                $paid = 1;
            }
            

            $params['featured'] = $featured;
            $params['featured_home'] = $featuredHome;
            $params['just_view'] = $justView;
            $params['is_free_gift'] = $freeGift;
            $params['pay_status'] = $paid;
            $params['user_id'] = Auth::user()->id;

            $currentUser = Auth::user();
            if($currentUser->role != User::ROLE_ADMIN){
                $params['assignee_id'] = Auth::user()->id;
            }   
            $product = $this->productRepository->create($params);

            #Update updated_at of category
            $categoryID = $request->get('category_id');
            $productCate = Category::whereId($categoryID);
            $productCate->update(['updated_at' => Date('Y-m-d H:i:s')]);

            DB::commit();

            $commonController = new DashboardController();
            $commonController->siteMap(true);

            Flash::success('News saved successfully.');
            return redirect(route('admin.product.index'));
        } catch (\Throwable $e) {
            DB::rollBack();
            Flash::error($e->getMessage());
            return redirect(route('admin.product.index'));
        }
    }

    /**
     * Display the specified products.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $product = $this->productRepository->findWithoutFail($id);

        if (empty($product)) {
            Flash::error('News not found');

            return redirect(route('admin.product.index'));
        }

        return view('products.show')->with('product', $product);
    }

    /**
     * Show the form for editing the specified products.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $product = $this->productRepository->findWithoutFail($id);

        if (empty($product)) {
            Flash::error('Products not found');

            return redirect(route('admin.product.index'));
        }
        $currentUser = Auth::user();
        if ($currentUser->role != User::ROLE_ADMIN && $currentUser->id != $product->user_id && $currentUser->id != $product->assignee_id) {
            Flash::error('Bài này được giao cho người khác nên không có quyền cập nhật');
            return redirect(route('admin.product.index'));
        }

        $categoryModel = new Category();
        $listCategory = $categoryModel->getNameSubCategories();

        $userModel = new User();
        $listEditor = $userModel->getEditors();

        $providerModel = new Provider();
        $providers = $providerModel->getNameProviders();

        return view(
            'products.edit',
            [
                'listCategory'  => $listCategory,
                'listEditor'    => $listEditor,
                'product'       => $product,
                'providers'     => $providers
            ]
        )->with('product', $product);
    }

    /**
     * Update the specified News in storage.
     *
     * @param  int              $id
     * @param UpdateNewsRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateNewsRequest $request)
    {
        $product = $this->productRepository->findWithoutFail($id);

        if (empty($product)) {
            Flash::error('News not found');

            return redirect(route('admin.product.index'));
        }

        $currentUser = Auth::user();
        if ($currentUser->role != User::ROLE_ADMIN && $currentUser->id != $product->user_id && $currentUser->id != $product->assignee_id) {
            Flash::error('Bài này được giao cho người khác nên không có quyền cập nhật');
            return redirect(route('admin.product.index'));
        }

        if ($currentUser->role != User::ROLE_ADMIN && $product->status == 1) {
            Flash::error('Bài này đã được public, không có quyền sửa');
            return redirect(route('admin.product.index'));
        }

        $params = $request->all();

        # Check slug is changed
        if ($product->status == Product::STATUS_ACTIVE && $params['slug'] != $product->slug) {
            Flash::error('Không được thay đổi slug khi đã publish bài viết');
            return redirect(route('admin.product.index'));
        }

        $params['slug'] = str_replace(' ', '', $params['slug']);
        if (isset($params['preview']) && (int) $params['preview'] == 1) {
            $params['status'] = Product::STATUS_UNACTIVE;
        } else {
            $params['status'] = Product::STATUS_ACTIVE;
        }
        if(!$params['thumbnail']){
            unset($params['thumbnail']);
        }else{
            $params['seo_image'] = genImage($params['thumbnail']);
        }
        if(!$params['thumbnail_home']){
            unset($params['thumbnail_home']);
        }
        if(!$params['image_list']){
            unset($params['image_list']);
        }

        // Create a category if it is not existed
        if(!$params['provider_id']) {
            $provider = Provider::create([
                'title'         => $params['provider_name'],
                'slug'          => str_slug($params['provider_name'], '-', 'vi'),
                'from'          => $params['nation'],
                'from_slug'     => str_slug($params['nation'], '-', 'vi'),
                'seo_title'     => $params['provider_name'],
                'seo_keyword'   => $params['provider_name'],
                'seo_description'   => $params['provider_name'],
            ]);
            $params['provider_id'] = $provider->id;
        }

        $featured = $request->get('featured', 0);
        $featuredHome = $request->get('featured_home', 0);
        if ($featured === 'on') {
            $featured = 1;
        }

        if ($featuredHome === 'on') {
            $featuredHome = 1;
        }

        $justView = $request->get('just_view', 0);
        if ($justView === 'on') {
            $justView = 1;
        }
        if ($currentUser->role == User::ROLE_ADMIN) {
            $freeGift = $request->get('is_free_gift', 0);
            if ($freeGift === 'on') {
                $freeGift = 1;
            }
            $params['is_free_gift'] = $freeGift;
        }

        if ($currentUser->role == User::ROLE_ADMIN) {
           $paid = $request->get('pay_status', 0);
            if ($paid === 'on') {
                $paid = 1;
            }
            $params['pay_status'] = $paid;
        }


        $params['featured'] = $featured;
        $params['featured_home'] = $featuredHome;
        $params['just_view'] = $justView;
        
        $params['content'] = processImageContent($params['content']);

        $product = $this->productRepository->update($params, $id);

        #Update updated_at of category
        $categoryID = $request->get('category_id');
        $productCate = Category::whereId($categoryID);
        $productCate->update(['updated_at' => Date('Y-m-d H:i:s')]);

        # Update site map
        $commonController = new DashboardController();
        $commonController->siteMap(true);

        DB::commit();


        // Clean redis key
        $cachedKeyMobile = "mobile_".$product->slug;
        $cachedKeyDesktop = "desktop_".$product->slug;
        try {
            Redis::del(Redis::keys($cachedKeyMobile));
        } catch (\Throwable $th) {
            // do nothing
        }
        try {
            Redis::del(Redis::keys($cachedKeyDesktop));
        } catch (\Throwable $th) {
            // do nothing
        }

        Flash::success('Cập nhật sản phẩm thành công.');

        return redirect(route('admin.product.index'));
    }

    /**
     * Remove the specified News from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $product = $this->productRepository->findWithoutFail($id);

        if (empty($product)) {
            Flash::error('News not found');

            return redirect(route('admin.product.index'));
        }

        $currentUser = Auth::user();
        if ($currentUser->role != User::ROLE_ADMIN && $currentUser->id != $product->user_id) {
            Flash::error('Bài viết này không phải bạn tạo ra, nên không có xoá');
            return redirect(route('admin.product.index'));
        }

        if ($currentUser->role != User::ROLE_ADMIN && $product->status == 1) {
            Flash::error('Bài này đã được public, không có quyền xóa');
            return redirect(route('admin.product.index'));
        }

        $this->productRepository->delete($id);

        Flash::success('News deleted successfully.');

        return redirect(route('admin.product.index'));
    }


    public function ratingSeeding(Request $request, $id)
    {
        $ratings = Rating::where('product_id', $id)->get();
        $product = $this->productRepository->findWithoutFail($id);

        if ($request->isMethod('post')) {
            try {
                DB::beginTransaction();
                $customerRatings = $request->input('customer_rating');
                $adminRatings = $request->input('admin_rating');
                foreach ($customerRatings as $key => $customerRating) {
                    if (!$customerRating) {
                        continue;
                    }

                    $rating = Rating::create([
                        'product_id'  => (int) $id,
                        'customer_name' => RandomCustomerName(),
                        'content'       => strip_tags($customerRating),
                        'rating'        => 5,
                        'ip'            => get_client_ip(),
                        'is_admin'      => Rating::IS_ADMIN_FALSE,
                    ]);

                    Rating::create([
                        'product_id'  => (int) $id,
                        'customer_name' => 'Thảo Mộc Uy Tín',
                        'content'       => strip_tags($adminRatings[$key]),
                        'rating'        => 5,
                        'ip'            => get_client_ip(),
                        'parent_id'     => $rating->id,
                        'is_admin'      => Rating::IS_ADMIN_TRUE,
                    ]);
                }
                DB::commit();
                Flash::success('Rating sedding created successfully');
                return redirect(route('admin.product.index'));
            } catch (\Throwable $e) {
                DB::rollBack();
                Flash::error($e->getMessage());
                return redirect(route('admin.product.index'));
            }
        }

        return view('products.rating_seeding', [
            'ratings' => $ratings,
            'product'  => $product
        ]);
    }

    public function anyDatatables() {

        $currentUser = Auth::user();

        if ($currentUser->role == User::ROLE_ADMIN) {
            $products = Product::leftjoin('categories', 'products.category_id', '=', 'categories.id')
            ->leftjoin('providers', 'products.provider_id', '=', 'providers.id')
            ->leftjoin('users', 'products.assignee_id', '=', 'users.id')
            ->select(
                'products.*',
                'categories.title as category_title',
                'categories.slug as category_slug',
                'providers.title as provider_title',
                'users.name as assignee_name'
            );
        }else{
            $currentUserId = $currentUser->id;
            $products = Product::leftjoin('categories', 'products.category_id', '=', 'categories.id')
            ->leftjoin('providers', 'products.provider_id', '=', 'providers.id')
            ->leftjoin('users', 'products.assignee_id', '=', 'users.id')
            ->select(
                'products.*',
                'categories.title as category_title',
                'categories.slug as category_slug',
                'providers.title as provider_title',
                'users.name as assignee_name'
            )->where('products.user_id','=',$currentUserId)->orWhere('products.assignee_id','=',$currentUserId);
        }


        return Datatables::of($products)
            ->addColumn('action', function($product) {
                
                $string =  '<a href="/admin/product/'.$product->id.'/rating">
                           <button class="btn btn-primary"><i class="glyphicon glyphicon-comment" aria-hidden="true"></i></button>
                       </a>';

                $string .=  '<a href="'.route('admin.product.edit', ['id' => $product->id]).'">
                           <button class="btn btn-primary"><i class="fa fa-pencil" aria-hidden="true"></i></button>
                       </a>';
                $string .= '<a  href="'.route('admin.product.destroy', ['id' => $product->id]).'" class="btn btn-danger btnDelete" 
                            data-toggle="modal" data-target="#myModalDelete" onclick="return submitDelete(this);">
                               <i class="fa fa-trash-o" aria-hidden="true"></i>
                            </a>';
                return $string;
            })
            ->orderColumn('products.id', 'products.id desc')
            ->make(true);
    }

    public function payProductForEditor(Request $request) {
        try{
            $editorId = $request->input('editorId');
            
            $values = Product::where('assignee_id', $editorId)
            ->where('pay_status', 0)
            ->update(['pay_status'=>1]);

            return response([
                'httpCode' => 200
            ])->header('Content-Type', 'text/plain');

        } catch (\Exception $e) {
            Log::error('http->site->OrderController->trackPhone');

            return redirect('/');
        }
    }
}
