<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\AboutContent;
use App\Models\Course;
use App\Models\FinderQuestion;
use App\Models\Footer;
use App\Models\Tutor;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Render Public Home Page with all required data.
     */
    public function index(): View
    {
        $courses    = Course::where('status', 1)->latest()->get();
        $tutors     = Tutor::where('status', 1)->latest()->take(3)->get();
        $about      = AboutContent::first();
        $questions  = FinderQuestion::with('options')->orderBy('step_number', 'asc')->get();
        $footerData = Footer::first();

        return view('frontend.home', compact('courses', 'tutors', 'about', 'questions', 'footerData'));
    }

    /**
     * Mark a specific user notification as read and redirect to target link.
     */
    public function markNotificationAsRead(string $id): RedirectResponse
    {
        $notification = auth()->user()?->notifications()->where('id', $id)->first();

        if ($notification) {
            $notification->markAsRead();
            return redirect($notification->data['link'] ?? route('home'));
        }

        return redirect()->back();
    }

    /**
     * Mark all unread notifications for current user as read.
     */
    public function clearAllNotifications(): RedirectResponse
    {
        auth()->user()?->unreadNotifications->markAsRead();
        return redirect()->back()->with('success', 'All notifications marked as read.');
    }
}