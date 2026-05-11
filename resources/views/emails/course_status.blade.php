<!DOCTYPE html>
<html>

<head>
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            line-height: 1.6;
            color: #334155;
        }

        .container {
            max-width: 600px;
            margin: 20px auto;
            padding: 40px;
            border: 1px solid #e2e8f0;
            border-radius: 24px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .logo {
            height: 50px;
            margin-bottom: 20px;
        }

        .status-badge {
            display: inline-block;
            padding: 8px 16px;
            border-radius: 12px;
            font-weight: 900;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .status-active {
            background-color: #f0fdf4;
            color: #166534;
        }

        .status-inactive {
            background-color: #fef2f2;
            color: #991b1b;
        }

        .footer {
            text-align: center;
            margin-top: 40px;
            font-size: 12px;
            color: #94a3b8;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>RK INSTITUTE</h1>
            <h2>Course Access Update</h2>
        </div>

        <p>Hello <strong>{{ $user->name }}</strong>,</p>

        <p>This is to inform you about a change in your access status for the following course:</p>

        <div style="background: #f8fafc; padding: 20px; border-radius: 16px; margin: 20px 0;">
            <p style="margin: 0; font-weight: 800; color: #1e293b;">{{ $course->name }}</p>
            <p style="margin: 5px 0 15px 0; font-size: 12px; color: #64748b;">Enrollment ID: #{{ str_pad($user->id, 4, '0', STR_PAD_LEFT) }}</p>

            <span class="status-badge {{ $status === 'approved' ? 'status-active' : 'status-inactive' }}">
                {{ $status === 'approved' ? 'Active' : 'Inactive' }}
            </span>
        </div>

        @if($status === 'approved')
        <p>Your access to this course has been <strong>restored</strong>. You can now continue your learning from your student dashboard.</p>
        <div style="text-align: center; margin-top: 30px;">
            <a href="{{ route('login') }}" style="background: #0062ff; color: white; padding: 12px 30px; text-decoration: none; border-radius: 12px; font-weight: 700; font-size: 14px;">Go to Dashboard</a>
        </div>
        @else
        <p>Your access to this course has been <strong>temporarily suspended</strong> due to pending fee installments. Please clear your outstanding balance to restore access.</p>
        <p style="font-weight: 700; color: #e11d48;">Action Required: Please contact the RK Institute office for payment.</p>
        @endif

        <div class="footer">
            <p>&copy; {{ date('Y') }} RK Institute. All rights reserved.</p>
            <p>This is an automated notification. Please do not reply to this email.</p>
        </div>
    </div>
</body>

</html>