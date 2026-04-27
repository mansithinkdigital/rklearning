<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Marksheet - {{ $user->name }}</title>
    <style>
        @page {
            size: A4;
            margin: 10mm;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: 'Times New Roman', Times, serif;
            color: #222;
        }

        .marksheet-card {
            border: 5px solid #1a2a6c;
            padding: 2px;
            height: 270mm;
            box-sizing: border-box;
        }

        .inner-content {
            border: 2px solid #d4af37;
            height: 100%;
            padding: 25px;
            box-sizing: border-box;
            position: relative;
        }

        /* HEADER */
        .header {
            text-align: center;
        }

        .rk-logo {
            width: 90px;
            margin-bottom: 5px;
        }

        .inst-name {
            font-size: 36px;
            font-weight: bold;
            color: #b21f1f;
            margin: 0;
        }

        .inst-tag {
            font-size: 16px;
            color: #1a2a6c;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .inst-info {
            font-size: 10px;
            color: #555;
            line-height: 1.2;
        }

        /* TITLES */
        .title-block {
            text-align: center;
            margin: 20px 0;
        }

        .m-title {
            font-size: 28px;
            font-weight: bold;
            color: #1a2a6c;
            letter-spacing: 2px;
            text-transform: uppercase;
        }

        .m-year {
            font-size: 18px;
            font-weight: bold;
            margin-top: 5px;
        }

        /* STUDENT INFO */
        .info-section {
            margin-top: 20px;
            width: 100%;
        }

        .info-table {
            width: 75%;
            border-collapse: collapse;
        }

        .info-table td {
            padding: 6px 0;
            font-size: 15px;
        }

        .info-label {
            font-weight: bold;
            width: 150px;
        }

        .photo-area {
            position: absolute;
            top: 200px;
            right: 40px;
            width: 100px;
            height: 120px;
            border: 1px solid #1a2a6c;
            text-align: center;
        }

        .photo-area img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* TABLE */
        .marks-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 30px;
        }

        .marks-table th,
        .marks-table td {
            border: 1px solid #333;
            padding: 10px;
            text-align: center;
            font-size: 14px;
        }

        .marks-table th {
            background-color: #f0f0f0;
            font-weight: bold;
        }

        .sub-name {
            text-align: left !important;
        }

        .bold-row {
            font-weight: bold;
            background-color: #f9f9f9;
        }

        /* SUMMARY */
        .result-box {
            margin-top: 25px;
            font-size: 16px;
            font-weight: bold;
            border: 1px solid #1a2a6c;
            padding: 10px;
            display: inline-block;
        }

        /* FOOTER */
        .footer-line {
            position: absolute;
            bottom: 30px;
            left: 25px;
            right: 25px;
            width: calc(100% - 50px);
        }

        .footer-table {
            width: 100%;
            border-collapse: collapse;
        }

        .footer-table td {
            width: 33%;
            text-align: center;
            vertical-align: bottom;
        }

        .f-logo {
            height: 70px;
        }

        .f-label {
            font-size: 11px;
            font-weight: bold;
            margin-top: 5px;
            display: block;
        }

        .md-sign {
            height: 60px;
        }

        .sign-text {
            border-top: 1px solid #000;
            padding-top: 5px;
            font-size: 12px;
            font-weight: bold;
            width: 160px;
            margin: auto;
        }
    </style>
</head>

