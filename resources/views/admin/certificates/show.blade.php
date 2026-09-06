<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificate - {{ $certificate->certificate_no }}</title>
    
    <!-- Bootstrap 5 & FontAwesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Custom Certificate Print Stylesheet -->
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Cinzel:wght@600;700;800&family=Great+Vibes&family=Montserrat:wght@400;500;600;700&display=swap');

        @page {
            size: A4 landscape;
            margin: 0;
        }

        body {
            background-color: #f1f5f9;
            font-family: 'Montserrat', sans-serif;
            color: #1e293b;
            padding: 20px;
        }

        .cert-container {
            width: 297mm;
            height: 210mm;
            margin: 0 auto;
            background: #ffffff;
            padding: 16mm;
            position: relative;
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
            box-sizing: border-box;
        }

        .outer-border {
            border: 8px solid #0b2545;
            height: 100%;
            padding: 8px;
            position: relative;
        }

        .inner-border {
            border: 2px solid #d4af37;
            height: 100%;
            padding: 30px 50px;
            text-align: center;
            position: relative;
            background: radial-gradient(circle, #ffffff 60%, #faf8f2 100%);
        }

        .college-title {
            font-family: 'Cinzel', serif;
            font-weight: 800;
            color: #0b2545;
            letter-spacing: 4px;
            font-size: 2.5rem;
        }

        .cert-subheading {
            font-family: 'Cinzel', serif;
            color: #d4af37;
            font-weight: 700;
            letter-spacing: 6px;
            font-size: 1.1rem;
            text-transform: uppercase;
        }

        .student-name {
            font-family: 'Great Vibes', cursive;
            font-size: 3.5rem;
            color: #0b2545;
            border-bottom: 2px solid #d4af37;
            display: inline-block;
            padding: 0 40px 5px;
        }

        .course-title {
            font-family: 'Cinzel', serif;
            font-weight: 700;
            color: #0b2545;
            font-size: 1.6rem;
        }

        .watermark-seal {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            opacity: 0.03;
            width: 350px;
            pointer-events: none;
        }

        .official-seal-badge {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            border: 3px double #d4af37;
            background: #0b2545;
            color: #d4af37;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto;
            box-shadow: 0 4px 10px rgba(0,0,0,0.15);
        }

        @media print {
            body {
                background: none;
                padding: 0;
            }
            .no-print {
                display: none !important;
            }
            .cert-container {
                box-shadow: none;
                width: 100%;
                height: 100vh;
            }
        }
    </style>
</head>
<body>

<!-- Non-Printable Floating Action Bar -->
<div class="text-center mb-4 no-print">
    <button onclick="window.print()" class="btn btn-dark btn-lg fw-bold shadow-sm px-4">
        <i class="fa-solid fa-print text-warning me-2"></i> Print Official Certificate
    </button>
</div>

<!-- Printable Certificate Box -->
<div class="cert-container">
    <div class="outer-border">
        <div class="inner-border d-flex flex-column justify-content-between">
            
            <i class="fa-solid fa-graduation-cap watermark-seal"></i>

            <!-- Header Section -->
            <div>
                <div class="d-flex justify-content-center align-items-center gap-2 mb-2">
                    <i class="fa-solid fa-award text-warning fs-3"></i>
                    <h1 class="college-title mb-0">LOGIX COLLEGE</h1>
                    <i class="fa-solid fa-award text-warning fs-3"></i>
                </div>
                <div class="cert-subheading mb-3">Certificate of Completion</div>
                <p class="text-muted fst-italic mb-0">This is to officially certify that</p>
            </div>

            <!-- Recipient Section -->
            <div>
                <div class="student-name my-1">
                    {{ $certificate->admission->student_name }}
                </div>
                <p class="text-secondary small mb-1 mt-2">has successfully satisfied all requirements for the completion of</p>
                <div class="course-title mt-1 mb-2">
                    {{ $certificate->admission->course->course_name ?? 'Professional Development Program' }}
                </div>
                <p class="text-muted small mb-0">
                    Graduated with Grade <strong class="text-dark">{{ $certificate->grade }}</strong> | Reg No: <strong class="text-dark font-monospace">{{ $certificate->admission->registration_no }}</strong>
                </p>
            </div>

            <!-- Footer & Signatures -->
            <div class="row align-items-end pt-3">
                <div class="col-4 text-start">
                    <div class="small text-muted">
                        <div>Certificate ID: <strong class="text-dark font-monospace">#{{ $certificate->certificate_no }}</strong></div>
                        <div>Date Issued: <strong class="text-dark">{{ \Carbon\Carbon::parse($certificate->issue_date)->format('d M, Y') }}</strong></div>
                    </div>
                </div>

                <div class="col-4 text-center">
                    <div class="official-seal-badge">
                        <i class="fa-solid fa-shield-halved fs-2"></i>
                    </div>
                    <small class="text-uppercase fw-bold text-muted fs-8 tracking-wider d-block mt-1">Official Seal</small>
                </div>

                <div class="col-4 text-end">
                    <div class="d-flex justify-content-end gap-4">
                        <div class="text-center" style="width: 130px;">
                            <div class="border-bottom border-dark pb-1 mb-1 fw-bold small">Academic Director</div>
                            <span class="text-muted fs-8">Authorized Sign</span>
                        </div>
                        <div class="text-center" style="width: 130px;">
                            <div class="border-bottom border-dark pb-1 mb-1 fw-bold small">Principal</div>
                            <span class="text-muted fs-8">Executive Sign</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

</body>
</html>