@extends('layouts.app')

@section('content')
    <style>
        @media (min-width: 0) {
            .g-mr-15 {
                margin-right: 1.07143rem !important;
            }
        }

        @media (min-width: 0) {
            .g-mt-3 {
                margin-top: 0.21429rem !important;
            }
        }

        .g-height-50 {
            height: 50px;
        }

        .g-width-50 {
            width: 50px !important;
        }

        @media (min-width: 0) {
            .g-pa-30 {
                padding: 2.14286rem !important;
            }
        }

        .g-bg-secondary {
            background-color: #fdfdfd !important;
        }

        .u-shadow-v18 {
            box-shadow: 0 5px 10px -6px rgba(0, 0, 0, 0.15);
        }

        .g-color-gray-dark-v4 {
            color: #777 !important;
        }

        .g-font-size-12 {
            font-size: 0.85714rem !important;
        }

        .media-comment {
            margin-top: 20px
        }





        [data-initials]:before {
            background: linear-gradient(180deg, rgba(253, 88, 29, 0.9559087643678161) 0%, rgba(252, 176, 69, 0.9501616379310345) 100%);

            color: white;
            opacity: 1;
            content: attr(data-initials);
            display: inline-block;
            font-weight: 600;
            border-radius: 50%;
            vertical-align: middle;
            margin-right: 0.5em;
            width: 50px;
            height: 50px;
            line-height: 50px;
            text-align: center;
        }
    </style>
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
                                                    name="ticket_number" readonly autocomplete="ticket_number" autofocus
                                                    placeholder="Ticket Number">

                                                <script>
                                                    // Function to generate a random number with a length of 4 digits
                                                    function generateRandomNumber() {
                                                        return String(Math.floor(Math.random() * 10000)).padStart(4, '0');
                                                    }

                                                    // Function to generate a unique string based on the company initials and current year
                                                    function generateUniqueString(companyInitials) {
                                                        var currentYear = new Date().getFullYear(); // Get the current year
                                                        var randomNumber = generateRandomNumber(); // Generate a random number
                                                        return companyInitials + '-' + currentYear + '-' + randomNumber; // Combine elements
                                                    }

                                                    // Function to set the generated unique string as the value of the input field
                                                    function setTicketNumberValue() {
                                                        var companySubStr = "{!! $companySubStr !!}"; // Replace this with the value of $companySubStr
                                                        var ticketNumberInput = document.getElementById('ticket_number');
                                                        var uniqueString = generateUniqueString(companySubStr);
                                                        ticketNumberInput.value = uniqueString;
                                                    }

                                                    // Call the function to set the value when the page loads
                                                    window.onload = function() {
                                                        setTicketNumberValue();
                                                    };
                                                </script>

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
                                                        <textarea class="form-control" id="post" value="" name="posts" rows="4" autocomplete="post"
                                                            autofocus></textarea>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="mb-5 p-3">
                                            <div class=" user_btn myborder label float-end">
                                                <div class=" user_btn_style submit clickable-element"
                                                    onclick="addRepeaterItem()">Add Comment</div>
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
                                                function dateTimeFormat(params) {
                                                    // Create a new Date object to get the current date and time
                                                    var currentDate = new Date();

                                                    // Get year, month, and day
                                                    var year = currentDate.getFullYear();
                                                    var month = ('0' + (currentDate.getMonth() + 1)).slice(-2); // Months are zero-based
                                                    var day = ('0' + currentDate.getDate()).slice(-2);

                                                    // Get hours, minutes, and seconds
                                                    var hours = ('0' + currentDate.getHours()).slice(-2);
                                                    var minutes = ('0' + currentDate.getMinutes()).slice(-2);
                                                    var seconds = ('0' + currentDate.getSeconds()).slice(-2);

                                                    // Format the date and time
                                                    var formattedDateTime = year + '-' + month + '-' + day + ' ' + hours + ':' + minutes + ':' + seconds;

                                                    console.log("Current time:", formattedDateTime);

                                                    return formattedDateTime;
                                                }

                                                function addRepeaterItem() {
                                                    // write an ajax call
                                                    const repeaterContainer = document.getElementById('repeater-container');
                                                    const newItem = document.createElement('div');
                                                    var content = document.getElementById('post').value;
                                                    var username = {!! json_encode($user->name) !!};
                                                    // storeComment(username, content);

                                                    newItem.innerHTML = `
                                                    <div class="container">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="media g-mb-30 media-comment  d-flex">
                                                                    <div data-initials="${getInitials(username)}">
                                                                    </div>
                                                                    <div
                                                                        class="media-body u-shadow-v18 g-bg-secondary g-pa-30 w-100" style="max-width:90%">
                                                                        <div class="g-mb-15 d-flex" style="justify-content: space-between;">
                                                                            <h5 class="h5 g-color-gray-dark-v1 mb-0">
                                                                                ${username }</h5>
                                                                            <div class="d-flex ">
                                                                                <span class="g-color-gray-dark-v4 g-font-size-12">
                                                                                    ${dateTimeFormat() }</span>
                                                                                <div class="ms-4"
                                                                                    onclick="removeRepeaterItem(this)">
                                                                                    <i class="fa fa-trash-o text-dark w-75"
                                                                                        aria-hidden="true"></i>
                                                                                </div>

                                                                                <div class="ms-3"
                                                                                    onclick="editRepeaterItem(this)">
                                                                                    <i class="fa fa-pencil-square-o text-secondary  w-75"
                                                                                        aria-hidden="true"></i>
                                                                                </div>
                                                                            </div>


                                                                        </div>
                                                                        <div id="comment-place" class="my-3">
                                                                            <div class="user_input_form" style="display: none;">
                                                                                <textarea class="form-control" id="comment" name="comment[]" autofocus>${content}</textarea>
                                                                            </div>

                                                                            <p>${content}</p>
                                                                        </div>


                                                                        <ul class="list-inline w-100  my-0 submit-button"
                                                                            style="justify-content: flex-end; display:none;">
                                                                            <li class="list-inline-item ml-auto">
                                                                                <a onclick="editRepeaterComment(this)"
                                                                                    class="btn btn-light u-link-v5 g-color-gray-dark-v4 g-color-primary--hover">
                                                                                    <i
                                                                                        class="fa fa-paper-plane g-pos-rel g-top-1 g-mr-3"></i>
                                                                                    Submit
                                                                                </a>
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>


                                                        </div>
                                                    </div>
                                                                
                                                    `;
                                                    var firstChild = repeaterContainer.firstChild;
                                                    repeaterContainer.insertBefore(newItem, firstChild);
                                                    // repeaterContainer.appendChild(newItem);
                                                    document.querySelector('#post').value = "";

                                                }

                                                function removeRepeaterItem(button) {
                                                    button.parentElement.parentElement.parentElement.remove();
                                                }

                                                function editRepeaterComment(element, comment_id) {
                                                    // Make AJAX request
                                                    var commentInputField = element.closest('.media-comment').querySelector('#comment').value;
                                                    console.log(commentInputField);

                                                    var commentText = element.closest('.media-comment').querySelector('#comment');
                                                    if (commentText) {
                                                        commentText.innerHTML = commentInputField
                                                    }
                                                    var commentText = element.closest('.media-comment').querySelector('p');
                                                    if (commentText) {
                                                        commentText.innerHTML = commentInputField
                                                        commentText.style.display = 'block';
                                                    }
                                                    // document.getElementsByClassName("comment-place")[0].style.display = "none";
                                                    var commentInputUpperField = element.closest('.media-comment').querySelector('.user_input_form');
                                                    if (commentInputUpperField) {
                                                        commentInputUpperField.style.display = 'none';
                                                    }
                                                    var componentButton = element.closest('.media-comment').querySelector('.submit-button');
                                                    if (componentButton) {
                                                        componentButton.style.display = 'none';
                                                    }
                                                }
                                                // Example usage
                                                function editRepeaterItem(element, commentId) {
                                                    // Hide the comment input field
                                                    var commentInputField = element.closest('.media-comment').querySelector('.user_input_form');
                                                    if (commentInputField) {
                                                        commentInputField.style.display = 'block';
                                                    }
                                                    var componentButton = element.closest('.media-comment').querySelector('.submit-button');
                                                    if (componentButton) {
                                                        componentButton.style.display = 'flex';
                                                    }


                                                    // Hide the comment text
                                                    var commentText = element.closest('.media-comment').querySelector('p');
                                                    if (commentText) {
                                                        commentText.style.display = 'none';
                                                    }

                                                    // Additional logic for editing the comment...
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

        function getInitials(name) {
            // Split the name into words
            const nameWords = name.trim().split(" ");

            // Initialize the initials variable
            let initials = "";

            // Get the initial of the first name
            initials += nameWords[0][0].toUpperCase();

            // If there's a last name, get its initial
            if (nameWords.length > 1) {
                initials += nameWords[nameWords.length - 1][0].toUpperCase();
            }

            // Return the initials
            return initials;
        }
    </script>
@endsection
