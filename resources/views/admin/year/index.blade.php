@extends('admin.layout')
@section('content')
<div class="content-page">
    <div class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h3>Year Management</h3>
                                <nav class="navbar navbar-light">
                                    <form method="get" class="d-flex">
                                        <div class="input-group"> @csrf
                                            <input type="text" name="q" value="{{ @$q }}" class="form-control"
                                                placeholder="Search">
                                            <button class="btn btn-success my-2 my-sm-0" type="submit"><i
                                                    class="align-middle" data-feather="search"></i></button>
                                        </div>
                                    </form>
                                    <a href="{{route('admin-year-add')}}" class="btn btn-primary my-2 my-sm-0 ms-1">
                                        Add</a>
                                </nav>
                            </div>
                            <div class="card-body">
                                @if($years->count() > 0)
                                <table class="table">
                                    <thead class="table-light">
                                        <tr>
                                            <th width="50">#</th>
                                            <th>Year</th>
                                            <th>Make</th>
                                            <th>Model</th> 
                                            <th width="200">Status</th>
                                            <th style="text-align:center" width="120">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($years as $year)
                                        <tr id="tr{{ $year->id }}">
                                            <td>{{ $count++ }}</td>
                                            <td>{{ $year->name }}</td>
                                            <td>{{ $year->make->name }}</td>
                                            <td>{{ $year->model->name }}</td>
                                            <td><label class="switch" style="margin: 0 auto">
                                                    <input class="switch-input switch-status" type="checkbox"
                                                        data-id="{{ $year->id }}"
                                                        data-status-value="{{ $year->status }}" @if($year->
                                                    status == 1) checked @endif /> <span class="switch-label"
                                                        data-on="Show" data-off="Hide"></span> <span
                                                        class="switch-handle"></span> </label></td>
                                            <td style="text-align:center"><a
                                                    href="{{route('admin-year-add', ['id='.$year->id])}}"
                                                    class="btn btn-sm btn-warning rounded-pill"><i
                                                        class="fas fa-pen"></i></a>
                                                <button type="button"
                                                    class="btn btn-sm btn-danger rounded-pill delete-row-btn"
                                                    data-id="{{ $year->id }}"><span class="icon"><i
                                                            class='fas fa-trash'></i></span></button>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="row">
                                    <div class="col-md-4 col-sm-6 col-xs-12">
                                        Showing {{ $from_data }} to {{ $to_data }} of {{ $total_data }}
                                        records.
                                    </div>
                                    <div class="col-md-8 col-sm-6 col-xs-12">
                                        <div class="float-end"> {{$years->links('pagination::bootstrap-4')}} </div>
                                    </div>
                                </div>
                                @else
                                <div class="alert alert-info" role="alert"> No data found. </div>
                                @endif
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
    <script>
    $(document).ready(function() {
        $('.switch-status').change(function() {
            if ($(this).attr('data-status-value') == 0) {
                var val = 1;
            } else {
                var val = 0;
            }
            $(this).attr("data-status-value", val);
            var id = $(this).attr('data-id');
            $.ajax({
                url: '{{ route("admin-year-status")}}',
                type: 'POST',
                data: {
                    'id': id,
                    'val': val,
                    'field_name': 'status',
                    '_token': '{{ csrf_token() }}'
                },
            });
        });
        $('.delete-row-btn').click(function() {
            var id = $(this).data("id");
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
                        url: '{{ route("admin-year-delete")}}',
                        type: 'POST',
                        data: {
                            'id': id,
                            '_token': '{{ csrf_token() }}'
                        },
                        success: function() {
                            $("#tr" + id).remove();
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
        });
    });
    </script>
    @endsection