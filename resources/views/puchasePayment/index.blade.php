@extends('layouts.app')
@section('title', 'Purchase Payment')
@section('content')
    <div class="row my-2">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between border-bottom border-light">
                    <h4 class="header-title">Manage Purchase Payments</h4>
                    <div>
                        <a href="{{ route('puchasePayment.create') }}" class="btn btn-success bg-gradient"><i
                            class="ti ti-plus me-1"></i> Record Purchase Payment</a>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-nowrap mb-0">
                        <thead class="bg-light-subtle">
                            <tr>
                                <th class="ps-3" style="width: 60px;">No</th>
                                <th>Payment Method</th>
                                <th>Purchase ID</th>
                                <th>Total Payment</th>
                                <th>Purchase Date</th>
                                <th class="text-center" style="width: 125px;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($rows)
                                @foreach ($rows as $row)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td>{{ $row->paymentMethod->MethodName ?? 'N/A' }}</td>
                                        <td>Purchase #{{ $row->PuchaseID }}</td>
                                        <td>${{ number_format($row->TotalPayment, 2) }}</td>
                                        <td>{{ $row->PuchaseDate->format('Y-m-d') }}</td>
                                        <td class="pe-3">
                                            <div class="hstack gap-1 justify-content-end">
                                                <a href="{{ route('puchasePayment.edit', $row->id) }}"
                                                    class="btn btn-soft-success btn-icon btn-sm rounded-circle"> <i
                                                        class="ti ti-edit fs-16"></i></a>

                                                <form action="{{ route('puchasePayment.remove', $row->id) }}" method="POST"
                                                    onsubmit="return confirm('Are you sure you want to delete this purchase payment record?')"
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
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    <div class="d-flex justify-content-end gap-5 align-items-center justify-content-center">
                        {{ $rows->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
