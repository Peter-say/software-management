@isset($reservation)
    @if ($reservation->total_amount > ($reservation->payments() ?? collect())->sum('amount'))
        <input type="hidden" name="payables[0][payable_id]" value="{{ $reservation->id }}">
        <input type="hidden" name="payables[0][payable_type]" value="{{ get_class($reservation) }}">
        <input type="hidden" name="payables[0][payable_amount]" value="{{ $reservation->total_amount }}">
    @endif

    @if (isset($reservation->guest) && ($reservation->guest->restaurantOrders || $reservation->guest->barOrders))
        @php $index = 1; @endphp

        {{-- Restaurant Orders --}}
        @foreach ($reservation->guest->restaurantOrders->where('status', 'Open') as $restaurant_order)
            @if ($restaurant_order->paymentStatus('pending'))
                <input type="hidden" name="payables[{{ $index }}][payable_id]" value="{{ $restaurant_order->id }}">
                <input type="hidden" name="payables[{{ $index }}][payable_type]" value="{{ get_class($restaurant_order) }}">
                <input type="hidden" name="payables[{{ $index }}][payable_amount]" value="{{ $restaurant_order->total_amount }}">
                @php $index++; @endphp
            @endif
        @endforeach

        {{-- Bar Orders --}}
        @foreach ($reservation->guest->barOrders->where('status', 'Open') as $bar_order)
            @if ($bar_order->paymentStatus('pending'))
                <input type="hidden" name="payables[{{ $index }}][payable_id]" value="{{ $bar_order->id }}">
                <input type="hidden" name="payables[{{ $index }}][payable_type]" value="{{ get_class($bar_order) }}">
                <input type="hidden" name="payables[{{ $index }}][payable_amount]" value="{{ $bar_order->total_amount }}">
                @php $index++; @endphp
            @endif
        @endforeach
    @endif

    {{-- Total Due --}}
    @if (isset($reservation->guest))
        <input type="hidden" name="amount_due"
            value="{{ $reservation->total_amount + $reservation->guest->calculateOrderNetTotal() - ($reservation->payments() ?? collect())->sum('amount') }}">
    @endif
@endisset
