<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Registration Confirmation</title>
</head>
<body style="margin: 0; padding: 0; background-color: #f4f6f9; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; -webkit-font-smoothing: antialiased;">

    <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #f4f6f9; padding: 40px 10px;">
        <tr>
            <td align="center">
                <!-- Main Container -->
                <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px; background-color: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05); border: 1px solid #e2e8f0;">
                    
                    <!-- Header Banner -->
                    <tr>
                        <td style="background: linear-gradient(135deg, #0b2545 0%, #1e293b 100%); padding: 35px 30px; text-align: center;">
                            <h1 style="color: #ffffff; margin: 0; font-size: 24px; font-weight: 700; letter-spacing: 0.5px;">
                                Registration Confirmed
                            </h1>
                            <p style="color: #cbd5e1; margin: 8px 0 0 0; font-size: 14px;">
                                Welcome to the Learning Portal
                            </p>
                        </td>
                    </tr>

                    <!-- Body Content -->
                    <tr>
                        <td style="padding: 40px 30px;">
                            <p style="color: #334155; font-size: 16px; margin: 0 0 16px 0; font-weight: 600;">
                                Dear Student,
                            </p>
                            <p style="color: #64748b; font-size: 14px; line-height: 1.6; margin: 0 0 25px 0;">
                                Your pre-registration has been processed successfully. Below are your account credentials and system reference details:
                            </p>

                            <!-- Account Details Box -->
                            <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #f8fafc; border: 1px solid #e2e8f0; border-left: 5px solid #0b2545; border-radius: 8px; margin-bottom: 30px;">
                                <tr>
                                    <td style="padding: 18px 20px;">
                                        <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
                                            <tr>
                                                <td style="padding: 6px 0; color: #64748b; font-size: 13px; font-weight: 600; width: 40%;">
                                                    REGISTERED EMAIL
                                                </td>
                                                <td style="padding: 6px 0; color: #0f172a; font-size: 14px; font-weight: 700; word-break: break-all;">
                                                    {{ $student->email ?? $student['email'] ?? 'N/A' }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding: 6px 0; color: #64748b; font-size: 13px; font-weight: 600;">
                                                    CNIC / B-FORM NO
                                                </td>
                                                <td style="padding: 6px 0; color: #0f172a; font-size: 14px; font-weight: 700;">
                                                    {{ $student->cnic ?? $student->cnic_bform ?? $student['cnic'] ?? 'N/A' }}
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>

                            <p style="color: #64748b; font-size: 14px; line-height: 1.6; margin: 0 0 25px 0;">
                                To complete your account setup and choose your portal password, please click the button below:
                            </p>

                            <!-- CTA Button -->
                            <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <td align="center">
                                        <a href="{{ route('login') }}" target="_blank" style="background-color: #0b2545; color: #ffffff; text-decoration: none; padding: 14px 32px; border-radius: 6px; font-size: 14px; font-weight: 700; display: inline-block; box-shadow: 0 4px 12px rgba(11, 37, 69, 0.25);">
                                            Complete Profile Setup &rarr;
                                        </a>
                                    </td>
                                </tr>
                            </table>

                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background-color: #f8fafc; padding: 20px 30px; text-align: center; border-top: 1px solid #e2e8f0;">
                            <p style="color: #94a3b8; font-size: 12px; margin: 0 0 4px 0;">
                                This is an automated notification. Please do not reply directly to this email.
                            </p>
                            <p style="color: #94a3b8; font-size: 12px; margin: 0;">
                                &copy; {{ date('Y') }} Student Portal. All rights reserved.
                            </p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>

</body>
</html>