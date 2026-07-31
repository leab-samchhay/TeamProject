<?php
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ExchangeController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\InvoiceDetailController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PuchaseController;
use App\Http\Controllers\PuchaseDetailController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UnitypeController;
use App\Http\Controllers\UserController;
use App\Models\Permission;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\PaymentMethodController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PurchasePaymentController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route:: get('/employee',[EmployeeController::class,'index'])->name('employee.index');
Route:: get('/employee-create',[EmployeeController::class,'create'])->name('employee.create');
Route:: post('/employee-store',[EmployeeController::class,'store'])->name('employee.store');
Route:: get('/employee-edit/{id}',[EmployeeController::class,'edit'])->name('employee.edit');
Route:: put('/employee-update/{id}',[EmployeeController::class,'update'])->name('employee.update');
Route:: delete('/employee-remove/{id}',[EmployeeController::class,'destroy'])->name('employee.remove');

Route:: get('/customer',[CustomerController::class,'index'])->name('customer.index');
Route:: get('/customer-create',[CustomerController::class,'create'])->name('customer.create');
Route:: post('/customer-store',[CustomerController::class,'store'])->name('customer.store');
Route:: get('/customer-edit/{id}',[CustomerController::class,'edit'])->name('customer.edit');
Route:: put('/customer-update/{id}',[CustomerController::class,'update'])->name('customer.update');
Route:: delete('/customer-remove/{id}',[CustomerController::class,'destroy'])->name('customer.remove');

Route:: get('/category',[CategoryController::class,'index'])->name('category.index');
Route:: get('/category-create',[CategoryController::class,'create'])->name('category.create');
Route:: post('/category-store',[CategoryController::class,'store'])->name('category.store');
Route:: get('/category-edit/{id}',[CategoryController::class,'edit'])->name('category.edit');
Route:: put('/category-update/{id}',[CategoryController::class,'update'])->name('category.update');
Route:: delete('/category-remove/{id}',[CategoryController::class,'destroy'])->name('category.remove');

Route:: get('/exchange',[ExchangeController::class,'index'])->name('exchange.index');
Route:: get('/exchange-create',[ExchangeController::class,'create'])->name('exchange.create');
Route:: post('/exchange-store',[ExchangeController::class,'store'])->name('exchange.store');
Route:: get('/exchange-edit/{id}',[ExchangeController::class,'edit'])->name('exchange.edit');
Route:: put('/exchange-update/{id}',[ExchangeController::class,'update'])->name('exchange.update');
Route:: delete('/exchange-remove/{id}',[ExchangeController::class,'destroy'])->name('exchange.remove');

Route:: get('/supplier',[SupplierController::class,'index'])->name('supplier.index');
Route:: get('/supplier-create',[SupplierController::class,'create'])->name('supplier.create');
Route:: post('/supplier-store',[SupplierController::class,'store'])->name('supplier.store');
Route:: get('/supplier-edit/{id}',[SupplierController::class,'edit'])->name('supplier.edit');
Route:: put('/supplier-update/{id}',[SupplierController::class,'update'])->name('supplier.update');
Route:: delete('/supplier-remove/{id}',[SupplierController::class,'destroy'])->name('supplier.remove');

Route:: get('/product',[ProductController::class,'index'])->name('product.index');
Route:: get('/product-create',[ProductController::class,'create'])->name('product.create');
Route:: post('/product-store',[ProductController::class,'store'])->name('product.store');
Route:: get('/product-edit/{id}',[ProductController::class,'edit'])->name('product.edit');
Route:: put('/product-update/{id}',[ProductController::class,'update'])->name('product.update');
Route:: delete('/product-remove/{id}',[ProductController::class,'destroy'])->name('product.remove');

Route:: get('/role',[RoleController::class,'index'])->name('role.index');
Route:: get('/role-create',[RoleController::class,'create'])->name('role.create');
Route:: post('/role-store',[RoleController::class,'store'])->name('role.store');
Route:: get('/role-edit/{id}',[RoleController::class,'edit'])->name('role.edit');
Route:: put('/role-update/{id}',[RoleController::class,'update'])->name('role.update');
Route:: delete('/role-remove/{id}',[RoleController::class,'destroy'])->name('role.remove');

Route:: get('/unitype',[UnitypeController::class,'index'])->name('unitype.index');
Route:: get('/unitype-create',[UnitypeController::class,'create'])->name('unitype.create');
Route:: post('/unitype-store',[UnitypeController::class,'store'])->name('unitype.store');
Route:: get('/unitype-edit/{id}',[UnitypeController::class,'edit'])->name('unitype.edit');
Route:: put('/unitype-update/{id}',[UnitypeController::class,'update'])->name('unitype.update');
Route:: delete('/unitype-remove/{id}',[UnitypeController::class,'destroy'])->name('unitype.remove');

Route:: get('/currency',[CurrencyController::class,'index'])->name('currency.index');
Route:: get('/currency-create',[CurrencyController::class,'create'])->name('currency.create');
Route:: post('/currency-store',[CurrencyController::class,'store'])->name('currency.store');
Route:: get('/currency-edit/{id}',[CurrencyController::class,'edit'])->name('currency.edit');
Route:: put('/currency-update/{id}',[CurrencyController::class,'update'])->name('currency.update');
Route:: delete('/currency-remove/{id}',[CurrencyController::class,'destroy'])->name('currency.remove');

Route:: get('/permision',[PermissionController::class,'index'])->name('permision.index');
Route:: get('/permision-create',[PermissionController::class,'create'])->name('permision.create');
Route:: post('/permision-store',[PermissionController::class,'store'])->name('permision.store');
Route:: get('/permision-edit/{id}',[PermissionController::class,'edit'])->name('permision.edit');
Route:: put('/permision-update/{id}',[PermissionController::class,'update'])->name('permision.update');
Route:: delete('/permision-remove/{id}',[PermissionController::class,'destroy'])->name('permision.remove');

