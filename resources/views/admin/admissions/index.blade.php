@extends('layouts.app')

@section('page_title', 'Student Directory & QR / CNIC Search')

@push('styles')
<style>
    :root {
        --color-navy: #0A2D5A;
        --color-blue: #2E5FA3;
        --color-ice: #8BB4E3;
        --color-gold: #CFAE4E;
        
        --panel-bg: #FFFFFF;
        --panel-border: #E2E8F0;
        --panel-header-bg: #0A2D5A;
        --panel-header-text: #FFFFFF;
        --input-bg: #FFFFFF;
        --input-border: #CBD5E1;
        --input-text: #0F172A;
        --text-primary: #0F172A;
        --text-muted: #64748B;
        --card-bg: #FFFFFF;
        --box-subtle-bg: #F8FAFC;
        --table-hover-bg: #F8FAFC;
        --modal-bg: #FFFFFF;
    }

    [data-bs-theme="dark"] {
        --panel-bg: #0F1B2D;
        --panel-border: #1E293B;
        --panel-header-bg: #06152B;
        --panel-header-text: #F1F5F9;
        --input-bg: #162842;
        --input-border: #334155;
        --input-text: #F8FAFC;
        --text-primary: #F8FAFC;
        --text-muted: #94A3B8;
        --card-bg: #0F1B2D;
        --box-subtle-bg: #162842;
        --table-hover-bg: #162842;
        --modal-bg: #0F1B2D;
    }

    .dir-card {
        border: 1px solid var(--panel-border);
        border-radius: 16px;
        background: var(--card-bg);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
    }

    .dir-header {
        background: var(--panel-header-bg);
        color: var(--panel-header-text);
        padding: 20px 24px;
        border-bottom: 2px solid var(--color-gold);
    }

    .avatar-circle {
        width: 45px;
        height: 45px;
        min-width: 45px;
        min-height: 45px;
        background-color: var(--color-navy);
        color: #FFFFFF;
        font-size: 16px;
    }

    .btn-gold {
        background-color: var(--color-gold);
        color: var(--color-navy);
        font-weight: 700;
        border-radius: 8px;
        border: none;
        transition: all 0.25s ease;
    }

    .btn-gold:hover {
        background-color: #B8993E;
        color: #000000;
        box-shadow: 0 4px 12px rgba(207, 174, 78, 0.35);
    }

    .search-container {
        background-color: var(--box-subtle-bg);
        border-bottom: 1px solid var(--panel-border);
    }

    .form-control {
        background-color: var(--input-bg);
        border-color: var(--input-border);
        color: var(--input-text);
    }

    .form-control:focus {
        background-color: var(--input-bg);
        color: var(--input-text);
        border-color: var(--color-gold);
        box-shadow: 0 0 0 0.25rem rgba(207, 174, 78, 0.25);
    }

    .table-custom {
        color: var(--text-primary);
        margin-bottom: 0;
    }

    .table-custom thead {
        background-color: var(--box-subtle-bg);
        border-bottom: 1px solid var(--panel-border);
    }

    .table-custom thead th {
        color: var(--text-muted);
        font-size: 0.75rem;
        letter-spacing: 0.5px;
    }

    .table-custom tbody tr {
        border-bottom: 1px solid var(--panel-border);
        transition: background-color 0.2s ease;
    }

    .table-custom tbody tr:hover {
        background-color: var(--table-hover-bg);
    }

    .text-theme-primary { color: var(--text-primary) !important; }
    .text-theme-muted { color: var(--text-muted) !important; }

    #reader {
        width: 100%;
        max-width: 450px;
        margin: 0 auto;
        border-radius: 12px;
        overflow: hidden;
        border: 2px dashed var(--color-gold);
    }

    .modal-content {
        background-color: var(--modal-bg);
        border: 1px solid var(--panel-border);
    }
</style>
@endpush

