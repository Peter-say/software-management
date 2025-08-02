@extends('dashboard.layouts.app')

@section('contents')
    <div class="content-body">
        <div class="container-fluid">

            <!-- Breadcrumb -->
            <div class="row page-titles">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard.home') }}">Home</a></li>
                    <li class="breadcrumb-item "><a href="{{route('dashboard.payments.overview')}}">Overview</a></li>
                     <li class="breadcrumb-item active"><a href="#">List</a></li>
                </ol>
            </div>

            <!-- Filter and Search -->
            <div class="d-flex justify-content-between mb-4">
                <form id="filter-form" class="d-flex gap-2" onsubmit="return false;">
                    <input type="text" class="form-control" name="search"
                        placeholder="Search transaction or description" value="{{ request()->search }}" />
                    <select name="selection" class="form-select">
                        <option value="">-- Filter --</option>
                        <option value="Newest" {{ request()->selection == 'Newest' ? 'selected' : '' }}>Newest</option>
                        <option value="Oldest" {{ request()->selection == 'Oldest' ? 'selected' : '' }}>Oldest</option>
                        <option value="Highest" {{ request()->selection == 'Highest' ? 'selected' : '' }}>Highest</option>
                        <option value="Lowest" {{ request()->selection == 'Lowest' ? 'selected' : '' }}>Lowest</option>
                        <option value="Paid" {{ request()->selection == 'Paid' ? 'selected' : '' }}>Paid</option>
                        <option value="Pending" {{ request()->selection == 'Pending' ? 'selected' : '' }}>Pending</option>
                    </select>
                </form>
                <div id="total-amount" class="text-end">
                    <strong>Total Amount:</strong> ₦{{ number_format($totalAmount, 2) }}
                </div>
            </div>

            <!-- Payment Table -->
            <div class="card">
                <div class="card-body p-0">
                    @include('dashboard.hotel.finance.payment.search', ['payments' => $payments])
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            function fetchPayments(url = "{{ route('dashboard.payments.list') }}") {
                $.ajax({
                    url: url,
                    type: "GET",
                    data: $('#filter-form').serialize(),
                    beforeSend: function() {
                        $('#payment-table-wrapper').html(
                            '<div class="text-center p-4">Loading...</div>');
                    },
                    success: function(response) {
                        $('#payment-table-wrapper').replaceWith(response.html);
                         $('#total-amount').html(response.totalAmount);
                    },
                    error: function() {
                        $('#payment-table-wrapper').html(
                            '<div class="text-center text-danger p-4">Failed to load payments.</div>'
                        );
                    }
                });
            }

            // Typing in search box
            $('#filter-form input[name="search"]').on('keyup', function() {
                clearTimeout($.data(this, 'timer'));
                const wait = setTimeout(() => fetchPayments(), 500);
                $(this).data('timer', wait);
            });

            // Selection dropdown
            $('#filter-form select[name="selection"]').on('change', function() {
                fetchPayments();
            });

            // Pagination click
            $(document).on('click', '#payment-table-wrapper .pagination a', function(e) {
                e.preventDefault();
                const url = $(this).attr('href');
                fetchPayments(url);
            });
        });
    </script>
@endsection
