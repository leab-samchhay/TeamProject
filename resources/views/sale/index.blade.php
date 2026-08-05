@extends('layouts.app')
@section('title', 'Product Sale')

@section('content')
    {{-- ==== FLASH MESSAGES ==== --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show my-2" role="alert">
            <i class="ti ti-check me-1"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('error'))
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
                    <form action="{{ route('sale.index') }}" method="GET"
                        class="d-flex flex-wrap gap-2 align-items-center">
                        <div class="flex-grow-1" style="min-width: 200px;">
                            <input type="text" name="search" value="{{ request('search') }}" class="form-control"
                                placeholder="Search Sale name...">
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="ti ti-search me-1"></i> Search
                        </button>

                        @if (request('search') || request('category_id'))
                            <a href="{{ route('sale.index') }}" class="btn btn-light">Reset</a>
                        @endif

                        <div class="dropdown">
                            <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="categoryDropdown"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                @if (request('category_id'))
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
                                        style="cursor: pointer;" data-id="{{ $row->id }}"
                                        data-name="{{ $row->ProNameKh }}" data-price="{{ $row->price }}"
                                        data-photo="{{ $row->Photo ? asset('storage/' . $row->Photo) : '' }}">

                                        <div class="card-img-top bg-light" style="height: 150px; overflow: hidden;">
                                            @if ($row->Photo)
                                                <img src="{{ asset('storage/' . $row->Photo) }}"
                                                    alt="{{ $row->ProNameKh }}" class="w-100 h-100"
                                                    style="object-fit: cover;">
                                            @else
                                                <div
                                                    class="d-flex align-items-center justify-content-center h-100 text-muted small">
                                                    No photo
                                                </div>
                                            @endif
                                        </div>

                                        <div class="card-body d-flex flex-column justify-content-between p-2">
                                            <div>
                                                <h5 class="card-title fw-bold text-dark mb-1 fs-6 text-truncate"
                                                    title="{{ $row->ProNameKh }}">
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
            <form action="{{ route('invoice.store') }}" method="POST" id="checkout-form">
                @csrf

                <div class="card shadow-sm mb-3 h-100 d-flex flex-column">
                    <div
                        class="card-header border-bottom border-light bg-white py-3 d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="header-title mb-1">Cart</h4>
                            <small class="text-muted">Selected products will appear here.</small>
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-danger" id="clear-cart">Clear</button>
                    </div>

                    <div class="card-body overflow-y-auto flex-grow-1 p-2" id="cart-area">
                        <p class="text-muted text-center my-4" id="empty-cart-msg">Cart items will appear here...</p>
                    </div>

                    <div class="card-footer bg-white border-top p-3">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="fw-semibold">Subtotal</span>
                            <span id="cart-subtotal">$ 0.00</span>
                        </div>
                        <div class="mb-3">
                            <label for="discount-input" class="form-label fw-semibold mb-1">Discount</label>
                            <input type="number" name="discount" id="discount-input" class="form-control" min="0"
                                step="0.01" value="0">
                        </div>
                        <div class="d-flex justify-content-between align-items-center fw-bold fs-5 mb-3">
                            <span>Total Payment</span>
                            <span class="text-danger" id="cart-total">$ 0.00</span>
                        </div>
                        <input type="hidden" name="total" id="total-input" value="0">
                        <input type="hidden" name="ExchangeID" value="{{ optional($exchanges->first())->id ?? '' }}">
                        <div id="cart-hidden-inputs"></div>
                        <button type="submit" class="btn btn-primary w-100 py-2">To Payment</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="modal fade" id="addCustomerModal" tabindex="-1" aria-labelledby="addCustomerModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="addCustomerModalLabel">
                        <i class="ti ti-user-shield me-2"></i> Create New Customer
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>

                <form id="ajaxCustomerForm" action="{{ route('customers.stores') }}" method="POST"
                    enctype="multipart/form-data">
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
                            <label class="form-label fw-semibold">Customer Phone <span
                                    class="text-danger">*</span></label>
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

    <!-- Payment Modal -->
    <div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="paymentModalLabel">Payment Method</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="list-group mb-3" id="payment-method-list">
                        @foreach ($paymentMethods as $method)
                            <label class="list-group-item d-flex align-items-center justify-content-between">
                                <div>
                                    <i class="ti ti-credit-card me-2"></i>
                                    {{ $method->MethodName }}
                                </div>
                                <input type="radio" name="payment_method" value="{{ $method->id }}">
                            </label>
                        @endforeach
                    </div>

                    <div class="mb-2">
                        <div class="d-flex justify-content-between">
                            <span>Subtotal</span>
                            <span id="modal-subtotal">$0.00</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span>Discount (%)</span>
                            <span id="modal-discount-percent">0%</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span>Total (USD)</span>
                            <span id="modal-total-usd">$0.00</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span>Total (KHR)</span>
                            <span id="modal-total-khr">៛0.00</span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-success" id="print-invoice-btn">Print Invoice</button>
                </div>
            </div>
        </div>
    </div>

    {{-- ==== JAVASCRIPT FOR CART FUNCTIONALITY ==== --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let cart = [];

            const cartArea = document.getElementById('cart-area');
            const cartSubtotal = document.getElementById('cart-subtotal');
            const cartTotal = document.getElementById('cart-total');
            const discountInput = document.getElementById('discount-input');
            const totalInput = document.getElementById('total-input');
            const cartHiddenInputs = document.getElementById('cart-hidden-inputs');
            const clearCartBtn = document.getElementById('clear-cart');
            const checkoutForm = document.getElementById('checkout-form');

            document.querySelectorAll('.product-card').forEach(card => {
                card.addEventListener('click', function() {
                    const id = this.dataset.id;
                    const name = this.dataset.name;
                    const price = parseFloat(this.dataset.price);
                    const photo = this.dataset.photo;

                    addToCart(id, name, price, photo);
                });
            });

            discountInput.addEventListener('input', renderCart);

            checkoutForm.addEventListener('submit', function(e) {
                e.preventDefault();
                if (cart.length === 0) {
                    alert('សូមជ្រើសរើសទំនិញមុនពេលចុច To Payment.');
                    return;
                }

                // Build FormData (includes CSRF token)
                const formData = new FormData(checkoutForm);

                fetch("{{ route('invoice.store') }}", {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (!data || !data.success) {
                            alert(data.message || 'Error creating invoice');
                            return;
                        }

                        // Fill modal with amounts
                        const subtotal = data.subtotal || 0;
                        const discount = data.discount || 0;
                        const total = data.total || 0;
                        const rate = data.exchange_rate || null;

                        document.getElementById('modal-subtotal').textContent =
                            `$ ${parseFloat(subtotal).toFixed(2)}`;
                        const percent = subtotal > 0 ? Math.round((discount / subtotal) * 100) : 0;
                        document.getElementById('modal-discount-percent').textContent = `${percent}%`;
                        document.getElementById('modal-total-usd').textContent =
                            `$ ${parseFloat(total).toFixed(2)}`;
                        if (rate) {
                            document.getElementById('modal-total-khr').textContent =
                                `៛ ${ (total * parseFloat(rate)).toFixed(2) }`;
                        } else {
                            document.getElementById('modal-total-khr').textContent = '៛ N/A';
                        }

                        // store invoice info on modal button
                        window.__createdInvoice = {
                            id: data.invoice_id,
                            total
                        };

                        const paymentModalEl = document.getElementById('paymentModal');
                        const paymentModal = new bootstrap.Modal(paymentModalEl);
                        paymentModal.show();
                    })
                    .catch(err => {
                        console.error(err);
                        alert('មានបញ្ហាក្នុងការបង្កើត Invoice');
                    });
            });

            function addToCart(id, name, price, photo) {
                const existingItem = cart.find(item => item.id === id);

                if (existingItem) {
                    existingItem.qty++;
                } else {
                    cart.push({
                        id,
                        name,
                        price,
                        photo,
                        qty: 1
                    });
                }

                renderCart();
            }

            window.updateQty = function(id, change) {
                const item = cart.find(i => i.id === id);
                if (!item) return;

                item.qty += change;
                if (item.qty <= 0) {
                    cart = cart.filter(i => i.id !== id);
                }

                renderCart();
            };

            window.removeFromCart = function(id) {
                cart = cart.filter(item => item.id !== id);
                renderCart();
            };

            clearCartBtn.addEventListener('click', function() {
                cart = [];
                discountInput.value = 0;
                renderCart();
            });

            function renderCart() {
                if (cart.length === 0) {
                    cartArea.innerHTML =
                        '<p class="text-muted text-center my-4" id="empty-cart-msg">Cart items will appear here...</p>';
                    cartSubtotal.textContent = '$ 0.00';
                    cartTotal.textContent = '$ 0.00';
                    totalInput.value = 0;
                    cartHiddenInputs.innerHTML = '';
                    return;
                }

                let html = '';
                let subtotal = 0;
                let hiddenInputs = '';

                cart.forEach((item, index) => {
                    const itemTotal = item.price * item.qty;
                    subtotal += itemTotal;

                    const imageMarkup = item.photo ?
                        `<img src="${item.photo}" class="rounded me-2" style="width: 55px; height: 55px; object-fit: cover;">` :
                        `<div class="bg-light rounded me-2 d-flex align-items-center justify-content-center text-muted fs-6" style="width: 55px; height: 55px;">No image</div>`;

                    html += `
                        <div class="d-flex align-items-center justify-content-between p-2 mb-2 bg-white rounded shadow-sm">
                            <div class="d-flex align-items-center">
                                ${imageMarkup}
                                <div class="overflow-hidden">
                                    <h6 class="mb-1 text-truncate" style="max-width: 150px;" title="${item.name}">${item.name}</h6>
                                    <small class="text-muted">$${item.price.toFixed(2)} x ${item.qty}</small>
                                </div>
                            </div>
                            <div class="d-flex align-items-center gap-1">
                                <button type="button" class="btn btn-sm btn-outline-secondary px-2" onclick="updateQty('${item.id}', -1)">-</button>
                                <span class="fw-semibold px-2">${item.qty}</span>
                                <button type="button" class="btn btn-sm btn-outline-secondary px-2" onclick="updateQty('${item.id}', 1)">+</button>
                                <button type="button" class="btn btn-sm btn-link text-danger ms-2 p-0" onclick="removeFromCart('${item.id}')">
                                    <i class="ti ti-trash fs-5"></i>
                                </button>
                            </div>
                        </div>
                    `;

                    hiddenInputs += `
                        <input type="hidden" name="items[${index}][product_id]" value="${item.id}">
                        <input type="hidden" name="items[${index}][quantity]" value="${item.qty}">
                        <input type="hidden" name="items[${index}][price]" value="${item.price}">
                    `;
                });

                const discount = Math.max(0, parseFloat(discountInput.value) || 0);
                const total = Math.max(0, subtotal - discount);

                cartArea.innerHTML = html;
                cartHiddenInputs.innerHTML = hiddenInputs;
                cartSubtotal.textContent = `$ ${subtotal.toFixed(2)}`;
                cartTotal.textContent = `$ ${total.toFixed(2)}`;
                totalInput.value = total.toFixed(2);
            }

            // Handle Print Invoice -> create Payment record
            document.getElementById('print-invoice-btn').addEventListener('click', function() {
                const selected = document.querySelector('input[name="payment_method"]:checked');
                if (!selected) {
                    alert('សូមជ្រើសរើស Payment Method មុនពេល Print Invoice');
                    return;
                }

                const methodId = selected.value;
                const invoiceInfo = window.__createdInvoice || null;
                if (!invoiceInfo) {
                    alert('Invoice information missing.');
                    return;
                }

                const payData = new FormData();
                payData.append('_token', '{{ csrf_token() }}');
                payData.append('MethodID', methodId);
                payData.append('InvoiceID', invoiceInfo.id);
                payData.append('TotalPayment', invoiceInfo.total);
                const today = new Date().toISOString().slice(0, 10);
                payData.append('PaymentDate', today);

                fetch("{{ route('payment.store') }}", {
                        method: 'POST',
                        body: payData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(r => r.json())
                    .then(res => {
                        // PaymentController returns redirect by default; try to handle JSON or fallback
                        if (res && res.success === false) {
                            alert(res.message || 'Payment failed');
                            return;
                        }

                        // close modal and show success
                        const paymentModalEl = document.getElementById('paymentModal');
                        const modal = bootstrap.Modal.getInstance(paymentModalEl);
                        if (modal) modal.hide();

                        alert('Payment recorded successfully.');
                        // Optionally refresh page
                        window.location.href = '{{ route('sale.index') }}';
                    })
                    .catch(err => {
                        console.error(err);
                        alert('មានបញ្ហាក្នុងការកត់ត្រា Payment');
                    });
            });
        });
    </script>
@endsection
