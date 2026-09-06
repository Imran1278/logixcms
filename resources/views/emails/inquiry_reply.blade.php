<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f6f9; padding: 20px; }
        .card { background: #ffffff; padding: 25px; border-radius: 10px; border: 1px solid #e0e0e0; }
        .header { background: #0b2545; color: #ffffff; padding: 15px; border-radius: 8px 8px 0 0; text-align: center; }
        .content { padding: 20px 0; }
        .box { background: #f8fafc; border-left: 4px solid #d4af37; padding: 12px; margin: 10px 0; }
        .footer { font-size: 12px; color: #777; text-align: center; margin-top: 20px; }
        .btn { display: inline-block; padding: 10px 18px; background: #0b2545; color: #fff; text-decoration: none; border-radius: 5px; margin-top: 15px; }
    </style>
</head>
<body>
    <div class="card">
        <div class="header">
            <h2>Logix College Management System</h2>
        </div>
        <div class="content">
            <p>Dear <strong>{{ $inquiry->student_name ?? 'Student' }}</strong>,</p>
            <p>We have processed your inquiry/complaint. Here is the response from our administration:</p>
            
            <div class="box">
                <strong>Your Message:</strong>
                <p>{{ $inquiry->remarks }}</p>
            </div>

            <div class="box" style="border-left-color: #20c997;">
                <strong>Admin Reply:</strong>
                <p>{{ $inquiry->admin_reply }}</p>
            </div>

            <p>If you want to reply back to this message, please log in to your Student Portal dashboard.</p>
            <a href="{{ route('login') }}" class="btn">Go to Student Portal</a>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} Logix College. All rights reserved.
        </div>
    </div>
</body>
</html>