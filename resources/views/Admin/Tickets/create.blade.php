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
                            <form method="POST" action="{{ route('tickets.store') }}" novalidate
                                enctype="multipart/form-data">
                                @csrf

                                <div class="">
                                    <div class="user_form_box">
                                        <div class="form_title">
                                            <h4>General</h4>
                                        </div>
                                        @if ($user->hasRole('admin'))
                                            <div class="user_form_content">
                                                <div class="label">
                                                    <label>{{ __('Company Name:') }} <span
                                                            class="text-danger">*</span></label>
                                                </div>
                                                <div class="user_select_form">
                                                    <select id="company" onchange="setTicketNo(this)" name="company_id"
                                                        class="form-select" required>
                                                        <option value="" selected>Select Company</option>
                                                        @if ($companies != null)
                                                            @foreach ($companies as $company)
                                                                <option value="{{ $company['id'] }}">
                                                                    {{ $company['company_name'] }}
                                                                </option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                        @endif



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



                                        @php
                                            if (!Auth::user()->hasRole('admin')) {
                                                $company_name = $companies['company_name'];
                                                $companySubStr = substr($company_name, 0, 3);
                                            } else {
                                                $companySubStr = 'ADMIN';
                                            }
                                            // $companySubStr = strtoupper(substr($company_name, 0, 3));
                                        @endphp
                                        {{-- {{dd($companySubStr)}} --}}

                                        <div class="user_form_content mt-2">
                                            <div class="label">
                                                <label>{{ __('Ticket Number:') }}</label>
                                            </div>
                                            <div class="user_input_form">
                                                <input type="text" class="form-control" id="ticket_number"
                                                    value='{{ generateUniqueString($companySubStr) }}' name="ticket_number"
                                                    readonly autocomplete="ticket_number" autofocus
                                                    placeholder="Ticket Number">
                                                {{-- <input type="text" class="form-control" id="ticket_number" value=""
                                                name="ticket_number" autocomplete="ticket_number" autofocus
                                                placeholder="Ticket Number"> --}}
                                                {{-- <input type="text" name="your_input_name"
                                                value="{{ generateUniqueString('CI') }}" readonly> --}}

                                            </div>
                                        </div>
                                        <div class="user_form_content  mt-2">
                                            <div class="label">
                                                <label>{{ __('Created By:') }}</label>
                                            </div>
                                            <div class="user_input_form">
                                                <input type="email" class="form-control" id="created_by"
                                                    value="{{ $user->email }}" name="created_by" readonly
                                                    autocomplete="created_by" autofocus placeholder="Created By">
                                                {{-- <input type="text" name="your_input_name"
                                                value="{{ generateUniqueString('CI') }}" readonly> --}}

                                            </div>
                                        </div>

                                        <div class="user_form_content  mt-2">
                                            <div class="label">
                                                <label>{{ __('Module Name:') }} <span class="text-danger">*</span></label>
                                            </div>
                                            <div class="user_input_form">
                                                <input type="text" class="form-control" id="module_name" value=""
                                                    name="module_name" autocomplete="module_name" autofocus
                                                    placeholder="Module Name" required>

                                            </div>
                                        </div>
                                        <div class="user_form_content  mt-2">
                                            <div class="label">
                                                <label>{{ __('Description:') }}</label>
                                            </div>
                                            <div class="user_input_form">
                                                <textarea class="form-control" id="description" value="" name="description" autocomplete="description" autofocus></textarea>

                                            </div>
                                        </div>
                                        <div class="user_form_content  mt-2">
                                            <div class="label">
                                                <label>{{ __('Severity:') }} <span class="text-danger">*</span></label>
                                            </div>
                                            <div class="user_select_form">
                                                <select id="severity" name="severity" class="form-select"
                                                    placeholder="Select Severity" required>
                                                    <option value="" disabled selected>Select Severity</option>
                                                    <option value="High">High</option>
                                                    <option value="Medium">Medium</option>
                                                    <option value="Low">Low</option>
                                                    <option value="Enhancement">Enhancement</option>
                                                </select>
                                                @error('severity')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="user_form_content  mt-2">
                                            <div class="label">
                                                <label>{{ __('Incident Type:') }} <span
                                                        class="text-danger">*</span></label>
                                            </div>
                                            <div class="user_select_form">
                                                <select id="incident_type" name="incident_type" class="form-select"
                                                    placeholder="Incident Type" required>
                                                    <option value="" disabled selected>Select Incident Type</option>
                                                    <option value="Hardware Issues">Hardware Issues</option>
                                                    <option value="Software Bugs">Software Bugs</option>
                                                    <option value="User Account Management">User Account Management
                                                    </option>
                                                    <option value="Network Connectivity">Network Connectivity</option>
                                                    <option value="Security Incidents">Security Incidents</option>
                                                    <option value="Performance Issues">Performance Issues</option>
                                                    <option value="Service Requests">Service Requests</option>
                                                    <option value="Outages or Downtime">Outages or Downtime</option>
                                                    <option value="Training and Documentation">Training and Documentation
                                                    </option>
                                                </select>
                                                @error('incident_type')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        {{-- <div class="attachment-container">
                                        <div class="label">
                                            <label>{{ __('Attachment') }}</label>
                                        </div>

                                        <div class="user_form_content">

                                            <div class="user_input_form">
                                                <input type="file" class="form-control attachment-input"
                                                    name="attachments" required autocomplete="name">
                                                @error('attachments.*')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div> --}}

                                        <div class="row">
                                            <div class="col-2">
                                                <div class="label mt-2">
                                                    <label>{{ __('Attachments:') }}</label>
                                                </div>
                                            </div>
                                            <div class="col-10">
                                                <div class="card attachment-container">
                                                    <div class="card-body p-2" id="attachment-container">
                                                        <div>
                                                            <div class="user_input_form">
                                                                <div class="attachment-actions">
                                                                    <div class="attachment-remove-link   clickable-element p-2 text-danger float-end"
                                                                        style="display: block" onclick="removeFile(this)">
                                                                        Remove</div>
                                                                    <a href="#"
                                                                        class="attachment-preview-link float-end p-2"
                                                                        style="display: none" target="_blank">Preview</a>
                                                                    &nbsp; &nbsp; &nbsp; &nbsp;
                                                                </div>
                                                                <input type="file"
                                                                    class="form-control attachment-input"
                                                                    name="attachments[]" required autocomplete="name"
                                                                    onchange="previewFile(this)">
                                                                @error('attachments.*')
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>

                                            </div>
                                            <div class="col-12">
                                                <div class="text-decoration-underline clickable-element p-2  text-primary add-new-attachment float-end"
                                                    onclick="addNewAttachment()">+Add New Attachment</div>
                                            </div>
                                        </div>
                                        <div class="col-12 ">
                                            <div class="user_form_content  mt-2">
                                                <div class="label p-2">
                                                    @if ($user->hasRole('admin'))
                                                        <label>{{ __('Dev Notes:') }}</label>
                                                    @else
                                                        <label>{{ __('User Comments:') }}</label>
                                                    @endif
                                                </div>

                                                <div class="user_form_content col-10">
                                                    <div class="user_input_form">
                                                        <textarea class="form-control" id="post" value="" name="posts" autocomplete="post" autofocus></textarea>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="mb-5 p-3">
                                            <div class=" user_btn myborder label float-end">
                                                <div class=" user_btn_style submit clickable-element"
                                                    onclick="addRepeaterItem()">Post</div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="label p-2">
                                                @if ($user->hasRole('admin'))
                                                    <label>{{ __('Dev Notes:') }}</label>
                                                @else
                                                    <label>{{ __('User Comments:') }}</label>
                                                @endif
                                            </div>


                                            <div class="card">
                                                <div class="card-body p-4" id="repeater-container">

                                                    {{-- <div>
                                                    <div class="user_form_content col-10">

                                                        <div class="user_input_form">
                                                            <textarea class="form-control" id="user_posts" value=""
                                                                name="user_posts[]" autocomplete="user_posts"
                                                                autofocus></textarea>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                </div> --}}
                                                </div>
                                            </div>
                                            <script>
                                                


                                                function addRepeaterItem() 
                                                {
                                                    // write an ajax call
                                                    const repeaterContainer = document.getElementById('repeater-container');
                                                    const newItem = document.createElement('div');
                                                    var content = document.getElementById('post').value;
                                                    var username = {!!json_encode($user->name) !!};
                                                    // storeComment(username, content);

                                                    newItem.innerHTML = `
                                                        <div class="col-12">
                                                            <div class="user_input_form" >
                                                                <div class='row'  style='background:white; padding:10px;'>
                                                                    <div class= 'col-8'>
                                                                        <h5><b>${username}</b></h5>
                                                                    </div>
                                                                    <div class='col-2'>
                                                                        12:00:00
                                                                    </div> 
                                                                    <br><br>
                                                                    <div class='col-8'>
                                                                        <p id="user_posts" class="editable" contenteditable="true">${content}</p>
                                                                        <input type= 'text' name='comment[]' value= '${content}' hidden />
                                                                    </div>
                                                                    <div class='col-2'>
                                                                        <button onclick="removeRepeaterItem(this)">
                                                                            <i class="fa fa-trash-o text-danger" aria-hidden="true"></i>
                                                                        </button>

                                                                        <button onclick="editRepeaterItem(this)">
                                                                            <i class="fa fa-pencil-square-o text-secondary" aria-hidden="true"></i>
                                                                        </button>

                                                                    </div>
                                                                </div>
                                                            <br><br><br>

                                                            </div>
                                                        </div>
                                                        
                                                    `;
                                                    repeaterContainer.appendChild(newItem);
                                                }

                                                function removeRepeaterItem(button) {
                                                    button.parentElement.parentElement.parentElement.remove();
                                                }

                                                function editRepeaterItem(link) {
                                                    const paragraph = link.parentElement.parentElement.querySelector('.editable');
                                                    paragraph.contentEditable = 'true';
                                                    paragraph.focus();
                                                }
                                            </script>

                                        </div>

                                        <script>
                                            function previewFile(input) {
                                                var previewLink = input.parentElement.querySelector('.attachment-preview-link');
                                                var removeLink = input.parentElement.querySelector('.attachment-remove-link');

                                                // Make sure a file is selected
                                                if (input.files.length > 0) {
                                                    var file = input.files[0];

                                                    // Set the preview link's href to the file object URL
                                                    previewLink.href = URL.createObjectURL(file);

                                                    // Display the preview and remove links
                                                    previewLink.style.display = 'inline-block';
                                                    removeLink.style.display = 'inline-block';
                                                } else {
                                                    // Hide the preview and remove links if no file is selected
                                                    previewLink.style.display = 'none';
                                                    removeLink.style.display = 'block';
                                                }
                                            }

                                            function removeFile(link) {
                                                var container = link.closest('.user_input_form');

                                                // Remove the entire container when "Remove" link is clicked
                                                container.remove();
                                            }

                                            function addNewAttachment() {
                                                var container = document.querySelector('.attachment-container');
                                                const newItem = document.createElement('div');
                                                // newItem.classList.add("p-1");
                                                newItem.innerHTML = `
                                                <div class="user_input_form p-2">
                                                    <div class="attachment-actions">
                                                        <div class="attachment-remove-link   clickable-element p-2 text-danger float-end" style="display: block" onclick="removeFile(this)">Remove</div>
                                                        <a href="#" class="attachment-preview-link float-end p-2" style="display: none" target="_blank">Preview</a> &nbsp; &nbsp; &nbsp; &nbsp;
                                                    </div>
                                                    <input type="file" class="form-control attachment-input" name="attachments[]" required autocomplete="name" onchange="previewFile(this)">
                                                </div>
                                                `;
                                                // user_input_form
                                                container.appendChild(newItem);
                                                // initMap();
                                            }
                                        </script>



                                        <div class="user_btn_list">
                                            {{-- <div class="user_btn text-secondary">
                                            <div class="user_btn_style"> <img src="{{asset('assets/images/save.png')}}">
                                                Save Changes
                                            </div>
                                        </div> --}}
                                            <div class="user_btn myborder">
                                                <button type="submit" class=" user_btn_style submit ">
                                                    <img src="{{ asset('assets/images/next.png') }}" alt="->">
                                                    Submit
                                                </button>
                                            </div>

                                            {{-- <div class="user_btn  text-secondary">
                                            <div class="user_btn_style"> <img
                                                    src="{{asset('assets/images/del_user.png')}}"> Delete User
                                            </div>
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
    {{-- @php
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
@endphp --}}

    <script>
        function setTicketNo(selectElement) {
            var selectedOption = selectElement.options[selectElement.selectedIndex];

            // Get the value and text of the selected option
            var selectedValue = selectedOption.value;
            var selectedText = selectedOption.text;
            let compInitial = selectedText.substr(0, 3);
            var existingTicket = document.getElementById('ticket_number').value;
            const arr = existingTicket.split("-");
            var newTicketNo = compInitial + '-' + arr[1] + '-' + arr[2];
            // alert(newTicketNo);
            // document.getElementById('ticket_number').readOnly=false;

            document.getElementById('ticket_number').value = newTicketNo;
        }
    </script>
@endsection
