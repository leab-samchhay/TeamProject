@extends('layouts.app')

@section('title', 'Update InvoiceDetail')

@section('content')
    <div class="container-fluid mt-3">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-sm border-0 rounded-3">

                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">
                            <i class="ti ti-box me-2"></i>
                            Update InvoiceDetail
                        </h4>

                        <a href="{{ route('invoiceDetail.index') }}" class="btn btn-light btn-sm">
                            <i class="ti ti-arrow-left"></i> Back
                        </a>
                    </div>

                    <div class="card-body p-4">

                        <form action="{{ route('invoiceDetail.update', $invoiceDetail->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">
                                        Invoice ID <span class="text-danger">*</span>
                                    </label>

                                    <select name="InvoiceID" class="form-select">
                                        <option value="">Select Invoice ID</option>
                                        @foreach ($invoices as $invoice)
                                            <option value="{{ $invoice->id }}" {{ old('InvoiceID', $invoiceDetail->InvoiceID) == $invoice->id ? 'selected' : '' }}>
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
                                        <option value="">Select Product ID</option>
                                        @foreach ($products as $product)
                                            <option value="{{ $product->id }}" {{ old('ProductID', $invoiceDetail->ProductID) == $product->id ? 'selected' : '' }}>
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
                                        value="{{ old('qty', $invoiceDetail->qty) }}">

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
                                        value="{{ old('price', $invoiceDetail->price) }}">

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
                                        value="{{ old('cost', $invoiceDetail->cost) }}">

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
                                        value="{{ old('totalPay', $invoiceDetail->totalPay) }}">

                                    @error('totalPay')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label class="form-label fw-semibold">
                                        discount<span class="text-danger">*</span>
                                    </label>

                                    <input type="text"
                                        name="discount"
                                        class="form-control"
                                        value="{{ old('discount', $invoiceDetail->discount) }}">

                                    @error('discount')
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
                                    Update InvoiceDetail
                                </button>

                            </div>

                        </form>

                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

