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
     */
    public function index()
    {
         $pageConfigs = ['pageSidebar' => 'ticket'];    
        $tickets= Ticket::all();
        $companies= Company::all();


        return view('Admin.Tickets.index', compact('tickets', 'companies'), ['pageConfigs' => $pageConfigs]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pageConfigs = ['pageSidebar' => 'ticket'];  
        $user= Auth::user();

        return view('Admin.Tickets.create',compact('user'), ['pageConfigs' => $pageConfigs]);
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
                $tempTicket= Ticket::create($request->all());
                // dd($request->hasFile('attachments'));
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
            'dev_notes' => 'required',
            'user_comments' => 'required',
            // 'attachments' => 'required|mimes:xlsx,xls,png,doc,docx,pdf,jpeg,jpg|max:100000',
        ]);

        if ($validator->fails()) {
            // Validation failed
            return redirect()->back()->withErrors($validator)->withInput();
        }
            // Find the ticket by ID
            $tempTicket = Ticket::findOrFail($id);

            // Update the ticket with the new data
            $tempTicket->update($request->all());

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
