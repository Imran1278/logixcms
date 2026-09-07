@extends('layouts.app')

@section('page_title', 'Manage Fee Heads')

@section('content')
<div class="container py-4">
    <div class="row g-4">
        <!-- Add Fee Head Form -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-dark text-white p-4 rounded-top-4">
                    <h6 class="mb-0 text-white"><i class="fa-solid fa-plus-circle me-2 text-warning"></i> Add New Fee Head</h6>
                </div>
                <div class="card-body p-4 d-flex flex-column justify-content-between">
                    @if(session('success'))
                        <div class="alert alert-success border-0 shadow-sm rounded-4 mb-4">
                            <div class="d-flex align-items-center">
                                <i class="fa-solid fa-circle-check fs-5 me-2 text-success"></i>
                                <div>{{ session('success') }}</div>
                            </div>
                        </div>
                    @endif

                    <form action="{{ route('fees.heads.store') }}" method="POST" class="w-100">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-bold text-secondary">Fee Head Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control shadow-none" placeholder="e.g. Tuition Fee, Admission Fee" required>
                            @error('name')
                                <small class="text-danger mt-1 d-block">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold text-secondary">Type / Frequency <span class="text-danger">*</span></label>
                            <select name="type" class="form-select shadow-none" required>
                                <option value="Recurring">Recurring (Monthly / Regular)</option>
                                <option value="One-Time">One-Time (Admission / Security)</option>
                            </select>
                            @error('type')
                                <small class="text-danger mt-1 d-block">{{ $message }}</small>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-warning text-dark fw-bold w-100 py-2 shadow-sm">
                            <i class="fa-solid fa-save me-1"></i> Save Fee Head
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Fee Heads List -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden h-100">
                <div class="card-header bg-dark text-white p-4">
                    <h6 class="mb-0 text-white"><i class="fa-solid fa-list-check me-2 text-warning"></i> Configured Fee Heads</h6>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light text-uppercase fs-8">
                                <tr>
                                    <th class="py-3 ps-4">#</th>
                                    <th class="py-3">Fee Head Name</th>
                                    <th class="py-3">Type</th>
                                    <th class="py-3">Status</th>
                                    <th class="py-3 text-end pe-4">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($feeHeads as $head)
                                <tr>
                                    <td class="ps-4 font-monospace text-muted">{{ $loop->iteration }}</td>
                                    <td class="fw-bold text-dark">{{ $head->name }}</td>
                                    <td>
                                        <span class="badge {{ $head->type == 'Recurring' ? 'bg-info-subtle text-info border' : 'bg-secondary-subtle text-secondary border' }} px-2 py-1">
                                            {{ $head->type }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-success-subtle text-success border px-2 py-1">Active</span>
                                    </td>
                                    <td class="text-end pe-4">
                                        <form action="{{ route('fees.heads.destroy', $head->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this fee head?');" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger border-0">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5 text-muted">
                                        <i class="fa-solid fa-folder-open fs-3 mb-2 d-block opacity-50"></i>
                                        No fee heads created yet. Add one using the form on the left.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection