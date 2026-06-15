<!DOCTYPE html>
<html>
<head>
    <title>Email Verification OTP - Rk Institute</title>
</head>
<body style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f8fafc; padding: 20px;">
    <div style="max-width: 480px; margin: 0 auto; background: #ffffff; border-radius: 16px; padding: 32px; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
        <div style="text-align: center; margin-bottom: 24px;">
            <h2 style="color: #1e293b; margin: 0;">Email Verification</h2>
            <p style="color: #64748b; margin-top: 8px;">Rk Institute Registration</p>
        </div>
        <p style="color: #334155;">Dear Student,</p>
        <p style="color: #334155;">Thank you for registering with Rk Institute. Please use the OTP below to verify your email address:</p>
        <div style="text-align: center; margin: 24px 0;">
            <span style="display: inline-block; background: linear-gradient(135deg, #3b82f6, #2563eb); color: #ffffff; font-size: 32px; font-weight: bold; letter-spacing: 8px; padding: 16px 32px; border-radius: 12px;">{{ $otp }}</span>
        </div>
        <p style="color: #64748b; font-size: 14px; text-align: center;">This OTP is valid for <strong>10 minutes</strong>. Do not share it with anyone.</p>
        <hr style="border: none; border-top: 1px solid #e2e8f0; margin: 24px 0;">
        <p style="color: #94a3b8; font-size: 12px; text-align: center;">If you did not initiate this registration, please ignore this email.</p>
        <p style="color: #94a3b8; font-size: 12px; text-align: center;">Best regards,<br><strong>Rk Institute</strong></p>
    </div>
</body>
</html>
