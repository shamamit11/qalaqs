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
                        window.location.href = "{{ route('admin-brand') }}";
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
</script>
<script>
    $("#button-image").click(function(e) {
        e.preventDefault();
        inputId = 'image';
        window.open('/file-manager/fm-button', 'fm', 'width=1200,height=700');
    });

    let inputId = '';

    function fmSetLink($url) {
        $("#" + inputId).val($url);
        $("#" + inputId + "_link").attr("src", $url);
    }
</script>
