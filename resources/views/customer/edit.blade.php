
@extends('layouts.app')

@section('title', 'Update Customer')

@section('content')
    <div class="container-fluid mt-3">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-sm border-0 rounded-3">

                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">
                            <i class="ti ti-user-shield me-2"></i>
                            Update Customer
                        </h4>

                        <a href="{{ route('customer.index') }}" class="btn btn-light btn-sm">
                            <i class="ti ti-arrow-left"></i> Back
                        </a>
                    </div>

                    <div class="card-body p-4">

                        <form action="{{ route('customer.update',$customer->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <label class="form-label fw-semibold">
                                        Customer Name <span class="text-danger">*</span>
                                    </label>

                                    <input type="text"
                                        name="name"
                                        class="form-control"
                                        value="{{ old('name',$customer->name) }}">

                                    @error('name')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label class="form-label fw-semibold">
                                        Customer Sex <span class="text-danger">*</span>
                                    </label>

                                    <input type="text"
                                        name="sex"
                                        class="form-control"
                                        value="{{ old('sex',$customer->sex) }}">

                                    @error('sex')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label class="form-label fw-semibold">
                                        Customer Phone <span class="text-danger">*</span>
                                    </label>

                                    <input type="text"
                                        name="phone"
                                        class="form-control"
                                        value="{{ old('phone',$customer->phone) }}">

                                    @error('phone')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label class="form-label fw-semibold">
                                        Status
                                    </label>

                                    <select name="status" class="form-select">
                                        <option value="1" {{ old('active',$customer->active) == 1 ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ old('active',$customer->active) == 0 ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                </div>

                            </div>


                            <div class="d-flex justify-content-end gap-2">

                                <button type="reset" class="btn btn-secondary">
                                    Cancel
                                </button>

                                <button type="submit" class="btn btn-primary">
                                    <i class="ti ti-device-floppy me-1"></i>
                                    Update Customer
                                </button>

                            </div>

                        </form>

                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
```
