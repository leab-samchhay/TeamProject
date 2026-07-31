@extends('layouts.app')

@section('title', 'Record Payment')

@section('content')
    <div class="container-fluid mt-3">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-sm border-0 rounded-3">

                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">
                            <i class="ti ti-receipt me-2"></i>
                            Record New Payment
                        </h4>

                        <a href="{{ route('payment.index') }}" class="btn btn-light btn-sm">
                            <i class="ti ti-arrow-left"></i> Back
                        </a>
                    </div>

                    <div class="card-body p-4">

                        <form action="{{ route('payment.store') }}" method="POST">
                            @csrf

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">
                                        Payment Method <span class="text-danger">*</span>
                                    </label>

                                    <select name="MethodID" class="form-select">
                                        <option value="">Select Method</option>
                                        @foreach ($paymentMethods as $method)
                                            <option value="{{ $method->id }}" {{ old('MethodID') == $method->id ? 'selected' : '' }}>
                                                {{ $method->MethodName }}
                                            </option>
                                        @endforeach
                                    </select>

                                    @error('MethodID')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">
                                        Invoice <span class="text-danger">*</span>
                                    </label>

                                    <select name="InvoiceID" class="form-select">
                                        <option value="">Select Invoice</option>
                                        @foreach ($invoices as $invoice)
                                            <option value="{{ $invoice->id }}" {{ old('InvoiceID') == $invoice->id ? 'selected' : '' }}>
                                                Invoice #{{ $invoice->id }} (Total: ${{ number_format($invoice->total, 2) }})
                                            </option>
                                        @endforeach
                                    </select>

                                    @error('InvoiceID')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">
                                        Total Payment ($) <span class="text-danger">*</span>
                                    </label>

                                    <input type="number"
                                        step="0.000001"
                                        name="TotalPayment"
                                        class="form-control"
                                        value="{{ old('TotalPayment') }}">

                                    @error('TotalPayment')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">
                                        Payment Date <span class="text-danger">*</span>
                                    </label>

                                    <input type="date"
                                        name="PaymentDate"
                                        class="form-control"
                                        value="{{ old('PaymentDate', date('Y-m-d')) }}">

                                    @error('PaymentDate')
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
                                    Save Payment
                                </button>
                            </div>

                        </form>

                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

