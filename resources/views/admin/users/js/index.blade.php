<script>
    $(document).ready(function() {
        $('.switch-admin_approved').change(function() {
            if ($(this).attr('data-admin_approved-value') == 0) {
                var val = 1;
            } else {
                var val = 0;
            }
            $(this).attr("data-admin_approved-value", val);
            var id = $(this).attr('data-id');
            $.ajax({
                url: '{{ route('admin-vendor-status') }}',
                type: 'POST',
                data: {
                    'id': id,
                    'val': val,
                    'field_name': 'admin_approved',
                    '_token': '{{ csrf_token() }}'
                },
            });
        });
    });
</script>
