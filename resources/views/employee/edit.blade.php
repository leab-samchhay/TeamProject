
@extends('layouts.app')

@section('title', 'Update Employee')

@section('content')
    <div class="container-fluid mt-3">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-sm border-0 rounded-3">

                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">
                            <i class="ti ti-user-shield me-2"></i>
                            Update Employee
                        </h4>

                        <a href="{{ route('employee.index') }}" class="btn btn-light btn-sm">
                            <i class="ti ti-arrow-left"></i> Back
                        </a>
                    </div>

                    <div class="card-body p-4">

                        <form action="{{ route('employee.update',$employee->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <label class="form-label fw-semibold">
                                        Employee Name <span class="text-danger">*</span>
                                    </label>

                                    <input type="text"
                                        name="name"
                                        class="form-control"
                                        value="{{ old('name',$employee->name) }}">

                                    @error('name')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label class="form-label fw-semibold">
                                        Employee Sex <span class="text-danger">*</span>
                                    </label>

                                    <input type="text"
                                        name="sex"
                                        class="form-control"
                                        value="{{ old('sex',$employee->sex) }}">

                                    @error('sex')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label class="form-label fw-semibold">
                                        Employee Phone <span class="text-danger">*</span>
                                    </label>

                                    <input type="text"
                                        name="phone"
                                        class="form-control"
                                        value="{{ old('phone',$employee->phone) }}">

                                    @error('phone')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label class="form-label fw-semibold">
                                        Employee Email <span class="text-danger">*</span>
                                    </label>

                                    <input type="text"
                                        name="email"
                                        class="form-control"
                                        value="{{ old('email',$employee->email) }}">

                                    @error('email')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label class="form-label fw-semibold">
                                        Employee Role <span class="text-danger">*</span>
                                    </label>

                                    <input type="text"
                                        name="role"
                                        class="form-control"
                                        value="{{ old('role',$employee->role) }}">

                                    @error('role')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label class="form-label fw-semibold">
                                        Status
                                    </label>

                                    <select name="status" class="form-select">
                                        <option value="1" {{ old('active',$employee->active) == 1 ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ old('active',$employee->active) == 0 ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                </div>


                                <div class="mb-3">
                                    <label class="form-label fw-semibold">
                                        Profile
                                    </label>

                                    <input type="file"
                                        name="photo"
                                        value="{{ old('photo',$employee->photo) }}"
                                        class="form-control">

                                    @error('photo')
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
                                    Update Employee
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

