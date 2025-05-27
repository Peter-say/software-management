<?php $__env->startSection('contents'); ?>
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active"><a href="<?php echo e(route('dashboard.home')); ?>">Home</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Guest Details</a></li>
                </ol>
            </div>
            <div class="row mt-4">
                <div class="col-xl-12">
                    <div class="row">
                        <div class="row guest-profile">
                            <div class="col-6">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex mb-4">
                                            <?php if($guest->id_picture_location): ?>
                                                <img src="<?php echo e(getStorageUrl('hotel/guests/id_picture_locations/' . $guest->id_picture_location)); ?>"
                                                    alt="<?php echo e($guest->name); ?>">
                                            <?php else: ?>
                                                <img src="#" alt="No Image">
                                            <?php endif; ?>
                                            <div>
                                                <h2 class="font-w600"><?php echo e($guest->full_name); ?></h2>
                                                <span class="text-secondary">ID <?php echo e($guest->uuid); ?></span>
                                                <div class="call d-flex align-items-center">
                                                    <a href="javascript:void(0);"><i
                                                            class="fas fa-phone-alt text-secondary"></i>

                                                    </a>
                                                    <button class="btn btn-secondary ms-3">
                                                        <svg class="me-2" xmlns="http://www.w3.org/2000/svg"
                                                            width="24" height="24.18" viewBox="0 0 24 24.18">
                                                            <g id="_032-speech-bubble" data-name="032-speech-bubble"
                                                                transform="translate(-1.63 0)">
                                                                <g id="Group_9" data-name="Group 9"
                                                                    transform="translate(1.63 0)">
                                                                    <path id="Path_118" data-name="Path 118"
                                                                        d="M22.193,3.6A12,12,0,0,0,1.636,12.361a11.434,11.434,0,0,0,.82,4.015,11.885,11.885,0,0,0,1.7,2.969l-.99,2.347a1.778,1.778,0,0,0,1.951,2.46l4.581-.792A12.013,12.013,0,0,0,22.193,3.6ZM12.749,16.8H9.61a.9.9,0,1,1,0-1.81h3.139a.911.911,0,0,1,.9.9A.893.893,0,0,1,12.749,16.8Zm4.892-3.676H9.61a.911.911,0,0,1-.9-.9.893.893,0,0,1,.9-.9h8.031a.9.9,0,1,1,0,1.81Zm0-3.7H9.61a.9.9,0,1,1,0-1.81h8.031a.911.911,0,0,1,.9.9A.93.93,0,0,1,17.641,9.421Z"
                                                                        transform="translate(-1.63 0)" fill="#fff" />
                                                                </g>
                                                            </g>
                                                        </svg>
                                                        Send Message
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="dropdown dropend ms-auto mb-3">
                                                <a href="javascript:void(0);" class="btn-link" data-bs-toggle="dropdown"
                                                    aria-expanded="false">
                                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M12 13C12.5523 13 13 12.5523 13 12C13 11.4477 12.5523 11 12 11C11.4477 11 11 11.4477 11 12C11 12.5523 11.4477 13 12 13Z"
                                                            stroke="#575757" stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round"></path>
                                                        <path
                                                            d="M12 6C12.5523 6 13 5.55228 13 5C13 4.44772 12.5523 4 12 4C11.4477 4 11 4.44772 11 5C11 5.55228 11.4477 6 12 6Z"
                                                            stroke="#575757" stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round"></path>
                                                        <path
                                                            d="M12 20C12.5523 20 13 19.5523 13 19C13 18.4477 12.5523 18 12 18C11.4477 18 11 18.4477 11 19C11 19.5523 11.4477 20 12 20Z"
                                                            stroke="#575757" stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round"></path>
                                                    </svg>

                                                </a>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item"
                                                        href="<?php echo e(route('dashboard.hotel.guests.edit', $guest->id)); ?>">Edit</a>
                                                    <a class="dropdown-item" href="javascript:void(0);"
                                                        onclick="confirmDelete('<?php echo e(route('dashboard.hotel.guests.destroy', $guest->id)); ?>')">Delete</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex flex-column align-items-center text-center mt-3">
                                            <div class="mt-1">
                                                <div class="wallet-icon me-3">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        fill="currentColor" class="bi bi-wallet" viewBox="0 0 16 16">
                                                        <path d="M0 3a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2H0z" />
                                                        <path
                                                            d="M16 6H0v7a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V6zm-2 3.5a.5.5 0 0 1-1 0v-1a.5.5 0 0 1 1 0v1z" />
                                                    </svg>

                                                </div>
                                                <!-- Wallet Details -->
                                                <div>
                                                    <h5 class="card-subtitle mb-2 text-muted">
                                                        Wallet Balance: <?php echo e(currencySymbol()); ?><?php echo e(number_format($guest->wallet->balance)); ?>

                                                    </h5>
                                                    <!-- Action Buttons -->
                                                    <div class="d-flex">
                                                        <!-- Button to Add Funds -->
                                                        <button type="button" data-bs-toggle="modal"
                                                            data-bs-target="#fund-guest-wallet-modal"
                                                            class="btn btn-sm btn-primary me-2">Add
                                                            Funds</button>
                                                        <!-- Button to Deduct Funds -->
                                                        <button type="button" data-bs-toggle="modal"
                                                            data-bs-target="#deduct-guest-wallet-modal"
                                                            class="btn btn-sm btn-danger">Deduct Funds</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="tab-content">
                                            <div class="tab-pane fade active show" id="AllRooms">
                                                <div class="table-responsive">
                                                    <table
                                                        class="table card-table display mb-4 shadow-hover table-responsive-lg"
                                                        id="guestTable-all3">
                                                        <thead>
                                                            <tr>
                                                                <th class="bg-none">
                                                                    <div class="form-check style-1">
                                                                        <input class="form-check-input" type="checkbox"
                                                                            value="" id="checkAll3">
                                                                    </div>
                                                                </th>
                                                                <th>Amount</th>
                                                                <th>Payment Method</th>
                                                                <th>Type</th>
                                                                <th>Currency</th>
                                                                <th>Description</th>
                                                                <th>Status</th>
                                                                <th class="bg-none">Date</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            
                                                            <?php $__currentLoopData = $guest->transactionHistory(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <?php $__currentLoopData = $payment->transactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $transaction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                    <tr>
                                                                        <td>
                                                                            <div class="form-check style-1">
                                                                                <input class="form-check-input"
                                                                                    type="checkbox" value="">
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div
                                                                                class="room-list-bx d-flex align-items-center">
                                                                                <div>
                                                                                    <span
                                                                                        class="fs-16 font-w500 text-nowrap">
                                                                                        <?php echo e(number_format(optional($transaction)->amount)); ?>

                                                                                    </span>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <span class="fs-16 font-w500 text-nowrap">
                                                                                <?php echo e(optional($transaction->payment)->payment_method); ?>

                                                                            </span>
                                                                        </td>
                                                                        <td>
                                                                            <span
                                                                                class="fs-16 font-w500 text-nowrap"><?php echo e($transaction->transaction_type); ?></span>
                                                                        </td>
                                                                        <td><?php echo e(optional($transaction)->currency); ?></td>
                                                                        <!-- Use optional() here to avoid errors -->
                                                                        <td>
                                                                            <span
                                                                                class="fs-16 font-w500 text-nowrap"><?php echo e($transaction->description); ?></span>
                                                                        </td>
                                                                        <td><?php echo e($transaction->status); ?></td>
                                                                        <td>
                                                                            <span
                                                                                class="fs-16 font-w500 text-nowrap"><?php echo e($transaction->created_at); ?></span>
                                                                        </td>
                                                                    </tr>
                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                                        </tbody>
                                                    </table>
                                                </div>
                                                <?php echo $__env->make('dashboard.hotel.guest.wallet.credit', ['guest' => $guest], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-12">
                            <div class="card overflow-hidden">
                                <div class="row m-0">
                                    <div class="col-xl-6 p-0">
                                        <div class="card-body">

                                            <div class="guest-profile">
                                                <?php
                                                    // Get the most recent reservation
                                                    $latest_reservation = $guest->latestReservation();
                                                    $room = $latest_reservation->room ?? null;
                                                    $roomType = $room?->roomType ?? null;
                                                    $currency = $roomType?->currency ?? null;
                                                ?>

                                                <?php if($latest_reservation): ?>
                                                    <div class="d-flex mt-5">
                                                        <div class="mt-4 check-status">
                                                            <span class="d-block mb-2">Check In</span>
                                                            <span class="font-w500 fs-16">
                                                                <?php echo e($latest_reservation->checked_in_at
                                                                    ? $latest_reservation->checked_in_at->format('M jS, Y | h:i A')
                                                                    : 'Not yet checked in'); ?>

                                                            </span>
                                                        </div>
                                                        <div class="mt-4">
                                                            <span class="d-block mb-2">Check Out</span>
                                                            <span class="font-w500 fs-16">
                                                                <?php echo e($latest_reservation->checked_out_at
                                                                    ? $latest_reservation->checked_out_at->format('M jS, Y | h:i A')
                                                                    : 'Ongoing'); ?>

                                                            </span>
                                                        </div>
                                                    </div>
                                                <?php else: ?>
                                                    <div class="d-flex justify-content-center">
                                                        <h6>No data available</h6>
                                                    </div>
                                                <?php endif; ?>

                                            </div>

                                            <?php if($room): ?>
                                                <div class="d-flex flex-wrap">
                                                    <!-- Room Info -->
                                                    <div class="mt-4 check-status">
                                                        <span class="d-block mb-2">Room Info</span>
                                                        <h4 class="font-w500 fs-24">
                                                            <?php echo e($roomType->name . ' - ' . $room->name); ?>

                                                        </h4>
                                                    </div>

                                                    <!-- Room Price -->
                                                    <div class="mt-4 ms-3">
                                                        <span class="d-block mb-2 text-black">Price</span>
                                                        <span class="font-w500 fs-24 text-black">
                                                            <?php echo e($currency->symbol ?? ''); ?><?php echo e($roomType->rate ?? 'N/A'); ?>

                                                            <small class="fs-14 ms-2 text-secondary">/night</small>
                                                        </span>
                                                    </div>
                                                </div>

                                                <!-- Room Description -->
                                                <p class="mt-2"><?php echo e($room->description); ?></p>
                                            <?php else: ?>
                                                <p class="mt-2">No room information available.</p>
                                            <?php endif; ?>

                                            <div class="facilities">
                                                <div class="mb-3 ">
                                                    <span class="d-block mb-3">Facilities</span>
                                                    <a href="javascript:void(0);" class="btn btn-secondary light btn-lg">
                                                        <svg class="me-2" xmlns="http://www.w3.org/2000/svg"
                                                            width="28" height="20" viewBox="0 0 28 20">
                                                            <g>
                                                                <path
                                                                    d="M27,14V7a1,1,0,0,0-1-1H6A1,1,0,0,0,5,7v7a3,3,0,0,0-3,3v8a1,1,0,0,0,2,0V24H28v1a1,1,0,0,0,2,0V17A3,3,0,0,0,27,14ZM7,8H25v6H24V12a2,2,0,0,0-2-2H19a2,2,0,0,0-2,2v2H15V12a2,2,0,0,0-2-2H10a2,2,0,0,0-2,2v2H7Zm12,6V12h3v2Zm-9,0V12h3v2ZM4,17a1,1,0,0,1,1-1H27a1,1,0,0,1,1,1v5H4Z"
                                                                    transform="translate(-2 -6)" fill="#135846" />
                                                            </g>
                                                        </svg>
                                                        3 Bed Space</a>
                                                    <a href="javascript:void(0);" class="btn btn-secondary light btn-lg">
                                                        <svg class="me-2" xmlns="http://www.w3.org/2000/svg"
                                                            width="20" height="23.512" viewBox="0 0 20 23.512">
                                                            <g id="_010-security" data-name="010-security"
                                                                transform="translate(-310.326 -159.324)">
                                                                <path id="Path_1958" data-name="Path 1958"
                                                                    d="M330.326,165.226a2.952,2.952,0,0,0-1.71-2.8l-7.5-2.951a2.139,2.139,0,0,0-1.581,0l-7.5,2.951a2.951,2.951,0,0,0-1.709,2.8v5.318a10.445,10.445,0,0,0,4.372,8.772l5.142,3.372a.871.871,0,0,0,.971,0l5.143-3.372a10.448,10.448,0,0,0,4.372-8.772Zm-2,0a.591.591,0,0,0-.342-.561l-7.5-2.951a.432.432,0,0,0-.317,0l-7.5,2.951a.59.59,0,0,0-.341.561v5.318a7.985,7.985,0,0,0,3.343,6.707l4.657,3.054,4.656-3.054a7.986,7.986,0,0,0,3.344-6.707Zm-8.657,7.273,4.949-5.843a.9.9,0,0,1,1.415,0,1.338,1.338,0,0,1,0,1.67L320.376,175a.9.9,0,0,1-1.414,0l-2.829-3.338a1.337,1.337,0,0,1,0-1.669.9.9,0,0,1,1.414,0Z"
                                                                    transform="translate(0 0)" fill="#135846"
                                                                    fill-rule="evenodd" />
                                                            </g>
                                                        </svg>
                                                        24 Hours Guard</a>
                                                    <a href="javascript:void(0);" class="btn btn-secondary light btn-lg">
                                                        <svg class="me-2" xmlns="http://www.w3.org/2000/svg"
                                                            width="20" height="15.75" viewBox="0 0 20 15.75">
                                                            <g id="internet" transform="translate(0 -2.15)">
                                                                <g id="Group_22" data-name="Group 22">
                                                                    <path id="Path_1969" data-name="Path 1969"
                                                                        d="M18.3,7.6a11.709,11.709,0,0,0-16.6,0,.967.967,0,0,1-1.4,0,.967.967,0,0,1,0-1.4,13.641,13.641,0,0,1,19.4,0,.99.99,0,0,1-1.4,1.4Z"
                                                                        fill="#135846" />
                                                                </g>
                                                                <g id="Group_23" data-name="Group 23">
                                                                    <path id="Path_1970" data-name="Path 1970"
                                                                        d="M15.4,10.4a7.667,7.667,0,0,0-10.7,0A.99.99,0,0,1,3.3,9,9.418,9.418,0,0,1,16.8,9a.99.99,0,0,1-1.4,1.4Z"
                                                                        fill="#135846" />
                                                                </g>
                                                                <g id="Group_24" data-name="Group 24">
                                                                    <path id="Path_1971" data-name="Path 1971"
                                                                        d="M12.6,13.4a3.383,3.383,0,0,0-4.9,0,.967.967,0,0,1-1.4,0,1.087,1.087,0,0,1,0-1.5,5.159,5.159,0,0,1,7.7,0,1.088,1.088,0,0,1,0,1.5A.967.967,0,0,1,12.6,13.4Z"
                                                                        fill="#135846" />
                                                                </g>
                                                                <circle id="Ellipse_10" data-name="Ellipse 10"
                                                                    cx="1.9" cy="1.9" r="1.9"
                                                                    transform="translate(8.2 14.1)" fill="#135846" />
                                                            </g>
                                                        </svg>
                                                        Free Wifi</a>
                                                </div>
                                                <a href="javascript:void(0);" class="btn btn-secondary light">2
                                                    Bathroom</a>
                                                <a href="javascript:void(0);" class="btn btn-secondary light">Air
                                                    Conditioner</a>
                                                <a href="javascript:void(0);"
                                                    class="btn btn-secondary light">Television</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 p-0">
                                        <div class="guest-carousel owl-carousel owl-loaded owl-drag owl-dot">
                                            <?php if(getModelItems('rooms')): ?>
                                                <?php $__currentLoopData = getModelItems('rooms'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $room): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <div class="item">
                                                        <div class="rooms">
                                                            <img src="<?php echo e($room->RoomImage()); ?>"
                                                                alt="<?php echo e(basename($room->RoomImage())); ?>" style="">
                                                            <div class="booked">
                                                                <?php if(isset($latest_reservation) && $latest_reservation->room->id === $room->id): ?>
                                                                    <p class="fs-20 font-w500">BOOKED</p>
                                                                <?php endif; ?>
                                                            </div>
                                                            <div class="img-content">
                                                                <h4 class="fs-24 font-w600 text-white"><?php echo e($room->name); ?>

                                                                </h4>
                                                                <p class="text-white"><?php echo e($room->description); ?></p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php else: ?>
                                                <div class="d-flex justify-content-center">
                                                    <h6>No data available</h6>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="col-xl-12">
                            <div class="card">
                                <div class="card-header border-0">
                                    <h4 class="fs-20">Purchase History</h4>
                                    <div class="newest ms-3">
                                        <select class="default-select">
                                            <option>Newest</option>
                                            <option>Oldest</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="card-body pt-0">
                                    <?php if($guest->purchaseHistory()->count()): ?>
                                        <?php $__currentLoopData = $guest->purchaseHistory(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $purchase_history): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="row align-items-center mt-5">
                                                <div class="col-xl-4 col-sm-7">
                                                    <div class="purchase-history d-flex align-items-center">
                                                        <a href="<?php echo e($purchase_history->room->RoomImage()); ?>"
                                                            data-fancybox="gallery_<?php echo e($purchase_history->room->id); ?>"
                                                            data-caption="<?php echo e($purchase_history->room->name); ?>">
                                                            <img class="me-3 rounded img-thumbnail"
                                                                src="<?php echo e($purchase_history->room->RoomImage()); ?>"
                                                                alt="<?php echo e(basename($purchase_history->room->RoomImage())); ?>">
                                                        </a>
                                                        <?php $__currentLoopData = $purchase_history->room->RoomImages()->skip(1); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <a href="<?php echo e(getStorageUrl($image->file_path)); ?>"
                                                                data-fancybox="gallery_<?php echo e($room->id); ?>"
                                                                data-caption="<?php echo e($room->name); ?>">
                                                                <img class="me-3 rounded img-thumbnail"
                                                                    src="<?php echo e(getStorageUrl($image->file_path)); ?>"
                                                                    alt="<?php echo e(basename($image->file_path)); ?>"
                                                                    style="display: none">
                                                            </a>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        <div class="ms-3">
                                                            <h4 class="guest-text font-w500">
                                                                <?php echo e($purchase_history->room->roomType->name . ' ' . $purchase_history->room->name); ?>

                                                            </h4>
                                                            <span
                                                                class="fs-14 d-block mb-2 text-secondary">#000123456</span>
                                                            <span
                                                                class="fs-16 text-nowrap"><?php echo e($latest_reservation->created_at->format(' M jS, Y | h:i A')); ?></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-2 col-sm-5 col-6">
                                                    <div class="ms-2">
                                                        <span class="d-block">Check In</span>
                                                        <span
                                                            class="guest-text font-w500"><?php echo e($purchase_history->checked_in_at->format(' M jS, Y')); ?></span>
                                                        <span
                                                            class="fs-14 d-block"><?php echo e($purchase_history->checked_in_at->format('h:i A')); ?></span>
                                                    </div>
                                                </div>
                                                <div class="col-xl-2 col-sm-4 col-6">
                                                    <div class="mt-sm-0 mt-2">
                                                        <span class="d-block">Check Out</span>
                                                        <span
                                                            class="guest-text font-w500"><?php echo e($purchase_history->checked_out_at->format(' M jS, Y')); ?></span>
                                                        <span
                                                            class="fs-14 d-block"><?php echo e($purchase_history->checked_out_at->format(' h:i A')); ?></span>
                                                    </div>
                                                </div>
                                                <div class="col-xl-2 col-sm-4 col-6">
                                                    <div class="mt-sm-0 mt-3">
                                                        <span class="d-block mb-2 text-black">Price</span>
                                                        <span
                                                            class="font-w500 fs-24 text-black"><?php echo e($purchase_history->room->roomType->currency->symbol ?? ''); ?><?php echo e(number_format($purchase_history->room->roomType->rate)); ?><small
                                                                class="fs-14 ms-2 text-secondary">/night</small></span>
                                                    </div>
                                                </div>
                                                <div class="col-xl-2 col-sm-4 col-6">
                                                    <div class="d-flex align-items-center mt-sm-0 mt-3">
                                                        <!-- View Notes Button -->
                                                        <a href="javascript:void(0);" class="btn btn-secondary light"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#viewNotesModal-<?php echo e($purchase_history->id); ?>">
                                                            View Notes
                                                        </a>
                                                        <?php echo $__env->make('dashboard.hotel.guest.modal.note', [
                                                            'purchase_history' => $purchase_history,
                                                        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                                        <div class="dropdown dropend ms-auto">
                                                            <a href="javascript:void(0);" class="btn-link"
                                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                                <svg width="24" height="24" viewBox="0 0 24 24"
                                                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                    <path
                                                                        d="M12 13C12.5523 13 13 12.5523 13 12C13 11.4477 12.5523 11 12 11C11.4477 11 11 11.4477 11 12C11 12.5523 11.4477 13 12 13Z"
                                                                        stroke="#575757" stroke-width="2"
                                                                        stroke-linecap="round" stroke-linejoin="round">
                                                                    </path>
                                                                    <path
                                                                        d="M12 6C12.5523 6 13 5.55228 13 5C13 4.44772 12.5523 4 12 4C11.4477 4 11 4.44772 11 5C11 5.55228 11.4477 6 12 6Z"
                                                                        stroke="#575757" stroke-width="2"
                                                                        stroke-linecap="round" stroke-linejoin="round">
                                                                    </path>
                                                                    <path
                                                                        d="M12 20C12.5523 20 13 19.5523 13 19C13 18.4477 12.5523 18 12 18C11.4477 18 11 18.4477 11 19C11 19.5523 11.4477 20 12 20Z"
                                                                        stroke="#575757" stroke-width="2"
                                                                        stroke-linecap="round" stroke-linejoin="round">
                                                                    </path>
                                                                </svg>
                                                            </a>
                                                            <div class="dropdown-menu">
                                                                <a class="dropdown-item"
                                                                    href="javascript:void(0);">Edit</a>
                                                                <a class="dropdown-item"
                                                                    href="javascript:void(0);">Delete</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php else: ?>
                                        <div class="d-flex justify-content-center">
                                            <h6>No data available for this guest</h6>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php echo $__env->make('dashboard.hotel.guest.delete-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            function TravlCarousel() {

                /*  testimonial one function by = owl.carousel.js */
                jQuery('.guest-carousel').owlCarousel({
                    loop: false,
                    margin: 15,
                    nav: true,
                    autoplaySpeed: 3000,
                    navSpeed: 3000,
                    paginationSpeed: 3000,
                    slideSpeed: 3000,
                    smartSpeed: 3000,
                    autoplay: false,
                    animateOut: 'fadeOut',
                    dots: true,
                    navText: ['<i class="fas fa-arrow-left"></i>', '<i class="fas fa-arrow-right"></i>'],
                    responsive: {
                        0: {
                            items: 1
                        },

                        480: {
                            items: 1
                        },

                        767: {
                            items: 1
                        },
                        1750: {
                            items: 1
                        },
                        1920: {
                            items: 1
                        },
                    }
                })
            }

            jQuery(window).on('load', function() {
                setTimeout(function() {
                    TravlCarousel();
                }, 1000);
            });
        })
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('dashboard.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/swifbayo/public_html/software-management/resources/views/dashboard/hotel/guest/details.blade.php ENDPATH**/ ?>