@extends('dashboard.layouts.app')

@section('contents')
<!--**********************************
                                               Content body start
                                              ***********************************-->
<div class="content-body">
    <!-- row -->
    <div class="container-fluid">
        <!-- Start::page-header -->
        <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
            <div>
                <p class="fw-semibold fs-18 mb-0">Welcome back, {{ auth()->user()?->name }}</p>
            </div>

        </div>
        <!-- End::page-header -->
        <div class="row">
            <div class="col-xl-12">
                <div class="row">
                    @foreach ($cards as $card)
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
                                                fill="var(--{{ $card['class'] }})" fill-rule="evenodd" />
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
        </div>
    </div>
</div>

@endsection