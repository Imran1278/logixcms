<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>New Student Inquiry</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f6f9; margin: 0; padding: 20px; color: #333; }
        .email-card { max-width: 600px; margin: 0 auto; background: #ffffff; border-radius: 8px; padding: 25px; border: 1px solid #e1e8ed; box-shadow: 0 4px 10px rgba(0,0,0,0.05); }
        .header { border-bottom: 2px solid #0b2545; padding-bottom: 12px; margin-bottom: 20px; }
        .header h2 { color: #0b2545; margin: 0; font-size: 20px; }
        .info-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .info-table td { padding: 8px 0; border-bottom: 1px solid #f0f0f0; }
        .info-table td.label { font-weight: bold; width: 40%; color: #555; }
        .remarks-box { background: #f8fafc; border-left: 4px solid #d4af37; padding: 12px 15px; border-radius: 4px; margin-top: 15px; }
        .footer { margin-top: 25px; font-size: 12px; color: #888; text-align: center; }
    </style>
</head>
<body>
    <div class="email-card">
        <div class="header">
            <h2>New Student Inquiry Received</h2>
        </div>
        <p>A new inquiry has been submitted via Student Portal Dashboard.</p>
        
        <table class="info-table">
            <tr>
                <td class="label">Student Name:</td>
                <td><strong>{{ $inquiry->student_name }}</strong></td>
            </tr>
            <tr>
                <td class="label">Email Address:</td>
                <td>{{ $inquiry->email }}</td>
            </tr>
            <tr>
                <td class="label">CNIC:</td>
                <td>{{ $inquiry->cnic }}</td>
            </tr>
            <tr>
                <td class="label">Mobile Number:</td>
                <td><strong>{{ $inquiry->mobile_number }}</strong></td>
            </tr>
            <tr>
                <td class="label">WhatsApp Number:</td>
                <td>{{ $inquiry->whatsapp_number }}</td>
            </tr>
            <tr>
                <td class="label">Father Mobile:</td>
                <td>{{ $inquiry->father_mobile }}</td>
            </tr>
            <tr>
                <td class="label">Inquiry Date:</td>
                <td>{{ $inquiry->inquiry_date }}</td>
            </tr>
            <tr>
                <td class="label">Followed Social Media:</td>
                <td>{{ $inquiry->followed_social_media }}</td>
            </tr>
            <tr>
                <td class="label">Source:</td>
                <td>{{ $inquiry->source }}</td>
            </tr>
            <tr>
                <td class="label">Status:</td>
                <td><span style="color: #16a34a; font-weight: bold;">{{ $inquiry->status }}</span></td>
            </tr>
        </table>

        <div class="remarks-box">
            <strong>Remarks / Message:</strong><br>
            {{ $inquiry->remarks }}
        </div>

        <div class="footer">
            <p>This is an automated alert from LOGIX College Student Portal.</p>
        </div>
    </div>
</body>
</html>