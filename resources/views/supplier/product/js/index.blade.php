
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