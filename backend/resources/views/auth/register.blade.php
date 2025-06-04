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
			@if ($errors->register->any())
			<ul>
			     @foreach($errors->register->all() as $error)
			        <li>{{ $error }}</li>
			     @endforeach
			 </ul>
			@endif
			<!--begin::Card-->
			<div class="bg-body d-flex flex-column align-items-stretch flex-center rounded-4 w-md-600px p-20">
				<!--begin::Wrapper-->
				<div class="d-flex flex-center flex-column flex-column-fluid px-lg-10 pb-15 pb-lg-20">
					 <!--begin::Form-->
		            <form class="form w-100" novalidate="novalidate" id="kt_sign_up_form" data-kt-redirect-url="dashboard" method="POST" action="{{route('register')}}">
		            	@csrf
		                <!--begin::Heading-->
		                <div class="text-center mb-11">
		                    <!--begin::Title-->
		                    <h1 class="text-dark fw-bolder mb-3">Sign Up</h1>
		                    <!--end::Title-->
		                </div>
		                <!--begin::Heading-->
		                <!--begin::Input group=-->
			            <div class="fv-row mb-8">
			                <input type="text" placeholder="Name" name="name" class="form-control bg-transparent" />
			            </div>
			            <!--begin::Input group=-->
			            <div class="fv-row mb-8">
			                <input type="text" placeholder="phone" name="phone" class="form-control bg-transparent" />
			            </div>
			             <!--begin::Input group=-->
			            <div class="fv-row mb-8">
			            	<select class="form-select" data-control="select2" data-placeholder="Select City" name="city">
			            		<option selected="selected" value="">S</option>
			            		@foreach(\App\Models\City::get(['id', 'name']) as $city)
								    <option value="{{ $city->id }}">{{ $city->name }}</option>
								@endforeach
			            	</select>
			            </div>
			            <!--begin::Input group=-->
			            <div class="fv-row mb-8">
			                <!--begin::Email-->
			                <input type="text" placeholder="Email" name="email" class="form-control bg-transparent" />
			                <!--end::Email-->
			            </div>
			            <!--begin::Input group-->
			            <div class="fv-row mb-8" data-kt-password-meter="true">
			                <!--begin::Wrapper-->
			                <div class="mb-1">
			                    <!--begin::Input wrapper-->
			                    <div class="position-relative mb-3">
			                        <input class="form-control bg-transparent" type="password" placeholder="Password" name="password" autocomplete="off" />
			                        <span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2" data-kt-password-meter-control="visibility">
			                            <i class="ki-outline ki-eye-slash fs-2"></i>
			                            <i class="ki-outline ki-eye fs-2 d-none"></i>
			                        </span>
			                    </div>
			                    <!--end::Input wrapper-->
			                    <!--begin::Meter-->
			                    <div class="d-flex align-items-center mb-3" data-kt-password-meter-control="highlight">
			                        <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
			                        <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
			                        <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
			                        <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px"></div>
			                    </div>
			                    <!--end::Meter-->
			                </div>
			                <!--end::Wrapper-->
			                <!--begin::Hint-->
			                <div class="text-muted">Use 8 or more characters with a mix of letters, numbers & symbols.</div>
			                <!--end::Hint-->
			            </div>
			            <!--end::Input group=-->
			            <!--end::Input group=-->
			            <div class="fv-row mb-8">
			                <!--begin::Repeat Password-->
			                <input placeholder="Repeat Password" name="password_confirmation" type="password" autocomplete="off" class="form-control bg-transparent" />
			                <!--end::Repeat Password-->
			            </div>
			            <!--end::Input group=-->
			            <div class="fv-row input-group mb-8">
						  	<input type="text" class="form-control" name="referral_code" placeholder="Referral Code" aria-label="Referral Code">
						  	<button class="btn btn-success" type="button" id="button-addon2">Check</button>
						</div>
			            <!--begin::Accept-->
			            <div class="fv-row mb-8">
			                <label class="form-check form-check-inline">
			                    <input class="form-check-input" type="checkbox" name="toc" value="1" />
			                    <span class="form-check-label fw-semibold text-gray-700 fs-base ms-1">I Accept the
			                    <a href="#" class="ms-1 link-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_term">TnC</a></span>
			                </label>
			            </div>
			            <!--end::Accept-->
		                <!--begin::Submit button-->
		                <div class="d-grid mb-10">
		                    <button type="submit" id="kt_sign_up_submit" class="btn btn-primary">
		                        <!--begin::Indicator label-->
		                        <span class="indicator-label">Sign Up</span>
		                        <!--end::Indicator label-->
		                        <!--begin::Indicator progress-->
		                        <span class="indicator-progress">Please wait...
		                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
		                        <!--end::Indicator progress-->
		                    </button>
		                </div>
		                <!--end::Submit button-->
		                <!--begin::Sign up-->
		                <div class="text-gray-500 text-center fw-semibold fs-6">Already Member?
		                <a href="{{url('login')}}" class="link-primary">Sign In</a></div>
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

