@extends('layouts.app')

@section('title', 'Product Variants')

@section('content')
    <div class="row my-2">
        <div class="col-12">
            @session('success')
                <div class="alert alert-success">{{ $value }}</div>
            @endsession
            @session('error')
                <div class="alert alert-danger">{{ $value }}</div>
            @endsession

            <div class="card">

                <div class="card-header d-flex align-items-center justify-content-between border-bottom border-light">
                    <h4 class="header-title">Manage Product Variants</h4>

                    <div>
                        <a href="{{ route('product-variants.create') }}" class="btn btn-success bg-gradient">
                            <i class="ti ti-plus me-1"></i> Add Variant
                        </a>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-nowrap mb-0">
                        <thead class="bg-light-subtle">
                            <tr>
                                <th class="ps-3">No</th>
                                <th>Image</th>
                                <th>Product</th>
                                <th>SKU</th>
                                <th>Barcode</th>
                                <th>Selling Price</th>
                                <th>Stock</th>
                                <th>Status</th>
                                <th class="text-center" style="width: 125px;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($rows as $row)
                                <tr>
                                    <td class="ps-3">{{ $loop->iteration }}</td>
                                    <td>
                                        @if ($row->image)
                                            <img src="{{ asset('storage/' . $row->image) }}" alt="{{ $row->sku }}"
                                                class="avatar-sm rounded"
                                                style="width: 40px; height: 40px; object-fit: cover;">
                                        @else
                                            <span class="text-muted">—</span>
                                        @endif
                                    </td>
                                    <td>{{ $row->product->name ?? '—' }}</td>
                                    <td>{{ $row->sku ?? '—' }}</td>
                                    <td>{{ $row->barcode ?? '—' }}</td>
                                    <td>{{ number_format($row->selling_price, 2) }}</td>
                                    <td>
                                        <span
                                            class="badge @if ($row->current_stock <= $row->minimum_stock) bg-warning @else bg-light text-dark @endif">
                                            {{ $row->current_stock }}
                                        </span>
                                    </td>
                                    <td>
                                        <span
                                            class="badge @if ($row->status) bg-primary @else bg-danger @endif">
                                            {{ $row->status ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                    <td class="pe-3">
                                        <div class="hstack gap-1 justify-content-end">
                                            <a href="{{ route('product-variants.edit', $row->id) }}"
                                                class="btn btn-soft-success btn-icon btn-sm rounded-circle"><i
                                                    class="ti ti-edit fs-16"></i></a>
                                            <a href="javascript:void(0);"
                                                onclick="event.preventDefault(); document.getElementById('variants_delete-{{ $row->id }}').submit();"
                                                class="btn btn-soft-danger btn-icon btn-sm rounded-circle"><i
                                                    class="ti ti-trash"></i></a>
                                        </div>
                                        <form id="variants_delete-{{ $row->id }}"
                                            action="{{ route('product-variants.destroy', $row->id) }}" method="POST"
                                            class="d-none">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center py-4">No Variants found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="card-footer">
                    <div class="d-flex justify-content-end gap-5 align-items-center justify-conten-center">
                        {{ $rows->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
