@extends('layouts.app')

@section('title', 'Create Exchange')

@section('content')
    <div class="container-fluid mt-3">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-sm border-0 rounded-3">

                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">
                            <i class="ti ti-user-shield me-2"></i>
                            Create New Exchange
                        </h4>

                        <a href="{{ route('exchange.index') }}" class="btn btn-light btn-sm">
                            <i class="ti ti-arrow-left"></i> Back
                        </a>
                    </div>

                    <div class="card-body p-4">

                        <form action="{{ route('exchange.store') }}" method="POST">
                            @csrf

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">
                                        From Currency <span class="text-danger">*</span>
                                    </label>

                                    <select name="from_currency_id" class="form-select">
                                        <option value="">Select From Currency</option>
                                        @foreach ($currencies as $currency)
                                            <option value="{{ $currency->id }}"
                                                {{ old('from_currency_id') == $currency->id ? 'selected' : '' }}>
                                                {{ $currency->currencycode }}
                                            </option>
                                        @endforeach
                                    </select>

                                    @error('from_currency_id')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">
                                        To Currency <span class="text-danger">*</span>
                                    </label>

                                    <select name="to_currency_id" class="form-select">
                                        <option value="">Select To Currency</option>
                                        @foreach ($currencies as $currency)
                                            <option value="{{ $currency->id }}"
                                                {{ old('to_currency_id') == $currency->id ? 'selected' : '' }}>
                                                {{ $currency->currencycode }}
                                            </option>
                                        @endforeach
                                    </select>

                                    @error('to_currency_id')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label class="form-label fw-semibold">
                                        Rate <span class="text-danger">*</span>
                                    </label>

                                    <input type="text"
                                        name="rate"
                                        class="form-control"
                                        value="{{ old('rate') }}">

                                    @error('rate')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label class="form-label fw-semibold">
                                        Date <span class="text-danger">*</span>
                                    </label>

                                    <input type="date"
                                        name="date"
                                        class="form-control"
                                        value="{{ old('date', now()->format('Y-m-d')) }}">

                                    @error('date')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="mb-3 col-md-12">
                                    <label class="form-label fw-semibold">
                                        Status
                                    </label>

                                    <select name="status" class="form-select">
                                        <option value="1" {{ old('status', 1) == 1 ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ old('status', 1) == 0 ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                </div>

                            </div>

                            <div class="d-flex justify-content-end gap-2">
                                <button type="reset" class="btn btn-secondary">
                                    Cancel
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="ti ti-device-floppy me-1"></i>
                                    Save Exchange
                                </button>
                            </div>

                        </form>

                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
