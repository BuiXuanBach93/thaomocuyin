<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateRatingNewsRequest;
use App\Http\Requests\UpdateRatingNewsRequest;
use App\Repositories\RatingNewsRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class RatingNewsController extends AppBaseController
{
    /** @var  RatingNewsRepository */
    private $ratingNewsRepository;

    public function __construct(RatingNewsRepository $ratingNewsRepo)
    {
        $this->ratingNewsRepository = $ratingNewsRepo;
    }

    /**
     * Display a listing of the RatingNews.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->ratingNewsRepository->pushCriteria(new RequestCriteria($request));
        $ratingNews = $this->ratingNewsRepository->all();

        return view('rating_news.index')
            ->with('ratingNews', $ratingNews);
    }

    /**
     * Show the form for creating a new RatingNews.
     *
     * @return Response
     */
    public function create()
    {
        return view('rating_news.create');
    }

    /**
     * Store a newly created RatingNews in storage.
     *
     * @param CreateRatingNewsRequest $request
     *
     * @return Response
     */
    public function store(CreateRatingNewsRequest $request)
    {
        $input = $request->all();

        $ratingNews = $this->ratingNewsRepository->create($input);

        Flash::success('Rating News saved successfully.');

        return redirect(route('ratingNews.index'));
    }

    /**
     * Display the specified RatingNews.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $ratingNews = $this->ratingNewsRepository->findWithoutFail($id);

        if (empty($ratingNews)) {
            Flash::error('Rating News not found');

            return redirect(route('ratingNews.index'));
        }

        return view('rating_news.show')->with('ratingNews', $ratingNews);
    }

    /**
     * Show the form for editing the specified RatingNews.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $ratingNews = $this->ratingNewsRepository->findWithoutFail($id);

        if (empty($ratingNews)) {
            Flash::error('Rating News not found');

            return redirect(route('ratingNews.index'));
        }

        return view('rating_news.edit')->with('ratingNews', $ratingNews);
    }

    /**
     * Update the specified RatingNews in storage.
     *
     * @param  int              $id
     * @param UpdateRatingNewsRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateRatingNewsRequest $request)
    {
        $ratingNews = $this->ratingNewsRepository->findWithoutFail($id);

        if (empty($ratingNews)) {
            Flash::error('Rating News not found');

            return redirect(route('ratingNews.index'));
        }

        $ratingNews = $this->ratingNewsRepository->update($request->all(), $id);

        Flash::success('Rating News updated successfully.');

        return redirect(route('ratingNews.index'));
    }

    /**
     * Remove the specified RatingNews from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $ratingNews = $this->ratingNewsRepository->findWithoutFail($id);

        if (empty($ratingNews)) {
            Flash::error('Rating News not found');

            return redirect(route('ratingNews.index'));
        }

        $this->ratingNewsRepository->delete($id);

        Flash::success('Rating News deleted successfully.');

        return redirect(route('ratingNews.index'));
    }
}
