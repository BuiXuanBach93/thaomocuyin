<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\CreateProductSlideRequest;
use App\Http\Requests\UpdateProductSlideRequest;
use App\Repositories\ProductSlideRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class ProductSlideController extends AppBaseController
{
    /** @var  ProductSlideRepository */
    private $productSlideRepository;

    public function __construct(ProductSlideRepository $productSlideRepo)
    {
        $this->productSlideRepository = $productSlideRepo;
    }

    /**
     * Display a listing of the ProductSlide.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->productSlideRepository->pushCriteria(new RequestCriteria($request));
        $productSlides = $this->productSlideRepository->all();

        return view('product_slides.index')
            ->with('productSlides', $productSlides);
    }

    /**
     * Show the form for creating a new ProductSlide.
     *
     * @return Response
     */
    public function create()
    {
        return view('product_slides.create');
    }

    /**
     * Store a newly created ProductSlide in storage.
     *
     * @param CreateProductSlideRequest $request
     *
     * @return Response
     */
    public function store(CreateProductSlideRequest $request)
    {
        $input = $request->all();

        $productSlide = $this->productSlideRepository->create($input);

        Flash::success('Product Slide saved successfully.');

        return redirect(route('productSlides.index'));
    }

    /**
     * Display the specified ProductSlide.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $productSlide = $this->productSlideRepository->findWithoutFail($id);

        if (empty($productSlide)) {
            Flash::error('Product Slide not found');

            return redirect(route('productSlides.index'));
        }

        return view('product_slides.show')->with('productSlide', $productSlide);
    }

    /**
     * Show the form for editing the specified ProductSlide.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $productSlide = $this->productSlideRepository->findWithoutFail($id);

        if (empty($productSlide)) {
            Flash::error('Product Slide not found');

            return redirect(route('productSlides.index'));
        }

        return view('product_slides.edit')->with('productSlide', $productSlide);
    }

    /**
     * Update the specified ProductSlide in storage.
     *
     * @param  int              $id
     * @param UpdateProductSlideRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateProductSlideRequest $request)
    {
        $productSlide = $this->productSlideRepository->findWithoutFail($id);

        if (empty($productSlide)) {
            Flash::error('Product Slide not found');

            return redirect(route('productSlides.index'));
        }

        $productSlide = $this->productSlideRepository->update($request->all(), $id);

        Flash::success('Product Slide updated successfully.');

        return redirect(route('productSlides.index'));
    }

    /**
     * Remove the specified ProductSlide from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $productSlide = $this->productSlideRepository->findWithoutFail($id);

        if (empty($productSlide)) {
            Flash::error('Product Slide not found');

            return redirect(route('productSlides.index'));
        }

        $this->productSlideRepository->delete($id);

        Flash::success('Product Slide deleted successfully.');

        return redirect(route('productSlides.index'));
    }
}
