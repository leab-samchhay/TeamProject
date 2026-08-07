@extends('layouts.app')

@section('title', 'Update Product Variant')

@section('content')
    <div class="container-fluid mt-3">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-sm border-0 rounded-3">

                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">
                            <i class="ti ti-box me-2"></i>
                            Update Product Variant
                        </h4>

                        <a href="{{ route('product-variants.index') }}" class="btn btn-light btn-sm">
                            <i class="ti ti-arrow-left"></i> Back
                        </a>
                    </div>

                    <div class="card-body p-4">

                        <form action="{{ route('product-variants.update', $row->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label class="form-label fw-semibold">
                                        Product <span class="text-danger">*</span>
                                    </label>

                                    <select name="product_id" class="form-select" required>
                                        <option value="">— Choose Product —</option>
                                        @foreach ($products as $product)
                                            <option value="{{ $product->id }}"
                                                {{ old('product_id', $row->product_id) == $product->id ? 'selected' : '' }}>
                                                {{ $product->name }}
                                            </option>
                                        @endforeach
                                    </select>

                                    @error('product_id')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">
                                        SKU
                                    </label>

                                    <input type="text" name="sku" class="form-control"
                                        value="{{ old('sku', $row->sku) }}" placeholder="e.g. SKU-001">

                                    @error('sku')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">
                                        Barcode
                                    </label>

                                    <input type="text" name="barcode" class="form-control"
                                        value="{{ old('barcode', $row->barcode) }}" placeholder="Barcode">

                                    @error('barcode')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">
                                        QR Code
                                    </label>

                                    <input type="text" name="qr_code" class="form-control"
                                        value="{{ old('qr_code', $row->qr_code) }}" placeholder="QR Code">

                                    @error('qr_code')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">
                                        Cost
                                    </label>

                                    <input type="number" step="0.01" name="cost" class="form-control"
                                        value="{{ old('cost', $row->cost) }}" placeholder="0.00" min="0">

                                    @error('cost')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">
                                        Selling Price
                                    </label>

                                    <input type="number" step="0.01" name="selling_price" class="form-control"
                                        value="{{ old('selling_price', $row->selling_price) }}" placeholder="0.00"
                                        min="0">

                                    @error('selling_price')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">
                                        Wholesale Price
                                    </label>

                                    <input type="number" step="0.01" name="wholesale_price" class="form-control"
                                        value="{{ old('wholesale_price', $row->wholesale_price) }}" placeholder="0.00"
                                        min="0">

                                    @error('wholesale_price')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">
                                        Minimum Stock
                                    </label>

                                    <input type="number" name="minimum_stock" class="form-control"
                                        value="{{ old('minimum_stock', $row->minimum_stock) }}" placeholder="0"
                                        min="0">

                                    @error('minimum_stock')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">
                                        Current Stock
                                    </label>

                                    <input type="number" name="current_stock" class="form-control"
                                        value="{{ old('current_stock', $row->current_stock) }}" placeholder="0"
                                        min="0">

                                    @error('current_stock')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">
                                        Weight (kg)
                                    </label>

                                    <input type="number" step="0.01" name="weight" class="form-control"
                                        value="{{ old('weight', $row->weight) }}" placeholder="0.00" min="0">

                                    @error('weight')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label class="form-label fw-semibold">
                                        Image
                                    </label>

                                    @if ($row->image)
                                        <div class="mb-2">
                                            <img src="{{ asset('storage/' . $row->image) }}" alt="{{ $row->sku }}"
                                                class="rounded" style="width: 60px; height: 60px; object-fit: cover;">
                                        </div>
                                    @endif

                                    <input type="file" name="image" class="form-control" accept="image/*">

                                    <small class="text-muted">Leave empty to keep the current image.</small>

                                    @error('image')
                                        <small class="text-danger d-block">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label class="form-label fw-semibold">
                                        Status
                                    </label>

                                    <select name="status" class="form-select">
                                        <option value="1" {{ $row->status ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ !$row->status ? 'selected' : '' }}>Inactive</option>
                                    </select>

                                    @error('status')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                            </div>


                            <div class="d-flex justify-content-end gap-2">

                                <button type="reset" class="btn btn-secondary">
                                    Cancel
                                </button>

                                <button type="submit" class="btn btn-primary">
                                    <i class="ti ti-device-floppy me-1"></i>
                                    Update Variant
                                </button>

                            </div>

                        </form>

                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

</form>
</div>
@endsection
