@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 mb-4">
        <div>
            <h3 class="fw-bold text-dark mb-1">Manage Contact & Inquiries</h3>
            <p class="text-muted small mb-0">Manage contact information and respond to student messages.</p>
        </div>
        <div class="d-flex align-items-center flex-wrap gap-2">
            <button type="button" class="btn btn-warning fw-bold rounded-pill px-4 shadow-sm" data-bs-toggle="modal" data-bs-target="#editContactInfoModal">
                <i class="fa-solid fa-pen-to-square me-1"></i> Update Contact Info
            </button>
            <span class="badge bg-warning text-dark px-3 py-2 rounded-pill fw-bold font-monospace">
                <i class="fa-solid fa-envelope me-1"></i> {{ $unreadCount }} Unread
            </span>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm rounded-4 alert-dismissible fade show mb-4" role="alert">
            <div class="d-flex align-items-center">
                <i class="fa-solid fa-circle-check fs-5 me-2 text-success"></i>
                <div>{{ session('success') }}</div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-uppercase fs-8 font-monospace text-secondary">
                        <tr>
                            <th class="ps-4 py-3">Status</th>
                            <th class="py-3">Sender</th>
                            <th class="py-3">Contact Info</th>
                            <th class="py-3">Subject & Message</th>
                            <th class="py-3">Date</th>
                            <th class="text-end pe-4 py-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($messages as $msg)
                            <tr class="{{ $msg->is_read ? 'bg-white' : 'bg-light fw-bold' }}">
                                <td class="ps-4 py-3">
                                    @if($msg->is_read)
                                        <span class="badge bg-secondary-subtle text-secondary rounded-pill px-2 py-1">Read</span>
                                    @else
                                        <span class="badge bg-primary rounded-pill px-2 py-1">New</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="fw-bold text-dark">{{ $msg->name }}</div>
                                </td>
                                <td>
                                    <div class="small text-muted"><i class="fa-regular fa-envelope me-1 text-secondary"></i>{{ $msg->email }}</div>
                                    @if($msg->phone)
                                        <div class="small text-muted"><i class="fa-solid fa-phone me-1 text-secondary"></i>{{ $msg->phone }}</div>
                                    @endif
                                </td>
                                <td style="max-width: 300px;">
                                    <div class="fw-semibold text-dark text-truncate">{{ $msg->subject ?? 'No Subject' }}</div>
                                    <div class="small text-muted text-truncate" title="{{ $msg->message }}">{{ $msg->message }}</div>
                                </td>
                                <td class="small text-muted font-monospace">
                                    {{ $msg->created_at->format('d M, Y - h:i A') }}
                                </td>
                                <td class="text-end pe-4">
                                    <div class="d-flex align-items-center justify-content-end gap-2">
                                        <!-- View / Reply Modal Trigger Button -->
                                        <button class="btn btn-sm btn-outline-primary rounded-circle shadow-none" data-bs-toggle="modal" data-bs-target="#viewMsgModal{{ $msg->id }}" title="View & Reply">
                                            <i class="fa-solid fa-reply"></i>
                                        </button>

                                        <form action="{{ route('admin.contacts.toggleRead', $msg->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-outline-secondary rounded-circle shadow-none" title="Mark Read/Unread">
                                                <i class="fa-solid {{ $msg->is_read ? 'fa-envelope-open' : 'fa-envelope' }}"></i>
                                            </button>
                                        </form>

                                        <form action="{{ route('admin.contacts.destroy', $msg->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this message?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger rounded-circle shadow-none" title="Delete Message">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </button>
                                        </form>
                                    </div>

                                    <!-- View & Reply Modal -->
                                    <div class="modal fade text-start" id="viewMsgModal{{ $msg->id }}" tabindex="-1">
                                        <div class="modal-dialog modal-dialog-centered modal-lg">
                                            <div class="modal-content rounded-4 border-0 shadow">
                                                <div class="modal-header border-0 pb-0 pt-4 px-4">
                                                    <h5 class="modal-title fw-bold text-dark">
                                                        <i class="fa-solid fa-envelope-open-text text-warning me-2"></i>Message Details & Reply
                                                    </h5>
                                                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body p-4">
                                                    <div class="row g-3 mb-4 bg-light p-3 rounded-4 border">
                                                        <div class="col-md-4">
                                                            <small class="text-muted d-block text-uppercase fw-bold fs-8">Sender Name</small>
                                                            <strong class="text-dark">{{ $msg->name }}</strong>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <small class="text-muted d-block text-uppercase fw-bold fs-8">Email Address</small>
                                                            <span class="text-dark">{{ $msg->email }}</span>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <small class="text-muted d-block text-uppercase fw-bold fs-8">Phone Number</small>
                                                            <span class="text-dark">{{ $msg->phone ?? 'N/A' }}</span>
                                                        </div>
                                                    </div>

                                                    <div class="mb-3">
                                                        <small class="text-muted d-block text-uppercase fw-bold fs-8">Subject</small>
                                                        <strong class="text-primary fs-6">{{ $msg->subject ?? 'No Subject' }}</strong>
                                                    </div>

                                                    <div class="mb-4">
                                                        <small class="text-muted d-block text-uppercase fw-bold fs-8 mb-1">Student's Message</small>
                                                        <div class="p-3 bg-light rounded-4 text-secondary border" style="white-space: pre-line;">{{ $msg->message }}</div>
                                                    </div>

                                                    <hr class="my-4">

                                                    <!-- Direct Email Reply Form -->
                                                    <form action="{{ route('admin.contacts.reply', $msg->id) }}" method="POST">
                                                        @csrf
                                                        <div class="mb-3">
                                                            <label class="form-label fw-bold text-dark mb-1">
                                                                <i class="fa-solid fa-paper-plane text-primary me-1"></i> Write Reply Email <span class="text-danger">*</span>
                                                            </label>
                                                            <textarea name="reply_message" rows="4" class="form-control shadow-none" required placeholder="Type your response to {{ $msg->name }} here..."></textarea>
                                                        </div>
                                                        <div class="d-flex justify-content-end gap-2">
                                                            <button type="button" class="btn btn-light rounded-pill px-4 fw-bold text-secondary" data-bs-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold shadow-sm">
                                                                <i class="fa-solid fa-paper-plane me-1"></i> Send Reply Email
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <i class="fa-solid fa-inbox fa-2x mb-2 d-block opacity-50"></i>
                                    No contact messages found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($messages->hasPages())
                <div class="p-3 border-top">
                    {{ $messages->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Modal: Update Contact & Footer Info -->
@php
    $footerData = \App\Models\Footer::first();
@endphp
<div class="modal fade" id="editContactInfoModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header border-0 pt-4 px-4 pb-0">
                <h5 class="modal-title fw-bold text-dark"><i class="fa-solid fa-sliders text-warning me-2"></i>Update Public Contact Info</h5>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.footer.update') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small text-secondary">Phone Number(s)</label>
                            <input type="text" name="phone_number" class="form-control shadow-none" value="{{ $footerData?->phone_number }}" placeholder="+92 48 3220901 / 0346-8667400">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small text-secondary">Email Address</label>
                            <input type="email" name="email" class="form-control shadow-none" value="{{ $footerData?->email }}" placeholder="info@logix.edu.pk">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small text-secondary">Working Hours</label>
                            <input type="text" name="working_hours" class="form-control shadow-none" value="{{ $footerData?->working_hours }}" placeholder="MON to SAT (8 AM TO 6 PM)">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small text-secondary">Website / URL Link</label>
                            <input type="url" name="website_link" class="form-control shadow-none" value="{{ $footerData?->website_link ?? 'https://alicreations.kesug.com' }}" placeholder="https://example.com">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold small text-secondary">Campus Address / Location</label>
                            <textarea name="address" class="form-control shadow-none" rows="2" placeholder="Sargodha, Punjab, Pakistan">{{ $footerData?->address }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 pb-4 px-4 pt-0">
                    <button type="button" class="btn btn-light rounded-pill px-4 fw-bold text-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-warning fw-bold rounded-pill px-4 shadow-sm">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection