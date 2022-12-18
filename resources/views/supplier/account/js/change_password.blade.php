<script>
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
                $('.btn-loading').html('Change password');
                if (data.status_code == 200) {
                    toastr["success"]("Changed password successfully.");
                    window.location.href = app_url + '/supplier/logout';
                }
            },
            error: function(xhr) {
                $('.btn-loading').prop('disabled', false);
                $('.btn-loading').html('Change password');
                if (xhr.status == 401) {
                    toastr["error"]("Invalid password");
                } else if (xhr.status == 422) {
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