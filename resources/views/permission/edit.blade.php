@extends('layouts.app')

@section('title', 'Update Permission')

@section('content')
    <div class="container-fluid mt-3">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-sm border-0 rounded-3">

                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">
                            <i class="ti ti-box me-2"></i>
                            Update Permission
                        </h4>

                        <a href="{{ route('permission.index') }}" class="btn btn-light btn-sm">
                            <i class="ti ti-arrow-left"></i> Back
                        </a>
                    </div>

                    <div class="card-body p-4">

                        <form action="{{ route('permission.update', $permission->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label class="form-label fw-semibold">
                                        Permission Name <span class="text-danger">*</span>
                                    </label>

                                    <input type="text"
                                        name="permissionName"
                                        class="form-control"
                                        value="{{ old('permissionName', $permission->permissionName) }}">

                                    @error('permissionName')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label class="form-label fw-semibold">
                                        Permission Date <span class="text-danger">*</span>
                                    </label>

                                    <input type="date"
                                        name="permissionDate"
                                        class="form-control"
                                        value="{{ old('permissionDate', $permission->permissionDate ? \Carbon\Carbon::parse($permission->permissionDate)->format('Y-m-d') : '') }}">

                                    @error('permissionDate')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="mb-3 col-md-12">
                                    <label class="form-label fw-semibold">
                                        Status
                                    </label>

                                    <select name="status" class="form-select">
                                        <option value="1" {{ old('status', $permission->status) == 1 ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ old('status', $permission->status) == 0 ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                </div>

                            </div>


                            <div class="d-flex justify-content-end gap-2">

                                <button type="reset" class="btn btn-secondary">
                                    Cancel
                                </button>

                                <button type="submit" class="btn btn-primary">
                                    <i class="ti ti-device-floppy me-1"></i>
                                    Update Permission
                                </button>

                            </div>

                        </form>

                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

