@extends('layouts.app')

@section('title', 'Update Invoice')

@section('content')
    <div class="container-fluid mt-3">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-sm border-0 rounded-3">

                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">
                            <i class="ti ti-box me-2"></i>
                            Update Invoice
                        </h4>

                        <a href="{{ route('invoice.index') }}" class="btn btn-light btn-sm">
                            <i class="ti ti-arrow-left"></i> Back
                        </a>
                    </div>

                    <div class="card-body p-4">

                        <form action="{{ route('invoice.update', $invoice->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label class="form-label fw-semibold">
                                        Invoice Date <span class="text-danger">*</span>
                                    </label>

                                    <input type="date"
                                        name="invoiceDate"
                                        class="form-control"
                                        value="{{ old('invoiceDate', $invoice->invoiceDate ? \Carbon\Carbon::parse($invoice->invoiceDate)->format('Y-m-d') : '') }}">

                                    @error('invoiceDate')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">
                                        Discround <span class="text-danger">*</span>
                                    </label>

                                    <input type="number"
                                        name="discound"
                                        class="form-control"
                                        value="{{ old('discound', $invoice->discound) }}">

                                    @error('discound')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">
                                        Total <span class="text-danger">*</span>
                                    </label>

                                    <input type="text"
                                        name="total"
                                        class="form-control"
                                        value="{{ old('total', $invoice->total) }}">

                                    @error('total')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">
                                        Customer <span class="text-danger">*</span>
                                    </label>

                                    <select name="CustomerID" class="form-select">
                                        <option value="">Select Customer</option>
                                        @foreach ($customers as $customer)
                                            <option value="{{ $customer->id }}"
                                                {{ old('CustomerID', $invoice->CustomerID) == $customer->id ? 'selected' : '' }}>
                                                {{ $customer->name }}
                                            </option>
                                        @endforeach
                                    </select>

                                    @error('CustomerID')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">
                                        User <span class="text-danger">*</span>
                                    </label>

                                    <select name="UserID" class="form-select">
                                        <option value="">Select User</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}"
                                                {{ old('UserID', $invoice->UserID) == $user->id ? 'selected' : '' }}>
                                                {{ $user->name }}
                                            </option>
                                        @endforeach
                                    </select>

                                    @error('UserID')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">
                                        Exchange <span class="text-danger">*</span>
                                    </label>

                                    <select name="ExchangeID" class="form-select">
                                        <option value="">Select Exchange</option>
                                        @foreach ($exchanges as $exchange)
                                            <option value="{{ $exchange->id }}"
                                                {{ old('ExchangeID', $invoice->ExchangeID) == $exchange->id ? 'selected' : '' }}>
                                                {{ $exchange->fromCurrency->currencycode ?? '-' }}
                                                🔜
                                                {{ $exchange->toCurrency->currencycode ?? '-' }}
                                            </option>
                                        @endforeach
                                    </select>

                                    @error('ExchangeID')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label class="form-label fw-semibold">
                                        Status
                                    </label>

                                    <select name="status" class="form-select">
                                        <option value="1" {{ old('status', $invoice->status) == 1 ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ old('status', $invoice->status) == 0 ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                </div>

                            </div>


                            <div class="d-flex justify-content-end gap-2">

                                <button type="reset" class="btn btn-secondary">
                                    Cancel
                                </button>

                                <button type="submit" class="btn btn-primary">
                                    <i class="ti ti-device-floppy me-1"></i>
                                    Update Invoice
                                </button>

                            </div>

                        </form>

                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
