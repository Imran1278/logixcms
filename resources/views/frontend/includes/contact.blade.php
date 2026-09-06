<!-- Contact Us Section (Included Partial) -->
<section class="contact-section py-5" id="contact-us-section">
    <style>
        .contact-info-card {
            background: #FFFFFF;
            border-radius: 14px;
            border: 1px solid rgba(212, 175, 55, 0.25);
            padding: 24px;
            height: 100%;
            transition: all 0.3s ease;
        }

        .contact-info-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 25px rgba(212, 175, 55, 0.15);
            border-color: rgba(212, 175, 55, 0.5);
        }

        .contact-info-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            background: rgba(212, 175, 55, 0.12);
            color: #D4AF37;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            margin-bottom: 15px;
        }

        .contact-form-card {
            background: #FFFFFF;
            border-radius: 16px;
            border: 1px solid rgba(212, 175, 55, 0.25);
            padding: 35px;
            box-shadow: 0 10px 30px rgba(15, 23, 42, 0.05);
        }

        .contact-form-card .form-control:focus {
            border-color: #D4AF37;
            box-shadow: 0 0 0 0.25rem rgba(212, 175, 55, 0.2);
        }

        .btn-gold-submit {
            background: linear-gradient(180deg, #EAD074 0%, #C49A21 100%);
            color: #FFFFFF !important;
            border: none;
            padding: 12px 28px;
            border-radius: 50px;
            font-weight: 700;
            transition: all 0.3s ease;
            box-shadow: 0 4px 14px rgba(196, 154, 33, 0.3);
        }

        .btn-gold-submit:hover {
            background: linear-gradient(180deg, #F3DA83 0%, #B08818 100%);
            transform: translateY(-1px);
            box-shadow: 0 6px 18px rgba(196, 154, 33, 0.4);
        }
    </style>

    <div class="container">
        <!-- Section Header -->
        <div class="text-center mb-5">
            <span class="badge bg-warning text-dark px-3 py-2 rounded-pill fw-bold text-uppercase mb-2">
                <i class="fa-solid fa-headset me-1"></i> Get In Touch
            </span>
            <h2 class="fw-extrabold display-6 text-dark mb-2">Have Any Questions?</h2>
            <p class="text-muted mx-auto mb-0" style="max-width: 600px;">
                Have questions about admissions, courses, or fee structure? Send us a message and our team will get back to you shortly.
            </p>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show rounded-3 mb-4 shadow-sm" role="alert">
                <i class="fa-solid fa-circle-check me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show rounded-3 mb-4 shadow-sm" role="alert">
                <i class="fa-solid fa-circle-exclamation me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Dynamic Quick Info Cards -->
        <div class="row g-4 mb-5">
            <div class="col-md-3">
                <div class="contact-info-card">
                    <div class="contact-info-icon"><i class="fa-solid fa-location-dot"></i></div>
                    <h6 class="fw-bold text-dark mb-1">Our Campus</h6>
                    <p class="text-muted small mb-0">{{ $footerData?->address ?? 'Sargodha, Punjab, Pakistan' }}</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="contact-info-card">
                    <div class="contact-info-icon"><i class="fa-solid fa-phone"></i></div>
                    <h6 class="fw-bold text-dark mb-1">Phone Number</h6>
                    <p class="text-muted small mb-0">{{ $footerData?->phone_number ?? '+92 48 3220901 / 0346-8667400' }}</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="contact-info-card">
                    <div class="contact-info-icon"><i class="fa-solid fa-clock"></i></div>
                    <h6 class="fw-bold text-dark mb-1">Working Hours</h6>
                    <p class="text-muted small mb-0">{{ $footerData?->working_hours ?? 'MON to SAT (8 AM TO 6 PM)' }}</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="contact-info-card">
                    <div class="contact-info-icon"><i class="fa-solid fa-globe"></i></div>
                    <h6 class="fw-bold text-dark mb-1">Official Website</h6>
                    @if(!empty($footerData?->website_link))
                        <a href="{{ $footerData->website_link }}" target="_blank" class="text-primary small text-decoration-underline text-truncate d-block">
                            {{ parse_url($footerData->website_link, PHP_URL_HOST) ?? $footerData->website_link }}
                        </a>
                    @else
                        <p class="text-muted small mb-0">www.logix.edu.pk</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Contact Form -->
        <div class="row justify-content-center mb-5">
            <div class="col-lg-8">
                <div class="contact-form-card">
                    <h4 class="fw-bold text-dark mb-4 d-flex align-items-center gap-2">
                        <i class="fa-solid fa-paper-plane text-warning"></i>
                        <span>Send Us A Message</span>
                    </h4>

                    <form action="{{ route('contact.send') }}" method="POST">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold small text-dark">Full Name *</label>
                                <input type="text" name="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" required placeholder="John Doe">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold small text-dark">Email Address *</label>
                                <input type="email" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" required placeholder="name@example.com">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold small text-dark">Phone Number</label>
                                <input type="text" name="phone" value="{{ old('phone') }}" class="form-control @error('phone') is-invalid @enderror" placeholder="+92 300 0000000">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold small text-dark">Subject</label>
                                <input type="text" name="subject" value="{{ old('subject') }}" class="form-control @error('subject') is-invalid @enderror" placeholder="Course Inquiry">
                                @error('subject')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-semibold small text-dark">Message *</label>
                                <textarea name="message" rows="4" class="form-control @error('message') is-invalid @enderror" required placeholder="Write your message here...">{{ old('message') }}</textarea>
                                @error('message')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12 text-end mt-4">
                                <button type="submit" class="btn btn-gold-submit fw-bold">
                                    <i class="fa-solid fa-paper-plane me-1"></i> Send Message
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Student Inquiry Status Check Section -->
        @auth
            @php
                $myInquiries = \App\Models\Contact::where('email', auth()->user()->email)->latest()->get();
            @endphp

            @if($myInquiries->count() > 0)
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
                            <h5 class="fw-bold text-dark mb-3">
                                <i class="fa-solid fa-clock-rotate-left text-warning me-2"></i>My Recent Inquiries & Responses
                            </h5>

                            <div class="accordion accordion-flush" id="inquiryAccordion">
                                @foreach($myInquiries as $index => $inquiry)
                                    <div class="accordion-item border rounded-3 mb-2 overflow-hidden">
                                        <h2 class="accordion-header" id="heading{{ $inquiry->id }}">
                                            <button class="accordion-button collapsed fw-semibold text-dark" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $inquiry->id }}">
                                                <div class="d-flex align-items-center justify-content-between w-100 me-3">
                                                    <span>{{ $inquiry->subject ?? 'General Inquiry' }}</span>
                                                    <div>
                                                        @if($inquiry->admin_reply)
                                                            <span class="badge bg-success-subtle text-success rounded-pill px-2 py-1 small"><i class="fa-solid fa-reply me-1"></i> Replied</span>
                                                        @elseif($inquiry->is_read)
                                                            <span class="badge bg-info-subtle text-info rounded-pill px-2 py-1 small"><i class="fa-solid fa-eye me-1"></i> Read by Admin</span>
                                                        @else
                                                            <span class="badge bg-warning-subtle text-warning rounded-pill px-2 py-1 small"><i class="fa-solid fa-hourglass-start me-1"></i> Pending Review</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </button>
                                        </h2>
                                        <div id="collapse{{ $inquiry->id }}" class="accordion-collapse collapse" data-bs-parent="#inquiryAccordion">
                                            <div class="accordion-body bg-light">
                                                <p class="small text-muted mb-1"><strong>Sent Date:</strong> {{ $inquiry->created_at->format('d M, Y - h:i A') }}</p>
                                                <p class="small text-dark mb-3"><strong>My Message:</strong> {{ $inquiry->message }}</p>

                                                @if($inquiry->admin_reply)
                                                    <div class="p-3 bg-white border border-success-subtle rounded-3">
                                                        <div class="fw-bold text-success small mb-1">
                                                            <i class="fa-solid fa-user-shield me-1"></i> Admin Response ({{ $inquiry->replied_at ? \Carbon\Carbon::parse($inquiry->replied_at)->format('d M, Y') : '' }}):
                                                        </div>
                                                        <p class="small text-dark mb-0" style="white-space: pre-line;">{{ $inquiry->admin_reply }}</p>
                                                    </div>
                                                @else
                                                    <div class="p-2 bg-white rounded-3 small text-muted">
                                                        <i class="fa-solid fa-circle-info me-1"></i> Admin has not replied to this message yet.
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endauth

    </div>
</section>