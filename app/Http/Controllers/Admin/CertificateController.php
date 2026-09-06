<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admission;
use App\Models\Certificate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Exception;

class CertificateController extends Controller
{
    /**
     * Display a listing of generated certificates and admissions.
     */
    public function index()
    {
        $certificates = Certificate::with(['admission.course', 'admission.batch'])
            ->latest('id')
            ->paginate(15);

        $admissions = Admission::with('course:id,course_name')
            ->whereDoesntHave('certificate')
            ->select('id', 'course_id', 'student_name', 'registration_no')
            ->get();

        return view('admin.certificates.index', compact('certificates', 'admissions'));
    }

    /**
     * Store a newly created certificate in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'admission_id' => 'required|exists:admissions,id|unique:certificates,admission_id',
            'grade'        => 'required|string|max:10',
            'issue_date'   => 'required|date',
        ]);

        try {
            $certificate = DB::transaction(function () use ($validated) {
                $latest = Certificate::latest('id')->first();
                $nextId = $latest ? ($latest->id + 1) : 1;
                $certNo = 'CERT-' . date('Y') . '-' . str_pad($nextId, 4, '0', STR_PAD_LEFT);

                return Certificate::create([
                    'certificate_no' => $certNo,
                    'admission_id'   => $validated['admission_id'],
                    'grade'          => strtoupper($validated['grade']),
                    'issue_date'     => $validated['issue_date'],
                    'issued_by'      => Auth::user()->name ?? 'Principal',
                ]);
            });

            return redirect()
                ->route('certificates.show', $certificate->id)
                ->with('success', 'Certificate generated successfully!');
                
        } catch (Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Failed to generate certificate: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified certificate details.
     */
    public function show($id)
    {
        $certificate = Certificate::with(['admission.course', 'admission.batch'])->findOrFail($id);
        
        return view('admin.certificates.show', compact('certificate'));
    }
}