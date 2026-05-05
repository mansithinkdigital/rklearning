<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Certificate of Completion - {{ $user->name }}</title>
    @php
    $bgPath = public_path('assets/certificate/RK Learning Certificates.png');
    $bgBase64 = '';
    if (file_exists($bgPath)) {
    $bgData = file_get_contents($bgPath);
    $bgBase64 = 'data:image/jpeg;base64,' . base64_encode($bgData);
    }

    $logoPath = public_path('assets/certificate/Rk Logo.jpg');
    $logoBase64 = '';
    if (file_exists($logoPath)) {
    $logoData = file_get_contents($logoPath);
    $logoBase64 = 'data:image/jpeg;base64,' . base64_encode($logoData);
    }

    // Skills List
    $subjects = \App\Models\CourseSubject::where('course_id', $course->id)->with('subject')->get();
    $skillsList = $subjects->pluck('subject.name')->implode(', ');
    if (empty($skillsList)) {
    $skillsList = 'Accounting Fundamentals, Tally Prime Software, GST, Inventory Management, Payroll Management, Financial Reporting';
    }

    // Student Photo Fallback
    if (!isset($userPhotoBase64) || !$userPhotoBase64) {
    $userPhotoBase64 = null;
    }
    @endphp
    <style>
        @page {
            margin: 0;
            size: a4 landscape;
        }

        body {
            font-family: 'Times New Roman', Times, serif;
            margin: 0;
            padding: 0;
            background-color: #fff;
            color: #0f2441;
        }

        .wrapper {
            width: 297mm;
            height: 210mm;
            position: relative;
            background-image: url('{{ $bgBase64 }}');
            background-size: 100% 100%;
            background-repeat: no-repeat;
            box-sizing: border-box;
            overflow: hidden;
        }

        .student-name {
            position: absolute;
            top: 69mm;
            left: 20mm;
            right: 0;
            text-align: center;
            font-size: 22pt;
            font-weight: bold;
            color: #0f2441;
            text-transform: uppercase;
        }

        .course-name {
            position: absolute;
            top: 92mm;
            /* Let's use 55mm so it doesn't overlap Name too much */
            left: 65mm;
            right: 0;
            text-align: center;
            max-width: 650px;
            font-size: 18pt;
            font-weight: bold;
            color: #c56b27;
            text-transform: uppercase;
        }

        .period-text {
            position: absolute;
            top: 111mm;
            left: 50mm;
            right: 0;
            text-align: center;
            font-size: 14pt;
            color: #0f2441;
        }

        .skills-text {
            position: absolute;
            max-width: 650px;
            top: 117mm;
            left: 63mm;
            right: 15%;
            text-align: center;
            font-size: 11pt;
            color: #555;
            line-height: 1.4;
        }

        .cert-id {
            position: absolute;
            top: 100mm;
            left: 16mm;
            width: 45mm;
            text-align: center;
            font-size: 11pt;
            font-weight: bold;
            color: #0f2441;
        }

        .photo-box {
            position: absolute;
            top: 78mm;
            right: 22mm;
            width: 35mm;
            height: 42mm;
            border: 1px solid #0f2441;
            background: #fff;
        }

        .photo-img {
            width: 105%;
            height: 100%;
            object-fit: cover;
        }

        .date-text {
            position: absolute;
            top: 136.5mm;
            left: 75mm;
            text-align: center;
            font-size: 11pt;
            font-weight: bold;
            color: #0f2441;
        }

        .month-text {
            position: absolute;
            top: 136.5mm;
            left: 88mm;
            text-align: center;
            font-size: 11pt;
            font-weight: bold;
            color: #0f2441;
        }

        .year-text {
            position: absolute;
            top: 136.5mm;
            left: 99mm;
            text-align: center;
            font-size: 11pt;
            font-weight: bold;
            color: #0f2441;
        }


        .branch {
            position: absolute;
            top: 145mm;
            left: 74mm;
            text-align: center;
            font-size: 10pt;
            font-weight: bold;
            color: #0f2441;
        }

        .website {
            position: absolute;
            bottom: 14mm;
            right: 109mm;
            font-size: 9pt;
            color: #0f2441;
            font-weight: bold;
            z-index: 1000;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <div class="student-name">
            {{ strtoupper($user->name) }}
        </div>

        <div class="course-name">
            {{ strtoupper($course->name) }}
        </div>

        <div class="period-text">
            {{ $enrollDate }}&nbsp;&nbsp; to &nbsp;&nbsp;{{ date('d/m/Y') }}
        </div>

        <div class="date-text">
            {{ date('d') }}
        </div>

        <div class="month-text">
            {{ date('m') }}
        </div>

        <div class="year-text">
            {{ date('Y') }}
        </div>

        <div class="skills-text">
            <b>During this course, the student has gained knowledge in:</b> {{ $skillsList }}
        </div>

        <div class="cert-id">
            {{ $certificateNo ?? (date('Ym') . '-' . rand(1000, 9999)) }}
        </div>

        <div class="branch">
            {{ strtoupper(optional($user->branch)->branch_name ?? 'Main Branch') }}
        </div>

        @if($userPhotoBase64)
        <div class="photo-box">
            <img src="{{ $userPhotoBase64 }}" class="photo-img">
        </div>
        @endif


        <div class="website">
            <a href="https://www.rklearning.in" target="_blank">www.rklearning.in</a>
        </div>
    </div>
</body>

</html>