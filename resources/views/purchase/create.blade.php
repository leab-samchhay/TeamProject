@extends('layouts.app')

@section('title', 'Create Purchase')

@section('content')
    <div class="container-fluid mt-3">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-sm border-0 rounded-3">

                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">
                            <i class="ti ti-user-shield me-2"></i>
                            Create New Purchase
                        </h4>

                        <a href="{{ route('purchase.index') }}" class="btn btn-light btn-sm">
                            <i class="ti ti-arrow-left"></i> Back
                        </a>
                    </div>

                    <div class="card-body p-4">

                        <form action="{{ route('purchase.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">
                                        Bill No <span class="text-danger">*</span>
                                    </label>

                                    <input type="text"
                                        name="buillno"
                                        class="form-control"
                                        value="{{ old('buillno') }}">

                                    @error('buillno')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">
                                        Purchase Date <span class="text-danger">*</span>
                                    </label>

                                    <input type="date"
                                        name="puchaseDate"
                                        class="form-control"
                                        value="{{ old('puchaseDate') }}">

                                    @error('puchaseDate')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">
                                        Supplier <span class="text-danger">*</span>
                                    </label>

                                    <select name="supplierId" class="form-select">
                                        <option value="">-- Select Supplier --</option>
                                        @foreach ($suppliers as $supplier)
                                            <option value="{{ $supplier->id }}" @selected(old('supplierId') == $supplier->id)>
                                                {{ $supplier->name }}
                                            </option>
                                        @endforeach
                                    </select>

                                    @error('supplierId')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">
                                        User <span class="text-danger">*</span>
                                    </label>

                                    <select name="userId" class="form-select">
                                        <option value="">-- Select User --</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}" @selected(old('userId') == $user->id)>
                                                {{ $user->name }}
                                            </option>
                                        @endforeach
                                    </select>

                                    @error('userId')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">
                                        Total Amount <span class="text-danger">*</span>
                                    </label>

                                    <input type="number"
                                        step="0.01"
                                        name="totalAmount"
                                        class="form-control"
                                        value="{{ old('totalAmount') }}">

                                    @error('totalAmount')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">
                                        Discount <span class="text-danger">*</span>
                                    </label>

                                    <input type="number"
                                        name="discound"
                                        class="form-control"
                                        value="{{ old('discound') }}">

                                    @error('discound')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label class="form-label fw-semibold">
                                        Status
                                    </label>

                                    <select name="status" class="form-select">
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                </div>

                            </div>

                            <div class="d-flex justify-content-end gap-2">

                                <button type="reset" class="btn btn-secondary">
                                    Cancel
                                </button>

                                <button type="submit" class="btn btn-primary">
                                    <i class="ti ti-device-floppy me-1"></i>
                                    Save Purchase
                                </button>

                            </div>

                        </form>

                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
