function encodeImgtoBase64(file) {
    var img = file;
    var reader = new FileReader();
    reader.onloadend = function() {
        $("#btn_image_delete").removeClass('d-none');
        $("#displayImg").removeClass('d-none');
        $("#image").val(reader.result);
        $("#displayImg").attr("src", reader.result);
        $(".dropify-message").removeClass('d-block').addClass('d-none');
    }
    reader.readAsDataURL(img);
}

$(document).ready(function () {
	
    var dropArea = document.querySelector('.drag-area');
    var input = dropArea.querySelector('input');
    dropArea.onclick = () => {
        input.click();
    };
    // when browse
    input.addEventListener('change', function() {
        file = this.files[0];
        encodeImgtoBase64(file);
    });
    // when file is inside drag area
    dropArea.addEventListener('dragover', (e) => {
        e.preventDefault();
        encodeImgtoBase64(file);
    });

    // when file is dropped
    dropArea.addEventListener('drop', (e) => {
        e.preventDefault();
        file = e.dataTransfer.files[0]; // grab single file even of user selects multiple files
        encodeImgtoBase64(file);
    });
    
    $("#form").submit(function (e) {
        e.preventDefault();
        $('.btn-loading').prop('disabled', true)
        $('.btn-loading').html('<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Loading...');
        $.ajax({
            type: 'post',
            url: $('#form').attr('action'),
            data: $("#form").serialize(),
            success: function (data) {
                $('.btn-loading').prop('disabled', false);
                $('.btn-loading').html('Submit');
                if (data.status_code == 201) {
                    toastr["success"](data.message);
                    window.location.href = app_url + '/admin/make';
                }
            },
            error: function (xhr) {
                $('.btn-loading').prop('disabled', false);
                $('.btn-loading').html('Submit');
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