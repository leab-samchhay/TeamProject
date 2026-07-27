@extends('layouts.app')

@section('title', 'Create Product')

@section('content')
    <div class="container-fluid mt-3">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-sm border-0 rounded-3">

                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">
                            <i class="ti ti-box me-2"></i>
                            Create New Product
                        </h4>

                        <a href="{{ route('product.index') }}" class="btn btn-light btn-sm">
                            <i class="ti ti-arrow-left"></i> Back
                        </a>
                    </div>

                    <div class="card-body p-4">

                        <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">
                                        Product Name <span class="text-danger">*</span>
                                    </label>

                                    <input type="text"
                                        name="ProName"
                                        class="form-control"
                                        value="{{ old('ProName') }}">

                                    @error('ProName')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">
                                        Product Name (Khmer)
                                    </label>

                                    <input type="text"
                                        name="ProNameKh"
                                        class="form-control"
                                        value="{{ old('ProNameKh') }}">

                                    @error('ProNameKh')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">
                                        Barcode
                                    </label>

                                    <input type="text"
                                        name="Barcode"
                                        class="form-control"
                                        value="{{ old('Barcode') }}">

                                    @error('Barcode')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">
                                        Category <span class="text-danger">*</span>
                                    </label>

                                    <select name="CategoryID" class="form-select">
                                        <option value="">Select Category</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ old('CategoryID') == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>

                                    @error('CategoryID')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">
                                        Supplier <span class="text-danger">*</span>
                                    </label>

                                    <select name="SupplierID" class="form-select">
                                        <option value="">Select Supplier </option>
                                        @foreach ($suppliers as $supplier)
                                            <option value="{{ $supplier->id }}"
                                                {{ old('SupplierID') == $supplier->id ? 'selected' : '' }}>
                                                {{ $supplier->name }}
                                            </option>
                                        @endforeach
                                    </select>

                                    @error('SupplierID')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">
                                        Unitype <span class="text-danger">*</span>
                                    </label>

                                    <select name="UnitypeID" class="form-select">
                                        <option value="">Select Unitype </option>
                                        @foreach ($unitypes as $unitype)
                                            <option value="{{ $unitype->id }}"
                                                {{ old('UnitypeID') == $unitype->id ? 'selected' : '' }}>
                                                {{ $unitype->name }}
                                            </option>
                                        @endforeach
                                    </select>

                                    @error('SupplierID')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">
                                        Qty Onhand
                                    </label>

                                    <input type="number"
                                        name="Qty_Onhand"
                                        class="form-control"
                                        value="{{ old('Qty_Onhand') }}">

                                    @error('Qty_Onhand')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">
                                        Qty Alert
                                    </label>

                                    <input type="number"
                                        name="Qty_Alert"
                                        class="form-control"
                                        value="{{ old('Qty_Alert') }}">

                                    @error('Qty_Alert')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">
                                        Price
                                    </label>

                                    <input type="text"
                                        name="price"
                                        class="form-control"
                                        value="{{ old('price') }}">

                                    @error('price')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">
                                       Release Date
                                    </label>

                                    <input type="date"
                                        name="ReleaseDate"
                                        class="form-control"
                                        value="{{ old('ReleaseDate') }}">

                                    @error('ReleaseDate')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">
                                        Expired Date
                                    </label>

                                    <input type="date"
                                        name="ExpiredDate"
                                        class="form-control"
                                        value="{{ old('ExpiredDate') }}">

                                    @error('ExpiredDate')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label class="form-label fw-semibold">
                                        Status
                                    </label>

                                    <select name="Status" class="form-select">
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label class="form-label fw-semibold">
                                        Photo
                                    </label>

                                    <input type="file"
                                        name="Photo"
                                        class="form-control">

                                    @error('Photo')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label class="form-label fw-semibold">
                                        Remark
                                    </label>

                                    <textarea name="Remark"
                                        class="form-control"
                                        rows="1">{{ old('Remark') }}</textarea>

                                    @error('Remark')
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
                                    Save Product
                                </button>

                            </div>

                        </form>

                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
