@extends('layouts.app')

@section('title', 'Update PurchaseDetail')

@section('content')
    <div class="container-fluid mt-3">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-sm border-0 rounded-3">

                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">
                            <i class="ti ti-user-shield me-2"></i>
                            Update PurchaseDetail
                        </h4>

                        <a href="{{ route('purchaseDetail.index') }}" class="btn btn-light btn-sm">
                            <i class="ti ti-arrow-left"></i> Back
                        </a>
                    </div>

                    <div class="card-body p-4">

                        <form action="{{ route('purchaseDetail.update',$purchaseDetail->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                           <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">
                                        purchaseID <span class="text-danger">*</span>
                                    </label>

                                    <select name="purchaseID" class="form-select">
                                        <option value="">Select purchaseID </option>
                                        @foreach ($purchases as $puchas)
                                            <option value="{{ $puchas->id }}" @selected(old('puchasId',$purchaseDetail->purchaseID) == $puchas->id)>
                                                {{ $puchas->id }}
                                            </option>
                                        @endforeach
                                    </select>

                                    @error('purchaseID')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">
                                        ProductID <span class="text-danger">*</span>
                                    </label>

                                    <select name="productID" class="form-select">
                                        <option value="">Select Product </option>
                                        @foreach ($products as $product)
                                            <option value="{{ $product->id }}" @selected(old('productID',$purchaseDetail->purchaseID) == $product->id)>
                                                {{ $product->id }}
                                            </option>
                                        @endforeach
                                    </select>

                                    @error('productID')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">
                                        Quantity <span class="text-danger">*</span>
                                    </label>

                                    <input type="text"
                                        name="qty"
                                        class="form-control"
                                        value="{{ old('qty',$purchaseDetail->purchaseID) }}">

                                    @error('qty')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">
                                        Cost <span class="text-danger">*</span>
                                    </label>

                                    <input type="text"
                                        name="cost"
                                        class="form-control"
                                        value="{{ old('cost',$purchaseDetail->cost) }}">

                                    @error('cost')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>



                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">
                                        Discount <span class="text-danger">*</span>
                                    </label>

                                    <input type="number"
                                        name="discount"
                                        class="form-control"
                                        value="{{ old('discount',$purchaseDetail->discount) }}">

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
                                    Update Purchase
                                </button>

                            </div>

                        </form>

                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

