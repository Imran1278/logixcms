@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h3 class="fw-bold text-dark mb-1">Manage Contact & Inquiries</h3>
            <p class="text-muted small mb-0">Manage contact information and respond to student messages.</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <button type="button" class="btn btn-warning fw-bold rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#editContactInfoModal">
                <i class="fa-solid fa-pen-to-square me-1"></i> Update Contact Info
            </button>
            <span class="badge bg-warning text-dark px-3 py-2 rounded-pill fw-bold">
                <i class="fa-solid fa-envelope me-1"></i> {{ $unreadCount }} Unread
            </span>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-3 mb-4" role="alert">
            <i class="fa-solid fa-circle-check me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-uppercase small font-monospace">
                        <tr>
                            <th class="ps-4">Status</th>
                            <th>Sender</th>
                            <th>Contact Info</th>
                            <th>Subject & Message</th>
                            <th>Date</th>
                            <th class="text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($messages as $msg)
                            <tr class="{{ $msg->is_read ? 'bg-white' : 'bg-light fw-bold' }}">
                                <td class="ps-4">
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
                                    <div class="small text-muted"><i class="fa-regular fa-envelope me-1"></i>{{ $msg->email }}</div>
                                    @if($msg->phone)
                                        <div class="small text-muted"><i class="fa-solid fa-phone me-1"></i>{{ $msg->phone }}</div>
                                    @endif
                                </td>
                                <td style="max-width: 300px;">
                                    <div class="fw-semibold text-dark text-truncate">{{ $msg->subject ?? 'No Subject' }}</div>
                                    <div class="small text-muted text-truncate" title="{{ $msg->message }}">{{ $msg->message }}</div>
                                </td>
                                <td class="small text-muted">
                                    {{ $msg->created_at->format('d M, Y - h:i A') }}
                                </td>
                                <td class="text-end pe-4">
                                    <div class="d-flex align-items-center justify-content-end gap-2">
                                        <!-- View / Reply Modal Trigger Button -->
                                        <button class="btn btn-sm btn-outline-primary rounded-circle" data-bs-toggle="modal" data-bs-target="#viewMsgModal{{ $msg->id }}" title="View & Reply">
                                            <i class="fa-solid fa-reply"></i>
                                        </button>

                                        <form action="{{ route('admin.contacts.toggleRead', $msg->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-outline-secondary rounded-circle" title="Mark Read/Unread">
                                                <i class="fa-solid {{ $msg->is_read ? 'fa-envelope-open' : 'fa-envelope' }}"></i>
                                            </button>
                                        </form>

                                        <form action="{{ route('admin.contacts.destroy', $msg->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this message?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger rounded-circle" title="Delete Message">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </button>
                                        </form>
                                    </div>

                                    <!-- View & Reply Modal -->
                                    <div class="modal fade text-start" id="viewMsgModal{{ $msg->id }}" tabindex="-1">
                                        <div class="modal-dialog modal-dialog-centered modal-lg">
                                            <div class="modal-content rounded-4 border-0">
                                                <div class="modal-header border-bottom-0 pb-0">
                                                    <h5 class="modal-header-title fw-bold text-dark">
                                                        <i class="fa-solid fa-envelope-open-text text-warning me-2"></i>Message Details & Reply
                                                    </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body py-3">
                                                    <div class="row g-2 mb-3 bg-light p-3 rounded-3">
                                                        <div class="col-md-4">
                                                            <small class="text-muted d-block">Sender Name</small>
                                                            <strong class="text-dark">{{ $msg->name }}</strong>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <small class="text-muted d-block">Email Address</small>
                                                            <span class="text-dark">{{ $msg->email }}</span>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <small class="text-muted d-block">Phone Number</small>
                                                            <span class="text-dark">{{ $msg->phone ?? 'N/A' }}</span>
                                                        </div>
                                                    </div>

                                                    <div class="mb-3">
                                                        <small class="text-muted d-block">Subject</small>
                                                        <strong class="text-primary">{{ $msg->subject ?? 'No Subject' }}</strong>
                                                    </div>

                                                    <div class="mb-4">
                                                        <small class="text-muted d-block mb-1">Student's Message</small>
                                                        <div class="p-3 bg-light rounded-3 text-secondary" style="white-space: pre-line;">{{ $msg->message }}</div>
                                                    </div>

                                                    <hr class="my-4">

                                                    <!-- Direct Email Reply Form -->
                                                    <form action="{{ route('admin.contacts.reply', $msg->id) }}" method="POST">
                                                        @csrf
                                                        <div class="mb-3">
                                                            <label class="form-label fw-bold text-dark mb-1">
                                                                <i class="fa-solid fa-paper-plane text-primary me-1"></i> Write Reply Email
                                                            </label>
                                                            <textarea name="reply_message" rows="4" class="form-control" required placeholder="Type your response to {{ $msg->name }} here..."></textarea>
                                                        </div>
                                                        <div class="text-end">
                                                            <button type="button" class="btn btn-light btn-sm rounded-pill px-3 me-2" data-bs-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-primary btn-sm rounded-pill px-4 fw-bold">
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
                                    <i class="fa-solid fa-inbox fa-2x mb-2 d-block"></i>
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
        <div class="modal-content rounded-4 border-0">
            <div class="modal-header border-bottom-0">
                <h5 class="modal-title fw-bold text-dark"><i class="fa-solid fa-sliders text-warning me-2"></i>Update Public Contact Info</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.footer.update') }}" method="POST">
                @csrf
                <div class="modal-body py-0">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">Phone Number(s)</label>
                            <input type="text" name="phone_number" class="form-control" value="{{ $footerData?->phone_number }}" placeholder="+92 48 3220901 / 0346-8667400">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">Email Address</label>
                            <input type="email" name="email" class="form-control" value="{{ $footerData?->email }}" placeholder="info@logix.edu.pk">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">Working Hours</label>
                            <input type="text" name="working_hours" class="form-control" value="{{ $footerData?->working_hours }}" placeholder="MON to SAT (8 AM TO 6 PM)">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">Website / URL Link</label>
                            <input type="url" name="website_link" class="form-control" value="{{ $footerData?->website_link ?? 'https://alicreations.kesug.com' }}" placeholder="https://example.com">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold small">Campus Address / Location</label>
                            <textarea name="address" class="form-control" rows="2" placeholder="Sargodha, Punjab, Pakistan">{{ $footerData?->address }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top-0 mt-3">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-warning fw-bold rounded-pill px-4">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection