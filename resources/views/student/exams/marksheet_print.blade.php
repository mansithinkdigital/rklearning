<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Official Marksheet - {{ $user->name }}</title>
    <style>
        @page {
            margin: 0;
            size: a4 portrait;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #fff;
            color: #333;
        }
        .container {
            width: 100%;
            height: 100%;
            padding: 40px;
            box-sizing: border-box;
            position: relative;
            background: #fff;
        }
        .outer-border {
            border: 8px double #1a2a6c;
            height: 100%;
            padding: 5px;
            box-sizing: border-box;
        }
        .inner-border {
            border: 2px solid #b21f1f;
            height: 100%;
            padding: 20px;
            box-sizing: border-box;
            background-color: #fffaf0; /* parchment feel */
            position: relative;
        }
        
        /* Watermark */
        .watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-30deg);
            font-size: 80px;
            color: rgba(0,0,0,0.03);
            font-weight: bold;
            white-space: nowrap;
            z-index: 0;
            pointer-events: none;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
            position: relative;
            z-index: 1;
        }
        .logo-main {
            width: 100px;
            margin-bottom: 10px;
        }
        .institute-name {
            font-size: 42px;
            color: #1a2a6c;
            font-weight: 900;
            margin: 0;
            text-transform: uppercase;
        }
        .tagline {
            font-size: 16px;
            color: #0088cc;
            font-weight: bold;
            margin: 5px 0;
        }
        .govt-info {
            font-size: 12px;
            color: #b21f1f;
            font-weight: bold;
            text-transform: uppercase;
            margin: 5px 0;
        }
        .reg-info {
            font-size: 11px;
            color: #444;
            margin: 5px 0;
        }
        .contact-info {
            font-size: 11px;
            color: #444;
            border-bottom: 3px solid #000;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .marksheet-id-row {
            display: table;
            width: 100%;
            margin-bottom: 15px;
        }
        .ms-id {
            display: table-cell;
            width: 30%;
            font-weight: bold;
            font-size: 14px;
        }
        .ms-title-box {
            display: table-cell;
            width: 40%;
            text-align: center;
        }
        .ms-title {
            background-color: #1a2a6c;
            color: white;
            padding: 8px 30px;
            border-radius: 10px;
            font-size: 24px;
            font-weight: bold;
            display: inline-block;
        }
        .ms-year {
            display: table-cell;
            width: 30%;
            text-align: right;
            font-weight: bold;
            font-size: 13px;
        }

        .photo-container {
            position: absolute;
            top: 240px;
            right: 40px;
            width: 110px;
            height: 130px;
            border: 1px solid #000;
            padding: 2px;
            background: white;
            z-index: 10;
        }
        .photo-container img { width: 100%; height: 100%; object-fit: cover; }

        .student-details {
            margin-top: 20px;
            line-height: 1.8;
            font-size: 15px;
            color: #000;
            position: relative;
            z-index: 1;
        }
        .detail-row { margin-bottom: 8px; font-weight: bold; }
        .detail-value { font-weight: 500; }
        .completed-text {
            color: #b21f1f;
            font-weight: 900;
            font-size: 16px;
        }

        .marks-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            position: relative;
            z-index: 1;
        }
        .marks-table th, .marks-table td {
            border: 2px solid #000;
            padding: 8px;
            text-align: left;
            font-weight: bold;
            font-size: 14px;
        }
        .marks-table th { background-color: #eee; text-align: center; }
        .center-text { text-align: center; }

        .summary-row {
            margin-top: 20px;
            display: table;
            width: 100%;
            font-weight: bold;
            font-size: 15px;
        }
        .summary-item { display: table-cell; }

        .footer {
            position: absolute;
            bottom: 40px;
            width: calc(100% - 40px);
            left: 20px;
        }
        .seal-row {
            display: table;
            width: 100%;
            text-align: center;
        }
        .seal-box {
            display: table-cell;
            width: 33%;
            vertical-align: bottom;
        }
        .seal-img { width: 80px; }
        .signature-line {
            width: 150px;
            border-bottom: 2px solid #000;
            margin: 0 auto 5px;
        }
        .sig-text {
            font-size: 11px;
            font-weight: bold;
            color: #1a2a6c;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="outer-border">
            <div class="inner-border">
                <div class="watermark">RK INSTITUTE SUCCESS</div>

                <div class="header">
                    <img src="{{ public_path('assets/images/logo.png') }}" class="logo-main" alt="Logo">
                    <h1 class="institute-name">RK INSTITUTE</h1>
                    <p class="tagline">Ramesh Kolhe's Learning Hub</p>
                    <p class="govt-info">GOVERNMENT OF INDIA MINISTRY OF CORPORATE AFFAIRS</p>
                    <p class="reg-info">Reg No. U85301MH2023PTC401715</p>
                    <p class="reg-info">Registered office: C 6, Plot No. 7 s, Shree Sai Village, Pathardi Road, Pathardi, Nashik-422010, Maharastra.</p>
                    <p class="contact-info">Email : rklearninghub2023@gmail.com</p>
                </div>

                <div class="marksheet-id-row">
                    <div class="ms-id">Marksheet No. RK{{ date('Y') }}{{ str_pad($user->id, 4, '0', STR_PAD_LEFT) }}</div>
                    <div class="ms-title-box"><div class="ms-title">Marksheet</div></div>
                    <div class="ms-year">Marksheet issued Year {{ date('Y') }}</div>
                </div>

                <div class="photo-container">
                    @if($userPhotoBase64)
                        <img src="{{ $userPhotoBase64 }}" alt="Student">
                    @else
                        <div style="width:100%; height:100%; background:#eee;"></div>
                    @endif
                </div>

                <div class="student-details">
                    <div class="detail-row">This is Certified that Mr/ms : <span class="detail-value">{{ strtoupper($user->name) }}</span></div>
                    <div class="detail-row">Father Name : <span class="detail-value">{{ strtoupper($user->father_name ?? 'NOT DEFINED') }}</span></div>
                    <div class="detail-row">Mother Name : <span class="detail-value">{{ strtoupper($user->mother_name ?? 'NOT DEFINED') }}</span></div>
                    <div class="detail-row">HAS SUCCESSFULLY COMPLETED : <span class="completed-text">{{ strtoupper($course->name) }}</span></div>
                    <div class="detail-row">Centre Name : <span class="detail-value">RK INSTITUTE 1 - Ashok Stumbha, Nashik</span></div>
                    <div class="detail-row" style="margin-top:15px;">Performance in Examination as below</div>
                </div>

                <table class="marks-table">
                    <thead>
                        <tr>
                            <th style="width: 10%;">Sr No.</th>
                            <th style="width: 45%;">Subject</th>
                            <th colspan="2">Total Marks</th>
                            <th style="width: 15%;">Obtain Marks</th>
                        </tr>
                        <tr>
                            <th></th>
                            <th></th>
                            <th style="width: 15%;">Max</th>
                            <th style="width: 15%;">MIN</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @php 
                            $totalMax = 0;
                            $totalMin = 0;
                            $totalObtained = 0;
                        @endphp
                        @foreach($subjects as $index => $subject)
                            @php 
                                $res = $results->get($subject->id);
                                $obtained = $res ? $res->score : 0;
                                $totalMax += $subject->total_marks;
                                $totalMin += $subject->pass_marks;
                                $totalObtained += $obtained;
                            @endphp
                            <tr>
                                <td class="center-text">{{ $index + 1 }}</td>
                                <td>{{ $subject->subject->name }}</td>
                                <td class="center-text">{{ $subject->total_marks }}</td>
                                <td class="center-text">{{ $subject->pass_marks }}</td>
                                <td class="center-text">{{ $obtained }}</td>
                            </tr>
                        @endforeach
                        <tr style="background-color: #eee;">
                            <td colspan="2" style="text-align: right;">TOTAL</td>
                            <td class="center-text">{{ $totalMax }}</td>
                            <td class="center-text">{{ $totalMin }}</td>
                            <td class="center-text">{{ $totalObtained }}</td>
                        </tr>
                    </tbody>
                </table>

                @php 
                    $overallPct = ($totalMax > 0) ? round(($totalObtained / $totalMax) * 100) : 0;
                    $grade = 'F';
                    if($overallPct >= 80) $grade = 'O';
                    elseif($overallPct >= 70) $grade = 'A+';
                    elseif($overallPct >= 60) $grade = 'A';
                    elseif($overallPct >= 50) $grade = 'B';
                    elseif($overallPct >= 40) $grade = 'C';
                @endphp

                <div class="summary-row">
                    <div class="summary-item">Date of issue : {{ date('d/m/Y') }}</div>
                    <div class="summary-item" style="text-align: center;">Overall Percentage : {{ $overallPct }}%</div>
                    <div class="summary-item" style="text-align: right;">Grade : {{ $grade }}</div>
                </div>

                <div class="footer">
                    <div class="seal-row">
                        <div class="seal-box">
                            <img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png" class="seal-img" alt="ISO">
                            <div class="sig-text" style="color: #b21f1f;">ISO 9001:2015<br>Certified Company</div>
                        </div>
                        <div class="seal-box">
                            <img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png" class="seal-img" alt="Seal">
                            <div class="sig-text">INSTITUTE<br>OFFICIAL SEAL</div>
                        </div>
                        <div class="seal-box">
                            <div class="signature-line"></div>
                            <div class="sig-text">Managing Director<br>Authorised Signatory</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
