<script>
    $(document).ready(function() {
        $('.switch-status').change(function() {
            if ($(this).attr('data-status-value') == 0) {
                var val = 1;
            } else {
                var val = 0;
            }
            $(this).attr("data-status-value", val);
            var id = $(this).attr('data-id');
            $.ajax({
                url: '{{ route('admin-product-status') }}',
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
