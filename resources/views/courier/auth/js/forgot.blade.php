<script>
$(document).ready(function() {
    $("#frm_forgot").submit(function(e) {
        e.preventDefault();
        $('.btn-loading').prop('disabled', true)
        $('.btn-loading').html(
            '<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Loading...'
        );
        $.ajax({
            type: 'post',
            url: $('#frm_forgot').attr('action'),
            data: $("#frm_forgot").serialize(),
            success: function(data) {
                $('.btn-loading').prop('disabled', false);
                $('.btn-loading').html('Reset Password');
                if (data.status_code == 200) {
                    toastr["success"]("We have emailed your password reset link!.");
                    window.location.href = "{{route('courier-login')}}";
                }
            },
            error: function(xhr) {
                $('.btn-loading').prop('disabled', false);
                $('.btn-loading').html('Reset Password');
                if (xhr.status == 422) {
                    var res = $.parseJSON(xhr.responseText);
                    if (res.error == 'validation') {
                        toastr["error"]("Please check required field.");
                        var messageLength = res.message.length;
                        for (var i = 0; i < messageLength; i++) {
                            for (const [key, value] of Object.entries(res.message[i])) {
                                if (value) {
                                    $('#'+key).addClass('inputerror');
                                    $('#error_'+ key).show();
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

$("input").change(function(e){
    var inputId = $(this).attr("id");
    $("#"+inputId).removeClass('inputerror');
});
</script>