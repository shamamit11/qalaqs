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
                                    <div class="mb-3">
                                        <label class="form-label"> Image</label>
                                        <br>
                                        <input type="file" name="file_image" onchange="encodeImgtoBase64(this)">
                                        <input name="image" type="hidden" id="image" />
                                        <div>
                                            @if($row && $row->image)
                                            <div style="margin:5px 0 0 0;"> <img
                                                    src="{{ asset('/storage/banner/'.$row->image)}}" id="displayImg"
                                                    height="150">
                                            </div>
                                            @else
                                            <div style="margin:5px 0 0 0;"> <img
                                                    src="{{ asset('/assets/admin/images/browser.png')}}" id="displayImg"
                                                    height="150">
                                            </div>
                                            @endif
                                            <div style="margin:5px 0 0 0;"
                                                class="{{ ($row && $row->image) ? 'd-block' : 'd-none' }}"
                                                id='btn_image_delete'>
                                                <button type="button" class="btn btn-xs btn-danger"
                                                    Onclick="confirmDelete('image')">Delete Image</button>
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
    <script src="{{ asset('assets/admin/js/banner/add.js') }}"></script>
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
                        url: '{{ route("admin-banner-imagedelete")}}',
                        type: 'POST',
                        data: {
                            'id': '{{ @$row->id }}',
                            'field_name': field_name,
                            '_token': '{{ csrf_token() }}'
                        },
                        success: function() {
                            $("#displayImg").attr("src",
                                "{{ asset('/assets/admin/images/browser.png')}}");
                            $("#btn_image_delete").addClass('d-none');
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
