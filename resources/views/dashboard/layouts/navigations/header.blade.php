<!--**********************************
   Header start
  ***********************************-->
<div class="header">
    <div class="header-content">
        <nav class="navbar navbar-expand">
            <div class="collapse navbar-collapse justify-content-between">
                <div class="header-left">
                    <div class="dashboard_bar">
                        @if (Route::currentRouteName() == 'dashboard.home')
                            Dashboard
                        @elseif (in_array(Route::currentRouteName(), [
                                'dashboard.hotel-users.overview',
                                'dashboard.hotel-users.create',
                                'dashboard.hotel-users.edit',
                            ]))
                            Hotel Users
                        @elseif (in_array(Route::currentRouteName(), [
                                'dashboard.hotel.expenses.index',
                                'dashboard.hotel.expenses.create',
                                'dashboard.hotel.expenses.edit',
                            ]))
                            Expenses
                        @elseif (in_array(Route::currentRouteName(), [
                                'dashboard.hotel.guests.index',
                                'dashboard.hotel.guests.create',
                                'dashboard.hotel.guests.edit',
                                'dashboard.hotel.guests.show',
                            ]))
                            Guest
                        @elseif (Route::currentRouteName() == 'dashboard.hotel.kitchen.orders')
                            Kitchen Order
                        @elseif (in_array(Route::currentRouteName(), [
                                'dashboard.hotel.notifications.view-all',
                                'dashboard.hotel.notifications.view',
                            ]))
                            Notification
                        @elseif (in_array(Route::currentRouteName(), [
                                'dashboard.hotel.outlets.index',
                                'dashboard.hotel.outlets.create',
                                'dashboard.hotel.outlets.edit',
                            ]))
                            Outlets
                        @elseif (in_array(Route::currentRouteName(), [
                                'dashboard.hotel.reservations.index',
                                'dashboard.hotel.reservations.create',
                                'dashboard.hotel.reservations.show',
                                'dashboard.hotel.reservations.edit',
                                'dashboard.hotel.reservation-dashboard',
                            ]))
                            Room Reservation
                        @elseif (in_array(Route::currentRouteName(), [
                                'dashboard.hotel.restaurant-items.index',
                                'dashboard.hotel.restaurant-items.create',
                                'dashboard.hotel.restaurant-items.edit',
                            ]))
                            Restaurant Items
                        @elseif (in_array(Route::currentRouteName(), [
                                'dashboard.hotel.restaurant.create-order',
                                'dashboard.hotel.restaurant.view-orders',
                            ]))
                            Restaurant Order
                        @elseif (in_array(Route::currentRouteName(), [
                                'dashboard.hotel.bar-items.index',
                                'dashboard.hotel.bar-items.create',
                                'dashboard.hotel.bar-items.edit',
                            ]))
                            Bar Items
                        @elseif (in_array(Route::currentRouteName(), ['dashboard.hotel.bar.create-order', 'dashboard.hotel.bar.view-orders']))
                            Restaurant Order
                        @elseif (in_array(Route::currentRouteName(), [
                                'dashboard.hotel.rooms.index',
                                'dashboard.hotel.rooms.create',
                                'dashboard.hotel.rooms.edit',
                            ]))
                            Rooms
                        @elseif (in_array(Route::currentRouteName(), [
                                'dashboard.hotel.suppliers.index',
                                'dashboard.hotel.suppliers.create',
                                'dashboard.hotel.suppliers.edit',
                            ]))
                            Suppliers
                        @elseif (in_array(Route::currentRouteName(), [
                                'dashboard.hotel.settings.',
                                'dashboard.hotel.settings.hotel-info.',
                                'dashboard.hotel.module-preferences.edit',
                                'dashboard.hotel.settings.hotel-info.edit',
                            ]))
                            Settings
                        @endif
                    </div>
                </div>
                <div class="nav-item d-flex align-items-center">
                    <div class="input-group search-area">
                        <input type="text" class="form-control" placeholder="">
                        <span class="input-group-text"><a href="javascript:void(0)"><i
                                    class="flaticon-381-search-2"></i></a></span>
                    </div>
                </div>

                <ul class="navbar-nav header-right">
                    <li class="nav-item dropdown notification_dropdown">
                        <a class="nav-link" href="javascript:void(0);">
                            <svg xmlns="http://www.w3.org/2000/svg" width="26.309" height="23.678"
                                viewBox="0 0 26.309 23.678">
                                <path id="Path_1955" data-name="Path 1955"
                                    d="M163.217,78.043a7.409,7.409,0,0,1,10.5-10.454l.506.506.507-.506a7.409,7.409,0,0,1,10.5,10.454L175.181,88.686a1.316,1.316,0,0,1-1.912,0Zm11.008,7.823,9.1-9.632.027-.027a4.779,4.779,0,1,0-6.759-6.757l-1.435,1.437a1.317,1.317,0,0,1-1.861,0l-1.437-1.437a4.778,4.778,0,0,0-6.758,6.757l.026.027Z"
                                    transform="translate(-161.07 -65.42)" fill="#135846" fill-rule="evenodd" />
                            </svg>
                        </a>
                    </li>
                    {{-- <li class="nav-item dropdown notification_dropdown">
                        <a class="nav-link bell-link " href="javascript:void(0);">
                            <svg xmlns="http://www.w3.org/2000/svg" width="26.667" height="24"
                                viewBox="0 0 26.667 24">
                                <g id="_014-mail" data-name="014-mail" transform="translate(0 -21.833)">
                                    <path id="Path_1962" data-name="Path 1962"
                                        d="M26.373,26.526A6.667,6.667,0,0,0,20,21.833H6.667A6.667,6.667,0,0,0,.293,26.526,6.931,6.931,0,0,0,0,28.5V39.166a6.669,6.669,0,0,0,6.667,6.667H20a6.669,6.669,0,0,0,6.667-6.667V28.5A6.928,6.928,0,0,0,26.373,26.526ZM6.667,24.5H20a4.011,4.011,0,0,1,3.947,3.36L13.333,33.646,2.72,27.86A4.011,4.011,0,0,1,6.667,24.5ZM24,39.166a4.012,4.012,0,0,1-4,4H6.667a4.012,4.012,0,0,1-4-4V30.873L12.693,36.34a1.357,1.357,0,0,0,1.28,0L24,30.873Z"
                                        transform="translate(0 0)" fill="#135846" />
                                </g>
                            </svg>
                            <span class="badge light text-white bg-primary rounded-circle">76</span>
                        </a>
                    </li> --}}
                    @unless (Route::currentRouteName() === 'dashboard.chat-gemini')
                        <li class="nav-item dropdown notification_dropdown">
                            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#aiChatModal">
                                Ask AI
                            </button>
                        </li>
                    @endunless

                    <li class="nav-item dropdown notification_dropdown">
                        <a class="nav-link" href="javascript:void(0);" role="button" data-bs-toggle="dropdown">
                            <svg xmlns="http://www.w3.org/2000/svg" width="19.375" height="24"
                                viewBox="0 0 19.375 24">
                                <g id="_006-notification" data-name="006-notification"
                                    transform="translate(-341.252 -61.547)">
                                    <path id="Path_1954" data-name="Path 1954"
                                        d="M349.741,65.233V62.747a1.2,1.2,0,1,1,2.4,0v2.486a8.4,8.4,0,0,1,7.2,8.314v4.517l.971,1.942a3,3,0,0,1-2.683,4.342h-5.488a1.2,1.2,0,1,1-2.4,0h-5.488a3,3,0,0,1-2.683-4.342l.971-1.942V73.547a8.4,8.4,0,0,1,7.2-8.314Zm1.2,2.314a6,6,0,0,0-6,6v4.8a1.208,1.208,0,0,1-.127.536l-1.1,2.195a.6.6,0,0,0,.538.869h13.375a.6.6,0,0,0,.536-.869l-1.1-2.195a1.206,1.206,0,0,1-.126-.536v-4.8a6,6,0,0,0-6-6Z"
                                        transform="translate(0 0)" fill="#135846" fill-rule="evenodd" />
                                </g>
                            </svg>

                            <span class="badge light text-white bg-primary rounded-circle "
                                id="notificationcount"></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <div id="DZ_W_Notification1" class="widget-media dlab-scroll p-3" style="height:380px;">
                                <ul class="timeline">
                                    <!-- Existing notifications will be populated here -->
                                </ul>
                            </div>
                            <a class="all-notification" href="{{ route('dashboard.hotel.notifications.view-all') }}">See
                                all notifications <i class="ti-arrow-end"></i></a>
                        </div>

                    </li>

                    {{-- <li class="nav-item dropdown notification_dropdown">
                        <a class="nav-link " href="javascript:void(0);" data-bs-toggle="dropdown">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="21.6" viewBox="0 0 24 21.6">
                                <g id="_008-chat" data-name="008-chat" transform="translate(-250.397 -62.547)">
                                    <path id="Path_1956" data-name="Path 1956"
                                        d="M274.4,67.347a4.8,4.8,0,0,0-4.8-4.8H255.2a4.8,4.8,0,0,0-4.8,4.8v15.6a1.2,1.2,0,0,0,2.048.848l3.746-3.745a2.4,2.4,0,0,1,1.7-.7H269.6a4.8,4.8,0,0,0,4.8-4.8Zm-2.4,0a2.4,2.4,0,0,0-2.4-2.4H255.2a2.4,2.4,0,0,0-2.4,2.4v12.7l1.7-1.7a4.8,4.8,0,0,1,3.395-1.406H269.6a2.4,2.4,0,0,0,2.4-2.4Zm-15.6,7.2H266a1.2,1.2,0,1,0,0-2.4h-9.6a1.2,1.2,0,0,0,0,2.4Zm0-4.8h12a1.2,1.2,0,1,0,0-2.4h-12a1.2,1.2,0,0,0,0,2.4Z"
                                        fill="#135846" fill-rule="evenodd" />
                                </g>
                            </svg>
                            <span class="badge light text-white bg-primary rounded-circle">15</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <div id="DZ_W_TimeLine02"
                                class="widget-timeline dlab-scroll style-1 ps ps--active-y p-3 height370">
                                <ul class="timeline">
                                    <li>
                                        <div class="timeline-badge primary"></div>
                                        <a class="timeline-panel text-muted" href="javascript:void(0);">
                                            <span>10 minutes ago</span>
                                            <h6 class="mb-0">Youtube, a video-sharing website, goes live <strong
                                                    class="text-primary">$500</strong>.</h6>
                                        </a>
                                    </li>
                                    <li>
                                        <div class="timeline-badge info">
                                        </div>
                                        <a class="timeline-panel text-muted" href="javascript:void(0);">
                                            <span>20 minutes ago</span>
                                            <h6 class="mb-0">New order placed <strong
                                                    class="text-info">#XF-2356.</strong></h6>
                                            <p class="mb-0">Quisque a consequat ante Sit amet magna at
                                                volutapt...</p>
                                        </a>
                                    </li>
                                    <li>
                                        <div class="timeline-badge danger">
                                        </div>
                                        <a class="timeline-panel text-muted" href="javascript:void(0);">
                                            <span>30 minutes ago</span>
                                            <h6 class="mb-0">john just buy your product <strong
                                                    class="text-warning">Sell $250</strong></h6>
                                        </a>
                                    </li>
                                    <li>
                                        <div class="timeline-badge success">
                                        </div>
                                        <a class="timeline-panel text-muted" href="javascript:void(0);">
                                            <span>15 minutes ago</span>
                                            <h6 class="mb-0">StumbleUpon is acquired by eBay. </h6>
                                        </a>
                                    </li>
                                    <li>
                                        <div class="timeline-badge warning">
                                        </div>
                                        <a class="timeline-panel text-muted" href="javascript:void(0);">
                                            <span>20 minutes ago</span>
                                            <h6 class="mb-0">Mashable, a news website and blog, goes live.</h6>
                                        </a>
                                    </li>
                                    <li>
                                        <div class="timeline-badge dark">
                                        </div>
                                        <a class="timeline-panel text-muted" href="javascript:void(0);">
                                            <span>20 minutes ago</span>
                                            <h6 class="mb-0">Mashable, a news website and blog, goes live.</h6>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </li> --}}
                    <li class="nav-item dropdown header-profile">
                        <a class="nav-link" href="javascript:void(0);" role="button" data-bs-toggle="dropdown">

                            <img class="img-fluid" id="logo" src="{{ $logoUrl }}" alt="Hotel Logo">
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a href="app-profile.html" class="dropdown-item ai-icon">
                                <svg id="icon-user2" xmlns="http://www.w3.org/2000/svg" class="text-primary"
                                    width="18" height="18" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg>
                                <span class="ms-2">Profile </span>
                            </a>
                            <a href="email-inbox.html" class="dropdown-item ai-icon">
                                <svg id="icon-inbox1" xmlns="http://www.w3.org/2000/svg" class="text-success"
                                    width="18" height="18" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path
                                        d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z">
                                    </path>
                                    <polyline points="22,6 12,13 2,6"></polyline>
                                </svg>
                                <span class="ms-2">Inbox </span>
                            </a>
                            @if (session()->has('impersonator_id'))
                                <a href="{{ route('dashboard.hotels.switch-back-impersonator') }}"
                                    class="dropdown-item ai-icon"
                                    onclick="event.preventDefault(); document.getElementById('switch-back-form').submit();">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="text-warning" width="18"
                                        height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M3 12l18 0"></path>
                                        <path d="M12 3l0 18"></path>
                                    </svg>
                                    <span class="ms-2">Switch to Developer</span>
                                </a>
                                <form id="switch-back-form"
                                    action="{{ route('dashboard.hotels.switch-back-impersonator') }}" method="POST"
                                    style="display: none;">
                                    @csrf
                                </form>
                            @else
                                <a href="{{ route('logout') }}" class="dropdown-item ai-icon"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="text-danger" width="18"
                                        height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                        <polyline points="16 17 21 12 16 7"></polyline>
                                        <line x1="21" y1="12" x2="9" y2="12"></line>
                                    </svg>
                                    <span class="ms-2">Logout</span>
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                    style="display: none;">
                                    @csrf
                                </form>
                            @endif

                        </div>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</div>
<!--**********************************
   Header end ti-comment-alt
  ***********************************-->
