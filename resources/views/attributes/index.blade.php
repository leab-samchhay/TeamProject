@extends('layouts.app')

@section('title', 'Attributes')

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
                    <h4 class="header-title">Manage Attributes</h4>

                    <div>
                        <a href="{{ route('attributes.create') }}" class="btn btn-success bg-gradient">
                            <i class="ti ti-plus me-1"></i> Add Attribute
                        </a>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-nowrap mb-0">
                        <thead class="bg-light-subtle">
                            <tr>
                                <th class="ps-3">No</th>
                                <th>Name</th>
                                <th>Values</th>
                                <th>Display Order</th>
                                <th>Status</th>
                                <th class="text-center" style="width: 125px;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($rows as $row)
                                <tr>
                                    <td class="ps-3">{{ $loop->iteration }}</td>
                                    <td>{{ $row->name }}</td>
                                    <td>
                                        @forelse ($row->values as $value)
                                            <span class="badge bg-light text-dark me-1">{{ $value->value }}</span>
                                        @empty
                                            <span class="text-muted">—</span>
                                        @endforelse
                                    </td>
                                    <td>{{ $row->display_order }}</td>
                                    <td>
                                        <span
                                            class="badge @if ($row->status) bg-primary @else bg-danger @endif">
                                            {{ $row->status ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                    <td class="pe-3">
                                        <div class="hstack gap-1 justify-content-end">
                                            <a href="{{ route('attributes.edit', $row->id) }}"
                                                class="btn btn-soft-success btn-icon btn-sm rounded-circle"><i
                                                    class="ti ti-edit fs-16"></i></a>
                                            <a href="javascript:void(0);"
                                                onclick="event.preventDefault(); document.getElementById('attributes_delete-{{ $row->id }}').submit();"
                                                class="btn btn-soft-danger btn-icon btn-sm rounded-circle"><i
                                                    class="ti ti-trash"></i></a>
                                        </div>
                                        <form id="attributes_delete-{{ $row->id }}"
                                            action="{{ route('attributes.destroy', $row->id) }}" method="POST"
                                            class="d-none">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4">No Attributes found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- <div class="card-footer">
                        <div class="d-flex justify-content-end">
                            {{ $rows->links('pagination.custom') }}
                        </div>
                    </div> --}}

                <div class="card-footer">
                    <div class="d-flex justify-content-end gap-5 align-items-center justify-conten-center">
                        {{ $rows->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
