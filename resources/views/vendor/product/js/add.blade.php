<script src="{{ asset('assets/libs/chained/jquery.chained.min.js') }}"></script>
<script>
    function mainImageBrowser(element) {
        var img = element.files[0];
        var reader = new FileReader();
        reader.onloadend = function() {
            $("#btn_main_image_delete").removeClass('d-none');
            $("#main_image").val(reader.result);
            $("#displayMainImage").attr("src", reader.result);
        }
        reader.readAsDataURL(img);
    }

    function image01ImageBrowser(element) {
        var img = element.files[0];
        var reader = new FileReader();
        reader.onloadend = function() {
            $("#btn_image_01_delete").removeClass('d-none');
            $("#image_01").val(reader.result);
            $("#displayImage01").attr("src", reader.result);
        }
        reader.readAsDataURL(img);
    }

    function image02ImageBrowser(element) {
        var img = element.files[0];
        var reader = new FileReader();
        reader.onloadend = function() {
            $("#btn_image_02_delete").removeClass('d-none');
            $("#image_02").val(reader.result);
            $("#displayImage02").attr("src", reader.result);
        }
        reader.readAsDataURL(img);
    }

    function image03ImageBrowser(element) {
        var img = element.files[0];
        var reader = new FileReader();
        reader.onloadend = function() {
            $("#btn_image_03_delete").removeClass('d-none');
            $("#image_03").val(reader.result);
            $("#displayImage03").attr("src", reader.result);
        }
        reader.readAsDataURL(img);
    }

    function image04ImageBrowser(element) {
        var img = element.files[0];
        var reader = new FileReader();
        reader.onloadend = function() {
            $("#btn_image_04_delete").removeClass('d-none');
            $("#image_04").val(reader.result);
            $("#displayImage04").attr("src", reader.result);
        }
        reader.readAsDataURL(img);
    }

    function confirmDelete(field_name, data_val, img_id, btn_id) {
        if(data_val) {
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
                        url: '{{ route('vendor-product-imagedelete') }}',
                        type: 'POST',
                        data: {
                            'id': '{{ @$user->id }}',
                            'field_name': field_name,
                            '_token': '{{ csrf_token() }}'
                        },
                        success: function() {
                            $("#"+btn_id).addClass('d-none');
                            $("#"+img_id).attr("src", "{{ asset('/assets/admin/images/browser.png')}}");
                            $("#"+field_name).val('');
                            toastr["success"]('Data deleted.');
                        }
                    });
                } 
                else if (result.dismiss === Swal.DismissReason.cancel) {
                    toastr["error"]('Cancelled.');
                }
            })
        } 
        else {
            $("#"+field_name).val('');
            $("#"+btn_id).addClass('d-none');
            $("#"+img_id).attr("src", "{{ asset('/assets/admin/images/browser.png')}}");
        }
    }
</script>
<script>
    $(document).ready(function() {
        $('.select2').select2();
        $(".selectize").selectize();
        $("#model_id").chained("#make_id");
        //$("#year_id").chained("#model_id");
        //$("#engine_id").chained("#year_id");
        $("#subcategory_id").chained("#category_id");
    });

    $("#subcategory_id").change(function(e) {
        var subcategory_id = $(this).val();

        $.ajax({
            url: '{{ route('vendor-subcategory-by-id') }}',
            type: 'GET',
            data: {
                'id': subcategory_id,
            },
            success: function(res) {
                //console.log(res?.data?.name);
                $("#title").val(res?.data?.name);
            }
        });
    });
</script>

<script>
    $('.delete-match-btn').click(function() {
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
                        url: '{{ route('vendor-product-match-delete') }}',
                        type: 'POST',
                        data: {
                            'id': id,
                            '_token': '{{ csrf_token() }}'
                        },
                        success: function() {
                            $("#tr" + id).remove();
                            toastr["success"]('Your data has been deleted.');
                            // setTimeout(function() {
                            //     location.reload();
                            // }, 500);
                        }
                    });
                } else if (
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    toastr["error"]('Cancelled.');
                }
            })
        });
</script>
<script>
    $(document).ready(function() {
        $("#form").submit(function(e) {
            e.preventDefault();
            $('.btn-loading').prop('disabled', true)
            $('.btn-loading').html(
                '<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Loading...'
            );
            $.ajax({
                type: 'post',
                url: $('#form').attr('action'),
                data: $("#form").serialize(),
                success: function(data) {
                    $('.btn-loading').prop('disabled', false);
                    $('.btn-loading').html('Submit');
                    if (data.status_code == 201) {
                        toastr["success"](data.message);
                        window.location.href = "{{ route('vendor-product') }}";
                    }
                },
                error: function(xhr) {
                    $('.btn-loading').prop('disabled', false);
                    $('.btn-loading').html('Submit');
                    if (xhr.status == 422) {
                        var res = jQuery.parseJSON(xhr.responseText);
                        if (res.error == 'validation') {
                            toastr["error"]("Please check required field.");
                            var messageLength = res.message.length;
                            for (var i = 0; i < messageLength; i++) {
                                for (const [key, value] of Object.entries(res.message[i])) {
                                    if (value) {
                                        $('#' + key).addClass('inputerror');
                                        $('#error_' + key).show();
                                        $('#error_' + key).text(value);
                                    }
                                }
                            }
                        }
                    }
                }
            });
        });
    });

    $("input").change(function(e) {
        var inputId = $(this).attr("id");
        $("#" + inputId).removeClass('inputerror');
    });
</script>