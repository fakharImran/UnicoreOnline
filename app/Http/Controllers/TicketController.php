<?php

namespace App\Http\Controllers;

use Validator;
use App\Models\Ticket;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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
            return redirect()->back()->withErrors("Admin cannot create Tickcts right now")->withInput();
        }
        else{
            $companies = $user->companyUser->company; //for getting single company
            $tickets = $companies->tickets;
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
                    'dev_notes' => 'required',
                    'user_comments' => 'required',
                    // 'attachments' => 'required|mimes:xlsx,xls,png,doc,docx,pdf,jpeg,jpg|max:100000',
                ]);

                if ($validator->fails()) {
                    // Validation failed
                    return redirect()->back()->withErrors($validator)->withInput();
                }
               
                $user= Auth::user();

                $company_id= $user->companyUser->company->id;
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
                $tempTicket->dev_notes = $request->dev_notes ?? null;
                $tempTicket->user_comments = json_encode($request->user_comments);

                $tempTicket->save();
                // dd($tempTicket);
                if($request->hasFile('attachments'))
                {
                    $url = $request->file('attachments')->store('ticket', 'public');
                }
                else
                {
                    $url=null;
                }
                // dd($url);
            
                $tempTicket->attachments= $url;
               $tempTicket->save();
                // dd($tempTicket);
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

        $pageConfigs = ['pageSidebar' => 'ticket'];    
        $ticket = Ticket::findOrFail($id);
        // dd($ticket);
        return view('Admin.Tickets.edit', compact('ticket', 'id'), ['pageConfigs' => $pageConfigs]);        }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
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
                $tempTicket->dev_notes = $request->dev_notes ?? null;
                $tempTicket->user_comments = json_encode($request->user_comments);

            // Save the store record with the updated data
            $tempTicket->save();
            // Handle file attachment if provided
            if ($request->hasFile('attachments')) {
                // Delete the previous attachment if exists
                if ($tempTicket->attachments) {
                    Storage::disk('public')->delete($tempTicket->attachments);
                }

                // Store the new attachment
                $url = $request->file('attachments')->store('ticket', 'public');
                $tempTicket->attachments = $url;
            }

            $tempTicket->save();

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
