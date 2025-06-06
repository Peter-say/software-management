<script>
    window.addEventListener('load', function() {
        @if ($message = Session::get('success_message'))
            Toastify({
                text: '{{ $message }}',
                duration: 5000,
                gravity: 'top',
                position: 'right',
                backgroundColor: 'linear-gradient(to right, #00b09b, #96c93d)',
            }).showToast();
        @endif

        @if ($message = Session::get('error_message'))
            Toastify({
                text: '{{ $message }}',
                duration: 5000,
                gravity: 'top',
                position: 'right',
                backgroundColor: 'linear-gradient(to right, #ff5f6d, #ffc371)',
            }).showToast();
        @endif

        @if ($message = Session::get('warning_message'))
            Toastify({
                text: '{{ $message }}',
                duration: 5000,
                gravity: 'top',
                position: 'right',
                backgroundColor: 'linear-gradient(to right, #f39c12, #f1c40f)',
            }).showToast();
        @endif
    });
</script>
