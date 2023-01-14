<style>
table {
    font-family: arial, sans-serif;
    border-collapse: collapse;
    width: 100%;
}

td,
th {
    border: 1px solid #dddddd;
    text-align: left;
    padding: 8px;
}

th {
    background-color: #dddddd;
}

.even {
    background-color: #ecf6fc;
}

.odd {
    background-color: #ddeedd;
}

.myDragClass {
    background-color: yellow;
    font-size: 16pt;
}

.nodrag {
    background-color: lightblue;
}

.nodrop {
    background-color: red;
}
</style>
<script>
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
$(document).ready(function() {
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

    $("#btn_image_delete").click(function() {
        $("#btn_image_delete").addClass('d-none');
        $("#displayImg").addClass('d-none');
        $(".dropify-message").removeClass('d-none').addClass('d-block');
        $("#displayImg").attr("src", '');
        $("#image").val('');
    });

    $('.switch-is_primary').change(function() {
        if ($(this).attr('data-is_primary-value') == 0) {
            var val = 1;
        } else {
            var val = 0;
        }
        $(this).attr("data-is_primary-value", val);
        var id = $(this).attr('data-id');
        let product_id = $('input[name="product_id"]').val();
        $.ajax({
            url: '{{ route("supplier-image-status")}}',
            type: 'POST',
            data: {
                'id': id,
                'product_id': product_id,
                'val': val,
                '_token': '{{ csrf_token() }}'
            },
            success: function() {
                toastr["success"]('Data updated.');
                $('[data-bs-target="#imageModal"][data-id="' + product_id +
                    '"]').click();
            },
        });
    });

    $('.delete-image-btn').click(function() {
        const deletebtn = $(this);
        var id = $(this).data("id");
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success',
                cancelButton: 'btn btn-danger'
            },
            buttonsStyling: false
        })
        swalWithBootstrapButtons.fire({
            title: 'Are you sure?',
            text: "",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes',
            cancelButtonText: 'No',
            reverseButtons: false
        }).then((result) => {
            if (result.isConfirmed) {
                let product_id = $('input[name="product_id"]').val();
                $.ajax({
                    url: '{{ route("supplier-product-imagedelete")}}',
                    type: 'POST',
                    data: {
                        'id': id,
                        'product_id': product_id,
                        '_token': '{{ csrf_token() }}'
                    },
                    success: function() {
                        deletebtn.parents('tr').remove();
                        toastr["success"]('Data deleted.');
                        $('[data-bs-target="#imageModal"][data-id="' + product_id +
                            '"]').click();
                    }
                });
            } else if (
                result.dismiss === Swal.DismissReason.cancel
            ) {
                toastr["error"]('Cancelled.');
            }
        })
    });


    $("#frm_image").submit(function(e) {
        e.preventDefault();
        $('.btn-loading').prop('disabled', true)
        $('.btn-loading').html(
            '<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Loading...'
        );
        $.ajax({
            type: 'post',
            url: $('#frm_image').attr('action'),
            data: $("#frm_image").serialize(),
            success: function(data) {
                $('.btn-loading').prop('disabled', false);
                $('.btn-loading').html('Submit');
                if (data.status_code == 201) {
                    $("#btn_image_delete").addClass('d-none');
                    $("#displayImg").addClass('d-none');
                    $(".dropify-message").removeClass('d-none').addClass('d-block');
                    $("#displayImg").attr("src", '');
                    $("#image").val('');
                    toastr["success"](data.message);
                    let submittedProdcutID = $('input[name="product_id"]').val();
                    $('[data-bs-target="#imageModal"][data-id="' + submittedProdcutID +
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
                                    $('#error_' + key).text(value);
                                }
                            }
                        }
                    }
                }
            }
        });
    });


    var iCnt = 1;
    $("#tblData tbody tr").each(function() {
        var id = "tr" + parseInt(iCnt);
        $(this).attr("id", id);
        iCnt++;
    });
    $("#tblData").find("tr:even").addClass("even");
    $("#tblData").find("tr:odd").addClass("odd");
    $("#tblData").tableDnD({
        onDragClass: "myDragClass",
        onDrop: function(table, row) {
            $("#tblData").find("tr").removeClass("even odd");
            $("#tblData").find("tr:even").addClass("even");
            $("#tblData").find("tr:odd").addClass("odd");
            let product_id = $('input[name="product_id"]').val();
            $.ajax({
                type: 'post',
                url: $('#frm_listimage').attr('action'),
                data: $("#frm_listimage").serialize(),
                success: function(data) {
                        toastr["success"](data.message);
                        let product_id = $('input[name="product_id"]').val();
                        $('[data-bs-target="#imageModal"][data-id="' +
                        product_id +
                            '"]').click();
                },
                error: function(xhr) {
                    $('.btn-loading').prop('disabled', false);
                    $('.btn-loading').html('Submit');
                    if (xhr.status == 422) {
                        var res = $.parseJSON(xhr.responseText);
                        if (res.error == 'validation') {
                            var messageLength = res.message.length;
                            for (var i = 0; i < messageLength; i++) {
                                for (const [key, value] of Object.entries(res.message[
                                        i])) {
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

        },
    });
});
</script>