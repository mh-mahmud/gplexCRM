@extends('layouts.master')
@php
use Carbon\Carbon;
@endphp

@section('content')


<!-- <div class="content d-flex flex-column flex-column-fluid" id="kt_content"> -->

<!--begin::Toolbar-->
<div class="toolbar" id="kt_toolbar">
    <!--begin::Container-->
    <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
        <!--begin::Page title-->
        <div data-kt-swapper="true" data-kt-swapper-mode="prepend"
            data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}"
            class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
            <!--begin::Title-->
            <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Lead Details
                <!--begin::Separator-->
                <span class="h-20px border-gray-200 border-start ms-3 mx-2"></span>
                <!--end::Separator-->
                <!--begin::Description-->
                <small class="text-muted fs-7 fw-bold my-1 ms-1">Show Lead Details</small>
                <!--end::Description-->
            </h1>
            <!--end::Title-->
        </div>
        <!--end::Page title-->
        <!--begin::Actions-->
        <div class="d-flex align-items-center py-1">

            @if($customer_id==null)
                <a href="{{ route('add-customer', $lead->id) }}" class="btn btn-sm btn-danger" id="kt_toolbar_primary_button">Add as Customer</a>
            @else
                <span style="border: 1px solid #14A44D;padding:6px;color:#FFF;background-color:#14A44D;border-radius:5px;">Customer ID: {{ $customer_id }}</span>
            @endif
            
            &nbsp;
            <a href="{{ route('lead-index') }}" class="btn btn-sm btn-primary" id="kt_toolbar_primary_button">Lead List</a>
            <!--end::Button-->
        </div>
        <!--end::Actions-->
    </div>
    <!--end::Container-->
</div>
<!--end::Toolbar-->

<!--**********************************
               Tables View
     ***********************************-->
