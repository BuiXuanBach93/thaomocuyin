<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\UpdateUserRequest;
use App\Repositories\UserRepository;
use App\Http\Controllers\AppBaseController;
use App\Models\User;
use Illuminate\Http\Request;
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


class UserController extends AppBaseController
{
    /** @var  UserRepository */
    private $userRepository;

    public function __construct(UserRepository $userRepo)
    {
        $this->userRepository = $userRepo;
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
        $this->userRepository->pushCriteria(new RequestCriteria($request));
        $users = User::orderBy('id', 'desc')
                    ->get();

        return view('users.list')
            ->with('users', $users);
    }

    /**
     * Show the form for creating a new User.
     *
     * @return Response
     */
    public function create()
    {
        return view('users.add');
    }

    /**
     * Store a newly created User in storage.
     *
     * @param CreateUserRequest $request
     *
     * @return Response
     */
    public function store(Request $request)
    {
        try {
            $validation = Validator::make($request->all(), [
                'email' => 'required | unique:users',
            ]);

            // if validation fail return error
            if ($validation->fails()) {
                return redirect('admin/users/create')
                    ->withErrors($validation)
                    ->withInput();
            }

            // insert to database
            $user = new User();
            $userId = $user->insertGetId([
                'email' => $request->input('email'),
                'password' => bcrypt($request->input('password')),
                'slug' => $request->input('slug'),
                'avatar' => $request->input('avatar'),
                'name' => $request->input('name'),
                'nick_name' => $request->input('nick_name'),
                'description' => $request->input('description'),
                'role' => $request->input('role'),
                'created_at' => new \Datetime(),
                'updated_at' => new \DateTime()
            ]);

        } catch (\Exception $e) {
            Flash::error('Create User Failure');
        } finally {
            Flash::success('Add new user success');
            return redirect(route('admin.users.index'));
        }
    }

    /**
     * Show the form for editing the specified User.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $user = $this->userRepository->findWithoutFail($id);
        if (empty($user)) {
            Flash::error('User not found');
            return redirect(route('admin.users.index'));
        }

        return view('users.edit')->with(['user' => $user]);
    }

    /**
     * Update the specified User in storage.
     *
     * @param  int              $id
     * @param UpdateUserRequest $request
     *
     * @return Response
     */
    public function update($id, Request $request)
    {
        $user = $this->userRepository->findWithoutFail($id);
        if (empty($user)) {
            Flash::error('User not found');

            return redirect(route('admin.users.index'));
        }

        try  {
            $validation = Validator::make($request->all(), [
                'email' =>  Rule::unique('users')->ignore($user->id, 'id'),
            ]);

            // if validation fail return error
            if ($validation->fails()) {
                return redirect(route('admin.users.edit', ['id' => $user->id]))
                    ->withErrors($validation)
                    ->withInput();
            }
            $userModel = new User;
            $isChangePassword = $request->input('is_change_password');
            if ($isChangePassword == 1) {
                $userModel->where('id', '=', $id)->update([
                    'password' =>  bcrypt($request->input('password'))
                ]);
            }
            // update to database
            $userModel->where('id', '=', $id)->update([
                'email' => $request->input('email'),
                'slug' => $request->input('slug'),
                'avatar' => $request->input('avatar'),
                'name' => $request->input('name'),
                'nick_name' => $request->input('nick_name'),
                'description' => $request->input('description'),
                'role' => $request->input('role'),
                'updated_at' => new \DateTime()
            ]);

        } catch (\Exception $e) {
            Flash::error('Update User Failure');
        } finally {
            Flash::success('Update Success');
            return redirect(route('admin.users.index'));
        }
    }

    /**
     * Remove the specified User from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $user = $this->userRepository->findWithoutFail($id);

        if (empty($user)) {
            Flash::error('User not found');

            return redirect(route('admin.users.index'));
        }

        $this->userRepository->delete($id);

        Flash::success('User deleted successfully.');

        return redirect(route('admin.users.index'));
    }
}
