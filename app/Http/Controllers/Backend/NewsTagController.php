<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\CreateNewsTagRequest;
use App\Http\Requests\UpdateNewsTagRequest;
use App\Repositories\NewsTagRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use Illuminate\Support\Facades\View;
use App\Models\Notification;

class NewsTagController extends AppBaseController
{
    /** @var  NewsTagRepository */
    private $productTagRepository;

    public function __construct(NewsTagRepository $productTagRepo)
    {
        $this->newsTagRepository = $productTagRepo;
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
     * Display a listing of the NewsTag.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->newsTagRepository->pushCriteria(new RequestCriteria($request));
        $productTags = $this->newsTagRepository->all();

        return view('news_tags.index')
            ->with('newsTags', $productTags);
    }

    /**
     * Show the form for creating a new ProductTag.
     *
     * @return Response
     */
    public function create()
    {
        return view('news_tags.create');
    }

    /**
     * Store a newly created NewsTag in storage.
     *
     * @param CreateNewsTagRequest $request
     *
     * @return Response
     */
    public function store(CreateNewsTagRequest $request)
    {
        $input = $request->all();

        $productTag = $this->newsTagRepository->create($input);

        Flash::success('News Tag saved successfully.');

        return redirect(route('newsTags.index'));
    }

    /**
     * Display the specified NewsTag.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $productTag = $this->newsTagRepository->findWithoutFail($id);

        if (empty($productTag)) {
            Flash::error('News Tag not found');

            return redirect(route('newsTags.index'));
        }

        return view('news_tags.show')->with('newsTag', $productTag);
    }

    /**
     * Show the form for editing the specified NewsTag.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $productTag = $this->newsTagRepository->findWithoutFail($id);

        if (empty($productTag)) {
            Flash::error('News Tag not found');

            return redirect(route('newsTags.index'));
        }

        return view('news_tags.edit')->with('newsTag', $productTag);
    }

    /**
     * Update the specified NewsTag in storage.
     *
     * @param  int              $id
     * @param UpdateNewsTagRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateNewsTagRequest $request)
    {
        $productTag = $this->newsTagRepository->findWithoutFail($id);

        if (empty($productTag)) {
            Flash::error('News Tag not found');

            return redirect(route('newsTags.index'));
        }

        $productTag = $this->newsTagRepository->update($request->all(), $id);

        Flash::success('News Tag updated successfully.');

        return redirect(route('newsTags.index'));
    }

    /**
     * Remove the specified NewsTag from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $productTag = $this->newsTagRepository->findWithoutFail($id);

        if (empty($productTag)) {
            Flash::error('News Tag not found');

            return redirect(route('newsTags.index'));
        }

        $this->newsTagRepository->delete($id);

        Flash::success('News Tag deleted successfully.');

        return redirect(route('newsTags.index'));
    }
}
