<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Certificate and Marksheet - {{ $user->name }}</title>
    <style>
        @page {
            margin: 0;
            size: a4 landscape;
        }
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #fff;
        }
        
        /* Certificate Page */
        .page-break {
            page-break-after: always;
        }
        .certificate-wrapper {
            width: 100%;
            height: 100%;
            padding: 30px;
            box-sizing: border-box;
            position: relative;
        }
        .certificate-border {
            border: 15px solid #1a2a6c;
            height: 100%;
            padding: 20px;
            box-sizing: border-box;
            position: relative;
        }
        .certificate-inner {
            border: 5px solid #b21f1f;
            height: 100%;
            padding: 30px;
            box-sizing: border-box;
            text-align: center;
            background-color: #fffaf0; /* Subtle parchment feel */
        }
        
        .header {
            margin-bottom: 20px;
        }
        .title {
            font-size: 50px;
            color: #1a2a6c;
            text-transform: uppercase;
            font-weight: bold;
            margin: 0;
            letter-spacing: 4px;
        }
        .subtitle {
            font-size: 18px;
            color: #b21f1f;
            margin-top: 5px;
            font-style: italic;
            font-weight: bold;
        }
        
        .user-photo-container {
            position: absolute;
            top: 40px;
            right: 40px;
            width: 120px;
            height: 140px;
            border: 4px solid #1a2a6c;
            padding: 2px;
            background: white;
        }
        .user-photo {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .award-text {
            font-size: 22px;
            margin: 30px 0 10px;
            color: #333;
        }
        .student-name {
            font-size: 42px;
            color: #1a2a6c;
            font-weight: bold;
            text-decoration: underline;
            margin: 15px 0;
        }
        .course-text {
            font-size: 18px;
            line-height: 1.5;
            margin: 15px auto;
            max-width: 85%;
            color: #444;
        }
        .course-name {
            font-weight: bold;
            color: #b21f1f;
            font-size: 24px;
        }
        
        .footer {
            margin-top: 40px;
            width: 100%;
        }
        .footer-item {
            width: 32%;
            display: inline-block;
            vertical-align: bottom;
            text-align: center;
        }
        .signature-line {
            border-bottom: 2px solid #333;
            width: 70%;
            margin: 0 auto 8px;
        }
        .footer-label {
            font-size: 12px;
            color: #555;
            text-transform: uppercase;
            font-weight: bold;
        }
        .seal-img {
            width: 90px;
            margin-bottom: 5px;
        }
        
        .meta-info {
            position: absolute;
            bottom: 30px;
            width: 100%;
            left: 0;
            padding: 0 50px;
            box-sizing: border-box;
            font-size: 11px;
            color: #777;
        }
        
        /* Marksheet Page */
        .marksheet-wrapper {
            padding: 50px;
            box-sizing: border-box;
        }
        .marksheet-header {
            text-align: center;
            border-bottom: 2px solid #1a2a6c;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .marksheet-title {
            font-size: 28px;
            color: #1a2a6c;
            font-weight: bold;
            margin: 0;
        }
        .student-info-grid {
            width: 100%;
            margin-bottom: 30px;
        }
        .student-info-grid td {
            padding: 8px 0;
            font-size: 14px;
        }
        .info-label {
            font-weight: bold;
            width: 150px;
            color: #555;
        }
        
        .marks-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .marks-table th {
            background-color: #1a2a6c;
            color: white;
            padding: 12px;
            text-align: left;
            font-size: 14px;
            text-transform: uppercase;
        }
        .marks-table td {
            border: 1px solid #e2e8f0;
            padding: 12px;
            font-size: 14px;
        }
        .marks-table tr:nth-child(even) {
            background-color: #f8fafc;
        }
        
        .total-row {
            background-color: #f1f5f9 !important;
            font-weight: bold;
        }
        .status-pass { color: green; font-weight: bold; }
        .status-fail { color: red; font-weight: bold; }
        
        .marksheet-footer {
            margin-top: 50px;
            text-align: right;
            font-size: 12px;
            color: #777;
        }
    </style>
</head>
<body>
    <!-- PAGE 1: CERTIFICATE -->
    <div class="certificate-wrapper page-break">
        <div class="certificate-border">
            <div class="certificate-inner">
                <!-- User Photo -->
                <div class="user-photo-container">
                    @if($userPhotoBase64)
                        <img src="{{ $userPhotoBase64 }}" class="user-photo" alt="Student Photo">
                    @else
                        <div style="width:100%; height:100%; background:#eee; display:flex; align-items:center; justify-content:center; font-size:10px; color:#999;">Photo Not Available</div>
                    @endif
                </div>

                <div class="header">
                    <h1 class="title">Certificate</h1>
                    <p class="subtitle">OF ACHIEVEMENT AND EXCELLENCE</p>
                </div>

                <p class="award-text">This is to officially certify that</p>
                <h2 class="student-name">{{ strtoupper($user->name) }}</h2>
                
                <p class="course-text">
                    has successfully completed the comprehensive professional course in<br>
                    <span class="course-name">{{ strtoupper($course->name) }}</span><br>
                    demonstrating exceptional proficiency and passing all required subject examinations<br>
                    conducted by the RK Learning Hub academic board.
                </p>

                <div class="footer">
                    <div class="footer-item">
                        <div class="signature-line"></div>
                        <p class="footer-label">Course Coordinator</p>
                    </div>
                    <div class="footer-item">
                        <img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png" class="seal-img" alt="Official Seal">
                        <p class="footer-label">RK Learning Hub Seal</p>
                    </div>
                    <div class="footer-item">
                        <div class="signature-line"></div>
                        <p class="footer-label">Director of Education</p>
                    </div>
                </div>

                <div class="meta-info">
                    <div style="float: left;">Issue Date: {{ date('d F, Y') }}</div>
                    <div style="float: right;">Verification ID: RK-{{ strtoupper(substr(md5($user->id . $course->id), 0, 8)) }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- PAGE 2: MARKSHEET -->
    <div class="marksheet-wrapper">
        <div class="marksheet-header">
            <p style="margin:0; font-size:12px; color:#b21f1f; font-weight:bold; letter-spacing:2px;">ACADEMIC RECORD</p>
            <h1 class="marksheet-title">OFFICIAL STATEMENT OF MARKS</h1>
            <p style="margin:5px 0 0; font-size:14px; color:#555;">RK Learning Hub - Academic Assessment Division</p>
        </div>

        <table class="student-info-grid">
            <tr>
                <td class="info-label">Student Name:</td>
                <td>{{ $user->name }}</td>
                <td class="info-label">Course Title:</td>
                <td>{{ $course->name }}</td>
            </tr>
            <tr>
                <td class="info-label">Student ID:</td>
                <td>STU-{{ str_pad($user->id, 5, '0', STR_PAD_LEFT) }}</td>
                <td class="info-label">Enrollment Date:</td>
                <td>{{ $course->pivot->created_at->format('d M Y') }}</td>
            </tr>
        </table>

        <table class="marks-table">
            <thead>
                <tr>
                    <th>Subject Name</th>
                    <th>Total Marks</th>
                    <th>Pass Marks</th>
                    <th>Marks Obtained</th>
                    <th>Percentage</th>
                    <th>Result</th>
                </tr>
            </thead>
            <tbody>
                @php 
                    $totalMax = 0;
                    $totalObtained = 0;
                @endphp
                @foreach($subjects as $subject)
                    @php 
                        $res = $results->get($subject->id);
                        $obtained = $res ? $res->score : 0;
                        $totalMax += $subject->total_marks;
                        $totalObtained += $obtained;
                        $pct = ($subject->total_marks > 0) ? ($obtained / $subject->total_marks * 100) : 0;
                    @endphp
                    <tr>
                        <td>{{ $subject->subject->name }}</td>
                        <td>{{ $subject->total_marks }}</td>
                        <td>{{ $subject->pass_marks }}</td>
                        <td>{{ $obtained }}</td>
                        <td>{{ number_format($pct, 1) }}%</td>
                        <td>
                            @if($res && $res->status == 'pass')
                                <span class="status-pass">PASS</span>
                            @else
                                <span class="status-fail">FAIL</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
                <tr class="total-row">
                    <td>AGGREGATE TOTAL</td>
                    <td>{{ $totalMax }}</td>
                    <td>-</td>
                    <td>{{ $totalObtained }}</td>
                    <td>{{ number_format(($totalMax > 0 ? ($totalObtained / $totalMax * 100) : 0), 1) }}%</td>
                    <td>
                        @if($totalObtained >= ($totalMax * 0.4)) {{-- Assuming 40% aggregate pass --}}
                            <span class="status-pass">QUALIFIED</span>
                        @else
                            <span class="status-fail">NOT QUALIFIED</span>
                        @endif
                    </td>
                </tr>
            </tbody>
        </table>

        <div style="margin-top:40px; font-size:12px; color:#666; line-height:1.6;">
            <p><strong>Note:</strong> This document is a computer-generated official statement of marks. Any alteration or tampering renders this document invalid. For verification, please contact the administrative office at RK Learning Hub.</p>
            <p>Percentage Calculation: (Marks Obtained / Total Marks) * 100</p>
        </div>

        <div class="marksheet-footer">
            <p>Generated on: {{ date('d-m-Y H:i:s') }}</p>
            <p>Reference: RKLH/MARK/{{ $course->id }}/{{ $user->id }}</p>
        </div>
    </div>
</body>
</html>
