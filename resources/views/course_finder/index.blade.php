@php
    $questions = $questions ?? \App\Models\FinderQuestion::with('options')->orderBy('step_number', 'asc')->get();
    $totalSteps = count($questions);
@endphp

<!-- Enterprise Course Finder Modal -->
<div class="modal fade" id="courseFinderModal" tabindex="-1" aria-labelledby="courseFinderModalLabel" aria-hidden="true" style="z-index: 1060;">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-2xl rounded-4 overflow-hidden finder-glass-modal">
            
            <!-- Header Section -->
            <div class="modal-header crm-navy-header text-white p-4 border-0 position-relative">
                <div class="d-flex align-items-center gap-3">
                    <div class="icon-shape bg-gold-gradient text-navy rounded-3 d-flex align-items-center justify-content-center shadow-md">
                        <i class="fa-solid fa-compass fs-4"></i>
                    </div>
                    <div>
                        <h5 class="modal-title fw-bold mb-0 text-white tracking-wide" id="courseFinderModalLabel">Smart Career Path Finder</h5>
                        <p class="text-slate-light small mb-0">Select your preferences to discover customized academic roadmap</p>
                    </div>
                </div>
                <button type="button" class="btn-close btn-close-white ms-auto me-1 opacity-75 hover-opacity-100 shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body p-4 p-md-5 bg-slate-50">
                @if($totalSteps > 0)
                    
                    <!-- Dynamic Progress Bar Section -->
                    <div class="mb-4 p-3 bg-white rounded-3 border border-slate-200 shadow-xs" id="modalProgressWrapper">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="fw-bold text-uppercase text-secondary extra-small tracking-wider">
                                Step <span id="currentStepNum" class="text-navy fw-black">1</span> of {{ $totalSteps }}
                            </span>
                            <span class="badge bg-navy-subtle text-navy fw-bold px-3 py-1 rounded-pill" id="progressPercent">
                                0% Completed
                            </span>
                        </div>
                        <div class="progress rounded-pill bg-slate-100" style="height: 8px;">
                            <div class="progress-bar bg-gold-gradient rounded-pill transition-all" id="courseFinderProgressBar" role="progressbar" style="width: 0%;"></div>
                        </div>
                    </div>

                    <!-- Step-by-Step Form -->
                    <form id="courseFinderForm" action="{{ route('course.recommend') }}" method="POST">
                        @csrf

                        @foreach($questions as $index => $q)
                            <div class="step-card fade-in" id="modalStep{{ $index + 1 }}" style="{{ $index > 0 ? 'display: none;' : '' }}">
                                
                                <div class="mb-4">
                                    <h5 class="fw-bold text-navy mb-1 d-flex align-items-center gap-2">
                                        <i class="fa-solid {{ $q->icon ?? 'fa-circle-question' }} text-gold"></i>
                                        {{ $q->question }}
                                    </h5>
                                    <p class="text-muted small mb-0">Choose the best answer to refine your path recommendations.</p>
                                </div>

                                <div class="row g-3">
                                    @foreach($q->options as $opt)
                                        <div class="col-12 col-md-4 option-card-wrapper">
                                            <input type="radio" name="{{ $q->field_name }}" id="opt_{{ $opt->id }}" value="{{ $opt->option_value }}" class="btn-check opt-radio-input" required>
                                            
                                            <label for="opt_{{ $opt->id }}" class="card h-100 border-0 shadow-xs finder-option-card p-3 text-center cursor-pointer position-relative">
                                                <div class="card-body d-flex flex-column align-items-center justify-content-center p-2">
                                                    @if($opt->icon)
                                                        <div class="option-icon-shape mb-3 rounded-circle d-flex align-items-center justify-content-center bg-slate-100 text-navy">
                                                            <i class="fa-solid {{ $opt->icon }} fs-4"></i>
                                                        </div>
                                                    @endif
                                                    <span class="fw-bold text-navy fs-6">{{ $opt->option_label }}</span>
                                                </div>
                                                <div class="check-badge position-absolute top-0 end-0 m-2 d-none">
                                                    <i class="fa-solid fa-circle-check text-gold fs-5"></i>
                                                </div>
                                            </label>
                                        </div>
                                    @endforeach
                                </div>

                                <!-- Step Validation Notice -->
                                <div class="alert alert-danger border-0 shadow-xs d-none mt-3 mb-0 py-2 small d-flex align-items-center gap-2 rounded-3" id="alertStep{{ $index + 1 }}">
                                    <i class="fa-solid fa-circle-exclamation"></i>
                                    <span>Please select an option to continue to the next step.</span>
                                </div>

                                <!-- Controls -->
                                <div class="mt-4 pt-3 border-top border-slate-200 d-flex justify-content-between align-items-center">
                                    @if($index > 0)
                                        <button type="button" class="btn btn-outline-navy px-4 rounded-pill fw-semibold" onclick="prevModalStep({{ $index + 1 }}, {{ $totalSteps }})">
                                            <i class="fa-solid fa-arrow-left me-1"></i> Back
                                        </button>
                                    @else
                                        <div></div>
                                    @endif

                                    @if($index + 1 < $totalSteps)
                                        <button type="button" class="btn btn-navy px-4 rounded-pill fw-bold ms-auto" onclick="nextModalStep({{ $index + 1 }}, {{ $totalSteps }})">
                                            Continue <i class="fa-solid fa-arrow-right ms-1"></i>
                                        </button>
                                    @else
                                        <button type="submit" class="btn btn-gold-solid px-4 rounded-pill fw-bold ms-auto" id="modalSubmitBtn">
                                            <span id="btnText"><i class="fa-solid fa-wand-magic-sparkles me-1"></i> Generate Recommendations</span>
                                            <span id="btnSpinner" class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                        </button>
                                    @endif
                                </div>
                            </div>
                        @endforeach

                    </form>

                    <!-- Recommendations Container -->
                    <div id="modalResultsContainer" class="d-none fade-in">
                        <div class="alert alert-navy-gold border-0 rounded-3 p-3 mb-4 d-flex align-items-center gap-3 shadow-xs">
                            <div class="icon-shape bg-gold-gradient text-navy rounded-circle flex-shrink-0 d-flex align-items-center justify-content-center" style="width:40px; height:40px;">
                                <i class="fa-solid fa-circle-check fs-4"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold text-navy mb-0">Recommended Career Tracks</h6>
                                <p class="small text-muted mb-0">Here are the best matching paths based on your inputs:</p>
                            </div>
                        </div>

                        <div id="modalRecommendationsList" class="d-flex flex-column gap-3"></div>

                        <div class="text-center mt-4 pt-3 border-top border-slate-200">
                            <button type="button" id="modalResetBtn" class="btn btn-outline-navy rounded-pill px-4 fw-bold">
                                <i class="fa-solid fa-rotate-left me-2"></i> Retake Assessment
                            </button>
                        </div>
                    </div>

                @else
                    <div class="text-center py-5">
                        <div class="mb-3 text-muted">
                            <i class="fa-solid fa-folder-open display-4 opacity-50"></i>
                        </div>
                        <h6 class="fw-bold text-navy">No Recommendation Questions Found</h6>
                        <p class="text-muted small mb-0">Please configure the questions in your administration dashboard.</p>
                    </div>
                @endif
            </div>

        </div>
    </div>
