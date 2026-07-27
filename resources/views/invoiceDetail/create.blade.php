@extends('layouts.app')

@section('title', 'Create InvoiceDetail')

@section('content')
    <div class="container-fluid mt-3">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-sm border-0 rounded-3">

                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">
                            <i class="ti ti-box me-2"></i>
                            Create New InvoiceDetail
                        </h4>

                        <a href="{{ route('invoiceDetail.index') }}" class="btn btn-light btn-sm">
                            <i class="ti ti-arrow-left"></i> Back
                        </a>
                    </div>

                    <div class="card-body p-4">

                        <form action="{{ route('invoiceDetail.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">
                                        Invoice ID <span class="text-danger">*</span>
                                    </label>

                                    <select name="InvoiceID" class="form-select">
                                        <option>Select Invoice ID</option>
                                        @foreach ($invoices as $invoice )
                                            <option value="{{ $invoice->id }}"
                                                {{ old('InvoiceID') == $invoice->id ? 'selected' : '' }}>
                                                {{ $invoice->id }}
                                            </option>

                                        @endforeach
                                    </select>
                                    @error('InvoiceID')
                                        <small class="text-danger">{{ $message }}</small>

                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">
                                        Product ID <span class="text-danger">*</span>
                                    </label>

                                    <select name="ProductID" class="form-select">
                                        <option>Select Product ID</option>
                                        @foreach ($products as $product )
                                            <option value="{{$product->id }}" {{ old('ProductID') == $product->id ? 'select' : '' }}>
                                                {{ $product->id }}
                                            </option>

                                        @endforeach
                                    </select>
                                    @error('ProductID')
                                        <small class="text-danger">{{ $message }}</small>

                                    @enderror
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label class="form-label fw-semibold">
                                        Quantity <span class="text-danger">*</span>
                                    </label>

                                    <input type="number"
                                        name="qty"
                                        class="form-control"
                                        value="{{ old('qty') }}">

                                    @error('qty')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label class="form-label fw-semibold">
                                        Price <span class="text-danger">*</span>
                                    </label>

                                    <input type="text"
                                        name="price"
                                        class="form-control"
                                        value="{{ old('price') }}">

                                    @error('price')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label class="form-label fw-semibold">
                                        Cost <span class="text-danger">*</span>
                                    </label>

                                    <input type="text"
                                        name="cost"
                                        class="form-control"
                                        value="{{ old('cost') }}">

                                    @error('cost')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label class="form-label fw-semibold">
                                        Total Payment<span class="text-danger">*</span>
                                    </label>

                                    <input type="text"
                                        name="totalPay"
                                        class="form-control"
                                        value="{{ old('totalPay') }}">

                                    @error('totalPay')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label class="form-label fw-semibold">
                                        Discound<span class="text-danger">*</span>
                                    </label>

                                    <input type="text"
                                        name="discound"
                                        class="form-control"
                                        value="{{ old('discound') }}">

                                    @error('discound')
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
                                    Save InvoiceDetail
                                </button>

                            </div>

                        </form>

                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
