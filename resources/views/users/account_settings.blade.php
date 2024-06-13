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
                            <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">User List
                                <!--begin::Separator-->
                                <span class="h-20px border-gray-200 ms-3 mx-2" style="border-left:1px solid #000!important"></span>
                                <!--end::Separator-->
                                <!--begin::Description-->
                                <small class="text-muted fs-7 fw-bold my-1 ms-1">Show all users</small>
                                <!--end::Description--></h1>
                            <!--end::Title-->
                        </div>
                        <!--end::Page title-->
                        <!--begin::Actions-->
                        <div class="d-flex align-items-center py-1">
                            <!--begin::Button-->
                            <a href="{{ route('create-user') }}" class="btn btn-sm btn-primary" id="kt_toolbar_primary_button">Create</a>

                            <!--end::Button-->
                        </div>
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
<div class="text-center">
	<div class="row">
		<div class="col-md-5 mx-auto">
		   @if (session('success'))
		    <div class="alert alert-success alert-dismissible fade show" role="alert">
				<strong>{{ session('success') }}</strong>
				<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
			</div>
			@endif
			@if (session('error'))
			<div class="alert alert-danger alert-dismissible fade show" role="alert">
				<strong> {{ session('error') }}</strong>
				<button type="button" class="btn-close" data-bs-dismiss="alert"
						aria-label="Close"></button>
			</div>
			@endif

			
		</div>
	</div>
</div>

<!--End Table Alert Message-->


<div class="row">
	<div class="col-xxl-12">
	<div class="card mb-5 mb-xl-10">
									<!--begin::Card header-->
									<div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse" data-bs-target="#kt_account_profile_details" aria-expanded="true" aria-controls="kt_account_profile_details">
										<!--begin::Card title-->
										<div class="card-title m-0">
											<h3 class="fw-bolder m-0">Profile Details</h3>
										</div>
										<!--end::Card title-->
									</div>
									<!--begin::Card header-->
									<!--begin::Content-->
									<div id="kt_account_profile_details" class="collapse show">
										<!--begin::Form-->
										<form id="kt_account_profile_details_form" class="form">
											<!--begin::Card body-->
											<div class="card-body border-top p-9">
												<!--begin::Input group-->
												<div class="row mb-6">
													<!--begin::Label-->
													<label class="col-lg-4 col-form-label fw-bold fs-6">Avatar</label>
													<!--end::Label-->
													<!--begin::Col-->
													<div class="col-lg-8">
														<!--begin::Image input-->
														<div class="image-input image-input-outline" data-kt-image-input="true" style="background-image: url(assets/media/avatars/blank.png)">
															<!--begin::Preview existing avatar-->
															<div class="image-input-wrapper w-125px h-125px" style="background-image: url(assets/media/avatars/150-26.jpg)"></div>
															<!--end::Preview existing avatar-->
															<!--begin::Label-->
															<label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Change avatar">
																<i class="bi bi-pencil-fill fs-7"></i>
																<!--begin::Inputs-->
																<input type="file" name="avatar" accept=".png, .jpg, .jpeg" />
																<input type="hidden" name="avatar_remove" />
																<!--end::Inputs-->
															</label>
															<!--end::Label-->
															<!--begin::Cancel-->
															<span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="Cancel avatar">
																<i class="bi bi-x fs-2"></i>
															</span>
															<!--end::Cancel-->
															<!--begin::Remove-->
															<span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="Remove avatar">
																<i class="bi bi-x fs-2"></i>
															</span>
															<!--end::Remove-->
														</div>
														<!--end::Image input-->
														<!--begin::Hint-->
														<div class="form-text">Allowed file types: png, jpg, jpeg.</div>
														<!--end::Hint-->
													</div>
													<!--end::Col-->
												</div>
												<!--end::Input group-->
												<!--begin::Input group-->
												<div class="row mb-6">
													<!--begin::Label-->
													<label class="col-lg-4 col-form-label required fw-bold fs-6">Full Name</label>
													<!--end::Label-->
													<!--begin::Col-->
													<div class="col-lg-8">
														<!--begin::Row-->
														<div class="row">
															<!--begin::Col-->
															<div class="col-lg-6 fv-row">
																<input type="text" name="fname" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" placeholder="First name" value="Max" />
															</div>
															<!--end::Col-->
															<!--begin::Col-->
															<div class="col-lg-6 fv-row">
																<input type="text" name="lname" class="form-control form-control-lg form-control-solid" placeholder="Last name" value="Smith" />
															</div>
															<!--end::Col-->
														</div>
														<!--end::Row-->
													</div>
													<!--end::Col-->
												</div>
												<!--end::Input group-->
												<!--begin::Input group-->
												<div class="row mb-6">
													<!--begin::Label-->
													<label class="col-lg-4 col-form-label required fw-bold fs-6">Company</label>
													<!--end::Label-->
													<!--begin::Col-->
													<div class="col-lg-8 fv-row">
														<input type="text" name="company" class="form-control form-control-lg form-control-solid" placeholder="Company name" value="Keenthemes" />
													</div>
													<!--end::Col-->
												</div>
												<!--end::Input group-->
												<!--begin::Input group-->
												<div class="row mb-6">
													<!--begin::Label-->
													<label class="col-lg-4 col-form-label fw-bold fs-6">
														<span class="required">Contact Phone</span>
														<i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Phone number must be active"></i>
													</label>
													<!--end::Label-->
													<!--begin::Col-->
													<div class="col-lg-8 fv-row">
														<input type="tel" name="phone" class="form-control form-control-lg form-control-solid" placeholder="Phone number" value="044 3276 454 935" />
													</div>
													<!--end::Col-->
												</div>
												<!--end::Input group-->
												<!--begin::Input group-->
												<div class="row mb-6">
													<!--begin::Label-->
													<label class="col-lg-4 col-form-label fw-bold fs-6">Company Site</label>
													<!--end::Label-->
													<!--begin::Col-->
													<div class="col-lg-8 fv-row">
														<input type="text" name="website" class="form-control form-control-lg form-control-solid" placeholder="Company website" value="keenthemes.com" />
													</div>
													<!--end::Col-->
												</div>
												<!--end::Input group-->
												<!--begin::Input group-->
												<div class="row mb-6">
													<!--begin::Label-->
													<label class="col-lg-4 col-form-label fw-bold fs-6">
														<span class="required">Country</span>
														<i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Country of origination"></i>
													</label>
													<!--end::Label-->
													<!--begin::Col-->
													<div class="col-lg-8 fv-row">
														<select name="country" aria-label="Select a Country" data-control="select2" data-placeholder="Select a country..." class="form-select form-select-solid form-select-lg fw-bold">
															<option value="">Select a Country...</option>
															
														</select>
													</div>
													<!--end::Col-->
												</div>
												<!--end::Input group-->
												<!--begin::Input group-->
												<div class="row mb-6">
													<!--begin::Label-->
													<label class="col-lg-4 col-form-label required fw-bold fs-6">Language</label>
													<!--end::Label-->
													<!--begin::Col-->
													<div class="col-lg-8 fv-row">
														<!--begin::Input-->
														<select name="language" aria-label="Select a Language" data-control="select2" data-placeholder="Select a language..." class="form-select form-select-solid form-select-lg">
															<option value="">Select a Language...</option>
														
														</select>
														<!--end::Input-->
														<!--begin::Hint-->
														<div class="form-text">Please select a preferred language, including date, time, and number formatting.</div>
														<!--end::Hint-->
													</div>
													<!--end::Col-->
												</div>
												<!--end::Input group-->
												<!--begin::Input group-->
												<div class="row mb-6">
													<!--begin::Label-->
													<label class="col-lg-4 col-form-label required fw-bold fs-6">Time Zone</label>
													<!--end::Label-->
													<!--begin::Col-->
													<div class="col-lg-8 fv-row">
														<select name="timezone" aria-label="Select a Timezone" data-control="select2" data-placeholder="Select a timezone.." class="form-select form-select-solid form-select-lg">
															<option value="">Select a Timezone..</option>
															
														</select>
													</div>
													<!--end::Col-->
												</div>
												<!--end::Input group-->
												<!--begin::Input group-->
												<div class="row mb-6">
													<!--begin::Label-->
													<label class="col-lg-4 col-form-label fw-bold fs-6">Currency</label>
													<!--end::Label-->
													<!--begin::Col-->
													<div class="col-lg-8 fv-row">
														<select name="currnecy" aria-label="Select a Timezone" data-control="select2" data-placeholder="Select a currency.." class="form-select form-select-solid form-select-lg">
															<option value="">Select a currency..</option>
															
														</select>
													</div>
													<!--end::Col-->
												</div>
												<!--end::Input group-->



                                                <div class="row mb-6">
                                                    <!--begin::Label-->
                                                    <label class="col-lg-4 col-form-label fw-bold fs-6">Update Password</label>
                                                    <!--end::Label-->

                                                    <div class="col-lg-8 fv-row">
                                                        <!--begin::Edit-->
                                                        <div  class="flex-row-fluid">
                                                            <!--begin::Form-->
                                                            <form  class="form" novalidate="novalidate">
                                                                <div class="row mb-1">
                                                                    <div class="col-lg-4">
                                                                        <div class="fv-row mb-0">
