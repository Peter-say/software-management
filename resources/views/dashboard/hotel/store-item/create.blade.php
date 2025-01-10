@extends('dashboard.layouts.app')

@section('contents')
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active"><a href="{{ route('dashboard.home') }}">Home</a></li>
                    <li class="breadcrumb-item active"><a href="{{ route('dashboard.hotel.store-items.index') }}">Store Items</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Create</a></li>
                </ol>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">{{ isset($store_item) ? 'Update Store Item' : 'Create Store Item' }}</h4>
                    </div>
                    <div class="card-body">
                        <form
                            action="{{ isset($store_item) ? route('dashboard.hotel.store-items.update', $store_item->id) : route('dashboard.hotel.store-items.store') }}"
                            enctype="multipart/form-data" method="POST">
                            @csrf
                            @if (isset($store_item))
                                @method('PUT')
                                <input type="hidden" name="store_item_id" value="{{ $store_item->id }}">
                            @endif
                            <div class="row justify-content-center">
                                <!-- Item Category -->
                                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 mb-3">
                                    <div class="form-group">
                                        <label for="item_category_id" class="text-label form-label">Item Category*</label>
                                        <select id="item_category_id" name="item_category_id"
                                            class="form-control @error('item_category_id') is-invalid @enderror" required>
                                            <option value="">Select Category</option>
                                            @foreach (getModelItems('item-categories') as $category)
                                                <option value="{{ $category->id }}"
                                                    {{ old('item_category_id', $store_item->item_category_id ?? '') == $category->id ? 'selected' : '' }}>
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

                                <!-- Item Sub-Category -->
                                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 mb-3">
                                    <div class="form-group">
                                        <label for="item_sub_category_id" class="text-label form-label">Item
                                            Sub-Category</label>
                                        <select id="item_sub_category_id" name="item_sub_category_id"
                                            class="form-control @error('item_sub_category_id') is-invalid @enderror">
                                            <option value="">Select Sub-Category</option>
                                            @foreach (getModelItems('item-sub_categories')  as $subCategory)
                                                <option value="{{ $subCategory->id }}"
                                                    {{ old('item_sub_category_id', $store_item->item_sub_category_id ?? '') == $subCategory->id ? 'selected' : '' }}>
                                                    {{ $subCategory->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('item_sub_category_id')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Name -->
                                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 mb-3">
                                    <div class="form-group">
                                        <label for="name" class="text-label form-label">Name*</label>
                                        <input type="text" id="name" name="name"
                                            class="form-control @error('name') is-invalid @enderror"
                                            value="{{ old('name', $store_item->name ?? '') }}" required>
                                        @error('name')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                               <!-- Image -->
                                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 mb-3">
                                    <div class="form-group">
                                        <label for="image" class="text-label form-label">Image</label>
                                        <input type="file" id="image" name="image"
                                            class="form-control @error('image') is-invalid @enderror">
                                        @error('image')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Description -->
                                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 mb-3">
                                    <div class="form-group">
                                        <label for="description" class="text-label form-label">Description</label>
                                        <textarea id="description" name="description" class="form-control @error('description') is-invalid @enderror">{{ old('description', $store_item->description ?? '') }}</textarea>
                                        @error('description')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Unit Measurement -->
                                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 mb-3">
                                    <div class="form-group">
                                        <label for="unit_measurement" class="text-label form-label">Unit
                                            Measurement*</label>
                                        <select id="unit_measurement" name="unit_measurement"
                                            class="form-control @error('unit_measurement') is-invalid @enderror" required>
                                            <option value="" disabled
                                                {{ old('unit_measurement', $store_item->unit_measurement ?? '') == '' ? 'selected' : '' }}>
                                                Select Unit Measurement</option>
                                            <option value="kg"
                                                {{ old('unit_measurement', $store_item->unit_measurement ?? '') == 'kg' ? 'selected' : '' }}>
                                                Kilogram (kg)</option>
                                            <option value="g"
                                                {{ old('unit_measurement', $store_item->unit_measurement ?? '') == 'g' ? 'selected' : '' }}>
                                                Gram (g)</option>
                                            <option value="l"
                                                {{ old('unit_measurement', $store_item->unit_measurement ?? '') == 'l' ? 'selected' : '' }}>
                                                Liter (l)</option>
                                            <option value="ml"
                                                {{ old('unit_measurement', $store_item->unit_measurement ?? '') == 'ml' ? 'selected' : '' }}>
                                                Milliliter (ml)</option>
                                            <option value="pcs"
                                                {{ old('unit_measurement', $store_item->unit_measurement ?? '') == 'pcs' ? 'selected' : '' }}>
                                                Pieces (pcs)</option>
                                            <option value="box"
                                                {{ old('unit_measurement', $store_item->unit_measurement ?? '') == 'box' ? 'selected' : '' }}>
                                                Box</option>
                                            <option value="set"
                                                {{ old('unit_measurement', $store_item->unit_measurement ?? '') == 'set' ? 'selected' : '' }}>
                                                Set</option>
                                        </select>
                                        @error('unit_measurement')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>


                                <!-- Quantity -->
                                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 mb-3">
                                    <div class="form-group">
                                        <label for="qty" class="text-label form-label">Quantity*</label>
                                        <input type="number" id="qty" name="qty"
                                            class="form-control @error('qty') is-invalid @enderror"
                                            value="{{ old('qty', $store_item->qty ?? 0) }}" required>
                                        @error('qty')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Prices -->
                                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 mb-3">
                                    <div class="form-group">
                                        <label for="cost_price" class="text-label form-label">Cost Price</label>
                                        <input type="number" step="0.01" id="cost_price" name="cost_price"
                                            class="form-control @error('cost_price') is-invalid @enderror"
                                            value="{{ old('cost_price', $store_item->cost_price ?? '') }}">
                                        @error('cost_price')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="selling_price" class="text-label form-label">Selling Price</label>
                                        <input type="number" step="0.01" id="selling_price" name="selling_price"
                                            class="form-control @error('selling_price') is-invalid @enderror"
                                            value="{{ old('selling_price', $store_item->selling_price ?? '') }}">
                                        @error('selling_price')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Low Stock Alert -->
                                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 mb-3">
                                    <div class="form-group">
                                        <label for="low_stock_alert" class="text-label form-label">Low Stock Alert</label>
                                        <input type="number" id="low_stock_alert" name="low_stock_alert"
                                            class="form-control @error('low_stock_alert') is-invalid @enderror"
                                            value="{{ old('low_stock_alert', $store_item->low_stock_alert ?? '') }}">
                                        @error('low_stock_alert')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- For Sale -->
                                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 mb-3">
                                    <div class="form-group">
                                        <label for="for_sale" class="text-label form-label">For Sale</label>
                                        <select id="for_sale" name="for_sale"
                                            class="form-control @error('for_sale') is-invalid @enderror">
                                            <option value="1"
                                                {{ old('for_sale', $store_item->for_sale ?? true) == 1 ? 'selected' : '' }}>
                                                Yes</option>
                                            <option value="0"
                                                {{ old('for_sale', $store_item->for_sale ?? true) == 0 ? 'selected' : '' }}>
                                                No</option>
                                        </select>
                                        @error('for_sale')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <button type="submit"
                                class="btn btn-primary">{{ isset($store_item) ? 'Update' : 'Submit' }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
