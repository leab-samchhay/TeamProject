{{-- @extends('layouts.app')
@section('title', 'Product')
@section('content')
    <div class="row my-2">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between border-bottom border-light">
                    <h4 class="header-title">Manage Product</h4>
                    <div>
                        <a href="{{ route('product.create') }}" class="btn btn-success bg-gradient"><i
                            class="ti ti-plus me-1"></i> Add Product</a>

                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-nowrap mb-0">
                        <thead class="bg-light-subtle">
                            <tr>
                                <th class="ps-3" style="width: 60px;">
                                    No
                                </th>
                                <th>Photo</th>
                                <th>Name</th>
                                <th>Name (Kh)</th>
                                <th>Barcode</th>
                                <th>Release</th>
                                <th>Expired</th>
                                <th>Category</th>
                                <th>Supplier</th>
                                <th>Unitype</th>
                                <th class="text-center">Qty Onhand</th>
                                <th class="text-center">Qty Alert</th>
                                <th>Status</th>
                                <th class="text-center" style="width: 125px;">Action</th>
                            </tr>
                        </thead><!-- end thead -->
                        <tbody>
                            @if ($rows)
                                @foreach ($rows as $row )
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td>
                                            @if ($row->Photo)
                                                <img src="{{ asset('storage/' . $row->Photo) }}" alt="{{ $row->ProName }}"
                                                    class="rounded" width="40" height="40"
                                                    style="object-fit: cover;">
                                            @else
                                                <span class="text-muted">No photo</span>
                                            @endif
                                        </td>
                                        <td>{{ $row->ProName }}</td>
                                        <td>{{ $row->ProNameKh }}</td>
                                        <td>{{ $row->Barcode }}</td>
                                        <td>{{ $row->ReleaseDate}}</td>
                                        <td>{{ $row->ExpiredDate}}</td>
                                        <td>{{ $row->category->name ?? '-' }}</td>
                                        <td>{{ $row->supplier->name ?? '-' }}</td>
                                        <td>{{ $row->unitype->name ?? '-' }}</td>
                                        <td class="text-center">
                                            @if($row->Qty_Onhand <= $row->Qty_Alert)
                                                <span class="badge bg-danger">{{ $row->Qty_Onhand }}</span>
                                            @else
                                                {{ $row->Qty_Onhand }}
                                            @endif
                                        </td>
                                        <td class="text-center">{{ $row->Qty_Alert }}</td>
                                        <td>
                                            @if($row->Status == true)
                                                <button class="btn btn-sm text-white bg-success">
                                                    Active
                                                </button>
                                            @else
                                                <button class="btn btn-sm text-white bg-danger">
                                                    Inactive
                                                </button>
                                            @endif
                                        </td>

                                        <td class="pe-3">
                                            <div class="hstack gap-1 justify-content-end">

                                                <a href="{{ route('product.edit',$row->id) }}"
                                                    class="btn btn-soft-success btn-icon btn-sm rounded-circle"> <i
                                                        class="ti ti-edit fs-16"></i></a>

                                                <form action="{{ route('product.remove', $row->id) }}" method="POST"
                                                    onsubmit="return confirm('Are you sure you want to delete this product?')"
                                                    style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit"
                                                        class="btn btn-soft-danger btn-icon btn-sm rounded-circle mt-0">
                                                        <i class="ti ti-trash"></i>
                                                    </button>
                                                </form>

                                            </div>
                                        </td>
                                    </tr>
                                @endforeach

                            @endif


                        </tbody><!-- end tbody -->
                    </table><!-- end table -->
                </div>
                <div class="card-footer">
                    <div class="d-flex justify-content-end gap-5 align-items-center justify-conten-center">
                        {{ $rows->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection --}}



@extends('layouts.app')
@section('title', 'Product')
@section('content')
    <div class="row my-2">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between border-bottom border-light">
                    <h4 class="header-title">Manage Product</h4>
                    <div>
                        <a href="{{ route('product.create') }}" class="btn btn-success bg-gradient"><i
                            class="ti ti-plus me-1"></i> Add Product</a>
                    </div>
                </div>

                {{-- ==== SEARCH + CATEGORY FILTER NAVBAR ==== --}}
                <div class="card-body border-bottom">
                    <form action="{{ route('product.index') }}" method="GET" class="d-flex flex-wrap gap-2 align-items-center">

                        {{-- Search by name --}}
                        <div class="flex-grow-1" style="min-width: 220px;">
                            <input type="text" name="search" value="{{ request('search') }}"
                                class="form-control" placeholder="Search product name...">
                        </div>

                        <button type="submit" class="btn btn-primary"><i class="ti ti-search me-1"></i> Search</button>

                        @if(request('search') || request('category_id'))
                            <a href="{{ route('product.index') }}" class="btn btn-light">Reset</a>
                        @endif

                        {{-- Category filter dropdown --}}
                        <div class="dropdown">
                            <button class="btn btn-outline-secondary dropdown-toggle" type="button"
                                id="categoryDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                @if(request('category_id'))
                                    {{ optional($categories->firstWhere('id', request('category_id')))->name ?? 'Category' }}
                                @else
                                    All Categories
                                @endif
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="categoryDropdown">
                                <li>
                                    <a class="dropdown-item {{ !request('category_id') ? 'active' : '' }}"
                                        href="{{ route('product.index', array_merge(request()->except('category_id'), [])) }}">
                                        All Categories
                                    </a>
                                </li>
                                @foreach ($categories as $category)
                                    <li>
                                        <a class="dropdown-item {{ request('category_id') == $category->id ? 'active' : '' }}"
                                            href="{{ route('product.index', array_merge(request()->except('category_id'), ['category_id' => $category->id])) }}">
                                            {{ $category->name }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                    </form>
                </div>
                {{-- ==== END NAVBAR ==== --}}

                <div class="table-responsive">
                    <table class="table table-nowrap mb-0">
                        <thead class="bg-light-subtle">
                            <tr>
                                <th class="ps-3" style="width: 60px;">No</th>
                                <th>Photo</th>
                                <th>Name</th>
                                <th>Name (Kh)</th>
                                <th>Barcode</th>
                                <th>Release</th>
                                <th>Expired</th>
                                <th>Category</th>
                                <th>Supplier</th>
                                <th>Unitype</th>
                                <th class="text-center">Qty Onhand</th>
                                <th class="text-center">Qty Alert</th>
                                <th class="text-center">Price</th>
                                <th>Status</th>
                                <th class="text-center" style="width: 125px;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($rows)
                                @foreach ($rows as $row )
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td>
                                            @if ($row->Photo)
                                                <img src="{{ asset('storage/' . $row->Photo) }}" alt="{{ $row->ProName }}"
                                                    class="rounded" width="40" height="40"
                                                    style="object-fit: cover;">
                                            @else
                                                <span class="text-muted">No photo</span>
                                            @endif
                                        </td>
                                        <td>{{ $row->ProName }}</td>
                                        <td>{{ $row->ProNameKh }}</td>
                                        <td>{{ $row->Barcode }}</td>
                                        <td>{{ $row->ReleaseDate}}</td>
                                        <td>{{ $row->ExpiredDate}}</td>
                                        <td>{{ $row->category->name ?? '-' }}</td>
                                        <td>{{ $row->supplier->name ?? '-' }}</td>
                                        <td>{{ $row->unitype->name ?? '-' }}</td>
                                        <td class="text-center">
                                            @if($row->Qty_Onhand <= $row->Qty_Alert)
                                                <span class="badge bg-danger">{{ $row->Qty_Onhand }}</span>
                                            @else
                                                {{ $row->Qty_Onhand }}
                                            @endif
                                        </td>
                                        <td class="text-center">{{ $row->Qty_Alert }}</td>
                                        <td class="text-center">{{ $row->price }}</td>
                                        <td>
                                            @if($row->Status == true)
                                                <button class="btn btn-sm text-white bg-success">Active</button>
                                            @else
                                                <button class="btn btn-sm text-white bg-danger">Inactive</button>
                                            @endif
                                        </td>
                                        <td class="pe-3">
                                            <div class="hstack gap-1 justify-content-end">
                                                <a href="{{ route('product.edit',$row->id) }}"
                                                    class="btn btn-soft-success btn-icon btn-sm rounded-circle"> <i
                                                        class="ti ti-edit fs-16"></i></a>
                                                <form action="{{ route('product.remove', $row->id) }}" method="POST"
                                                    onsubmit="return confirm('Are you sure you want to delete this product?')"
                                                    style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="btn btn-soft-danger btn-icon btn-sm rounded-circle mt-0">
                                                        <i class="ti ti-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="14" class="text-center py-4">No products found.</td>
                                </tr>
                            @endif
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
@endsection

