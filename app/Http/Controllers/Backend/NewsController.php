<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\CreateNewsRequest;
use App\Http\Requests\UpdateNewsRequest;
use App\Repositories\NewsRepository;
use App\Http\Controllers\AppBaseController;
use App\Models\News;
use App\Models\NewsCategory;
use Illuminate\Http\Request;
use Flash;
use Illuminate\Support\Facades\Auth;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\RatingNews;
use PhpParser\Node\Stmt\TryCatch;
use Illuminate\Support\Facades\Redis;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\View;
use App\Models\Notification;

class NewsController extends AppBaseController
{
    /** @var  NewsRepository */
    private $newsRepository;

    public function __construct(NewsRepository $newsRepo)
    {
        $this->newsRepository = $newsRepo;
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
     * Display a listing of the News.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $notPaidPost = News::where('pay_status', 0)->count();
        $editors = $this->getEditors();

        $this->newsRepository->pushCriteria(new RequestCriteria($request));
        $news = $this->newsRepository->all()->sortByDesc("id");

        return view('news.index',compact('news','notPaidPost','editors'));
    }

    private function getEditors() {
            
            $userModel = new User();

            $advisors = $userModel->select(
                    'users.id',
                    'users.role',
                    'users.name'
                )->where('users.role', 2)->orderBy('id', 'desc')->get();

            foreach($advisors as $editor){
                $notPaidProduct = News::where('pay_status', 0)
                ->where('assignee_id',$editor->id)
                ->whereNull('deleted_at')
                ->count();
                $editor->countNotPaid = $notPaidProduct;
            }
            
            return $advisors;
        }

