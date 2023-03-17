@extends('layouts.master')
@section('title')
    {{__('messagevalidation.users.images')}}
@endsection
@section('css')
    <!-- Internal Data table css -->
    <link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
    <link href="{{URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}" rel="stylesheet">
    <link href="{{URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
    <link href="{{URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css')}}" rel="stylesheet">
    <link href="{{URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css')}}" rel="stylesheet">

    <!--- Internal Select2 css-->
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <!---Internal Fileupload css-->
    <link href="{{ URL::asset('assets/plugins/fileuploads/css/fileupload.css') }}" rel="stylesheet" type="text/css" />
    <!---Internal Fancy uploader css-->
    <link href="{{ URL::asset('assets/plugins/fancyuploder/fancy_fileupload.css') }}" rel="stylesheet" />
    <!--Internal Sumoselect css-->
    <link rel="stylesheet" href="{{ URL::asset('assets/plugins/sumoselect/sumoselect-rtl.css') }}">

    <!--Internal  Quill css -->
    <link href="{{URL::asset('assets/plugins/quill/quill.snow.css')}}" rel="stylesheet">
    <link href="{{URL::asset('assets/plugins/quill/quill.bubble.css')}}" rel="stylesheet">
@endsection
@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto">{{__('messagevalidation.users.images')}}</h4>
						</div>
					</div>
				</div>
				<!-- breadcrumb -->
@endsection
@section('content')
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

				<!-- row -->
				<div class="row">

                    {{-- Index --}}
                        <div class="col-xl-12">
                            <div class="card mg-b-20">
                                <div class="card-header pb-0">
                                    <div class="d-flex justify-content-between">
                                        <a class="modal-effect btn btn-outline-primary btn-block" data-effect="effect-scale" data-toggle="modal"
                                        href="#modaldemo8" title="Update">
                                        {{__('messagevalidation.users.addimagesgallary')}}</a>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="example1" class="table key-buttons text-md-nowrap">
                                            <thead>
                                                <tr>
                                                    <th class="border-bottom-0">#</th>
                                                    <th class="border-bottom-0">{{__('messagevalidation.users.products')}}</th>
                                                    <th class="border-bottom-0">{{__('messagevalidation.users.mainimage')}}</th>
                                                    <th class="border-bottom-0">{{__('messagevalidation.users.galleryimages')}}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                    <tr>
                                                        <td>{{$Product->id}}</td>
                                                        <td>{{$Product->title}}</td>
                                                        @foreach ($images as $x)
                                                            <td>
                                                                <img src="{{asset('storage/'.$x->mainimage)}}" alt="" style="width: 80px; height:80px;">
                                                                <br>
                                                                <br>
                                                                <input placeholder="{{__('messagevalidation.users.color')}}" type="color" name="color" value="{{$x->product_color->color}}" class="form-control @error('color') is-invalid @enderror" id="color" disabled>
                                                                <br>
                                                                <a class="modal-effect btn btn-sm btn-info" data-effect="effect-scale"
                                                                data-id="{{ $x->id }}"
                                                                data-colorid="{{ $x->product_color->id }}"
                                                                data-mainimage="{{ $x->mainimage }}" data-toggle="modal"
                                                                href="#exampleModal2" title="Update">
                                                                <i class="las la-pen"></i></a>
                                                            </td>
                                                        @endforeach
                                                        @foreach ($multimg as $x)
                                                            <td>
                                                                <form action="{{route('image.delete')}}" method="post">
                                                                    {{ method_field('delete') }}
                                                                    {{ csrf_field() }}
                                                                    <input type="hidden" value="{{$x->id}}" name="id">
                                                                    <img src="{{asset('storage/'.$x->multimg)}}" alt="" style="width: 80px; height:80px;">
                                                                    <br>
                                                                    <br>
                                                                    <input placeholder="{{__('messagevalidation.users.color')}}" type="color" name="color" value="{{$x->product_color->color}}" class="form-control @error('color') is-invalid @enderror" id="color" disabled>
                                                                    <button type="submit" class="btn btn-danger">{{__('message.deletee')}}</button>
                                                                </form>
                                                            </td>
                                                        @endforeach

                                                    </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                    <!-- Add Images -->
                        <div class="modal" id="modaldemo8">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content modal-content-demo">
                                    <div class="modal-header">
                                        <h6 class="modal-title">{{__('messagevalidation.users.addimages')}}</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                                    </div>
                                        <div class="modal-body">
                                            <form action="{{route('image.create')}}" method="post" enctype="multipart/form-data" autocomplete="off">
                                                @csrf
                                                    <div class="form-group">
                                                        <input placeholder="product_id" type="hidden" id="product_id" name="product_id" value="{{$Product->id}}">
                                                        <div class="from-group">
                                                            <label for="files" class="form-label mt-4">{{__('messagevalidation.users.uploadmoreimages')}}</label>
                                                            <input id="image" type="file" name="image" data-height="200" accept=".jpg, .png, image/jpeg, image/png" class="dropify @error('image') is-invalid @enderror">
                                                        </div>
                                                        <br>
                                                        <div class="form-group">
                                                            <input placeholder="{{__('messagevalidation.users.color')}}" type="color" name="color" class="form-control @error('color') is-invalid @enderror" id="color">
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button class="btn ripple btn-primary" type="submit">{{__('message.save')}}</button>
                                                        <button class="btn ripple btn-secondary" data-dismiss="modal" type="button">{{__('message.close')}}</button>
                                                    </div>
                                            </form>
                                        </div>
                                </div>
                            </div>
                        </div>
                    <!-- End Basic modal -->

                                        <!-- edit -->
                                        <div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog"  aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="{{route('image.edit')}}" enctype="multipart/form-data" method="post" autocomplete="off">
                                                            {{ method_field('patch') }}
                                                            {{ csrf_field() }}
                                                            <div class="form-group">
                                                                <input type="hidden" name="id" id="id">
                                                                <input type="text" name="colorid" id="colorid">
                                                            </div>
                                                            <div class="form-group">
                                                                <input type="file" class="dropify @error('image') is-invalid @enderror" data-height="200" id="image" name="image" accept=".jpg, .png, image/jpeg, image/png"/>
                                                            </div>
                                                            <div class="form-group">
                                                                <input placeholder="{{__('messagevalidation.users.color')}}" type="color" name="color" class="form-control @error('color') is-invalid @enderror">
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="submit" class="btn btn-primary">{{__('message.save')}}</button>
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('message.close')}}</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
				</div>
				<!-- row closed -->
			</div>
			<!-- Container closed -->
		</div>
		<!-- main-content closed -->
