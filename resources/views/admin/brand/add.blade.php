@extends('admin.layout')
@section('content')
<div class="content-page">
    <div class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <form enctype="multipart/form-data" method="post" action="{{$action}}" id="form">
                                    @csrf
                                    <input type="hidden" class="form-control" name="id"
                                        value="{{ isset($row->id)? $row->id : '' }}">
                                    <div class="mb-3">
                                        <label class="form-label"> Name</label>
                                        <input type="text" class="form-control" name="name"
                                            value="{{old('name' , isset($row->name)? $row->name : '' )}}">
                                        <div class="error" id='error_name'></div>
                                    </div>
                                    <div class="mb-3 col-4">
                                        <label class="form-label"> Image</label>
                                        <div class="drag-container">
                                            <button type="button" class="btn btn-xs btn-danger {{ ($row && $row->image) ? 'd-block' : 'd-none' }}"
                                                Onclick="confirmDelete('image')" id="btn_image_delete">Remove</button>
                                            <div class="drag-area">
                                                <div class="dropify-message {{ ($row && $row->image) ? 'd-none' : 'd-block' }}"><svg xmlns="http://www.w3.org/2000/svg"
                                                        xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1"
                                                        id="Layer_1" x="0px" y="0px" width="64px" height="64px"
                                                        viewBox="0 0 64 64" enable-background="new 0 0 64 64"
                                                        xml:space="preserve">
                                                        <path fill="none" stroke="#8a8a8a" stroke-width="2"
                                                            stroke-miterlimit="10"
                                                            d="M41,50h14c4.565,0,8-3.582,8-8s-3.435-8-8-8  c0-11.046-9.52-20-20.934-20C23.966,14,14.8,20.732,13,30c0,0-0.831,0-1.667,0C5.626,30,1,34.477,1,40s4.293,10,10,10H41" />
                                                        <polyline fill="none" stroke="#8a8a8a" stroke-width="2"
                                                            stroke-linejoin="bevel" stroke-miterlimit="10"
                                                            points="23.998,34   31.998,26 39.998,34 " />
                                                        <g>
                                                            <line fill="none" stroke="#8a8a8a" stroke-width="2"
                                                                stroke-miterlimit="10" x1="31.998" y1="26" x2="31.998"
                                                                y2="46" />
                                                        </g>
                                                    </svg>
                                                    <p>Drag and drop a file here or click</p>
                                                </div>
                                                <input type="file" hidden="" />
                                                <input name="image" type="hidden" id="image" />
                                                <div class="image-preview"> @if($row && $row->image)  <img
                                                        src="{{ Storage::disk('public')->url('brand/'.$row->image)}}"
                                                        id="displayImg"> @else <img src="" id="displayImg"
                                                        class="d-none">
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <div class="row">
                                            <div class="col-md-6 col-sm-6 col-xs-6">
                                                <label class="form-label">Order By</label>
                                                <input type="text" class="form-control" name="order"
                                                    value="{{old('order' , isset($row->order) ? $row->order : $order)}}">
                                                <div class="error" id='error_order'></div>
                                            </div>
                                            <div class="col-md-6 col-sm-6 col-xs-6">
                                                <label class="form-label">Status</label>
                                                <label class="switch">
                                                    <input type="checkbox" class="switch-input" name="status" value="1" {{ ((isset($row->
                status) && $row->status == 1) ||  !isset($row->status))? 'checked' : '' }} /> <span
                                                        class="switch-label" data-on="Show" data-off="Hide"></span>
                                                    <span class="switch-handle"></span> </label>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary  btn-loading">Submit</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('admin.includes.footer')
    </div>
    @endsection
    @section('footer-scripts')

    <script src="{{ asset('assets/admin/js/brand/add.js') }}"></script>
    <script>
    $().ready(function() {
        //to delete
        confirmDelete = function(field_name) {
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
            })
            swalWithBootstrapButtons.fire({
                title: 'Are you sure?',
                text: "",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes',
                cancelButtonText: 'No',
                reverseButtons: false
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{ route("admin-brand-imagedelete")}}',
                        type: 'POST',
                        data: {
                            'id': '{{ @$row->id }}',
                            'field_name': field_name,
                            '_token': '{{ csrf_token() }}'
                        },
                        success: function() {
                            $("#btn_image_delete").addClass('d-none');
                            $("#displayImg").addClass('d-none');
                            $(".dropify-message").removeClass('d-none').addClass('d-block');
                            $("#displayImg").attr("src", '');
                            $("#image").val('');
                            swalWithBootstrapButtons.fire(
                                'Deleted!',
                                'Your data has been deleted.',
                                'success'
                            );
                        }
                    });
                } else if (
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    swalWithBootstrapButtons.fire(
                        'Cancelled',
                        '',
                        'error'
                    )
                }
            })
        }

    });
    </script>
    @endsection