@section('content')
<div class="container-fluid py-2">

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-3 mb-3 shadow-sm border-0" role="alert">
            <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($errors->has('error'))
        <div class="alert alert-danger alert-dismissible fade show rounded-3 mb-3 shadow-sm border-0" role="alert">
            <i class="fa-solid fa-triangle-exclamation me-2"></i> {{ $errors->first('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="dir-card overflow-hidden">
        <div class="dir-header d-flex flex-wrap justify-content-between align-items-center gap-3">
            <div class="d-flex align-items-center gap-3">
                <div class="bg-warning text-dark p-2 rounded-3">
                    <i class="fa-solid fa-graduation-cap fs-4"></i>
                </div>
                <div>
                    <h5 class="fw-bold mb-0">Enrolled Students Directory</h5>
                    <small class="text-white-50">Search student details, password status, or scan ID QR code for auto-lookup.</small>
                </div>
            </div>
            <div class="d-flex gap-2">
                <button class="btn btn-outline-warning fw-bold btn-sm shadow-sm px-3 py-2 rounded-2" data-bs-toggle="modal" data-bs-target="#qrScanModal">
                    <i class="fa-solid fa-qrcode me-1"></i> Scan Student QR
                </button>
                <a href="{{ route('admissions.create') }}" class="btn btn-gold btn-sm shadow-sm px-3 py-2 rounded-2">
                    <i class="fa-solid fa-plus me-1"></i> Pre-Register Student
                </a>
            </div>
        </div>

        <div class="p-4 search-container">
            <form action="{{ route('admissions.index') }}" method="GET" id="searchForm" class="row g-2 align-items-center">
                <div class="col-md-9 col-lg-10">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0"><i class="fa-solid fa-magnifying-glass text-muted"></i></span>
                        <input type="text" name="cnic" id="searchInput" class="form-control form-control-lg fs-6 border-start-0" placeholder="Enter Student CNIC (e.g. 38403-xxxxxxx-x) or Scan QR..." value="{{ request('cnic', $cnic ?? '') }}" autofocus>
                        @if(request('cnic'))
                            <a href="{{ route('admissions.index') }}" class="btn btn-outline-secondary d-flex align-items-center">
                                <i class="fa-solid fa-xmark me-1"></i> Clear
                            </a>
                        @endif
                    </div>
                </div>
                <div class="col-md-3 col-lg-2">
                    <button type="submit" class="btn btn-dark btn-lg w-100 fs-6 fw-bold">Search Record</button>
                </div>
            </form>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-custom align-middle mb-0">
                    <thead>
                        <tr class="text-uppercase">
                            <th class="ps-4 py-3">Student Identity</th>
                            <th>CNIC / Contact</th>
                            <th>Enrolled Course & Batch</th>
                            <th>Portal Setup</th>
                            <th class="text-center">Account Status</th>
                            <th class="pe-4 text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($admissions as $item)
                        @php
                            $user = $item->user ?? (isset($item->role) ? $item : null);
                            $rawPicture = $user->picture ?? $item->picture ?? null;
                            
                            $imageUrl = null;
                            if (!empty($rawPicture)) {
                                $imageUrl = str_starts_with($rawPicture, 'http') 
                                    ? $rawPicture 
                                    : asset('storage/' . ltrim($rawPicture, '/'));
                            }
                            
                            $hasRealName = (!empty($item->student_name) && $item->student_name !== 'Pending Entry');
                            $displayName = $hasRealName ? $item->student_name : ($user->name ?? 'Pending Profile Entry');
                            
                            $cnicVal  = $item->cnic_bform ?? $user->cnic ?? 'N/A';
                            $emailVal = $item->email ?? $user->email ?? 'N/A';
                            $phoneVal = $item->mobile_number ?? $user->phone ?? 'Not Provided';
                            $initial  = $hasRealName ? strtoupper(substr(trim($displayName), 0, 1)) : null;
                        @endphp
                        <tr>
                            <td class="ps-4 py-3">
                                <div class="d-flex align-items-center gap-3">
                                    @if(!empty($imageUrl))
                                        <img src="{{ $imageUrl }}" 
                                             class="rounded-circle border object-fit-cover shadow-sm" 
                                             width="45" height="45" 
                                             alt="Student Avatar"
                                             onerror="this.style.display='none'; if(this.nextElementSibling) this.nextElementSibling.style.setProperty('display', 'flex', 'important');">
                                        
                                        <div class="rounded-circle text-white align-items-center justify-content-center fw-bold shadow-sm avatar-circle" 
                                             style="display: none !important;">
                                            {{ $initial ?? 'S' }}
                                        </div>
                                    @else
                                        <div class="rounded-circle text-white d-flex align-items-center justify-content-center fw-bold shadow-sm avatar-circle">
                                            {{ $initial ?? 'S' }}
                                        </div>
                                    @endif

                                    <div>
                                        <div class="fw-bold text-theme-primary fs-6">{{ $displayName }}</div>
                                        <small class="text-theme-muted"><i class="fa-regular fa-envelope me-1"></i>{{ $emailVal }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="small fw-semibold text-theme-primary"><i class="fa-regular fa-id-card me-1 text-secondary"></i>{{ $cnicVal }}</div>
                                <small class="text-theme-muted"><i class="fa-solid fa-phone me-1 text-success"></i>{{ $phoneVal }}</small>
                            </td>
                            <td>
                                <span class="badge bg-primary-subtle text-primary fw-bold">
                                    {{ $item->course->title ?? $item->course->course_name ?? 'Not Selected Yet' }}
                                </span>
                                <small class="d-block text-theme-muted mt-1 fw-semibold">
                                    Batch: {{ $item->batch->batch_name ?? $item->batch->batch_number ?? 'Not Selected Yet' }}
                                </small>
                            </td>
                            <td>
                                @if(($user->profile_completed ?? false) || ($item->profile_completed ?? false))
                                    <span class="badge bg-success-subtle text-success"><i class="fa-solid fa-check me-1"></i>Password Set</span>
                                @else
                                    <span class="badge bg-warning-subtle text-warning-emphasis"><i class="fa-solid fa-clock me-1"></i>Pending Password</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <span class="badge bg-success px-2 py-1">{{ $item->status ?? 'Registered' }}</span>
                            </td>
                            <td class="pe-4 text-end">
                                <a href="{{ route('admissions.show', $item->id) }}" class="btn btn-sm btn-outline-primary rounded-2 px-3 fw-bold">
                                    <i class="fa-solid fa-eye me-1"></i> Details
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-theme-muted">
                                <i class="fa-solid fa-user-slash fs-2 d-block mb-2 opacity-50"></i>
                                @if(request('cnic'))
                                    No student record found matching CNIC or ID: <strong>{{ request('cnic') }}</strong>
                                @else
                                    No student admission records found in system.
                                @endif
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if(method_exists($admissions, 'hasPages') && $admissions->hasPages())
                <div class="p-3 search-container d-flex justify-content-between align-items-center">
                    <small class="text-theme-muted">
                        Showing {{ $admissions->firstItem() }} to {{ $admissions->lastItem() }} of {{ $admissions->total() }} students
                    </small>
                    <div>
                        {{ $admissions->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Camera QR Scanner Modal -->
<div class="modal fade" id="qrScanModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="modal-header bg-dark text-white p-3">
                <h5 class="modal-title fw-bold fs-6"><i class="fa-solid fa-qrcode text-warning me-2"></i> Scan Student ID / Card QR</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" onclick="stopQrScanner()"></button>
            </div>
            <div class="modal-body text-center p-4">
                <p class="text-theme-muted small mb-3">Position the QR code inside the camera viewfinder to instantly fetch details.</p>
                <div id="reader"></div>
                <div id="scanResultMsg" class="mt-3 fw-bold text-success d-none">
                    <i class="fa-solid fa-circle-check me-1"></i> QR Scanned! Loading details...
                </div>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-secondary btn-sm px-4 rounded-pill" data-bs-dismiss="modal" onclick="stopQrScanner()">Close Scanner</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
<script>
    let html5QrcodeScanner = null;

    function onScanSuccess(decodedText, decodedResult) {
        if(decodedText) {
            document.getElementById('scanResultMsg').classList.remove('d-none');
            stopQrScanner();
            
            // Check if URL or raw CNIC/ID
            if(decodedText.startsWith('http://') || decodedText.startsWith('https://')) {
                window.location.href = decodedText;
            } else {
                document.getElementById('searchInput').value = decodedText;
                document.getElementById('searchForm').submit();
            }
        }
    }

    document.getElementById('qrScanModal').addEventListener('shown.bs.modal', function () {
        if(!html5QrcodeScanner) {
            html5QrcodeScanner = new Html5QrcodeScanner("reader", { fps: 10, qrbox: {width: 250, height: 250} }, false);
            html5QrcodeScanner.render(onScanSuccess);
        }
    });

    function stopQrScanner() {
        if (html5QrcodeScanner) {
            html5QrcodeScanner.clear().catch(error => console.error(error));
            html5QrcodeScanner = null;
        }
    }
</script>
@endpush