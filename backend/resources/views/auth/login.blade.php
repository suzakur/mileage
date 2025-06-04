@extends('layouts.master')

@section('app')
<div class="d-flex flex-column flex-root" id="kt_app_root">
	<!--begin::Page bg image-->
	<style>body { background-image: url('assets/media/auth/bg4.jpg'); } [data-bs-theme="dark"] body { background-image: url('assets/media/auth/bg4-dark.jpg'); }</style>
	<!--end::Page bg image-->
	<!--begin::Authentication - Sign-in -->
	<div class="d-flex flex-column flex-column-fluid flex-lg-row">
		<!--begin::Aside-->
		<div class="d-flex flex-center w-lg-50 pt-15 pt-lg-0 px-10">
			<!--begin::Aside-->
			<div class="d-flex flex-center flex-lg-start flex-column">
				<!--begin::Logo-->
				<a href="index.html" class="mb-7">
					<img alt="Logo" src="{{asset('assets/media/logos/custom-3.svg')}}" />
				</a>
				<!--end::Logo-->
				<!--begin::Title-->
				<h2 class="text-white fw-normal m-0">Branding tools designed for your business</h2>
				<!--end::Title-->
			</div>
			<!--begin::Aside-->
		</div>
		<!--begin::Aside-->
		<!--begin::Body-->
		<div class="d-flex flex-column-fluid flex-lg-row-auto justify-content-center justify-content-lg-end p-12 p-lg-20">
			<!--begin::Card-->
			<div class="bg-body d-flex flex-column align-items-stretch flex-center rounded-4 w-md-600px p-20">
				<!--begin::Wrapper-->
				<div class="d-flex flex-center flex-column flex-column-fluid px-lg-10 pb-15 pb-lg-20">
					 <!--begin::Form-->
		            <form class="form w-100" novalidate="novalidate" id="kt_sign_in_form" data-kt-redirect-url="dashboard" method="POST" action="{{route('login')}}">
		            	@csrf
		                <!--begin::Heading-->
		                <div class="text-center mb-11">
		                    <!--begin::Title-->
		                    <h1 class="text-dark fw-bolder mb-3">Sign In</h1>
		                    <!--end::Title-->
		                </div>
		                <!--begin::Heading-->
		                <!--begin::Login options-->
		                <div class="row g-3 mb-9">
		                    <!--begin::Col-->
		                    <div class="col-md-12">
		                        <!--begin::Google link=-->
		                        <a href="{{ route('google.redirect') }}" class="btn btn-flex btn-outline btn-text-gray-700 btn-active-color-primary bg-state-light flex-center text-nowrap w-100">
		                        <img alt="Logo" src="{{asset('assets/media/svg/brand-logos/google-icon.svg')}}" class="h-15px me-3" />Sign in with Google</a>
		                        <!--end::Google link=-->
		                    </div>
		                    <!--end::Col-->
		                </div>
		                <!--end::Login options-->
		                <!--begin::Separator-->
		                <div class="separator separator-content my-14">
		                    <span class="w-125px text-gray-500 fw-semibold fs-7">Or with email</span>
		                </div>
		                <!--end::Separator-->
		                <!--begin::Input group=-->
		                <div class="fv-row mb-8">
		                    <!--begin::Email-->
		                    <input type="text" placeholder="Email" name="email" autocomplete="off" class="form-control bg-transparent" />
		                    <!--end::Email-->
		                </div>
		                <!--end::Input group=-->
		                <div class="fv-row mb-3">
		                    <!--begin::Password-->
		                    <input type="password" placeholder="Password" name="password" autocomplete="off" class="form-control bg-transparent" />
		                    <!--end::Password-->
		                </div>
		                <!--end::Input group=-->
		                <!--begin::Wrapper-->
		                <div class="d-flex flex-stack flex-wrap gap-3 fs-base fw-semibold mb-8">
		                    <div></div>
		                    <!--begin::Link-->
		                    <a href="{{url('forgot-password')}}" class="link-primary">Forgot Password ?</a>
		                    <!--end::Link-->
		                </div>
		                <!--end::Wrapper-->
		                <!--begin::Submit button-->
		                <div class="d-grid mb-10">
		                    <button type="submit" id="kt_sign_in_submit" class="btn btn-primary">
		                        <!--begin::Indicator label-->
		                        <span class="indicator-label">Sign In</span>
		                        <!--end::Indicator label-->
		                        <!--begin::Indicator progress-->
		                        <span class="indicator-progress">Please wait...
		                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
		                        <!--end::Indicator progress-->
		                    </button>
		                </div>
		                <!--end::Submit button-->
		                <!--begin::Sign up-->
		                <div class="text-gray-500 text-center fw-semibold fs-6">Not a Member yet?
		                <a href="{{url('register')}}" class="link-primary">Sign up</a></div>
		                <!--end::Sign up-->
		            </form>
		            <!--end::Form-->
				</div>
				<!--end::Wrapper-->
				<!--begin::Footer-->
				<div class="d-flex flex-stack px-lg-10">
					<!--begin::Links-->
					<div class="d-flex fw-semibold text-primary fs-base gap-5">
						<a href="{{url('tnc')}}" target="_blank">Terms</a>
						<a href="{{url('pricing')}}" target="_blank">Plans</a>
						<a href="{{url('contact')}}" target="_blank">Contact Us</a>
					</div>
					<!--end::Links-->
				</div>
				<!--end::Footer-->
			</div>
			<!--end::Card-->
		</div>
		<!--end::Body-->
	</div>
	<!--end::Authentication - Sign-in-->
</div>
@endsection