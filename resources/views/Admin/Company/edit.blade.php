@extends('layouts.app')

@section('content')
  <div class="site-wrapper">
    <div class="admin_form">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="admin_box">

                      <div class="tab_title">
                        <h3>Ticket</h3>
                      </div>
                      
                      @if($errors->any())
                      <div class="alert alert-danger">
                          <ul>
                              @foreach($errors->all() as $error)
                                  <li>{{ $error }}</li>
                              @endforeach
                          </ul>
                      </div>
                      @endif
                        <form method="POST" action="{{ route('companies.update', $id) }}" >
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
                                        <div class="user_input_form">
                                            <input type="text" class="form-control" id="company_name" value="{{$company['company_name']}}" name="company_name" required autocomplete="company_name" autofocus  placeholder="Company Name">
                                            {{-- <input type="text" name="your_input_name" value="{{ generateUniqueString('CI') }}" readonly> --}}

                                        </div>
                                  </div>
                                  <div class="user_btn_list">
                                      {{-- <div class="user_btn text-secondary" >
                                          <div class="user_btn_style"> <img src="{{asset('assets/images/save.png')}}"> Save Changes</div>
                                      </div> --}}
                                      <div class="user_btn myborder">
                                        <button type="submit" class=" user_btn_style submit ">
                                         <img src="{{asset('assets/images/next.png')}}" alt="->"> Save Changes
                                        </button>
                                      </div>
  
                                      {{-- <div class="user_btn  text-secondary" >
                                          <div class="user_btn_style"> <img src="{{asset('assets/images/del_user.png')}}"> Delete User</div>
                                      </div> --}}
  
                                      <div class="user_btn myborder" onclick="window.history.go(-1); return false;" >
                                          <button  class="user_btn_style submit" > <img src="{{asset('assets/images/close.png')}}"> Close</button>
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