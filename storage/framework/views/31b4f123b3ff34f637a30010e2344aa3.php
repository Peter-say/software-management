<html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f8f9fa; /* Light background for contrast */
        }
        .col-12 {
            max-width: 800px; /* Limit the width of the invoice */
            margin: auto;
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Soft shadow for depth */
        }
        .card {
            margin-bottom: 20px;
        }
        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: red; /* Bootstrap primary color */
            color: white;
            padding: 15px; /* Increased padding for better spacing */
            border-radius: 8px 8px 0 0;
        }
        .card-title {
            margin: 0;
            font-size: 1.5em; /* Increase title size */
        }
      
        .card-body {
            padding: 15px;
        }
        h6 {
            margin: 0;
            color: red; /* Heading color */
        }
        p {
            margin: 5px 0; /* Spacing between paragraphs */
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .table, .table th, .table td {
            border: 1px solid #dee2e6; /* Border for table */
        }
        .table th, .table td {
            padding: 10px;
            text-align: left;
        }
        .table th {
            background-color: red; /* Header background color */
            color: white; /* Header text color */
        }
        .d-flex {
            display: flex;
            flex-wrap: wrap; /* Allow images to wrap */
        }
        .me-3 {
            margin-right: 1rem; /* Right margin for image spacing */
        }
        .mb-3 {
            margin-bottom: 1rem; /* Bottom margin for image spacing */
        }
        .rounded {
            border-radius: 4px; /* Rounded corners for images */
        }
        .text-end {
            text-align: right; /* Right-align text */
        }
        .alert {
            background-color: #e9ecef; /* Light gray background */
            color: #495057; /* Darker text color */
            padding: 10px;
            border-radius: 4px; /* Rounded corners */
            text-align: center; /* Center the alert text */
        }
        .flex-container {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        .flex-item {
            width: 48%; /* Allow for side by side layout */
        }
        .flex-item p {
            margin: 0; /* Remove margin for paragraph within flex items */
        }
    </style>
</head>
<body>
    <div class="col-12">
        <div class="card">
            <?php if($reservation): ?>
                <div class="card-header">
                    <h4 class="card-title">Reservation Invoice</h4>
                </div>
                <div class="card-body">
                    <!-- Invoice Header -->
                    <div class="flex-container">
                        <div class="flex-item">
                            <h6>From:</h6>
                            <p><?php echo e($reservation->hotel->hotel_name); ?></p>
                            <p><?php echo e($reservation->hotel->address); ?></p>
                            <p>Phone: <?php echo e($reservation->hotel->phone); ?></p>
                        </div>
                        <div class="flex-item text-end">
                            <h6>To:</h6>
                            <p><?php echo e($reservation->guest->full_name); ?></p>
                            <p><?php echo e($reservation->guest->address); ?></p>
                            <p>Phone: <?php echo e($reservation->guest->phone); ?></p>
                        </div>
                    </div>

                    <!-- Reservation Details -->
                    <div class="flex-container">
                        <div class="flex-item">
                            <p>Invoice Date: <?php echo e(\Carbon\Carbon::now()->format('d M, Y')); ?></p>
                            <p>Reservation Code: <?php echo e($reservation->reservation_code); ?></p>
                        </div>
                        <div class="flex-item text-end">
                            <p>Check-in Date: <?php echo e($reservation->checkin_date); ?></p>
                            <p>Check-out Date: <?php echo e($reservation->checkout_date); ?></p>
                        </div>
                    </div>

                    <table class="table">
                        <thead>
                            <tr>
                                <th>Description</th>
                                <th>Rate</th>
                                <th>Night(s)</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Room: <?php echo e($reservation->room->name); ?></td>
                                <td><?php echo e(number_format($reservation->rate)); ?></td>
                                <td><?php echo e(number_format($reservation->calculateNight())); ?></td>
                                <td><?php echo e(number_format($reservation->total_amount)); ?></td>
                            </tr>
                            <!-- Add more rows here if there are additional services -->
                           
                            <tr>
                                <td colspan="3" class="text-end">Net Total</td>
                                <td><?php echo e(number_format($reservation->total_amount)); ?></td>
                            </tr>
                            <?php if($reservation->payments->count()): ?>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Date & Time</th>
                                            <th>Amount</th>
                                            <th>Date & Time</th>
                                            <th>Amount</th>
                                            <th>Date & Time</th>
                                            <th>Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $payments = $reservation->payments->where('payable_id', $reservation->id);
                                            $paymentChunks = $payments->chunk(3); // Chunk payments into groups of 3
                                        ?>

                                        <?php $__currentLoopData = $paymentChunks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $chunk): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <?php $__currentLoopData = $chunk; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <td><?php echo e($payment->created_at); ?></td>
                                                    <td><?php echo e(number_format($payment->amount)); ?></td>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                                <!-- Fill in empty cells for any missing columns in the last chunk -->
                                                <?php for($i = $chunk->count(); $i < 3; $i++): ?>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                <?php endfor; ?>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                            <?php endif; ?>
                        </tbody>
                    </table>

                </div>
            <?php else: ?>
                <div class="alert">
                    No reservation found
                </div>
            <?php endif; ?>

        </div>
    </div>
</body>
</html>
<?php /**PATH /home/swifbayo/public_html/software-management/resources/views/dashboard/hotel/room/reservation/print-invoice.blade.php ENDPATH**/ ?>