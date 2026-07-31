
@extends('layouts.app')

@section('title', 'Update Supllier')

@section('content')
    <div class="container-fluid mt-3">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-sm border-0 rounded-3">

                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">
                            <i class="ti ti-user-shield me-2"></i>
                            Update Supllier
                        </h4>

                        <a href="{{ route('supplier.index') }}" class="btn btn-light btn-sm">
                            <i class="ti ti-arrow-left"></i> Back
                        </a>
                    </div>

                    <div class="card-body p-4">

                        <form action="{{ route('supplier.update',$supplier->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                           <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">
                                        Supplier Name <span class="text-danger">*</span>
                                    </label>

                                    <input type="text"
                                        name="name"
                                        class="form-control"
                                        value="{{ old('name',$supplier->name) }}">

                                    @error('name')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">
                                        Supplier Phone <span class="text-danger">*</span>
                                    </label>

                                    <input type="text"
                                        name="phone"
                                        class="form-control"
                                        value="{{ old('phone',$supplier->phone) }}">

                                    @error('phone')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">
                                        Supplier Email <span class="text-danger">*</span>
                                    </label>

                                    <input type="email"
                                        name="email"
                                        class="form-control"
                                        value="{{ old('email',$supplier->email) }}">

                                    @error('email')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label class="form-label fw-semibold">
                                        Status
                                    </label>

                                    <select name="status" class="form-select">
                                        <option value="1" {{ old('active',$supplier->active) == 1 ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ old('active',$supplier->active) == 0 ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                </div>


                                <div class="col-md-12 mb-3">
                                    <label class="form-label fw-semibold">
                                        Supplier Address <span class="text-danger">*</span>
                                    </label>

                                    <textarea
                                        name="address"
                                        rows="2"
                                        class="form-control">{{ old('address',$supplier->address) }}</textarea>

                                    @error('address')
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
                                    Update Supplier
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

