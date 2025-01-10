@extends('dashboard.layouts.app')

@section('contents')
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active"><a href="{{ route('dashboard.home') }}">Home</a></li>
                    {{-- <li class="breadcrumb-item active"><a href="{{ route('dashboard.hotel.purchasess-dashbaord') }}">purchases</a> --}}
                    <li class="breadcrumb-item "><a href="{{ route('dashboard.hotel.purchases.index') }}">List</a>

                    </li>
                    <li class="breadcrumb-item">{{ isset($purchase) ? 'Update purchases' : 'Create purchases' }}</li>
                </ol>
            </div>

            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">{{ isset($purchase) ? 'Update Purchases' : 'Create purchases' }}</h4>
                    </div>

                    <div class="card-body">
                        <form id="purchasesForm"
                            action="{{ isset($purchase) ? route('dashboard.hotel.purchases.update', $purchase->id) : route('dashboard.hotel.purchases.store') }}"
                            method="POST" enctype="multipart/form-data">
                            @csrf
                            @if (isset($purchase))
                                @method('PUT')
                                <input type="hidden" name="purchase_id" value="{{ $purchase->id }}">
                            @endif

                            <div class="row">
                                <!-- purchases Details -->
                                <div class="col-lg-12">
                                    <h5>purchases Details</h5>
                                    <div class="row">

                                        <!-- Name Field -->
                                        <div class="col-xl-3 col-md-4 col-12 mb-3">
                                            <div class="form-group">
                                                <label for="name" class="form-label">Item Category*</label>
                                                <select id="category" name="item_category_id"
                                                    class="form-control @error('item_category_id') is-invalid @enderror">
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
                                                <label for="supplier_id" class="form-label">Supplier
                                                    <span>
                                                        <a href="{{ route('dashboard.hotel.suppliers.create') }}"
                                                            class="text-primary">(Add)</a>
                                                    </span>
                                                </label>
                                                <select id="supplier_id" name="supplier_id"
                                                    class="form-control @error('supplier_id') is-invalid @enderror">
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
                                                    class="form-control @error('status') is-invalid @enderror">
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
                                        <!-- Other Photo Field -->
                                        <div class="col-xl-3 col-md-4  col-12 mb-3">
                                            <div class="form-group">
                                                <label for="file_path" class="form-label">File</label>
                                                <input type="file" id="file_path" name="file_path"
                                                    class="form-control @error('file_path') is-invalid @enderror"
                                                    value="{{ old('file_path', $purchase->file_path ?? '') }}">
                                                @error('file_path')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- note Field -->
                                        <div class="col-xl-9 col-md-9  col-12 mb-3">
                                            <div class="form-group">
                                                <label for="note" class="form-label">Note</label>
                                                <input type="text" id="note" name="note"
                                                    class="form-control @error('note') is-invalid @enderror"
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
                                                            class="form-control @error('store_item_id') is-invalid @enderror">
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
                                                            class="form-control @error('qty') is-invalid @enderror"
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
                                                            class="form-control @error('rate') is-invalid @enderror"
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
                                                            class="form-control @error('received') is-invalid @enderror"
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
                                                            class="form-control money @error('amount') is-invalid @enderror"
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
                                                            class="form-control money @error('unit_qty') is-invalid @enderror"
                                                            placeholder="Unit Qty"
                                                            value="{{ old('unit_qty.' . $key, $purchaseItem->pivot->unit_qty) }}">
                                                        @error('unit_qty')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-2 d-flex justify-content-end">
                                                    <!-- Remove Button -->
                                                    <button type="button"
                                                        class="btn btn-sm btn-danger remove-button d-flex align-items-center justify-content-center"
                                                        style="border-radius: 50%; width: 40px; height: 40px;">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <div id="input-template" class="row align-items-center">
                                            <div class="col-xl-2 col-md-4 col-12 mb-3">
                                                <div class="form-group">
                                                    <label for="store_item_id_0"
                                                        class="text-label form-label">Item/Description</label>
                                                    <select id="store_item_id_0" name="store_item_id[]"
                                                        class="form-control @error('store_item_id') is-invalid @enderror">
                                                        <option value="" disabled selected>Select an item</option>
                                                        @foreach (getModelItems('store-items') as $item)
                                                            <option value="{{ $item->id }}"
                                                                {{ old('store_item_id.0') == $item->id ? 'selected' : '' }}>
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
                                                    <input id="qty_0" name="qty[]" type="number"
                                                        onkeyup="updateAmount(0)" inputmode="decimal" min="0"
                                                        step="any"
                                                        class="form-control @error('qty') is-invalid @enderror"
                                                        placeholder="Qty" value="{{ old('qty.0') }}">
                                                    @error('qty')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-xl-2 col-md-4 col-12 mb-3">
                                                <div class="form-group">
                                                    <label for="purchases_date" class="text-label form-label">Rate</label>
                                                    <input type="number" id="rate_0" name="rate[]"
                                                        onkeyup="updateAmount(0)" inputmode="decimal" min="0"
                                                        step="any"
                                                        class="form-control @error('rate') is-invalid @enderror"
                                                        placeholder="Rate" value="{{ old('rate.0') }}">
                                                    @error('rate')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-xl-2 col-md-4 col-12 mb-3">
                                                <div class="form-group">
                                                    <label for="received" class="text-label form-label">Received</label>
                                                    <input type="number" id="received_0" name="received[]"
                                                        inputmode="decimal" min="0" step="any"
                                                        class="form-control @error('received') is-invalid @enderror"
                                                        placeholder="Received" value="{{ old('received.0') }}">
                                                    @error('received')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-xl-2 col-md-4 col-12 mb-3">
                                                <div class="form-group">
                                                    <label for="purchases_date"
                                                        class="text-label form-label">Amount</label>
                                                    <input type="number" id="amount_0" name="amount[]"
                                                        class="form-control money @error('amount') is-invalid @enderror"
                                                        placeholder="Amount" value="{{ old('amount.0') }}">
                                                    @error('amount')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-xl-2 col-md-4 col-12 mb-3">
                                                <div class="form-group">
                                                    <label for="purchases_date" class="text-label form-label">Unit
                                                        Quantity</label>
                                                    <input type="number" id="unitQty_0" name="unit_qty[]"
                                                        inputmode="decimal" min="0" step="any"
                                                        class="form-control money @error('unit_qty') is-invalid @enderror"
                                                        placeholder="Unit Qty" value="{{ old('unit_qty.0') }}">
                                                    @error('unit_qty')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-xl-2 col-md-4 col-12 mb-3 d-flex align-items-center">
                                                <!-- Remove Button -->
                                                <button type="button"
                                                    class="btn btn-sm btn-danger remove-button d-flex align-items-center justify-content-center"
                                                    style="border-radius: 50%; width: 40px; height: 40px;">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div style="display: none">
                                <div id="input-template" class="row">
                                    <div class="col-xl-2 col-md-4 col-12 mb-3">
                                        <div class="form-group">
                                            <label for="store_item_id_0"
                                                class="text-label form-label">Item/Description</label>
                                            <select id="store_item_id_0" name="store_item_id[]"
                                                class="form-control @error('store_item_id') is-invalid @enderror">
                                                <option value="" disabled selected>Select an item</option>
                                                @foreach (getModelItems('store-items') as $item)
                                                    <option value="{{ $item->id }}"
                                                        {{ old('store_item_id.0') == $item->id ? 'selected' : '' }}>
                                                        {{ $item->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('store_item_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-xl-2 col-md-4  col-12 mb-3">
                                        <div class="form-group">
                                            <label for="purchases_date" class="text-label form-label">
                                                Quantity</label>
                                            <input id="qty_0" name="qty[]" type="number"
                                                onkeyup="updateAmount(0)" inputmode="decimal" min="0"
                                                step="any" class="form-control @error('qty') is-invalid @enderror"
                                                placeholder="Qty" value="{{ old('qty[]') }}">

                                            @error('description')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-xl-2 col-md-4  col-12 mb-3">
                                        <div class="form-group">
                                            <label for="purchases_date" class="text-label form-label">
                                                Rate</label>
                                            <input type="number" id="rate_0" name="rate[]" type="number"
                                                onkeyup="updateAmount(0)" inputmode="decimal" min="0"
                                                step="any" class="form-control @error('rate') is-invalid @enderror"
                                                placeholder="Rate" value="{{ old('rate[]') }}">
                                            @error('rate')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-xl-2 col-md-4 col-12 mb-3">
                                        <div class="form-group">
                                            <label for="received_0" class="text-label form-label">Received</label>
                                            <input type="number" id="received_0" name="received[]" inputmode="decimal"
                                                min="0" step="any"
                                                class="form-control @error('received') is-invalid @enderror"
                                                placeholder="Received" value="{{ old('received[]') }}">
                                            @error('received')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-xl-2 col-md-4  col-12 mb-3">
                                        <div class="form-group">
                                            <label for="purchases_date" class="text-label form-label">
                                                Amount</label>
                                            <input type="number" id="amount_0" name="amount[]" type="number"
                                                class="form-control money @error('amount') is-invalid @enderror"
                                                placeholder="Amount" value="{{ old('amount[]') }}">
                                            @error('amount')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-xl-2 col-md-4  col-12 mb-3">
                                        <div class="form-group">
                                            <label for="purchases_date" class="text-label form-label">
                                                Unit Quantity</label>
                                            <input type="number" id="unitQty_0" name="unit_qty[]" type="number"
                                                inputmode="decimal" min="0" step="any"
                                                class="form-control money @error('unit_qty') is-invalid @enderror"
                                                placeholder="Unit Qty" value="{{ old('unit_qty[]') }}">
                                            @error('unit_qty')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-2 d-flex justify-content-end mt-3">
                                        <!-- Remove Button -->
                                        <button type="button"
                                            class="btn btn-sm btn-danger remove-button d-flex align-items-center justify-content-center"
                                            style="border-radius: 50%; width: 40px; height: 40px; display: none;">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>

                                </div>
                            </div>
                            <div class="mt-4 d-flex justify-content-between align-items-center">
                                <!-- Left-aligned Buttons (Submit and Cancel) -->
                                <div class="d-flex">
                                    <button type="submit" class="btn btn-primary">
                                        {{ isset($purchase) ? 'Update purchases' : 'Create purchases' }}
                                    </button>
                                    <a href="{{ route('dashboard.hotel.purchases.index') }}"
                                        class="btn btn-danger light ms-3">
                                        Cancel
                                    </a>
                                </div>

                                <!-- Right-aligned Add Button -->
                                <button type="button" id="add-input"
                                    class="btn btn-sm btn-dark d-flex align-items-center justify-content-center"
                                    style="border-radius: 50%; width: 40px; height: 40px;">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>

                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
    <script>
        let inputCounter =
            {{ isset($purchase->items) ? count($purchase->items) : 0 }}; // Start counter from existing items count

        // Function to update the amount field based on quantity and rate
        function updateAmount(index) {
            var qty = parseFloat($("#qty_" + index).val()) || 0;
            var rate = parseFloat($("#rate_" + index).val()) || 0;
            var amount = qty * rate;
            $("#amount_" + index).val(amount.toFixed(2)); // Format the amount
            $("#unitQty_" + index).val(qty); // Set unit qty
        }

        // Wait until the DOM is fully loaded
        $(document).ready(function() {
            // Hide the remove button on the initial input
            $("#input-container .remove-button:first").hide();

            // Event handler for adding a new cloned input section
            $("#add-input").click(function() {
                inputCounter++;

                // Clone the input template and update attributes
                var newInput = $("#input-template").first().clone();
                newInput.find("input, select").each(function() {
                    var oldName = $(this).attr("name");
                    var oldId = $(this).attr("id");

                    // Update name and id attributes
                    if (oldName) $(this).attr("name", oldName.replace(/\[\]/g, "[" + inputCounter +
                        "]"));
                    if (oldId) $(this).attr("id", oldId.replace(/_0$/, "_" + inputCounter));

                    // Clear values for cloned inputs
                    $(this).val('');
                });

                // Update the remove button and show it
                newInput.find(".remove-button").show().click(function() {
                    newInput.remove();
                });

                // Append the new input element to the container
                $("#input-container").append(newInput);

                // Trigger initial calculation for amount in the new input section
                newInput.find("input[type='number']").on('keyup', function() {
                    var index = $(this).attr("id").split("_")[1];
                    updateAmount(index);
                });

                updateAmount(inputCounter);
            });
        });
    </script>
@endsection
