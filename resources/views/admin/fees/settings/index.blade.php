@extends('layouts.app')

@section('page_title', 'Manage Fee Configurations')

@section('content')
<div class="container py-4">

    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <h4 class="fw-bold text-dark mb-1">Fee System Configurations</h4>
            <p class="text-muted mb-0">Manage Academic Sessions, Payment Frequencies, and Scholarship Reasons dynamically.</p>
        </div>
        <a href="{{ route('fees.index') }}" class="btn btn-outline-dark fw-bold align-self-start align-self-md-auto">
            <i class="fa-solid fa-arrow-left me-2"></i> Back to Directory
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm rounded-4 mb-4">
            <div class="d-flex align-items-center">
                <i class="fa-solid fa-circle-check fs-5 me-2 text-success"></i>
                <div>{{ session('success') }}</div>
            </div>
        </div>
    @endif

    <div class="row g-4">
        <!-- Academic Sessions -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-dark text-white p-3 rounded-top-4">
                    <h6 class="mb-0 text-white"><i class="fa-solid fa-calendar-days text-warning me-2"></i> Academic Sessions</h6>
                </div>
                <div class="card-body p-4 d-flex flex-column">
                    <form action="{{ route('fees.settings.store') }}" method="POST" class="mb-3">
                        @csrf
                        <input type="hidden" name="type" value="session">
                        <div class="input-group">
                            <input type="text" name="title" class="form-control shadow-none" placeholder="e.g. 2026-2027" required>
                            <button type="submit" class="btn btn-warning text-dark fw-bold px-3"><i class="fa-solid fa-plus"></i></button>
                        </div>
                    </form>

                    <ul class="list-group list-group-flush border-top mt-2">
                        @forelse($sessions as $item)
                            <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-3">
                                <span class="fw-semibold text-dark">{{ $item->title }}</span>
                                <form action="{{ route('fees.settings.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Delete this session?');">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger border-0"><i class="fa-solid fa-trash"></i></button>
                                </form>
                            </li>
                        @empty
                            <li class="list-group-item text-muted text-center py-4 border-0">No Sessions Added</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>

        <!-- Frequencies -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-dark text-white p-3 rounded-top-4">
                    <h6 class="mb-0 text-white"><i class="fa-solid fa-clock-rotate-left text-warning me-2"></i> Frequencies</h6>
                </div>
                <div class="card-body p-4 d-flex flex-column">
                    <form action="{{ route('fees.settings.store') }}" method="POST" class="mb-3">
                        @csrf
                        <input type="hidden" name="type" value="frequency">
                        <div class="input-group">
                            <input type="text" name="title" class="form-control shadow-none" placeholder="e.g. Monthly, Quarterly" required>
                            <button type="submit" class="btn btn-warning text-dark fw-bold px-3"><i class="fa-solid fa-plus"></i></button>
                        </div>
                    </form>

                    <ul class="list-group list-group-flush border-top mt-2">
                        @forelse($frequencies as $item)
                            <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-3">
                                <span class="fw-semibold text-dark">{{ $item->title }}</span>
                                <form action="{{ route('fees.settings.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Delete this frequency?');">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger border-0"><i class="fa-solid fa-trash"></i></button>
                                </form>
                            </li>
                        @empty
                            <li class="list-group-item text-muted text-center py-4 border-0">No Frequencies Added</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>

        <!-- Scholarship Reasons -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-dark text-white p-3 rounded-top-4">
                    <h6 class="mb-0 text-white"><i class="fa-solid fa-award text-warning me-2"></i> Scholarship / Reasons</h6>
                </div>
                <div class="card-body p-4 d-flex flex-column">
                    <form action="{{ route('fees.settings.store') }}" method="POST" class="mb-3">
                        @csrf
                        <input type="hidden" name="type" value="scholarship_reason">
                        <div class="input-group">
                            <input type="text" name="title" class="form-control shadow-none" placeholder="e.g. Kinship / Merit" required>
                            <button type="submit" class="btn btn-warning text-dark fw-bold px-3"><i class="fa-solid fa-plus"></i></button>
                        </div>
                    </form>

                    <ul class="list-group list-group-flush border-top mt-2">
                        @forelse($scholarshipReasons as $item)
                            <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-3">
                                <span class="fw-semibold text-dark">{{ $item->title }}</span>
                                <form action="{{ route('fees.settings.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Delete this reason?');">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger border-0"><i class="fa-solid fa-trash"></i></button>
                                </form>
                            </li>
                        @empty
                            <li class="list-group-item text-muted text-center py-4 border-0">No Reasons Added</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection