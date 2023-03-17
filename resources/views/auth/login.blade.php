@extends('layouts.master2')
@section('css')
<!-- Sidemenu-respoansive-tabs css -->
<link href="{{URL::asset('assets/plugins/sidemenu-responsive-tabs/css/sidemenu-responsive-tabs.css')}}" rel="stylesheet">
@endsection
@section('content')
		<div class="container-fluid">
			<div class="row no-gutter">
				<!-- The image half -->
				<div class="col-md-6 col-lg-6 col-xl-7 d-none d-md-flex bg-primary-transparent">
					<div class="row wd-100p mx-auto text-center">
						<div class="col-md-12 col-lg-12 col-xl-12 my-auto mx-auto wd-100p">
							<img src="{{URL::asset('assets/img/flags/favicon.png')}}" class="my-auto ht-xl-80p wd-md-100p wd-xl-80p mx-auto" alt="logo">
						</div>
					</div>
				</div>
				<!-- The content half -->
				<div class="col-md-6 col-lg-6 col-xl-5 bg-white">
					<div class="login d-flex align-items-center py-2">
						<!-- Demo content-->
						<div class="container p-0">
							<div class="row">
								<div class="col-md-10 col-lg-10 col-xl-9 mx-auto">
									<div class="card-sigin">
										<div class="mb-3 d-flex">
                                            <h1 class="main-logo1 ml-1 mr-0 my-auto tx-28"><span><a href="{{route('welcome')}}">{{__('message.Couture Sofa')}}</a></span></h1>
                                            <ul class="nav">
                                                <li class="">
                                                    <div class="dropdown  nav-itemd-none d-md-flex">
                                                        <a href="#" class="d-flex nav-item nav-link pr-4 country-flag1" data-toggle="dropdown" aria-expanded="false">
                                                            <span class="avatar bg-transparent"><img src="{{URL::asset('assets/img/flags/images.png')}}" alt="img"></span>
                                                        </a>
                                                        <div class="dropdown-menu dropdown-menu-left dropdown-menu-arrow" x-placement="bottom-end">
                                                            @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                                                    <a rel="alternate" hreflang="{{ $localeCode }}" href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}" class="dropdown-item d-flex ">
                                                                        <div class="d-flex">
                                                                            <span class="mt-2">{{ $properties['native'] }}</span>
                                                                        </div>
                                                                    </a>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="card-sigin">
											<div class="main-signup-header">
												<h2>{{__('message.Welcome back!')}}</h2>
												<h5 class="font-weight-semibold mb-4">{{__('message.Please sign in to continue.')}}</h5>
                                                <!-- Session Status -->
                                                <x-auth-session-status class="mb-4" :status="session('status')" />
												<form method="POST" action="{{ route('loginbackend') }}">
                                                    @csrf
													<div class="form-group">
														<label>{{__('message.Email')}}</label>
                                                        <input class="form-control" placeholder="{{__('message.enteryouemail')}}" type="email" name="email" :value="old('email')" required autofocus>
                                                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                                    </div>
													<div class="form-group">
														<label>{{__('message.Password')}}</label>
                                                        <input class="form-control" placeholder="{{__('message.enteryoupassword')}}" type="password" name="password" required autocomplete="current-password">
													</div>
                                                    <div class="block mt-4">
                                                        <label for="remember_me" class="inline-flex items-center">
                                                            <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                                                            <span class="ml-2 text-sm text-gray-600">{{ __('message.Remember me') }}</span>
                                                        </label>
                                                    </div>
                                                    <button class="btn btn-main-primary btn-block">{{__('message.Sign In')}}</button>
												</form>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div><!-- End -->
					</div>
				</div><!-- End -->
			</div>
		</div>
@endsection
@section('js')
@endsection
