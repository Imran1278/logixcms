<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

// Model Imports
use App\Models\Course;

// Auth Controllers
use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\Auth\StudentRegisterController;
use App\Http\Controllers\Auth\StudentLoginController;

// Student Controllers
use App\Http\Controllers\Student\StudentDashboardController;
use App\Http\Controllers\Student\StudentProfileController;
use App\Http\Controllers\Student\InquiryController as StudentInquiryController;
use App\Http\Controllers\Student\StudentAttendanceController;

// Frontend Controllers
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\AboutController;
use App\Http\Controllers\Frontend\TutorController;
use App\Http\Controllers\Frontend\DownloadController;
use App\Http\Controllers\Frontend\FooterController;
use App\Http\Controllers\Frontend\NewsReleaseController;
use App\Http\Controllers\Frontend\CourseRecommendationController;
use App\Http\Controllers\Frontend\StudentChatbotController;
use App\Http\Controllers\Frontend\ContactController;

// Admin Controllers
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\BatchController;
use App\Http\Controllers\Admin\InquiryController as AdminInquiryController;
use App\Http\Controllers\Admin\AdmissionController;
use App\Http\Controllers\Admin\FeeController;
use App\Http\Controllers\Admin\FeeAllocationController;
use App\Http\Controllers\Admin\AttendanceController;
use App\Http\Controllers\Admin\CertificateController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\AdminSearchController;
use App\Http\Controllers\Admin\HeaderSettingController;
use App\Http\Controllers\Admin\FeeHeadController;
use App\Http\Controllers\Admin\FeeSettingController;
use App\Http\Controllers\Admin\ContactMessageController;
use App\Http\Controllers\Admin\AdminLeaveController;

