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
                            <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Activity Logs
                                <!--begin::Separator-->
                                <span class="h-20px border-gray-200 border-start ms-3 mx-2"></span>
                                <!--end::Separator-->
                                <!--begin::Description-->
                                <small class="text-muted fs-7 fw-bold my-1 ms-1">Activity Logs</small>
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
		<div class="card mt-10">
			<!--begin::Header-->
			<div class="d-flex justify-content-between align-items-start card-header border-0 pt-1">
				<h3 class="card-title align-items-start flex-column">
					<span class="card-label fw-bolder fs-3 mb-1">Activity Logs</span>
					<!-- <span class="text-muted mt-1 fw-bold fs-7">Leads Form data here</span> -->
				</h3>
			</div>
			<!--end::Header-->
			<!--begin::Body-->
			<div class="card-body py-3">
                <div class="container-xxl">
                    <div class="row">
                        <div class="col-xxl-12">
                            <div class="card card-xxl-stretch">
                                <div class="card-header">
                                    <!--begin::Card title-->
                                    {{-- <div class="card-title m-0">
                                        <h3 class="fw-bolder m-0">Activity Logs</h3>
                                    </div> --}}
                                    <!--end::Card title-->
                                </div>

                                <!-- Card Body-->
                                <div class="card-body">


                                    <!--begin::Tab Logs-->
                                    <div id="kt_activity_month" class="card-body p-0 tab-pane fade show" role="tabpanel"
                                         aria-labelledby="kt_activity_month_tab">
                                        <!--begin::Timeline-->
                                        <div class="timeline">
				                            @if($logs->isNotEmpty())
                                           
                                                @foreach ($logs as $log)                                        
                                                <!--begin::Timeline item-->
                                                <div class="timeline-item">
                                                    <!--begin::Timeline line-->
                                                    <div class="timeline-line w-40px"></div>
                                                    <!--end::Timeline line-->
                                                    <!--begin::Timeline icon-->
                                                    <div class="timeline-icon symbol symbol-circle symbol-40px">
                                                        <div class="symbol-label bg-light">
                                                            <!--begin::Svg Icon | path: icons/duotune/communication/com009.svg-->
                                                            <span class="svg-icon svg-icon-2 svg-icon-gray-500">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                            height="24" viewBox="0 0 24 24" fill="none">
                                                                            <path opacity="0.3"
                                                                                d="M5.78001 21.115L3.28001 21.949C3.10897 22.0059 2.92548 22.0141 2.75004 21.9727C2.57461 21.9312 2.41416 21.8418 2.28669 21.7144C2.15923 21.5869 2.06975 21.4264 2.0283 21.251C1.98685 21.0755 1.99507 20.892 2.05201 20.7209L2.886 18.2209L7.22801 13.879L10.128 16.774L5.78001 21.115Z"
                                                                                fill="black"/>
                                                                            <path d="M21.7 8.08899L15.911 2.30005C15.8161 2.2049 15.7033 2.12939 15.5792 2.07788C15.455 2.02637 15.3219 1.99988 15.1875 1.99988C15.0531 1.99988 14.92 2.02637 14.7958 2.07788C14.6717 2.12939 14.5589 2.2049 14.464 2.30005L13.74 3.02295C13.548 3.21498 13.4402 3.4754 13.4402 3.74695C13.4402 4.01849 13.548 4.27892 13.74 4.47095L14.464 5.19397L11.303 8.35498C10.1615 7.80702 8.87825 7.62639 7.62985 7.83789C6.38145 8.04939 5.2293 8.64265 4.332 9.53601C4.14026 9.72817 4.03256 9.98855 4.03256 10.26C4.03256 10.5315 4.14026 10.7918 4.332 10.984L13.016 19.667C13.208 19.859 13.4684 19.9668 13.74 19.9668C14.0115 19.9668 14.272 19.859 14.464 19.667C15.3575 18.77 15.9509 17.618 16.1624 16.3698C16.374 15.1215 16.1932 13.8383 15.645 12.697L18.806 9.53601L19.529 10.26C19.721 10.452 19.9814 10.5598 20.253 10.5598C20.5245 10.5598 20.785 10.452 20.977 10.26L21.7 9.53601C21.7952 9.44108 21.8706 9.32825 21.9221 9.2041C21.9737 9.07995 22.0002 8.94691 22.0002 8.8125C22.0002 8.67809 21.9737 8.54505 21.9221 8.4209C21.8706 8.29675 21.7952 8.18392 21.7 8.08899Z"
                                                                                fill="black"/>
                                                                        </svg>
                                                                    </span>
                                                            <!--end::Svg Icon-->
                                                        </div>
                                                    </div>
                                                    <!--end::Timeline icon-->
                                                    <!--begin::Timeline content-->
                                                    <div class="timeline-content mb-10 mt-n2">
                                                        <!--begin::Timeline heading-->
                                                        <div class="overflow-auto pe-3">
                                                            <!--begin::Title-->
                                                            <div class="fs-5 fw-bold mb-2">{{ $log->log_message }}
                                                            </div>
                                                            <!--end::Title-->
                                                            <!--begin::Description-->
                                                            <div class="d-flex align-items-center mt-1 fs-6">
                                                                <!--begin::Info-->
                                                                <div class="text-muted me-2 fs-7">Added at {{ Carbon::parse($log->created_at)->format('d-m-Y h:i:s A') }}  by {{ $log->first_name }} {{ $log->last_name }}</div>
                                                                <!--end::Info-->
                                                            </div>
                                                            <!--end::Description-->
                                                        </div>
                                                        <!--end::Timeline heading-->
                                                    </div>
                                                    <!--end::Timeline content-->
                                                </div>
                                                <!--end::Timeline item-->
                                                @endforeach
                                            @else
                                                <p>No results found.</p>
                                            @endif

                                        </div>
                                        <!--end::Timeline-->
                                    </div>
                                    <!--end::Tab Logs-->

                                </div>
                                <!--End Card body-->

                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Forms-->


            </div>
				<!--begin::Table container-->
				
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

    	@include('components.pagination', ['paginator' => $logs])
		

		<!--End Table Pagination-->

	</div>
</div>
</div>

<!-- End Tables-->

@endsection