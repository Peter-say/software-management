<!-- Modal to display data for the order -->
<div class="modal fade" id="notificationModal{{ $notification->id }}" tabindex="-1"
    aria-labelledby="notificationModalLabel{{ $notification->id }}" aria-hidden="true">
   <div class="modal-dialog modal-lg">
       <div class="modal-content">
           <div class="modal-header">
               <h5 class="modal-title" id="notificationModalLabel{{ $notification->id }}">Order
                   #{{ $notification->data['order_id'] }} Details</h5>
               <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
           </div>
           <div class="modal-body">
               <p><strong>Title:</strong> {{ $notification->data['title'] }}</p>
               <p><strong>Message:</strong> {{ $notification->data['message'] }}</p>
               <p><strong>Total Amount:</strong> ${{ number_format($notification->data['total_amount'], 2) }}</p>
               <p><strong>Status:</strong> {{ $notification->data['status'] }}</p>

               <h5>Order Items</h5>
               <table class="table">
                   <thead>
                       <tr>
                           <th>Name</th>
                           <th>Quantity</th>
                           <th>Image</th>
                       </tr>
                   </thead>
                   <tbody>
                       @foreach ($notification->data['items'] as $item)
                           <tr>
                               <td>{{ $item['name'] }}</td>
                               <td>{{ $item['quantity'] }}</td>
                               <td>
                                <div class="item-image d-flex align-items-center">
                                    @if ($item['image'])
                                        {{-- Only the main image in Fancybox --}}
                                        <a href="{{ asset($item['image']) }}" data-fancybox="gallery_{{ $item['name'] }}" data-caption="{{ $item['name'] }}">
                                            <img src="{{ asset($item['image']) }}" alt="{{ $item['name'] }}" width="50" class="rounded img-thumbnail">
                                        </a>
                                    @else
                                        No Image
                                    @endif
                                </div>
                            </td>
                            
                           </tr>
                       @endforeach
                   </tbody>
               </table>
           </div>
           <div class="modal-footer d-flex justify-content-between">
               <a href="{{ $notification->data['link'] }}" class="btn btn-primary" target="_blank">View Order</a>
               <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
           </div>
       </div>
   </div>
</div>
