@extends('dashboard.layouts.app')

@section('contents')
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active"><a href="{{ route('dashboard.home') }}">Home</a></li>
                    <li class="breadcrumb-item active"><a href="{{ route('dashboard.hotel.expenses-dashbaord') }}">Expense</a>
                    <li class="breadcrumb-item active"><a href="{{ route('dashboard.hotel.expenses.index') }}">List</a>
                    <li class="breadcrumb-item "><a href="{{ route('dashboard.hotel.expenses.index') }}">View</a>

                    </li>
                </ol>
            </div>

            <div class="col-12">
                <div class="card" disabled>
                    <div class="card-header">
                        {{-- <h4 class="card-title">{{ isset($expense) ? 'Update Expense' : 'Create Expense' }}</h4> --}}
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <!-- expense Details -->
                            <div class="col-lg-12">
                                <h5>Expense Details</h5>
                                <div class="row">

                                    <!-- Name Field -->
                                    <div class="col-xl-3 col-md-4 col-12 mb-3">
                                        <div class="form-group">
                                            <label for="name" class="form-label">Category*</label>
                                            <select id="category" name="category_id"
                                                class="form-control @error('country_id') is-invalid @enderror" disabled>
                                                <option value="">Select Country</option>
                                                @foreach (getModelItems('expense-categories') as $category)
                                                    <option value="{{ $category->id }}"
                                                        {{ old('category_id', $expense->category_id ?? '') == $category->id ? 'selected' : '' }}>
                                                        {{ $category->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('country_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <!-- Date Field -->
                                    <div class="col-xl-3 col-md-4  col-12 mb-3">
                                        <div class="form-group">
                                            <label for="expense_date" class="text-label form-label">
                                                Date*</label>
                                            <input type="date" id="expense-date" name="expense_date"
                                                class="form-control  @error('expense_date') is-invalid @enderror"
                                                value="{{ old('expense_date', isset($expense) && $expense->expense_date ? $expense->expense_date->format('Y-m-d') : '') }}"
                                                required disabled>

                                            @error('exapense_date')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Supplier Field -->
                                    <div class="col-xl-3 col-md-4  col-12 mb-3">
                                        <div class="form-group">
                                            <label for="supplier_id" class="form-label">Supplier
                                            </label>
                                            <select id="supplier_id" name="supplier_id"
                                                class="form-control @error('supplier_id') is-invalid @enderror" disabled>
                                                <option value="">Select Supplier</option>
                                                @foreach (getModelItems('suppliers') as $supplier)
                                                    <option value="{{ $supplier->id }}"
                                                        {{ old('supplier_id', $expense->supplier_id ?? '') == $supplier->id ? 'selected' : '' }}>
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
                                                    @if (isset($expense->uploaded_file))
                                                        <iframe src="{{ getStorageUrl('hotel/expense/files/' . $expense->uploaded_file) }}"
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
                                    <div class="col-12 mb-3">
                                        <div class="form-group">
                                            <label for="note" class="form-label">Note</label>
                                            <textarea type="text" id="note" name="note" cols="2" rows="2"
                                                class="form-control @error('note') is-invalid @enderror" disabled>{{ old('note', isset($expense) && $expense->note) }}</textarea>
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
                                @if (isset($expense) && $expense->items->isNotEmpty())
                                    @foreach ($expense->items as $key => $expenseItem)
                                        <div id="input-template" class="row">
                                            <div class="col-xl-2 col-md-4 col-12 mb-3">
                                                <div class="form-group">
                                                    <label for="expense_date"
                                                        class="text-label form-label">Item/Description</label>
                                                    <input type="text" id="description_{{ $key }}"
                                                        name="description[]"
                                                        class="form-control @error('description') is-invalid @enderror"
                                                        value="{{ old('description.' . $key, $expenseItem->expenseItem->name ?? '') }}"
                                                        list="items" disabled>
                                                    @error('description')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                    <datalist id="items">
                                                        @foreach (getModelItems('expense-items') as $item)
                                                            <option value="{{ $item->name }}">
                                                        @endforeach
                                                    </datalist>
                                                </div>
                                            </div>
                                            <div class="col-xl-2 col-md-4 col-12 mb-3">
                                                <div class="form-group">
                                                    <label for="expense_date"
                                                        class="text-label form-label">Quantity</label>
                                                    <input id="qty_{{ $key }}" name="qty[]" type="number"
                                                        onkeyup="updateAmount({{ $key }})" inputmode="decimal"
                                                        min="0" step="any"
                                                        class="form-control @error('qty') is-invalid @enderror"
                                                        placeholder="Qty"
                                                        value="{{ old('qty.' . $key, $expenseItem->qty) }}" disabled>
                                                    @error('qty')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-xl-2 col-md-4 col-12 mb-3">
                                                <div class="form-group">
                                                    <label for="expense_date" class="text-label form-label">Rate</label>
                                                    <input type="number" id="rate_{{ $key }}" name="rate[]"
                                                        onkeyup="updateAmount({{ $key }})" inputmode="decimal"
                                                        min="0" step="any"
                                                        class="form-control @error('rate') is-invalid @enderror"
                                                        placeholder="Rate"
                                                        value="{{ old('rate.' . $key, $expenseItem->rate) }}" disabled>
                                                    @error('rate')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-xl-2 col-md-4 col-12 mb-3">
                                                <div class="form-group">
                                                    <label for="expense_date" class="text-label form-label">Amount</label>
                                                    <input type="number" id="amount_{{ $key }}"
                                                        name="amount[]"
                                                        class="form-control money @error('amount') is-invalid @enderror"
                                                        placeholder="Amount"
                                                        value="{{ old('amount.' . $key, $expenseItem->amount) }}"
                                                        disabled>
                                                    @error('amount')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-xl-2 col-md-4 col-12 mb-3">
                                                <div class="form-group">
                                                    <label for="expense_date" class="text-label form-label">Unit
                                                        Quantity</label>
                                                    <input type="number" id="unitQty_{{ $key }}"
                                                        name="unit_qty[]" inputmode="decimal" min="0"
                                                        step="any"
                                                        class="form-control money @error('unit_qty') is-invalid @enderror"
                                                        placeholder="Unit Qty"
                                                        value="{{ old('unit_qty.' . $key, $expenseItem->unit_qty) }}"
                                                        disabled>
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
                                        @if ($expense->paymentStatus() === 'pending')
                                            <div class="alert alert-danger mt-3" role="alert">
                                                <h6 class="mb-0">No payments have been made for this expense.</h6>
                                            </div>
                                        @elseif ($expense->paymentStatus() === 'partial')
                                            <div class="alert alert-warning mt-3" role="alert">
                                                <h6 class="mb-0">Partial payment made. Remaining {{number_format($expense->amount - $expense->payments->sum('amount'))}}</h6>
                                            </div>
                                        @else
                                            <div class="alert alert-success mt-3" role="alert">
                                                <h6 class="mb-0">Items already paid for</h6>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="card-body">
                                    @if ($expense->payments()->count() > 0)
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
                                                    @foreach ($expense->payments as $payment)
                                                        <tr>
                                                            <td>{{ $payment->created_at->format('jS, M Y') }}</td>
                                                            <td>{{ number_format($payment->amount) }}</td>
                                                            <td>{{ $payment->payment_method }}</td>
                                                            <td>{{ $payment->note ?? 'N/A' }}</td>
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
                                    @if ($expense->amount > $expense->payments()->sum('amount') || $expense->payments() === null)
                                        {{-- Payment Modal Button --}}
                                        <button type="button" data-bs-toggle="modal"
                                            data-bs-target="#payment-modal-{{ $expense->id }}"
                                            class="btn btn-primary shadow btn-xl sharp me-2">
                                            Make payment
                                        </button>
                                    @endif
        
                            </div>
                        </div>
                        @include('dashboard.general.payment.modal', [
                            'payableType' => $payableType,
                            'payableModel' => $expense,
                            'currencies' => $currencies,
                        ])
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
