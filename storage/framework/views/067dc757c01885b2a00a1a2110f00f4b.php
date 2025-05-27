<?php if(isset($reservation)): ?>
    <?php if($reservation->total_amount > ($reservation->payments() ?? collect())->sum('amount')): ?>
        <input type="hidden" name="payables[0][payable_id]" value="<?php echo e($reservation->id); ?>">
        <input type="hidden" name="payables[0][payable_type]" value="<?php echo e(get_class($reservation)); ?>">
        <input type="hidden" name="payables[0][payable_amount]" value="<?php echo e($reservation->total_amount); ?>">
    <?php endif; ?>

    <?php if(isset($reservation->guest) && ($reservation->guest->restaurantOrders || $reservation->guest->barOrders)): ?>
        <?php $index = 1; ?>

        
        <?php $__currentLoopData = $reservation->guest->restaurantOrders->where('status', 'Open'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $restaurant_order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if($restaurant_order->paymentStatus('pending')): ?>
                <input type="hidden" name="payables[<?php echo e($index); ?>][payable_id]" value="<?php echo e($restaurant_order->id); ?>">
                <input type="hidden" name="payables[<?php echo e($index); ?>][payable_type]" value="<?php echo e(get_class($restaurant_order)); ?>">
                <input type="hidden" name="payables[<?php echo e($index); ?>][payable_amount]" value="<?php echo e($restaurant_order->total_amount); ?>">
                <?php $index++; ?>
            <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        
        <?php $__currentLoopData = $reservation->guest->barOrders->where('status', 'Open'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bar_order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if($bar_order->paymentStatus('pending')): ?>
                <input type="hidden" name="payables[<?php echo e($index); ?>][payable_id]" value="<?php echo e($bar_order->id); ?>">
                <input type="hidden" name="payables[<?php echo e($index); ?>][payable_type]" value="<?php echo e(get_class($bar_order)); ?>">
                <input type="hidden" name="payables[<?php echo e($index); ?>][payable_amount]" value="<?php echo e($bar_order->total_amount); ?>">
                <?php $index++; ?>
            <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php endif; ?>

    
    <?php if(isset($reservation->guest)): ?>
        <input type="hidden" name="amount_due"
            value="<?php echo e($reservation->total_amount + $reservation->guest->calculateOrderNetTotal() - ($reservation->payments() ?? collect())->sum('amount')); ?>">
    <?php endif; ?>
<?php endif; ?>
<?php /**PATH /home/swifbayo/public_html/software-management/resources/views/dashboard/general/payment/payable-details.blade.php ENDPATH**/ ?>