Route:: get('/user',[UserController::class,'index'])->name('user.index');
Route:: get('/user-create',[UserController::class,'create'])->name('user.create');
Route:: post('/user-store',[UserController::class,'store'])->name('user.store');
Route:: get('/user-edit/{id}',[UserController::class,'edit'])->name('user.edit');
Route:: put('/user-update/{id}',[UserController::class,'update'])->name('user.update');
Route:: delete('/user-remove/{id}',[UserController::class,'destroy'])->name('user.remove');

Route:: get('/invoice',[InvoiceController::class,'index'])->name('invoice.index');
Route:: get('/invoice-create',[InvoiceController::class,'create'])->name('invoice.create');
Route:: post('/invoice-store',[InvoiceController::class,'store'])->name('invoice.store');
Route:: get('/invoice-edit/{id}',[InvoiceController::class,'edit'])->name('invoice.edit');
Route:: put('/invoice-update/{id}',[InvoiceController::class,'update'])->name('invoice.update');
Route:: delete('/invoice-remove/{id}',[InvoiceController::class,'destroy'])->name('invoice.remove');

Route:: get('/invoiceDetail',[InvoiceDetailController::class,'index'])->name('invoiceDetail.index');
Route:: get('/invoiceDetail-create',[InvoiceDetailController::class,'create'])->name('invoiceDetail.create');
Route:: post('/invoiceDetail-store',[InvoiceDetailController::class,'store'])->name('invoiceDetail.store');
Route:: get('/invoiceDetail-edit/{id}',[InvoiceDetailController::class,'edit'])->name('invoiceDetail.edit');
Route:: put('/invoiceDetail-update/{id}',[InvoiceDetailController::class,'update'])->name('invoiceDetail.update');
Route:: delete('/invoiceDetail-remove/{id}',[InvoiceDetailController::class,'destroy'])->name('invoiceDetail.remove');

Route:: get('/purchase',[PuchaseController::class,'index'])->name('purchase.index');
Route:: get('/purchase-create',[PuchaseController::class,'create'])->name('purchase.create');
Route:: post('/purchase-store',[PuchaseController::class,'store'])->name('purchase.store');
Route:: get('/purchase-edit/{id}',[PuchaseController::class,'edit'])->name('purchase.edit');
Route:: put('/purchase-update/{id}',[PuchaseController::class,'update'])->name('purchase.update');
Route:: delete('/purchase-remove/{id}',[PuchaseController::class,'destroy'])->name('purchase.remove');

Route:: get('/purchaseDetail',[PuchaseDetailController::class,'index'])->name('purchaseDetail.index');
Route:: get('/purchaseDetail-create',[PuchaseDetailController::class,'create'])->name('purchaseDetail.create');
Route:: post('/purchaseDetail-store',[PuchaseDetailController::class,'store'])->name('purchaseDetail.store');
Route:: get('/purchaseDetail-edit/{id}',[PuchaseDetailController::class,'edit'])->name('purchaseDetail.edit');
Route:: put('/purchaseDetail-update/{id}',[PuchaseDetailController::class,'update'])->name('purchaseDetail.update');
Route:: delete('/purchaseDetail-remove/{id}',[PuchaseDetailController::class,'destroy'])->name('purchaseDetail.remove');



Route::get('/Sale', [SalesController::class, 'index'])->name('sale.index');
Route::post('/customers-store', [CustomerController::class, 'stores'])->name('customers.stores');

// Payment Method Routes
Route::get('/paymentMethod', [PaymentMethodController::class, 'index'])->name('paymentMethod.index');
Route::get('/paymentMethod-create', [PaymentMethodController::class, 'create'])->name('paymentMethod.create');
Route::post('/paymentMethod-store', [PaymentMethodController::class, 'store'])->name('paymentMethod.store');
Route::get('/paymentMethod-edit/{id}', [PaymentMethodController::class, 'edit'])->name('paymentMethod.edit');
Route::put('/paymentMethod-update/{id}', [PaymentMethodController::class, 'update'])->name('paymentMethod.update');
Route::delete('/paymentMethod-remove/{id}', [PaymentMethodController::class, 'destroy'])->name('paymentMethod.remove');

// Payment Routes
Route::get('/payment', [PaymentController::class, 'index'])->name('payment.index');
Route::get('/payment-create', [PaymentController::class, 'create'])->name('payment.create');
Route::post('/payment-store', [PaymentController::class, 'store'])->name('payment.store');
Route::get('/payment-edit/{id}', [PaymentController::class, 'edit'])->name('payment.edit');
Route::put('/payment-update/{id}', [PaymentController::class, 'update'])->name('payment.update');
Route::delete('/payment-remove/{id}', [PaymentController::class, 'destroy'])->name('payment.remove');

// Purchase Payment Routes
Route::get('/purchasePayment', [PurchasePaymentController::class, 'index'])->name('purchasePayment.index');
Route::get('/purchasePayment-create', [PurchasePaymentController::class, 'create'])->name('purchasePayment.create');
Route::post('/purchasePayment-store', [PurchasePaymentController::class, 'store'])->name('purchasePayment.store');
Route::get('/purchasePayment-edit/{id}', [PurchasePaymentController::class, 'edit'])->name('purchasePayment.edit');
Route::put('/purchasePayment-update/{id}', [PurchasePaymentController::class, 'update'])->name('purchasePayment.update');
Route::delete('/purchasePayment-remove/{id}', [PurchasePaymentController::class, 'destroy'])->name('purchasePayment.remove');