<div class="modal fade" id="kt_modal_term" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog mw-650px">
        <div class="modal-content">
            <div class="modal-header" id="kt_modal_create_header">
                <h2 class="fw-bold">Terms and Conditions</h2>
                <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                    <i class="ki-outline ki-cross fs-1"></i>
                </div>
            </div>
            <div class="modal-body px-5 my-7">
                <p>
				Syarat dan Ketentuan untuk Pendaftaran Pengguna dan Penggunaan Data
            <ol>
                <li>
                    Persetujuan atas Syarat dan Ketentuan
                    <ol type = "a" start = "1">   
                        <li>
                            Dengan mendaftarkan akun di {{config('app.name')}}, Anda setuju untuk terikat oleh Syarat dan Ketentuan ini. Jika Anda tidak setuju dengan syarat dan ketentuan ini, harap tidak menggunakan Aplikasi atau mendaftarkan akun.
                        </li>
                    </ol>
                </li>
                <li>
                    Pendaftaran Pengguna
                    <ol type = "a" start = "1">   
                        <li>Untuk menggunakan fitur tertentu di Aplikasi, Anda harus mendaftarkan akun dengan memberikan informasi yang akurat dan lengkap.</li>
                        <li>Anda bertanggung jawab untuk menjaga kerahasiaan kredensial akun Anda dan untuk semua aktivitas yang terjadi di bawah akun Anda.</li>
                    </ol>
                </li>
                <li>
                    Pengumpulan dan Penggunaan Data
                    <ol type = "a" start = "1">   
                        <li>
                            <span>Jenis Data yang Dikumpulkan:</span>
                            <span>Aplikasi dapat mengumpulkan jenis data berikut:</span>
                            <ul>
                            	<li>Informasi Pribadi: Nama, alamat email, nomor telepon, dll.</li>
                            	<li>Data Penggunaan: Alamat IP, informasi perangkat, aktivitas penelusuran, dll.</li>
                            	<li>Data Lainnya: Informasi tambahan yang Anda berikan secara sukarela.</li>
                            </ul>
                        </li>
                        <li>
                            <span>Tujuan Pengumpulan Data:</span>
                            <span>Data Anda dikumpulkan dan digunakan untuk tujuan berikut:</span>
                            <ul>
                            	<li>Untuk menyediakan dan meningkatkan layanan Aplikasi.</li>
                            	<li>Untuk mempersonalisasi pengalaman Anda.</li>
                            	<li>Untuk berkomunikasi dengan Anda (misalnya, pembaruan, dukungan, pemasaran).</li>
                            	<li>Untuk mematuhi kewajiban hukum.</li>
                            </ul>
                        </li>
                        <li>
                            <span>Berbagi Data:</span>
                            <span>Aplikasi dapat mengumpulkan jenis data berikut:</span>
                            <ul>
                            	<li>Penyedia layanan pihak ketiga yang membantu pengoperasian Aplikasi.</li>
                            	<li>Otoritas hukum jika diwajibkan oleh undang-undang.</li>
                            	<li>Afiliasi atau mitra, tetapi hanya dengan persetujuan eksplisit Anda.</li>
                            </ul>
                        </li>
                        <li>
                            <span>Keamanan Data:</span>
                            <span>Kami menerapkan langkah-langkah keamanan yang wajar untuk melindungi data Anda. Namun, tidak ada sistem yang sepenuhnya aman, dan kami tidak dapat menjamin keamanan absolut.</span>
                        </li>
                    </ol>
                </li>
                <li>
                    Layanan Pihak Ketiga
                    <ol type = "a" start = "1">   
                        <li>
                            Aplikasi dapat terintegrasi dengan layanan pihak ketiga (misalnya, platform media sosial, gateway pembayaran). Layanan ini memiliki syarat dan kebijakan privasi sendiri, dan kami tidak bertanggung jawab atas praktik mereka.
                        </li>
                        <li>
                           Dengan menggunakan layanan pihak ketiga, Anda setuju dengan syarat dan ketentuan mereka.
                        </li>
                    </ol>
                </li>
              <li>
                    Perubahan pada Syarat dan Ketentuan
                    <ol type = "a" start = "1">   
                        <li>
                            Kami dapat memperbarui Syarat dan Ketentuan ini dari waktu ke waktu. Perubahan akan dipublikasikan di halaman ini, dan penggunaan Aplikasi Anda yang berkelanjutan menunjukkan penerimaan Anda terhadap syarat dan ketentuan yang diperbarui.

                        </li>
                        <li>
                           Kami akan memberi tahu Anda tentang perubahan signifikan melalui email atau melalui Aplikasi.


                        </li>
                    </ol>
                </li>
                <li>
                    Batasan Tanggung Jawab
                    <ol type = "a" start = "1">   
                        <li>Aplikasi disediakan "sebagaimana adanya," dan kami tidak menjamin layanan yang bebas gangguan atau bebas kesalahan.
                        </li>
                        <li>
                           Sejauh diizinkan oleh hukum, kami tidak bertanggung jawab atas kerusakan apa pun yang timbul dari penggunaan Aplikasi Anda.
                        </li>
                    </ol>
                </li>
            </ol>
            Dengan mendaftarkan akun, Anda menyatakan bahwa Anda telah membaca, memahami, dan menyetujui Syarat dan Ketentuan ini.
        </p>
            </div>
        </div>
    </div>
</div>
@endsection

@section('compute')
	@parent
	<script src="{{asset('assets/js/custom/authentication/sign-up/general.js')}}"></script>
@endsection