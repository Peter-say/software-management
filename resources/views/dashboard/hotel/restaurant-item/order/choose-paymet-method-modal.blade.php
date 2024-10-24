<!-- Payment Modal -->
<div class="modal fade" id="paymentModal{{$order->id}}" tabindex="-1" aria-labelledby="paymentModalLabel{{$order->id}}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="paymentModalLabel">Select Payment Method</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <!-- Only show Pay with Wallet button if the order has a guest -->
                @if ($order->guest)
                    <button type="button" class="btn btn-outline-primary m-2" data-bs-toggle="modal"
                        data-bs-target="#Pay-with-wallet-modal{{ $order->id }}">
                        <i class="fas fa-wallet"></i> Pay with Wallet
                    </button>
                @endif

                <!-- Pay with Card Button -->
                <button type="button" class="btn btn-outline-success m-2">
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
@include('dashboard.hotel.restaurant-item.order.guest-wallet-modal', ['order' => $order])
