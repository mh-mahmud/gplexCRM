@extends('layouts.master')
@php
    use Carbon\Carbon;
@endphp

@section('content')

    <!--begin::Toolbar-->

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
                    text: '{{ session('success') }}',
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
                    text: '{{ session('error') }}',
                    showConfirmButton: false,
                    timer: 1500
                });
            </script>
        @endif

        <!--End Table Alert Message-->


        <div class="row">
            <div class="col-xxl-12">
                <div class="card mt-4">
                    <!--begin::Header-->
                    <div class="d-flex justify-content-between align-items-start card-header border-0 p-1">
                        <h3 class="card-title align-items-start flex-column">
                            <span class="card-label fw-bolder fs-3 mb-1">Activity Logs</span>
                            <!-- <span class="text-muted mt-1 fw-bold fs-7">Leads Form data here</span> -->
                        </h3>

                    </div>
                    <!--end::Header-->
                    <!--begin::Body-->
                    <div class="card-body p-1">
                        <!--begin::Table container-->
                        <div class="table-responsive">
                            @if ($logs->isNotEmpty())
                                <!--begin::Table-->


                                                    <table class="table table-sm table-condensed table-row-bordered table-row-gray-100 align-middle gs-0 gy-3">
                                                        <!--begin::Table head-->
                                                        <thead>
                                                        <tr class="fw-bolder text-muted bg-light bd-cyan">
                                                            <th class="ps-4 rounded-start min-w-40px">SL</th>
                                                            <th class="min-w-150px">Module</th>
                                                            <th class="min-w-140px">Sub Module</th>
                                                            <th class="min-w-140px">Log Message</th>
                                                            <th class="min-w-140px">Lead</th>
                                                            <th class="min-w-140px">Created By</th>
                                                            <th class="min-w-120px">Created At</th>
                                                        </tr>
                                                        </thead>
                                                        <!--end::Table head-->
                                                        <!--begin::Table body-->
                                                        <tbody>
                                                        @foreach ($logs as $log)
                                                        <tr>
                                                            <td class="ps-5 text-dark fs-6">{{($logs->currentPage() - 1) * $logs->perPage() + $loop->iteration}}</td>
                                                            <td class="text-dark fs-6">{{ $log->module }}</td>
                                                            <td class="text-dark fs-6">{{ $log->sub_module }}</td>
                                                            <td class="text-dark fs-6">{{ $log->log_message }}</td>
                                                            <td class="text-dark fs-6">{{ $log->lead_first_name }} {{ $log->lead_last_name }}</td>
                                                            <td class="text-dark fs-6">{{ $log->first_name }} {{ $log->last_name }}</td>
                                                            <td>
                                                                {{ Carbon::parse($log->created_at)->format('d-m-Y h:i:s A') }}
                                                            </td>
                                                        </tr>
                                                        @endforeach

                                                        </tbody>
                                                        <!--end::Table body-->
                                                    </table>
                                                    <!--end::Table-->
                                                </div>
                                                <!--end::Table container-->
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

                @include('components.pagination', ['paginator' => $logs])

                <!--End Table Pagination-->

            </div>
        </div>
    </div>

    <script>
        function confirmDelete() {
            if (confirm("Are you sure you want to delete Email Template?")) {
                document.getElementById('deleteForm').submit();
            }
            return false;
        }
    </script>

    <!-- End Tables-->

@endsection
