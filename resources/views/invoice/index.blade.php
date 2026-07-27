@extends('layouts.app')

@section('title', 'Invoice')

@section('content')
    <div class="row my-2">
        <div class="col-12">
            <div class="card">

                <div class="card-header d-flex align-items-center justify-content-between border-bottom border-light">
                    <h4 class="header-title">Manage Invoice</h4>

                    <div>
                        <a href="{{ route('invoice.create') }}" class="btn btn-success bg-gradient">
                            <i class="ti ti-plus me-1"></i> Add Invoice
                        </a>
                    </div>
                </div>


                <div class="table-responsive">

                    <table class="table table-nowrap mb-0" style="table-layout: fixed;">

                        <thead class="bg-light-subtle">

                            <tr>
                                <th class="ps-3 text-center" style="width:60px;">
                                    No
                                </th>

                                <th>
                                    Invoice Date
                                </th>

                                <th>
                                    Customer
                                </th>

                                <th>
                                    User
                                </th>

                                <th>
                                    Exchange
                                </th>

                                <th>
                                    Discound
                                </th>

                                <th>
                                    Total
                                </th>

                                <th>
                                    Status
                                </th>

                                <th class="text-center" style="width:125px;">
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($rows)
                                @foreach ($rows as $row)
                                    <tr>
                                        <td class="text-center">
                                            {{ $loop->iteration }}
                                        </td>
                                        <td>
                                            {{ $row->invoiceDate }}
                                        </td>
                                        <td>
                                            {{ $row->customer->name ?? '-' }}
                                        </td>
                                        <td>
                                            {{ $row->user->name ?? '-' }}
                                        </td>
                                        <td>
                                            {{ $row->exchange->fromCurrency->currencycode ?? '-' }}
                                            🔜
                                            {{ $row->exchange->toCurrency->currencycode ?? '-' }}
                                        </td>
                                        <td>
                                            {{ $row->discound }}
                                        </td>
                                        <td>
                                            {{ $row->total }}
                                        </td>

                                        <td>
                                            @if($row->status == true)
                                                <button class="btn btn-sm text-white bg-success">
                                                    Active
                                                </button>
                                            @else
                                                <button class="btn btn-sm text-white bg-danger">
                                                    Inactive
                                                </button>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="hstack gap-1 justify-content-center">
                                                <a href="{{ route('invoice.edit',$row->id) }}"
                                                    class="btn btn-soft-success btn-icon btn-sm rounded-circle">
                                                    <i class="ti ti-edit fs-16"></i>
                                                </a>
                                                <form action="{{ route('invoice.remove', $row->id) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Are you sure you want to delete this role?')"
                                                    style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="btn btn-soft-danger btn-icon btn-sm rounded-circle">
                                                        <i class="ti ti-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    <div class="d-flex justify-content-end gap-5 align-items-center justify-conten-center">
                        {{ $rows->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
