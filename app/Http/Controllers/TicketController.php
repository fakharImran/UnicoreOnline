<?php

namespace App\Http\Controllers;

use Validator;
use App\Models\User;
use App\Models\Ticket;
use App\Mail\AdminMail;
use App\Models\Company;
use App\Mail\TicketMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use App\Mail\UpdateTicketByAdminMailToUser;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:ticket-index|ticket-create|ticket-edit|ticket-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:ticket-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:ticket-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:ticket-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         $pageConfigs = ['pageSidebar' => 'ticket'];    
         $user = Auth::user();
        if(Auth::user()->hasRole('admin')){
            $tickets= Ticket::all();
            $companies= Company::all();
            // dd($companies);
        }
        else{
            $companies = $user->companyUser->company; //for getting single company
            $tickets = $companies->tickets;
            // dd($tickets);

        }
        // dd($c ompanies);


        return view('Admin.Tickets.index', compact('user','tickets', 'companies'), ['pageConfigs' => $pageConfigs]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user();

        if(Auth::user()->hasRole('admin')){
            // return redirect()->back()->withErrors("Admin cannot create Tickcts right now")->withInput();
            $companies = Company::all();
        }
        else{
            $companies = $user->companyUser->company; //for getting single company
            // $tickets = $companies->tickets;
            // dd($tickets);

        }
        // dd($companies);

        $pageConfigs = ['pageSidebar' => 'ticket'];  
        $user= Auth::user();

        return view('Admin.Tickets.create',compact('user','companies'), ['pageConfigs' => $pageConfigs]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
                // dd($request->all());
                $validator = Validator::make($request->all(), [
                    'state' => 'required',
                    'ticket_number' => 'required',
                    'created_by' => 'required',
                    'module_name' => 'required',
                    'description' => 'required',
                    'severity' => 'required',
                    'incident_type' => 'required',
                    // 'attachments' => 'required|mimes:xlsx,xls,png,doc,docx,pdf,jpeg,jpg|max:100000',
                ]);

                if ($validator->fails()) {
                    // Validation failed
                    return redirect()->back()->withErrors($validator)->withInput();
                }
               
                $user= Auth::user();
                if($user->hasRole('admin'))
                {
                    $validator = Validator::make($request->all(), [
                        'company_id' => 'required',
                        // 'attachments' => 'required|mimes:xlsx,xls,png,doc,docx,pdf,jpeg,jpg|max:100000',
                    ]);
                    if ($validator->fails()) {
                        // Validation failed
                        return redirect()->back()->withErrors("Company Name is Required")->withInput();
                    }
                $company_id= $request->company_id;
                    $comment_type = "dev";
                }
                else
                {
                    $company_id= $user->companyUser->company->id;
                    $comment_type = "user";
                }
                
               
                // dd($company_id);
                $tempTicket = new Ticket();
                $tempTicket->company_id=$company_id;
                $tempTicket->state = $request->state ?? null;
                $tempTicket->ticket_number = $request->ticket_number ?? null;
                $tempTicket->created_by = $request->created_by ?? null;
                $tempTicket->module_name = $request->module_name ?? null;
                $tempTicket->description = $request->description ?? null;
                $tempTicket->severity = $request->severity ?? null;
                $tempTicket->incident_type = $request->incident_type ?? null;
                
// dd($tempTicket->comments);
                $tempTicket->save();
                if($request->comment){
                    foreach ($request->comment as $key => $comment) {
                        $tempTicket->comments()->create(['comment' => $comment, 'ticket_id'=> $tempTicket->id, 'user_id'=> $user->id, 'comment_type' => $comment_type]);
                    }
                }
                
                // dd($tempTicket->comments);

               // Ensure that files are present in the request
                if ($request->hasFile('attachments')) {
                    $attachments = [];

                    // Iterate through each uploaded file
                    foreach ($request->file('attachments') as $file) {
                        // Store each file in the 'ticket' directory under the 'public' disk
                        $originalName = $file->getClientOriginalName();

                        // Store each file with the original name in the 'ticketAttachments' directory under the 'public' disk
                        $url = $file->storeAs('ticketAttachments', $originalName, 'public');
                        
                        
                        // Save the URL to the array
                        $attachments[] = $url;
                    }
                    // dd($attachments);
                    // Save the array of URLs in the 'attachments' column of the database
                    $tempTicket->attachments = $attachments;
                    $tempTicket->save();
                    // dd($tempTicket);
                } else {
                    // No files were uploaded, handle accordingly
                }


                $user_id = Auth::user()->id;
                $user= User::find($user_id);
                // dd($user);
                $ticket = $tempTicket;
                if($user->hasRole('user'))
                {
                    Mail::to($user->email)->send(new TicketMail($ticket, $user));
                    Mail::to('support@unicoreonline.com')->send(new AdminMail($ticket, $user));
                }
                
                // dd($user->email);
                return redirect()->route('tickets.index');

        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Ticket $ticket)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $user = Auth::user();

        $pageConfigs = ['pageSidebar' => 'ticket'];    
        $ticket = Ticket::findOrFail($id);
        // dd($ticket);

        $comments= $ticket->comments()->orderBy('created_at', 'desc')->get();;
        
        return view('Admin.Tickets.edit', compact('ticket','comments', 'id','user'), ['pageConfigs' => $pageConfigs]);        }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // dd($request->existing_attachments);
        $validator = Validator::make($request->all(), [
            'state' => 'required',
            'ticket_number' => 'required',
            'created_by' => 'required',
            'module_name' => 'required',
            'description' => 'required',
            'severity' => 'required',
            'incident_type' => 'required',
            // 'dev_notes' => 'required',
            // 'user_comments' => 'required',
            // 'attachments' => 'required|mimes:xlsx,xls,png,doc,docx,pdf,jpeg,jpg|max:100000',
        ]);

        if ($validator->fails()) {
            // Validation failed
            return redirect()->back()->withErrors($validator)->withInput();
        }
            // Find the ticket by ID
            $tempTicket = Ticket::findOrFail($id);
            // Find the store by its ID
            if (!$tempTicket) {
                // Handle the case where the store with the given ID is not found
                return redirect()->route('tickets.index')->with('error', 'Ticket not found.');
            }

                $tempTicket->state = $request->state ?? null;
                $tempTicket->ticket_number = $request->ticket_number ?? null;
                $tempTicket->created_by = $request->created_by ?? null;
                $tempTicket->module_name = $request->module_name ?? null;
                $tempTicket->description = $request->description ?? null;
                $tempTicket->severity = $request->severity ?? null;
                $tempTicket->incident_type = $request->incident_type ?? null;

            // Save the store record with the updated data
            $tempTicket->save();
            // Handle file attachment if provided
            if ($request->hasFile('attachments')) {
                $attachments = [];

                // Iterate through each uploaded file
                foreach ($request->file('attachments') as $file) {

                    $originalName = $file->getClientOriginalName();

                    // Store each file with the original name in the 'ticketAttachments' directory under the 'public' disk
                    $url = $file->storeAs('ticketAttachments', $originalName, 'public');
                    
                    // Save the URL to the array
                    $attachments[] = $url;
                }
                // dd($attachments);
                // Save the array of URLs in the 'attachments' column of the database
                foreach($request->existing_attachments as $existing)
                {
                    $existingUrl= 'ticketAttachments/'.$existing;
                    array_push($attachments,$existingUrl );
                }
                // dd($attachments);
                $tempTicket->attachments = $attachments;
                $tempTicket->save();
                // dd($tempTicket);
            } else {
                // No files were uploaded, handle accordingly
            }



            $user_id = Auth::user()->id;
            $user= User::find($user_id);
            // dd($user);
            $ticket = $tempTicket;
            if($user->hasRole('user'))
            {
                Mail::to('support@unicoreonline.com')->send(new AdminMail($ticket, $user));
            }
            elseif($user->hasRole('admin'))
            {

                if($ticket->state!="Pending Pick Up")
                {
                    $user= User::where('email', $ticket->created_by)->first();
                    // dd($user);

                    Mail::to($ticket->created_by)->send(new UpdateTicketByAdminMailToUser($ticket, $user));
                }
            }

            return redirect()->route('tickets.index');
            
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id)
    {
        // dd($id);
        try {
            // Find the item with the given ID and delete it
            $item = Ticket::find($id);
            if ($item) {
                $item->delete();
                return redirect()->route('tickets.index');
            } else {
                return redirect()->back()->withErrors(['error' => 'Item not found']);
                // return response()->json(['error' => 'Item not found']);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Something went wrong while deleting the item']);
        }
    }

}
