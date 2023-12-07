@extends('layouts.app')

@section('content')
    <div class="site-wrapper">
        <div class="admin_form">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-9">
                        <div class="admin_box">

                            <div class="tab_title mb-5">
                                <h3>Ticket</h3>
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
                            {{-- {{dd($ticket)}} --}}
                            <form method="POST" action="{{ route('tickets.update', $id) }}" novalidate
                                enctype="multipart/form-data">
                                @method('PUT')
                                @csrf

                                <div class="">
                                    <div class="user_form_box">
                                        <div class="form_title">
                                            <h4>General</h4>
                                        </div>
                                        {{-- {{dd($ticket)}} --}}
                                        <div class="user_form_content">
                                            <div class="label">
                                                <label>{{ __('State:') }} <span class="text-danger">*</span></label>
                                            </div>
                                            <div class="user_select_form">
                                                <select id="state" name="state" class="form-select"
                                                    placeholder="Select State" required>
                                                    <option value="" disabled selected>Select State</option>
                                                    <option {{ $ticket['state'] == 'Pending Pick Up' ? 'selected' : '' }}
                                                        value="Pending Pick Up">Pending Pick Up</option>
                                                    <option {{ $ticket['state'] == 'Review' ? 'selected' : '' }}
                                                        value="Review">Review</option>
                                                    <option {{ $ticket['state'] == 'Updated' ? 'selected' : '' }}
                                                        value="Updated">Updated</option>
                                                    <option {{ $ticket['state'] == 'Complete' ? 'selected' : '' }}
                                                        value="Complete">Complete</option>
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
                                                <input type="text" class="form-control" id="ticket_number"
                                                    value="{{ $ticket['ticket_number'] }}" name="ticket_number" readonly
                                                    autocomplete="ticket_number" autofocus placeholder="Ticket Number">
                                                {{-- <input type="text" name="your_input_name" value="{{ generateUniqueString('CI') }}" readonly> --}}

                                            </div>
                                        </div>
                                        <div class="user_form_content">
                                            <div class="label">
                                                <label>{{ __('Created By:') }}</label>
                                            </div>
                                            <div class="user_input_form">
                                                <input type="email" class="form-control" id="created_by"
                                                    value="{{ $ticket['created_by'] }}" name="created_by" readonly
                                                    autocomplete="created_by" autofocus placeholder="Created By">
                                                {{-- <input type="text" name="your_input_name" value="{{ generateUniqueString('CI') }}" readonly> --}}

                                            </div>
                                        </div>

                                        <div class="user_form_content">
                                            <div class="label">
                                                <label>{{ __('Module Name:') }}</label>
                                            </div>
                                            <div class="user_input_form">
                                                <input type="text" class="form-control" id="module_name"
                                                    value="{{ $ticket['module_name'] }}" name="module_name"
                                                    autocomplete="module_name" autofocus placeholder="Module Name">

                                            </div>
                                        </div>
                                        <div class="user_form_content">
                                            <div class="label">
                                                <label>{{ __('Description:') }}</label>
                                            </div>
                                            <div class="user_input_form">
                                                <textarea class="form-control" id="description" name="description" autocomplete="description" autofocus>{{ $ticket['description'] }}</textarea>

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
                                                    <option {{ $ticket['severity'] == 'High' ? 'selected' : '' }}
                                                        value="High">High</option>
                                                    <option {{ $ticket['severity'] == 'Medium' ? 'selected' : '' }}
                                                        value="Medium">Medium</option>
                                                    <option {{ $ticket['severity'] == 'Low' ? 'selected' : '' }}
                                                        value="Low">Low</option>
                                                    <option {{ $ticket['severity'] == 'Enhancement' ? 'selected' : '' }}
                                                        value="Enhancement">Enhancement</option>
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
                                                    <option
                                                        {{ $ticket['incident_type'] == 'Hardware Issues' ? 'selected' : '' }}
                                                        value="Hardware Issues">Hardware Issues</option>
                                                    <option
                                                        {{ $ticket['incident_type'] == 'Software Bugs' ? 'selected' : '' }}
                                                        value="Software Bugs">Software Bugs</option>
                                                    <option
                                                        {{ $ticket['incident_type'] == 'User Account Management' ? 'selected' : '' }}
                                                        value="User Account Management">User Account Management</option>
                                                    <option
                                                        {{ $ticket['incident_type'] == 'Network Connectivity' ? 'selected' : '' }}
                                                        value="Network Connectivity">Network Connectivity</option>
                                                    <option
                                                        {{ $ticket['incident_type'] == 'Security Incidents' ? 'selected' : '' }}
                                                        value="Security Incidents">Security Incidents</option>
                                                    <option
                                                        {{ $ticket['incident_type'] == 'Performance Issues' ? 'selected' : '' }}
                                                        value="Performance Issues">Performance Issues</option>
                                                    <option
                                                        {{ $ticket['incident_type'] == 'Service Requests' ? 'selected' : '' }}
                                                        value="Service Requests">Service Requests</option>
                                                    <option
                                                        {{ $ticket['incident_type'] == 'Outages or Downtime' ? 'selected' : '' }}
                                                        value="Outages or Downtime">Outages or Downtime</option>
                                                    <option
                                                        {{ $ticket['incident_type'] == 'Training and Documentation' ? 'selected' : '' }}
                                                        value="Training and Documentation">Training and Documentation
                                                    </option>
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
                                                <textarea class="form-control" id="dev_notes" name="dev_notes" autocomplete="dev_notes" autofocus>{{ $ticket['dev_notes'] }}</textarea>

                                            </div>
                                        </div>
                                        @php
                                            $comments = json_decode($ticket['user_comments'], true);
                                            // dd($comments);
                                        @endphp
                                        <div class="label mt-2">
                                            <label>{{ __('User Comments:') }}</label>
                                        </div>
                                        <div class="card">
                                            <div class="card-body p-4" id="repeater-container">
                                                @if ($comments != [])
                                                    @foreach ($comments as $comment)
                                                        <div>
                                                            <div class="user_form_content">

                                                                <div class="user_input_form">
                                                                    <textarea class="form-control" id="user_comments" value="" name="user_comments[]"
                                                                        autocomplete="user_comments" autofocus>{{ $comment }}</textarea>
                                                                </div>
                                                            </div>

                                                            <div class="  clickable-element p-1 btn btn-danger"
                                                                onclick="removeRepeaterItem(this)">Delete</div>
                                                            <hr>
                                                        </div>
                                                    @endforeach
                                                @endif
                                            </div>
                                        </div>

                                        <script>
                                            function addRepeaterItem() {
                                                const repeaterContainer = document.getElementById('repeater-container');
                                                const newItem = document.createElement('div');
                                                // newItem.classList.add("p-1");
                                                newItem.innerHTML = `
                                            <div class="user_form_content">
                                               
                                                <div class="user_input_form">
                                                    <textarea  class="form-control" id="user_comments" value="" name="user_comments[]" autocomplete="user_comments" autofocus  ></textarea>
                                                </div>
                                            </div>
                                                <div  class="  clickable-element p-1 btn btn-danger" onclick="removeRepeaterItem(this)">Delete</div>
                                                <hr>
                                                
                                            `;
                                                // user_input_form
                                                repeaterContainer.appendChild(newItem);
                                                initMap();
                                            }


                                            function removeRepeaterItem(button) {
                                                button.parentElement.remove();
                                            }
                                        </script>

                                        <div class="mb-5 p-3">
                                            <div class=" user_btn myborder label float-end">
                                                <div class=" user_btn_style submit clickable-element"
                                                    onclick="addRepeaterItem()">Add New</div>
                                            </div>
                                        </div>

                                        <div class="form_title"
                                            style="
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
                                                <input type="file" class="form-control"
                                                    value="{{ $ticket['attachments'] }}" id="attachments"
                                                    name="attachments" required autocomplete="name">
                                                @if (isset($ticket['attachments']))
                                                    @php
                                                        $tempTicket = explode('/', $ticket['attachments']);
                                                    @endphp
                                                    <p>Current Attachment: {{ $tempTicket[1] }}</p>
                                                @endif
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
                                                    <img src="{{ asset('assets/images/next.png') }}" alt="->"> Save
                                                    Changes
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
            @php
                function generateRandomNumber()
                {
                    // Generate a random number with a length of 4 digits
                    return str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT);
                }

                function generateUniqueString($companyInitials)
                {
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
