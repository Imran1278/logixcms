@extends('layouts.app')

@section('page_title', 'CMS - Downloads & Resources')

@push('styles')
<style>
    :root {
        --admin-navy: #0A2D5A;
        --admin-navy-dark: #051329;
        --admin-gold: #CFAE4E;
        --admin-teal: #10B981;
    }

    .download-card {
        border: 1px solid #E2E8F0;
        border-radius: 16px;
        background: #ffffff;
        box-shadow: 0 10px 30px rgba(10, 45, 90, 0.04);
    }

    .download-header-pill {
        background: linear-gradient(135deg, var(--admin-navy) 0%, var(--admin-navy-dark) 100%);
        color: #ffffff;
        border-top-left-radius: 16px;
        border-top-right-radius: 16px;
        padding: 18px 24px;
        font-size: 0.95rem;
        font-weight: 700;
        border-bottom: 2px solid var(--admin-gold);
    }

    .form-box-styled {
        background-color: #F8FAFC;
        border: 1px dashed #CBD5E1;
        border-radius: 12px;
        padding: 20px;
    }

    .btn-navy-action {
        background: linear-gradient(135deg, var(--admin-navy) 0%, var(--admin-navy-dark) 100%);
        color: #ffffff;
        border-radius: 50px;
        font-weight: 700;
        font-size: 0.9rem;
        padding: 12px 24px;
        border: 1px solid var(--admin-gold);
        transition: all 0.3s ease;
    }

    .btn-navy-action:hover {
        background: var(--admin-gold);
        color: var(--admin-navy-dark);
        border-color: var(--admin-gold);
        box-shadow: 0 6px 20px rgba(207, 174, 78, 0.35);
        transform: translateY(-1px);
    }

    .form-control:focus, .form-select:focus {
        border-color: var(--admin-gold);
        box-shadow: 0 0 0 0.25rem rgba(207, 174, 78, 0.15);
    }
</style>
@endpush

