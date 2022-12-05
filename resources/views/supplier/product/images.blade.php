<div class="mb-3">
    <div class="table-responsive">
        @csrf
        <input name="product_id" type="hidden" value="{{ $product_id }}">
        <div class="mb-3">
            <label class="form-label">Image</label>
            <br>
            <input name="image" type="file" accept="image/*" />
        </div>
        @if($images)
        @foreach($images as $image)
        <div class="mb-3">
        <div id="image{{$image->id}}">
        <img src="{{asset('/storage/product/'.$image->image)}}" style="height:200px; border-radius:10px" /> 
            <div style="margin:5px 0 0 0;">
              <button type="button" class="btn btn-xs btn-danger" Onclick="confirmDelete('{{$image->id}}')">Delete Image</button>
            </div>
          </div>
        </div>
        @endforeach
        @endif
    </div>
</div>

<script>
    $().ready(function() {
        //to delete
        confirmDelete = function(id) {
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
                        url: '{{ route("supplier-product-imagesdelete")}}',
                        type: 'POST',
                        data: {
                            'id': id,
                            '_token': '{{ csrf_token() }}'
                        },
                        success: function() {
                            $("#image"+id).remove();
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