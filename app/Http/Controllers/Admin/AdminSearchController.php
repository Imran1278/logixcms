<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Inquiry;
use App\Models\Fee;
use App\Models\Admission;
use App\Models\Attendance;
use Illuminate\Http\Request;

class AdminSearchController extends Controller
{
    // Search Student Directory by CNIC
    public function searchStudent(Request $request)
    {
        $cnic = $request->get('cnic');
        $student = null;

        if ($cnic) {
            $student = User::where('role', 'student')->where('cnic', $cnic)->first();
        }

        return view('admin.students.index', compact('student', 'cnic'));
    }

    // Search Student Inquiries by CNIC
    public function searchInquiries(Request $request)
    {
        $cnic = $request->get('cnic');
        $inquiries = collect();

        if ($cnic) {
            $inquiries = Inquiry::where('cnic', $cnic)->latest()->get();
        }

        return view('admin.inquiries.index', compact('inquiries', 'cnic'));
    }

    // Search Student Fees by CNIC
    public function searchFees(Request $request)
    {
        $cnic = $request->get('cnic');
        $admissions = collect();
        $fees = collect();
        $student = null;

        if ($cnic) {
            $student = User::where('cnic', $cnic)->first();
            if ($student) {
                $fees = Fee::where('user_id', $student->id)->get();
                $admissions = Admission::with(['course', 'batch', 'student'])
                                        ->where('user_id', $student->id)
                                        ->get();
            }
        } else {
            // Agar CNIC filter nahi laga toh saari active admissions load ho jayengi
            $admissions = Admission::with(['course', 'batch', 'student'])->latest()->get();
        }

        return view('admin.fees.index', compact('admissions', 'fees', 'student', 'cnic'));
    }

    // Search Student Attendance Calendar by CNIC
    public function searchAttendance(Request $request)
    {
        $cnic = $request->get('cnic');
        $attendances = collect();
        $student = null;

        if ($cnic) {
            $student = User::where('cnic', $cnic)->first();
            if ($student) {
                $attendances = Attendance::where('user_id', $student->id)->get();
            }
        }

        return view('admin.attendance.index', compact('attendances', 'student', 'cnic'));
    }
}