@extends('layouts.master')
@php
    use Carbon\Carbon;
@endphp

@section('content')

				<!--begin::Toolbar-->
				<div class="toolbar" id="kt_toolbar">
                    <!--begin::Container-->
                    <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
                        <!--begin::Page title-->
                        <div data-kt-swapper="true" data-kt-swapper-mode="prepend"
                             data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}"
                             class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
                            <!--begin::Title-->
                            <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">SMS List
                                <!--begin::Separator-->
                                <span class="h-20px border-gray-200 border-start ms-3 mx-2"></span>
                                <!--end::Separator-->
                                <!--begin::Description-->
                                <small class="text-muted fs-7 fw-bold my-1 ms-1">Send SMS List</small>
                                <!--end::Description--></h1>
                            <!--end::Title-->
                        </div>
                        <!--end::Page title-->
                        <!--begin::Actions-->
                        <!--end::Actions-->
                    </div>
                    <!--end::Container-->
                </div>
                <!--end::Toolbar-->
                 <!--**********************************
                                Tables
                  ***********************************-->
<div class="container-fluid">

<!--Table Alert Message-->
<!-- Display Success and Error Messages using SweetAlert2 -->
    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: '{{ session('success')}}',
                showConfirmButton: false,
                timer: 1500
            });
        </script>
    @endif

    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: '{{ session('error')}}',
                showConfirmButton: false,
                timer: 1500
            });
        </script>
    @endif

<!--End Table Alert Message-->


<div class="row">
	<div class="col-xxl-12">
		<div class="card mt-5">
			<!--begin::Header-->
			<div class="d-flex justify-content-between align-items-start card-header border-0 pt-1">
				<h3 class="card-title align-items-start flex-column">
					<span class="card-label fw-bolder fs-3 mb-1">SMS List</span>
					<!-- <span class="text-muted mt-1 fw-bold fs-7">Leads Form data here</span> -->
				</h3>

				<div class="d-flex flex-wrap gap-2">
				<form action="{{ route('send-sms-list') }}" method="GET" class="d-flex">
					<!--begin::Input group-->
					<div class="d-flex align-items-center position-relative">
						<!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
						<span class="svg-icon svg-icon-1 position-absolute ms-6">
							<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
								viewBox="0 0 24 24" fill="none">
								<rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546"
									height="2" rx="1" transform="rotate(45 17.0365 15.1223)"
									fill="black"></rect>
								<path
									d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z"
									fill="black"></path>
							</svg>
						</span>
						<!--end::Svg Icon-->
						<input type="text" name="search" class="form-control form-control-sm form-control-solid w-250px ps-15" value="{{ request('search') }}" placeholder="Search by sms Address">
					</div>
					<!--end::Input group-->
					<button type="submit" class="btn btn-primary btn-sm ms-2">Search</button>
				</form>
			</div>



			</div>
			<!--end::Header-->
			<!--begin::Body-->
			<div class="card-body py-3">
				<!--begin::Table container-->
				<div class="table-responsive">
				@if($sms->isNotEmpty())
					<!--begin::Table-->
					<table
						class="table table-sm table-condensed table-row-bordered table-row-gray-100 align-middle gs-0 gy-3">
						<!--begin::Table head-->
						<thead>
						<tr class="fw-bolder">
						    <th class="min-w-150px">SL</th>
						    <th class="min-w-150px">To</th>
							<th class="min-w-140px">Text</th>
							<th class="min-w-140px">Send Time</th>
							<th class="min-w-120px">Status</th>
						</tr>
						</thead>
						<!--end::Table head-->
						<!--begin::Table body-->
						<tbody>
						@foreach ($sms as $value)
						<tr>
						    <td class="text-dark fs-6">{{ $loop->iteration}}</td>
							<td class="text-dark fs-6">{{ $value->sms_to }}</td>
							<td class="text-dark fs-6">{{ $value->sms_text }}</td>
							<td class="text-dark fs-6">{{ Carbon::parse($value->log_time)->format('d-m-Y h:i A') }}</td>
		                    <td>
								@if ($value->send_status == 1)
									<span class="badge badge-light-success">Success</span>
								@elseif ($value->status == 0)
									<span class="badge badge-light-danger">Fail</span>
								@endif
                            </td>
						</tr>
						@endforeach
					
						</tbody>
						<!--end::Table body-->
					</table>
					@else
						<p>No results found.</p>
					@endif
					<!--end::Table-->
				</div>
				<!--end::Table container-->
			</div>
			<!--begin::Body-->

		</div>

		<!--Table Pagination-->
		<!-- <ul class="pagination">
			<li class="page-item previous disabled"><span class="page-link">Previous</span></span>
			</li>
			<li class="page-item "><a href="#" class="page-link">1</a></li>
			<li class="page-item active"><a href="#" class="page-link">2</a></li>
			<li class="page-item "><a href="#" class="page-link">3</a></li>
			<li class="page-item "><a href="#" class="page-link">4</a></li>
			<li class="page-item "><a href="#" class="page-link">5</a></li>
			<li class="page-item "><a href="#" class="page-link">6</a></li>
			<li class="page-item next"><a class="page-link" href="#">Next</span></a></li>
		</ul> -->

		<ul class="pagination">
			<!-- Previous Page Link -->
			@if ($sms->onFirstPage())
				<li class="page-item previous disabled"><span class="page-link">Previous</span></li>
			@else
				<li class="page-item previous"><a href="{{ $sms->previousPageUrl() }}" class="page-link">Previous</a></li>
			@endif

			<!-- Pagination Elements -->
			@for ($page = 1; $page <= $sms->lastPage(); $page++)
				@if ($page == $sms->currentPage())
					<li class="page-item active"><span class="page-link">{{ $page }}</span></li>
				@else
					<li class="page-item"><a href="{{ $sms->url($page) }}" class="page-link">{{ $page }}</a></li>
				@endif
			@endfor

			<!-- Next Page Link -->
			@if ($sms->hasMorePages())
				<li class="page-item next"><a href="{{ $sms->nextPageUrl() }}" class="page-link">Next</a></li>
			@else
				<li class="page-item next disabled"><span class="page-link">Next</span></li>
			@endif
		</ul>

		<!--End Table Pagination-->

	</div>
</div>
</div>

<script>
    function confirmDelete() {
        if (confirm("Are you sure you want to delete sms Template?")) {
            document.getElementById('deleteForm').submit();
        }
        return false;
    }
</script>

<!-- End Tables-->

@endsection