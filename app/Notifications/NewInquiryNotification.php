<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewInquiryNotification extends Notification
{
    use Queueable;

    protected $inquiryData;

    public function __construct($inquiryData)
    {
        $this->inquiryData = $inquiryData;
    }

    public function via($notifiable)
    {
        return ['database']; // Stores in 'notifications' DB table
    }

    public function toArray($notifiable)
    {
        return [
            'title' => 'New Lead / Inquiry Alert',
            'message' => 'New student ' . $this->inquiryData['student_name'] . ' inquired for ' . $this->inquiryData['course_name'],
            'link' => route('inquiries.index'),
            'icon' => 'fa-user-plus text-primary',
        ];
    }
}