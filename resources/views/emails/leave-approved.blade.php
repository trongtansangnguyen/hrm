<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thong bao duyet don nghi phep</title>
</head>
<body style="margin:0;padding:0;background-color:#f3f4f6;font-family:Arial,Helvetica,sans-serif;color:#111827;">
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background-color:#f3f4f6;padding:24px 0;">
        <tr>
            <td align="center">
                <table role="presentation" width="600" cellspacing="0" cellpadding="0" style="max-width:600px;width:100%;background:#ffffff;border-radius:10px;overflow:hidden;border:1px solid #e5e7eb;">
                    <tr>
                        <td style="padding:24px;background:#16a34a;color:#ffffff;">
                            <h1 style="margin:0;font-size:20px;line-height:1.4;">Đơn nghỉ phép của bạn đã được duyệt</h1>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:24px;line-height:1.7;">
                            <p style="margin:0 0 12px;">Xin chào {{ $employeeName }},</p>
                            <p style="margin:0 0 12px;">Đơn nghỉ phép của bạn đã được duyệt.</p>
                            <p style="margin:0 0 12px;">Thời gian nghỉ: <strong>{{ $fromDate }}</strong> đến <strong>{{ $toDate }}</strong>.</p>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:16px 24px;background:#f9fafb;color:#6b7280;font-size:12px;line-height:1.5;border-top:1px solid #e5e7eb;">
                            © 2026 SGU Tech Hub
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
