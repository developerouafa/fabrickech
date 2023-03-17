@extends('layouts.master')
@section('title')
    {{__('message.orders')}}
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
                <h4 class="content-title mb-0 my-auto">{{(__('message.orders'))}}</h4>
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
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="example1" class="table key-buttons text-md-nowrap">
                                        <thead>
                                            <tr>
                                                <th class="border-bottom-0">#</th>
                                                <th class="border-bottom-0">{{__('messagevalidation.users.price')}}</th>
                                                <th class="border-bottom-0">{{__('message.Quantity')}}</th>
                                                <th class="border-bottom-0">{{__('message.Total')}}</th>
                                                <th class="border-bottom-0">{{__('message.CLIENT')}}</th>
                                                <th class="border-bottom-0">{{__('message.Status')}}</th>
                                                <th class="border-bottom-0"></th>
                                                <th class="border-bottom-0"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($orders as $ordersproduct)
                                                <tr>
                                                    <td>{{$ordersproduct->id}}</td>
                                                    <td>
                                                        @foreach($ordersproduct->products as $drug=>$d)
                                                            @foreach ($products as $pr)
                                                                @if ($pr->id == $d)
                                                                <b style="color: #FF7370">{{__('message.$')}}{{$pr->price}}</b>
                                                                <br>
                                                                <b style="color: #FF7370">{{$pr->title}}</b>
                                                                <br>
                                                                @endif
                                                            @endforeach
                                                        @endforeach
                                                    </td>
                                                    <td>{{$ordersproduct->quantity}}</td>
                                                    <td>{{__('message.$')}}{{$ordersproduct->total}}</td>
                                                    <td>
                                                        <span style="color:#4507AC">{{__('message.Full Name')}} : </span>{{$ordersproduct->fullname}},
                                                        <span style="color:#4507AC">{{__('message.Town')}} : </span>{{$ordersproduct->town}},<br>
                                                        <span style="color:#4507AC">{{__('message.City')}} : </span>{{$ordersproduct->city}},
                                                        <span style="color:#4507AC">{{__('message.Region')}} : </span>{{$ordersproduct->region}},<br>
                                                        <span style="color:#4507AC">{{__('message.Street Address')}} : </span>{{$ordersproduct->streetaddress}},<br>
                                                        <span style="color:#4507AC">{{__('message.Zip Code')}} : </span>{{$ordersproduct->zipcode}},
                                                        <span style="color:#4507AC">{{__('message.Phone')}} : </span>{{$ordersproduct->phone}}
                                                    </td>
                                                    <td>
                                                        <b style="color:forestgreen">{{$ordersproduct->statusorder->status}}</b>
                                                        <a class="modal-effect btn btn-sm btn-info" data-effect="effect-scale"
                                                            data-id="{{ $ordersproduct->id }}" data-toggle="modal"
                                                            href="#exampleModal2" title="Update">
                                                            <i class="las la-pen"></i></a>
                                                    </td>
                                                    <td>{{$ordersproduct->created_at->diffForHumans()}}</td>
                                                    <td>
                                                        <a class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale"
                                                            data-id="{{ $ordersproduct->id }}"
                                                            data-toggle="modal" href="#modaldemo9" title="Delete">
                                                            <i class="las la-trash"></i></a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                <!-- edit -->
                    <div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog"  aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">{{__('message.updatetitle')}} {{__('message.orderstatus')}}</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{route('oneorderstatus.update')}}" enctype="multipart/form-data" method="post" autocomplete="off">
                                        {{ method_field('patch') }}
                                        {{ csrf_field() }}
                                        <div class="form-group">
                                            <input type="hidden" name="id" id="id">
                                            <select name="status" class="form-control SlectBox">
                                                <option value="" selected disabled>{{__('message.orderstatus')}}</option>
                                                @foreach ($statusorder as $status)
                                                    <option value="{{ $status->id }}"> {{ $status->status }}</option>
                                                @endforeach
                                            </select>
                                            <br>
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

                <!-- delete -->
                    <div class="modal" id="modaldemo9">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content modal-content-demo">
                                <div class="modal-header">
                                    <h6 class="modal-title">{{__('message.deletee')}}</h6><button aria-label="Close" class="close" data-dismiss="modal"
                                        type="button"><span aria-hidden="true">&times;</span></button>
                                </div>
                                <form action="{{route('oneorderstatus.delete')}}" method="post">
                                    {{ method_field('delete') }}
                                    {{ csrf_field() }}
                                    <div class="modal-body">
                                        <p>{{__('message.aresuredeleting')}}</p><br>
                                        <input type="hidden" name="id" id="id">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('message.close')}}</button>
                                        <button type="submit" class="btn btn-danger">{{__('message.deletee')}}</button>
                                    </div>
                                </form>
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


    <script>
        $('#exampleModal2').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var modal = $(this)
            modal.find('.modal-body #id').val(id);
        })
    </script>

    <script>
        $('#modaldemo9').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var modal = $(this)
            modal.find('.modal-body #id').val(id);
        })
    </script>

@endsection
