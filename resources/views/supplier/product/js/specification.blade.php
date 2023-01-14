<script>
$(document).ready(function() {
    var addButton = $('.add_button');
    var wrapper = $('.field_wrapper');
    var fieldHTML =
        '<div class="row mb-1 input-specification"><div class="col-md-5 col-sm-5 col-xs-5"><input type="text" name="specification_name[]" class="form-control"><div class="error" id="error_specification_name"></div></div><div class="col-md-5 col-sm-5 col-xs-5"><input type="text" name="specification_value[]" class="form-control"><div class="error" id="error_specification_value"></div></div><div class="col-md-2 col-sm-2 col-xs-2"><span class="input-group-btn input-group-append"><span class="input-group-btn input-group-append"><input type="hidden" name="specification_id[]" value="0" class="form-control"><button class="btn btn-danger bootstrap-touchspin-up remove_button" type="button">-</button></span></div></div>';
    $(addButton).click(function() {
        $(wrapper).append(fieldHTML);
    });

    $(wrapper).on('click', '.remove_button', function(e) {
        e.preventDefault();
        let specification_id = $(this).siblings('input[name="specification_id[]"]').val();
        if (specification_id > 0) {
            $.ajax({
                type: 'delete',
                url: "{{ route('supplier-product-specification-delete') }}",
                data: {
                    'specification_id': specification_id,
                    '_token': '{{ csrf_token() }}'
                },
                success: function(data) {
                        toastr["success"]('Data deleted');
                        let product_id = $('input[name="product_id"]').val();
                        $('[data-bs-target="#specificationeModal"][data-id="' + product_id +
                            '"]').click();
                },
            });
        }
        $(this).parents('.input-specification').remove();
    });

    $("#frm_specification").submit(function(e) {
        e.preventDefault();
        $('.btn-loading').prop('disabled', true)
        $('.btn-loading').html(
            '<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Loading...'
        );
        $.ajax({
            type: 'post',
            url: $('#frm_specification').attr('action'),
            data: $("#frm_specification").serialize(),
            success: function(data) {
                $('.btn-loading').prop('disabled', false);
                $('.btn-loading').html('Submit');
                if (data.status_code == 201) {
                    $(".error").hide();
                    toastr["success"](data.message);
                    let product_id = $('input[name="product_id"]').val();
                    $('[data-bs-target="#specificationeModal"][data-id="' + product_id +
                        '"]').click();
                }
            },
            error: function(xhr) {
                $('.btn-loading').prop('disabled', false);
                $('.btn-loading').html('Submit');
                if (xhr.status == 422) {
                    var res = $.parseJSON(xhr.responseText);
                    if (res.error == 'validation') {
                        var messageLength = res.message.length;
                        for (var i = 0; i < messageLength; i++) {
                            for (const [key, value] of Object.entries(res.message[i])) {
                                if (value) {
                                    $('div.error').show();
                                    var error_field = key.split(".");
                                    $('#error_' + error_field[0]).text(value);
                                }
                            }
                        }
                    }
                }
            }
        });
    });
});
</script>