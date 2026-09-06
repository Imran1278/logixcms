@extends('layouts.app')

@section('page_title', 'Manage Fee Configurations')

@section('content')
<div class="container py-3">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold text-dark mb-0">Fee System Configurations</h4>
            <small class="text-muted">Manage Academic Sessions, Payment Frequencies, and Scholarship Reasons dynamically.</small>
        </div>
        <a href="{{ route('fees.index') }}" class="btn btn-outline-dark fw-bold">
            <i class="fa-solid fa-arrow-left me-1"></i> Back to Directory
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm rounded-3 mb-4">
            <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
        </div>
    @endif

    <div class="row g-4">
        <!-- Academic Sessions -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-dark text-white p-3">
                    <h6 class="mb-0 text-white"><i class="fa-solid fa-calendar-days text-warning me-2"></i> Academic Sessions</h6>
                </div>
                <div class="card-body p-3">
                    <form action="{{ route('fees.settings.store') }}" method="POST" class="mb-3">
                        @csrf
                        <input type="hidden" name="type" value="session">
                        <div class="input-group">
                            <input type="text" name="title" class="form-control" placeholder="e.g. 2026-2027" required>
                            <button type="submit" class="btn btn-warning text-dark fw-bold"><i class="fa-solid fa-plus"></i></button>
                        </div>
                    </form>

                    <ul class="list-group list-group-flush border-top">
                        @forelse($sessions as $item)
                            <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                <span class="fw-bold text-dark">{{ $item->title }}</span>
                                <form action="{{ route('fees.settings.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Delete this session?');">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger border-0"><i class="fa-solid fa-trash"></i></button>
                                </form>
                            </li>
                        @empty
                            <li class="list-group-item text-muted text-center py-3">No Sessions Added</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>

        <!-- Frequencies -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-dark text-white p-3">
                    <h6 class="mb-0 text-white"><i class="fa-solid fa-clock-rotate-left text-warning me-2"></i> Frequencies</h6>
                </div>
                <div class="card-body p-3">
                    <form action="{{ route('fees.settings.store') }}" method="POST" class="mb-3">
                        @csrf
                        <input type="hidden" name="type" value="frequency">
                        <div class="input-group">
                            <input type="text" name="title" class="form-control" placeholder="e.g. Monthly, Quarterly" required>
                            <button type="submit" class="btn btn-warning text-dark fw-bold"><i class="fa-solid fa-plus"></i></button>
                        </div>
                    </form>

                    <ul class="list-group list-group-flush border-top">
                        @forelse($frequencies as $item)
                            <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                <span class="fw-bold text-dark">{{ $item->title }}</span>
                                <form action="{{ route('fees.settings.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Delete this frequency?');">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger border-0"><i class="fa-solid fa-trash"></i></button>
                                </form>
                            </li>
                        @empty
                            <li class="list-group-item text-muted text-center py-3">No Frequencies Added</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>

        <!-- Scholarship Reasons -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-dark text-white p-3">
                    <h6 class="mb-0 text-white"><i class="fa-solid fa-award text-warning me-2"></i> Scholarship / Reasons</h6>
                </div>
                <div class="card-body p-3">
                    <form action="{{ route('fees.settings.store') }}" method="POST" class="mb-3">
                        @csrf
                        <input type="hidden" name="type" value="scholarship_reason">
                        <div class="input-group">
                            <input type="text" name="title" class="form-control" placeholder="e.g. Kinship / Merit" required>
                            <button type="submit" class="btn btn-warning text-dark fw-bold"><i class="fa-solid fa-plus"></i></button>
                        </div>
                    </form>

                    <ul class="list-group list-group-flush border-top">
                        @forelse($scholarshipReasons as $item)
                            <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                <span class="fw-bold text-dark">{{ $item->title }}</span>
                                <form action="{{ route('fees.settings.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Delete this reason?');">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger border-0"><i class="fa-solid fa-trash"></i></button>
                                </form>
                            </li>
                        @empty
                            <li class="list-group-item text-muted text-center py-3">No Reasons Added</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection