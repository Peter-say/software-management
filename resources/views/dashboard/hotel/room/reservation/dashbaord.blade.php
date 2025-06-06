@extends('dashboard.layouts.app')

@section('contents')
    <!--**********************************
                                                       Content body start
                                                      ***********************************-->
    <div class="content-body">
        <!-- row -->
        <div class="container-fluid">
            <!-- Start::page-header -->
            <div class="row page-titles">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active"><a href="{{ route('dashboard.home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Reservation</a></li>
                </ol>
            </div>
            <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
                <div>
                    {{-- <p class="fw-semibold fs-18 mb-0">Welcome back, {{ auth()->user()?->name }}</p> --}}
                </div>
                <div class="d-flex justify-content-end align-items-center gap-2">
                    <form method="GET" action="{{ route('dashboard.hotel.reservation-dashboard') }}"
                        class="d-inline d-flex align-items-center gap-2">
                        <div class="dropdown">
                            <button type="button" class="btn btn-primary btn-sm btn-wave waves-effect waves-light"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                Sort Stats By {{ request()->period ?? 'day' }}
                                <i class="ri-arrow-down-s-line align-middle ms-1 d-inline-block"></i>
                            </button>
                            <ul class="dropdown-menu" role="menu">
                                <li><a class="dropdown-item" href="javascript:void(0);" data-period="day">Day</a></li>
                                <li><a class="dropdown-item" href="javascript:void(0);" data-period="week">Week</a></li>
                                <li><a class="dropdown-item" href="javascript:void(0);" data-period="month">Month</a></li>
                                <li><a class="dropdown-item" href="javascript:void(0);" data-period="year">Year</a></li>
                            </ul>
                        </div>

                        <!-- Hidden input to capture selected period -->
                        <input type="hidden" name="period" id="selected-period" value="{{ request('period', 'day') }}">

                        <!-- Buttons aligned horizontally -->
                        <a href="{{ route('dashboard.hotel.reservations.index') }}" class="btn btn-primary">
                            View List
                        </a>
                        <a href="{{ route('dashboard.hotel.reservations.create') }}" class="btn btn-secondary">
                            + Add New
                        </a>
                    </form>
                </div>

            </div>
            <!-- End::page-header -->
            <div class="row">
                <div class="col-xl-12">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="row">
                                {{-- <div class="col-xl-3 col-sm-6">
										<div class="card booking">
											<div class="card-body">
												<div class="booking-status d-flex align-items-center">
													<span>
														<svg xmlns="http://www.w3.org/2000/svg" width="28" height="20" viewBox="0 0 28 20">
														  <path  d="M27,14V7a1,1,0,0,0-1-1H6A1,1,0,0,0,5,7v7a3,3,0,0,0-3,3v8a1,1,0,0,0,2,0V24H28v1a1,1,0,0,0,2,0V17A3,3,0,0,0,27,14ZM7,8H25v6H24V12a2,2,0,0,0-2-2H19a2,2,0,0,0-2,2v2H15V12a2,2,0,0,0-2-2H10a2,2,0,0,0-2,2v2H7Zm12,6V12h3v2Zm-9,0V12h3v2ZM4,17a1,1,0,0,1,1-1H27a1,1,0,0,1,1,1v5H4Z" transform="translate(-2 -6)" fill="var(--primary)"/>
														</svg>
													</span>
													<div class="ms-4">
														<h2 class="mb-0 font-w600">8,461</h2>
														<p class="mb-0 text-nowrap">New Booking</p>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="col-xl-3 col-sm-6">
										<div class="card booking">
											<div class="card-body">
												<div class="booking-status d-flex align-items-center">
													<span>
														<svg xmlns="http://www.w3.org/2000/svg" width="28" height="20" viewBox="0 0 28 20">
														  <path  d="M27,14V7a1,1,0,0,0-1-1H6A1,1,0,0,0,5,7v7a3,3,0,0,0-3,3v8a1,1,0,0,0,2,0V24H28v1a1,1,0,0,0,2,0V17A3,3,0,0,0,27,14ZM7,8H25v6H24V12a2,2,0,0,0-2-2H19a2,2,0,0,0-2,2v2H15V12a2,2,0,0,0-2-2H10a2,2,0,0,0-2,2v2H7Zm12,6V12h3v2Zm-9,0V12h3v2ZM4,17a1,1,0,0,1,1-1H27a1,1,0,0,1,1,1v5H4Z" transform="translate(-2 -6)" fill="var(--primary)"/>
														</svg>
													</span>
													<div class="ms-4">
														<h2 class="mb-0 font-w600">{{$today_reserved_room_count}}</h2>
														<p class="mb-0 text-nowrap ">Today Booking</p>
													</div>
												</div>
											</div>
										</div>
									</div> --}}
                                @foreach ($room_reservation_stats['cards'] as $index => $card)
                                    <div class="col-xl-3 col-sm-6">
                                        <div class="card booking">
                                            <div class="card-body">
                                                <div class="booking-status d-flex align-items-center">
                                                    <span>
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="28"
                                                            height="28" viewBox="0 0 28 28">
                                                            <path data-name="Path 1957"
                                                                d="M129.035,178.842v2.8a5.6,5.6,0,0,0,5.6,5.6h14a5.6,5.6,0,0,0,5.6-5.6v-16.8a5.6,5.6,0,0,0-5.6-5.6h-14a5.6,5.6,0,0,0-5.6,5.6v2.8a1.4,1.4,0,0,0,2.8,0v-2.8a2.8,2.8,0,0,1,2.8-2.8h14a2.8,2.8,0,0,1,2.8,2.8v16.8a2.8,2.8,0,0,1-2.8,2.8h-14a2.8,2.8,0,0,1-2.8-2.8v-2.8a1.4,1.4,0,0,0-2.8,0Zm10.62-7-1.81-1.809a1.4,1.4,0,1,1,1.98-1.981l4.2,4.2a1.4,1.4,0,0,1,0,1.981l-4.2,4.2a1.4,1.4,0,1,1-1.98-1.981l1.81-1.81h-12.02a1.4,1.4,0,1,1,0-2.8Z"
                                                                transform="translate(-126.235 -159.242)"
                                                                fill="var(--primary)" fill-rule="evenodd" />
                                                        </svg>
                                                    </span>
                                                    <div class="ms-4">
                                                        <h2 class="mb-0 font-w600">{{ $card['value'] }}</h2>
                                                        <p class="mb-0">{{ $card['title'] }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                            </div>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-sm-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Revenue Chart</h4>
                                    <div class="d-flex d-md-flex d-block align-items-center justify-content-end">
                                        <form method="GET" action="{{ route('dashboard.hotel.reservation-dashboard') }}"
                                            class="d-inline">
                                            <div>
                                                <div class="dropdown">
                                                    <button type="button"
                                                        class="btn btn-primary btn-sm btn-wave waves-effect waves-light  me-2"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                        Sort Chart By {{ ucfirst(request()->analytic_period ?? 'month') }}<i
                                                            class="ri-arrow-down-s-line align-middle ms-1 d-inline-block"></i>
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-custom" role="menu">
                                                        <li><a class="analytic-dropdown-item" href="javascript:void(0);"
                                                                data-analytic-period="day">Day</a></li>
                                                        <li><a class="analytic-dropdown-item" href="javascript:void(0);"
                                                                data-analytic-period="week">Week</a></li>
                                                        <li><a class="analytic-dropdown-item" href="javascript:void(0);"
                                                                data-analytic-period="month">Month</a></li>
                                                        <li><a class="analytic-dropdown-item" href="javascript:void(0);"
                                                                data-analytic-period="year">Year</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <!-- Hidden input to capture selected period -->
                                            <input type="hidden" name="analytic_period" id="analytic-selected-period"
                                                value="{{ request('analytic_period', 'month') }}">
                                        </form>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <canvas id="revenueChart"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-12">
                            <div class="row">
                                @include('dashboard.fragments.dashboard.recent-booking-schedule', [
                                    'recent_room_reservations' => $recent_room_reservations,
                                ])
                                <div class="col-xl-6">
                                    <div class="row">
                                        <div class="col-xl-12">
                                            <div class="card">
                                                <div class="card-header border-0 flex-wrap">
                                                    <h4 class="fs-20">Reservation Stats</h4>
                                                    <div
                                                        class="d-md-flex d-block align-items-center justify-content-end my-4">

                                                        <form method="GET"
                                                            action="{{ route('dashboard.hotel.reservation-dashboard') }}"
                                                            class="d-inline">
                                                            <div class="dropdown">
                                                                <button type="button"
                                                                    class="btn btn-primary btn-sm btn-wave waves-effect waves-light"
                                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                                    Sort By {{ request()->booking_period ?? 'week' }}<i
                                                                        class="ri-arrow-down-s-line align-middle ms-1 d-inline-block"></i>
                                                                </button>
                                                                <ul class="dropdown-menu" role="menu">
                                                                    <li><a class="dropdown-item dropdown-item-booking-stats"
                                                                            href="javascript:void(0);"
                                                                            data-booking-period="week">Week</a></li>
                                                                    <li><a class="dropdown-item dropdown-item-booking-stats"
                                                                            href="javascript:void(0);"
                                                                            data-booking-period="year">Year</a></li>
                                                                </ul>
                                                            </div>

                                                            <!-- Hidden input to capture selected period -->
                                                            <input type="hidden" name="booking_period"
                                                                id="booking-selected-period"
                                                                value="{{ request('booking_period', 'week') }}">
                                                        </form>

                                                    </div>
                                                </div>
                                                <div class="card-body pb-0">
                                                    <div class="d-flex flex-wrap">
                                                        <span class="me-sm-5 me-0 font-w500">
                                                            <svg class="me-1" xmlns="http://www.w3.org/2000/svg"
                                                                width="13" height="13" viewBox="0 0 13 13">
                                                                <rect width="13" height="13" fill="#135846" />
                                                            </svg>

                                                            Check In
                                                        </span>
                                                        <span
                                                            class="fs-16 font-w600 me-4">{{ $reservation_data['data']['checkedins_count'] }}
                                                            <small
                                                                class="text-success fs-12 font-w400">{{ $reservation_data['data']['room_reservation_checkin_percentage'] }}%</small></span>
                                                        <span class="me-sm-5 ms-0 font-w500">
                                                            <svg class="me-1" xmlns="http://www.w3.org/2000/svg"
                                                                width="13" height="13" viewBox="0 0 13 13">
                                                                <rect width="13" height="13" fill="#E23428" />
                                                            </svg>
                                                            Check Out
                                                        </span>
                                                        <span
                                                            class="fs-16 font-w600">{{ $reservation_data['data']['checkedouts_count'] }}</span>
                                                    </div>
                                                    <div class="tab-content">
                                                        <div class="tab-pane fade show active" id="Daily1">
                                                            <div id="chartBar" class="chartBar"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-sm-6">
                                            <div class="card bg-secondary">
                                                <div class="card-body">
                                                    <div class="d-flex align-items-end pb-4 justify-content-between">
                                                        <span class="fs-14 font-w500 text-white">Available Room
                                                            Today</span>
                                                        <span class="fs-20 font-w600 text-white"><span
                                                                class="pe-2"></span>{{ $available_rooms['available_rooms'] }}</span>
                                                    </div>
                                                    <div class="progress default-progress h-auto">
                                                        <div class="progress-bar bg-white progress-animated"
                                                            style="width: {{ $available_rooms['status_bar'] }}%; height:13px;"
                                                            role="progressbar"
                                                            aria-valuenow="{{ $available_rooms['status_bar'] }}"
                                                            aria-valuemin="0" aria-valuemax="100">
                                                            <span class="sr-only">{{ $available_rooms['status_bar'] }}%
                                                                complete</span>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-sm-6">
                                            <div class="card bg-secondary">
                                                <div class="card-body">
                                                    <div class="d-flex align-items-end pb-4 justify-content-between">
                                                        <span class="fs-14 font-w500 text-white">Sold Out Room Today</span>
                                                        <span class="fs-20 font-w600 text-white"><span
                                                                class="pe-2"></span>{{ $occupiedRooms['occupiedRooms'] }}</span>
                                                    </div>
                                                    <div class="progress default-progress h-auto">
                                                        <div class="progress-bar bg-white progress-animated"
                                                            style="width: {{ $occupiedRooms['statusBar'] }}%; height:13px;"
                                                            role="progressbar"
                                                            aria-valuenow="{{ $occupiedRooms['statusBar'] }}"
                                                            aria-valuemin="0" aria-valuemax="100">
                                                            <span class="sr-only">{{ $occupiedRooms['statusBar'] }}%
                                                                complete</span>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-12">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-xl-3 col-sm-3 col-6 mb-4 col-xxl-6">
                                                            <div class="text-center">
                                                                <h3 class="fs-28 font-w600">569</h3>
                                                                <span class="fs-16">Total Concierge</span>
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-3 col-sm-3 col-6 mb-4 col-xxl-6">
                                                            <div class="text-center">
                                                                <h3 class="fs-28 font-w600">
                                                                    {{ getModelItems('guests')->count() }}</h3>
                                                                <span class="fs-16">Total Customer</span>
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-3 col-sm-3 col-6 mb-4 col-xxl-6">
                                                            <div class="text-center">
                                                                <h3 class="fs-28 font-w600">
                                                                    {{ getModelItems('rooms')->count() }}</h3>
                                                                <span class="fs-16">Total Room</span>
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-3 col-sm-3 col-6 mb-4 col-xxl-6">
                                                            <div class="text-center">
                                                                <h3 class="fs-28 font-w600">
                                                                    {{ formatNumber($total_transaction) }}</h3>
                                                                <span class="fs-16 wspace-no">Total Transaction</span>
                                                            </div>
                                                        </div>
                                                        <div class="mb-5 mt-4 d-flex align-items-center">
                                                            <div>
                                                                <h4><a href="javascript:void(0);"
                                                                        class="text-secondary">Let Travl Generate Your
                                                                        Annualy Report Easily</a></h4>
                                                                <span class="fs-12">Lorem ipsum dolor sit amet,
                                                                    consectetur adipiscing elit, sed do eiusmod tempor
                                                                    incididunt ut labo
                                                                </span>
                                                            </div>
                                                            <div><a href="javascript:void(0);" class="ms-5"><i
                                                                        class="fas fa-arrow-right fs-20"></i></a></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--**********************************
                                                       Content body end
                                                      ***********************************-->
    @include('dashboard.chart.reservation.analytic', ['reservation_chart_data' => $reservation_analytic_data])
    @include('dashboard.chart.reservation.check-in-out', ['reservation_data' => $reservation_data])
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Handle dropdown item click
            document.querySelectorAll('.dropdown-menu .dropdown-item').forEach(item => {
                item.addEventListener('click', function() {
                    const period = this.getAttribute('data-period');
                    const form = this.closest('form');
                    form.querySelector('#selected-period').value = period;
                    form.submit(); // Submit the form automatically
                });
            });

            document.querySelectorAll('.dropdown-menu .dropdown-item-booking-stats').forEach(item => {
                item.addEventListener('click', function() {
                    const period = this.getAttribute('data-booking-period');
                    const form = this.closest('form');
                    form.querySelector('#booking-selected-period').value = period;
                    form.submit(); // Submit the form automatically
                });
            });
            document.querySelectorAll('.dropdown-menu .analytic-dropdown-item').forEach(item => {
                item.addEventListener('click', function() {
                    const period = this.getAttribute('data-analytic-period');
                    const form = this.closest('form');
                    form.querySelector('#analytic-selected-period').value = period;
                    form.submit(); // Submit the form automatically
                });
            });
        });
    </script>
    {{-- @endsection --}}
@endsection
