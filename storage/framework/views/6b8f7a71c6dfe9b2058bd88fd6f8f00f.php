<!--**********************************
   Sidebar start
***********************************-->
<div class="dlabnav">

    <?php
    use App\Models\HotelSoftware\HotelUser;
    use App\Models\HotelSoftware\HotelModulePreference;
    $user = Auth::user();
    // Check if the user is associated with any hotel
    $hotelUser = HotelUser::where('user_id', $user->id)->whereHas('user', function($query){
     $query->where('role', '!=', 'Developer');
    })->first();
    $hasModules = false;

    if ($hotelUser && $hotelUser->hotel) {
    $hasModules = HotelModulePreference::where('hotel_id', $hotelUser->hotel->id)->exists();
    }
    ?>
    <div class="dlabnav-scroll">
        <ul class="metismenu" id="menu">
           <?php if(Gate::allows('developer')): ?>
           <li>
                <a href="<?php echo e(route('dashboard.home')); ?>" aria-expanded="false">
                    <i class="flaticon-013-checkmark"></i>
                    <span class="nav-text">Dashboard</span>
                </a>
            </li>
            <li><a class="has-arrow " href="javascript:void()" aria-expanded="false">
                    <i class="flaticon-045-heart"></i>
                    <span class="nav-text">Developer</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="<?php echo e(route('dashboard.hotels.')); ?>">Hotels</a></li>
                    <li><a href="<?php echo e(route('dashboard.users.')); ?>">Users</a></li>
                </ul>
            </li>
           <?php endif; ?>
            <?php if($hasModules): ?>
            <li>
                <a href="<?php echo e(route('dashboard.home')); ?>" aria-expanded="false">
                    <i class="flaticon-013-checkmark"></i>
                    <span class="nav-text">Dashboard</span>
                </a>
            </li>
            <?php if(Gate::allows('view-module', 'staff-management')): ?>
            <li>
                <a href="<?php echo e(route('dashboard.hotel-users.overview')); ?>" aria-expanded="false">
                    <i class="flaticon-013-checkmark"></i>
                    <span class="nav-text">Users</span>
                </a>
            </li>
            <?php endif; ?>
            <?php if(Gate::allows('view-module', 'guest-management')): ?>
            <li>
                <a href="<?php echo e(route('dashboard.hotel.guests.index')); ?>" aria-expanded="false">
                    <i class="flaticon-013-checkmark"></i>
                    <span class="nav-text">Guests</span>
                </a>
            </li>
            <?php endif; ?>
            <?php if(Gate::allows('view-module', 'room-reservation')): ?>
            <li>
                <a href="<?php echo e(route('dashboard.hotel.rooms.index')); ?>" aria-expanded="false">
                    <i class="flaticon-013-checkmark"></i>
                    <span class="nav-text">Rooms</span>
                </a>
            </li>
            <?php endif; ?>
            <?php if(Gate::allows('view-module', 'food-and-beverage')): ?>
            <li><a class="has-arrow " href="javascript:void()" aria-expanded="false">
                    <i class="flaticon-045-heart"></i>
                    <span class="nav-text">Restaurant</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="<?php echo e(route('dashboard.hotel.restaurant-items.index')); ?>">Menu Items</a></li>
                    <li><a href="<?php echo e(route('dashboard.hotel.restaurant.create-order')); ?>">Create Order</a></li>
                    <li><a href="<?php echo e(route('dashboard.hotel.restaurant.view-orders')); ?>">View Orders</a></li>
                </ul>
            </li>
            <?php endif; ?>
            <?php if(Gate::allows('view-module', 'food-and-beverage')): ?>
            <li><a class="has-arrow " href="javascript:void()" aria-expanded="false">
                    <i class="flaticon-045-heart"></i>
                    <span class="nav-text">Bar</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="<?php echo e(route('dashboard.hotel.bar-items.index')); ?>">Menu Items</a></li>
                    <li><a href="<?php echo e(route('dashboard.hotel.bar.create-order')); ?>">Create Order</a></li>
                    <li><a href="<?php echo e(route('dashboard.hotel.bar.view-orders')); ?>">View Orders</a></li>
                </ul>
            </li>
            <?php endif; ?>
            <?php if(Gate::allows('view-module', 'kitchen-management')): ?>
            <li><a class="has-arrow " href="javascript:void()" aria-expanded="false">
                    <i class="flaticon-045-heart"></i>
                    <span class="nav-text">Kitchen</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="<?php echo e(route('dashboard.hotel.kitchen.orders')); ?>">Orders</a></li>
                </ul>
            </li>
            <?php endif; ?>
            <?php if(Gate::allows('view-module', 'room-reservation')): ?>
            <li>
                <a href="<?php echo e(route('dashboard.hotel.reservation-dashboard')); ?>" aria-expanded="false">
                    <i class="flaticon-013-checkmark"></i>
                    <span class="nav-text">Room Reservations</span>
                </a>
            </li>
            <?php endif; ?>
            <?php if(Gate::allows('view-module', 'staff-management')): ?>
            <li>
                <a href="<?php echo e(route('dashboard.hotel.outlets.index')); ?>" aria-expanded="false">
                    <i class="flaticon-013-checkmark"></i>
                    <span class="nav-text">Outlets</span>
                </a>
            </li>
            <?php endif; ?>
            <?php if(Gate::allows('view-module', 'staff-management')): ?>
            <li>
                <a href="<?php echo e(route('dashboard.hotel.suppliers.index')); ?>" aria-expanded="false">
                    <i class="flaticon-013-checkmark"></i>
                    <span class="nav-text">Suppliers</span>
                </a>
            </li>
            <?php endif; ?>
            <?php if(Gate::allows('view-module', 'staff-management')): ?>
            <li>
                <a href="<?php echo e(route('dashboard.hotel.expenses-dashbaord')); ?>" aria-expanded="false">
                    <i class="flaticon-013-checkmark"></i>
                    <span class="nav-text">Expenses</span>
                </a>
            </li>
            <?php endif; ?>
            <?php if(Gate::allows('view-module', 'staff-management')): ?>
            <li>
                <a href="<?php echo e(route('dashboard.hotel.requisitions.create')); ?>" aria-expanded="false">
                    <i class="flaticon-013-checkmark"></i>
                    <span class="nav-text">Requisitions</span>
                </a>
            </li>
            <?php endif; ?>
            <?php if(Gate::allows('view-module', 'staff-management')): ?>
            <li>
                <a href="<?php echo e(route('dashboard.hotel.purchases-dashbaord')); ?>" aria-expanded="false">
                    <i class="flaticon-013-checkmark"></i>
                    <span class="nav-text">Purchase</span>
                </a>
            </li>
            <?php endif; ?>
            <?php if(Gate::allows('view-module', 'staff-management')): ?>
            <li><a class="has-arrow " href="javascript:void()" aria-expanded="false">
                    <i class="flaticon-045-heart"></i>
                    <span class="nav-text">Store</span>
                </a>

                <ul aria-expanded="false">
                    <li><a href="<?php echo e(route('dashboard.hotel.store-dashboard')); ?>">Overview</a></li>
                    <li><a href="<?php echo e(route('dashboard.hotel.store-items.index')); ?>">Items</a></li>
                    <li><a href="<?php echo e(route('dashboard.hotel.store-issues.create')); ?>">Issue Item</a></li>
                    <li><a class="has-arrow " href="javascript:void()" aria-expanded="false">
                            <i class="flaticon-045-heart"></i>
                            <span class="nav-text">Inventory</span>
                        </a>
                        <ul aria-expanded="false">
                            <li><a href="<?php echo e(route('dashboard.hotel.store.inventory.incoming')); ?>">Incoming</a>
                            </li>
                            <li><a href="<?php echo e(route('dashboard.hotel.store.inventory.outgoing')); ?>">Outgoing</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>
            <?php endif; ?>
            <li><a class="has-arrow " href="javascript:void()" aria-expanded="false">
                    <i class="flaticon-045-heart"></i>
                    <span class="nav-text">Notifications</span>
                </a>

                <ul aria-expanded="false">
                    <li><a href="<?php echo e(route('dashboard.hotel.notifications.view-all')); ?>">Orders</a></li>
                    
            </li>
            <?php if(Gate::allows('view-module', 'billing-and-payments')): ?>
            <li><a class="has-arrow " href="javascript:void()" aria-expanded="false">
                <i class="flaticon-045-heart"></i>
                <span class="nav-text">Manage Payments</span>
            </a>
            <ul aria-expanded="false">
                <li><a href="<?php echo e(route('dashboard.payments.list')); ?>">List</a></li>
        </li>
        </ul>
        </li>
        <?php endif; ?>
        <li>
            <a href="<?php echo e(route('dashboard.hotel.settings.')); ?>" aria-expanded="false">
                <i class="flaticon-013-checkmark"></i>
                <span class="nav-text">Settings</span>
            </a>
        </li>
        <?php endif; ?>
        </ul>
        <?php if(Auth::check()): ?>
        <div class="dropdown header-profile2">
            <div class="header-info2 text-center">
                <img src="images/profile/pic1.jpg" alt="" />
                <div class="sidebar-info">
                    <h5 class="font-w500 mb-0"><?php echo e(Auth::user()->name); ?></h5>
                    <span class="fs-12"><?php echo e(Auth::user()->email); ?></span>
                </div>
                <div>
                    <a href="javascript:void(0);" class="btn btn-md text-secondary">Contact Us</a>
                </div>
            </div>
        </div>
        <?php endif; ?>
        <div class="copyright">
            <p class="text-center"><strong>Travl Hotel Admin Dashboard</strong> © 2021 All Rights Reserved</p>
            <p class="fs-12 text-center">Made with <span class="heart"></span> by DexignLab</p>
        </div>
    </div>
</div>
<!--**********************************
   Sidebar end
***********************************--><?php /**PATH C:\Web Development\Backend\Laravel\software-management\software-management\resources\views\dashboard\layouts\navigations\sidebar.blade.php ENDPATH**/ ?>