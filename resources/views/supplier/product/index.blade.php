@extends('supplier.layout')
@section('content')
<div class="content-page">
    <div class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h3>Product Management</h3>
                                <nav class="navbar navbar-light">
                                    <form method="get" class="d-flex">
                                        <div class="input-group"> @csrf
                                            <input type="text" name="q" value="{{ @$q }}" class="form-control"
                                                placeholder="Search">
                                            <button class="btn btn-success my-2 my-sm-0" type="submit"><i
                                                    class="align-middle" data-feather="search"></i></button>
                                        </div>
                                    </form>
                                    <a href="{{route('supplier-product-add')}}"
                                        class="btn btn-primary my-2 my-sm-0 ms-1">
                                        Add</a>
                                </nav>
                            </div>
                            <div class="card-body">
                                @if($products->count() > 0)
                                <table class="table">
                                    <thead class="table-light">
                                        <tr>
                                            <th width="50">#</th>
                                            <th>Sku</th>
                                            <th>Name</th>
                                            <th> Specification</th>
                                            <th> Matches</th>
                                            <th> Images</th>
                                            <th width="200">Status</th>
                                            <th style="text-align:center" width="120">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($products as $product)
                                        <tr id="tr{{ $product->id }}">
                                            <td>{{ $count++ }}</td>
                                            <td>{{ $product->sku }}</td>
                                            <td>{{ $product->name }}</td>
                                            <td><a type="button" class="btn btn-primary" data-id=" {{ $product->id}}"
                                                    data-bs-toggle="modal" data-bs-target="#specificationModal">
                                                    {{ count($product->specifications) }} Specification</a></td>
                                            <td><a type="button" class="btn btn-primary" data-id=" {{ $product->id}}"
                                                    data-bs-toggle="modal" data-bs-target="#matchModal">
                                                    {{ count($product->matches) }} Matches</a></td>
                                            <td><a type="button" class="btn btn-primary" data-id=" {{ $product->id}}"
                                                    data-bs-toggle="modal" data-bs-target="#imagesModal">
                                                    {{ count($product->images) }} Images</a></td>

                                            <td><label class="switch" style="margin: 0 auto">
                                                    <input class="switch-input switch-status" type="checkbox"
                                                        data-id="{{ $product->id }}"
                                                        data-status-value="{{ $product->status }}" @if($product->
                                                    status == 1) checked @endif /> <span class="switch-label"
                                                        data-on="Show" data-off="Hide"></span> <span
                                                        class="switch-handle"></span> </label></td>
                                            <td style="text-align:center"><a
                                                    href="{{route('supplier-product-add', ['id='.$product->id])}}"
                                                    class="btn btn-sm btn-warning rounded-pill"><i
                                                        class="fas fa-pen"></i></a>
                                                <button type="button"
                                                    class="btn btn-sm btn-danger rounded-pill delete-row-btn"
                                                    data-id="{{ $product->id }}"><span class="icon"><i
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
                                        <div class="float-end"> {{$products->links('pagination::bootstrap-4')}} </div>
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
        @include('supplier.includes.footer')
    </div>
    <div class="modal fade" id="specificationModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">

        <form enctype="multipart/form-data" method="post" action="{{route('supplier-product-addspecification')}}">
            <div class="modal-dialog  modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Product Specification</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="specification">
                        Loading
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="modal fade" id="matchModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">

        <form enctype="multipart/form-data" method="post" action="{{route('supplier-product-addmatch')}}">
            <div class="modal-dialog  modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Product Matches</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="match">
                        Loading
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="modal fade" id="imagesModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">

        <form enctype="multipart/form-data" method="post" action="{{route('supplier-product-addimages')}}">
            <div class="modal-dialog  modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Product Images</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="images">
                        Loading
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!-- <div class="modal" id="specificationModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" id="modal-content">
    <div style="width: 400px; height: 400px; vertical-align: middle; text-align: center; margin-top: 40%; margin-left: 30%">vsdfgsfsd </div>
  </div>
</div> -->
    @endsection
    @section('footer-scripts')
    <script>
    $(document).ready(function() {
        $('#specificationModal').on('show.bs.modal', function(e) {
            var product_id = $(e.relatedTarget).data('id');
            $.ajax({
                url: "{{route('supplier-product-specification')}}",
                type: 'post',
                data: {
                    'product_id': product_id,
                    '_token': '{{ csrf_token() }}'
                },
                success: function(data) {
                    $(e.currentTarget).find('#specification').html(data);
                }
            });
        });

        $('#matchModal').on('show.bs.modal', function(e) {
            var product_id = $(e.relatedTarget).data('id');
            $.ajax({
                url: "{{route('supplier-product-match')}}",
                type: 'post',
                data: {
                    'product_id': product_id,
                    '_token': '{{ csrf_token() }}'
                },
                success: function(data) {
                    $(e.currentTarget).find('#match').html(data);
                }
            });
        });

        $('#imagesModal').on('show.bs.modal', function(e) {
            var product_id = $(e.relatedTarget).data('id');
            $.ajax({
                url: "{{route('supplier-product-images')}}",
                type: 'post',
                data: {
                    'product_id': product_id,
                    '_token': '{{ csrf_token() }}'
                },
                success: function(data) {
                    $(e.currentTarget).find('#images').html(data);
                }
            });
        });

        
        $('.switch-status').change(function() {
            if ($(this).attr('data-status-value') == 0) {
                var val = 1;
            } else {
                var val = 0;
            }
            $(this).attr("data-status-value", val);
            var id = $(this).attr('data-id');
            $.ajax({
                url: '{{ route("supplier-product-status")}}',
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
                        url: '{{ route("supplier-product-delete")}}',
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