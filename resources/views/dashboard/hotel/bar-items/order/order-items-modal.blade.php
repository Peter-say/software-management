  <!-- Modal to display items for the order -->
  <div class="modal fade" id="orderItemsModal{{ $order->id }}" tabindex="-1" aria-labelledby="orderItemsModalLabel{{ $order->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="orderItemsModalLabel{{ $order->id }}">Order #{{ $order->id }} Items</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Item</th>
                            <th>Quantity</th>
                            <th>Amount</th>
                            <th>Discount</th>
                            <th>Tax</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->barOrderItems as $item)
                            <tr>
                                <td>{{ $item->barItem->name }}</td>
                                <td>{{ $item->qty }}</td>
                                <td>${{ number_format($item->amount, 2) }}</td>
                                <td>${{ number_format($item->discount_amount, 2) }} ({{ $item->discount_type }})</td>
                                <td>${{ number_format($item->tax_amount, 2) }} ({{ $item->tax_rate }}%)</td>
                                <td>${{ number_format($item->total_amount, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>