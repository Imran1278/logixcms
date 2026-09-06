@extends('layouts.app')

@section('page_title', 'Course Finder Builder')

@push('styles')
<style>
    :root {
        --admin-navy: #0A2D5A;
        --admin-navy-dark: #051329;
        --admin-gold: #CFAE4E;
        --admin-teal: #10B981;
    }

    .finder-card {
        background: #ffffff;
        border: 1px solid #E2E8F0;
        border-radius: 16px;
        box-shadow: 0 10px 30px rgba(10, 45, 90, 0.04);
    }

    .finder-header-pill {
        background: linear-gradient(135deg, var(--admin-navy) 0%, var(--admin-navy-dark) 100%);
        color: #ffffff;
        border-top-left-radius: 16px;
        border-top-right-radius: 16px;
        padding: 18px 24px;
        font-weight: 700;
        border-bottom: 2px solid var(--admin-gold);
    }

    .option-row-box {
        background-color: #F8FAFC;
        border: 1px solid #E2E8F0;
        border-radius: 12px;
        padding: 12px;
        transition: all 0.25s ease;
    }

    .option-row-box:hover {
        border-color: rgba(207, 174, 78, 0.5);
        background-color: #FFFFFF;
        box-shadow: 0 4px 12px rgba(10, 45, 90, 0.03);
    }

    .step-number-badge {
        width: 36px;
        height: 36px;
        background: var(--admin-navy);
        color: var(--admin-gold);
        border: 1px solid rgba(207, 174, 78, 0.3);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        font-size: 0.85rem;
    }

    .btn-navy-submit {
        background: linear-gradient(135deg, var(--admin-navy) 0%, var(--admin-navy-dark) 100%);
        color: #ffffff;
        font-weight: 700;
        padding: 12px 28px;
        border-radius: 50px;
        border: 1px solid var(--admin-gold);
        transition: all 0.3s ease;
    }

    .btn-navy-submit:hover {
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

    <!-- Top Header Banner -->
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3 bg-white p-4 rounded-4 shadow-sm border border-slate-100">
        <div class="d-flex align-items-center gap-3">
            <div class="rounded-3 p-3 text-white shadow-sm" style="background: linear-gradient(135deg, var(--admin-navy) 0%, var(--admin-navy-dark) 100%); border: 1px solid rgba(207, 174, 78, 0.3);">
                <i class="fa-solid fa-route fs-4" style="color: var(--admin-gold);"></i>
            </div>
            <div>
                <h4 class="fw-bold text-dark mb-1">Course Finder Engine Builder</h4>
                <p class="text-muted small mb-0">Configure dynamic quiz steps, questions, and choice fields for the student recommendation portal.</p>
            </div>
        </div>
        <div class="badge bg-light text-dark border px-3 py-2.5 rounded-pill d-flex align-items-center gap-2 shadow-xs">
            <span class="rounded-circle" style="width: 9px; height: 9px; background-color: var(--admin-teal);"></span>
            <span class="fw-bold text-secondary">Active Steps Configured: <strong class="text-dark">{{ count($questions) }}</strong></span>
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
        
        <!-- Left Column: Create Question & Options Form -->
        <div class="col-lg-7">
            <div class="finder-card overflow-hidden">
                <div class="finder-header-pill d-flex justify-content-between align-items-center">
                    <span class="d-flex align-items-center gap-2">
                        <i class="fa-solid fa-plus-circle" style="color: var(--admin-gold);"></i> Create Step Question
                    </span>
                    <span class="badge px-3 py-1.5 rounded-pill fw-bold" style="background-color: rgba(207, 174, 78, 0.2); color: var(--admin-gold); border: 1px solid rgba(207, 174, 78, 0.4);">Step Config</span>
                </div>
                <div class="card-body p-4 p-md-4">
                    <form action="{{ route('admin.finder.store') }}" method="POST">
                        @csrf
                        
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label fw-bold text-dark small mb-1">Question Title <span class="text-danger">*</span></label>
                                <div class="input-group shadow-xs rounded-3 overflow-hidden">
                                    <span class="input-group-text bg-light text-muted border-end-0"><i class="fa-solid fa-heading"></i></span>
                                    <input type="text" name="question" id="questionInput" class="form-control border-start-0 ps-0" placeholder="e.g. What is your highest qualification?" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark small mb-1">Database Field Name <span class="text-danger">*</span></label>
                                <div class="input-group shadow-xs rounded-3 overflow-hidden">
                                    <span class="input-group-text bg-light text-muted border-end-0"><i class="fa-solid fa-code"></i></span>
                                    <input type="text" name="field_name" id="fieldNameInput" class="form-control border-start-0 ps-0" placeholder="e.g. education_level" required>
                                </div>
                                <div class="form-text fs-8 text-muted mt-1">Unique variable name stored in database.</div>
                            </div>

                            <div class="col-md-3 col-6">
                                <label class="form-label fw-bold text-dark small mb-1">Step Order <span class="text-danger">*</span></label>
                                <input type="number" name="step_number" class="form-control text-center fw-bold shadow-xs" value="{{ count($questions) + 1 }}" min="1" required>
                            </div>

                            <div class="col-md-3 col-6">
                                <label class="form-label fw-bold text-dark small mb-1">Icon Class</label>
                                <input type="text" name="icon" id="fieldIconInput" class="form-control shadow-xs" placeholder="fa-graduation-cap">
                            </div>
                        </div>

                        <hr class="my-4 text-muted opacity-25">

                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <h6 class="fw-bold text-dark mb-0">Selectable Choices / Options</h6>
                                <p class="text-muted small mb-0">Provide options for students to pick (minimum 2 options).</p>
                            </div>
                            <button type="button" class="btn btn-sm rounded-pill px-3 fw-bold text-dark shadow-xs" style="background-color: var(--admin-gold); border: 1px solid var(--admin-gold);" id="addMoreOptionBtn">
                                <i class="fa-solid fa-plus me-1"></i> Add Choice
                            </button>
                        </div>

                        <div id="optionsWrapper" class="d-flex flex-column gap-2">
                            
                            <div class="row g-2 align-items-center option-row-box">
                                <div class="col-md-4">
                                    <input type="text" name="options[0][label]" class="form-control form-control-sm opt-label-input shadow-none" placeholder="Label (e.g. Matric / SSC)" required>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" name="options[0][value]" class="form-control form-control-sm opt-value-input shadow-none" placeholder="Value (e.g. matric)" required>
                                </div>
                                <div class="col-md-3">
                                    <input type="text" name="options[0][icon]" class="form-control form-control-sm opt-icon-input shadow-none" placeholder="Icon (e.g. fa-school)">
                                </div>
                                <div class="col-md-1 text-end">
                                    <button type="button" class="btn btn-sm btn-outline-danger w-100 border-0 remove-opt-btn" disabled>
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="row g-2 align-items-center option-row-box">
                                <div class="col-md-4">
                                    <input type="text" name="options[1][label]" class="form-control form-control-sm opt-label-input shadow-none" placeholder="Label (e.g. Intermediate)" required>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" name="options[1][value]" class="form-control form-control-sm opt-value-input shadow-none" placeholder="Value (e.g. intermediate)" required>
                                </div>
                                <div class="col-md-3">
                                    <input type="text" name="options[1][icon]" class="form-control form-control-sm opt-icon-input shadow-none" placeholder="Icon (e.g. fa-building-columns)">
                                </div>
                                <div class="col-md-1 text-end">
                                    <button type="button" class="btn btn-sm btn-outline-danger w-100 border-0 remove-opt-btn" disabled>
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </div>
                            </div>

                        </div>

                        <div class="mt-4 pt-3 text-end border-top">
                            <button type="submit" class="btn btn-navy-submit">
                                <i class="fa-solid fa-floppy-disk me-1"></i> Save Step & Options
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Right Column: Configured Steps List -->
        <div class="col-lg-5">
            <div class="finder-card overflow-hidden h-100">
                <div class="finder-header-pill d-flex justify-content-between align-items-center">
                    <span class="d-flex align-items-center gap-2">
                        <i class="fa-solid fa-layer-group" style="color: var(--admin-teal);"></i> Configured Steps
                    </span>
                    <span class="badge bg-white text-dark fw-bold px-3 py-1 rounded-pill">{{ count($questions) }} Steps</span>
                </div>
                <div class="card-body p-3 bg-light" style="max-height: 680px; overflow-y: auto;">
                    
                    @forelse($questions as $q)
                        <div class="card border-0 shadow-sm mb-3 rounded-4 overflow-hidden border-start border-4" style="border-left-color: var(--admin-navy) !important;">
                            <div class="card-body p-3">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="step-number-badge">
                                            {{ $q->step_number }}
                                        </div>
                                        <h6 class="fw-bold mb-0 text-dark">{{ $q->question }}</h6>
                                    </div>
                                    
                                    <form action="{{ route('admin.finder.destroy', $q->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this step?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger rounded-circle p-1" title="Delete Step" style="width: 30px; height: 30px;">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </form>
                                </div>

                                <div class="d-flex align-items-center gap-2 mb-2 text-muted small ps-5">
                                    <span>Field: <code class="bg-light px-2 py-0.5 rounded text-dark fw-bold border">{{ $q->field_name }}</code></span>
                                    <span>•</span>
                                    <span>Icon: <i class="fa-solid {{ $q->icon ?? 'fa-circle-question' }}" style="color: var(--admin-gold);"></i></span>
                                </div>

                                <div class="pt-2 border-top ms-5">
                                    <small class="text-muted d-block mb-1 fs-8 fw-bold text-uppercase tracking-wider">Options / Choices:</small>
                                    <div class="d-flex flex-wrap gap-1.5">
                                        @foreach($q->options as $opt)
                                            <span class="badge bg-white text-dark border fw-semibold rounded-pill px-2.5 py-1 shadow-2xs d-inline-flex align-items-center gap-1">
                                                @if($opt->icon)
                                                    <i class="fa-solid {{ $opt->icon }}" style="color: var(--admin-gold);"></i>
                                                @endif
                                                {{ $opt->option_label }}
                                            </span>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-5">
                            <i class="fa-solid fa-clipboard-question text-muted display-6 mb-3 opacity-50"></i>
                            <h6 class="fw-bold text-dark mb-1">No Quiz Steps Configured</h6>
                            <p class="text-muted small mb-0">Use the form on the left to add your first question step.</p>
                        </div>
                    @endforelse

                </div>
            </div>
        </div>

    </div>
</div>

<script>
    let optionIndex = 2;

    const fieldIconMap = {
        'education': 'fa-graduation-cap',
        'qualification': 'fa-user-graduate',
        'gender': 'fa-venus-mars',
        'age': 'fa-calendar-days',
        'interest': 'fa-lightbulb',
        'field': 'fa-laptop-code',
        'experience': 'fa-briefcase',
        'goal': 'fa-bullseye',
        'budget': 'fa-wallet',
        'duration': 'fa-clock',
        'time': 'fa-clock',
        'mode': 'fa-house-laptop',
        'city': 'fa-location-dot',
        'location': 'fa-map-pin',
        'skill': 'fa-wand-magic-sparkles',
        'level': 'fa-chart-line',
        'career': 'fa-rocket'
    };

    const optionIconMap = {
        'matric': 'fa-school',
        'ssc': 'fa-school',
        'inter': 'fa-building-columns',
        'intermediate': 'fa-building-columns',
        'hssc': 'fa-building-columns',
        'bachelor': 'fa-user-graduate',
        'bs': 'fa-user-graduate',
        'graduation': 'fa-user-graduate',
        'master': 'fa-award',
        'ms': 'fa-award',
        'phd': 'fa-book-bookmark',
        'male': 'fa-mars',
        'female': 'fa-venus',
        'other': 'fa-genderless',
        'web': 'fa-code',
        'developer': 'fa-laptop-code',
        'design': 'fa-palette',
        'graphic': 'fa-pen-nib',
        'app': 'fa-mobile-screen-button',
        'flutter': 'fa-mobile-button',
        'python': 'fa-brands fa-python',
        'ai': 'fa-robot',
        'data': 'fa-database',
        'cyber': 'fa-shield-halved',
        'marketing': 'fa-bullhorn',
        'seo': 'fa-magnifying-glass-chart',
        'video': 'fa-video',
        'editing': 'fa-scissors',
        'beginner': 'fa-seedling',
        'basic': 'fa-seedling',
        'intermediate_level': 'fa-chart-line',
        'advance': 'fa-rocket',
        'advanced': 'fa-rocket',
        'expert': 'fa-crown',
        'job': 'fa-briefcase',
        'freelance': 'fa-laptop',
        'business': 'fa-chart-pie',
        'certificate': 'fa-certificate',
        'degree': 'fa-graduation-cap'
    };

    document.getElementById('fieldNameInput').addEventListener('input', function() {
        const fieldVal = this.value.toLowerCase().trim();
        const iconInput = document.getElementById('fieldIconInput');

        for (const [key, iconClass] of Object.entries(fieldIconMap)) {
            if (fieldVal.includes(key)) {
                iconInput.value = iconClass;
                return;
            }
        }
    });

    function attachOptionEvents(row) {
        const labelInput = row.querySelector('.opt-label-input');
        const valueInput = row.querySelector('.opt-value-input');
        const iconInput = row.querySelector('.opt-icon-input');

        labelInput.addEventListener('input', function() {
            const val = this.value.toLowerCase().trim();
            const slug = val.replace(/[^a-z0-9]/g, '_').replace(/_+/g, '_');
            valueInput.value = slug;

            let matchedIcon = '';
            for (const [key, iconClass] of Object.entries(optionIconMap)) {
                if (val.includes(key)) {
                    matchedIcon = iconClass;
                    break;
                }
            }

            if (matchedIcon) {
                iconInput.value = matchedIcon;
            } else if (!iconInput.value) {
                iconInput.value = 'fa-circle-dot';
            }
        });
    }

    document.querySelectorAll('.option-row-box').forEach(attachOptionEvents);

    document.getElementById('addMoreOptionBtn').addEventListener('click', function() {
        const wrapper = document.getElementById('optionsWrapper');
        const newRowHTML = `
            <div class="row g-2 align-items-center option-row-box fade-in">
                <div class="col-md-4">
                    <input type="text" name="options[${optionIndex}][label]" class="form-control form-control-sm opt-label-input shadow-none" placeholder="Option Label" required>
                </div>
                <div class="col-md-4">
                    <input type="text" name="options[${optionIndex}][value]" class="form-control form-control-sm opt-value-input shadow-none" placeholder="Option Value" required>
                </div>
                <div class="col-md-3">
                    <input type="text" name="options[${optionIndex}][icon]" class="form-control form-control-sm opt-icon-input shadow-none" placeholder="Icon Class">
                </div>
                <div class="col-md-1 text-end">
                    <button type="button" class="btn btn-sm btn-outline-danger w-100 border-0 remove-opt-btn" onclick="removeRow(this)">
                        <i class="fa-solid fa-trash-can"></i>
                    </button>
                </div>
            </div>
        `;
        wrapper.insertAdjacentHTML('beforeend', newRowHTML);

        const addedRow = wrapper.lastElementChild;
        attachOptionEvents(addedRow);

        optionIndex++;
        checkRemoveButtons();
    });

    function removeRow(btn) {
        btn.closest('.option-row-box').remove();
        checkRemoveButtons();
    }

    function checkRemoveButtons() {
        const rows = document.querySelectorAll('.option-row-box');
        const removeButtons = document.querySelectorAll('.remove-opt-btn');
        
        removeButtons.forEach(btn => {
            btn.disabled = rows.length <= 2;
        });
    }
</script>
@endsection