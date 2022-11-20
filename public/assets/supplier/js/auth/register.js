$(document).ready(function () {
    $('.select2').select2();
    $("#frm_register").submit(function (e) {
        e.preventDefault();
        $('.btn-loading').prop('disabled', true);
        $('.btn-loading').html('<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Loading...');
        $.ajax({
            type: 'post',
            url: $('#frm_register').attr('action'),
            data: $("#frm_register").serialize(),
            success: function (data) {
                $('#register_error').addClass('d-none');
                $('.btn-loading').prop('disabled', false);
                $('.btn-loading').html('Register');
                if (data.status_code == 201) {
                    toastr["success"]("Rgistered Successfully.");
                    window.location.href = app_url + '/supplier/verify/'+$("input[name='email']").val();
                }
            },
            error: function (xhr) {
                $('#register_error').removeClass('d-none');
                $('.btn-loading').prop('disabled', false);
                $('.btn-loading').html('Register');
                if (xhr.status == 422) {
                    $('#register_error').addClass('d-none');
                    var res = jQuery.parseJSON(xhr.responseText);
                    if (res.error == 'validation') {
                        var messageLength = res.message.length;
                        for (var i = 0; i < messageLength; i++) {
                            for (const [key, value] of Object.entries(res.message[i])) {
                                if (value) {
                                    $('div.error').show();
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