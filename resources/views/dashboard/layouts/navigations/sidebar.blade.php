<!--**********************************
   Sidebar start
***********************************-->
<div class="dlabnav">

    @php
        use App\Models\HotelSoftware\HotelUser;
        $user = Auth::user();
       // Check if the user is associated with any hotel
       $hotelUser = HotelUser::where('user_id', $user->id)->first();
    @endphp
    @if ($hotelUser)
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
                    <a href="{{ route('dashboard.hotel.guests.index') }}" aria-expanded="false">
                        <i class="flaticon-013-checkmark"></i>
                        <span class="nav-text">Guests</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('dashboard.hotel.rooms.index') }}" aria-expanded="false">
                        <i class="flaticon-013-checkmark"></i>
                        <span class="nav-text">Rooms</span>
                    </a>
                </li>
                
                <li><a class="has-arrow " href="javascript:void()" aria-expanded="false">
                    <i class="flaticon-045-heart"></i>
                    <span class="nav-text">Restaurant</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('dashboard.hotel.restaurant-items.index') }}">Menu Items</a></li>
                    <li><a href="{{ route('dashboard.hotel.restaurant.create-order') }}">Create Order</a></li>
                </ul>
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
                    <img src="images/profile/pic1.jpg" alt="" />
                    <div class="sidebar-info">
                        <h5 class="font-w500 mb-0">William Johanson</h5>
                        <span class="fs-12">williamjohn@mail.com</span>
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
