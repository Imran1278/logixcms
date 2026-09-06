@extends('layouts.app')

@section('page_title', 'Manage Fee Heads')

@section('content')
<div class="container py-3">
    <div class="row g-4">
        <!-- Add Fee Head Form -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-dark text-white p-3">
                    <h6 class="mb-0 text-white"><i class="fa-solid fa-plus-circle me-2 text-warning"></i> Add New Fee Head</h6>
                </div>
                <div class="card-body p-4">
                    @if(session('success'))
                        <div class="alert alert-success border-0 small mb-3">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('fees.heads.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-bold">Fee Head Name</label>
                            <input type="text" name="name" class="form-control shadow-sm" placeholder="e.g. Tuition Fee, Admission Fee" required>
                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Type / Frequency</label>
                            <select name="type" class="form-select shadow-sm" required>
                                <option value="Recurring">Recurring (Monthly / Regular)</option>
                                <option value="One-Time">One-Time (Admission / Security)</option>
                            </select>
                            @error('type')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-warning text-dark fw-bold w-100 shadow-sm">
                            <i class="fa-solid fa-save me-1"></i> Save Fee Head
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Fee Heads List -->
        <div class="col-md-8">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-dark text-white p-3">
                    <h6 class="mb-0 text-white"><i class="fa-solid fa-list-check me-2 text-warning"></i> Configured Fee Heads</h6>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Fee Head Name</th>
                                    <th>Type</th>
                                    <th>Status</th>
                                    <th class="text-end">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($feeHeads as $head)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="fw-bold text-dark">{{ $head->name }}</td>
                                    <td>
                                        <span class="badge {{ $head->type == 'Recurring' ? 'bg-info-subtle text-info border' : 'bg-secondary-subtle text-secondary border' }}">
                                            {{ $head->type }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-success-subtle text-success border">Active</span>
                                    </td>
                                    <td class="text-end">
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
                                    <td colspan="5" class="text-center py-4 text-muted">
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