<div class="container-fluid">
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
    <div class="row">
        <div class="col-xxl-12 mx-auto">
            <!--**********************************
                             Table Tabs
                 ***********************************-->
            <div class="card mt-2">
                <div class="card-header">
                    <ul class="nav nav-tabs nav-stretch fs-6 border-0">
                        <li class="nav-item">
                            <a class="nav-link @if(session('success') || session('error')) @else active @endif"
                                data-bs-toggle="tab" href="#g_lead_details">Lead Details</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link @if(session('success') || session('error')) active @endif"
                                data-bs-toggle="tab" href="#g_lead_table">Lead Table</a>
                        </li>

                        <!-- new tables added by customer panel -->
                        <li class="nav-item">
                            <a class="nav-link @if(session('success') || session('error')) active @endif" data-bs-toggle="tab" href="#g_lead_email">Email</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link @if(session('success') || session('error')) active @endif" data-bs-toggle="tab" href="#g_lead_sms">SMS</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link @if(session('success') || session('error')) active @endif" data-bs-toggle="tab" href="#g_lead_meeting">Meetings</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link @if(session('success') || session('error')) active @endif" data-bs-toggle="tab" href="#g_lead_proposals">Proposals</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link @if(session('success') || session('error')) active @endif" data-bs-toggle="tab" href="#g_lead_products">Products</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link @if(session('success') || session('error')) active @endif" data-bs-toggle="tab" href="#g_lead_invoice">Invoice</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link @if(session('success') || session('error')) active @endif" data-bs-toggle="tab" href="#g_lead_tickets">Tickets</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link @if(session('success') || session('error')) active @endif" data-bs-toggle="tab" href="#g_lead_activity_log">Activity Logs</a>
                        </li>


                    </ul>

                </div>
            </div>


            {{--End Table Tabs--}}

            {{--Tab Content--}}
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show @if(session('success') || session('error')) @else active @endif" id="g_lead_details" role="tabpanel">
                    <div class="card">

                        <div class="card-header bg-light bd-cyan">
                            <div class="card-title">
                                <h2>Lead Details</h2>
                            </div>
                        </div>
                        <!--begin::Body-->
                        <div class="card-body py-2">

                            <div class="g-lead-details-area mb-5">


                                <div class="d-flex align-items-center gap-2 bg-light p-1 mb-1">
                                    <span
                                        class="fs-7 fw-bolder mb-1 text-gray-900 text-hover-primary w-lg-100px w-xxl-150px flex-shrink-0">Form Name</span>
                                    <span>{{ $lead->leadsForm?->form_name ?? '' }}</span>
                                </div>

                                <div class="d-flex align-items-center gap-2 bg-light p-1 mb-1">
                                    <span
                                        class="fs-7 fw-bolder mb-1 text-gray-900 text-hover-primary w-lg-100px w-xxl-150px flex-shrink-0">First Name</span>
                                    <span>{{ $lead->first_name }}</span>
                                </div>
                                <div class="d-flex align-items-center gap-2 bg-light p-1 mb-1">
                                    <span
                                        class="fs-7 fw-bolder mb-1 text-gray-900 text-hover-primary w-lg-100px w-xxl-150px flex-shrink-0">Last Name</span>
                                    <span>{{ $lead->last_name }}</span>
                                </div>

                                <div class="d-flex align-items-center gap-2 bg-light p-1 mb-1">
                                    <span
                                        class="fs-7 fw-bolder mb-1 text-gray-900 text-hover-primary w-lg-100px w-xxl-150px flex-shrink-0">Email</span>
                                    <span>{{ $lead->email }}</span>
                                </div>

                                <div class="d-flex align-items-center gap-2 bg-light p-1 mb-1">
                                    <span
                                        class="fs-7 fw-bolder mb-1 text-gray-900 text-hover-primary w-lg-100px w-xxl-150px flex-shrink-0">Phone</span>
                                    <span>{{ $lead->phone }}</span>
                                </div>

                                <div class="d-flex align-items-center gap-2 bg-light p-1 mb-1">
                                    <span
                                        class="fs-7 fw-bolder mb-1 text-gray-900 text-hover-primary w-lg-100px w-xxl-150px flex-shrink-0">Alternative Number</span>
                                    <span>{{ $lead->alternative_number }}</span>
                                </div>


                                <div class="d-flex align-items-center gap-2 bg-light p-1 mb-1">
                                    <span
                                        class="fs-7 fw-bolder mb-1 text-gray-900 text-hover-primary w-lg-100px w-xxl-150px flex-shrink-0">Address</span>
                                    <span>{{ $lead->address }}</span>
                                </div>

                                <div class="d-flex align-items-center gap-2 bg-light p-1 mb-1">
                                    <span
                                        class="fs-7 fw-bolder mb-1 text-gray-900 text-hover-primary w-lg-100px w-xxl-150px flex-shrink-0">Company</span>
                                    <span>{{ $lead->company }}</span>
                                </div>

                                <div class="d-flex align-items-center gap-2 bg-light p-1 mb-1">
                                    <span
                                        class="fs-7 fw-bolder mb-1 text-gray-900 text-hover-primary w-lg-100px w-xxl-150px flex-shrink-0">Status</span>
                                    @if ($lead->lead_status === 1)
                                    <span>Active</span>
                                    @elseif ($lead->lead_status === 0)
                                    <span>Inactive</span>
                                    @endif
                                </div>

                                <div class="d-flex align-items-center gap-2 bg-light p-1 mb-1">
                                    <span
                                        class="fs-7 fw-bolder mb-1 text-gray-900 text-hover-primary w-lg-100px w-xxl-150px flex-shrink-0">Lead Rating</span>
                                    <span>{{ $lead->lead_rating }}</span>
                                </div>

                                <div class="d-flex align-items-center gap-2 bg-light p-1 mb-1">
                                    <span
                                        class="fs-7 fw-bolder mb-1 text-gray-900 text-hover-primary w-lg-100px w-xxl-150px flex-shrink-0">Website</span>
                                    <span>{{ $lead->website }}</span>
                                </div>

                                <div class="d-flex align-items-center gap-2 bg-light p-1 mb-1">
                                    <span
                                        class="fs-7 fw-bolder mb-1 text-gray-900 text-hover-primary w-lg-100px w-xxl-150px flex-shrink-0">Lead Owner</span>
                                    <span>{{ $lead->lead_owner }}</span>
                                </div>

                                <div class="d-flex align-items-center gap-2 bg-light p-1 mb-1">
                                    <span
                                        class="fs-7 fw-bolder mb-1 text-gray-900 text-hover-primary w-lg-100px w-xxl-150px flex-shrink-0">Industry</span>
                                    <span>{{ $lead->industry }}</span>
                                </div>


                                <div class="d-flex align-items-center gap-2 bg-light p-1 mb-1">
                                    <span
                                        class="fs-7 fw-bolder mb-1 text-gray-900 text-hover-primary w-lg-100px w-xxl-150px flex-shrink-0">Lead Source</span>
                                    <span>
                                        @if(in_array($lead->lead_source, config('constants.lead_source')))
                                        {{ $lead->lead_source }}
                                        @else

                                        @endif
                                    </span>
                                </div>

                                <div class="d-flex align-items-center gap-2 bg-light p-1 mb-1">
                                    <span
                                        class="fs-7 fw-bolder mb-1 text-gray-900 text-hover-primary w-lg-100px w-xxl-150px flex-shrink-0">Street</span>
                                    <span>{{ $lead->street }}</span>
                                </div>

                                <div class="d-flex align-items-center gap-2 bg-light p-1 mb-1">
                                    <span
                                        class="fs-7 fw-bolder mb-1 text-gray-900 text-hover-primary w-lg-100px w-xxl-150px flex-shrink-0">City</span>
                                    <span>{{ $lead->city }}</span>
                                </div>

                                <div class="d-flex align-items-center gap-2 bg-light p-1 mb-1">
                                    <span
                                        class="fs-7 fw-bolder mb-1 text-gray-900 text-hover-primary w-lg-100px w-xxl-150px flex-shrink-0">Zip</span>
                                    <span>{{ $lead->zip }}</span>
                                </div>

                                <div class="d-flex align-items-center gap-2 bg-light p-1 mb-1">
                                    <span
                                        class="fs-7 fw-bolder mb-1 text-gray-900 text-hover-primary w-lg-100px w-xxl-150px flex-shrink-0">State</span>
                                    <span>{{ $lead->state }}</span>
                                </div>

                                <div class="d-flex align-items-center gap-2 bg-light p-1 mb-1">
                                    <span
                                        class="fs-7 fw-bolder mb-1 text-gray-900 text-hover-primary w-lg-100px w-xxl-150px flex-shrink-0">Country</span>
                                    <span>{{ $lead->country }}</span>
                                </div>

                                <div class="d-flex align-items-center gap-2 bg-light p-1 mb-1">
                                    <span
                                        class="fs-7 fw-bolder mb-1 text-gray-900 text-hover-primary w-lg-100px w-xxl-150px flex-shrink-0">Lead Notes</span>
                                    <span>{{ $lead->lead_notes }}</span>
                                </div>

                                <div class="d-flex align-items-center gap-2 bg-light p-1 mb-1">
                                    <span class="fs-7 fw-bolder mb-1 text-gray-900 text-hover-primary w-lg-100px w-xxl-150px flex-shrink-0">Profile Image</span>
                                    <span></span>
                                    @if(!empty($lead->profile_image))
                                        <img src="{{ asset('uploads/leads/' . $lead->profile_image) }}" width="150">
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade show @if(session('success') || session('error')) active @endif" id="g_lead_table" role="tabpanel">
                    <div class="card">
                        <div class="card-body">

                            @foreach ($tableData as $tableName => $data)
                             <!-- @if (!empty($data)) -->
                            @php
                            $field = $fields->firstWhere('table_name', $tableName);
                            $viewType = $field->view_type ?? 'table_view'; // Default to table_view if view_type is not set

                            //Initialize arrays to store column sizes and form data
                            //Iterate over all rows to collect column information
                            $columnSizes = [];
                            $formData = [];

                            @endphp
                            @if ($viewType === 'form_view')
                            @foreach ($data as $row)
                            @foreach ($row as $key => $value)
                            @if (!in_array($key, ['id', 'lead_id', 'form_id', 'created_at', 'updated_at']))
                            @php
                            $field = $fields->where('field_name', $key)->first();
                            $formSize = $field->form_size ?? 'col-md-12';
                            $isFile = $field && $field->field_value === 'file';

                            //Map the column size to the corresponding mb- class
                            $columnSize = '';
                            switch ($formSize) {
                            case 'col-md-3':
                            $columnSize = '1';
                            break;
                            case 'col-md-6':
                            $columnSize = '2';
                            break;
                            case 'col-md-9':
                            $columnSize = '3';
                            break;
                            case 'col-md-12':
                            default:
                            $columnSize = '4';
                            break;
                            }

                            // Store column sizes and form data
                            if (!isset($columnSizes[$formSize])) {
                            $columnSizes[$formSize] = $formSize;
                            }

                            if (!isset($formData[$formSize])) {
                            $formData[$formSize] = [];
                            }

                            $formData[$formSize][] = [
                            'key' => $key,
                            'value' => $value,
                            'isFile' => $isFile
                            ];
                            @endphp
                            @endif
                            @endforeach
                            @endforeach

                            <div class="row mb-1">
                                <strong class="fs-3">{{ ucwords(str_replace('_', ' ', $tableName)) }}</strong>
                                @foreach ($columnSizes as $formSize)
                                <div class="{{ $formSize }}">
                                    <div class="g-lead-details mb-5" style="columns: {{ $columnSize }}">
                                        @foreach ($formData[$formSize] as $dataItem)
                                        <div class="d-flex align-items-center gap-2 bg-light p-1 mb-1">
                                            <span class="fs-6 fw-bolder mb-1 text-gray-900 text-hover-primary w-lg-100px w-xxl-150px flex-shrink-0">
                                                {{ ucwords(str_replace('_', ' ', $dataItem['key'])) }}
                                            </span>
                                            @if ($dataItem['isFile'])
                                            @if (!empty($dataItem['value']))
                                            <span><a href="{{ url('uploads/files/' . $dataItem['value']) }}" download>Download</a></span>
                                            @else
                                            <span></span>
                                            @endif
                                            @else
                                            <span>{{ $dataItem['value'] }}</span>
                                            @endif
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            @endif
                            @endif
                            @endforeach

                            {{-- Display table_view after form_view --}}
                            @foreach ($tableData as $tableName => $data)
                            @if (!empty($data))
                            @php
                            $field = $fields->firstWhere('table_name', $tableName);
                            $viewType = $field->view_type ?? 'table_view'; // Default to table_view if view_type is not set
                            @endphp

                            @if ($viewType === 'table_view')
                            <div>
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <strong class="fs-3">{{ ucwords(str_replace('_', ' ', $tableName)) }}</strong>
                                    <button type="button" class="btn btn-success btn-sm"
                                        onclick="window.location='{{ route('leads-add', ['tableName' => $tableName, 'leadId' => $lead->id]) }}'">
                                        <i class="bi bi-plus-lg"></i>
                                        Add New
                                    </button>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-sm table-condensed table-row-bordered table-row-gray-100 align-middle gs-0 gy-3">
                                        <thead>
                                            <tr class="fw-bolder text-muted bg-light bd-cyan">
                                                @if ($data->isNotEmpty() && $data->first() !== null)
                                                <th class="ps-4 min-w-50px">SL</th>
                                                @foreach ($data->first() as $key => $value)
                                                @if (!in_array($key, ['id', 'lead_id', 'form_id', 'created_by', 'created_at', 'updated_at']))
                                                <th class="ps-4 min-w-150px">{{ ucwords(str_replace('_', ' ', $key)) }}</th>
                                                @endif
                                                @endforeach
                                                <th class="ps-4 min-w-150px">Created By</th>
                                                <th class="min-w-50px text-end pe-4">Action</th>
                                                @else
                                                <th class="ps-4 min-w-150px">&nbsp;</th>
                                                @endif
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if ($data->isNotEmpty())
                                            @foreach ($data as $index => $row)
                                            <tr>
                                                <td class="ps-4 text-dark fs-6">{{ $index + 1 }}</td>
                                                @foreach ($row as $key => $value)
                                                @if (!in_array($key, ['id', 'lead_id', 'form_id','created_by', 'created_at', 'updated_at']))
                                                @php
                                                $field = $fields->where('field_name', $key)->first();
                                                $isFile = $field && $field->field_value === 'file';
                                                $isDate = $field && $field->field_value === 'date';
                                                @endphp

                                                @if ($isFile)
                                                <td class="ps-5 text-dark fs-6">
                                                    @if (!empty($value))
                                                    <a href="{{ url('uploads/files/' . $value) }}" download>Download</a>
                                                    @else
                                                    <span></span>
                                                    @endif
                                                </td>
                                                @elseif ($isDate)
                                                <td class="ps-5 text-dark fs-6">
                                                    {{ !empty($value) ? $value : ' ' }}
                                                </td>
                                                @else
                                                <td class="ps-5 text-dark fs-6">{{ $value }}</td>
                                                @endif
                                                @endif
                                                @endforeach
                                                <td class="ps-5 text-dark fs-6">{{ $row->created_by }}</td>
                                                <td class="text-end pe-6">
                                                <a href="{{ route('lead-edit-tabledata', ['tableName' => $tableName, 'leadId' => $row->id]) }}" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                                                    <!--begin::Svg Icon | path: icons/duotune/art/art005.svg-->
                                                    <span class="svg-icon svg-icon-3">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                            <path opacity="0.3" d="M21.4 8.35303L19.241 10.511L13.485 4.755L15.643 2.59595C16.0248 2.21423 16.5426 1.99988 17.0825 1.99988C17.6224 1.99988 18.1402 2.21423 18.522 2.59595L21.4 5.474C21.7817 5.85581 21.9962 6.37355 21.9962 6.91345C21.9962 7.45335 21.7817 7.97122 21.4 8.35303ZM3.68699 21.932L9.88699 19.865L4.13099 14.109L2.06399 20.309C1.98815 20.5354 1.97703 20.7787 2.03189 21.0111C2.08674 21.2436 2.2054 21.4561 2.37449 21.6248C2.54359 21.7934 2.75641 21.9115 2.989 21.9658C3.22158 22.0201 3.4647 22.0084 3.69099 21.932H3.68699Z" fill="black" />
                                                            <path d="M5.574 21.3L3.692 21.928C3.46591 22.0032 3.22334 22.0141 2.99144 21.9594C2.75954 21.9046 2.54744 21.7864 2.3789 21.6179C2.21036 21.4495 2.09202 21.2375 2.03711 21.0056C1.9822 20.7737 1.99289 20.5312 2.06799 20.3051L2.696 18.422L5.574 21.3ZM4.13499 14.105L9.891 19.861L19.245 10.507L13.489 4.75098L4.13499 14.105Z" fill="black" />
                                                        </svg>
                                                    </span>
                                                    <!--end::Svg Icon-->
                                                    </a>
                                                    <form action="{{ route('delete-tabledata', ['tableName' => $tableName, 'id' => $row->id, 'leadId' => $lead->id]) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this record?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm px-2 py-1">
                                                            <i class="bi bi-x p-0"></i>
                                                        </button>
                                                    </form>

                                                   
                                                </td>
                                                

                                                <!-- <td class="text-end pe-4">

                                                    <a href="{{ route('lead-edit-tabledata', ['tableName' => $tableName, 'leadId' => $row->id]) }}" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                                                       
                                                        <span class="svg-icon svg-icon-3">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                                <path opacity="0.3" d="M21.4 8.35303L19.241 10.511L13.485 4.755L15.643 2.59595C16.0248 2.21423 16.5426 1.99988 17.0825 1.99988C17.6224 1.99988 18.1402 2.21423 18.522 2.59595L21.4 5.474C21.7817 5.85581 21.9962 6.37355 21.9962 6.91345C21.9962 7.45335 21.7817 7.97122 21.4 8.35303ZM3.68699 21.932L9.88699 19.865L4.13099 14.109L2.06399 20.309C1.98815 20.5354 1.97703 20.7787 2.03189 21.0111C2.08674 21.2436 2.2054 21.4561 2.37449 21.6248C2.54359 21.7934 2.75641 21.9115 2.989 21.9658C3.22158 22.0201 3.4647 22.0084 3.69099 21.932H3.68699Z" fill="black" />
                                                                <path d="M5.574 21.3L3.692 21.928C3.46591 22.0032 3.22334 22.0141 2.99144 21.9594C2.75954 21.9046 2.54744 21.7864 2.3789 21.6179C2.21036 21.4495 2.09202 21.2375 2.03711 21.0056C1.9822 20.7737 1.99289 20.5312 2.06799 20.3051L2.696 18.422L5.574 21.3ZM4.13499 14.105L9.891 19.861L19.245 10.507L13.489 4.75098L4.13499 14.105Z" fill="black" />
                                                            </svg>
                                                        </span>
                                                       
                                                    </a>

                                                </td> -->
                                            </tr>
                                            @endforeach
                                            @else
                                            <tr>
                                                <td colspan="100%" class="text-center">No data available</td>
                                            </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            @endif
                           <!-- @endif -->
                            @endforeach

                        </div>
                    </div>
                </div>

                <div class="tab-pane fade show @if(session('success') || session('error')) active @endif" id="g_lead_email" role="tabpanel">
                    <div class="card">
                        <div class="card-body">

                            <!--begin::Body-->
                             <div class="card-body p-1">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <strong class="fs-3">Emails</strong>
                                    <a class="btn btn-success btn-sm" target="_blank" href="{{ route('send-email') }}">
                                        <i class="bi bi-plus-lg"></i>
                                        Send Email
                                    </a>
                                </div>
                                <div class="table-responsive">
                                    @if($emails->isNotEmpty())
                                    <table class="table table-sm table-condensed table-bordered table-row-gray-100 align-middle gs-0 gy-3">
                                        <thead>
                                        <tr class="fw-bolder text-muted bg-light bd-cyan">
                                            <th class="ps-4 rounded-start min-w-50px">SL</th>
                                            <th class="min-w-150px">To</th>
                                            <th class="min-w-150px">Lead</th>
                                            <th class="min-w-150px">Email Subject</th>
                                            <th class="min-w-140px">Time</th>
                                            <th class="rounded-end min-w-50px">Status</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @php
                                            $i=1;
                                        @endphp
                                        @foreach ($emails as $email)
                                        <tr>
                                            <td class="ps-5 text-dark fs-6">{{ $i }}</td>
                                            <td class="text-dark fs-6">{{ $email->email_to }}</td>
                                            <td class="text-dark fs-6">{{ $lead->first_name }} {{ $lead->last_name }}</td>
                                            <td class="text-dark fs-6">{{ $email->email_subject }}</td>
                                            <td class="text-dark fs-6">{{ Carbon::parse($email->log_time)->format('d-m-Y h:i A') }}</td>
                                            <td class="text-dark fs-6">
                                                @if ($email->send_status == config('constants.campaign_status')["Success"])
                                                    <span class="badge badge-light-success">Success</span>
                                                @elseif ($email->status == 0)
                                                    <span class="badge badge-light-danger">Fail</span>
                                                @endif
                                            </td>
                                        </tr>
                                        @php
                                            $i++;
                                        @endphp
                                        @endforeach

                                        </tbody>
                                    </table>
                                    @else
                                        <p>No results found.</p>
                                    @endif
                                </div>
                            </div>
                            <!--end::Body-->

                        </div>
                    </div>
                </div>

                <div class="tab-pane fade show @if(session('success') || session('error')) active @endif" id="g_lead_sms" role="tabpanel">
                    <div class="card">
                        <div class="card-body">

                            <!--begin::Body-->
                             <!-- <div class="card-body p-1"> -->
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <strong class="fs-3">SMS List</strong>
                                    <a class="btn btn-success btn-sm" target="_blank" href="{{ route('send-sms') }}">
                                        <i class="bi bi-plus-lg"></i>
                                        Send SMS
                                    </a>
                                </div>



                                <div class="table-responsive">
                                    @if($sms->isNotEmpty())
                                        <!--begin::Table-->
                                        <table
                                            class="table table-sm table-condensed table-row-gray-100 align-middle gs-0 gy-3 table-row-bordered">
                                            <!--begin::Table head-->
                                            <thead>
                                            <tr class="fw-bolder text-muted bg-light bd-cyan">
                                                <th class="ps-4">SL</th>
                                                <th class="min-w-150px">To</th>
                                                <th class="min-w-150px">Lead</th>
                                                <th class="min-w-150px">SMS Body</th>
                                                <th class="min-w-140px">Send Time</th>
                                                <th class=" min-w-120px">Status</th>
                                            </tr>
                                            </thead>
                                            <!--end::Table head-->
                                            <!--begin::Table body-->
                                            <tbody>
                                            @php
                                                $i=1;
                                            @endphp
                                            @foreach ($sms as $value)
                                                <tr>
                                                    <td class="ps-5 text-dark fs-6">{{ $i }}</td>
                                                    <td class="text-dark fs-6">{{ $value->sms_to }}</td>
                                                    <td class="text-dark fs-6">{{ $lead->first_name }} {{ $lead->last_name }}</td>
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
                                            @php
                                                $i++;
                                            @endphp
                                            @endforeach

                                            </tbody>
                                            <!--end::Table body-->
                                        </table>
                                    @else
                                        <p>No results found.</p>
                                    @endif
                                    <!--end::Table-->
                                </div>



                            <!-- </div> -->
                            <!--end::Body-->

                        </div>
                    </div>
                </div>

                <div class="tab-pane fade show @if(session('success') || session('error')) active @endif" id="g_lead_meeting" role="tabpanel">
                    <div class="card">
                        <div class="card-body">

                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <strong class="fs-3">Meetings</strong>
                                <a class="btn btn-success btn-sm" target="_blank" href="{{ route('meeting-create') }}">
                                    <i class="bi bi-plus-lg"></i>
                                    Meeting Request
                                </a>
                            </div>

                            <div class="table-responsive">
                                @if($meetings->isNotEmpty())
                                <!--begin::Table-->
                                <table class="table table-sm table-condensed table-row-gray-100 align-middle gs-0 gy-3 table-row-bordered">
                                    <!--begin::Table head-->
                                    <thead>
                                        <tr class="fw-bolder text-muted bg-light bd-cyan">
                                            <th class=" ps-4">SL</th>
                                            <!-- <th class="min-w-150px">Form ID</th> -->
                                            <th class="min-w-150px">Meeting Subject</th>
                                            <!-- <th class="min-w-150px">Promotion</th> -->
                                            <th class="min-w-140px">Meeting Date</th>
                                            <th class="min-w-140px">Duration</th>
                                            <th class="min-w-140px">Created By</th>
                                            <th class="min-w-120px">Status</th>
                                            <th class="min-w-120px">Rating</th>
                                            <th class="min-w-100px text-center text-center-new">Actions</th>
                                        </tr>
                                    </thead>
                                    <!--end::Table head-->
                                    <!--begin::Table body-->
                                    <tbody>
                                        @php
                                            $i=1;
                                        @endphp
                                        @foreach ($meetings as $meeting)
                                        <tr>
                                            <td class="ps-5 text-dark fs-6">{{ $i }}</td>
                                            <td class="text-dark fs-6 w-250px">{{$meeting->meeting_subject }}</td>
                                            <td class="text-dark fs-6">{{ \Carbon\Carbon::parse($meeting->meeting_date)->format('Y-m-d h:i A') }}</td>
                                            <td class="text-dark fs-6">{{$meeting->duration }}</td>
                                            <td class="text-dark fs-6">{{$meeting->user->username ?? 'N/A'}}</td>

                                            <td>
                                                @if ($meeting->status == 1)
                                                <span class="badge badge-light-success">Active</span>
                                                @elseif ($meeting->status == 0)
                                                <span class="badge badge-light-danger">Inactive</span>
                                                @endif
                                            </td>

                                            <td class="text-dark fs-6">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    @if($i <=$meeting->rating)
                                                    <i class="fa fa-star text-warning"></i> <!-- Yellow star for ratings -->
                                                    @else
                                                    <i class="fa fa-star text-muted"></i> <!-- Grey star for remaining -->
                                                    @endif
                                                    @endfor
                                            </td>



                                            <td>
                                                <div class="d-inline-flex justify-content-end gap-1 w-100 border-bottom-0">
                                                    <a href="#" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#add_feedback_modal"
                                                        data-id="{{ $meeting->id }}"> <!-- Pass meeting ID here -->
                                                        <!-- Svg Icon -->
                                                        <span class="svg-icon svg-icon-3">
                                                            <svg fill="#000000" width="800px" height="800px" viewBox="0 0 1920 1920" xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M84 0v1423.143h437.875V1920l621.235-496.857h692.39V0H84Zm109.469 109.464H1726.03V1313.57h-621.235l-473.452 378.746V1313.57H193.469V109.464Z" fill-rule="evenodd" />
                                                            </svg>
                                                        </span>
                                                    </a>

                                                    <a target="_blank" href="{{ route('meeting-show', $meeting->id) }}" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                                                        <!--begin::Svg Icon | path: icons/duotune/general/gen019.svg-->
                                                        <span class="svg-icon svg-icon-3">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24">
                                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                                    <rect x="0" y="0" width="24" height="24" />
                                                                    <path d="M3,12 C3,12 5.45454545,6 12,6 C16.9090909,6 21,12 21,12 C21,12 16.9090909,18 12,18 C5.45454545,18 3,12 3,12 Z" fill="black" fill-rule="nonzero" opacity="0.7" />
                                                                    <path d="M12,15 C10.3431458,15 9,13.6568542 9,12 C9,10.3431458 10.3431458,9 12,9 C13.6568542,9 15,10.3431458 15,12 C15,13.6568542 13.6568542,15 12,15 Z" fill="black" opacity="0.7" />
                                                                </g>
                                                            </svg>
                                                        </span>
                                                        <!--end::Svg Icon-->
                                                    </a>
                                                    <a target="_blank" href="{{ route('meeting-edit', $meeting->id) }}" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                                                        <!--begin::Svg Icon | path: icons/duotune/art/art005.svg-->
                                                        <span class="svg-icon svg-icon-3">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                                <path opacity="0.3" d="M21.4 8.35303L19.241 10.511L13.485 4.755L15.643 2.59595C16.0248 2.21423 16.5426 1.99988 17.0825 1.99988C17.6224 1.99988 18.1402 2.21423 18.522 2.59595L21.4 5.474C21.7817 5.85581 21.9962 6.37355 21.9962 6.91345C21.9962 7.45335 21.7817 7.97122 21.4 8.35303ZM3.68699 21.932L9.88699 19.865L4.13099 14.109L2.06399 20.309C1.98815 20.5354 1.97703 20.7787 2.03189 21.0111C2.08674 21.2436 2.2054 21.4561 2.37449 21.6248C2.54359 21.7934 2.75641 21.9115 2.989 21.9658C3.22158 22.0201 3.4647 22.0084 3.69099 21.932H3.68699Z" fill="black" />
                                                                <path d="M5.574 21.3L3.692 21.928C3.46591 22.0032 3.22334 22.0141 2.99144 21.9594C2.75954 21.9046 2.54744 21.7864 2.3789 21.6179C2.21036 21.4495 2.09202 21.2375 2.03711 21.0056C1.9822 20.7737 1.99289 20.5312 2.06799 20.3051L2.696 18.422L5.574 21.3ZM4.13499 14.105L9.891 19.861L19.245 10.507L13.489 4.75098L4.13499 14.105Z" fill="black" />
                                                            </svg>
                                                        </span>
                                                        <!--end::Svg Icon-->
                                                    </a>
                                                    {{--
                                                    <form action="{{ route('meeting-destroy', $meeting->id) }}" method="POST" style="display: inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm" onclick="return confirmDelete()">
                                                            <!--begin::Svg Icon | path: icons/duotune/general/gen027.svg-->
                                                            <span class="svg-icon svg-icon-3">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                                    <path d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z" fill="black" />
                                                                    <path opacity="0.5" d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z" fill="black" />
                                                                    <path opacity="0.5" d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z" fill="black" />
                                                                </svg>
                                                            </span>
                                                            <!--end::Svg Icon-->
                                                        </button>
                                                    </form>
                                                    --}}
                                                </div>
                                            </td>
                                        </tr>
                                        @php
                                            $i++;
                                        @endphp
                                        @endforeach

                                    </tbody>
                                    <!--end::Table body-->
                                </table>
                                @else
                                <p>No results found.</p>
                                @endif
                                <!--end::Table-->
                            </div>

                        </div>
                    </div>
                </div>

                <div class="tab-pane fade show @if(session('success') || session('error')) active @endif" id="g_lead_proposals" role="tabpanel">
                    <div class="card">
                        <div class="card-body">

                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <strong class="fs-3">Proposals</strong>
                                <a class="btn btn-success btn-sm" target="_blank" href="{{ route('add-proposal') }}">
                                    <i class="bi bi-plus-lg"></i>
                                    Send Proposal
                                </a>
                            </div>

                            <div class="table-responsive">
                                @if ($proposals->isNotEmpty())
                                    <!--begin::Table-->

                                    <table class="table table-sm table-condensed table-row-gray-100 align-middle gs-0 gy-3 table-row-bordered">
                                        <!--begin::Table head-->
                                        <thead>
                                            <tr class="fw-bolder text-muted bg-light bd-cyan">
                                                <th class="ps-4 min-w-120px">SL</th>
                                                <th class="min-w-120px">Lead</th>
                                                <th class="min-w-150px">Subject</th>
                                                <th class="min-w-150px">Company</th>
                                                <th class="min-w-120px">Email</th>
                                                <!-- <th class="min-w-120px">Date</th> -->
                                                <!-- <th class="min-w-120px">Open Till</th> -->
                                                <th class="min-w-120px">Price</th>
                                                <th class="min-w-120px">Offer Price</th>
                                                <!-- <th class="min-w-120px">Offer Price with Tax</th> -->
                                                <!-- <th class="min-w-120px">Created At</th> -->
                                                <th class="min-w-120px">Status</th>
                                                <th class="min-w-100px text-end-new">Actions</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @php
                                                $i=1;
                                            @endphp
                                            @foreach ($proposals as $proposal)
                                                <tr>
                                                    <td class="ps-5 text-dark fs-6">{{ $i }}</td>
                                                    <td class="text-dark fs-6">{{ $lead->first_name }} {{ $lead->last_name }}</td>
                                                    <td class="text-dark fs-6">{{ $proposal->subject }}</td>
                                                    <td class="text-dark fs-6">{{ $proposal->company_name }}</td>
                                                    <td class="text-dark fs-6">{{ $proposal->send_to }}</td>
                                                    <td class="text-dark fs-6">{{ $proposal->price }}</td>
                                                    <td class="text-dark fs-6">{{ $proposal->offer_price }}</td>
                                                    <td class="text-dark fs-6">{{ $proposal->status }}</td>

                                                    <td>
                                                        <div class="d-inline-flex justify-content-end gap-1 w-100 border-bottom-0">

                                                            <a target="_blank" href="{{ route('proposal-show', $proposal->id) }}" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                                                            <span class="svg-icon svg-icon-3">
                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                     width="24px" height="24px" viewBox="0 0 24 24">
                                                                        <g stroke="none" stroke-width="1"
                                                                           fill="none" fill-rule="evenodd">
                                                                            <rect x="0" y="0" width="24"
                                                                                  height="24"/>
                                                                            <path
                                                                                d="M3,12 C3,12 5.45454545,6 12,6 C16.9090909,6 21,12 21,12 C21,12 16.9090909,18 12,18 C5.45454545,18 3,12 3,12 Z"
                                                                                fill="black" fill-rule="nonzero"
                                                                                opacity="0.7"/>
                                                                            <path
                                                                                d="M12,15 C10.3431458,15 9,13.6568542 9,12 C9,10.3431458 10.3431458,9 12,9 C13.6568542,9 15,10.3431458 15,12 C15,13.6568542 13.6568542,15 12,15 Z"
                                                                                fill="black" opacity="0.7"/>
                                                                        </g>
                                                                    </svg>
                                                             </span>
                                                        </a>
                                                        <a target="_blank" href="{{ route('proposal-edit', $proposal->id) }}"
                                                           class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                                                            <span class="svg-icon svg-icon-3">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                     height="24" viewBox="0 0 24 24" fill="none">
                                                                    <path opacity="0.3"
                                                                          d="M21.4 8.35303L19.241 10.511L13.485 4.755L15.643 2.59595C16.0248 2.21423 16.5426 1.99988 17.0825 1.99988C17.6224 1.99988 18.1402 2.21423 18.522 2.59595L21.4 5.474C21.7817 5.85581 21.9962 6.37355 21.9962 6.91345C21.9962 7.45335 21.7817 7.97122 21.4 8.35303ZM3.68699 21.932L9.88699 19.865L4.13099 14.109L2.06399 20.309C1.98815 20.5354 1.97703 20.7787 2.03189 21.0111C2.08674 21.2436 2.2054 21.4561 2.37449 21.6248C2.54359 21.7934 2.75641 21.9115 2.989 21.9658C3.22158 22.0201 3.4647 22.0084 3.69099 21.932H3.68699Z"
                                                                          fill="black"/>
                                                                    <path
                                                                        d="M5.574 21.3L3.692 21.928C3.46591 22.0032 3.22334 22.0141 2.99144 21.9594C2.75954 21.9046 2.54744 21.7864 2.3789 21.6179C2.21036 21.4495 2.09202 21.2375 2.03711 21.0056C1.9822 20.7737 1.99289 20.5312 2.06799 20.3051L2.696 18.422L5.574 21.3ZM4.13499 14.105L9.891 19.861L19.245 10.507L13.489 4.75098L4.13499 14.105Z"
                                                                        fill="black"/>
                                                                </svg>
                                                            </span>
                                                        </a>

                                                        {{--
                                                        <form action="{{ route('delete-proposal', $proposal->id) }}" method="POST" style="display: inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm"  onclick="return confirmDelete()">
                                                            <span class="svg-icon svg-icon-3">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                    height="24" viewBox="0 0 24 24" fill="none">
                                                                    <path
                                                                        d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z"
                                                                        fill="black" />
                                                                    <path opacity="0.5"
                                                                        d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z"
                                                                        fill="black" />
                                                                    <path opacity="0.5"
                                                                        d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z"
                                                                        fill="black" />
                                                                </svg>
                                                            </span>
                                                            </button>

                                                        </form>
                                                        --}}
                                                        <div>
                                                    </td>
                                                </tr>
                                            @php
                                                $i++;
                                            @endphp
                                            @endforeach

                                        </tbody>
                                        <!--end::Table body-->
                                    </table>
                                @else
                                    <p>No results found.</p>
                                @endif
                                <!--end::Table-->
                            </div>

                        </div>
                    </div>
                </div>

                <div class="tab-pane fade show @if(session('success') || session('error')) active @endif" id="g_lead_products" role="tabpanel">
                    <div class="card">
                        <div class="card-body">

                            Product Section

                        </div>
                    </div>
                </div>

                <div class="tab-pane fade show @if(session('success') || session('error')) active @endif" id="g_lead_invoice" role="tabpanel">
                    <div class="card">
                        <div class="card-body">

                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <strong class="fs-3">Invoices</strong>
                                <a class="btn btn-success btn-sm" target="_blank" href="{{ route('invoice-create') }}">
                                    <i class="bi bi-plus-lg"></i>
                                    Create Invoice
                                </a>
                            </div>

                            <div class="table-responsive">
                                @if($invoices->isNotEmpty())
                                <!--begin::Table-->
                                <table
                                    class="table table-sm table-condensed table-row-gray-100 align-middle gs-0 gy-3 table-row-bordered">
                                    <!--begin::Table head-->
                                    <thead>
                                        <tr class="fw-bolder text-muted bg-light bd-cyan">
                                            <th class="ps-4 min-w-50px">SL</th>
                                            <th class="min-w-150px">Invoice No</th>
                                            <th class="min-w-140px">Amount</th>
                                            <th class="min-w-140px">Total Tax</th>
                                            <th class="min-w-140px">Discount</th>
                                            <th class="min-w-140px">Date</th>
                                            <th class="min-w-120px">Customer</th>
                                            <th class="min-w-120px">Due Date</th>
                                            <th class="min-w-120px">Status</th>
                                            <th class="min-w-140px text-center">Payment</th>
                                            <th class="min-w-140px text-center">Due</th>
                                            <th class="min-w-100px text-end text-end-new">Actions</th>
                                        </tr>
                                    </thead>
                                    <!--end::Table head-->
                                    <!--begin::Table body-->
                                    <tbody>
                                        @php
                                        $i=1;
                                        @endphp
                                        @foreach ($invoices as $invoice)

                                        <tr>

                                            <td class="ps-5 text-dark fs-6">{{ $i }}</td>
                                            <td class="text-dark fs-6">{{$invoice->invoice_number}}</td>
                                            <td class="text-dark fs-6 w-100px">{{$invoice->total_amount}}</td>
                                            <td class="text-dark fs-6 w-200px">{{$invoice->total_tax }}</td>
                                            <td class="text-dark fs-6 w-200px">{{ $invoice->discount ?? '0.00' }}</td>
                                            <td class="text-dark fs-6 w-200px">
                                                @if($invoice->invoice_date)
                                                {{ \Carbon\Carbon::parse($invoice->invoice_date)->format('d-m-Y') }}
                                                @endif
                                            </td>
                                            <td class="text-dark fs-6 w-200px">{{$invoice->first_name}} {{$invoice->last_name}}</td>
                                            <td class="text-dark fs-6 w-200px">
                                                @if($invoice->due_date)
                                                {{ \Carbon\Carbon::parse($invoice->due_date)->format('d-m-Y') }}
                                                @endif
                                            </td>


                                            <td>

                                                <span class="badge badge-light-success">{{$invoice->invoice_status}}</span>

                                            </td>

                                            <!-- Display Payment and Due from payment_details -->
                                            @php
                                            //payment_details to a collection and calculate total payments
                                            $paymentDetails = collect($invoice->payment_details);
                                            $totalPayments = $paymentDetails->sum('payment');
                                            //last entry
                                            $lastPayment = $paymentDetails->last();
                                            $paymentAmount = $lastPayment['payment'] ?? '0.00';
                                            $dueAmount = $lastPayment['due'] ?? $invoice->total_amount;
                                            @endphp

                                            <td class="text-dark fs-6 w-200px text-center">{{ $totalPayments}}</td>
                                            <td class="text-dark fs-6 w-200px text-center">{{ $dueAmount }}</td>
                                            <td>
                                                <div
                                                    class="d-inline-flex justify-content-end gap-1 w-100 border-bottom-0">
                                                    <a href="{{ route('invoice-show', $invoice->id) }}" target="_blank" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                                                        <!--begin::Svg Icon | path: icons/duotune/general/gen019.svg-->
                                                        <span class="svg-icon svg-icon-3">
                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                width="24px" height="24px" viewBox="0 0 24 24">
                                                                <g stroke="none" stroke-width="1"
                                                                    fill="none" fill-rule="evenodd">
                                                                    <rect x="0" y="0" width="24"
                                                                        height="24" />
                                                                    <path d="M3,12 C3,12 5.45454545,6 12,6 C16.9090909,6 21,12 21,12 C21,12 16.9090909,18 12,18 C5.45454545,18 3,12 3,12 Z" fill="black" fill-rule="nonzero"
                                                                        opacity="0.7" />
                                                                    <path d="M12,15 C10.3431458,15 9,13.6568542 9,12 C9,10.3431458 10.3431458,9 12,9 C13.6568542,9 15,10.3431458 15,12 C15,13.6568542 13.6568542,15 12,15 Z" fill="black" opacity="0.7" />
                                                                </g>
                                                            </svg>
                                                        </span>
                                                        <!--end::Svg Icon-->
                                                    </a>
                                                    <a target="_blank" href="{{ route('invoice-edit', $invoice->id) }}"
                                                        class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                                                        <!--begin::Svg Icon | path: icons/duotune/art/art005.svg-->
                                                        <span class="svg-icon svg-icon-3">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                height="24" viewBox="0 0 24 24" fill="none">
                                                                <path opacity="0.3"
                                                                    d="M21.4 8.35303L19.241 10.511L13.485 4.755L15.643 2.59595C16.0248 2.21423 16.5426 1.99988 17.0825 1.99988C17.6224 1.99988 18.1402 2.21423 18.522 2.59595L21.4 5.474C21.7817 5.85581 21.9962 6.37355 21.9962 6.91345C21.9962 7.45335 21.7817 7.97122 21.4 8.35303ZM3.68699 21.932L9.88699 19.865L4.13099 14.109L2.06399 20.309C1.98815 20.5354 1.97703 20.7787 2.03189 21.0111C2.08674 21.2436 2.2054 21.4561 2.37449 21.6248C2.54359 21.7934 2.75641 21.9115 2.989 21.9658C3.22158 22.0201 3.4647 22.0084 3.69099 21.932H3.68699Z"
                                                                    fill="black" />
                                                                <path
                                                                    d="M5.574 21.3L3.692 21.928C3.46591 22.0032 3.22334 22.0141 2.99144 21.9594C2.75954 21.9046 2.54744 21.7864 2.3789 21.6179C2.21036 21.4495 2.09202 21.2375 2.03711 21.0056C1.9822 20.7737 1.99289 20.5312 2.06799 20.3051L2.696 18.422L5.574 21.3ZM4.13499 14.105L9.891 19.861L19.245 10.507L13.489 4.75098L4.13499 14.105Z"
                                                                    fill="black" />
                                                            </svg>
                                                        </span>
                                                        <!--end::Svg Icon-->
                                                    </a>

                                                    {{--
                                                    <form action="{{ route('invoice-destroy', $invoice->id) }}"
                                                        method="POST" style="display: inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm"
                                                            onclick="return confirmDelete()">
                                                            <!--begin::Svg Icon | path: icons/duotune/general/gen027.svg-->
                                                            <span class="svg-icon svg-icon-3">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                                    viewBox="0 0 24 24" fill="none">
                                                                    <path
                                                                        d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z"
                                                                        fill="black" />
                                                                    <path opacity="0.5"
                                                                        d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z"
                                                                        fill="black" />
                                                                    <path opacity="0.5"
                                                                        d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z"
                                                                        fill="black" />
                                                                </svg>
                                                            </span>
                                                            <!--end::Svg Icon-->
                                                        </button>
                                                    </form>
                                                    --}}

                                                </div>
                                            </td>
                                        </tr>
                                        @php
                                        $i++;
                                        @endphp
                                        @endforeach

                                    </tbody>
                                    <!--end::Table body-->
                                </table>
                                @else
                                <p>No results found.</p>
                                @endif
                                <!--end::Table-->
                            </div>

                        </div>
                    </div>
                </div>

                <div class="tab-pane fade show @if(session('success') || session('error')) active @endif" id="g_lead_tickets" role="tabpanel">
                    <div class="card">
                        <div class="card-body">

                            Ticket Section
                            <button class="btn btn-primary" id="createTicketButton">Create Ticket</button>
                            <div id="ticketIframeContainer" style="margin-top: 20px; display: none;">
                                <iframe 
                                    id="ticketIframe" 
                                    src="" 
                                    style="width: 100%; height: 600px; border: none;" 
                                    title="Create Ticket">
                                </iframe>
                            </div>
                            <table id="ticketTable" class="table table-sm table-condensed table-bordered table-row-gray-100 align-middle gs-0 gy-3">
                                <!--begin::Table head-->
                                <thead>
                                <tr class="fw-bolder text-muted bg-light bd-cyan">
                                    <th class="min-w-150px">Ticket ID</th>
                                    <th class="min-w-150px"> Title</th>
                                    <th class="min-w-150px"> Group</th>
                                    <th class="min-w-150px"> Status</th>

                                </tr>
                                </thead>
                               
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade show @if(session('success') || session('error')) active @endif" id="g_lead_activity_log" role="tabpanel">
                    <div class="card">
                        <div class="card-body">

                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <strong class="fs-3">Log History</strong>
                            </div>

                            <div class="table-responsive">
                                @if (isset($logs) && $logs->isNotEmpty())
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
                                        @php
                                            $i=1;
                                        @endphp
                                        @foreach ($logs as $log)
                                        <tr>
                                            <td class="ps-5 text-dark fs-6">{{ $i }}</td>
                                            <td class="text-dark fs-6">{{ $log->module }}</td>
                                            <td class="text-dark fs-6">{{ $log->sub_module }}</td>
                                            <td class="text-dark fs-6">{{ $log->log_message }}</td>
                                            <td class="text-dark fs-6">{{ $lead->first_name }} {{ $lead->last_name }}</td>
                                            <td class="text-dark fs-6">{{ $log->first_name }} {{ $log->last_name }}</td>
                                            <td>
                                                {{ Carbon::parse($log->created_at)->format('d-m-Y h:i:s A') }}
                                            </td>
                                        </tr>
                                        @php
                                            $i++;
                                        @endphp
                                        @endforeach

                                        </tbody>
                                        <!--end::Table body-->
                                    </table>
                                    @else
                                        <p>No results found.</p>
                                    @endif
                                    <!--end::Table-->
                            </div>

                        </div>
                    </div>
                </div>


            </div>
            {{--End Tab Content--}}


        </div>
    </div>
