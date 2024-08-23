<!--**********************************
   Sidebar start
***********************************-->
<div class="dlabnav">
    @php
        $user = Auth::user();
        $isHotelUser = $user->hotel && $user->hotel->hotelUser()->where('user_id', $user->id)->exists();
    @endphp

    @if ($isHotelUser)
        <div class="dlabnav-scroll">
            <ul class="metismenu" id="menu">
                <li>
                    <a href="{{ route('dashboard.home') }}" aria-expanded="false">
                        <i class="flaticon-013-checkmark"></i>
                        <span class="nav-text">Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('dashboard.hotel-users.overview') }}" aria-expanded="false">
                        <i class="flaticon-013-checkmark"></i>
                        <span class="nav-text">Users</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('dashboard.hotel.rooms.index') }}" aria-expanded="false">
                        <i class="flaticon-013-checkmark"></i>
                        <span class="nav-text">Rooms</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('dashboard.hotel.reservations.index') }}" aria-expanded="false">
                        <i class="flaticon-013-checkmark"></i>
                        <span class="nav-text">Room Reservations</span>
                    </a>
                </li>
            </ul>
            <div class="dropdown header-profile2">
                <div class="header-info2 text-center">
                    <img src="{{ asset('dashboard/images/profile/pic1.jpg') }}" alt="" />
                    <div class="sidebar-info">
                        <h5 class="font-w500 mb-0">{{ $user->name }}</h5>
                        <span class="fs-12">{{ $user->email }}</span>
                    </div>
                    <div>
                        <a href="javascript:void(0);" class="btn btn-md text-secondary">Contact Us</a>
                    </div>
                </div>
            </div>
    @endif
    <div class="copyright">
        <p class="text-center"><strong>Travl Hotel Admin Dashboard</strong> © 2021 All Rights Reserved</p>
        <p class="fs-12 text-center">Made with <span class="heart"></span> by DexignLab</p>
    </div>
</div>
</div>
<!--**********************************
   Sidebar end
***********************************-->