    /**
     * Show the form for creating a new News.
     *
     * @return Response
     */
    public function create()
    {
        $categoryModel = new NewsCategory();
        $listCategory = $categoryModel->getAllName();

        $userModel = new User();
        $listEditor = $userModel->getEditors();

        return view('news.create', [
            'listCategory'  => $listCategory,
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
            $thumbnail = request()->file('thumbnail');

            // if ($thumbnail) {
            //     $fileName = $thumbnail->getClientOriginalName();
            //     #check exist file name
            //     $exist = News::where('thumbnail', $fileName)->orWhere('thumbnail_home', $fileName)->exists();
            //     if ($exist) {
            //         Flash::error('This file name has been existed');
            //         return redirect(route('admin.product.index'));
            //     }

            //     $thumbnail = uploadImage($thumbnail);
            // }

            $params = $request->all();
            //$params['thumbnail'] = $thumbnail;
            $params['content'] = processImageContent($params['content']);
            # Process SEO image
            /*if (!$params['seo_image']) {
                try {
                    preg_match('/.*data-src="(.*?)\"/', $params['content'], $seoImage);
                    $params['seo_image'] = $seoImage[1];
                } catch (\Throwable $th) {
                    $params['seo_image'] = "";
                }
            }*/

            if($params['thumbnail']){
                $params['seo_image'] = genImage($params['thumbnail']);
            }

            if (isset($params['preview']) && (int) $params['preview'] == 1) {
                $params['status'] = News::STATUS_UNACTIVE;
            } else {
                $params['status'] = News::STATUS_ACTIVE;
            }

            $params['slug'] = str_replace(' ', '', $params['slug']);

            if ($request->hasFile('thumbnail_home')) {
                $fileName = request()->file('thumbnail_home')->getClientOriginalName();
                #check exist file name
                $exist = News::where('thumbnail', $fileName)->orWhere('thumbnail_home', $fileName)->exists();
                if ($exist) {
                    Flash::error('This file name has been existed');
                    return redirect(route('admin.product.index'));
                }

                $params['thumbnail_home'] = uploadImage(request()->file('thumbnail_home'));
            }

            $featured = $request->get('featured', 0);
            $featuredHome = $request->get('featured_home', 0);
            if ($featured === 'on') {
                $featured = 1;
            }

            if ($featuredHome === 'on') {
                $featuredHome = 1;
            }

            $paid = $request->get('pay_status', 0);
            if ($paid === 'on') {
                $paid = 1;
            }
            $params['pay_status'] = $paid;

            $params['user_id'] = Auth::user()->id;

            $currentUser = Auth::user();
            if($currentUser->role != User::ROLE_ADMIN){
                $params['assignee_id'] = Auth::user()->id;
            }   

            $news = $this->newsRepository->create($params);

            # Update site map
            $commonController = new DashboardController(false, true);
            $commonController->siteMap(false, true);

            # Create rating
            $ratingRandom = ratingRandom();
            foreach ($ratingRandom as $random) {
                $ratingNews = new RatingNews();
                $ratingNews->news_id = $news->id;
                $ratingNews->rating = $random;
                $ratingNews->save();
            }

            DB::commit();
            Flash::success('News saved successfully.');
            return redirect(route('admin.news.index'));
        } catch (\Throwable $e) {
            DB::rollBack();
            Flash::error($e->getMessage());
            return redirect(route('admin.product.index'));
        }
    }

    /**
     * Display the specified News.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $news = $this->newsRepository->findWithoutFail($id);

        if (empty($news)) {
            Flash::error('News not found');

            return redirect(route('admin.news.index'));
        }

        return view('admin.news.show')->with('news', $news);
    }

    /**
     * Show the form for editing the specified News.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $categoryModel = new NewsCategory();
        $listCategory = $categoryModel->getAllName();

        $userModel = new User();
        $listEditor = $userModel->getEditors();

        $news = $this->newsRepository->findWithoutFail($id);

        $currentUser = Auth::user();
        if ($currentUser->role != User::ROLE_ADMIN && $currentUser->id != $news->user_id && $currentUser->id != $news->assignee_id) {
            Flash::error('Bài viết này được giao cho người khác, không có quyền sửa');
            return redirect(route('admin.news.index'));
        }

        if (empty($news)) {
            Flash::error('News not found');

            return redirect(route('admin.news.index'));
        }

        return view('news.edit')->with([
            'news' => $news,
            'listCategory'  => $listCategory,
            'listEditor' => $listEditor,
        ]);
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
        $news = $this->newsRepository->findWithoutFail($id);

        if (empty($news)) {
            Flash::error('News not found');

            return redirect(route('admin.news.index'));
        }

        $currentUser = Auth::user();
        if ($currentUser->role != User::ROLE_ADMIN && $currentUser->id != $news->user_id && $currentUser->id != $news->assignee_id) {
            Flash::error('Bài viết này được giao cho người khác, không có quyền sửa');
            return redirect(route('admin.news.index'));
        }

        if ($currentUser->role != User::ROLE_ADMIN && $news->status == 1) {
            Flash::error('Bài này đã được public, không có quyền sửa');
            return redirect(route('admin.news.index'));
        }   

        $params = $request->all();
        # Check slug is changed
        if ($news->status == News::STATUS_ACTIVE && $params['slug'] != $news->slug) {
            Flash::error('Không được thay đổi slug khi đã publish bài viết');
            return redirect(route('admin.news.index'));
        }
        $params['content'] = processImageContent($params['content']);
        # Process SEO image
        /*if (!$params['seo_image']) {
            try {
                preg_match('/.*data-src="(.*?)\"/', $params['content'], $seoImage);
                $params['seo_image'] = $seoImage[1];
            } catch (\Throwable $th) {
                $params['seo_image'] = "";
            }
        }*/

        if(!$params['thumbnail']){
            unset($params['thumbnail']);
        }else{
            $params['seo_image'] = genImage($params['thumbnail']);
        }

        if (isset($params['preview']) && (int) $params['preview'] == 1) {
            $params['status'] = News::STATUS_UNACTIVE;
        } else {
            $params['status'] = News::STATUS_ACTIVE;
            $params['public_at'] = date("Y-m-d H:i:s", time());
        }
        $params['slug'] = str_replace(' ', '', $params['slug']);

        $paid = $request->get('pay_status', 0);
            if ($paid === 'on') {
                $paid = 1;
            }
        $params['pay_status'] = $paid;

        /*if ($request->hasFile('thumbnail')) {
            $fileName = request()->file('thumbnail')->getClientOriginalName();
            #check exist file name
            $exist = News::where('thumbnail', $fileName)->orWhere('thumbnail_home', $fileName)->exists();
            if ($exist) {
                Flash::error('This file name has been existed');
                return redirect(route('admin.product.index'));
            }

            $thumbnail = uploadImage(request()->file('thumbnail'));
            $params['thumbnail'] = $thumbnail;
        } else {
            unset($params['thumbnail']);
        }*/

        /*if ($request->hasFile('thumbnail_home')) {
            $fileName = request()->file('thumbnail_home')->getClientOriginalName();
            #check exist file name
            $exist = News::where('thumbnail', $fileName)->orWhere('thumbnail_home', $fileName)->exists();
            if ($exist) {
                Flash::error('This file name has been existed');
                return redirect(route('admin.product.index'));
            }
            $params['thumbnail_home'] = uploadImage(request()->file('thumbnail_home'));
        } else {
            unset($params['thumbnail_home']);
        }*/
        $news = $this->newsRepository->update($params, $id);

        # Update site map
        $commonController = new DashboardController(false, true);
        $commonController->siteMap(false, true);

        // Clean redis key
        $cachedKeyMobile = "tmut_mobile_".$news->slug;
        $cachedKeyDesktop = "tmut_desktop_".$news->slug;
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

        Flash::success('News updated successfully.');

        return redirect(route('admin.news.index'));
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
        $news = $this->newsRepository->findWithoutFail($id);

        if (empty($news)) {
            Flash::error('News not found');

            return redirect(route('admin.news.index'));
        }

        $currentUser = Auth::user();
        if ($currentUser->role != User::ROLE_ADMIN && $currentUser->id != $news->user_id) {
            Flash::error('Bài viết này không phải bạn tạo ra, nên không có quyền xoá');
            return redirect(route('admin.news.index'));
        }
        if ($currentUser->role != User::ROLE_ADMIN && $news->status == 1) {
            Flash::error('Bài này đã được public, không có quyền xóa');
            return redirect(route('admin.news.index'));
        }
        $this->newsRepository->delete($id);

        Flash::success('News deleted successfully.');

        return redirect(route('admin.news.index'));
    }