<body>

    <div class="marksheet-card">
        <div class="inner-content">

            <!-- HEADER -->
            <div class="header">
                <img src="{{ public_path('assets/images/logo.png') }}" class="rk-logo">
                <div class="inst-name">RK INSTITUTE</div>
                <div class="inst-tag">Ramesh Kolhe's Learning Hub</div>
                <div class="inst-info">
                    GOVERNMENT OF INDIA MINISTRY OF CORPORATE AFFAIRS<br>
                    Reg No. U85301MH2023PTC401715 | Registered office: Nashik - 422010<br>
                    Email: rklearninghub2023@gmail.com
                </div>
            </div>

            <hr style="border: 0.5px solid #d4af37; margin: 15px 0;">

            <!-- TITLE -->
            <div class="title-block">
                <div class="m-title">MARKSHEET</div>
                <div class="m-year">Academic Year: {{ date('Y') }}</div>
            </div>

            <!-- PHOTO -->
            <div class="photo-area">
                @if($userPhotoBase64)
                <img src="{{ $userPhotoBase64 }}">
                @else
                <div style="padding-top: 40px; color: #ddd; font-size: 10px;">PHOTO</div>
                @endif
            </div>

            <!-- STUDENT INFO -->
            <div class="info-section">
                <table class="info-table">
                    <tr>
                        <td class="info-label">Candidate Name</td>
                        <td>: {{ strtoupper($user->name) }}</td>
                    </tr>
                    <tr>
                        <td class="info-label">Course Name</td>
                        <td>: {{ strtoupper($course->name) }}</td>
                    </tr>
                    <tr>
                        <td class="info-label">Roll Number</td>
                        <td>: RK{{ date('Y') }}{{ str_pad($user->id, 4, '0', STR_PAD_LEFT) }}</td>
                    </tr>
                    <tr>
                        <td class="info-label">Training Center</td>
                        <td>: RK Institute, Nashik</td>
                    </tr>
                </table>
            </div>

            <!-- MARKS TABLE -->
            <table class="marks-table">
                <thead>
                    <tr>
                        <th width="10%">Sr. No.</th>
                        <th class="sub-name">Subject / Module</th>
                        <th width="15%">Max Marks</th>
                        <th width="15%">Min Marks</th>
                        <th width="15%">Marks Obtained</th>
                    </tr>
                </thead>
                <tbody>
                    @php 
                        $totalMax = 0; 
                        $totalMin = 0; 
                        $totalObt = 0; 
                    @endphp

                    @foreach($subjects as $i => $subject)
                    @php
                        $res = $results->get($subject->id);
                        $obt = $res ? round(($res->score / 100) * $subject->total_marks) : 0;
                        
                        $totalMax += $subject->total_marks;
                        $totalMin += $subject->pass_marks;
                        $totalObt += $obt;
                    @endphp
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td class="sub-name">{{ $subject->subject->name }}</td>
                        <td>{{ $subject->total_marks }}</td>
                        <td>{{ $subject->pass_marks }}</td>
                        <td><b>{{ $obt }}</b></td>
                    </tr>
                    @endforeach

                    <tr class="bold-row">
                        <td colspan="2">TOTAL</td>
                        <td>{{ $totalMax }}</td>
                        <td>{{ $totalMin }}</td>
                        <td>{{ $totalObt }}</td>
                    </tr>
                </tbody>
            </table>

            <!-- RESULT -->
            @php
                $pct = $totalMax ? round(($totalObt / $totalMax) * 100) : 0;
                $grade = 'F';
                if($pct >= 85) $grade = 'A+';
                elseif($pct >= 75) $grade = 'A';
                elseif($pct >= 60) $grade = 'B';
                elseif($pct >= 50) $grade = 'C';
                elseif($pct >= 40) $grade = 'D';
                $status = ($totalObt >= $totalMin) ? 'PASS' : 'FAIL';
            @endphp

            <div class="result-box">
                Percentage: {{ $pct }}% &nbsp; | &nbsp; Grade: {{ $grade }} &nbsp; | &nbsp; Result: {{ $status }}
            </div>

            <div style="margin-top: 30px; font-size: 14px;">
                <b>Date:</b> {{ date('d/m/Y') }}<br>
                <b>Place:</b> Nashik
            </div>

            <!-- FOOTER -->
            <div class="footer-line">
                <table class="footer-table">
                    <tr>
                        <td>
                            <img src="{{ public_path('student/asset/logo/1.png') }}" class="f-logo">
                            <span class="f-label">ISO 9001:2015</span>
                        </td>
                        <td>
                            <img src="{{ public_path('student/asset/logo/rlstamp.png') }}" class="f-logo">
                            <span class="f-label">INSTITUTE STAMP</span>
                        </td>
                        <td>
                            <img src="{{ public_path('student/asset/logo/rksign.png') }}" class="md-sign">
                            <div class="sign-text">Managing Director</div>
                        </td>
                    </tr>
                </table>
            </div>

        </div>
    </div>

</body>

</html>