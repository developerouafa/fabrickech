<!-- main-sidebar -->
		<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
		<aside class="app-sidebar sidebar-scroll">
			<div class="main-sidebar-header active">
                <a href="{{ route('dashboardbackend') }}"><img src="{{URL::asset('assets/img/brand/favicon.png')}}" class="sign-favicon ht-40 shadow-lg rounded-lg" alt="logo"></a>
                <h1 class="main-logo1 ml-1 mr-0 my-auto tx-28"><span> <a href="{{route('dashboardbackend')}}">{{__('message.Couture Sofa')}}</a> </span></h1>
            </div>
			<div class="main-sidemenu">
				<div class="app-sidebar__user clearfix">
					<div class="dropdown user-pro-body">
						<div class="">
                            <?php
                                use App\Models\User;
                                $imageuser = User::query()->select('id')->where('id', '=', Auth::user()->id)->with('image')->get();
                            ?>
                            @foreach ($imageuser as $img)
                                @if (empty($img->image->image))
                                    <img alt="user-img" class="avatar avatar-xl brround" src="{{URL::asset('assets/img/faces/6.jpg')}}"><span class="avatar-status profile-status bg-green"></span>
                                @else
                                    <img alt="user-img" class="avatar avatar-xl brround" src="{{URL::asset('storage/'.$img->image->image)}}"><span class="avatar-status profile-status bg-green"></span>
                                @endif
                            @endforeach

						</div>
						<div class="user-info">
							<h4 class="font-weight-semibold mt-3 mb-0">{{Auth::user()->profileuser->firstname}} {{Auth::user()->profileuser->lastname}}</h4>
						</div>
					</div>
				</div>
				<ul class="side-menu">
                    {{-- @can('المستخدمين') --}}
                    <li class="side-item side-item-category">
                        <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24"><path d="M0 0h24v24H0V0z" fill="none"></path><path d="M4 12c0 4.08 3.06 7.44 7 7.93V4.07C7.05 4.56 4 7.92 4 12z" opacity=".3"></path><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.94-.49-7-3.85-7-7.93s3.05-7.44 7-7.93v15.86zm2-15.86c1.03.13 2 .45 2.87.93H13v-.93zM13 7h5.24c.25.31.48.65.68 1H13V7zm0 3h6.74c.08.33.15.66.19 1H13v-1zm0 9.93V19h2.87c-.87.48-1.84.8-2.87.93zM18.24 17H13v-1h5.92c-.2.35-.43.69-.68 1zm1.5-3H13v-1h6.93c-.04.34-.11.67-.19 1z"></path></svg>
                        {{__('message.Dashboard')}}
                    </li>
                    <li class="slide">
                        <a class="side-menu__item" data-toggle="slide" href="{{ url('/' . ($page = '#')) }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M6 20h12V10H6v10zm6-7c1.1 0 2 .9 2 2s-.9 2-2 2-2-.9-2-2 .9-2 2-2z" opacity=".3"/><path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zM9 6c0-1.66 1.34-3 3-3s3 1.34 3 3v2H9V6zm9 14H6V10h12v10zm-6-3c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2z"/></svg>
                            <span class="side-menu__label">{{__('message.users')}}</span><i class="angle fe fe-chevron-down"></i>
                        </a>
                        <ul class="slide-menu">
                            {{-- @can('قائمة المستخدمين') --}}
                            <li><a class="slide-item" href="{{ url('/' . ($page = 'users')) }}">{{__('message.userlist')}}</a></li>
                            {{-- @endcan --}}

                            {{-- @can('صلاحيات المستخدمين') --}}
                                <li><a class="slide-item" href="{{ url('/' . ($page = 'roles')) }}">{{__('message.userpermissions')}}</a></li>
                            {{-- @endcan --}}
                                <li><a class="slide-item" href="{{ route('bulk_index') }}">{{__('message.bulk')}}</a></li>
                        </ul>
                    </li>
                    {{-- @endcan --}}
                    <li class="slide">
						<a class="side-menu__item" data-toggle="slide" href="{{ url('/' . $page='#') }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24"><path d="M0 0h24v24H0V0z" fill="none"></path><path d="M5 5h4v4H5zm10 10h4v4h-4zM5 15h4v4H5zM16.66 4.52l-2.83 2.82 2.83 2.83 2.83-2.83z" opacity=".3"></path><path d="M16.66 1.69L11 7.34 16.66 13l5.66-5.66-5.66-5.65zm-2.83 5.65l2.83-2.83 2.83 2.83-2.83 2.83-2.83-2.83zM3 3v8h8V3H3zm6 6H5V5h4v4zM3 21h8v-8H3v8zm2-6h4v4H5v-4zm8-2v8h8v-8h-8zm6 6h-4v-4h4v4z"></path></svg>
                            <span class="side-menu__label">{{__('messagevalidation.users.Categories')}}</span><i class="angle fe fe-chevron-down"></i>
                        </a>
						<ul class="slide-menu">
                            <li><a class="slide-item" href="{{ route('category_index') }}">{{__('messagevalidation.users.Categories')}}</a></li>
                            <li><a class="slide-item" href="{{ route('childcat_index') }}">{{__('messagevalidation.users.children')}}</a></li>
                        </ul>
					</li>
                    <li class="slide">
						<a class="side-menu__item" data-toggle="slide" href="{{ url('/' . $page='#') }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24"><path d="M0 0h24v24H0V0z" fill="none"></path><path d="M5 5h15v3H5zm12 5h3v9h-3zm-7 0h5v9h-5zm-5 0h3v9H5z" opacity=".3"></path><path d="M20 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h15c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zM8 19H5v-9h3v9zm7 0h-5v-9h5v9zm5 0h-3v-9h3v9zm0-11H5V5h15v3z"></path></svg>
                            <span class="side-menu__label">{{__('message.tags')}}</span><i class="angle fe fe-chevron-down"></i>
                        </a>
						<ul class="slide-menu">
                            <li><a class="slide-item" href="{{ route('tags_index') }}">{{__('message.tags')}}</a></li>
						</ul>
					</li>
                    <li class="slide">
						<a class="side-menu__item" data-toggle="slide" href="{{ url('/' . $page='#') }}">
                            <svg xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 24 24" class="side-menu__icon" viewBox="0 0 24 24" ><g><rect fill="none"/></g><g><g/><g><path d="M21,5c-1.11-0.35-2.33-0.5-3.5-0.5c-1.95,0-4.05,0.4-5.5,1.5c-1.45-1.1-3.55-1.5-5.5-1.5S2.45,4.9,1,6v14.65 c0,0.25,0.25,0.5,0.5,0.5c0.1,0,0.15-0.05,0.25-0.05C3.1,20.45,5.05,20,6.5,20c1.95,0,4.05,0.4,5.5,1.5c1.35-0.85,3.8-1.5,5.5-1.5 c1.65,0,3.35,0.3,4.75,1.05c0.1,0.05,0.15,0.05,0.25,0.05c0.25,0,0.5-0.25,0.5-0.5V6C22.4,5.55,21.75,5.25,21,5z M3,18.5V7 c1.1-0.35,2.3-0.5,3.5-0.5c1.34,0,3.13,0.41,4.5,0.99v11.5C9.63,18.41,7.84,18,6.5,18C5.3,18,4.1,18.15,3,18.5z M21,18.5 c-1.1-0.35-2.3-0.5-3.5-0.5c-1.34,0-3.13,0.41-4.5,0.99V7.49c1.37-0.59,3.16-0.99,4.5-0.99c1.2,0,2.4,0.15,3.5,0.5V18.5z"/><path d="M11,7.49C9.63,6.91,7.84,6.5,6.5,6.5C5.3,6.5,4.1,6.65,3,7v11.5C4.1,18.15,5.3,18,6.5,18 c1.34,0,3.13,0.41,4.5,0.99V7.49z" opacity=".3"/></g><g><path d="M17.5,10.5c0.88,0,1.73,0.09,2.5,0.26V9.24C19.21,9.09,18.36,9,17.5,9c-1.28,0-2.46,0.16-3.5,0.47v1.57 C14.99,10.69,16.18,10.5,17.5,10.5z"/><path d="M17.5,13.16c0.88,0,1.73,0.09,2.5,0.26V11.9c-0.79-0.15-1.64-0.24-2.5-0.24c-1.28,0-2.46,0.16-3.5,0.47v1.57 C14.99,13.36,16.18,13.16,17.5,13.16z"/><path d="M17.5,15.83c0.88,0,1.73,0.09,2.5,0.26v-1.52c-0.79-0.15-1.64-0.24-2.5-0.24c-1.28,0-2.46,0.16-3.5,0.47v1.57 C14.99,16.02,16.18,15.83,17.5,15.83z"/></g></g></svg>
                            <span class="side-menu__label">{{__('messagevalidation.users.posts')}}</span><i class="angle fe fe-chevron-down"></i>
                        </a>
						<ul class="slide-menu">
                            <li><a class="slide-item" href="{{ route('posts_index') }}">{{__('messagevalidation.users.posts')}}</a></li>
						</ul>
					</li>
                    <li class="slide">
						<a class="side-menu__item" data-toggle="slide" href="{{ url('/' . $page='#') }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M3.31 11l2.2 8.01L18.5 19l2.2-8H3.31zM12 17c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2z" opacity=".3"/><path d="M22 9h-4.79l-4.38-6.56c-.19-.28-.51-.42-.83-.42s-.64.14-.83.43L6.79 9H2c-.55 0-1 .45-1 1 0 .09.01.18.04.27l2.54 9.27c.23.84 1 1.46 1.92 1.46h13c.92 0 1.69-.62 1.93-1.46l2.54-9.27L23 10c0-.55-.45-1-1-1zM12 4.8L14.8 9H9.2L12 4.8zM18.5 19l-12.99.01L3.31 11H20.7l-2.2 8zM12 13c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"/></svg>
                            <span class="side-menu__label">{{__('messagevalidation.users.products')}}</span><i class="angle fe fe-chevron-down"></i>
                        </a>
						<ul class="slide-menu">
                            <li><a class="slide-item" href="{{ route('product_index') }}">{{__('messagevalidation.users.products')}}</a></li>
						</ul>
					</li>
                    <li class="slide">
						<a class="side-menu__item" data-toggle="slide" href="{{ url('/' . $page='#') }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M6.26 9L12 13.47 17.74 9 12 4.53z" opacity=".3"/><path d="M19.37 12.8l-7.38 5.74-7.37-5.73L3 14.07l9 7 9-7zM12 2L3 9l1.63 1.27L12 16l7.36-5.73L21 9l-9-7zm0 11.47L6.26 9 12 4.53 17.74 9 12 13.47z"/></svg>
                            <span class="side-menu__label">{{__('message.orderstatus')}}</span><i class="angle fe fe-chevron-down"></i>
                        </a>
						<ul class="slide-menu">
                            <li><a class="slide-item" href="{{ route('statusoreder_index') }}">{{__('message.orderstatus')}}</a></li>
						</ul>
					</li>
                    <li class="slide">
						<a class="side-menu__item" data-toggle="slide" href="{{ url('/' . $page='#') }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M6.26 9L12 13.47 17.74 9 12 4.53z" opacity=".3"/><path d="M19.37 12.8l-7.38 5.74-7.37-5.73L3 14.07l9 7 9-7zM12 2L3 9l1.63 1.27L12 16l7.36-5.73L21 9l-9-7zm0 11.47L6.26 9 12 4.53 17.74 9 12 13.47z"/></svg>
                            <span class="side-menu__label">{{__('message.orders')}}</span><i class="angle fe fe-chevron-down"></i>
                        </a>
						<ul class="slide-menu">
                            <li><a class="slide-item" href="{{ route('orders_index') }}">{{__('message.Orders In Cart')}}</a></li>
                            <li><a class="slide-item" href="{{ route('oneorder_index') }}">{{__('message.OneOrder')}}</a></li>
						</ul>
					</li>
                    <li class="slide pb-52">
						<a class="side-menu__item" data-toggle="slide" href="{{ url('/' . $page='#') }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24"><path d="M0 0h24v24H0V0z" fill="none"></path><path d="M15 11V4H4v8.17l.59-.58.58-.59H6z" opacity=".3"></path><path d="M21 6h-2v9H6v2c0 .55.45 1 1 1h11l4 4V7c0-.55-.45-1-1-1zm-5 7c.55 0 1-.45 1-1V3c0-.55-.45-1-1-1H3c-.55 0-1 .45-1 1v14l4-4h10zM4.59 11.59l-.59.58V4h11v7H5.17l-.58.59z"></path></svg>
                            <span class="side-menu__label">{{__('messagevalidation.users.contactus')}}</span><i class="angle fe fe-chevron-down"></i>
                        </a>
						<ul class="slide-menu">
                            <li><a class="slide-item" href="{{ route('contactus_index') }}">{{__('messagevalidation.users.contactus')}}</a></li>
						</ul>
					</li>
				</ul>
			</div>
		</aside>
<!-- main-sidebar -->
