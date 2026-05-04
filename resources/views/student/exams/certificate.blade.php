<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Certificate - {{ $user->name }}</title>
    @php
    $bgPath = public_path('assets/certificate/Certificate-template.jpeg');
    if (!file_exists($bgPath)) {
    $bgPath = public_path('assets/certificate/Certificate Blank.jpeg');
    }
    if (!file_exists($bgPath)) {
    $bgPath = public_path('assets/certificate/bg-sertificate.jpeg');
    }
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
    $testImagePath = 'C:\\Users\\ThinkDigital\\.gemini\\antigravity\\brain\\a538b63a-d516-4f0d-909c-b746bcd8eda9\\media__1777377327970.png';
    if (file_exists($testImagePath)) {
    $testImageData = file_get_contents($testImagePath);
    $userPhotoBase64 = 'data:image/png;base64,' . base64_encode($testImageData);
    }
    }
    @endphp
    <style>
        @page {
            margin: 0;
            size: A4 landscape;
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
            top: 45mm;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 24pt;
            font-weight: bold;
            color: #0f2441;
            text-transform: uppercase;
        }

        .course-name {
            position: absolute;
            top: 50mm;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 24pt;
            font-weight: bold;
            color: #c56b27;
            text-transform: uppercase;
        }

        .period-text {
            position: absolute;
            top: 92mm;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 14pt;
            color: #0f2441;
        }

        .skills-text {
            position: absolute;
            top: 100mm;
            left: 15%;
            right: 15%;
            text-align: center;
            font-size: 11pt;
            color: #555;
            line-height: 1.4;
        }

        .cert-id {
            position: absolute;
            top: 103mm;
            left: 22mm;
            width: 45mm;
            text-align: center;
            font-size: 11pt;
            font-weight: bold;
            color: #0f2441;
        }

        .photo-box {
            position: absolute;
            top: 85mm;
            right: 25mm;
            width: 35mm;
            height: 45mm;
            border: 1px solid #0f2441;
            background: #fff;
        }

        .photo-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .rklogo {
            position: absolute;
            top: 25mm;
            left: 20mm;
            width: 30mm;
            height: 30mm;
        }

        img.rklogo {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .website {
            position: absolute;
            top: 175mm;
            left: 50%;
            transform: translateX(-50%);
            font-size: 12pt;
            color: #0f2441;
            font-weight: bold;
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
            during the period from &nbsp;&nbsp;<u>{{ $enrollDate }}</u>&nbsp;&nbsp; to &nbsp;&nbsp;<u>{{ date('d/m/Y') }}</u>&nbsp;&nbsp;
        </div>

        <div class="skills-text">
            <b>During this course, the student has gained knowledge in:</b> {{ $skillsList }}
        </div>

        <div class="cert-id">
            {{ $certificateNo ?? ($course->pivot->certificate_no ?? (date('Ym') . '-' . rand(1000, 9999))) }}
        </div>

        @if($userPhotoBase64)
        <div class="photo-box">
            <img src="{{ $userPhotoBase64 }}" class="photo-img">
        </div>
        @endif

        <div class="rklogo">
            <img src="{{ $logoBase64 }}" class="rklogo">
        </div>

        <div class="website">
            <a href="https://www.rklearning.in" target="_blank">www.rklearning.in</a>
        </div>


    </div>
</body>

</html>