<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\CreateReplyRequest;
use App\Http\Requests\UpdateReplyRequest;
use App\Repositories\ReplyRepository;
use App\Http\Controllers\AppBaseController;
use App\Models\Reply;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use Illuminate\Support\Facades\View;
use App\Models\Notification;

class ReplyController extends AppBaseController
{
    /** @var  ReplyRepository */
    private $replyRepository;

    public function __construct(ReplyRepository $replyRepo)
    {
        $this->replyRepository = $replyRepo;
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
     * Display a listing of the Reply.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->replyRepository->pushCriteria(new RequestCriteria($request));
        $replies = $this->replyRepository->orderBy('id', 'desc')->all();

        return view('replies.index')
            ->with('replies', $replies);
    }

    /**
     * Show the form for creating a new Reply.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.replies.create');
    }

    /**
     * Store a newly created Reply in storage.
     *
     * @param CreateReplyRequest $request
     *
     * @return Response
     */
    public function store(CreateReplyRequest $request)
    {
        $input = $request->all();

        $reply = $this->replyRepository->create($input);

        Flash::success('Reply saved successfully.');

        return redirect(route('replies.index'));
    }

    /**
     * Display the specified Reply.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $reply = $this->replyRepository->findWithoutFail($id);

        if (empty($reply)) {
            Flash::error('Reply not found');

            return redirect(route('replies.index'));
        }

        return view('admin.replies.show')->with('reply', $reply);
    }

    /**
     * Show the form for editing the specified Reply.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $reply = $this->replyRepository->findWithoutFail($id);

        if (empty($reply)) {
            Flash::error('Reply not found');

            return redirect(route('replies.index'));
        }

        return view('admin.replies.edit')->with('reply', $reply);
    }

    /**
     * Update the specified Reply in storage.
     *
     * @param  int              $id
     * @param UpdateReplyRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateReplyRequest $request)
    {
        $reply = $this->replyRepository->findWithoutFail($id);

        if (empty($reply)) {
            Flash::error('Reply not found');

            return redirect(route('replies.index'));
        }

        $reply = $this->replyRepository->update($request->all(), $id);

        Flash::success('Reply updated successfully.');

        return redirect(route('replies.index'));
    }

    /**
     * Remove the specified Reply from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $reply = $this->replyRepository->findWithoutFail($id);

        if (empty($reply)) {
            Flash::error('Reply not found');

            return redirect(route('replies.index'));
        }

        $this->replyRepository->delete($id);

        Flash::success('Reply deleted successfully.');

        return redirect(route('replies.index'));
    }

    public function read(Request $request) {
        $isRead = $request->input('is_read');
        $replyID = $request->input('reply_id');
        $reply = $this->replyRepository->findWithoutFail($replyID);

        if (empty($reply)) {
            exit;
        }
        $reply->read = $isRead;
        $reply->save();
    }
}
