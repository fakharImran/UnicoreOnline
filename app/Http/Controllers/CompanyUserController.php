<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Company;
use App\Models\CompanyUser;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class CompanyUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pageConfigs = ['pageSidebar' => 'company user'];    
        $companyUsers= CompanyUser::all();
        return view('Admin.CompanyUser.index', compact('companyUsers'), ['pageConfigs' => $pageConfigs]);    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pageConfigs = ['pageSidebar' => 'company user'];  
        $roles = Role::pluck('name','name')->except('admin');
        $companies= Company::select('*')->get();  
        return view('Admin.CompanyUser.create',  compact('companies', 'roles'), ['pageConfigs' => $pageConfigs]);        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
         // dd($request->all());
         $this->validate($request, [
            'company_id' => 'required',
            'department' => 'required',
            'email' => 'required|email|unique:users,email',
            'first_name' => 'required',
            'last_name' => 'required',
            'password' => 'required',
            // 'password' => 'required|same:confirm-password',
            // 'roles' => 'required',
            'access_privilege' => 'required'
        ]);
        $name=$request->first_name.' '. $request->last_name;
        $input = $request->only(['email', 'password'] );
        $input['name']=$name;
        // $input= array_merge( $name, $input);

        $input['password'] = Hash::make($input['password']);
        // dd($input);
    
       
        $user = User::create($input);
        
        $tempUser= new CompanyUser();
       
        $tempUser->company_id= $request->company_id;
        $tempUser->user_id=  $user->id;
        $tempUser->access_privilege= $request->access_privilege;
        $tempUser->department= $request->department;

        $tempUser->save();
        // dd($tempUser);
        return redirect()->route('companyUsers.index')->with('success','User created successfully');

        // $tempRole=array();
        // if($request->input('roles')[0]=="Merchandiser & Manager")
        // {
        //     $tempRole[0] = 'manager';
        //     $tempRole[1] = 'merchandiser';
        //     $user->assignRole($tempRole);
        // }
        // else
        // {
        //     $user->assignRole($request->input('roles'));
        // }
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(CompanyUser $companyUser)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CompanyUser $companyUser , $id)
    {
        $pageConfigs = ['pageSidebar' => 'company user'];   

        $companies= Company::select('*')->get();
        $companyUser= CompanyUser::select()->where('id',$id)->first(); 
        $company = $companyUser->company;
        // $roles = Role::pluck('name','name')->except('admin');
        $user = $companyUser->user;
        // $userRole = $user->roles->pluck('name','name')->all();
        return view('Admin.CompanyUser.edit', compact('user','id', 'companyUser','company','companies'), ['pageConfigs' => $pageConfigs]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {
         // dd($request->all());
         // dd($request->all());
        $companyUser = CompanyUser::where('id', $id)->first();

         $this->validate($request, [
            'company_id' => 'required',
            'department' => 'required',
            'email' => 'required|email|unique:users,email',
            'first_name' => 'required',
            'last_name' => 'required',
            'password' => 'required',
            // 'password' => 'required|same:confirm-password',
            // 'roles' => 'required',
            'access_privilege' => 'required'
        ]);
        $name=$request->first_name.' '. $request->last_name;
        $input = $request->only(['email', 'password'] );
        $input['name']=$name;
        // $input= array_merge( $name, $input);
        if(!empty($input['password'])){ 
            $input['password'] = Hash::make($input['password']);
        }else{
            $input = Arr::except($input,array('password'));    
        }
        // dd($input);
        $user = User::find($companyUser->user_id);

        $user->update($input);

        $companyUser->company_id= $request->company_id;
        $companyUser->user_id=  $user->id;
        $companyUser->access_privilege= $request->access_privilege;
        $companyUser->department= $request->department;

        $companyUser->save();

        return redirect()->route('companyUsers.index')->with('success','User Updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id)
    {
        try {
            // Find the item with the given ID and delete it
            $item = CompanyUser::find($id);
            $userID=$item->user->id;
            $user = User::find($userID);

            if ($user) {
                $user->delete();
                return redirect()->route('companyUsers.index');
            } else {
                return redirect()->back()->withErrors(['error' => 'Item not found']);
                // return response()->json(['error' => 'Item not found']);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Something went wrong while deleting the item']);
        }
    }
}
