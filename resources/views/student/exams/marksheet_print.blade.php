<!DOCTYPE html>
<html>
@php
function getBase64($path) {
if (file_exists(public_path($path))) {
$data = file_get_contents(public_path($path));
$type = pathinfo(public_path($path), PATHINFO_EXTENSION);
return 'data:image/' . $type . ';base64,' . base64_encode($data);
}
return null;
}
$rkLogo = getBase64('assets/certificate/Rk Logo.jpg');
$msmeLogo = getBase64('student/asset/logo/msme-logo.webp');
$footerLogo1 = getBase64('student/asset/logo/1.png');
$footerLogo2 = getBase64('student/asset/logo/rlstamp.png');
$footerLogo3 = getBase64('student/asset/logo/rksign.png');
@endphp

<head>
    <meta charset="utf-8">
    <title>Official Marksheet - {{ $user->name }}</title>
    <style>
        @page {
            margin: 0;
            size: a4 portrait;
        }

        body {
            font-family: 'Arial', 'Helvetica', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #fff;
            color: #000;
        }

        .wrapper {
            width: 210mm;
            min-height: 297mm;
            padding: 10mm;
            box-sizing: border-box;
            position: relative;
            background-color: #fdf4f0;
            /* Light peach/beige background */
        }

        /* Multiple Borders */
        .border-outer {
            border: 1px solid #000;
            min-height: 275mm;
            padding: 1mm;
            box-sizing: border-box;
        }

        .border-middle {
            border: 3px solid #000;
            min-height: 271mm;
            padding: 1mm;
            box-sizing: border-box;
        }

        .border-inner {
            border: 1px solid #000;
            min-height: 267mm;
            padding: 10mm;
            box-sizing: border-box;
            position: relative;
        }

        /* Header */
        .header {
            text-align: center;
            margin-bottom: 5mm;
            position: relative;
        }

        .logo-left {
            position: absolute;
            top: 0;
            left: 0;
            width: 25mm;
        }

        .inst-name {
            font-size: 32pt;
            font-weight: bold;
            color: #0f2441;
            margin: 0;
            font-family: 'Georgia', serif;
        }

        .inst-tag {
            font-size: 14pt;
            color: #00b0f0;
            font-weight: bold;
            margin: 2mm 0;
        }

        .gov-text {
            font-size: 10pt;
            color: #00b0f0;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 2mm;
        }

        .reg-text {
            font-size: 8pt;
            color: #333;
            line-height: 1.4;
        }

        .divider {
            border-bottom: 3px solid #000;
            margin: 5mm 0;
        }

        /* Title Row */
        .title-row {
            width: 100%;
            margin-bottom: 5mm;
        }

        .marksheet-no {
            font-size: 11pt;
            font-weight: bold;
            text-align: left;
            white-space: nowrap;
        }

        .marksheet-pill {
            background-color: #0070c0;
            color: #fff;
            border-radius: 10px;
            padding: 2mm 6mm;
            font-size: 18pt;
            font-weight: bold;
            text-align: center;
            width: 50mm;
            margin: 0 auto;
        }

        .issued-year {
            font-size: 10pt;
            font-weight: bold;
            text-align: center;
            margin-top: 2mm;
        }

        /* Student Info & Photo */
        .info-photo-table {
            width: 100%;
            margin-bottom: 5mm;
        }

        .details-cell {
            vertical-align: top;
            font-size: 12pt;
            line-height: 1.8;
        }

        .photo-cell {
            vertical-align: top;
            text-align: right;
            width: 40mm;
        }

        .student-photo {
            width: 35mm;
            height: 45mm;
            border: 1px solid #000;
            object-fit: cover;
        }

        .emblems {
            text-align: left;
            margin-bottom: 5mm;
        }

        /* Marks Table */
        .marks-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 5mm;
        }

        .marks-table th,
        .marks-table td {
            border: 1px solid #000;
            padding: 2mm;
            font-size: 11pt;
            text-align: center;
        }

        .marks-table th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        .marks-table td.subject-name {
            text-align: left;
            font-weight: bold;
        }

        .total-row {
            font-weight: bold;
            background-color: #f2f2f2;
        }

        /* Footer Info */
        .footer-info {
            width: 100%;
            margin-top: 5mm;
            font-size: 12pt;
            font-weight: bold;
        }

        /* Footer Logos */
        .footer-logos {
            width: 100%;
            margin-top: 10mm;
        }

        .logo-cell {
            width: 33.33%;
            text-align: center;
            vertical-align: bottom;
        }
    </style>
</head>

