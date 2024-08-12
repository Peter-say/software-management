	<!--**********************************
			Sidebar start
		***********************************-->
		<div class="dlabnav">
			<div class="dlabnav-scroll">
				<ul class="metismenu" id="menu">
					<li><a class="has-arrow " href="javascript:void()" aria-expanded="false">
							<i class="flaticon-025-dashboard"></i>
							<span class="nav-text">Dashboard</span>
						</a>
						<ul aria-expanded="false">
							<li><a href="index.html">Dashboard Light</a></li>
							<li><a href="index-2.html">Dashboard Dark</a></li>
							<li><a href="guest-list.html">Guest List</a></li>
							<li><a href="guest-details.html">Guest Details</a></li>
							<li><a href="concierge-list.html">Concierge List</a></li>
							<li><a href="room-list.html">Room List</a></li>
							<li><a href="reviews.html">Reviews</a></li>
						</ul>

					</li>
					<li><a href="{{route('dashboard.hotel-users.overview')}}" class="" aria-expanded="false">
						<i class="flaticon-013-checkmark"></i>
						<span class="nav-text">Users</span>
					</a>
					<li><a href="{{route('dashboard.hotel.rooms.index')}}" class="" aria-expanded="false">
						<i class="flaticon-013-checkmark"></i>
						<span class="nav-text">Rooms</span>
					</a>
				</li>
					
					{{-- <li><a class="has-arrow " href="javascript:void()" aria-expanded="false">
							<i class="flaticon-043-menu"></i>
							<span class="nav-text">Table</span>
						</a>
						<ul aria-expanded="false">
							<li><a href="table-bootstrap-basic.html">Bootstrap</a></li>
							<li><a href="table-datatable-basic.html">Datatable</a></li>
						</ul>
					</li> --}}
				
				</ul>
				<div class="dropdown header-profile2 ">
					<div class="header-info2 text-center">
						<img src="images/profile/pic1.jpg" alt="" />
						<div class="sidebar-info">
							<div>
								<h5 class="font-w500 mb-0">William Johanson</h5>
								<span class="fs-12">williamjohn@mail.com</span>
							</div>
						</div>
						<div>
							<a href="javascript:void(0);" class="btn btn-md text-secondary">Contact Us</a>
						</div>
					</div>
				</div>
				<div class="copyright">
					<p class="text-center"><strong>Travl Hotel Admin Dashboard</strong> © 2021 All Rights Reserved</p>
					<p class="fs-12 text-center">Made with <span class="heart"></span> by DexignLab</p>
				</div>
			</div>
		</div>
		<!--**********************************
			Sidebar end
		***********************************-->
