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

                                        {{-- <div class="user_form_content">
                                            <div class="label">
                                                <label>{{ __('Attachment') }}</label>
                                            </div>
                                            @php
                                                $ticketAttachments= json_decode($ticket['attachments'], true);
                                            @endphp

                                            @if ($ticketAttachments != null)

                                            <div class="user_input_form">
                                                <input type="file" class="form-control" id="attachments" name="attachments[]" multiple>
                                                @if (isset($ticketAttachments) && is_array($ticketAttachments))
                                                    <p>Current Attachments:</p>
                                                    <ul>
                                                        @foreach ($ticketAttachments as $attachment)
                                                            @php
                                                                $tempTicket = explode('/', $attachment);
                                                            @endphp
                                                            <li>{{ $tempTicket[1] }}</li>
                                                        @endforeach
                                                    </ul>
                                                @endif
                                                @error('attachments')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            @else
                                            <div class="user_form_content mt-2">
                                                
                                                <div class="user_input_form">
                                                    <div class="attachment-actions">
                                                        <div class="attachment-remove-link   clickable-element p-2 text-danger float-end" style="display: block" onclick="removeFile(this)">Remove</div>
                                                        <a href="#" class="attachment-preview-link float-end p-2" style="display: none" target="_blank">Preview</a> &nbsp; &nbsp; &nbsp; &nbsp;
                                                    </div>
                                                    <input type="file" class="form-control attachment-input" name="attachments[]" required autocomplete="name" onchange="previewFile(this)">
                                                    @error('attachments.*')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div>
                                                    <div class="text-decoration-underline clickable-element p-2 float-end text-primary add-new-attachment"  onclick="addNewAttachment()">+Add New Attachment</div>
        
                                                </div>
                                            </div>
                                            @endif
                                        </div> --}}
                                        @php
                                            $ticketAttachments = json_decode($ticket['attachments'], true);
                                        @endphp

                                        <div class="row">
                                            <div class="col-2">
                                                <div class="label mt-2">
                                                    <label>{{ __('Attachments:') }}</label>
                                                </div>
                                            </div>
                                            <div class="col-10">
                                                <div class="card attachment-container">
                                                    <div class="card-body p-2" id="attachment-container">
                                                        @if (isset($ticketAttachments) && is_array($ticketAttachments))
                                                            @foreach ($ticketAttachments as $attachment)
                                                                <div>
                                                                    <div class="user_input_form" style="margin-top:10px">
                                                                        <div class="attachment-actions">
                                                                            <div class="attachment-remove-link clickable-element p-2 text-danger float-end"
                                                                                style="display: block"
                                                                                onclick="removeFile(this)">Remove</div>
                                                                            <a href="{{ asset('storage/' . $attachment) }}"
                                                                                value="{{ $attachment }}"
                                                                                class="attachment-preview-link float-end p-2"
                                                                                target="_blank">Preview</a>
                                                                        </div>

                                                                        <input type="text" class="form-control"
                                                                            style="width: 80%; padding: 0 20px" readonly
                                                                            name="existing_attachments[]"
                                                                            value="{{ basename($attachment) }}">
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        @endif

                                                        <div>
                                                            <div class="user_input_form">
                                                                <div class="attachment-actions">
                                                                    <div class="attachment-remove-link clickable-element p-2 text-danger float-end"
                                                                        style="display: none" onclick="removeFile(this)">
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
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>

                                            </div>
                                            <div class="col-12">
                                                <div class="text-decoration-underline clickable-element p-2 float-end text-primary add-new-attachment"
                                                    style="margin-top:15px" onclick="addNewAttachment()">+Add New
                                                    Attachment</div>
                                            </div>

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
                                                newItem.innerHTML = `
                                                <div class="user_input_form p-2">
                                                    <div class="attachment-actions">
                                                        <div class="attachment-remove-link clickable-element p-2 text-danger float-end"
                                                            style="display: block" onclick="removeFile(this)">Remove</div>
                                                        <a href="#" class="attachment-preview-link float-end p-2" style="display: none"
                                                            target="_blank">Preview</a>
                                                        &nbsp; &nbsp; &nbsp; &nbsp;
                                                    </div>
                                                    <input type="file" class="form-control attachment-input" name="attachments[]" required
                                                        autocomplete="name" onchange="previewFile(this)">
                                                </div>
                                            `;
                                                container.appendChild(newItem);
                                                initMap();
                                            }
                                        </script>





                                    </div>

                                    <div class="user_btn_list">
                                        <div class="user_btn myborder">
                                            <button type="submit" class=" user_btn_style submit ">
                                                <img src="{{ asset('assets/images/next.png') }}" alt="->"> Save
                                                Changes
                                            </button>
                                        </div>
                                        <div class="user_btn myborder" onclick="window.history.go(-1); return false;">
                                            <button class="user_btn_style submit"> <img
                                                    src="{{ asset('assets/images/close.png') }}"> Close</button>
                                        </div>
                                    </div>
                                </div>
                        </div>

                        </form>
                        <hr>
                        <div class="row mt-4">
                            <div class="col-12 ">
                                <div class="label">
                                    @if ($user->hasRole('admin'))
                                        <label>{{ __('Dev Notes:') }}</label>
                                    @else
                                        <label>{{ __('User Comments:') }}</label>
                                    @endif
                                </div>
                            </div>
                            <div class="col-12 ">
                                <div class="user_form_content  ">


                                    <div class="user_form_content col-12">
                                        <div class="user_input_form">
                                            <textarea class="form-control" id="post" value="" rows="4" name="posts"
                                                autofocus></textarea>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="col-12 ">
                                <div class="mb-5">
                                    <div class=" user_btn myborder label float-end">
                                        <div class=" user_btn_style submit clickable-element" onclick="addRepeaterItem()">
                                            Post
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-12 ">
                                @if ($user->hasRole('admin'))
                                    <label>{{ __('Dev Notes:') }}</label>
                                @else
                                    <label>{{ __('User Comments:') }}</label>
                                @endif
                            </div>
                        </div>

                        @php
                            function getInitials($name)
                            {
                                $nameWords = explode(' ', $name);
                                $initials = strtoupper($nameWords[0][0]);

                                if (count($nameWords) > 1) {
                                    $initials .= strtoupper($nameWords[count($nameWords) - 1][0]);
                                }

                                return $initials;
                            }
                        @endphp
                        <div class="card">
                            <div class="card-body p-4" id="repeater-container">
                                @if ($comments != [])
                                    @foreach ($comments as $comment)
                                        <div>
                                            <div class="container">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="media g-mb-30 media-comment  d-flex">
                                                            <div data-initials="{{ getInitials($comment->user->name) }}">
                                                            </div>
                                                            <div
                                                                class="media-body u-shadow-v18 g-bg-secondary g-pa-30 w-100">
                                                                <div class="g-mb-15">
                                                                    <h5 class="h5 g-color-gray-dark-v1 mb-0">
                                                                        {{ $comment->user->name }}</h5>
                                                                    <div class="d-flex ">
                                                                        <span class="g-color-gray-dark-v4 g-font-size-12">
                                                                            {{ $comment->updated_at }}</span>
                                                                        @if ($user->id === $comment->user->id ||( Auth::check() && $user->hasRole('admin')) )
                                                                            <div class="ms-4"
                                                                                onclick="removeRepeaterItem(this, {{ $comment->id }})">
                                                                                <i class="fa fa-trash-o text-dark w-75"
                                                                                    aria-hidden="true"></i>
                                                                            </div>
                                                                            <div class="ms-3"
                                                                                onclick="editRepeaterItem(this, {{ $comment->id }})">
                                                                                <i class="fa fa-pencil-square-o text-secondary  w-75"
                                                                                    aria-hidden="true"></i>
                                                                            </div>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                                <div id="comment-place">
                                                                    <div class="user_input_form" style="display: none;">
                                                                        <textarea class="form-control" id="comment" name="comment" autofocus>{{ $comment->comment }}</textarea>
                                                                    </div>

                                                                    <p>{{ $comment->comment }}</p>
                                                                </div>


                                                                <ul class="list-inline w-100  my-0 submit-button"
                                                                    style="justify-content: flex-end; display:none;">
                                                                    <li class="list-inline-item ml-auto">
                                                                        <button onclick="editRepeaterComment(this, {{ $comment->id }})"
                                                                            class="btn btn-light u-link-v5 g-color-gray-dark-v4 g-color-primary--hover">
                                                                            <i
                                                                                class="fa fa-paper-plane g-pos-rel g-top-1 g-mr-3"></i>
                                                                            Submit
                                                                        </button>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>


                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>

                        <script>
                            function storeComment(content, user_id, ticket_id) {
                                var csrfToken = $('meta[name="csrf-token"]').attr('content');

                                // Make AJAX request
                                $.ajax({
                                    type: 'POST',
                                    url: '/comments/store',
                                    headers: {
                                        'X-CSRF-TOKEN': csrfToken
                                    },
                                    data: {
                                        // _token: csrfToken, // Include the CSRF token in the data

                                        content: content,
                                        user_id: user_id,
                                        ticket_id: ticket_id

                                    },
                                    success: function(response) {
                                        // Handle successful response
                                        console.log('Comment stored:', response);
                                        handleSuccess(response.comment, content, user_id, ticket_id, response.time);
                                        // return response;
                                        // Optionally, do something with the response
                                    },
                                    error: function(xhr, status, error) {
                                        // Handle error
                                        console.error('Error storing comment:', error);
                                    }

                                });

                                function handleSuccess(comment, content, user_id, ticket_id, time) {
                                    const repeaterContainer = document.getElementById('repeater-container');
                                    const newItem = document.createElement('div');

                                    var username = {!! json_encode($user->name) !!};

                                    console.log("comment_id IS ", comment.id);
                                    newItem.innerHTML = `
                                    <div class="container">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="media g-mb-30 media-comment  d-flex">
                                                            <div data-initials="${getInitials(username)}">
                                                            </div>
                                                            <div
                                                                class="media-body u-shadow-v18 g-bg-secondary g-pa-30 w-100">
                                                                <div class="g-mb-15">
                                                                    <h5 class="h5 g-color-gray-dark-v1 mb-0">
                                                                        ${username }</h5>
                                                                    <div class="d-flex ">
                                                                        <span class="g-color-gray-dark-v4 g-font-size-12">
                                                                            ${time }</span>
                                                                        <div class="ms-4"
                                                                            onclick="removeRepeaterItem(this, ${comment.id })">
                                                                            <i class="fa fa-trash-o text-dark w-75"
                                                                                aria-hidden="true"></i>
                                                                        </div>

                                                                        <div class="ms-3"
                                                                            onclick="editRepeaterItem(this, ${comment.id })">
                                                                            <i class="fa fa-pencil-square-o text-secondary  w-75"
                                                                                aria-hidden="true"></i>
                                                                        </div>
                                                                    </div>


                                                                </div>
                                                                <div id="comment-place">
                                                                    <div class="user_input_form" style="display: none;">
                                                                        <textarea class="form-control" id="comment" name="comment" autofocus>${comment.comment }</textarea>
                                                                    </div>

                                                                    <p>${comment.comment }</p>
                                                                </div>


                                                                <ul class="list-inline w-100  my-0 submit-button"
                                                                    style="justify-content: flex-end; display:none;">
                                                                    <li class="list-inline-item ml-auto">
                                                                        <button onclick="editRepeaterComment(this, ${comment.id })"
                                                                            class="btn btn-light u-link-v5 g-color-gray-dark-v4 g-color-primary--hover">
                                                                            <i
                                                                                class="fa fa-paper-plane g-pos-rel g-top-1 g-mr-3"></i>
                                                                            Submit
                                                                        </button>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>


                                                </div>
                                            </div>
                                                `;
                                    // user_input_form
                                    repeaterContainer.appendChild(newItem);
                                }

                            }

                            function addRepeaterItem() {
                                var content = document.getElementById('post').value;
                                var user_id = {!! json_encode($user->id) !!};
                                var ticket_id = {!! json_encode($ticket->id) !!};
                                var comment_id = storeComment(content, user_id, ticket_id);
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

                            function editRepeaterComment(element, comment_id) {
                                // Make AJAX request
                                var commentInputField = element.closest('.media-comment').querySelector('#comment').value;
                                console.log(commentInputField);

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

                                var csrfToken = $('meta[name="csrf-token"]').attr('content');

                                $.ajax({
                                    type: 'PUT',
                                    url: '/comments/update',
                                    headers: {
                                        'X-CSRF-TOKEN': csrfToken
                                    },
                                    data: {
                                        comment_id: comment_id,
                                        comment: commentInputField
                                    },
                                    success: function(response) {
                                        // Handle successful response
                                        console.log('Comment updated:', response);
                                        // Optionally, do something with the response
                                    },
                                    error: function(xhr, status, error) {
                                        // Handle error
                                        console.error('Error updating comment:', error);
                                    }
                                });
                            }

                            function removeComment(comment_id, user_id, ticket_id) {
                                // Make AJAX request
                                // alert('ddddddd');
                                var csrfToken = $('meta[name="csrf-token"]').attr('content');

                                $.ajax({
                                    type: 'POST',
                                    url: '/comments/delete',
                                    headers: {
                                        'X-CSRF-TOKEN': csrfToken
                                    },
                                    data: {
                                        // _token: csrfToken, // Include the CSRF token in the data

                                        comment_id: comment_id,
                                        user_id: user_id,
                                        ticket_id: ticket_id

                                    },
                                    success: function(response) {
                                        // Handle successful response
                                        console.log('Comment deleted:', response);
                                        // Optionally, do something with the response
                                    },
                                    error: function(xhr, status, error) {
                                        // Handle error
                                        console.error('Error deleting comment:', error);
                                    }
                                });
                            }



                            function removeRepeaterItem(button, comment_id) {
                                var content = document.getElementById('post').value;
                                var user_id = {!! json_encode($user->id) !!};
                                var ticket_id = {!! json_encode($ticket->id) !!};

                                removeComment(comment_id, user_id, ticket_id);

                                button.parentElement.parentElement.parentElement.remove();



                            }
                        </script>



                    </div>
                </div>
            </div>
        </div>
        @php
            // function generateRandomNumber()
            // {
            //     // Generate a random number with a length of 4 digits
            //     return str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT);
            // }

            // function generateUniqueString($companyInitials)
            // {
            //     // Get the current year
            //     $currentYear = date('Y');

            //     // Generate a random number
            //     $randomNumber = generateRandomNumber();

            //     // Combine the elements to create the final string
            //     $result = "{$companyInitials}-{$currentYear}-{$randomNumber}";

            //     return $result;
            // }
        @endphp
    </div>
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
           <div class="user_input_form">
               <div class="attachment-actions">
                   <div class="attachment-remove-link   clickable-element p-2 text-danger float-end" style="display: block" onclick="removeFile(this)">Remove</div>
                   <a href="#" class="attachment-preview-link float-end p-2" style="display: none" target="_blank">Preview</a> &nbsp; &nbsp; &nbsp; &nbsp;
               </div>
               <input type="file" class="form-control attachment-input" name="attachments[]" required autocomplete="name" onchange="previewFile(this)">
           </div>
           `;
            // user_input_form
            container.appendChild(newItem);
            initMap();
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
