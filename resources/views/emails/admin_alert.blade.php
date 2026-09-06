<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin System Alert</title>
</head>
<body style="margin: 0; padding: 0; background-color: #f4f6f9; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout: fixed;">
        <tr>
            <td align="center" style="padding: 30px 15px;">
                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px; background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.08);">
                    
                    <!-- Top Status Bar -->
                    <tr>
                        <td style="background-color: #d4af37; height: 5px;"></td>
                    </tr>

                    <!-- Header -->
                    <tr>
                        <td style="background-color: #0b2545; padding: 20px 25px;">
                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <td>
                                        <h2 style="color: #ffffff; margin: 0; font-size: 18px; font-weight: 600; text-transform: uppercase;">
                                            SYSTEM ALERT NOTIFICATION
                                        </h2>
                                    </td>
                                    <td align="right">
                                        <span style="background-color: #d4af37; color: #0b2545; font-size: 11px; font-weight: 700; padding: 4px 10px; border-radius: 3px; text-transform: uppercase;">
                                            Action Needed
                                        </span>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Alert Content -->
                    <tr>
                        <td style="padding: 30px 25px; color: #333333; line-height: 1.6;">
                            <h3 style="color: #0b2545; margin-top: 0; font-size: 18px; font-weight: 600; border-bottom: 1px solid #eeeeee; padding-bottom: 10px;">
                                {{ $title }}
                            </h3>

                            <p style="font-size: 14px; color: #444444; background-color: #f8f9fa; border-left: 4px solid #d4af37; padding: 15px; border-radius: 4px; margin: 20px 0;">
                                {{ $contentDetails }}
                            </p>

                            <p style="font-size: 13px; color: #666666; margin-top: 25px;">
                                Please log into your Administrator Control Panel to view full record details and perform any necessary approvals or status updates.
                            </p>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td align="center" style="background-color: #f4f6f9; padding: 15px 20px; border-top: 1px solid #e9ecef; font-size: 12px; color: #888888;">
                            <p style="margin: 0;">Logix College ERP Automated Service &bull; System Notification</p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>
</html>