</div>

<style>
    :root {
        --navy-dark: #0b1623;
        --navy-light: #162a45;
        --gold-primary: #d4af37;
        --gold-gradient: linear-gradient(135deg, #f0d879 0%, #c49a21 100%);
        --slate-bg: #f8fafc;
        --slate-border: #e2e8f0;
    }

    .extra-small { font-size: 0.75rem; }
    .text-navy { color: var(--navy-dark) !important; }
    .text-gold { color: var(--gold-primary) !important; }
    .text-slate-light { color: #cbd5e1 !important; }
    .bg-slate-50 { background-color: var(--slate-bg) !important; }
    .bg-slate-100 { background-color: #f1f5f9 !important; }
    .border-slate-200 { border-color: var(--slate-border) !important; }
    .bg-gold-gradient { background: var(--gold-gradient) !important; }
    .bg-navy-subtle { background-color: rgba(11, 22, 35, 0.08) !important; }

    .crm-navy-header {
        background: linear-gradient(135deg, #0b1623 0%, #050d17 100%);
    }

    .icon-shape {
        width: 48px;
        height: 48px;
        flex-shrink: 0;
    }

    /* Primary & Secondary Action Styles */
    .btn-navy {
        background-color: var(--navy-dark);
        color: #ffffff;
        border: none;
        transition: all 0.25s ease;
    }
    .btn-navy:hover {
        background-color: var(--navy-light);
        color: #ffffff;
        box-shadow: 0 4px 12px rgba(11, 22, 35, 0.2);
    }

    .btn-outline-navy {
        border: 1px solid var(--navy-dark);
        color: var(--navy-dark);
        background: transparent;
        transition: all 0.25s ease;
    }
    .btn-outline-navy:hover {
        background-color: var(--navy-dark);
        color: #ffffff;
    }

    .btn-gold-solid {
        background: var(--gold-gradient);
        color: #ffffff !important;
        border: none;
        transition: all 0.25s ease;
        box-shadow: 0 4px 12px rgba(196, 154, 33, 0.25);
    }
    .btn-gold-solid:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 18px rgba(196, 154, 33, 0.35);
    }

    /* Interactive Option Cards */
    .finder-option-card {
        border: 2px solid var(--slate-border) !important;
        background-color: #ffffff;
        border-radius: 12px;
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .finder-option-card:hover {
        transform: translateY(-3px);
        border-color: #cbd5e1 !important;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.05) !important;
    }

    .option-icon-shape {
        width: 52px;
        height: 52px;
        transition: all 0.25s ease;
    }

    .cursor-pointer { cursor: pointer; }

    /* Radio Inputs Checked Visual State */
    .btn-check:checked + .finder-option-card {
        border-color: var(--gold-primary) !important;
        background-color: #fffdf5 !important;
        box-shadow: 0 8px 18px rgba(212, 175, 55, 0.15) !important;
    }
    .btn-check:checked + .finder-option-card .option-icon-shape {
        background: var(--gold-gradient) !important;
        color: #ffffff !important;
        box-shadow: 0 4px 10px rgba(196, 154, 33, 0.3);
    }
    .btn-check:checked + .finder-option-card .check-badge {
        display: block !important;
    }

    .alert-navy-gold {
        background-color: #ffffff;
        border-left: 4px solid var(--gold-primary) !important;
    }

    .fade-in {
        animation: fadeIn 0.3s ease-in-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(6px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .transition-all {
        transition: all 0.3s ease;
    }
</style>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        updateProgressBar(1, {{ $totalSteps }});

        const form = document.getElementById('courseFinderForm');
        const submitBtn = document.getElementById('modalSubmitBtn');
        const btnText = document.getElementById('btnText');
        const btnSpinner = document.getElementById('btnSpinner');
        const progressWrapper = document.getElementById('modalProgressWrapper');
        const resultsContainer = document.getElementById('modalResultsContainer');
        const recommendationsList = document.getElementById('modalRecommendationsList');
        const resetBtn = document.getElementById('modalResetBtn');

        if (form) {
            form.addEventListener('submit', function(e) {
                e.preventDefault();

                const currentCard = document.getElementById(`modalStep{{ $totalSteps }}`);
                const alertBox = document.getElementById(`alertStep{{ $totalSteps }}`);
                const inputs = currentCard.querySelectorAll('input[type="radio"]');
                let selected = false;
                
                inputs.forEach(i => { if(i.checked) selected = true; });

                if (!selected) {
                    if (alertBox) alertBox.classList.remove('d-none');
                    return;
                }

                submitBtn.disabled = true;
                if (btnText) btnText.classList.add('d-none');
                if (btnSpinner) btnSpinner.classList.remove('d-none');

                const formData = new FormData(form);

                fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    submitBtn.disabled = false;
                    if (btnText) btnText.classList.remove('d-none');
                    if (btnSpinner) btnSpinner.classList.add('d-none');

                    if (data.status === 'success' && data.data && data.data.length > 0) {
                        recommendationsList.innerHTML = '';

                        data.data.forEach(item => {
                            const cardHTML = `
                                <div class="card border-0 shadow-xs rounded-3 overflow-hidden">
                                    <div class="card-body p-4">
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <h5 class="fw-bold text-navy mb-0">${item.title}</h5>
                                            <span class="badge bg-navy-subtle text-navy border border-slate-200 rounded-pill px-3 py-1">
                                                <i class="fa-solid fa-clock text-gold me-1"></i>${item.duration}
                                            </span>
                                        </div>
                                        <p class="text-navy fw-semibold mb-2 small">
                                            <i class="fa-solid fa-briefcase text-gold me-2"></i>Target Career: <span class="text-muted">${item.career}</span>
                                        </p>
                                        <div class="p-3 bg-slate-100 rounded-3 text-muted small border-start border-4 border-warning">
                                            <i class="fa-solid fa-lightbulb text-gold me-2"></i><strong>Why recommended:</strong> ${item.reason}
                                        </div>
                                    </div>
                                </div>
                            `;
                            recommendationsList.innerHTML += cardHTML;
                        });

                        form.classList.add('d-none');
                        if (progressWrapper) progressWrapper.classList.add('d-none');
                        resultsContainer.classList.remove('d-none');
                    } else {
                        alert(data.message || 'No recommendations returned. Please try again.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    submitBtn.disabled = false;
                    if (btnText) btnText.classList.remove('d-none');
                    if (btnSpinner) btnSpinner.classList.add('d-none');
                    alert('An error occurred while generating recommendations. Please re-check your connection.');
                });
            });

            if (resetBtn) {
                resetBtn.addEventListener('click', function() {
                    form.reset();
                    resultsContainer.classList.add('d-none');
                    form.classList.remove('d-none');
                    if (progressWrapper) progressWrapper.classList.remove('d-none');

                    for (let i = 1; i <= {{ $totalSteps }}; i++) {
                        const stepAlert = document.getElementById(`alertStep${i}`);
                        if (stepAlert) stepAlert.classList.add('d-none');
                    }

                    for (let i = 1; i <= {{ $totalSteps }}; i++) {
                        const stepCard = document.getElementById(`modalStep${i}`);
                        if (stepCard) {
                            stepCard.style.display = (i === 1) ? 'block' : 'none';
                        }
                    }
                    updateProgressBar(1, {{ $totalSteps }});
                });
            }
        }
    });

    function updateProgressBar(current, total) {
        if (total <= 0) return;
        const percentage = Math.round(((current - 1) / total) * 100);
        const progressBar = document.getElementById('courseFinderProgressBar');
        const progressPercent = document.getElementById('progressPercent');
        const currentStepNum = document.getElementById('currentStepNum');

        if (progressBar) progressBar.style.width = `${percentage}%`;
        if (progressPercent) progressPercent.innerText = `${percentage}% Completed`;
        if (currentStepNum) currentStepNum.innerText = current;
    }

    function nextModalStep(current, total) {
        const currentCard = document.getElementById(`modalStep${current}`);
        const alertBox = document.getElementById(`alertStep${current}`);
        const inputs = currentCard.querySelectorAll('input[type="radio"]');
        let selected = false;
        
        inputs.forEach(i => { if(i.checked) selected = true; });

        if (!selected) {
            if (alertBox) alertBox.classList.remove('d-none');
            return;
        }
        
        if (alertBox) alertBox.classList.add('d-none');

        currentCard.style.display = 'none';
        const nextCard = document.getElementById(`modalStep${current + 1}`);
        if (nextCard) nextCard.style.display = 'block';
        
        updateProgressBar(current + 1, total);
    }

    function prevModalStep(current, total) {
        const currentCard = document.getElementById(`modalStep${current}`);
        const prevCard = document.getElementById(`modalStep${current - 1}`);

        if (currentCard) currentCard.style.display = 'none';
        if (prevCard) prevCard.style.display = 'block';
        
        updateProgressBar(current - 1, total);
    }
</script>