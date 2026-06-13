<!DOCTYPE html>
<html>
<head>
    <title>Course Enrollment Receipt</title>
</head>
<body style="font-family: sans-serif;">
    <h2>Hello {{ $user->name }},</h2>
    <p>Thank you for enrolling in <strong>{{ $course->name }}</strong> at Rk Institute.</p>
    <p>We have received your payment and your enrollment is now confirmed.</p>
    <p>Attached to this email is your official payment receipt for your records.</p>
    <p>If you have any questions, please feel free to contact us.</p>
    <br>
    <p>Best regards,<br>Rk Institute Team</p>
</body>
</html>
