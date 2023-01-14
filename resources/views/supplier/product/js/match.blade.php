<script>
$(document).ready(function() {
    var addButton = $('.add_button');
    var wrapper = $('.field_wrapper');
    var fieldHTML ='<div class="mb-1 input-group input-match input-group-merge"><select name="engine_id[]" class="select2 form-control">@if ($engines->count() > 0)@foreach ($engines as $engine)<option value="{{ $engine->id }}">{{ $engine->make->name }} / {{ $engine->model->name }} / {{ $engine->year->name }} / {{ $engine->name }}</option>@endforeach @endif </select><span class="input-group-btn input-group-append"><input type="hidden" name="match_id[]" value="0" class="form-control"><button class="btn btn-danger bootstrap-touchspin-up remove_button" type="button">-</button></span></div>';
    $(addButton).click(function() {
        $(wrapper).append(fieldHTML);
    });

    $(wrapper).on('click', '.remove_button', function(e) {
        e.preventDefault();
        let match_id = $(this).siblings('input[name="match_id[]"]').val();
        if (match_id > 0) {
            $.ajax({
                type: 'delete',
                url: "{{ route('supplier-product-match-delete') }}",
                data: {
                    'match_id': match_id,
                    '_token': '{{ csrf_token() }}'
                },
                success: function(data) {
                        toastr["success"]('Data deleted');
                        let product_id = $('input[name="product_id"]').val();
                        $('[data-bs-target="#matcheModal"][data-id="' + product_id +
                            '"]').click();
                },
            });
        }
        $(this).parents('.input-match').remove();
    });

    $("#frm_match").submit(function(e) {
        e.preventDefault();
        $('.btn-loading').prop('disabled', true)
        $('.btn-loading').html(
            '<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Loading...'
        );
        $.ajax({
            type: 'post',
            url: $('#frm_match').attr('action'),
            data: $("#frm_match").serialize(),
            success: function(data) {
                $('.btn-loading').prop('disabled', false);
                $('.btn-loading').html('Submit');
                if (data.status_code == 201) {
                    $(".error").hide();
                    toastr["success"](data.message);
                    let product_id = $('input[name="product_id"]').val();
                    $('[data-bs-target="#matcheModal"][data-id="' + product_id +
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