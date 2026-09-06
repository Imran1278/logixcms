@php
    $currentUser = $student ?? $user ?? auth()->user();
    
    $studentName  = strtoupper($currentUser->name ?? 'STUDENT');
    $studentEmail = $currentUser->email ?? '';
    $studentCnic  = $currentUser->cnic ?? $admission->cnic_bform ?? 'N/A';
    
    // Dynamic Address Logic
    $studentAddress = $currentUser->residential_address 
        ?? $currentUser->home_address 
        ?? $currentUser->address 
        ?? $admission->residential_address 
        ?? 'LOGIX College Sargodha';
    
    // Dynamic Avatar Logic
    $rawPic = $currentUser->picture ?? $admission->picture ?? null;
    $studentPic = $avatarUrl ?? (
        (!empty($rawPic) && \Illuminate\Support\Facades\Storage::disk('public')->exists($rawPic))
            ? asset('storage/' . ltrim($rawPic, '/')) 
            : 'https://ui-avatars.com/api/?name=' . urlencode($currentUser->name ?? 'Student') . '&background=0A2D5A&color=CFAE4E'
    );

    // Dynamic Admin-Added Courses & Batches Fetching with Fallbacks
    $coursesList = $coursesList ?? $courses ?? $availableCourses ?? collect();
    $batchesList = $batchesList ?? $batches ?? $availableBatches ?? collect();
@endphp

