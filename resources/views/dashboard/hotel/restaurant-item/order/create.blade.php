@extends('dashboard.layouts.app')

@section('contents')
    <style>
        .card {
            height: 100%;
        }

        /* Fixed height for order details section */
        .order-summary {
            max-height: 400px;
            /* Adjust as needed */
            overflow-y: auto;
            /* Enables vertical scrolling */
        }

        .card-img-top {
            object-fit: cover;
            height: 150px;
            width: 100%
        }

        .card-body {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .input-group {
            margin-top: auto;
        }
    </style>
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active"><a href="{{ route('dashboard.home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('dashboard.hotel.restaurant-items.index') }}">Restaurant
                            Order</a></li>
                    <li class="breadcrumb-item">{{ isset($item) ? 'Update' : 'Create' }}</li>
                </ol>
            </div>

            <!-- Main Section -->
            <div class="row mb-3">
                <!-- Recent Orders and Menu Items Section (8 Columns) -->
                <div class="col-lg-8 ">
                    <!-- Recent Orders Section -->
                    <div class="card shadow-sm rounded-lg ">
                        <div class="card-header bg-primary text-white">
                            <h4 class="card-title">Recent Orders</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <!-- Recent Orders Displayed in 3 Columns -->
                                <div class="col-md-4 mb-3">
                                    <div class="card shadow-sm border-0">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <h5 class="fw-bold text-primary">Vinicius Bayu</h5>
                                                <span class="text-muted">(#12532)</span>
                                            </div>
                                            <div class="badge bg-danger">Cancelled</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="card shadow-sm border-0">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <h5 class="fw-bold text-primary">Cheryl Arema</h5>
                                                <span class="text-muted">(#12532)</span>
                                            </div>
                                            <div class="badge bg-success">Ready to Serve</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="card shadow-sm border-0">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <h5 class="fw-bold text-primary">Kylian Rex</h5>
                                                <span class="text-muted">(#12531)</span>
                                            </div>
                                            <div class="badge bg-warning">Waiting</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- Customer Details Section (4 Columns) -->
                <div class="col-lg-4">
                    <!-- Customer Information and Order Summary -->
                    <div class="card mb-4 shadow-sm rounded-lg">
                        <div class="card-header bg-info text-white">
                            <h4 class="card-title">Customer Information</h4>
                        </div>
                        <div class="card-body">
                            <form>
                                <div class="mb-3">
                                    <label for="guestSelect" class="form-label fw-bold">Select Guest</label>
                                    <select class="form-select" id="guestId">
                                        <option value="" selected>Select or search for a guest or customer</option>
                                        @foreach (getModelItems('guests') as $guest)
                                            <option value="guest_{{ $guest->id }}">
                                                <i class="fas fa-user"></i> {{ $guest->full_name }}
                                            </option>
                                        @endforeach
                                        <hr>
                                        @foreach (getModelItems('walk_in_customers') as $customer)
                                            <option value="walkin_{{ $customer->id }}">
                                                <i class="fas fa-walking"></i> {{ $customer->walkInCustomerInfo() }}
                                            </option>
                                        @endforeach
                                    </select>

                                    <button type="button" class="btn btn-link" id="addWalkInCustomerBtn">Add Walk-In
                                        Customer</button>
                                </div>
                                <div class="mb-3" id="walkInCustomerForm" style="display: none;">
                                    <label for="customerName" class="form-label fw-bold">Customer Name</label>
                                    <input type="text" class="form-control" id="customerName">
                                    <label for="customerEmail" class="form-label fw-bold">Customer Email</label>
                                    <input type="email" class="form-control" id="customerEmail">
                                    <label for="customerPhone" class="form-label fw-bold">Customer Phone</label>
                                    <input type="tel" class="form-control" id="customerPhone">
                                </div>
                                <div class="mb-3">
                                    <label for="selectTable" class="form-label fw-bold">Select Table</label>
                                    <select class="form-select" id="selectTable">
                                        <option selected>Choose a table</option>
                                        <option value="1">Table 1</option>
                                        <option value="2">Table 2</option>
                                        <option value="3">Table 3</option>
                                    </select>
                                </div>
                                <!-- Button to Open Notes Modal -->
                                <div class="mb-3">
                                    <button type="button" class="btn btn-info" data-bs-toggle="modal"
                                        data-bs-target="#notesModal">
                                        <i class="fas fa-sticky-note"></i> Add Notes
                                    </button>
                                </div>
                                <!-- Note Section -->
                                <div class="mb-3">
                                    <label for="notes" class="form-label fw-bold">Notes</label>
                                    <textarea class="form-control" name="orderNotes" id="orderNotes" rows="1" style="display: none;"></textarea>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>


            </div>
            <div class="row" style="display: flex;">
                <!-- Recent Orders and Menu Items Section (8 Columns) -->
                <div class="col-lg-8" style="flex-grow: 1;">
                    <!-- Menu Items Section -->
                    <div class="card shadow-sm rounded-lg">
                        <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
                            <h4 class="card-title text-white">Menu</h4>
                            <ul class="nav nav-pills card-header-pills">

                                @foreach ($categories as $category)
                                    @php
                                        // Normalize category name for data attribute
                                        $normalizedCategory = strtolower(
                                            preg_replace('/[^a-z0-9]+/', '-', trim($category->category)),
                                        );
                                    @endphp
                                    <li class="nav-item">
                                        <a class="nav-link text-white" href="#"
                                            data-category="{{ $normalizedCategory }}">{{ $category->category }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="mb-3">
                                    <label for="guestSelect" class="form-label fw-bold">Outlet</label>
                                    <select class="form-select" id="outlet_id" required>
                                        <option value="" selected>Select Outlet</option>
                                        <!-- Populate this with existing guests from your database -->
                                        @foreach (getModelItems('restaurant-outlets') as $outlet)
                                            <option value="{{ $outlet->id }}">{{ $outlet->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <!-- Menu Items by Category -->

                                @foreach ($itemsByCategory as $category => $items)
                                    @php
                                        // Normalize category name for class usage
                                        $normalizedCategory = strtolower(
                                            preg_replace('/[^a-z0-9]+/', '-', trim($category)),
                                        );
                                    @endphp
                                    @if ($items)
                                        <div class="menu-category {{ $normalizedCategory }}" style="display: none;">
                                            <section>
                                                <div class="container my-5">
                                                    <header class="mb-4">
                                                        <h3>{{ $category }}</h3>
                                                    </header>

                                                    <div class="row">
                                                        @foreach ($items as $item)
                                                            <div class="col-lg-6 col-md-6 col-sm-6">
                                                                <div class="card px-4 border shadow-0 mb-4 mb-lg-0">
                                                                    <div class="mask px-2" style="height: 50px;">
                                                                        <div class="d-flex justify-content-between">
                                                                            <h6><span
                                                                                    class="badge bg-danger pt-1 mt-3 ms-2">New</span>
                                                                            </h6>
                                                                            <a href="#"><i
                                                                                    class="fas fa-heart text-primary fa-lg float-end pt-3 m-2"></i></a>
                                                                        </div>
                                                                    </div>
                                                                    <a href="#">
                                                                        <img src="{{ asset('storage/hotel/restaurant/items/' . $item->image) }}"
                                                                            class="card-img-top rounded-2" />
                                                                    </a>
                                                                    <div
                                                                        class="card-body d-flex flex-column pt-3 border-top">
                                                                        <a href="#"
                                                                            class="nav-link">{{ $item->name }}</a>
                                                                        <div class="price-wrap mb-2">
                                                                            <strong
                                                                                class="">${{ $item->price }}</strong>
                                                                            <del
                                                                                class="">${{ $item->discount ?? '0.00' }}</del>
                                                                        </div>
                                                                        <div
                                                                            class="card-footer d-flex align-items-end pt-3 px-0 pb-0 mt-auto">
                                                                            <a href="#"
                                                                                class="btn btn-outline-primary w-100 add-to-cart"
                                                                                data-item-id="{{ $item->id }}"
                                                                                data-item-price="{{ $item->price }}">Add
                                                                                to
                                                                                cart</a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </section>
                                        </div>
                                    @else
                                        <div class="text-center">No Items available.</div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4" style="flex: 0 0 auto; overflow-y: auto;">
                    <section>
                        <div class="card border shadow-sm rounded-lg">
                            <!-- Card Header -->
                            <div
                                class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
                                <h4 class="card-title mb-0 text-white">Order Details</h4>
                            </div>

                            <!-- Card Body -->
                            <div class="card-body">
                                <!-- Order Items will be injected here by JavaScript -->
                                <div id="order-items-container"></div>

                                <!-- Price Summary will be injected here by JavaScript -->
                                <div id="price-summary-container"></div>
                            </div>
                        </div>
                    </section>
                </div>



            </div>

        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                document.getElementById('addWalkInCustomerBtn').addEventListener('click', function() {
                    const walkInCustomerForm = document.getElementById('walkInCustomerForm');
                    walkInCustomerForm.style.display === 'block' 
                       
                });
            });
            document.addEventListener("DOMContentLoaded", function() {
                $(document).ready(function() {
                    // Display the first category by default
                    $('.menu-category').hide(); // Hide all categories initially
                    $('.menu-category').first().show(); // Show the first category

                    // Set the first nav link as active
                    $('.nav-link').removeClass('active'); // Remove active class from all links
                    $('.nav-link').first().addClass('active'); // Set first link as active

                    // Handle category click
                    $('.nav-link').click(function(event) {
                        event.preventDefault();

                        // Get normalized category name from data attribute
                        var category = $(this).data('category');

                        // Hide all categories
                        $('.menu-category').hide();

                        // Show the selected category
                        $('.menu-category.' + category).show();

                        // Update active nav link
                        $('.nav-link').removeClass('active');
                        $(this).addClass('active');
                    });

                    // Set the first category as active
                    $('.nav-link').first().addClass('active');
                });
                $(document).ready(function() {
                    let orderItems = JSON.parse(localStorage.getItem('orderItems')) ||
                []; // Load order items from localStorage

                    // Function to update the sidebar with order items
                    function updateOrderSidebar() {
                        const orderItemsContainer = $('#order-items-container');
                        orderItemsContainer.empty(); // Clear existing items

                        let totalPrice = 0; // To calculate total price
                        let totalDiscount = 0; // For discount (if any)
                        let totalTax = 0; // For tax (if any)

                        orderItems.forEach(item => {
                            // Calculate total price for this item
                            const itemTotalPrice = item.price * item.quantity;
                            totalPrice += itemTotalPrice;

                            // Create a new item element for the sidebar
                            const itemElement = `
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="card px-4 border shadow-0 mb-4 mb-lg-0">
                        <div class="mask px-2" style="height: 50px;"></div>
                        <a href="#">
                            <img src="${item.image}" class="card-img-top rounded-2" />
                        </a>
                        <div class="card-body d-flex flex-column pt-3 border-top">
                           <div class="d-flex align-items-center">
  <a href="#" class="nav-link">${item.name}</a>
  <span class="ms-2">X ${item.quantity}</span>
</div>

                            <div class="price-wrap mb-2">
                                <strong class="">$${itemTotalPrice.toFixed(2)}</strong>
                                <del class="">$${item.discount ? item.discount.toFixed(2) : '0.00'}</del>
                            </div>
                            <div class="card-footer d-flex align-items-end pt-3 px-0 pb-0 mt-auto">
                                <button class="btn btn-outline-danger w-100 remove-item" data-item-id="${item.id}">Remove</button>
                            </div>
                        </div>
                    </div>
                </div>
            `;
                            orderItemsContainer.append(itemElement);
                        });

                        // Update price summary
                        $('#price-summary-container').html(`
            <div class="card shadow-0 border mt-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <p class="mb-2">Total price:</p>
                        <p class="mb-2">$${totalPrice.toFixed(2)}</p>
                    </div>
                    <div class="d-flex justify-content-between">
                        <p class="mb-2">Discount:</p>
                        <p class="mb-2 text-primary">-$${totalDiscount.toFixed(2)}</p>
                    </div>
                    <div class="d-flex justify-content-between">
                        <p class="mb-2">TAX:</p>
                        <p class="mb-2">$${totalTax.toFixed(2)}</p>
                    </div>
                    <hr />
                    <div class="d-flex justify-content-between">
                        <p class="mb-2">Final Price:</p>
                        <p class="mb-2 fw-bold">$${(totalPrice - totalDiscount + totalTax).toFixed(2)}</p>
                    </div>
                    <div class="mt-3">
                        <button id="place-order" class="btn btn-primary w-100 shadow-0 mb-2"> Make Purchase</button>
                    </div>
                </div>
            </div>
        `);
                    }

                    // Save order items to localStorage
                    function saveOrderItems() {
                        localStorage.setItem('orderItems', JSON.stringify(orderItems));
                    }

                    // Add to cart button click event
                    $('.add-to-cart').on('click', function(e) {
                        e.preventDefault();

                        const itemId = $(this).data('item-id');
                        const itemPrice = parseFloat($(this).data('item-price'));
                        const itemName = $(this).closest('.card-body').find('.nav-link').text();
                        const itemImage = $(this).closest('.card').find('img').attr('src');
                        const itemDiscount = parseFloat($(this).closest('.price-wrap').find('del')
                            .text().replace('$', '')) || 0;

                        const quantity = parseInt(prompt("Enter quantity:", "1"));

                        if (quantity > 0) {
                            // Check if item already exists in the order
                            const existingItemIndex = orderItems.findIndex(item => item.id === itemId);
                            if (existingItemIndex > -1) {
                                // Update quantity if item already exists
                                orderItems[existingItemIndex].quantity += quantity;
                            } else {
                                // Add new item to orderItems
                                orderItems.push({
                                    id: itemId,
                                    price: itemPrice,
                                    quantity: quantity,
                                    name: itemName,
                                    image: itemImage,
                                    discount: itemDiscount
                                });
                            }

                            // Save order items to localStorage
                            saveOrderItems();

                            // Update sidebar with new items
                            updateOrderSidebar();
                            Toastify({
                                text: 'Item added to order!',
                                duration: 5000,
                                gravity: 'top',
                                position: 'right',
                                backgroundColor: 'linear-gradient(to right, #00b09b, #96c93d)',
                            }).showToast();
                        } else {
                            Toastify({
                                text: 'Please enter a valid quantity.',
                                duration: 5000,
                                gravity: 'top',
                                position: 'right',
                                backgroundColor: 'linear-gradient(to right, #ff5f6d, #ffc371)',
                            }).showToast();
                        }
                    });

                    // Remove item from order
                    $(document).on('click', '.remove-item', function() {
                        const itemId = $(this).data('item-id');
                        // Filter out the removed item from the orderItems array
                        orderItems = orderItems.filter(item => item.id !== itemId);
                        saveOrderItems(); // Save updated order items
                        updateOrderSidebar();
                        Toastify({
                            text: 'Item removed from order!',
                            duration: 5000,
                            gravity: 'top',
                            position: 'right',
                            backgroundColor: 'linear-gradient(to right, #ff5f6d, #ffc371)',
                        }).showToast();
                    });

                    // Place order button click event using event delegation
                    $(document).on('click', '#place-order', function(e) {
                        e.preventDefault();

                        if (orderItems.length === 0) {
                            Toastify({
                                text: 'No items in the order to place!',
                                duration: 5000,
                                gravity: 'top',
                                position: 'right',
                                backgroundColor: 'linear-gradient(to right, #ff5f6d, #ffc371)',
                            }).showToast();
                            return;
                        }

                        var selectedValue = $('#guestId').val();
                        var guest_id = null;
                        var walk_in_customer_id = null;

                        if (selectedValue) {
                            var parts = selectedValue.split('_');
                            var type = parts[0];
                            var id = parts[1];

                            if (type === 'guest') {
                                guest_id = id;
                            } else if (type === 'walkin') {
                                walk_in_customer_id = id;
                            }
                        }

                        // Prepare order data to send
                        const orderData = {
                            outlet_id: $('#outlet_id').val(), // Get the selected outlet ID
                            guest_id: guest_id, // Use the correct guest ID or null
                            walk_in_customer_id: walk_in_customer_id, // Use the correct walk-in customer ID or null
                            customer_name: $('#customerName')
                                .val(), // Get walk-in customer name, if filled
                            customer_email: $('#customerEmail')
                                .val(), // Get walk-in customer email, if filled
                            customer_phone: $('#customerPhone')
                                .val(), // Get walk-in customer phone, if filled
                            notes: localStorage.getItem('orderNotes') ||
                                '', // Get notes from localStorage
                            items: orderItems,
                            totalPrice: orderItems.reduce((total, item) => total + (item.price *
                                item.quantity), 0),
                            totalDiscount: 0, // You can add logic to calculate discounts if needed
                            totalTax: 0, // You can add logic to calculate taxes if needed
                            quantity: orderItems.reduce((total, item) => total + item.quantity,
                                0) // Calculate the total quantity of items
                        };

                        // Check if outlet_id is present
                        if (!orderData.outlet_id) {
                            Toastify({
                                text: "Outlet ID is required.",
                                duration: 5000,
                                gravity: 'top',
                                position: 'right',
                                backgroundColor: 'linear-gradient(to right, #ff5f6d, #ffc371)',
                            }).showToast();
                            return; // Exit the function if outlet_id is not provided
                        }

                        // Check if guest_id is not provided and customer details are missing
                        if (!orderData.guest_id && !walk_in_customer_id && (!orderData.customer_name ||
                                !orderData
                                .customer_email || !orderData.customer_phone)) {
                            Toastify({
                                text: "Either Guest ID or walk-in customer details must be provided.",
                                duration: 5000,
                                gravity: 'top',
                                position: 'right',
                                backgroundColor: 'linear-gradient(to right, #ff5f6d, #ffc371)',
                            }).showToast();
                            return; // Exit the function if neither is provided
                        }


                        // AJAX call to place order
                        $.ajax({
                            url: '/dashboard/hotel/restaurant/save-order', // Your backend endpoint for placing orders
                            method: 'POST',
                            data: JSON.stringify(orderData),
                            contentType: 'application/json',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                    'content') // Add CSRF token to the request headers
                            },
                            success: function(response) {
                                Toastify({
                                    text: response.message,
                                    duration: 5000,
                                    gravity: 'top',
                                    position: 'right',
                                    backgroundColor: 'linear-gradient(to right, #00b09b, #96c93d)',
                                }).showToast();
                                // Clear orderItems after successful order
                                orderItems = [];
                                localStorage.removeItem(
                                    'orderItems'); // Clear from localStorage
                                updateOrderSidebar();
                            },
                            error: function(xhr) {
                                var errorMessage = xhr.responseJSON.message ||
                                    'Error placing order. Please try again.';
                                console.error(errorMessage); // Log error to console
                                Toastify({
                                    text: errorMessage,
                                    duration: 5000,
                                    gravity: 'top',
                                    position: 'right',
                                    backgroundColor: 'linear-gradient(to right, #ff5f6d, #ffc371)',
                                }).showToast();
                            }
                        });

                    });



                    // Prompt before leaving the page if there are items in the order
                    $(window).on('beforeunload', function() {
                        if (orderItems.length > 0) {
                            return 'You have items in your order. Are you sure you want to leave?';
                        }
                    });

                    // Initial sidebar update
                    updateOrderSidebar();
                });

            });
        </script>
        @include('dashboard.hotel.restaurant-item.order.notes-modal')
    @endsection
