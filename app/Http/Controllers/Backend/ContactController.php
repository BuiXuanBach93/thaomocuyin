<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\AppBaseController;
use App\Models\User;
use App\Models\Contact;
use Illuminate\Http\Request;
use App\Http\Requests\UpdateContactRequest;
use App\Repositories\ContactRepository;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use Faker\Provider\DateTime;
use Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\View;
use App\Models\Notification;


class ContactController extends AppBaseController
{
    /** @var  UserRepository */
    private $contactRepository;

    public function __construct(ContactRepository $contactRepo)
    {
        $this->contactRepository = $contactRepo;
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
        $contact = new Contact();
        try {
            if($request->input('product_name')){
                $productName = $request->input('product_name');
                $contact = $contact->where('message','like','%'.$productName.'%');
            }
            if($request->input('phone')){
                $phone = $request->input('phone');
                $contact = $contact->where('phone','like','%'.$phone.'%');
            }

            $contacts = $contact->where('type',0)->orderBy('id', 'desc')
                ->paginate(15);
        } catch (\Exception $e) {
            $contacts = [];
        } finally {
            return view('contacts.list')->with('contacts', $contacts);
        }

    }

    /**
     * Show the form for creating a new User.
     *
     * @return Response
     */
    public function create()
    {
        return view('contacts.add');
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
            $contact = new Contact();
            $contact->insert([
                'name' => $request->input('name'),
                'phone_number' => $request->input('phone_number'),
                'email' => $request->input('email'),
                'address' => $request->input('address'),
                'status' => $request->input('status'),
                'message' => $request->input('message'),
                'content' => $request->input('content'),
                'reply'   => 0,
                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime()
            ]);
        } catch(\Exception $e) {
            Flash::error('Create contact Failure');
        }finally{
            Flash::success('Add new contact success');
            return redirect(route('admin.contacts.index'));
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
        $contact = $this->contactRepository->findWithoutFail($id);
        if (empty($contact)) {
            Flash::error('contact not found');
            return redirect(route('admin.contacts.index'));
        }

        return view('contacts.edit')->with(['contact' => $contact]);
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
        $contact = Contact::where('id',$id)->first();
        if($request->input('type') == 0){
            $this->updateContact($contact, $request);
            return redirect(route('admin.contacts.index'));
        }else{
            $this->updateRemarketingContact($contact, $request);
            return redirect(route('admin.contact-remarketing'));
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
        $user = $this->contactRepository->findWithoutFail($id);

        if (empty($user)) {
            Flash::error('contact not found');

            return redirect(route('admin.contacts.index'));
        }

        $this->contactRepository->delete($id);

        Flash::success('contact deleted successfully.');

        return redirect(route('admin.contacts.index'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function createAppointment(Request $request)
    {
        // if slug null slug create as title
        $this->insertAppointment($request);

        return redirect(route('admin.contact-remarketing'));
    }

    private function insertContact($request) {
        try {
            $contact = new Contact();
            $contact->insert([
                'name' => $request->input('name'),
                'phone' => $request->input('phone'),
                'email' => $request->input('email'),
                'address' => $request->input('address'),
                'reply' => $request->input('status'),
                'message' => $request->input('message'),
                'content' => $request->input('content'),
                'admin_note' => $request->input('admin_note'),
                'pass_to' => $request->input('pass_to'),
                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime()
            ]);
        } catch(\Exception $e) {
            Flash::error('Add contact Failure');
        }
    }

    private function insertAppointment($request) {
        try {
            $contact = new Contact();
            $appDateStr = $request->input('appointment_date_str');
            $appDate = null;
            if($appDateStr){
                $appDate = new \DateTime($appDateStr);
            }
            $contact->insert([
                'name' => $request->input('name'),
                'phone' => $request->input('phone'),
                'email' => $request->input('email'),
                'address' => $request->input('address'),
                'status' => $request->input('status'),
                'message' => $request->input('message'),
                'type' => 1,
                'reply' => 0,
                'admin_note' => $request->input('admin_note'),
                'appointment_date'=>$appDate,
                'order_id' => $request->input('order_id'),
                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime()
            ]);
        } catch(\Exception $e) {
            Flash::error('Add contact Failure');
        }
    }

    private function updateContact($contact, $request) {
        try {
            $appDateStr = $request->input('appointment_date_str');
            $appDate = null;
            if($appDateStr){
                $appDate = new \DateTime($appDateStr);
            }
            
            $contact->update([
                'name' => $request->input('name'),
                'phone' => $request->input('phone'),
                'email' => $request->input('email'),
                'address' => $request->input('address'),
                'reply' => $request->input('reply'),
                'message' => $request->input('message'),
                'product_id' => $request->input('product_id'),
                'content' => $request->input('content'),
                'admin_note' => $request->input('admin_note'),
                'pass_to' => $request->input('pass_to'),
                'is_ordered' => $request->has('is_ordered') ? 1 : 0,
                'updated_at' => new \DateTime()
            ]);
            
        } catch (\Exception $e) {
            
        }
        
    }

    private function updateRemarketingContact($contact, $request) {
        try {
            $appDateStr = $request->input('appointment_date_str');
            $appDate = null;
            if($appDateStr){
                $appDate = new \DateTime($appDateStr);
            }
            if($appDate){
                    $contact->update([
                        'name' => $request->input('name'),
                        'phone_number' => $request->input('phone_number'),
                        'email' => $request->input('email'),
                        'address' => $request->input('address'),
                        'reply' => $request->input('reply'),
                        'message' => $request->input('message'),
                        'product_id' => $request->input('product_id'),
                        'content' => $request->input('content'),
                        'admin_note' => $request->input('admin_note'),
                        'pass_to' => $request->input('pass_to'),
                        'is_ordered' => $request->has('is_ordered') ? 1 : 0,
                        'updated_at' => new \DateTime(),
                        'appointment_date'=>$appDate,
                        'type' => $request->input('type')

                    ]);
                }else{
                    $contact->update([
                        'name' => $request->input('name'),
                        'phone_number' => $request->input('phone_number'),
                        'email' => $request->input('email'),
                        'address' => $request->input('address'),
                        'reply' => $request->input('reply'),
                        'message' => $request->input('message'),
                        'product_id' => $request->input('product_id'),
                        'content' => $request->input('content'),
                        'admin_note' => $request->input('admin_note'),
                        'pass_to' => $request->input('pass_to'),
                        'is_ordered' => $request->has('is_ordered') ? 1 : 0,
                        'updated_at' => new \DateTime(),
                        'type' => $request->input('type')

                    ]);
                }
            
            
        } catch (\Exception $e) {
           
        }
        
    }

    public function updateAdvisorContact(Request $request) {
        try {
            $contactId = $request->input('id');
            $contact = Contact::where('id', $contactId)->first();
            $isOrdered = $contact->is_ordered;
            $contact->update([
                'reply' => $request->input('reply'),
                'content' => $request->input('content'),
                'updated_at' => new \DateTime(),
                'is_ordered' => $request->has('is_ordered') ? 1 : 0
            ]);
            if($isOrdered == 0 && $request->has('is_ordered')){
                $url = "";
                if($request->type == 1){
                    if($request->input('reply') == 1){
                         $url = "/admin/contact-remarketing-done";
                     }else{
                        $url = "/admin/contact-remarketing";
                     }
                   
                }else{
                    $url = "/admin/contacts";
                }
                $notifyDB = new Notification();
                $notifyDB->insert([
                   'title' => 'Đơn tư vấn',
                   'content' => 'Bạn vừa có tư vấn thành đơn',
                   'status' => '0',
                   'url' => asset($url),
                   'created_at' => new \DateTime(),
                   'updated_at' => new \DateTime()
               ]);
            }
            
        } catch (\Exception $e) {
        }finally{
            if($request->type == 0){
                return redirect(route('admin.contacts.contact-advisor'));
            }else{
                return redirect(route('admin.contact-advisor-remarketing'));
            }
        }
    }

    private function getAdvisors() {
        try {
            $userModel = new User();

            $advisors = $userModel->select(
                    'users.id',
                    'users.role',
                    'users.name'
                )->where('users.role', 4)->orderBy('id', 'desc')->get();

            return $advisors;
        } catch (\Exception $e) {
            Log::error('http->admin->ContactController-->getAdvisors: Lỗi lấy dữ liệu advisors');

            return array();
        }
    }

    public function listAdvisorContact()
    {
        $contact = new Contact();
        $userId = Auth::user()->id;
        try {
            $contacts = $contact->where('pass_to', $userId)->where('type', 0)->orderBy('id', 'desc')
                ->paginate(15);
        } catch (\Exception $e) {
            $contacts = null;
        } finally {
             return view('contacts.list_advisor')->with('contacts', $contacts);
        }
    }

    public function listRemarketingContact()
    {
        $contact = new Contact();
        $userId = Auth::user()->id;
    
        $contacts = DB::select('SELECT * FROM contacts where type = 1 and deleted_at is null and reply = 0
             and appointment_date is not null order by abs(datediff(appointment_date, now())) limit 200'); 
       
        return view('contacts.list_remarketing', compact('contacts'));
        
    }

    public function listRemarketingContactDone()
    {
        $contact = new Contact();
        $userId = Auth::user()->id;
        try {
            $contacts = $contact->where('reply', 1)->where('type', 1)->orderBy('id', 'desc')
                ->paginate(15);
        } catch (\Exception $e) {


            $contacts = null;
        } finally {
            return view('contacts.list_remarketing_done', compact('contacts'));
        }
    }

    public function listAdvisorRemarketingContact()
    {
        $contact = new Contact();
        $userId = Auth::user()->id;
        try {
            $contacts = DB::select('SELECT * FROM contacts where type = 1 and reply = 0 and deleted_at is null and appointment_date is not null and pass_to = :assignee order by abs(datediff(appointment_date, now())) limit 200', ['assignee'=>$userId]); 
                
        } catch (\Exception $e) {


            $contacts = null;
        } finally {
            return view('contacts.list_advisor_remarketing', compact('contacts'));
        }
    }

    public function listAdvisorRemarketingContactDone()
    {
        $contact = new Contact();
        $userId = Auth::user()->id;
        try {
            $contacts = $contact->where('reply', 1)->where('type', 1)->where('pass_to', $userId)->orderBy('id', 'desc')
                ->paginate(15);
        } catch (\Exception $e) {


            $contacts = null;
        } finally {
            return view('contacts.list_advisor_remarketing_done', compact('contacts'));
        }
    }

    
}