/*
|--------------------------------------------------------------------------
| Public Frontend Routes
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/all-courses', function () {
    $courses = Course::where('status', 1)->latest()->get();
    return view('admin.courses.all', compact('courses'));
})->name('courses.all');

Route::get('/courses/{id}', [CourseController::class, 'show'])->name('courses.show');
Route::get('/downloads', [DownloadController::class, 'publicIndex'])->name('downloads.index');
Route::get('/about-details', [AboutController::class, 'showDetails'])->name('about.details');

// Contact Us Public Routes
Route::get('/contact-us', [ContactController::class, 'index'])->name('contact.index');
Route::post('/contact-us', [ContactController::class, 'store'])->name('contact.send');

// Student Quick Login Route
Route::get('/student-quick-login', function (Request $request) {
    if (Auth::guard('web')->check()) {
        return redirect()->route('student.dashboard');
    }

    $email = $request->query('email');
    return redirect()->route('student.login', ['email' => $email]);
})->name('student.quick.login');

// Student Course Finder Routes
Route::get('/course-finder', [CourseRecommendationController::class, 'index'])->name('course.finder');
Route::post('/course-finder/recommend', [CourseRecommendationController::class, 'recommend'])->name('course.recommend');

// Public AI Student Chatbot Route
Route::post('/student-chatbot', [StudentChatbotController::class, 'chat'])->name('student.chatbot');

/*
|--------------------------------------------------------------------------
| Student Authentication Routes (Guard: web)
|--------------------------------------------------------------------------
*/
Route::prefix('student')->name('student.')->group(function () {
    Route::get('/register', [StudentRegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [StudentRegisterController::class, 'register'])->name('register.submit');

    Route::get('/login', [StudentLoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [StudentLoginController::class, 'login'])->name('login.submit');
});

/*
|--------------------------------------------------------------------------
| Protected Student Portal Routes (Guard: web)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth:web'])->prefix('student')->name('student.')->group(function () {
    Route::get('/dashboard', [StudentDashboardController::class, 'index'])->name('dashboard');
    Route::get('/complete-profile', [StudentProfileController::class, 'showCompleteForm'])->name('profile.complete');
    Route::post('/complete-profile', [StudentProfileController::class, 'submitProfile'])->name('profile.submit');
    
    // Attendance & 2FA Security Routes
    Route::get('/attendance', [StudentAttendanceController::class, 'index'])->name('attendance.index');
    Route::post('/attendance/enable-2fa', [StudentAttendanceController::class, 'enable2FA'])->name('enable2fa');
    Route::post('/attendance/check-in', [StudentAttendanceController::class, 'checkIn'])->name('checkin');
    
    // Legacy Route Names Compatibility
    Route::post('/attendance/enable-2fa-alias', [StudentAttendanceController::class, 'enable2FA'])->name('attendance.enable2fa');
    Route::post('/attendance/check-in-alias', [StudentAttendanceController::class, 'checkIn'])->name('attendance.checkin');
    
    Route::get('/attendance/export-excel', [StudentAttendanceController::class, 'exportExcel'])->name('attendance.export.excel');
    Route::get('/attendance/export-pdf', [StudentAttendanceController::class, 'exportPdf'])->name('attendance.export.pdf');

    // Inquiries, Leave Requests & Profile Management
    Route::post('/inquiries', [StudentInquiryController::class, 'store'])->name('inquiries.store');
    Route::post('/leave', [StudentAttendanceController::class, 'applyLeave'])->name('leave.store');
    Route::post('/profile/update', [StudentDashboardController::class, 'updateProfile'])->name('profile.update');

    // Downloads
    Route::get('/downloads', [DownloadController::class, 'publicIndex'])->name('downloads');
    
    // Fee Collection & Payment Gateway (Stripe) Callbacks
    Route::post('/fees/pay', [StudentDashboardController::class, 'payFee'])->name('fees.pay');
    Route::get('/fees/stripe/callback', [StudentDashboardController::class, 'stripeCallback'])->name('fees.stripe.callback');

    Route::post('/logout', [StudentLoginController::class, 'logout'])->name('logout');
});

/*
|--------------------------------------------------------------------------
| Admin Authentication Routes (Guard: admin)
|--------------------------------------------------------------------------
*/
Route::get('login', [AdminAuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AdminAuthController::class, 'login']);

Route::get('register', [AdminAuthController::class, 'showRegisterForm'])->name('register');
Route::post('register', [AdminAuthController::class, 'register']);

/*
|--------------------------------------------------------------------------
| Protected Admin Portal Routes (Guard: admin)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth:admin'])->prefix('admin')->group(function () {
    
    // Admin Control Panel & Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Header Configuration Management
    Route::get('/header-settings', [HeaderSettingController::class, 'index'])->name('admin.header_settings.index');
    Route::post('/header-settings', [HeaderSettingController::class, 'update'])->name('admin.header_settings.update');

    // News Releases & Press Management
    Route::get('/news-releases', [NewsReleaseController::class, 'index'])->name('admin.news.index');
    Route::post('/press-release', [NewsReleaseController::class, 'storePressRelease'])->name('admin.press.store');
    Route::post('/latest-news', [NewsReleaseController::class, 'storeLatestNews'])->name('admin.latest_news.store');
    Route::post('/upcoming-news', [NewsReleaseController::class, 'storeUpcomingNews'])->name('admin.upcoming_news.store');
    Route::delete('/press-release/{id}', [NewsReleaseController::class, 'destroyPressRelease'])->name('admin.press.destroy');
    Route::delete('/latest-news/{id}', [NewsReleaseController::class, 'destroyLatestNews'])->name('admin.latest_news.destroy');
    Route::delete('/upcoming-news/{id}', [NewsReleaseController::class, 'destroyUpcomingNews'])->name('admin.upcoming_news.destroy');

    // Footer & Content Customization Settings
    Route::get('/footer', [FooterController::class, 'index'])->name('admin.footer.index');
    Route::post('/footer/update', [FooterController::class, 'update'])->name('admin.footer.update');

    // Institutional Details & About Pages
    Route::get('/about', [AboutController::class, 'index'])->name('admin.about.index');
    Route::post('/about/update', [AboutController::class, 'updateAdmin'])->name('admin.about.update');
    Route::post('/about/delete-award', [AboutController::class, 'deleteAward'])->name('admin.about.award.delete');

    // Course Finder Engine CMS
    Route::get('/course-finder', [CourseRecommendationController::class, 'adminIndex'])->name('admin.finder.index');
    Route::post('/course-finder', [CourseRecommendationController::class, 'adminStore'])->name('admin.finder.store');
    Route::delete('/course-finder/{id}', [CourseRecommendationController::class, 'adminDestroy'])->name('admin.finder.destroy');

    // Digital Resources & Faculty Directory Management
    Route::get('/downloads', [DownloadController::class, 'index'])->name('admin.downloads.index');
    Route::post('/downloads', [DownloadController::class, 'store'])->name('admin.downloads.store');
    Route::delete('/downloads/{id}', [DownloadController::class, 'destroy'])->name('admin.downloads.destroy');

    Route::get('/tutors', [TutorController::class, 'index'])->name('admin.tutors.index');
    Route::post('/tutors', [TutorController::class, 'store'])->name('admin.tutors.store');
    Route::delete('/tutors/{id}', [TutorController::class, 'destroy'])->name('admin.tutors.destroy');

    // Public Contact Desk Messages
    Route::get('/contact-messages', [ContactMessageController::class, 'index'])->name('admin.contacts.index');
    Route::post('/contact-messages/{id}/toggle-read', [ContactMessageController::class, 'toggleRead'])->name('admin.contacts.toggleRead');
    Route::delete('/contact-messages/{id}', [ContactMessageController::class, 'destroy'])->name('admin.contacts.destroy');
    Route::post('/contact-messages/{id}/reply', [ContactMessageController::class, 'reply'])->name('admin.contacts.reply');

    // Student Information Directory & Security Management
    Route::get('/students', [AdminSearchController::class, 'searchStudent'])->name('admin.students.index');
    Route::post('/students/{id}/reset-2fa', [AdminLeaveController::class, 'reset2FA'])->name('admin.students.reset2fa');

    // Academics & Class Batches Modules
    Route::get('/courses', [CourseController::class, 'index'])->name('courses.index');
    Route::post('/courses', [CourseController::class, 'store'])->name('courses.store');

    Route::get('/batches', [BatchController::class, 'index'])->name('batches.index');
    Route::get('/batches/create', [BatchController::class, 'create'])->name('batches.create');
    Route::get('/batches/get-next-number/{courseId}', [BatchController::class, 'getNextBatchNumber']);
    Route::post('/batches', [BatchController::class, 'store'])->name('batches.store');
    Route::get('/batches/{id}', [BatchController::class, 'show'])->name('batches.show');
    
    // Public & Student Inquiries Management
    Route::get('/inquiries', [AdminInquiryController::class, 'index'])->name('inquiries.index');
    Route::post('/inquiries', [AdminInquiryController::class, 'store'])->name('inquiries.store');
    Route::match(['post', 'put'], '/inquiries/update/{id}', [AdminInquiryController::class, 'updateStatus'])->name('inquiries.update');
    Route::match(['post', 'put'], '/inquiries/{id}/reply', [AdminInquiryController::class, 'studentReply'])->name('inquiries.studentReply');

    // Admissions Administration Module
    Route::get('/admissions', [AdmissionController::class, 'index'])->name('admissions.index');
    Route::get('/admissions/create', [AdmissionController::class, 'create'])->name('admissions.create');
    Route::post('/admissions', [AdmissionController::class, 'store'])->name('admissions.store');
    Route::get('/admissions/{id}', [AdmissionController::class, 'show'])->name('admissions.show');

    // Fee Structures, Headings & Allocations
    Route::get('/fees/allot/{admission_id}', [FeeAllocationController::class, 'create'])->name('fees.allot.create');
    Route::post('/fees/allot/store', [FeeAllocationController::class, 'store'])->name('fees.allot.store');
    Route::get('/fees/defaulters', [FeeAllocationController::class, 'defaulters'])->name('fees.defaulters');
    
    Route::get('/fees/heads', [FeeHeadController::class, 'index'])->name('fees.heads.index');
    Route::post('/fees/heads', [FeeHeadController::class, 'store'])->name('fees.heads.store');
    Route::delete('/fees/heads/{feeHead}', [FeeHeadController::class, 'destroy'])->name('fees.heads.destroy');
    
    Route::get('/fees/settings', [FeeSettingController::class, 'index'])->name('fees.settings.index');
    Route::post('/fees/settings', [FeeSettingController::class, 'store'])->name('fees.settings.store');
    Route::delete('/fees/settings/{feeSetting}', [FeeSettingController::class, 'destroy'])->name('fees.settings.destroy');

    // Collection Ledger, Receipts & Online Payments
    Route::get('/fees', [FeeController::class, 'index'])->name('fees.index');
    Route::get('/fees/collect/{admission_id}', [FeeController::class, 'create'])->name('fees.create');
    Route::post('/fees/store', [FeeController::class, 'store'])->name('fees.store');
    Route::get('/fees/receipt/{id}', [FeeController::class, 'receipt'])->name('fees.receipt');
    Route::get('/fees/stripe/success', [FeeController::class, 'stripeSuccess'])->name('fees.stripe.success');

    // Campus Attendance & Analytical Export Reports
    Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance.index');
    Route::post('/attendance', [AttendanceController::class, 'store'])->name('attendance.store');
    Route::get('/attendance/report', [AttendanceController::class, 'report'])->name('attendance.report');
    Route::get('/attendance/export-excel', [AttendanceController::class, 'exportExcel'])->name('attendance.export.excel');
    Route::get('/attendance/export-pdf', [AttendanceController::class, 'exportPdf'])->name('attendance.export.pdf');

    // Leave Applications Approval Portal
    Route::get('/leaves', [AdminLeaveController::class, 'index'])->name('admin.leaves.index');
    Route::post('/leaves/{id}/update-status', [AdminLeaveController::class, 'updateLeaveStatus'])->name('admin.leaves.updateStatus');

    // Academic Certificate Generation
    Route::get('/certificates', [CertificateController::class, 'index'])->name('certificates.index');
    Route::post('/certificates', [CertificateController::class, 'store'])->name('certificates.store');
    Route::get('/certificates/{id}', [CertificateController::class, 'show'])->name('certificates.show');

    // Admin Profile Settings & Broadcast Notifications
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');

    Route::get('/notifications/read/{id}', [HomeController::class, 'markNotificationAsRead'])->name('notifications.read');
    Route::get('/notifications/clear-all', [HomeController::class, 'clearAllNotifications'])->name('notifications.clearAll');

    // Admin Session Logout
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');
});