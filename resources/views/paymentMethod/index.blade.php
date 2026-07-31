@extends('layouts.app')
@section('title', 'Payment Method')
@section('content')
    <div class="row my-2">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between border-bottom border-light">
                    <h4 class="header-title">Manage Payment Methods</h4>
                    <div>
                        <a href="{{ route('paymentMethod.create') }}" class="btn btn-success bg-gradient"><i
                            class="ti ti-plus me-1"></i> Add Payment Method</a>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-nowrap mb-0">
                        <thead class="bg-light-subtle">
                            <tr>
                                <th class="ps-3" style="width: 60px;">No</th>
                                <th>Method Name</th>
                                <th>Status</th>
                                <th class="text-center" style="width: 125px;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($rows)
                                @foreach ($rows as $row)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td>{{ $row->MethodName }}</td>
                                        <td>
                                            @if($row->Status == true)
                                                <button class="btn btn-sm text-white bg-success">Active</button>
                                            @else
                                                <button class="btn btn-sm text-white bg-danger">Inactive</button>
                                            @endif
                                        </td>
                                        <td class="pe-3">
                                            <div class="hstack gap-1 justify-content-end">
                                                <a href="{{ route('paymentMethod.edit', $row->id) }}"
                                                    class="btn btn-soft-success btn-icon btn-sm rounded-circle"> <i
                                                        class="ti ti-edit fs-16"></i></a>

                                                <form action="{{ route('paymentMethod.remove', $row->id) }}" method="POST"
                                                    onsubmit="return confirm('Are you sure you want to delete this payment method?')"
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