<body>
    <div class="wrapper">
            <div class="border-outer">
                <div class="border-middle">
                    <div class="border-inner">
                        @php
                            // Calculate actual completion date (date of the last passed exam)
                            $completionDate = $results->isNotEmpty() 
                                ? $results->max('created_at')->format('d/m/Y') 
                                : date('d/m/Y');
                                
                            // Unique Marksheet No using Course ID and User ID or Pivot ID
                            // Attempt to get the pivot ID for a truly unique number
                            $pivotId = optional($user->courses->firstWhere('id', $course->id))->pivot->id ?? $user->id;
                            $marksheetNo = "RK" . date('Y') . str_pad($pivotId, 5, '0', STR_PAD_LEFT);
                        @endphp
                        
                        <!-- Structural Table to keep footer at bottom while allowing content to grow -->
                        <table style="width: 100%; border-collapse: collapse; min-height: 240mm;">
                            <tr>
                                <td style="vertical-align: top; padding: 0;">
                                    <!-- Header -->
                                    <div class="header">
                                        <!-- Crest Logo -->
                                        <div class="logo-left">
                                            @if($rkLogo)
                                            <img src="{{ $rkLogo }}" style="width: 90px; height: 90px;">
                                            @else
                                            <svg width="80" height="80" viewBox="0 0 100 100">
                                                <circle cx="50" cy="50" r="45" fill="none" stroke="#0f2441" stroke-width="2" />
                                                <circle cx="50" cy="50" r="40" fill="none" stroke="#c5a059" stroke-width="1" />
                                                <path d="M30,65 L50,75 L70,65 L50,55 Z" fill="#c5a059" opacity="0.5" />
                                                <circle cx="50" cy="40" r="12" fill="#c5a059" />
                                            </svg>
                                            @endif
                                        </div>

                                        <h1 class="inst-name">RK INSTITUTE</h1>
                                        <div class="inst-tag">Ramesh Kolhe's Learning Hub</div>
                                        <div class="gov-text">Government of India Ministry of Corporate Affairs</div>
                                        <div class="reg-text">
                                            <b>Reg No. U85301MH2023PTC401715</b><br>
                                            Registered office: C 6, Plot No. 7 s, Shree Sai Village, Pathardi Road, Pathardi, Nashik-422010, Maharastra.<br>
                                            <b>Email : rklearninghub2023@gmail.com</b>
                                        </div>
                                    </div>
                                    <div class="divider"></div>
                                    <!-- Title Row -->
                                    <table class="title-row">
                                        <tr>
                                            <td style="width: 33%;" class="marksheet-no">
                                                Marksheet No. {{ $marksheetNo }}
                                            </td>
                                            <td style="width: 34%;">
                                                <div class="marksheet-pill">Marksheet</div>
                                                <div class="issued-year">Marksheet issued Year {{ date('Y') }}</div>
                                            </td>
                                            <td style="width: 33%;"></td>
                                        </tr>
                                    </table>
                                    <!-- Student Info & Photo -->
                                    <table class="info-photo-table">
                                        <tr>
                                            <td class="details-cell">
                                                <div class="emblems">
                                                    @if($msmeLogo)
                                                    <img src="{{ $msmeLogo }}" style="height: 80px;width:120px;">
                                                    @else
                                                    <!-- MSME & Emblem Placeholders -->
                                                    <svg width="100" height="40" viewBox="0 0 100 40">
                                                        <rect x="0" y="5" width="20" height="30" fill="#c5a059" rx="2" />
                                                        <text x="10" y="22" font-size="6" fill="#fff" text-anchor="middle" font-weight="bold">INDIA</text>
                                                        <rect x="30" y="5" width="60" height="30" fill="#0f2441" rx="2" />
                                                        <text x="60" y="22" font-size="10" fill="#fff" text-anchor="middle" font-weight="bold">MSME</text>
                                                    </svg>
                                                    @endif
                                                </div>

                                                <b>This is Certified that Mr/ms :</b> {{ strtoupper($user->name) }}<br>
                                                <b>Mother Name :</b> {{ strtoupper($user->mother_name ?? 'N/A') }}<br>
                                                <b>HAS SUCCESSFULLY COMPLETED :</b> {{ strtoupper($course->name) }}<br>
                                                <b>Centre Name :</b> {{ strtoupper(optional($user->branch)->branch_name ?? 'RK INSTITUTE 1 - Ashok Stumbha, Nashik') }}<br>
                                                <b>Performance in Examination as below</b>
                                            </td>
                                            <td class="photo-cell">
                                                @if($userPhotoBase64)
                                                <img src="{{ $userPhotoBase64 }}" class="student-photo">
                                                @else
                                                <div style="width: 35mm; height: 45mm; border: 1px solid #000; display: inline-block; text-align: center; line-height: 45mm; font-size: 10pt; background: #eee;">PHOTO</div>
                                                @endif
                                            </td>
                                        </tr>
                                    </table>

                                    <!-- Marks Table -->
                                    <table class="marks-table">
                                        <thead>
                                            <tr>
                                                <th style="width: 10%;">Sr No.</th>
                                                <th style="width: 40%;">Subject</th>
                                                <th style="width: 15%;">Max</th>
                                                <th style="width: 15%;">MIN</th>
                                                <th style="width: 20%;">Obtain Marks</th>
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
                                            // Ensure score is treated as percentage or absolute marks correctly
                                            // In our system, 'score' is percentage.
                                            $obt = $res ? round(($res->score / 100) * $subject->total_marks) : 0;

                                            $totalMax += $subject->total_marks;
                                            $totalMin += $subject->pass_marks;
                                            $totalObt += $obt;
                                            @endphp
                                            <tr>
                                                <td>{{ $i + 1 }}</td>
                                                <td class="subject-name">{{ $subject->subject->name }}</td>
                                                <td>{{ $subject->total_marks }}</td>
                                                <td>{{ $subject->pass_marks }}</td>
                                                <td><b>{{ $obt }}</b></td>
                                            </tr>
                                            @endforeach
                                            <tr class="total-row">
                                                <td colspan="2">TOTAL</td>
                                                <td>{{ $totalMax }}</td>
                                                <td>{{ $totalMin }}</td>
                                                <td>{{ $totalObt }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <!-- Footer Info -->
                                    @php
                                    $pct = $totalMax ? round(($totalObt / $totalMax) * 100) : 0;
                                    $grade = 'F';
                                    if($pct >= 85) $grade = 'O';
                                    elseif($pct >= 75) $grade = 'A+';
                                    elseif($pct >= 60) $grade = 'A';
                                    elseif($pct >= 50) $grade = 'B';
                                    elseif($pct >= 40) $grade = 'C';
                                    @endphp
                                    <table class="footer-info">
                                        <tr>
                                            <td style="width: 33%;">Date of issue : {{ $completionDate }}</td>
                                            <td style="width: 34%; text-align: center;">Overall Percentage : {{ $pct }}%</td>
                                            <td style="width: 33%; text-align: right;">Grade : {{ $grade }}</td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td style="vertical-align: bottom; height: 1px; padding: 0; margin-bottom:0px">
                                    <!-- Footer Logos -->
                                    <table class="footer-logos">
                                        <tr>
                                            <td class="logo-cell">
                                                @if($footerLogo1)
                                                <img src="{{ $footerLogo1 }}" style="height: 100px;">
                                                @else
                                                <svg width="80" height="80" viewBox="0 0 100 100">
                                                    <circle cx="50" cy="50" r="40" fill="#d4af37" />
                                                    <text x="50" y="45" font-size="8" fill="#fff" text-anchor="middle" font-weight="bold">ISO</text>
                                                    <text x="50" y="55" font-size="6" fill="#fff" text-anchor="middle">9001:2015</text>
                                                    <text x="50" y="65" font-size="6" fill="#fff" text-anchor="middle">CERTIFIED</text>
                                                </svg>
                                                @endif
                                            </td>
                                            <td class="logo-cell">
                                                @if($footerLogo2)
                                                <img src="{{ $footerLogo2 }}" style="height: 100px;">
                                                @else
                                                <svg width="80" height="80" viewBox="0 0 100 100">
                                                    <circle cx="50" cy="50" r="35" fill="none" stroke="#0070c0" stroke-width="2" />
                                                    <circle cx="50" cy="50" r="30" fill="none" stroke="#0070c0" stroke-width="1" stroke-dasharray="2,2" />
                                                    <text x="50" y="45" font-size="6" fill="#0070c0" text-anchor="middle" font-weight="bold">RK INSTITUTE</text>
                                                    <text x="50" y="55" font-size="6" fill="#0070c0" text-anchor="middle">SEAL</text>
                                                </svg>
                                                @endif
                                            </td>
                                            <td class="logo-cell">
                                                <div style="width: 80%; margin: 0 auto;">
                                                    @if($footerLogo3)
                                                    <img src="{{ $footerLogo3 }}" style="height: 70px; margin-bottom: 2mm;">
                                                    @else
                                                    <div style="border-bottom: 1px solid #000; width: 100%; margin-bottom: 2mm;">
                                                        <svg width="100" height="30" viewBox="0 0 100 30">
                                                            <path d="M10,25 Q30,5 50,20 T90,10" fill="none" stroke="#0070c0" stroke-width="2" />
                                                        </svg>
                                                    </div>
                                                    @endif
                                                </div>
                                                <div style="font-size: 10pt; font-weight: bold;">Managing Director</div>
                                                <div style="font-size: 8pt; color: #555;font-weight: bold;">Authorised Signatory</div>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </body>

    </html>