@extends('layouts.app')

@section('title', 'Update User')

@section('content')
    <div class="container-fluid mt-3">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-sm border-0 rounded-3">

                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">
                            <i class="ti ti-box me-2"></i>
                            Update User
                        </h4>

                        <a href="{{ route('user.index') }}" class="btn btn-light btn-sm">
                            <i class="ti ti-arrow-left"></i> Back
                        </a>
                    </div>

                    <div class="card-body p-4">

                        <form action="{{ route('user.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label class="form-label fw-semibold">
                                        User Name <span class="text-danger">*</span>
                                    </label>

                                    <input type="text"
                                        name="name"
                                        class="form-control"
                                        value="{{ old('name', $user->name) }}">

                                    @error('name')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label class="form-label fw-semibold">
                                        Email <span class="text-danger">*</span>
                                    </label>

                                    <input type="email"
                                        name="email"
                                        class="form-control"
                                        value="{{ old('email', $user->email) }}">

                                    @error('email')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label class="form-label fw-semibold">
                                        Password <span class="text-danger">*</span>
                                    </label>

                                    <input type="password"
                                        name="password"
                                        class="form-control"
                                        value="{{ old('password', $user->password) }}">

                                    @error('password')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">
                                        Permission <span class="text-danger">*</span>
                                    </label>

                                    <select name="permission_id" class="form-select">
                                        <option value="">Select Permission</option>
                                        @foreach ($permissions as $permision)
                                            <option value="{{ $permision->id }}"
                                                {{ old('permission_id', $user->id) == $permision->id ? 'selected' : '' }}>
                                                {{ $permision->permissionName }}
                                            </option>
                                        @endforeach
                                    </select>

                                    @error('permission_id')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">
                                        Role <span class="text-danger">*</span>
                                    </label>

                                    <select name="role_id" class="form-select">
                                        <option value="">Select Role</option>
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->id }}"
                                                {{ old('role_id', $user->role_id) == $role->id ? 'selected' : '' }}>
                                                {{ $role->name }}
                                            </option>
                                        @endforeach
                                    </select>

                                    @error('role_id')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label class="form-label fw-semibold">
                                        Expired Date <span class="text-danger">*</span>
                                    </label>

                                    <input type="date"
                                        name="expired"
                                        class="form-control"
                                        value="{{ old('expired', $user->expired) }}">

                                    @error('expired')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>


                                <div class="mb-3 col-md-12">
                                    <label class="form-label fw-semibold">
                                        Status
                                    </label>

                                    <select name="Status" class="form-select">
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
                                    Update User
                                </button>

                            </div>

                        </form>

                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
