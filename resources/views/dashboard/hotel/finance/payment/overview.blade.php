@extends('dashboard.layouts.app')

@section('contents')
    <div class="content-body">
        <div class="container-fluid">
            <!-- Page Breadcrumb -->
            <div class="row page-titles">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active"><a href="{{ route('dashboard.home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Payments Overview</a></li>
                </ol>
            </div>
            <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
                <div>
                    {{-- <p class="fw-semibold fs-18 mb-0">Welcome back, {{ auth()->user()?->name }}</p> --}}
                </div>
                <div class="d-flex justify-content-end">
                    <form method="GET" action="{{ route('dashboard.payments.overview') }}" class="d-inline">
                        <div>
                            <div class="dropdown">
                                <button type="button" class="btn btn-primary btn-sm btn-wave waves-effect waves-light me-2"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    Sort Stats By {{ ucfirst($period ?? 'Day') }}<i
                                        class="ri-arrow-down-s-line align-middle ms-1 d-inline-block"></i>
                                </button>
                                <ul class="dropdown-menu" role="menu" id="filter-period">
                                    <li><a class="dropdown-item" href="#" data-period="day">Day</a></li>
                                    <li><a class="dropdown-item" href="#" data-period="week">Week</a></li>
                                    <li><a class="dropdown-item" href="#" data-period="month">Month</a>
                                    </li>
                                    <li><a class="dropdown-item" href="#" data-period="year">Year</a></li>
                                </ul>
                            </div>

                        </div>
                        <!-- Hidden input to capture selected period -->
                        <input type="hidden" name="chart_period" id="chart-selected-period"
                            value="{{ request('chart_period', 'day') }}">
                    </form>
                    <div class="d-flex align-items-center mb-2">
                        <a href="{{ route('dashboard.hotel.payments.list') }}" class="btn btn-primary me-2">
                            View List</a>
                    </div>

                </div>
            </div>
            <div class="row">
                <div class="col-xxl-12 col-xl-12 col-md-12 col-sm-12">
                    <div class="row" id="cards-container">
                        @foreach ($payment_stats['cards'] as $index => $card)
                            <div class="col-xl-6 col-md-6 col-sm-12 mb-4">
                                <div class="card booking">
                                    <div class="card-body">
                                        <div class="booking-status d-flex align-items-center">
                                            <span>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28"
                                                    viewBox="0 0 28 28">
                                                    <path
                                                        d="M129.035,178.842v2.8a5.6,5.6,0,0,0,5.6,5.6h14a5.6,5.6,0,0,0,5.6-5.6v-16.8a5.6,5.6,0,0,0-5.6-5.6h-14a5.6,5.6,0,0,0-5.6,5.6v2.8a1.4,1.4,0,0,0,2.8,0v-2.8a2.8,2.8,0,0,1,2.8-2.8h14a2.8,2.8,0,0,1,2.8,2.8v16.8a2.8,2.8,0,0,1-2.8,2.8h-14a2.8,2.8,0,0,1-2.8-2.8v-2.8a1.4,1.4,0,0,0-2.8,0Zm10.62-7-1.81-1.809a1.4,1.4,0,1,1,1.98-1.981l4.2,4.2a1.4,1.4,0,0,1,0,1.981l-4.2,4.2a1.4,1.4,0,1,1-1.98-1.981l1.81-1.81h-12.02a1.4,1.4,0,1,1,0-2.8Z"
                                                        transform="translate(-126.235 -159.242)" fill="var(--primary)"
                                                        fill-rule="evenodd" />
                                                </svg>
                                            </span>
                                            <div class="ms-4">
                                                <h2 class="mb-0 font-w600">{{ $card['value'] }}</h2>
                                                <p class="mb-0">{{ $card['title'] }}</p>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-end">
                                            <p class="mb-0 ms-auto text-end text-primary rounded">this {{ $card['period'] }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                </div>

                <div class="col-xl-12 col-lg-12 col-sm-12">
                    <div class="row">
                        <div class="col-xl-6 col-lg-6 col-sm-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Payment Status Chart</h4>
                                </div>
                                <div class="card-body">
                                    <div id="status-chart-container">
                                        <canvas id="paymentStatusPieChart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-6 col-lg-6 col-sm-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Payment Distribution Chart</h4>
                                </div>
                                <div class="card-body">
                                    <div id="distribution-chart-container">
                                        <canvas id="paymentDistributionPieChart"></canvas>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('dashboard.chart.payment.status', ['payment_stats' => $payment_stats])
@endsection
