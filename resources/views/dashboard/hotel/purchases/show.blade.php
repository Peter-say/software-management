@extends('dashboard.layouts.app')

@section('contents')
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active"><a href="{{ route('dashboard.home') }}">Home</a></li>
                    <li class="breadcrumb-item active"><a href="{{ route('dashboard.hotel.purchases-dashbaord') }}">Expense</a>
                    <li class="breadcrumb-item active"><a href="{{ route('dashboard.hotel.purchases.index') }}">List</a>
                    <li class="breadcrumb-item "><a href="{{ route('dashboard.hotel.purchases.index') }}">View</a>

                    </li>
                </ol>
            </div>

            <div class="col-12">
                <div class="card" disabled>
                    <div class="card-header">
                        {{-- <h4 class="card-title">{{ isset($purchase) ? 'Update Expense' : 'Create Expense' }}</h4> --}}
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <!-- expense Details -->
                            <div class="col-lg-12">
                                <h5>Purchase Details</h5>
                                <div class="row">

                                    <!-- Name Field -->
                                    <div class="col-xl-3 col-md-4 col-12 mb-3">
                                        <div class="form-group">
                                            <label for="name" class="form-label">Item Category*</label>
                                            <select id="category" name="item_category_id"
                                                class="form-control @error('item_category_id') is-invalid @enderror" disabled>
                                                <option value="">Select Category</option>
                                                @foreach (getModelItems('item-categories') as $category)
                                                    <option value="{{ $category->id }}"
                                                        {{ old('item_category_id', $purchase->item_category_id ?? '') == $category->id ? 'selected' : '' }}>
                                                        {{ $category->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('item_category_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <!-- Date Field -->
                                    <div class="col-xl-3 col-md-4  col-12 mb-3">
                                        <div class="form-group">
                                            <label for="purchases_date" class="text-label form-label">
                                                Date*</label>
                                            <input type="date" id="purchase-date" name="purchase_date"
                                                class="form-control  @error('purchases_date') is-invalid @enderror"
                                                value="{{ old('purchase_date', isset($purchase) && $purchase->purchase_date ? $purchase->purchase_date->format('Y-m-d') : '') }}"
                                                required>

                                            @error('exapense_date')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Supplier Field -->
                                    <div class="col-xl-3 col-md-4  col-12 mb-3">
                                        <div class="form-group">
                                            <label for="supplier_id" class="form-label">Supplier</label>
                                            <select id="supplier_id" name="supplier_id"
                                                class="form-control @error('supplier_id') is-invalid @enderror" disabled>
                                                <option value="">Select Supplier</option>
                                                @foreach (getModelItems('suppliers') as $supplier)
                                                    <option value="{{ $supplier->id }}"
                                                        {{ old('supplier_id', $purchase->supplier_id ?? '') == $supplier->id ? 'selected' : '' }}>
                                                        {{ $supplier->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('supplier_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                    </div>
                                    <div class="col-xl-3 col-md-4  col-12 mb-3">
                                        <div class="form-group">
                                            <label for="status" class="form-label">Status</label>
                                            <select id="status" name="status"
                                                class="form-control @error('status') is-invalid @enderror" disabled>
                                                <option value="">Select Status</option>
                                                @foreach (['pending', 'partial', 'ordered'] as $status)
                                                    <option value="{{ $status }}"
                                                        {{ old('status', $purchase->status ?? '') == $status ? 'selected' : '' }}>
                                                        {{ ucfirst($status) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('status')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                    </div>
                                    <div class="col-xl-3 col-md-4  col-12 mb-3">
                                        <div class="form-group">
                                            <label for="expense_date" class="text-label form-label">
                                                Uploaded File</label>
                                            <div>
                                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                                    data-bs-target="#fileModal">
                                                    View File
                                                </button>
                                            </div>

                                            @error('exapense_date')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <!-- Modal -->
                                    <div class="modal fade" id="fileModal" tabindex="-1" aria-labelledby="fileModalLabel"
                                        aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="fileModalLabel">Uploaded File</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    @if (isset($purchase->file_path))
                                                        <iframe src="{{ getStorageUrl('hotel/purchase/files/' . $purchase->file_path) }}"
                                                            width="100%" height="500px"></iframe>
                                                    @else
                                                        <p>No file uploaded.</p>
                                                    @endif
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- note Field -->
                                    <div class="col-xl-9 col-md-9  col-12 mb-3">
                                        <div class="form-group">
                                            <label for="note" class="form-label">Note</label>
                                            <input type="text" id="note" name="note"
                                                class="form-control @error('note') is-invalid @enderror" disabled
                                                value="{{ old('note', isset($purchase) ? $purchase->note : '') }}">
                                            @error('note')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row no-gutters">
                            <div id="input-container" class="col-lg card-form__body card-body">
                                @if (isset($purchase) && $purchase->items->isNotEmpty())
                                @foreach ($purchase->items as $key => $purchaseItem)
                                <div id="input-template" class="row align-items-center">
                                    <div class="col-xl-2 col-md-4 col-12 mb-3">
                                        <div class="form-group">
                                            <label for="store_item_id_0"
                                                class="text-label form-label">Item/Description</label>
                                            <select id="store_item_id_0" name="store_item_id[]"
                                                class="form-control @error('store_item_id') is-invalid @enderror" disabled>
                                                <option value="" disabled selected>Select an item</option>
                                                @foreach (getModelItems('store-items') as $item)
                                                    <option value="{{ $item->id }}"
                                                        {{ old('store_item_id.' . $key, $purchaseItem->pivot->store_item_id) == $item->id ? 'selected' : '' }}>
                                                        {{ $item->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('store_item_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-xl-2 col-md-4 col-12 mb-3">
                                        <div class="form-group">
                                            <label for="purchases_date"
                                                class="text-label form-label">Quantity</label>
                                            <input id="qty_{{ $key }}" name="qty[]"
                                                type="number" onkeyup="updateAmount({{ $key }})"
                                                inputmode="decimal" min="0" step="any"
                                                class="form-control @error('qty') is-invalid @enderror"  disabled
                                                placeholder="Qty"
                                                value="{{ old('qty.' . $key, $purchaseItem->pivot->qty) }}">
                                            @error('qty')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-xl-2 col-md-4 col-12 mb-3">
                                        <div class="form-group">
                                            <label for="purchases_date"
                                                class="text-label form-label">Rate</label>
                                            <input type="number" id="rate_{{ $key }}"
                                                name="rate[]" onkeyup="updateAmount({{ $key }})"
                                                inputmode="decimal" min="0" step="any"
                                                class="form-control @error('rate') is-invalid @enderror"  disabled
                                                placeholder="Rate"
                                                value="{{ old('rate.' . $key, $purchaseItem->pivot->rate) }}">
                                            @error('rate')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-xl-2 col-md-4 col-12 mb-3">
                                        <div class="form-group">
                                            <label for="received_{{ $key }}"
                                                class="text-label form-label">Received</label>
                                            <input type="number" id="received_{{ $key }}"
                                                name="received[]" inputmode="decimal" min="0"
                                                step="any"
                                                class="form-control @error('received') is-invalid @enderror"  disabled
                                                placeholder="Received"
                                                value="{{ old('received.' . $key, $purchaseItem->pivot->received) }}">
                                            @error('received')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-xl-2 col-md-4 col-12 mb-3">
                                        <div class="form-group">
                                            <label for="purchases_date"
                                                class="text-label form-label">Amount</label>
                                            <input type="number" id="amount_{{ $key }}"
                                                name="amount[]"
                                                class="form-control money @error('amount') is-invalid @enderror"  disabled
                                                placeholder="Amount"
                                                value="{{ old('amount.' . $key, $purchaseItem->pivot->amount) }}">
                                            @error('amount')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-xl-2 col-md-4 col-12 mb-3">
                                        <div class="form-group">
                                            <label for="purchases_date" class="text-label form-label">Unit
                                                Quantity</label>
                                            <input type="number" id="unitQty_{{ $key }}"
                                                name="unit_qty[]" inputmode="decimal" min="0"
                                                step="any"
                                                class="form-control money @error('unit_qty') is-invalid @enderror"  disabled
                                                placeholder="Unit Qty"
                                                value="{{ old('unit_qty.' . $key, $purchaseItem->pivot->unit_qty) }}">
                                            @error('unit_qty')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                   
                                </div>
                            @endforeach
                                @else
                                    <div class="d-flex justify-content-center">
                                        <h4>No Data</h4>
                                    </div>
                                @endif
                            </div>
                        </div>
                        
                        </div>
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between">
                                    <h4 class="card-title">Payments Made</h4>
                                    <div class="d-flex justify-content-end">
                                        @if ($purchase->paymentStatus() === 'pending')
                                            <div class="alert alert-danger mt-3" role="alert">
                                                <h6 class="mb-0">No payments have been made for this purchase.</h6>
                                            </div>
                                        @elseif ($purchase->paymentStatus() === 'partial')
                                            <div class="alert alert-warning mt-3" role="alert">
                                                <h6 class="mb-0">Partial payment made. Remaining {{number_format($purchase->amount - $purchase->payments->sum('amount'))}}</h6>
                                            </div>
                                        @else
                                            <div class="alert alert-success mt-3" role="alert">
                                                <h6 class="mb-0">Items already paid for</h6>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="card-body">
                                    @if ($purchase->payments()->count() > 0)
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Date</th>
                                                        <th>Amount</th>
                                                        <th>Payment Method</th>
                                                        <th>Note</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($purchase->payments as $payment)
                                                        <tr>
                                                            <td>{{ $payment->created_at->format('jS, M Y') }}</td>
                                                            <td>{{ number_format($payment->amount) }}</td>
                                                            <td>{{ $payment->payment_method }}</td>
                                                            <td>{{ $payment->description ?? 'N/A' }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @else
                                        <div class="alert alert-warning" role="alert">
                                            No payments made for this expense.
                                        </div>
                                    @endif
                                </div>
                                <div class="d-flex justify-content-end">
                                    @if ($purchase->amount > $purchase->payments()->sum('amount') || $purchase->payments() === null)
                                        {{-- Payment Modal Button --}}
                                        <button type="button" data-bs-toggle="modal"
                                            data-bs-target="#payment-modal-{{ $purchase->id }}"
                                            class="btn btn-primary shadow btn-xl sharp me-2">
                                            Make payment
                                        </button>
                                    @endif
        
                            </div>
                        </div>
                        @include('dashboard.general.payment.modal', [
                            'payableType' => $payableType,
                            'payableModel' => $purchase,
                            'currencies' => $currencies,
                        ])
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
