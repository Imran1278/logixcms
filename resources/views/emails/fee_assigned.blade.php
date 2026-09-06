@component('mail::message')
# Dear {{ $admission->student_name }},

We hope this email finds you well. 

This is an official notification regarding the issuance of your fee voucher for the **{{ $admission->course->course_name ?? $admission->course->title ?? 'Enrolled Course' }}** program at **Logix College**.

@component('mail::panel')
### **Fee Voucher Summary**
---
* **Registration No:** `{{ $admission->registration_no ?? 'N/A' }}`
* **Student Name:** {{ $admission->student_name }}
* **Amount Payable:** **Rs. {{ number_format($fee->due_amount ?? $fee->net_payable ?? $fee->amount ?? 0) }}**
* **Academic Session:** {{ $fee->academic_session ?? 'N/A' }}
* **Payment Reference:** {{ $fee->remarks ?? 'Academic Fee Allocation' }}
@endcomponent

### **Payment Instructions**
To ensure uninterrupted access to your academic portal and classes, please process your payment on or before the due date.

You can conveniently pay online via Credit/Debit Card (Stripe) through your **Student Portal**, or visit the accounts department for manual collection.

@component('mail::button', ['url' => route('student.dashboard'), 'color' => 'success'])
Access Student Dashboard & Pay Online
@endcomponent

If you have already settled this fee or have any queries regarding this invoice, please reach out to our Accounts Department.

Warm regards,  
**Finance & Accounts Directorate**  
*Logix College Management System*  
*Contact Support: support@logix.edu.pk*
@endcomponent