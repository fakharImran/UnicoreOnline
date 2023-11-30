<?php

namespace App\Http\Controllers;

use Validator;
use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pageConfigs = ['pageSidebar' => 'company'];    
        $companies= Company::all();
        return view('Admin.Company.index', compact('companies'), ['pageConfigs' => $pageConfigs]);

        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        
        $pageConfigs = ['pageSidebar' => 'company'];    
        return view('Admin.Company.create', ['pageConfigs' => $pageConfigs]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

                // dd($request->all());
                $validator = Validator::make($request->all(), [
                    'company_name' => 'required',
                    // 'attachments' => 'required|mimes:xlsx,xls,png,doc,docx,pdf,jpeg,jpg|max:100000',
                ]);

                if ($validator->fails()) {
                    // Validation failed
                    return redirect()->back()->withErrors($validator)->withInput();
                }
                $tempTicket= Company::create($request->all());        //.
                return redirect()->route('companies.index');

    }

    /**
     * Display the specified resource.
     */
    public function show(Company $company)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $pageConfigs = ['pageSidebar' => 'company'];    
        $company = Company::findOrFail($id);
        // dd($ticket);
        return view('Admin.Company.edit', compact('company', 'id'), ['pageConfigs' => $pageConfigs]);        
     }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'company_name' => 'required',
        ]);

        if ($validator->fails()) {
            // Validation failed
            return redirect()->back()->withErrors($validator)->withInput();
        }
            // Find the ticket by ID
            $tempCompany = Company::findOrFail($id);

            // Update the ticket with the new data
            $tempCompany->update($request->all());
            return redirect()->route('companies.index');

        }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id)
    {
        // dd($id);
        try {
            // Find the item with the given ID and delete it
            $item = Company::find($id);
            if ($item) {
                $item->delete();
                return redirect()->route('companies.index');
            } else {
                return redirect()->back()->withErrors(['error' => 'Item not found']);
                // return response()->json(['error' => 'Item not found']);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Something went wrong while deleting the item']);
        }
    }
}
