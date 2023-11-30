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
                        <form method="POST" action="{{ route('tickets.store') }}" novalidate  enctype="multipart/form-data">
                            @csrf
                            
                            <div class="">
                              <div class="user_form_box">
                                  <div class="form_title">
                                      <h4>General</h4>
                                  </div>

                                    <div class="user_form_content">
                                        <div class="label">
                                            <label>{{ __('State:') }} <span class="text-danger">*</span></label>
                                        </div>
                                        <div class="user_select_form">
                                            <select id="state" name="state" class="form-select"
                                                placeholder="Select State" required>
                                                <option value="" disabled selected>Select State</option>
                                                <option value="Pending Pick Up">Pending Pick Up</option>
                                                <option value="Review">Review</option>
                                                <option value="Updated">Updated</option>
                                                <option value="Complete">Complete</option>
                                            </select>
                                            @error('state')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                  


                                  <div class="user_form_content">
                                      <div class="label">
                                          <label>{{ __('Ticket Number:') }}</label>
                                      </div>
                                        <div class="user_input_form">
                                            <input type="text" class="form-control" id="ticket_number" value="{{ generateUniqueString('ABC') }}" name="ticket_number" readonly autocomplete="ticket_number" autofocus  placeholder="Ticket Number">
                                            {{-- <input type="text" name="your_input_name" value="{{ generateUniqueString('CI') }}" readonly> --}}

                                        </div>
                                  </div>
                                    <div class="user_form_content">
                                        <div class="label">
                                            <label>{{ __('Created By:') }}</label>
                                        </div>
                                        <div class="user_input_form">
                                            <input type="email" class="form-control" id="created_by" value="Auth::user()->email" name="created_by" readonly autocomplete="created_by" autofocus  placeholder="Created By">
                                            {{-- <input type="text" name="your_input_name" value="{{ generateUniqueString('CI') }}" readonly> --}}

                                        </div>
                                    </div>

                                    <div class="user_form_content">
                                        <div class="label">
                                            <label>{{ __('Module Name:') }}</label>
                                        </div>
                                        <div class="user_input_form">
                                            <input type="text" class="form-control" id="module_name" value="" name="module_name" autocomplete="module_name" autofocus  placeholder="Module Name">

                                        </div>
                                    </div>
                                    <div class="user_form_content">
                                        <div class="label">
                                            <label>{{ __('Description:') }}</label>
                                        </div>
                                        <div class="user_input_form">
                                            <textarea  class="form-control" id="description" value="" name="description" autocomplete="description" autofocus  ></textarea>

                                        </div>
                                    </div>
                                    <div class="user_form_content">
                                        <div class="label">
                                            <label>{{ __('Severity:') }}</label>
                                        </div>
                                        <div class="user_select_form">
                                            <select id="severity" name="severity" class="form-select"
                                                placeholder="Select Severity" required>
                                                <option value="" disabled selected>Select Severity</option>
                                                <option value="Critical">Critical</option>
                                                <option value="temp1">temp1</option>
                                                <option value="temp2">temp2</option>
                                                <option value="temp3">temp3</option>
                                            </select>
                                            @error('severity')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="user_form_content">
                                        <div class="label">
                                            <label>{{ __('Incident Type:') }}</label>
                                        </div>
                                        <div class="user_select_form">
                                            <select id="incident_type" name="incident_type" class="form-select"
                                                placeholder="Incident Type" required>
                                                <option value="" disabled selected>Select Incident Type</option>
                                                <option value="Bug">Bug</option>
                                                <option value="temp1">temp1</option>
                                                <option value="temp2">temp2</option>
                                                <option value="temp3">temp3</option>
                                            </select>
                                            @error('incident_type')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="user_form_content">
                                        <div class="label">
                                            <label>{{ __('Dev Notes:') }}</label>
                                        </div>
                                        <div class="user_input_form">
                                            <textarea  class="form-control" id="dev_notes" value="" name="dev_notes" autocomplete="dev_notes" autofocus  ></textarea>

                                        </div>
                                    </div>
                                    <div class="user_form_content">
                                        <div class="label">
                                            <label>{{ __('User Comments:') }}</label>
                                        </div>
                                        <div class="user_input_form">
                                            <textarea  class="form-control" id="user_comments" value="" name="user_comments" autocomplete="user_comments" autofocus  ></textarea>
                                        </div>
                                    </div>
                                    {{-- <div class="user_form_content">

                                        <section class="form-control-repeater  caregiver-repeater">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <h4 class="card-title">Address<span class ="staric">*</span></h4>
                                                        </div>
                                                        <div class="card-body">
                                
                                                                <div data-repeater-list="address">
                                                                    <div data-repeater-item class="list-item">
                                                                        <div class="row d-flex align-items-end">
                                                                            <div class="col-md-2 col-12">
                                                                                <div class="mb-1">
                                                                                    <label class="form-label" for="address_line1">Address Line 1</label>
                                                                                    <input type="text" class="form-control" id="address_line1"
                                                                                        aria-describedby="address_line1" placeholder="Address Line 1"
                                                                                        name="address_line1"
                                                                                        
                                                                                    />
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-2 col-12">
                                                                                <div class="mb-1">
                                                                                    <label class="form-label" for="address_line2">Address Line 2</label>
                                                                                    <input
                                                                                        type="text" class="form-control" id="address_line2"
                                                                                        aria-describedby="address_line2" placeholder="Address Line 2"
                                                                                        name="address_line2"
                                                                                    />
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-2 col-12">
                                                                                <div class="mb-1">
                                                                                    <label class="form-label" for="City">City</label>
                                                                                    <input
                                                                                        type="text" class="form-control" id="city"
                                                                                        aria-describedby="city" placeholder="city"
                                                                                        name="city"
                                                                                    />
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-2 col-12">
                                                                                <div class="mb-1">
                                                                                    <label class="form-label" for="state">State</label>
                                                                                    <input
                                                                                        type="text" class="form-control" id="state"
                                                                                        aria-describedby="state" placeholder="state"
                                                                                        name="state" required
                                                                                    />
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-2 col-12">
                                                                                <div class="mb-1">
                                                                                    <label class="form-label" for="country">Country</label>
                                                                                    <select class="form-select" id="country" name="country">
                                                                                        <option>Select Country</option>
                                                                                        <option value="usa">USA</option>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-2 col-12">
                                                                                <div class="mb-1">
                                                                                    <label class="form-label" for="zip_code">Zip Code<span class="staric">*</span></label>
                                                                                    <input type="text" class="form-control" id="zip_code"
                                                                                        aria-describedby="zip_code" placeholder="xxxx-xxxx"
                                                                                        name="zip_code" required/>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-3 col-12">
                                                                                <div class="mb-1">
                                                                                    <label class="form-label" for="cross_street">Cross Street</label>
                                                                                    <input
                                                                                        type="text" class="form-control" id="cross_street"
                                                                                        aria-describedby="cross_street" placeholder="cross Street"
                                                                                        name="cros_street"
                                                                                    />
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-1 col-6">
                                                                                <div class="mt-2">
                                                                                    <div class="form-check form-check-inline">
                                                                                        <input class="form-check-input" type="checkbox" id="add_primary" value="Primary" name="add_primary" />
                                                                                        <label class="form-check-label" for="add_primary">Primary</label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-3 mb-1">
                                                                                <label class="form-label" for="address_type">Address Type</label>
                                                                                <select class="select2 form-select" id="address_type" value="" multiple name="address_type">
                                                                                        <option value="GPS">GPS</option>
                                                                                        <option value="Home">Home</option>
                                                                                        <option value="Community">Community</option>
                                                                                </select>
                                                                            </div>
                                                                            <div class="col-md-3 col-12">
                                                                                <div class="mb-1">
                                                                                    <label class="form-label" for="add_note">Note</label>
                                                                                    <textarea
                                                                                        class="form-control" id="add_note"
                                                                                        rows="1" placeholder="Note" name="add_note"
                                                                                    ></textarea>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-2 col-12 mb-50">
                                                                                <div class="mt-2">
                                                                                    <button class="btn btn-outline-danger text-nowrap px-1 delete-repeater" data-repeater-delete type="button">
                                                                                        <i data-feather="x" class="me-25"></i>
                                                                                        <span>Delete</span>
                                                                                    </button>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <hr />
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-12">
                                                                        <button class="btn btn-icon btn-primary" type="button" data-repeater-create>
                                                                            <i data-feather="plus" class="me-25"></i>
                                                                            <span>Add New</span>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- /Invoice repeater -->
                                            </div>
                                        </section>
                                    </div> --}}
                    
                                    <div class="form_title" style="
                                        border-bottom: 1px solid #1155CC;
                                        padding-bottom: 5px;
                                        margin-bottom: 20px;">
                                        <h4>Attachment (Optional)</h4>
                                    </div>
                                    
                                    <div class="user_form_content">
                                        <div class="label">
                                            <label>{{ __('Attachment') }}</label>
                                        </div>
                                        <div class="user_input_form">
                                            <input type="file"  class="form-control" id="attachments" name="attachments" required autocomplete="name"   >
                                        @error('Attachment')
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
                                         <img src="{{asset('assets/images/next.png')}}" alt="->"> Submit
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
        @php
        function generateRandomNumber() {
            // Generate a random number with a length of 4 digits
            return str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT);
        }
        
        function generateUniqueString($companyInitials) {
            // Get the current year
            $currentYear = date('Y');
        
            // Generate a random number
            $randomNumber = generateRandomNumber();
        
            // Combine the elements to create the final string
            $result = "{$companyInitials}-{$currentYear}-{$randomNumber}";
        
            return $result;
        }
        @endphp
    </div>
</div>



@endsection