    public function updateCanonical()
    {
        $newses = $this->newsRepository->all()->sortByDesc("id");
        $canonicals = [];
        foreach($newses as $news) {
            if(!$news->canonical) {
                continue;
            }
            $canonicals[$news->slug] = $news->canonical;
        }
        Redis::set('tmut_canonical_urls', json_encode($canonicals));
        echo "Total:".count($canonicals)." canonical urls"; exit;
        
    }

     public function anyDatatables() {
        $newses = News::leftjoin('news_categories', 'news.news_category_id', '=', 'news_categories.id')
            ->leftjoin('users', 'news.assignee_id', '=', 'users.id')
            ->select(
                'news.*',
                'news_categories.title as category_title',
                'news_categories.slug as category_slug',
                'users.name as assignee_name'
            );


        return Datatables::of($newses)
            ->addColumn('action', function($news) {

                $string =  '<a href="'.route('admin.news.edit', ['id' => $news->id]).'">
                           <button class="btn btn-primary"><i class="fa fa-pencil" aria-hidden="true"></i></button>
                       </a>';
                $string .= '<a  href="'.route('admin.news.destroy', ['id' => $news->id]).'" class="btn btn-danger btnDelete" 
                            data-toggle="modal" data-target="#myModalDelete" onclick="return submitDelete(this);">
                               <i class="fa fa-trash-o" aria-hidden="true"></i>
                            </a>';
                return $string;
            })
            ->orderColumn('news.id', 'news.id desc')
            ->make(true);
    }

    public function payPostForEditor(Request $request) {
        try{
            $editorId = $request->input('editorId');
            
            $values = News::where('assignee_id', $editorId)
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
