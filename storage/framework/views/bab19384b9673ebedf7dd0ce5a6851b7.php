<!-- Payment Modal -->
<div class="modal fade" id="paymentModal<?php echo e($payableModel->id); ?>" tabindex="-1"
    aria-labelledby="paymentModalLabel<?php echo e($payableModel->id); ?>" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="paymentModalLabel">Select Payment Method</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <!-- Only show Pay with Wallet button if the order has a guest -->
                <?php if($order->guest): ?>
                    <button type="button" class="btn btn-outline-primary m-2" data-bs-toggle="modal"
                        data-bs-target="#Pay-with-wallet-modal<?php echo e($order->id); ?>">
                        <i class="fas fa-wallet"></i> Pay with Wallet
                    </button>
                <?php endif; ?>

                <!-- Pay with Card Button -->
                <button type="button" class="btn btn-outline-success m-2" data-bs-toggle="modal"
                    data-bs-target="#payment-modal-<?php echo e($order->id); ?>">
                    <i class="fas fa-credit-card"></i> Pay with Card
                </button>

                <!-- Pay with Cash Button -->
                <button type="button" class="btn btn-outline-warning m-2">
                    <i class="fas fa-money-bill"></i> Pay with Cash
                </button>

                <!-- Bank Transfer Button -->
                <button type="button" class="btn btn-outline-info m-2">
                    <i class="fas fa-university"></i> Bank Transfer
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Include Guest Wallet Modal -->
<?php echo $__env->make('dashboard.hotel.restaurant-item.order.guest-wallet-modal', ['order' => $order], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('dashboard.general.payment.modal', [
    'payableType' => $payableType,
    'payableModel' => $order,
    'currencies' => $currencies,
], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php /**PATH /home/swifbayo/public_html/software-management/resources/views/dashboard/hotel/bar-items/order/choose-paymet-method-modal.blade.php ENDPATH**/ ?>