@section('content')
<div class="container-fluid py-4">

    <!-- Header Banner -->
    <div class="d-flex align-items-center justify-content-between mb-4 bg-white p-4 rounded-4 shadow-sm border border-slate-100">
        <div class="d-flex align-items-center gap-3">
            <div class="rounded-3 p-3 text-white shadow-sm" style="background: linear-gradient(135deg, var(--admin-navy) 0%, var(--admin-navy-dark) 100%); border: 1px solid rgba(207, 174, 78, 0.3);">
                <i class="fa-solid fa-folder-open fs-4" style="color: var(--admin-gold);"></i>
            </div>
            <div>
                <h4 class="fw-bold text-dark mb-1">Resource & Downloads Directory</h4>
                <p class="text-muted small mb-0">Manage downloadable forms, prospectuses, examination notices, and official documents.</p>
            </div>
        </div>
        <div class="badge bg-light text-dark border px-3 py-2.5 rounded-pill d-flex align-items-center gap-2 shadow-xs">
            <span class="rounded-circle" style="width: 9px; height: 9px; background-color: var(--admin-teal);"></span>
            <span class="fw-bold text-secondary">Total Resources: <strong class="text-dark">{{ $downloads->total() ?? count($downloads) }}</strong></span>
        </div>
    </div>

    @if(session('success'))
        <div class="alert border-0 shadow-sm rounded-4 mb-4 alert-dismissible fade show d-flex align-items-center gap-3 text-white" style="background: linear-gradient(135deg, #065F46 0%, #047857 100%);" role="alert">
            <i class="fa-solid fa-circle-check fs-4 text-warning"></i>
            <div class="fw-medium">{{ session('success') }}</div>
            <button type="button" class="btn-close btn-close-white ms-auto shadow-none" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row g-4">
        <!-- Upload Form Box -->
        <div class="col-lg-4">
            <div class="download-card overflow-hidden">
                <div class="download-header-pill d-flex align-items-center gap-2">
                    <i class="fa-solid fa-cloud-arrow-up" style="color: var(--admin-gold);"></i> Upload New Resource
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('admin.downloads.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold small text-dark">Form / Document Title <span class="text-danger">*</span></label>
                            <div class="input-group shadow-xs rounded-3 overflow-hidden">
                                <span class="input-group-text bg-light text-muted border-end-0"><i class="fa-solid fa-heading"></i></span>
                                <input type="text" name="title" class="form-control border-start-0 ps-0" placeholder="e.g. Admission Application Form 2026" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold small text-dark">Category <span class="text-danger">*</span></label>
                            <div class="input-group shadow-xs rounded-3 overflow-hidden">
                                <span class="input-group-text bg-light text-muted border-end-0"><i class="fa-solid fa-layer-group"></i></span>
                                <select name="category" class="form-select border-start-0 ps-0" required>
                                    <option value="" selected disabled>-- Select Category --</option>
                                    <option value="Admission Forms">Admission Forms</option>
                                    <option value="Fee & Prospectus">Fee & Prospectus</option>
                                    <option value="Rules & Regulations">Rules & Regulations</option>
                                    <option value="Examination Forms">Examination Forms</option>
                                    <option value="Certificates Request">Certificates Request</option>
                                    <option value="General Downloads">General Downloads</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold small text-dark">Description</label>
                            <textarea name="description" class="form-control shadow-xs" rows="3" placeholder="Short description of this document..."></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold small text-dark">Select File (PDF, DOC, PNG, ZIP) <span class="text-danger">*</span></label>
                            <input type="file" name="file" class="form-control shadow-xs" required>
                        </div>

                        <button type="submit" class="btn btn-navy-action w-100 mt-2">
                            <i class="fa-solid fa-upload me-1" style="color: var(--admin-gold);"></i> Upload Document
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Forms Listing Table -->
        <div class="col-lg-8">
            <div class="download-card overflow-hidden">
                <div class="download-header-pill d-flex align-items-center justify-content-between">
                    <span class="d-flex align-items-center gap-2">
                        <i class="fa-solid fa-file-pdf text-danger"></i> Uploaded Resources Directory
                    </span>
                    <span class="badge bg-white text-dark fw-bold px-3 py-1 rounded-pill">{{ $downloads->total() ?? count($downloads) }} Files</span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr class="text-uppercase fs-8 text-secondary">
                                    <th class="ps-3" style="width: 50px;">#</th>
                                    <th>Document Details</th>
                                    <th>Category</th>
                                    <th>Type</th>
                                    <th>Upload Date</th>
                                    <th class="text-center pe-3" style="width: 100px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($downloads as $item)
                                    <tr>
                                        <td class="ps-3 font-monospace text-muted small">{{ $loop->iteration }}</td>
                                        <td class="py-3">
                                            <div class="fw-bold text-dark">{{ $item->title }}</div>
                                            @if($item->description)
                                                <div class="small text-muted">{{ Str::limit($item->description, 45) }}</div>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge bg-white text-dark border fw-semibold px-2.5 py-1 shadow-2xs">{{ $item->category }}</span>
                                        </td>
                                        <td>
                                            @php
                                                $ext = strtolower($item->file_type ?? pathinfo($item->file_path, PATHINFO_EXTENSION));
                                                $badgeClass = match($ext) {
                                                    'pdf' => 'bg-danger-subtle text-danger border-danger',
                                                    'doc', 'docx' => 'bg-primary-subtle text-primary border-primary',
                                                    'zip', 'rar' => 'bg-warning-subtle text-warning-emphasis border-warning',
                                                    default => 'bg-info-subtle text-info border-info'
                                                };
                                            @endphp
                                            <span class="badge {{ $badgeClass }} text-uppercase border fw-bold px-2 py-1">
                                                {{ $ext ?: 'FILE' }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="small text-muted"><i class="fa-regular fa-calendar me-1"></i>{{ $item->created_at?->format('d M, Y') }}</span>
                                        </td>
                                        <td class="text-center pe-3">
                                            <div class="d-flex justify-content-center gap-1">
                                                <a href="{{ asset($item->file_path) }}" target="_blank" class="btn btn-sm btn-outline-primary rounded-circle" title="Preview / Download" style="width: 32px; height: 32px; display: inline-flex; align-items: center; justify-content: center;">
                                                    <i class="fa-solid fa-eye"></i>
                                                </a>
                                                <form action="{{ route('admin.downloads.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this document?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger rounded-circle" title="Delete" style="width: 32px; height: 32px; display: inline-flex; align-items: center; justify-content: center;">
                                                        <i class="fa-solid fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted py-5">
                                            <i class="fa-solid fa-folder-open display-6 mb-3 opacity-50"></i>
                                            <h6 class="fw-bold text-dark mb-1">No download forms uploaded yet.</h6>
                                            <p class="text-muted small mb-0">Use the form on the left to upload your first document.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if(method_exists($downloads, 'hasPages') && $downloads->hasPages())
                        <div class="p-3 border-top d-flex justify-content-end bg-light">
                            {{ $downloads->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection