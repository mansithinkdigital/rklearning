<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Certificate of Completion - {{ $user->name }}</title>
    <style>
        @page {
            margin: 0;
            size: a4 landscape;
        }
        body {
            font-family: 'Georgia', serif;
            margin: 0;
            padding: 0;
            background-color: #fff;
            color: #333;
        }
        .wrapper {
            width: 100%;
            height: 100%;
            padding: 0;
            box-sizing: border-box;
            position: relative;
            background: #fff;
            overflow: hidden;
        }
        
        /* Blue Corner Accents */
        .corner-accent-tl {
            position: absolute;
            top: 0;
            left: 0;
            width: 250px;
            height: 250px;
            background: #1a2a6c;
            clip-path: polygon(0 0, 100% 0, 0 100%);
            z-index: 1;
        }
        .corner-accent-br {
            position: absolute;
            bottom: 0;
            right: 0;
            width: 250px;
            height: 250px;
            background: #1a2a6c;
            clip-path: polygon(100% 100%, 0 100%, 100% 0);
            z-index: 1;
        }

        .border-gold {
            position: absolute;
            top: 20px;
            left: 20px;
            right: 20px;
            bottom: 20px;
            border: 3px solid #d4af37;
            z-index: 2;
            pointer-events: none;
        }

        .content {
            position: relative;
            z-index: 10;
            padding: 60px 100px;
            text-align: center;
        }

        .header-section {
            margin-bottom: 30px;
        }
        .main-logo {
            width: 110px;
            margin-bottom: 15px;
        }
        .institute-title {
            font-size: 52px;
            color: #b21f1f;
            margin: 0;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 2px;
        }
        .tagline-gold {
            font-size: 24px;
            color: #1a2a6c;
            font-style: italic;
            margin: 10px 0;
            position: relative;
            display: inline-block;
        }
        .tagline-gold::before, .tagline-gold::after {
            content: '✧';
            margin: 0 15px;
            color: #d4af37;
        }

        .cert-title {
            font-size: 38px;
            color: #1a2a6c;
            font-weight: bold;
            text-transform: uppercase;
            border-bottom: 2px solid #d4af37;
            display: inline-block;
            padding-bottom: 5px;
            margin: 20px 0;
            letter-spacing: 3px;
        }

        .excellence-badge {
            position: absolute;
            top: 60px;
            right: 80px;
            width: 120px;
        }

        .certify-text {
            font-size: 22px;
            margin: 25px 0;
            color: #444;
        }
        .student-name-box {
            border-bottom: 1px solid #444;
            display: inline-block;
            min-width: 500px;
            padding: 5px 20px;
            margin: 10px 0;
        }
        .student-name {
            font-size: 32px;
            font-weight: bold;
            color: #1a2a6c;
        }

        .course-info {
            font-size: 20px;
            line-height: 1.6;
            margin: 25px 0;
            color: #444;
        }
        .course-name-highlight {
            font-size: 42px;
            font-weight: 900;
            color: #1a2a6c;
            display: block;
            margin: 15px 0;
            text-transform: uppercase;
        }

        .skills-grid {
            margin: 40px auto;
            width: 90%;
            display: table;
            border-collapse: separate;
            border-spacing: 20px 0;
        }
        .skill-item {
            display: table-cell;
            width: 16%;
            text-align: center;
            vertical-align: top;
        }
        .skill-icon-box {
            width: 45px;
            height: 45px;
            background: #1a2a6c;
            border-radius: 50%;
            margin: 0 auto 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 18px;
            font-weight: bold;
        }
        .skill-label {
            font-size: 11px;
            font-weight: bold;
            color: #1a2a6c;
            line-height: 1.3;
            text-transform: uppercase;
        }

        .footer {
            margin-top: 60px;
            width: 100%;
        }
        .footer-table {
            width: 100%;
            border-collapse: collapse;
        }
        .footer-cell {
            width: 33%;
            vertical-align: bottom;
            text-align: center;
            padding: 0 20px;
        }
        .sig-box {
            border-top: 1px solid #444;
            padding-top: 10px;
            font-size: 12px;
            font-weight: bold;
            color: #444;
        }
        .seal-circle {
            width: 90px;
            height: 90px;
            border: 2px solid #444;
            border-radius: 50%;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
            color: #777;
        }

        .cert-id-box {
            position: absolute;
            top: 480px;
            right: 60px;
            border: 1px solid #d4af37;
            padding: 10px;
            background: #fff;
            width: 160px;
            text-align: center;
        }
        .id-label { font-size: 10px; font-weight: bold; color: #d4af37; text-transform: uppercase; margin-bottom: 3px; }
        .id-value { font-size: 12px; font-weight: bold; color: #1a2a6c; }

        .bottom-info {
            position: absolute;
            bottom: 40px;
            left: 60px;
            font-size: 14px;
            font-weight: bold;
            color: #444;
            text-align: left;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="corner-accent-tl"></div>
        <div class="corner-accent-br"></div>
        <div class="border-gold"></div>

        <div class="content">
            <div class="header-section">
                <img src="{{ public_path('assets/images/logo.png') }}" class="main-logo" alt="RK Logo">
                <h1 class="institute-title">RK INSTITUTE OF COMMERCE</h1>
                <p class="tagline-gold">Way to Success</p>
            </div>

            <img src="https://cdn-icons-png.flaticon.com/512/2111/2111295.png" class="excellence-badge" alt="Excellence Badge">

            <h2 class="cert-title">Certificate of Completion</h2>

            <p class="certify-text">This is to certify that</p>
            
            <div class="student-name-box">
                <span class="student-name">Mr./Ms. {{ strtoupper($user->name) }}</span>
            </div>

            <p class="course-info">
                has successfully completed the course in
                <span class="course-name-highlight">{{ strtoupper($course->name) }}</span>
                conducted by <span style="color:#b21f1f; font-weight:bold;">RK INSTITUTE OF COMMERCE</span><br>
                during the period from <u>{{ $enrollDate }}</u> to <u>{{ date('d/m/Y') }}</u>.
            </p>

            <p style="font-size: 14px; color: #444; font-style: italic; margin-top: 20px;">During this course, the student has gained knowledge in:</p>

            <div class="skills-grid">
                <div class="skill-item">
                    <div class="skill-icon-box">📊</div>
                    <div class="skill-label">Accounting<br>Fundamentals</div>
                </div>
                <div class="skill-item">
                    <div class="skill-icon-box">💻</div>
                    <div class="skill-label">Tally Prime<br>Software</div>
                </div>
                <div class="skill-item">
                    <div class="skill-icon-box">🧾</div>
                    <div class="skill-label">GST<br>(Goods and Services Tax)</div>
                </div>
                <div class="skill-item">
                    <div class="skill-icon-box">📦</div>
                    <div class="skill-label">Inventory<br>Management</div>
                </div>
                <div class="skill-item">
                    <div class="skill-icon-box">👥</div>
                    <div class="skill-label">Payroll<br>Management</div>
                </div>
                <div class="skill-item">
                    <div class="skill-icon-box">📈</div>
                    <div class="skill-label">Financial<br>Reporting</div>
                </div>
            </div>

            <p style="font-style: italic; font-size: 14px; margin-top: 30px;">We wish them success in their future endeavors.</p>

            <div class="footer">
                <table class="footer-table">
                    <tr>
                        <td class="footer-cell">
                            <div class="sig-box">Authorized Signature</div>
                        </td>
                        <td class="footer-cell">
                            <div class="seal-circle">Institute<br>Seal</div>
                        </td>
                        <td class="footer-cell">
                            <div class="sig-box">Director<br>RK INSTITUTE OF COMMERCE</div>
                        </td>
                    </tr>
                </table>
            </div>

            <div class="cert-id-box">
                <div class="id-label">Certificate ID</div>
                <div class="id-value">RKIC/{{ strtoupper(substr($course->name, 0, 3)) }}/{{ date('Y') }}/{{ str_pad($user->id, 4, '0', STR_PAD_LEFT) }}</div>
            </div>

            <div class="bottom-info">
                Date: {{ date('d/m/Y') }}<br>
                Place: Nashik
            </div>
        </div>
    </div>
</body>
</html>
