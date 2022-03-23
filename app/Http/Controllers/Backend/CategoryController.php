<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\CreateCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Repositories\CategoryRepository;
use App\Http\Controllers\AppBaseController;
use App\Models\Category;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use Faker\Provider\DateTime;
use Illuminate\Support\Facades\View;
use App\Models\Notification;

class CategoryController extends AppBaseController
{
    /** @var  CategoryRepository */
    private $categoryRepository;

    public function __construct(CategoryRepository $categoryRepo)
    {
        $this->categoryRepository = $categoryRepo;
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
     * Display a listing of the Category.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->categoryRepository->pushCriteria(new RequestCriteria($request));
        $categories = $this->categoryRepository->findByField('status', Category::STATUS_ACTIVE)->all();

        return view('categories.index')
            ->with('categories', $categories);
    }

    /**
     * Show the form for creating a new Category.
     *
     * @return Response
     */
    public function create()
    {
        $categoryModel = new Category();
        $listCategory = $categoryModel->getNameAllCategoriesToUpdate();
        return view('categories.create')->with('listCategory', $listCategory);
    }

    /**
     * Store a newly created Category in storage.
     *
     * @param CreateCategoryRequest $request
     *
     * @return Response
     */
    public function store(CreateCategoryRequest $request)
    {
        $input = $request->all();
        $category = $this->insertCategory($input);
        Flash::success("Thêm danh mục thành công");

        return redirect(route('admin.categories.index'));
    }

    private function insertCategory($request) {
        try {
            $category = new Category();
            $parentId = $request['parent_id'];
            if($parentId == 0){
                $parentId = null;
            }
            $cateId = $category->insertGetId([
                'title' => $request['title'],
                'slug' => $request['slug'],
                'parent_id' => $parentId,
                'content' => $request['content'],
                'seo_title' => $request['seo_title'],
                'seo_description' => $request['seo_description'],
                'seo_keyword' => $request['seo_keyword'],
                'status' =>1,
                'created_at' => new \Datetime(),
                'updated_at' => new \DateTime()
            ]);
        } catch (\Exception $e) {
            Flash::error("Thêm danh mục lỗi");
            Flash::error($e->getMessage());
        }
    }

    /**
     * Display the specified Category.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $category = $this->categoryRepository->findWithoutFail($id);

        if (empty($category)) {
            Flash::error('Category not found');

            return redirect(route('admin.categories.index'));
        }

        return view('categories.show')->with('category', $category);
    }

    /**
     * Show the form for editing the specified Category.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $category = $this->categoryRepository->findWithoutFail($id);

        $categoryModel = new Category();
        $listCategory = $categoryModel->getNameAllCategoriesToUpdate();
        //$listCategory[0] = "--Chọn--";
        if (empty($category)) {
            Flash::error('Category not found');

            return redirect(route('admin.categories.index'));
        }

        return view('categories.edit')->with(['category' => $category,'listCategory'  => $listCategory]);
    }

    /**
     * Update the specified Category in storage.
     *
     * @param  int              $id
     * @param UpdateCategoryRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCategoryRequest $request)
    {
        $category = $this->categoryRepository->findWithoutFail($id);

        if (empty($category)) {
            Flash::error('Category not found');

            return redirect(route('admin.categories.index'));
        }

        $params = $request->all();
        if($params['parent_id'] == 0){
            $params['parent_id'] = null;
        }
        $category = $this->categoryRepository->update($params, $id);

        Flash::success('Category updated successfully.');

        return redirect(route('admin.categories.index'));
    }

    /**
     * Remove the specified Category from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $category = $this->categoryRepository->findWithoutFail($id);

        if (empty($category)) {
            Flash::error('Category not found');

            return redirect(route('admin.categories.index'));
        }

        $this->categoryRepository->delete($id);

        Flash::success('Category deleted successfully.');

        return redirect(route('admin.categories.index'));
    }
}
