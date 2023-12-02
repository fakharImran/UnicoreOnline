@extends('layouts.app')

@section('content')
    <div class="site-wrapper">
        <div class="admin_form">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-9">
                        <div class="admin_box">

                            <div class="tab_title mb-5">
                                <h3>Users</h3>
                            </div>

                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <form method="POST" action="{{ route('companyUsers.update', $id) }}">
                            @method('PUT')
                            @csrf

                                <div class="">
                                    <div class="user_form_box">
                                        <div class="form_title">
                                            <h4>General</h4>
                                        </div>

                                        <div class="user_form_content">
                                            <div class="label">
                                                <label>{{ __('Company Name:') }}</label>
                                            </div>
                                            <div class="user_select_form">
                                                <select id="company" class="form-select " name="company_id" required>
                                                    <option value disabled selected>Select Company</option>
                                                    @if($companies!=null)
                                                    @foreach($companies as $company)
                                                    <option  {{ $company['id'] == $companyUser['company_id'] ? 'selected' : '' }} value="{{$company['id']}}">{{$company['company_name']}}</option>
                                                    @endforeach
                                                    @endif
                                                </select>
        
                                                @error('company_id')
                                                  <span class="invalid-feedback" role="alert">
                                                      <strong>{{ $message }}</strong>
                                                  </span>
                                                @enderror
                                            </div>
                                        </div>
                                        {{-- {{dd($companyUser['department'])}} --}}
                                        <div class="user_form_content">
                                            <div class="label">
                                                <label>{{ __('Department:') }}</label>
                                            </div>
                                            <div class="user_input_form">
                                                <input type="department" class="form-control" id="department"
                                                    name="department" value="{{$companyUser['department']}}" required autocomplete="department" autofocus
                                                    placeholder="Department">
                                            </div>
                                        </div>
                                        <div class="user_form_content">
                                            <div class="label">
                                                <label>{{ __('Email Address:') }}</label>
                                            </div>
                                            <div class="user_input_form">
                                                <input id="email" type="email"
                                                    class="form-control @error('email') is-invalid @enderror" name="email"
                                                    value="{{$user['email']}}" required autocomplete="email">

                                                @error('email')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="user_form_content">
                                            <div class="label">
                                                <label>{{ __('First Name:') }}</label>
                                            </div>
                                            @php
                                                $name= explode(' ', $user->name);
                                            @endphp
                                            <div class="user_input_form">
                                                <input id="first_name" type="text"
                                                    class="form-control @error('first_name') is-invalid @enderror"
                                                    name="first_name" value="{{$name[0]}}" required
                                                    autocomplete="first_name" autofocus>

                                                @error('first_name')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="user_form_content">
                                            <div class="label">
                                                <label>{{ __('Last Name:') }}</label>
                                            </div>
                                            <div class="user_input_form">
                                                <input id="last_name" type="text"
                                                    class="form-control @error('last_name') is-invalid @enderror"
                                                    name="last_name" value="{{ $name[1] }}" required
                                                    autocomplete="last_name" autofocus>

                                                @error('last_name')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="user_form_content">
                                            <div class="label">
                                                <label>{{ __('Access Privileges') }} <span class="text-danger">*</span></label>
                                            </div>
                                            <div class="user_select_form">
                                                <select id="access_privilege" class="form-select "  name="access_privilege" required>
                                                    <option value disabled selected>Select</option>
                                                    <option {{($companyUser->access_privilege=="Active")? "selected":""}} value="Active">Active</option>
                                                    <option  {{($companyUser->access_privilege=="Deactivated")? "selected":""}} value="Deactivated">Deactivated</option>
                                                </select>
                                                @error('access_privilege')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="user_form_content">
                                            <div class="label">
                                                <label>{{ __('Password') }} <span class="text-danger">*</span></label>
                                            </div>
                                            <div class="user_input_form">
                                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required  placeholder="Password">
                                                <span class="toggle-password fa fa-eye"  onclick="togglePasswordVisibility()"></span>
                                                @error('password')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                      
                                        <div class="user_btn_list">
                                            {{-- <div class="user_btn text-secondary" >
                                          <div class="user_btn_style"> <img src="{{asset('assets/images/save.png')}}"> Save Changes</div>
                                      </div> --}}
                                            <div class="user_btn myborder">
                                                <button type="submit" class=" user_btn_style submit ">
                                                    <img src="{{ asset('assets/images/next.png') }}" alt="->"> Save Changes
                                                </button>
                                            </div>

                                            {{-- <div class="user_btn  text-secondary" >
                                          <div class="user_btn_style"> <img src="{{asset('assets/images/del_user.png')}}"> Delete User</div>
                                      </div> --}}

                                            <div class="user_btn myborder" onclick="window.history.go(-1); return false;">
                                                <button class="user_btn_style submit"> <img
                                                        src="{{ asset('assets/images/close.png') }}"> Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>

        @endsection
