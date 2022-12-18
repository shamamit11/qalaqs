<script>
$(document).ready(function() {
    $("#frm_verify").submit(function(e) {
        e.preventDefault();
        $('.btn-loading').prop('disabled', true)
        $('.btn-loading').html(
            '<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Loading...'
            );
        $.ajax({
            type: 'post',
            url: $('#frm_verify').attr('action'),
            data: $("#frm_verify").serialize(),
            success: function(data) {
                $('#verify_error').addClass('d-none');
                $('.btn-loading').prop('disabled', false);
                $('.btn-loading').html('Log In');
                if (data.status_code == 200) {
                    toastr["success"]("You are already verified.");
                    window.location.href = app_url + '/supplier/login';
                }
                if (data.status_code == 201) {
                    toastr["success"]("Verify Success.");
                    window.location.href = app_url + '/supplier/login';
                }
            },
            error: function(xhr) {
                $('.btn-loading').prop('disabled', false);
                $('.btn-loading').html('Log In');
                if (xhr.status == 401) {
                    $('#verify_error').removeClass('d-none');
                } else if (xhr.status == 422) {
                    $('#verify_error').addClass('d-none');
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
</script>