@endsection
@section('js')

    <script>
        $('#exampleModal2').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var mainimage = button.data('mainimage')
            var colorid = button.data('colorid')
            var modal = $(this)
            modal.find('.modal-body #id').val(id);
            modal.find('.modal-body #mainimage').val(mainimage);
            modal.find('.modal-body #colorid').val(colorid);
        })
    </script>
    <!-- Internal Data tables -->
    <script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/dataTables.dataTables.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/responsive.dataTables.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/jszip.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/pdfmake.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/vfs_fonts.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/buttons.html5.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/buttons.print.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js')}}"></script>
    <!--Internal  Datatable js -->
    <script src="{{URL::asset('assets/js/table-data.js')}}"></script>
    <script src="{{URL::asset('assets/js/modal.js')}}"></script>

    <!--Internal Fileuploads js-->
    <script src="{{URL::asset('assets/plugins/fileuploads/js/fileupload.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/fileuploads/js/file-upload.js')}}"></script>
    <!--Internal Fancy uploader js-->
    <script src="{{URL::asset('assets/plugins/fancyuploder/jquery.ui.widget.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/fancyuploder/jquery.fileupload.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/fancyuploder/jquery.iframe-transport.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/fancyuploder/jquery.fancy-fileupload.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/fancyuploder/fancy-uploader.js')}}"></script>

    <!--Internal Sumoselect js-->
    <script src="{{URL::asset('assets/plugins/sumoselect/jquery.sumoselect.js')}}"></script>
    <!--Internal quill js -->
    <script src="{{URL::asset('assets/plugins/quill/quill.min.js')}}"></script>
@endsection
