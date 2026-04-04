<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đặt lại mật khẩu</title>
</head>
<body style="margin:0;padding:0;background-color:#f3f4f6;font-family:Arial,Helvetica,sans-serif;color:#111827;">
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background-color:#f3f4f6;padding:24px 0;">
        <tr>
            <td align="center">
                <table role="presentation" width="600" cellspacing="0" cellpadding="0" style="max-width:600px;width:100%;background:#ffffff;border-radius:10px;overflow:hidden;border:1px solid #e5e7eb;">
                    <tr>
                        <td style="padding:24px;background:#2563eb;color:#ffffff;">
                            <h1 style="margin:0;font-size:20px;line-height:1.4;">Yêu cầu đặt lại mật khẩu</h1>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:24px;">
                            <p style="margin:0 0 12px;line-height:1.6;">Xin chào,</p>
                            <p style="margin:0 0 16px;line-height:1.6;">Chúng tôi nhận được yêu cầu đặt lại mật khẩu cho tài khoản của bạn trên HRM System.</p>
                            <p style="margin:0 0 20px;line-height:1.6;">Nhấn nút bên dưới để đặt lại mật khẩu:</p>

                            <p style="margin:0 0 20px;text-align:center;">
                                <a href="{{ route('password.reset', ['token' => $token]) }}" style="display:inline-block;background:#2563eb;color:#ffffff;text-decoration:none;padding:12px 20px;border-radius:8px;font-weight:600;">Đặt lại mật khẩu</a>
                            </p>

                            <p style="margin:0 0 10px;line-height:1.6;">Nếu bạn không yêu cầu thao tác này, bạn có thể bỏ qua email này.</p>
                            <p style="margin:0;line-height:1.6;color:#6b7280;font-size:13px;">Vì lý do bảo mật, liên kết có thể hết hạn sau một khoảng thời gian.</p>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:16px 24px;background:#f9fafb;color:#6b7280;font-size:12px;line-height:1.5;border-top:1px solid #e5e7eb;">
                            © 2026 HRM System
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
