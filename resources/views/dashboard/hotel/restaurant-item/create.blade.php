@extends('dashboard.layouts.app')

@section('contents')
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active"><a href="{{ route('dashboard.home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{route('dashboard.hotel.restaurant-items.index')}}">Restaurant Item</a></li>
                    <li class="breadcrumb-item">{{ isset($item) ? 'Update' : 'Create' }}</li>
                </ol>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">{{ isset($item) ? 'Update Item' : 'Create Item' }}</h4>
                    </div>
                    <div class="card-body">
                        <form
                            action="{{ isset($item) ? route('dashboard.hotel.restaurant-items.update', $item->id) : route('dashboard.hotel.restaurant-items.store') }}"
                            enctype="multipart/form-data" method="POST">
                            @csrf
                            @if (isset($item))
                                @method('PUT')
                                <input type="hidden" name="item_id" value="{{ $item->id }}">
                            @endif

                            <div class="row">
                                <div class="col-lg-8">
                                    <div class="row">
                                        <div class="col-lg-6 col-12 mb-3">
                                            <div class="form-group">
                                                <label for="name" class="text-label form-label">Name*</label>
                                                <input type="text" id="name" name="name"
                                                    class="form-control @error('name') is-invalid @enderror" placeholder="Name"
                                                    value="{{ old('name', $item->name ?? '') }}" required>
                                                @error('name')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-12 mb-3">
                                            <div class="form-group">
                                                <label for="price" class="text-label form-label">Price*</label>
                                                <input type="text" id="price" name="price"
                                                    class="form-control @error('price') is-invalid @enderror"
                                                    placeholder="Price" value="{{ old('price', $item->price ?? '') }}" required>
                                                @error('price')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-lg-6 col-12 mb-3">
                                            <div class="form-group">
                                                <div class="d-flex justify-content-between">
                                                    <label for="image" class="text-label form-label">File Upload</label>
                                                    <span>
                                                        @if (isset($item) && $item->image)
                                                        <a href="#" class="" type="button" data-bs-toggle="modal" data-bs-target="#item-modal">
                                                           {{'View existing image'}} 
                                                        </a>
                                                    @endif
                                                    </span>
                                                </div>
                                                <input type="file" id="image" name="image" class="form-control @error('image') is-invalid @enderror">
                                                @error('image')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-lg-6 col-12 mb-3">
                                            <div class="form-group">
                                                <label for="outlet" class="text-label form-label">Outlet*</label>
                                                <select id="outlet" name="outlet_id"
                                                    class="form-control @error('outlet_id') is-invalid @enderror" required>
                                                    <option value="" disabled>Select Outlet</option>
                                                    @foreach (getModelItems('restaurant-outlets') as $outlet)
                                                        <option value="{{ $outlet->id }}"
                                                            {{ old('outlet_id', $item->outlet_id ?? '') == $outlet->id ? 'selected' : '' }}>
                                                            {{ $outlet->name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('outlet_id')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-12 mb-3">
                                            <div class="form-group">
                                                <label for="description" class="text-label form-label">Description</label>
                                                <textarea id="description" name="description"
                                                    class="form-control @error('description') is-invalid @enderror">{{ old('description', $item->description ?? '') }}</textarea>
                                                @error('description')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="col-lg-6 col-12 mb-3">
                                        <div class="form-group">
                                            <label for="category" class="text-label form-label">Category*</label>
                                            <input list="categoryList" id="category" name="category"
                                                   class="form-control @error('category') is-invalid @enderror"
                                                   value="{{ old('category', $item->category ?? '') }}" required>
                                            <datalist id="categoryList">
                                                @foreach (getModelItems('item-categories') as $category)
                                                    <option value="{{ $category->name }}">{{ $category->name }}</option>
                                                @endforeach
                                            </datalist>
                                            @error('category')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        
                                    </div>
                                    <h6 class="card-header ">Publish Box</h6>
                                    <div class="card-body">
                                        <div class="form-check mb-3">
                                            <input type="checkbox" class="form-check-input border-danger" id="publish"
                                                name="publish" value="1" {{ old('publish', $item->is_available ?? false) ? 'checked' : '' }}
                                                style="border-width: 2px;">
                                            <label class="form-check-label" for="publish">Make available?</label>
                                        </div>
                                    </div>
                                    <div class="card-footer bg-transparent">
                                        <button class="btn btn-primary" type="submit">
                                            {{ isset($item) ? 'Update' : 'Publish' }}
                                        </button>
                                    </div>
                                </div>
                                
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="item-modal" tabindex="-1" role="dialog" aria-labelledby="item-modal"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    {{-- <h5 class="modal-title">Upload Restaurant Items</h5> --}}
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
               <div class="d-flex justify-content-center">
                @if (isset($item) && $item->image)
                <a href="{{ $item->itemImage() }}"
                    data-fancybox="gallery_{{ $item->id }}"
                    data-caption="{{ $item->name }}">
                    <img src="{{ $item->itemImage() }}"
                        alt="Image" class="img-thumbnail">
                </a>
            @endif
               </div>
            </div>
        </div>
    </div>
@endsection