<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Complete & Edit Profile | LOGIX College</title>
    
    <link rel="icon" type="image/png" href="{{ asset('images/logix-logo.png') }}">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Framework Styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Custom Variables Theme Styling -->
    <style>
        :root {
            --color-navy: #0A2D5A;
            --color-blue: #2E5FA3;
            --color-ice: #8BB4E3;
            --color-gold: #CFAE4E;
            
            --panel-bg: #FFFFFF;
            --panel-border: #E2E8F0;
            --input-bg: #FFFFFF;
            --input-border: #CBD5E1;
            --input-text: #0F172A;
            --text-primary: #0F172A;
            --text-muted: #64748B;
            --card-bg: #FFFFFF;
            --box-subtle-bg: #F8FAFC;
        }

        [data-bs-theme="dark"] {
            --panel-bg: #0F1B2D;
            --panel-border: #1E293B;
            --input-bg: #162842;
            --input-border: #334155;
            --input-text: #F8FAFC;
            --text-primary: #F8FAFC;
            --text-muted: #94A3B8;
            --card-bg: #0F1B2D;
            --box-subtle-bg: #162842;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--box-subtle-bg);
            color: var(--text-primary);
            overflow-x: hidden;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        /* Sidebar Styling */
        .sidebar {
            width: 260px;
            background: #06152B;
            min-height: 100vh;
            border-right: 1px solid rgba(255, 255, 255, 0.08);
            padding: 24px 16px;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
        }

        .brand-logo {
            display: flex;
            align-items: center;
            gap: 12px;
            font-weight: 800;
            font-size: 1.25rem;
            color: #ffffff;
            margin-bottom: 30px;
            padding-left: 8px;
        }

        .brand-icon {
            width: 40px;
            height: 40px;
            background: var(--color-gold);
            color: #0A2D5A;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.15rem;
            box-shadow: 0 4px 12px rgba(207, 174, 78, 0.3);
        }

        .nav-section-title {
            font-size: 0.72rem;
            font-weight: 800;
            color: #64748B;
            letter-spacing: 0.8px;
            text-transform: uppercase;
            margin: 20px 0 10px 12px;
        }

        .nav-item-custom {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 12px 16px;
            border-radius: 12px;
            color: #CBD5E1;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.92rem;
            transition: all 0.25s ease;
            margin-bottom: 6px;
        }

        .nav-item-custom:hover {
            color: var(--color-gold);
            background: rgba(255, 255, 255, 0.05);
        }

        .nav-item-custom.active {
            background: var(--color-gold);
            color: #0A2D5A !important;
            box-shadow: 0 6px 16px rgba(207, 174, 78, 0.25);
            font-weight: 700;
        }

        /* Layout Container */
        .main-wrapper {
            margin-left: 260px;
            padding: 30px 40px;
        }

        @media (max-width: 991.98px) {
            .main-wrapper {
                margin-left: 0;
                padding: 20px 15px;
            }
        }

        /* Card Elements */
        .react-card {
            background-color: var(--card-bg);
            border: 1px solid var(--panel-border);
            border-radius: 16px;
            padding: 28px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
            transition: all 0.25s ease;
        }

        .form-control, .form-select {
            background-color: var(--input-bg);
            border: 1px solid var(--input-border);
            color: var(--input-text);
            border-radius: 10px;
            padding: 11px 16px;
            font-weight: 600;
            font-size: 0.92rem;
        }

        .form-control:focus, .form-select:focus {
            background-color: var(--input-bg);
            border-color: var(--color-gold);
            color: var(--input-text);
            box-shadow: 0 0 0 4px rgba(207, 174, 78, 0.18);
        }

        .form-label {
            font-size: 0.76rem;
            font-weight: 800;
            color: var(--text-muted);
            text-transform: uppercase;
            margin-bottom: 8px;
            letter-spacing: 0.5px;
        }

        .btn-gold {
            background-color: var(--color-gold);
            color: var(--color-navy);
            border-radius: 10px;
            padding: 12px 28px;
            font-weight: 800;
            border: none;
            transition: all 0.25s ease;
        }

        .btn-gold:hover {
            background-color: #B8993E;
            color: #000000;
            box-shadow: 0 6px 18px rgba(207, 174, 78, 0.35);
        }

        .theme-toggle-btn {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: 1px solid var(--panel-border);
            background-color: var(--card-bg);
            color: var(--text-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .theme-toggle-btn:hover {
            border-color: var(--color-gold);
            color: var(--color-gold);
        }

        .text-theme-primary { color: var(--text-primary) !important; }
        .text-theme-muted { color: var(--text-muted) !important; }
        .box-subtle { background-color: var(--box-subtle-bg); border: 1px solid var(--panel-border); }
        .border-theme { border-color: var(--panel-border) !important; }
    </style>
</head>
<body>

    <!-- Sidebar Navigation -->
    <aside class="sidebar d-none d-lg-block">
        <div class="brand-logo">
            <div class="brand-icon"><i class="fa-solid fa-graduation-cap"></i></div>
            <span>LOGIX <small class="text-warning fw-normal fs-6">Student</small></span>
        </div>

        <a href="{{ route('student.dashboard') }}" class="nav-item-custom">
            <span><i class="fa-solid fa-border-all me-2"></i> Dashboard</span>
        </a>

        <div class="nav-section-title">My Account</div>
        <a href="{{ Route::has('student.profile.complete') ? route('student.profile.complete') : route('student.dashboard') . '#profile' }}" class="nav-item-custom active">
            <span><i class="fa-regular fa-user me-2"></i> Edit Profile</span>
        </a>

        <form action="{{ route('student.logout') }}" method="POST" class="mt-4">
            @csrf
            <button type="submit" class="btn btn-outline-danger w-100 fw-bold rounded-3 py-2">
                <i class="fa-solid fa-power-off me-2"></i> Logout
            </button>
        </form>
    </aside>

    <!-- Main Content Layout -->
    <main class="main-wrapper">
        
        <!-- Header Strip -->
        <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-3 p-3 react-card">
            <div class="d-flex align-items-center gap-3">
                <img src="{{ $studentPic }}" alt="{{ $studentName }}" class="rounded-circle border border-warning shadow-sm" style="width: 52px; height: 52px; object-fit: cover;">
                <div>
                    <h4 class="fw-bold mb-0 text-theme-primary">Complete & Edit Profile</h4>
                    <small class="text-theme-muted">Manage your personal, guardian, and enrolled academic course details.</small>
                </div>
            </div>

            <div class="d-flex align-items-center gap-2">
                <!-- Light / Dark Theme Switcher -->
                <button type="button" class="theme-toggle-btn" id="themeToggleBtn" title="Toggle Light/Dark Theme">
                    <i class="fa-solid fa-moon" id="themeIcon"></i>
                </button>

                <a href="{{ route('student.dashboard') }}" class="btn btn-outline-secondary rounded-pill px-3 py-2 fw-bold fs-8">
                    <i class="fa-solid fa-arrow-left me-1"></i> Back to Dashboard
                </a>
            </div>
        </div>

        <!-- Success Alert -->
        @if(session('success'))
            <div class="alert alert-success border-0 rounded-4 shadow-sm mb-4">
                <i class="fa-solid fa-circle-check me-2"></i>{{ session('success') }}
            </div>
        @endif

        <!-- Validation Errors -->
        @if($errors->any())
            <div class="alert alert-danger border-0 rounded-4 shadow-sm mb-4">
                <div class="fw-bold mb-1"><i class="fa-solid fa-circle-exclamation me-1"></i> Please resolve following errors:</div>
                <ul class="mb-0 small ps-3">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Main Form Card -->
        <div class="react-card">
            <form action="{{ route('student.profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- SECTION 1: Personal Details -->
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h6 class="fw-bold text-theme-primary mb-0 text-uppercase letter-spacing-1">
                        <i class="fa-solid fa-user-gear text-warning me-2"></i> Personal Information
                    </h6>
                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle fs-8">Step 1</span>
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-md-4">
                        <label class="form-label">Student Full Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                               value="{{ old('name', $currentUser->name ?? '') }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Father Name <span class="text-danger">*</span></label>
                        <input type="text" name="father_name" class="form-control @error('father_name') is-invalid @enderror" 
                               value="{{ old('father_name', $currentUser->father_name ?? $admission->father_name ?? '') }}" 
                               placeholder="Enter Father Name" required>
                        @error('father_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">CNIC / B-Form Number</label>
                        <input type="text" class="form-control box-subtle text-theme-muted" 
                               value="{{ $studentCnic }}" readonly>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Gender <span class="text-danger">*</span></label>
                        <select name="gender" class="form-select @error('gender') is-invalid @enderror" required>
                            <option value="">Select Gender</option>
                            <option value="Male" {{ old('gender', $currentUser->gender ?? $admission->gender ?? '') == 'Male' ? 'selected' : '' }}>Male</option>
                            <option value="Female" {{ old('gender', $currentUser->gender ?? $admission->gender ?? '') == 'Female' ? 'selected' : '' }}>Female</option>
                            <option value="Other" {{ old('gender', $currentUser->gender ?? $admission->gender ?? '') == 'Other' ? 'selected' : '' }}>Other</option>
                        </select>
                        @error('gender')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Blood Group</label>
                        <select name="blood_group" class="form-select @error('blood_group') is-invalid @enderror">
                            <option value="">Select Blood Group</option>
                            @foreach(['A+', 'A-', 'B+', 'B-', 'O+', 'O-', 'AB+', 'AB-'] as $bg)
                                <option value="{{ $bg }}" {{ old('blood_group', $currentUser->blood_group ?? $admission->blood_group ?? '') == $bg ? 'selected' : '' }}>{{ $bg }}</option>
                            @endforeach
                        </select>
                        @error('blood_group')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Update Profile Picture</label>
                        <input type="file" name="picture" class="form-control @error('picture') is-invalid @enderror" accept="image/*">
                        @error('picture')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <hr class="my-4 border-theme">

                <!-- SECTION 2: Contact & Address Information -->
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h6 class="fw-bold text-theme-primary mb-0 text-uppercase letter-spacing-1">
                        <i class="fa-solid fa-address-book text-warning me-2"></i> Contact & Residential Info
                    </h6>
                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle fs-8">Step 2</span>
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-md-4">
                        <label class="form-label">Mobile Contact <span class="text-danger">*</span></label>
                        <input type="text" name="mobile_contact" class="form-control @error('mobile_contact') is-invalid @enderror" 
                               placeholder="03XXXXXXXXX" 
                               value="{{ old('mobile_contact', $currentUser->mobile_contact ?? $currentUser->phone ?? $admission->mobile_number ?? '') }}" required>
                        @error('mobile_contact')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">WhatsApp Contact</label>
                        <input type="text" name="whatsapp_contact" class="form-control @error('whatsapp_contact') is-invalid @enderror" 
                               placeholder="03XXXXXXXXX" 
                               value="{{ old('whatsapp_contact', $currentUser->whatsapp_contact ?? $admission->whatsapp_number ?? '') }}">
                        @error('whatsapp_contact')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Guardian Name</label>
                        <input type="text" name="guardian_name" class="form-control @error('guardian_name') is-invalid @enderror" 
                               placeholder="Guardian Full Name" 
                               value="{{ old('guardian_name', $currentUser->guardian_name ?? $admission->guardian_name ?? '') }}">
                        @error('guardian_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Guardian Contact Number</label>
                        <input type="text" name="guardian_contact" class="form-control @error('guardian_contact') is-invalid @enderror" 
                               placeholder="03XXXXXXXXX" 
                               value="{{ old('guardian_contact', $currentUser->guardian_contact ?? $admission->guardian_mobile ?? '') }}">
                        @error('guardian_contact')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Residential Address</label>
                        <input type="text" name="residential_address" class="form-control @error('residential_address') is-invalid @enderror" 
                               placeholder="Complete House Address & City Name" 
                               value="{{ old('residential_address', $studentAddress) }}">
                        @error('residential_address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <hr class="my-4 border-theme">

                <!-- SECTION 3: Admin Added Dynamic Courses & Batches Selection -->
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h6 class="fw-bold text-theme-primary mb-0 text-uppercase letter-spacing-1">
                        <i class="fa-solid fa-graduation-cap text-warning me-2"></i> Education & Admin Enrolled Courses
                    </h6>
                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle fs-8">Step 3</span>
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-md-4">
                        <label class="form-label">Last Qualification / Education</label>
                        <input type="text" name="last_qualification" class="form-control @error('last_qualification') is-invalid @enderror" 
                               placeholder="e.g. Matric / FSc / ICS / BS CS" 
                               value="{{ old('last_qualification', $currentUser->last_qualification ?? $currentUser->qualification ?? $admission->last_qualification ?? '') }}">
                        @error('last_qualification')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Dynamic Admin Added Courses Dropdown -->
                    <div class="col-md-4">
                        <label class="form-label">Select Course (Admin Sync) <span class="text-danger">*</span></label>
                        <select name="course_id" class="form-select @error('course_id') is-invalid @enderror" required>
                            <option value="">-- Choose Admin Added Course --</option>
                            @php
                                $selectedCourseId = old('course_id', $currentUser->course_id ?? $admission->course_id ?? '');
                            @endphp
                            @forelse($coursesList as $course)
                                @php
                                    $cId    = $course->id;
                                    $cTitle = $course->course_name ?? $course->title ?? $course->name ?? 'Course #'.$cId;
                                    $cCode  = $course->course_code ?? $course->code ?? '';
                                    $cFee   = isset($course->fee) ? ' - (Rs. '.number_format($course->fee).')' : '';
                                @endphp
                                <option value="{{ $cId }}" {{ $selectedCourseId == $cId ? 'selected' : '' }}>
                                    {{ $cCode ? '['.$cCode.'] ' : '' }}{{ $cTitle }}{{ $cFee }}
                                </option>
                            @empty
                                <option value="" disabled>No Admin Courses Found</option>
                            @endforelse
                        </select>
                        @error('course_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Dynamic Admin Added Batches Dropdown -->
                    <div class="col-md-4">
                        <label class="form-label">Select Batch (Admin Sync) <span class="text-danger">*</span></label>
                        <select name="batch_id" class="form-select @error('batch_id') is-invalid @enderror" required>
                            <option value="">-- Choose Admin Added Batch --</option>
                            @php
                                $selectedBatchId = old('batch_id', $currentUser->batch_id ?? $admission->batch_id ?? '');
                            @endphp
                            @forelse($batchesList as $batch)
                                @php
                                    $bId    = $batch->id;
                                    $bTitle = $batch->batch_name ?? $batch->title ?? $batch->name ?? 'Batch #'.$bId;
                                    $bCode  = $batch->batch_code ?? $batch->code ?? '';
                                @endphp
                                <option value="{{ $bId }}" {{ $selectedBatchId == $bId ? 'selected' : '' }}>
                                    {{ $bCode ? '['.$bCode.'] ' : '' }}{{ $bTitle }}
                                </option>
                            @empty
                                <option value="" disabled>No Admin Batches Found</option>
                            @endforelse
                        </select>
                        @error('batch_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <hr class="my-4 border-theme">

                <!-- SECTION 4: Account Security -->
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h6 class="fw-bold text-theme-primary mb-0 text-uppercase letter-spacing-1">
                        <i class="fa-solid fa-lock text-warning me-2"></i> Account Password (Optional)
                    </h6>
                    <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle fs-8">Optional</span>
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="form-label">New Password</label>
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Leave blank to keep current password">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Confirm New Password</label>
                        <input type="password" name="password_confirmation" class="form-control" placeholder="Re-enter new password">
                    </div>
                </div>

                <!-- Form Action Buttons -->
                <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top border-theme">
                    <a href="{{ route('student.dashboard') }}" class="btn btn-light px-4 fw-bold rounded-3 border">Cancel</a>
                    <button type="submit" class="btn btn-gold shadow-sm">
                        <i class="fa-solid fa-floppy-disk me-2"></i> Save Profile Details
                    </button>
                </div>
            </form>
        </div>

    </main>

    <!-- Framework Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- LocalStorage Theme Script -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const themeToggleBtn = document.getElementById('themeToggleBtn');
            const themeIcon = document.getElementById('themeIcon');
            const htmlElement = document.documentElement;

            const savedTheme = localStorage.getItem('student_portal_theme') || 'light';
            setTheme(savedTheme);

            themeToggleBtn.addEventListener('click', function () {
                const currentTheme = htmlElement.getAttribute('data-bs-theme');
                const newTheme = currentTheme === 'light' ? 'dark' : 'light';
                setTheme(newTheme);
            });

            function setTheme(theme) {
                htmlElement.setAttribute('data-bs-theme', theme);
                localStorage.setItem('student_portal_theme', theme);
                if (theme === 'dark') {
                    themeIcon.classList.remove('fa-moon');
                    themeIcon.classList.add('fa-sun');
                } else {
                    themeIcon.classList.remove('fa-sun');
                    themeIcon.classList.add('fa-moon');
                }
            }
        });
    </script>
</body>
</html>