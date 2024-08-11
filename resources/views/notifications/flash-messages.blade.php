<script>
    window.addEventListener('load', function() {
        @if ($message = Session::get('success_message'))
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: '{{ $message }}'
            });
        @endif

        @if ($message = Session::get('error_message'))
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: '{{ $message }}'
            });
        @endif

        @if ($message = Session::get('warning_message'))
            Swal.fire({
                icon: 'warning',
                title: 'Warning',
                text: '{{ $message }}'
            });
        @endif
    });
</script>
