@extends('dashboard.layouts.app')

@section('contents')
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active"><a href="{{ route('dashboard.home') }}">Home</a></li>
                    <li class="breadcrumb-item active"><a href="{{ route('dashboard.hotel.store-items.index') }}">Store
                            Items</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Create</a></li>
                </ol>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Create Store Issue</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('dashboard.hotel.store-issues.store') }}" enctype="multipart/form-data"
                            method="POST">
                            @csrf
                            <div class="row justify-content-center">
                                <!-- Item Category -->
                                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 mb-3">
                                    <div class="form-group">
                                        <label for="store_item_category_id" class="text-label form-label">Item
                                            Category*</label>
                                        <select id="store_item_category_id" name="item_category_id"
                                            class="form-control @error('item_category_id') is-invalid @enderror" required>
                                            <option value="">Select Category</option>
                                            @foreach (getModelItems('item-categories') as $category)
                                                <option value="{{ $category->id }}"
                                                    {{ old('item_category_id', $store_issue_item->item_category_id ?? '') == $category->id ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('item_category_id')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-xl-9 col-lg-9 col-md-6 col-sm-12 mb-3">
                                    <div class="form-group">
                                        <label for="outlet_id" class="text-label form-label">Choose Outlet*</label>
                                        <select id="outlet_id" name="outlet_id"
                                            class="form-control @error('outlet_id') is-invalid @enderror" required>
                                            <option value="">Select Outlet</option>
                                            @foreach (getModelItems('outlets') as $outlet)
                                                <option value="{{ $outlet->id }}"
                                                    {{ old('outlet_id', $store_issue_item->outlet_id ?? '') == $outlet->id ? 'selected' : '' }}>
                                                    {{ $outlet->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('outlet_id')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Table Section -->
                            <div class="row">
                                <div class="table-responsive">
                                    <table class="table card-table display mb-4 shadow-hover table-responsive-lg">
                                        <thead>
                                            <tr>
                                                <th>Code</th>
                                                <th>Name</th>
                                                <th>Unit</th>
                                                <th>Quantity</th>
                                                <th>Numbers to give out</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td colspan="5"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-3">
                                    <div class="form-group" id="receipiant-field">
                                        <div class="d-flex justify-content-between">
                                            <label for="recipient_id" class="text-label form-label">Recipient*
                                            </label>
                                            <span>
                                                <a href="#" class="text-primary" id="choose-receipiant-name">Enter
                                                    name instead</a>
                                            </span>
                                        </div>
                                        <select id="recipient_id" name="recipient_id"
                                            class="form-control @error('recipient_id') is-invalid @enderror">
                                            <option value="">Select or Enter Recipient</option>
                                            @foreach ($recipients as $recipient)
                                                <option value="{{ $recipient->id }}"
                                                    {{ old('recipient_id') == $recipient->id ? 'selected' : '' }}>
                                                    {{ $recipient->user->name }}
                                                </option>
                                                <input type="hidden" name="recipient_name" value="{{ $recipient->user->name }}">
                                            @endforeach
                                        </select>

                                        @error('recipient_id')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group" id="extenal_recipient-field">
                                        <div class="d-flex justify-content-between">
                                            <label for="extenal_recipient_name" class="text-label form-label">Recipient*
                                            </label>
                                            <span>
                                                <a href="#" class="text-primary" id="select-receipiant">Select
                                                    Receipiant</a>
                                            </span>
                                        </div>
                                        <input type="text"
                                            class="form-control @error('extenal_recipient_name') is-invalid @enderror"
                                            name="extenal_recipient_name" value="{{ old('extenal_recipient_name') }}"
                                            id="">
                                        @error('extenal_recipient_name')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-xl-8 col-lg-8 col-md-4 col-sm-12 mb-3">

                                    <div class="form-group">
                                        <div class="d-flex justify-content-between">
                                            <label for="note" class="text-label form-label">Note
                                            </label>
                                        </div>
                                        <input type="text" class="form-control @error('note') is-invalid @enderror"
                                            name="note" value="{{ old('note') }}" id="">
                                        @error('note')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript for AJAX -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            $('#store_item_category_id').on('change', function() {
                var selectedCategoryId = $(this).val();
                var tableBody = $('table tbody');

                tableBody.empty(); // Clear the table before populating new data

                if (selectedCategoryId) {
                    $.ajax({
                        url: '{{ route('dashboard.hotel.fetch-store-items') }}',
                        type: 'GET',
                        data: {
                            category_id: selectedCategoryId
                        },
                        success: function(response) {
                            if (response.items.length > 0) {
                                $.each(response.items, function(index, item) {
                                    tableBody.append(`
                                        <tr>
                                            <td>${item.code}</td>
                                            <td>${item.name}</td>
                                            <td>${item.unit_measurement}</td>
                                            <td>${item.qty}</td>
                                            <td>
                                                <input type="number" name="items[${item.id}][qty]" 
                                                       class="form-control item-quantity"
                                                       min="0" max="${item.qty}" 
                                                       data-available="${item.qty}" 
                                                       placeholder="Enter quantity" value="">
                                            </td>
                                        </tr>
                                         <input type="hidden" name="items[${item.id}][store_item_id]" 
                                                       class="form-control store_item"
                                                       value="${item.id}">
                                    `);
                                });
                            } else {
                                tableBody.append(
                                    '<tr><td colspan="5">No items found</td></tr>');
                            }
                        },
                        error: function() {
                            Toastify({
                                text: 'Something went wrong',
                                duration: 5000,
                                gravity: 'top',
                                position: 'right',
                                backgroundColor: 'linear-gradient(to right, #ff5f6d, #ffc371)',
                            }).showToast();

                        }
                    });
                } else {
                    // tableBody.append('<tr><td colspan="5">Select a category</td></tr>');
                }
            });

            // Trigger change event to populate items on page load if category is pre-selected
            $('#store_item_category_id').trigger('change');

            // Validate input quantity
            $(document).on('input', '.item-quantity', function() {
                var availableQty = $(this).data('available');
                var enteredQty = $(this).val();

                if (enteredQty > availableQty) {
                    Toastify({
                        text: `You cannot give out more than ${availableQty} items.`,
                        duration: 5000,
                        gravity: 'top',
                        position: 'right',
                        backgroundColor: 'linear-gradient(to right, #ff5f6d, #ffc371)',
                    }).showToast();
                    // alert(`You cannot give out more than ${availableQty} items.`);
                    $(this).val(availableQty);
                }
            });
            $(document).ready(function() {
                $('#extenal_recipient-field').hide();
                $('#choose-receipiant-name').click(function(event) {
                    event.preventDefault();
                    $('#receipiant-field').hide().find('select').prop('disabled', true);
                    $('#extenal_recipient-field').show().find('input').prop('disabled', false);
                });

                $('#select-receipiant').click(function(event) {
                    event.preventDefault();
                    $('#extenal_recipient-field').hide().find('input').prop('disabled', true);
                    $('#receipiant-field').show().find('select').prop('disabled', false);
                });

            });
        });
    </script>
@endsection