<!--                                                                            <label for="currentspassword" class="form-label fs-6 fw-bolder mb-3">Current Password</label>-->
                                                                            <input type="password" class="form-control form-control-lg form-control-solid" name="currentspassword" id="currentspassword" placeholder="current password" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-4">
                                                                        <div class="fv-row mb-0">
<!--                                                                            <label for="newspassword" class="form-label fs-6 fw-bolder mb-3">New Password</label>-->
                                                                            <input type="password" class="form-control form-control-lg form-control-solid" name="newspassword" id="newspassword" placeholder="new password"/>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-4">
                                                                        <div class="fv-row mb-0">
<!--                                                                            <label for="confirmspassword" class="form-label fs-6 fw-bolder mb-3">Confirm New Password</label>-->
                                                                            <input type="password" class="form-control form-control-lg form-control-solid" name="confirmspassword" id="confirmspassword"  placeholder="confirm new password"/>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </form>
                                                            <!--end::Form-->
                                                        </div>
                                                        <!--end::Edit-->
                                                    </div>
                                                </div>






												<!--begin::Input group-->
												
												<!--end::Input group-->
												<!--begin::Input group-->
												
												<!--end::Input group-->
											</div>
											<!--end::Card body-->
											<!--begin::Actions-->
											<div class="card-footer d-flex justify-content-end py-6 px-9">
												<button type="reset" class="btn btn-light btn-active-light-primary me-2">Discard</button>
												<button type="submit" class="btn btn-primary" id="kt_account_profile_details_submit">Update Changes</button>
											</div>
											<!--end::Actions-->
										</form>
										<!--end::Form-->
									</div>
									<!--end::Content-->
								</div>

		

	</div>
</div>
</div>

<script>
    function confirmDelete() {
        if (confirm("Are you sure you want to delete user?")) {
            document.getElementById('deleteForm').submit();
        }
        return false;
    }
</script>

<!-- End Tables-->

@endsection