</div>

<!-- End Tables View-->


<!-- </div> -->
<!--end::Content-->

@endsection

@section('endScript')
<script>
    var phone_no = @json($lead->phone); 
    function getTickets(phone_no) {
        const ticketListUrl = "http://192.168.11.220/ticket_crm/ticket_crm_api.php?TYPE=TICKET_LIST_BY_MOBILE&CLI="+phone_no;

        fetch(ticketListUrl)
            .then(response => response.json())
            .then(data => {
                console.log('data', data)
                populateTable(data);
            })
            .catch(error => {
                console.error('Error fetching iframe data:', error);
                alert('Failed to load the ticket creation form. Please try again.');
            });
    }

    function populateTable(data) {
        const tableBody = document.getElementById('ticketTable').getElementsByTagName('tbody')[0];

        tableBody.innerHTML = '';

        data.forEach(ticket => {
            const row = document.createElement('tr');

            row.innerHTML = `
                <td>${ticket.ticket_id || 'N/A'}</td>
                <td>${ticket.subject || 'N/A'}</td>
                <td>${ticket.group_name || 'N/A'}</td>
                <td>${ticket.status_name || 'N/A'}</td>
                `;

            tableBody.appendChild(row);
        });
    }

    let tickets = getTickets(phone_no);

    document.getElementById('createTicketButton').addEventListener('click', function() {
        const ticketUrl = "http://192.168.11.220/ticket_crm/ticket_crm_api.php?TYPE=TICKET_CREATE&CLI="+phone_no;

        fetch(ticketUrl)
            .then(response => response.json())
            .then(data => {
                const iframeHtml = data[0].iframe;
                const iframeContainer = document.getElementById('ticketIframeContainer');
                iframeContainer.innerHTML = iframeHtml;
                iframeContainer.style.display = 'block';
            })
            .catch(error => {
                console.error('Error fetching iframe data:', error);
                alert('Failed to load the ticket creation form. Please try again.');
            });
    });
</script>
@endsection
