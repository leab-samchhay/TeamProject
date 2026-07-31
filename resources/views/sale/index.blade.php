@extends('layouts.app')
@section('title', 'Product Sale')

@section('content')
    {{-- ==== FLASH MESSAGES ==== --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show my-2" role="alert">
            <i class="ti ti-check me-1"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show my-2" role="alert">
            <i class="ti ti-alert-circle me-1"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row g-3 my-2">
        {{-- ==== LEFT SIDE: PRODUCTS GRID ==== --}}
        <div class="col-12 col-lg-8">
            <div class="card h-100 mb-0">
                <div class="card-header d-flex align-items-center justify-content-between border-bottom border-light">
                    <h4 class="header-title mb-0">Product Sale</h4>
                </div>

                {{-- ==== SEARCH + CATEGORY FILTER NAVBAR ==== --}}
                <div class="card-body border-bottom">
                    <form action="{{ route('sale.index') }}" method="GET" class="d-flex flex-wrap gap-2 align-items-center">
                        <div class="flex-grow-1" style="min-width: 200px;">
                            <input type="text" name="search" value="{{ request('search') }}"
                                class="form-control" placeholder="Search Sale name...">
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="ti ti-search me-1"></i> Search
                        </button>

                        @if(request('search') || request('category_id'))
                            <a href="{{ route('sale.index') }}" class="btn btn-light">Reset</a>
                        @endif

                        <div class="dropdown">
                            <button class="btn btn-outline-secondary dropdown-toggle" type="button"
                                id="categoryDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                @if(request('category_id'))
                                    {{ optional($categories->firstWhere('id', request('category_id')))->name ?? 'Category' }}
                                @else
                                    All Categories
                                @endif
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="categoryDropdown">
                                <li>
                                    <a class="dropdown-item {{ !request('category_id') ? 'active' : '' }}"
                                        href="{{ route('sale.index', array_merge(request()->except('category_id'), [])) }}">
                                        All Categories
                                    </a>
                                </li>
                                @foreach ($categories as $category)
                                    <li>
                                        <a class="dropdown-item {{ request('category_id') == $category->id ? 'active' : '' }}"
                                            href="{{ route('sale.index', array_merge(request()->except('category_id'), ['category_id' => $category->id])) }}">
                                            {{ $category->name }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </form>
                </div>

                {{-- ==== PRODUCT GRID ==== --}}
                <div class="card-body">
                    <div class="row g-2">
                        @if ($rows && count($rows) > 0)
                            @foreach ($rows as $row)
                                <div class="col-6 col-sm-4 col-md-4 col-xl-3">
                                    <div class="card h-100 text-center border shadow-sm rounded overflow-hidden mb-0 product-card"
                                         style="cursor: pointer;"
                                         data-id="{{ $row->id }}"
                                         data-name="{{ $row->ProNameKh }}"
                                         data-price="{{ $row->price }}"
                                         data-photo="{{ $row->Photo ? asset('storage/' . $row->Photo) : '' }}">

                                        <div class="card-img-top bg-light" style="height: 150px; overflow: hidden;">
                                            @if ($row->Photo)
                                                <img src="{{ asset('storage/' . $row->Photo) }}" alt="{{ $row->ProNameKh }}"
                                                    class="w-100 h-100" style="object-fit: cover;">
                                            @else
                                                <div class="d-flex align-items-center justify-content-center h-100 text-muted small">
                                                    No photo
                                                </div>
                                            @endif
                                        </div>

                                        <div class="card-body d-flex flex-column justify-content-between p-2">
                                            <div>
                                                <h5 class="card-title fw-bold text-dark mb-1 fs-6 text-truncate" title="{{ $row->ProNameKh }}">
                                                    {{ $row->ProNameKh }}
                                                </h5>
                                            </div>

                                            <div class="mt-1">
                                                <p class="card-text text-danger fw-bold fs-6 mb-0">
                                                    $ {{ number_format($row->price, 2) }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="col-12 text-center py-5 text-muted fs-5">
                                No Product found.
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- ==== RIGHT SIDE: CART & FORM ==== --}}
        <div class="col-12 col-lg-4">
            <form action="{{ route('invoice.store') }}" method="POST" enctype="multipart/form-data" id="checkout-form">
                @csrf

                <div class="card shadow-sm d-flex flex-column mb-2" style="height: 60vh;">
                    <div class="card-header border-bottom border-light bg-white py-3 d-flex justify-content-between align-items-center">
                        <h4 class="header-title mb-0">Cart</h4>
                        <button type="button" class="btn btn-sm btn-outline-danger" id="clear-cart">Clear</button>
                    </div>

                    {{-- Cart Container --}}
                    <div class="card-body overflow-y-auto flex-grow-1 p-2" id="cart-area">
                        <p class="text-muted text-center my-4" id="empty-cart-msg">Cart items will appear here...</p>
                    </div>

                    {{-- Total Calculation --}}
                    <div class="card-footer bg-white border-top p-3">
                        <div class="d-flex justify-content-between align-items-center fw-bold fs-5">
                            <span>Total:</span>
                            <span class="text-danger" id="cart-total">$ 0.00</span>
                        </div>
                    </div>
                </div>

                {{-- Checkout Fields --}}

                <div class="card p-3 shadow-sm">
                    <div class="row mb-2">
                        <div class="col-12">
                            <button
                                type="button"
                                class="btn btn-outline-danger btn-sm w-100"
                                data-bs-toggle="modal"
                                data-bs-target="#addCustomerModal">
                                Add Customer
                            </button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <select name="CustomerID" class="form-select @error('CustomerID') is-invalid @enderror" required>
                                <option value="">ជ្រើសរើសអតិថិជន</option>
                                @foreach ($customers as $customer)
                                    <option value="{{ $customer->id }}" {{ old('CustomerID') == $customer->id ? 'selected' : '' }}>
                                        {{ $customer->name }}
                                    </option>
                                @endforeach
                            </select>

                            @error('CustomerID')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-2">
                            <select name="UserID" class="form-select @error('UserID') is-invalid @enderror" required>
                                <option value="">ជ្រើសរើសអ្នកប្រើ</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}" {{ old('UserID') == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>

                            @error('UserID')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- ✅ ត្រូវជា ExchangeID មិនមែន CustomerID ដដែលទេ --}}
                        <div class="col-md-12 mb-2">
                            <select name="ExchangeID" class="form-select @error('ExchangeID') is-invalid @enderror" required>
                                <option value="">ជ្រើសរើសអត្រាប្តូរប្រាក់</option>
                                @foreach ($exchanges as $exchange)
                                    <option value="{{ $exchange->id }}" {{ old('ExchangeID') == $exchange->id ? 'selected' : '' }}>
                                        {{ $exchange->fromCurrency->name ?? '' }} → {{ $exchange->toCurrency->name ?? '' }}
                                        (Rate: {{ $exchange->rate ?? '' }})
                                    </option>
                                @endforeach
                            </select>

                            @error('ExchangeID')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>


                    </div>

                    <button type="submit" class="btn btn-success w-100 mt-2 fw-bold">
                        Checkout / Save Invoice
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- ==== MODAL: ADD CUSTOMER ==== --}}
    <div class="modal fade" id="addCustomerModal" tabindex="-1" aria-labelledby="addCustomerModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="addCustomerModalLabel">
                        <i class="ti ti-user-shield me-2"></i> Create New Customer
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form id="ajaxCustomerForm" action="{{ route('customers.stores') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">

                        <div id="customer-modal-alert"></div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Customer Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" id="modal_name">
                            <small class="text-danger error-name"></small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Employee Sex <span class="text-danger">*</span></label>
                            <input type="text" name="sex" class="form-control" id="modal_sex">
                            <small class="text-danger error-sex"></small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Customer Phone <span class="text-danger">*</span></label>
                            <input type="text" name="phone" class="form-control" id="modal_phone">
                            <small class="text-danger error-phone"></small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Status</label>
                            <select name="status" class="form-select" id="modal_status">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="ti ti-device-floppy me-1"></i> Save Customer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- ==== JAVASCRIPT FOR CART FUNCTIONALITY ==== --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let cart = [];

            const cartArea = document.getElementById('cart-area');
            const cartTotal = document.getElementById('cart-total');
            const clearCartBtn = document.getElementById('clear-cart');
            const checkoutForm = document.getElementById('checkout-form');

            // Attach click event to product cards
            document.querySelectorAll('.product-card').forEach(card => {
                card.addEventListener('click', function () {
                    const id = this.dataset.id;
                    const name = this.dataset.name;
                    const price = parseFloat(this.dataset.price);
                    const photo = this.dataset.photo;

                    addToCart(id, name, price, photo);
                });
            });

            // Prevent submitting form if cart is empty
            checkoutForm.addEventListener('submit', function (e) {
                if (cart.length === 0) {
                    e.preventDefault();
                    alert('Please select at least one product before checking out.');
                }
            });

            // Add or increment item
            function addToCart(id, name, price, photo) {
                const existingItem = cart.find(item => item.id === id);

                if (existingItem) {
                    existingItem.qty++;
                } else {
                    cart.push({ id, name, price, photo, qty: 1 });
                }

                renderCart();
            }

            // Update quantity
            window.updateQty = function(id, change) {
                const item = cart.find(i => i.id === id);
                if (item) {
                    item.qty += change;
                    if (item.qty <= 0) {
                        cart = cart.filter(i => i.id !== id);
                    }
                }
                renderCart();
            };

            // Remove item
            window.removeFromCart = function(id) {
                cart = cart.filter(item => item.id !== id);
                renderCart();
            };

            // Clear all items
            clearCartBtn.addEventListener('click', function() {
                cart = [];
                renderCart();
            });

            // Render Cart UI and Hidden Inputs for Backend Form
            function renderCart() {
                if (cart.length === 0) {
                    cartArea.innerHTML = '<p class="text-muted text-center my-4" id="empty-cart-msg">Cart items will appear here...</p>';
                    cartTotal.textContent = '$ 0.00';
                    return;
                }

                let html = '';
                let grandTotal = 0;

                cart.forEach((item, index) => {
                    const itemTotal = item.price * item.qty;
                    grandTotal += itemTotal;

                    const imageMarkup = item.photo
                        ? `<img src="${item.photo}" class="rounded me-2" style="width: 45px; height: 45px; object-fit: cover;">`
                        : `<div class="bg-light rounded me-2 d-flex align-items-center justify-content-center text-muted fs-6" style="width: 45px; height: 45px;">No image</div>`;

                    html += `
                        <div class="d-flex align-items-center justify-content-between p-2 mb-2 border rounded bg-light">
                            <div class="d-flex align-items-center">
                                ${imageMarkup}
                                <div>
                                    <h6 class="mb-0 text-truncate" style="max-width: 110px;" title="${item.name}">${item.name}</h6>
                                    <small class="text-danger fw-bold">$${item.price.toFixed(2)}</small>
                                </div>
                            </div>

                            <div class="d-flex align-items-center gap-1">
                                <button type="button" class="btn btn-sm btn-outline-secondary px-2" onclick="updateQty('${item.id}', -1)">-</button>
                                <span class="fw-bold px-1">${item.qty}</span>
                                <button type="button" class="btn btn-sm btn-outline-secondary px-2" onclick="updateQty('${item.id}', 1)">+</button>
                                <button type="button" class="btn btn-sm btn-link text-danger ms-1 p-0 ms-2" onclick="removeFromCart('${item.id}')">
                                    <i class="ti ti-trash fs-5"></i>
                                </button>
                            </div>

                            {{-- Hidden Form Inputs to Send Cart Data to Backend --}}
                            <input type="hidden" name="items[${index}][product_id]" value="${item.id}">
                            <input type="hidden" name="items[${index}][quantity]" value="${item.qty}">
                            <input type="hidden" name="items[${index}][price]" value="${item.price}">
                        </div>
                    `;
                });

                cartArea.innerHTML = html;
                cartTotal.textContent = `$ ${grandTotal.toFixed(2)}`;
            }
        });
    </script>
@endsection


