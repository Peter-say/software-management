 <div class="table-responsive" id="payment-table-wrapper">
     <table class="table table-hover">
         <thead>
             <tr>
                 <th>Date</th>
                 <th>User</th>
                 <th>Amount</th>
                 <th>Currency</th>
                 <th>Transaction ID</th>
                 <th>Status</th>
                 <th>Payment Method</th>
                 <th>Paid For</th>
                 <th>Description</th>
             </tr>
         </thead>
         <tbody>
             @forelse($payments as $payment)
                 <tr>
                     <td>{{ $payment->created_at->format('Y-m-d') }}</td>
                     <td>{{ $payment->user->name ?? 'N/A' }}</td>
                     <td>{{currencySymbol() }}{{ number_format($payment->amount, 2) }}</td>
                     <td>{{ $payment->currency }}</td>
                     <td>{{ $payment->transaction_id }}</td>
                     <td>
                         <span class="badge {{ $payment->status == 'completed' ? 'bg-success' : 'bg-warning' }}">
                             {{ ucfirst($payment->status) }}
                         </span>
                     </td>
                     <td>{{ ucfirst($payment->payment_method ?? 'N/A') }}</td>
                     <td>
                         @if ($payment->payable)
                             {{ class_basename($payment->payable_type) }} #{{ $payment->payable->id }}
                         @else
                             N/A
                         @endif
                     </td>
                     <td>{{ Str::limit($payment->description, 30) }}</td>
                 </tr>
             @empty
                 <tr>
                     <td colspan="9" class="text-center">No payments found.</td>
                 </tr>
             @endforelse
         </tbody>
     </table>
 </div>

 <div class="d-flex justify-content-center mt-3">
     {{ $payments->appends(request()->all())->links() }}
 </div>
