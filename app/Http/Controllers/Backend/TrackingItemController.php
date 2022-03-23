<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\AppBaseController;
use App\Models\User;
use App\Models\TrackingItem;
use Illuminate\Http\Request;
use App\Http\Requests\UpdateContactRequest;
use App\Repositories\ContactRepository;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use Faker\Provider\DateTime;
use Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\View;
use App\Models\Notification;


class TrackingItemController extends AppBaseController
{

    public function __construct(ContactRepository $contactRepo)
    {
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
     * Display a listing of the User.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
       $trackingItem = new TrackingItem();
        
        $trackingItems = $trackingItem->orderBy('id', 'desc')
                ->paginate(100);

        return view('tracking.tracking_item')->with('trackingItems', $trackingItems);
        
    }
}