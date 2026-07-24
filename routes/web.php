<?php
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ExchangeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UnitypeController;
use Illuminate\Support\Facades\Route;

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
