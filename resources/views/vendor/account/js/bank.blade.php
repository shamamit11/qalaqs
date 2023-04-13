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
                    $('.btn-loading').html('Update Information');
                    if (data.status_code == 201) {
                        toastr["success"]("Updated Successfully.");
                        window.location.href = "{{route('vendor-account-bank')}}";
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
