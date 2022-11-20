$(document).ready(function () {
    $("#frm_login").submit(function (e) {
        e.preventDefault();
        $('.btn-loading').prop('disabled', true)
        $('.btn-loading').html('<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Loading...');
        $.ajax({
            type: 'post',
            url: $('#frm_login').attr('action'),
            data: $("#frm_login").serialize(),
            success: function (data) {
                $('#login_error').addClass('d-none');
                $('.btn-loading').prop('disabled', false);
                $('.btn-loading').html('Log In');
                if (data.status_code == 200 && data.data == true) {
                    toastr["success"]("Login Success.");
                    window.location.href = app_url + '/admin';
                }
            },
            error: function (xhr) {
                $('.btn-loading').prop('disabled', false);
                $('.btn-loading').html('Log In');
                if (xhr.status == 401) {
                    $('#login_error').removeClass('d-none');
                } else if (xhr.status == 422) {
                    $('#login_error').addClass('d-none');
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