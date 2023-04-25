<script>
    function profileImageBrowser(element) {
        var img = element.files[0];
        var reader = new FileReader();
        reader.onloadend = function() {
            $("#btn_image_delete").removeClass('d-none');
            $("#image").val(reader.result);
            $("#displayImg").attr("src", reader.result);
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
                        url: '{{ route('vendor-account-imagedelete') }}',
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
            $("#"+btn_id).addClass('d-none');
            $("#"+img_id).attr("src", "{{ asset('/assets/admin/images/browser.png')}}");
            $("#"+field_name).val('');
        }
    }

    $(document).ready(function() {
        $("#form").submit(function(e) {
            e.preventDefault();
            $('.btn-loading').prop('disabled', true);
            $('.btn-loading').html(
                '<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Loading...'
            );
            $.ajax({
                type: 'post',
                url: $('#form').attr('action'),
                data: $("#form").serialize(),
                success: function(data) {
                    $('.btn-loading').prop('disabled', false);
                    $('.btn-loading').html('Update Information');
                    if (data.status_code == 201) {
                        toastr["success"]("Updated Successfully.");
                        window.location.href = "{{route('vendor-account-setting')}}";
                    }
                },
                error: function(xhr) {
                    $('.btn-loading').prop('disabled', false);
                    $('.btn-loading').html('Update Information');
                    if (xhr.status == 422) {
                        var res = jQuery.parseJSON(xhr.responseText);
                        if (res.error == 'validation') {
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
