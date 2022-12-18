<script>
$(document).ready(function() {
    $("#frm_forgot").submit(function(e) {
        e.preventDefault();
        $('.btn-loading').prop('disabled', true)
        $('.btn-loading').html('<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Loading...');
        $.ajax({
            type: 'post',
            url: $('#frm_forgot').attr('action'),
            data: $("#frm_forgot").serialize(),
            success: function(data) {
                $('.btn-loading').prop('disabled', false);
                $('.btn-loading').html('Reset Password');
                if (data.status_code == 200) {
                    toastr["success"]("We have emailed your password reset link!.");
                    window.location.href = app_url + '/admin/login';
                }
            },
            error: function(xhr) {
                $('.btn-loading').prop('disabled', false);
                $('.btn-loading').html('Reset Password');
                if (xhr.status == 422) {
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