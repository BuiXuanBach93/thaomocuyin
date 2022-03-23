<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\CreateNewsCategoryRequest;
use App\Http\Requests\UpdateNewsCategoryRequest;
use App\Repositories\NewsCategoryRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use Illuminate\Support\Facades\View;
use App\Models\Notification;

class NewsCategoryController extends AppBaseController
{
    /** @var  NewsCategoryRepository */
    private $newsCategoryRepository;

    public function __construct(NewsCategoryRepository $newsCategoryRepo)
    {
        $this->newsCategoryRepository = $newsCategoryRepo;
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
     * Display a listing of the NewsCategory.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->newsCategoryRepository->pushCriteria(new RequestCriteria($request));
        $newsCategories = $this->newsCategoryRepository->all();

        return view('news_categories.index')
            ->with('newsCategories', $newsCategories);
    }

    /**
     * Show the form for creating a new NewsCategory.
     *
     * @return Response
     */
    public function create()
    {
        return view('news_categories.create');
    }

    /**
     * Store a newly created NewsCategory in storage.
     *
     * @param CreateNewsCategoryRequest $request
     *
     * @return Response
     */
    public function store(CreateNewsCategoryRequest $request)
    {
        $input = $request->all();

        $newsCategory = $this->newsCategoryRepository->create($input);

        Flash::success('News Category saved successfully.');

        return redirect(route('admin.newsCategories.index'));
    }

    /**
     * Display the specified NewsCategory.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $newsCategory = $this->newsCategoryRepository->findWithoutFail($id);

        if (empty($newsCategory)) {
            Flash::error('News Category not found');

            return redirect(route('newsCategories.index'));
        }

        return view('news_categories.show')->with('newsCategory', $newsCategory);
    }

    /**
     * Show the form for editing the specified NewsCategory.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $newsCategory = $this->newsCategoryRepository->findWithoutFail($id);

        if (empty($newsCategory)) {
            Flash::error('News Category not found');

            return redirect(route('newsCategories.index'));
        }

        return view('news_categories.edit')->with('newsCategory', $newsCategory);
    }

    /**
     * Update the specified NewsCategory in storage.
     *
     * @param  int              $id
     * @param UpdateNewsCategoryRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateNewsCategoryRequest $request)
    {
        $newsCategory = $this->newsCategoryRepository->findWithoutFail($id);

        if (empty($newsCategory)) {
            Flash::error('News Category not found');

            return redirect(route('admin.newsCategories.index'));
        }

        $newsCategory = $this->newsCategoryRepository->update($request->all(), $id);

        Flash::success('News Category updated successfully.');

        return redirect(route('admin.newsCategories.index'));
    }

    /**
     * Remove the specified NewsCategory from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $newsCategory = $this->newsCategoryRepository->findWithoutFail($id);

        if (empty($newsCategory)) {
            Flash::error('News Category not found');

            return redirect(route('admin.newsCategories.index'));
        }

        $this->newsCategoryRepository->delete($id);

        Flash::success('News Category deleted successfully.');

        return redirect(route('admin.newsCategories.index'));
    }
}
