@extends('layouts.app')

@section("top_links")
<link rel="stylesheet" href ="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css">
{{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous"> --}}
@endsection

@section("bottom_links")
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>

<script>
  

    // $(document).ready(function() {
    //   var table = $('#customDataTable').DataTable({
    //     // Add your DataTable options here, if needed.
    //   });
    
    //   // Add a custom button
    //   $('<button class="btn btn-primary btn-sm">Custom Button</button>')
    //     .appendTo($('#customDataTable_wrapper .dataTables_filter'))
    //     .on('click', function() {
    //       // Custom button action here
    //       alert('Custom button clicked!');
    //     });
    
    //   // Add a search bar (custom filter)
    //   $('#customDataTable_filter input').unbind().bind('keyup', function() {
    //     table.search(this.value).draw();
    //   });
    // });


//     $(document).ready(function() {
//   var table = $('#customDataTable').DataTable({
//     // Add your DataTable options here, if needed.
//     "pagingType": "full_numbers" // Use full_numbers paging type for more control
//   });


// });

$(document).ready(function() {
    var table = $('#customDataTable').DataTable({
    // Add your custom options here
    scrollX: true, // scroll horizontally
    paging: true, // Enable pagination
    searching: true, // Enable search bar
    ordering: true, // Enable column sorting
    lengthChange: true, // Show a dropdown for changing the number of records shown per page
    pageLength: 10, // Set the default number of records shown per page to 10
    dom: 'lBfrtip', // Define the layout of DataTable elements (optional)
    buttons: ['copy', 'excel', 'pdf', 'print'], // Add some custom buttons (optional)
    "pagingType": "full_numbers"

    
  });

  $('#customSearchInput').on('keyup', function() {
    table.search(this.value).draw();
  });
  // Custom search input for 'Name' column
  $('#name-search').on('change', function() {
    table.column(2).search(this.value).draw();
  });
  $('#next').on('click', function() {
      if (table.page() < table.pages() - 1) {
        customPagination(table.page() + 1);
      }
   });
   $('#previous').on('click', function() {
    if (table.page() > 0) {
        customPagination(table.page() - 1);
      }
   });

    
  var $paginationContainer = $('.custom-pagination');

  function goToPage(pageNumber) {
    table.page(pageNumber).draw('page');
    updatePaginationButtons();
  }

  function updatePaginationButtons() {
    var currentPage = table.page();
    var totalPages = table.page.info().pages;
    var pageInfo = table.page.info();

    $paginationContainer.empty();

    if (currentPage >= 0) {
      $paginationContainer.append(`<img class=" clickable-element next-prev-icon-style custom-page-btn prev" src="{{asset('assets/images/privious.png')}}"> ${pageInfo.start + 1} `);
    }
    //   for (var i = 0; i < totalPages; i++) {
    //     var activeClass = currentPage === i ? 'active' : '';
    //     $paginationContainer.append('<button class="custom-page-btn ' + activeClass + '">' + (i + 1) + '</button>');
    //   }

    if (currentPage <= totalPages - 1) {
      $paginationContainer.append(`- ${pageInfo.end} <img  class=" clickable-element next-prev-icon-style custom-page-btn next"  src="{{asset('assets/images/next.png')}}">`);
    }

    $('.custom-page-btn').on('click', function() {
      if ($(this).hasClass('prev')) {
        goToPage(currentPage - 1);
      } else if ($(this).hasClass('next')) {
        goToPage(currentPage + 1);
      } else {
        goToPage(parseInt($(this).text()) - 1);
      }
    });
  }

  updatePaginationButtons();

  // Update the custom button text with the current page length
  $('.current_pages').text(table.page.len());
  
  // Handle custom button click (Dropdown item selection)
  $('.dropdown-item').on('click', function() {
    var length = $(this).data('length');
    table.page.len(length).draw();
    updatePaginationButtons();

    // Update the custom button text with the selected page length
    $('.current_pages').text(length);
  });

  function updateTableInfo() {
    var pageInfo = table.page.info();
    var infoText = `${pageInfo.recordsTotal} records in total`;
    var startPage = `${pageInfo.start + 1}`;
    var endPage = `${pageInfo.end}`;

    $('.custom-table-info').text(infoText);
    $('.start_page').text(startPage);
    $('.end_page').text(endPage);
  }
  //  `Showing ${pageInfo.start + 1} to ${pageInfo.end} of ${pageInfo.recordsTotal} entries`
  // Call the function to set the initial table information
  updateTableInfo();

  // Event listener for DataTable page change
  table.on('page.dt', function() {
    updateTableInfo();
  });
});
</script>
@endsection

@section('content')
<div class="container">
    
    <div class="row mb-5" style="   max-width: 99%; margin: 1px auto;">
        <div class="col-md-12 col-12">
            {{-- <div class="Company" >Company
            </div>
             --}}
        </div>
        {{-- <div class="col-md-1 col-3"  style="margin: 1px auto;">
            <div class="add_btn">
                <a href="{{ route('company.create') }}"> <span>+</span>New</a>
            </div>
        </div> --}}
    </div>
    @if (session('success'))
      <div class="alert alert-success">
          {{ session('success') }}
      </div>
  @endif

  @if (session('error'))
  <div class="alert alert-danger">
      {{ session('error') }}
  </div>
  @endif
  <div class="row">
    <div class="col-12">
        <ul class="nav nav-tabs">
          <li class="nav-item">
            <a class="nav-link " aria-current="page" href="{{ route('companies.index') }}">Company</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" href="{{ route('companyUsers.index') }}">Users</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" aria-current="page" href="{{ route('tickets.index') }}">Requests</a>
        </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Complete</a>
            </li>
            
        </ul>
    </div>
</div>
    <div class="row mt-4" style="    max-width: 99%; margin: 1px auto; font-size: 12px;">
        <div class="col-12">
            <div class="table_btn_list">

                <div class="add_btn me-2">
                    <a href="{{ route('companyUsers.create') }}"> <span>+</span>New</a>
                </div>
                <div class="select_field me-2">
                    <select class="clickable-element" id="name-search">
                        <option class="text-secondary" value="">Select Company</option>
                        @if($companies!=null)
                        @foreach ($companies->unique('company_name')->sort() as $company)
                            <option value="{{ $company['company_name'] }}">{{ $company['company_name'] }}</option>
                        @endforeach
                        @endif
                    </select>
                </div>
            
                <div class="total_ticket me-2">
                    <p class="custom-table-info">10 records in total</p>
                </div>
                <div class="pagination_links custom-pagination me-2">
                    <div class="d-flex clickable-element" id="previous"><img class="next-prev-icon-style" src="{{asset('assets/images/privious.png')}}"><div class="start_page">1</div></div>
                    <div class="d-flex clickable-element"  id="next"> <div class="end_page"> 10 </div> <img  class="next-prev-icon-style"  src="{{asset('assets/images/next.png')}}"></div>
                </div>
            
                <div class="total_num clickable-element me-2">
                    <div class="custom-button">
                        <a class=" dropdown-toggle"data-toggle="dropdown">
                          <span class="current_pages">10</span> 
                        </a>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                          <div class="dropdown-item"  data-length="10">10</div>
                          <div class="dropdown-item"  data-length="25">25</div>
                          <div class="dropdown-item"  data-length="50">50</div>
                          <div class="dropdown-item"  data-length="100">100</div>
                        </div>
                      </div>
                      
                </div>
            </div>
        </div>
        {{-- {{dd($tickets)}} --}}
        <div class="col-12" style="margin: 1px auto; ">
            <table id="customDataTable" class="table  datatable table-bordered table-hover table-responsive nowrap" style="width:100%">
                <thead>
                    <tr>
                    <th class="thclass" scope="col">#</th>
                    <th class="thclass"  scope="col">Company</th>
                    <th class="thclass"  scope="col">Department</th>
                    <th class="thclass"  scope="col">Email Address</th>
                    <th class="thclass"  scope="col">First Name</th>
                    <th class="thclass"  scope="col">Last Name</th>
                    <th class="thclass"  scope="col">Access Privilege</th>
                    <th class="thclass"  scope="col">dateModified</th>
                    <th class="thclass"  scope="col">dateCreated</th>
                    {{-- <th class="thclass"  scope="col">Action</th> --}}

                    </tr>
                </thead>
                @php
                    $i=1;
                @endphp
                <tbody>
                    {{-- {{dd($companyUsers)}} --}}
                    @if($companyUsers!=null)
                    @foreach ($companyUsers as $companyUser)
                        <tr>
                          {{-- {{dd($companyUser)}} --}}
                            <td class="tdclass">{{ $i}}</td>
                            <td class="tdclass"> <a href="{{ route('companyUsers-edit', [$companyUser['id']]) }}" class="custom-link">{{ $companyUser->company->company_name }}
                            </a></td>
                            <td class="tdclass">{{ $companyUser->department }}</td>
                            <td class="tdclass">{{ $companyUser->user->email }}</td>
                            <td class="tdclass">
                                @php
                                    $name= explode(' ', $companyUser->user->name); //for first name and last name
                                @endphp
                                {{ $name[0]}}</td>

                            <td class="tdclass">{{ $name[1] }}</td>

                            <td class="tdclass">{{ $companyUser->access_privilege }}</td>
                            <td class="tdclass">{{ $companyUser->updated_at }}</td>
                            <td class="tdclass">{{ $companyUser->created_at}}</td>
                                    
                          {{-- <td class="tdclass">
                                <form action={{ route('companyUsers.destroy', $companyUser['id']) }} method="post">
                                    @csrf
                                    @method('DELETE')
                                
                                    <button class="submit delete-button">D
                                    </button>
                                    <a href="{{ route('companyUsers-edit', [$companyUser['id']]) }}">E
                                    </a>
                                </form>
                            
                            </td> --}}
                        </tr>
                        @php
                            $i++;
                        @endphp
                    @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    
    </script>
    
@endsection