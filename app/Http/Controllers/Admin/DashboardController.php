<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admission;
use App\Models\Course;
use App\Models\Batch;
use App\Models\Inquiry;
use App\Models\FeeCollection;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display admin metrics, system analytical counts, and recent transactions.
     */
    public function index()
    {
        // 1. Core Analytical Statistics
        $totalCourses    = Course::where('status', 1)->count();
        $totalBatches    = Batch::count();
        $totalAdmissions = Admission::count();
        $totalInquiries  = Inquiry::count();

        // 2. Financial Metrics (Direct Database Aggregation)
        $totalCollectedFee = FeeCollection::sum('amount_paid');
        
        $totalAgreedFee = Admission::select(
            DB::raw('SUM(total_agreed_fee - discount_amount) as total_net_agreed')
        )->value('total_net_agreed') ?? 0;

        $totalPendingFee = max(0, $totalAgreedFee - $totalCollectedFee);

        // 3. Recent Logs & Feeds
        $recentInquiries = Inquiry::latest('id')
            ->take(5)
            ->get();

        $recentPayments = FeeCollection::with(['admission.course'])
            ->latest('id')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalCourses',
            'totalBatches',
            'totalAdmissions',
            'totalInquiries',
            'totalCollectedFee',
            'totalPendingFee',
            'recentInquiries',
            'recentPayments'
        ));
    }
}