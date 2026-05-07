@php
function getBase64($path) {
if (file_exists(public_path($path))) {
$data = file_get_contents(public_path($path));
$type = pathinfo(public_path($path), PATHINFO_EXTENSION);
return 'data:image/' . $type . ';base64,' . base64_encode($data);
}
return null;
}
$background = getBase64('assets/certificate/marksheet.jpeg');

// For student photo
$userPhotoBase64 = null;
if (isset($user->profile_photo_path)) {
$userPhotoBase64 = getBase64('storage/' . $user->profile_photo_path);
}
@endphp

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
            font-family: 'Times New Roman', Times, serif;
            margin: 0;
            padding: 0;
            background-color: #fff;
            color: #000;
            font-size: 11pt;
        }

        .wrapper {
            width: 210mm;
            height: 297mm;
            margin: 0 auto;
            position: relative;
            background-image: url('{{ $background }}');
            background-size: 100% 100%;
            background-repeat: no-repeat;
            overflow: hidden;
        }

        /* Container for all dynamic values */
        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            box-sizing: border-box;
            pointer-events: none;
        }

        /* Dynamic Field Styling */
        .field {
            position: absolute;
            font-weight: normal;
            font-size: 11pt;
            color: #000;
        }

        /* Positioning specific fields - Adjust these to match your background image */
        #marksheet-no {
            top: 66.5mm;
            left: 43mm;
            color: #d41a1a;
        }

        #issued-year {
            top: 78.5mm;
            left: 104mm;
            text-align: center;
            width: 40mm;
            font-size: 10pt;
        }

        #student-name {
            top: 112.4mm;
            left: 72mm;
            width: 100mm;
            text-transform: uppercase;
        }

        #mother-name {
            top: 119.5mm;
            left: 43mm;
            width: 100mm;
            text-transform: uppercase;
        }

        #course-name {
            top: 127mm;
            left: 67mm;
            width: 100mm;
            text-transform: uppercase;
        }

        #centre-name {
            top: 134mm;
            left: 43mm;
            width: 130mm;
            text-transform: uppercase;
        }

        .photo-area {
            position: absolute;
            top: 74mm;
            right: 20mm;
            width: 30mm;
            height: 38mm;
        }

        .student-photo {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border: 1px solid #000;
        }

        /* Marks Table Positioning */
        .table-container {
            position: absolute;
            top: 148mm;
            left: 17mm;
            right: 15mm;
        }

        .marks-table {
            width: 100%;
            border-collapse: collapse;
            background-color: transparent;
        }

        .marks-table th,
        .marks-table td {
            border: 1.5px solid #000;
            /* Slightly thicker borders like in the image */
            padding: 1.5mm;
            font-size: 11pt;
            text-align: center;
            font-weight: bold;
        }

        .marks-table td.subject-name {
            text-align: left;
            padding-left: 4mm;
        }

        .total-row {
            background-color: transparent;
        }

        /* Footer Values Styling */
        .footer-stats {
            margin-top: 5mm;
            width: 100%;
            display: flex;
            justify-content: space-between;
        }

        .footer-item {
            font-weight: bold;
            font-size: 11pt;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <div class="overlay">
            <!-- Dynamic Values -->
            <div id="marksheet-no" class="field">RK{{ date('Y') }}{{ str_pad($user->id, 4, '0', STR_PAD_LEFT) }}</div>
            <div id="issued-year" class="field">{{ date('Y') }}</div>

            <div id="student-name" class="field">{{ strtoupper($user->name) }}</div>
            <div id="mother-name" class="field">{{ strtoupper($user->mother_name ?? 'N/A') }}</div>
            <div id="course-name" class="field">{{ strtoupper($course->name) }}</div>
            <div id="centre-name" class="field">{{ strtoupper(data_get($user, 'branch.branch_name', 'RK INSTITUTE 1 - Ashok Stumbha, Nashik')) }}</div>

            <!-- Student Photo -->
            <div class="photo-area">
                <img src="{{ asset($user->image) }}" class="student-photo" alt="Student Photo">
            </div>

            <!-- Marks Table -->
            <div class="table-container">
                <table class="marks-table">
                    <thead>
                        <tr>
                            <th rowspan="2" style="width: 10%;">Sr No.</th>
                            <th rowspan="2" style="width: 40%;">Subject</th>
                            <th colspan="2" style="width: 30%;">Total Marks</th>
                            <th rowspan="2" style="width: 20%;">Obtain Marks</th>
                        </tr>
                        <tr>
                            <th style="width: 15%;">Max</th>
                            <th style="width: 15%;">MIN</th>
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
                            <td class="subject-name">{{ $subject->subject->name }}</td>
                            <td>{{ $subject->total_marks }}</td>
                            <td>{{ $subject->pass_marks }}</td>
                            <td>{{ $obt }}</td>
                        </tr>
                        @endforeach
                        <tr class="total-row">
                            <td></td>
                            <td style="text-align: center;">TOTAL</td>
                            <td>{{ $totalMax }}</td>
                            <td>{{ $totalMin }}</td>
                            <td>{{ $totalObt }}</td>
                        </tr>
                    </tbody>
                </table>
                <!-- Footer Stats -->
                @php
                $pct = $totalMax ? round(($totalObt / $totalMax) * 100) : 0;
                $grade = 'D'; // User wants to hide Fail, and they must pass to see this
                if($pct >= 90) $grade = 'O';
                elseif($pct >= 75) $grade = 'A+';
                elseif($pct >= 60) $grade = 'A';
                elseif($pct >= 55) $grade = 'B+';
                elseif($pct >= 50) $grade = 'B';
                elseif($pct >= 45) $grade = 'C';
                elseif($pct >= 40) $grade = 'D';
                @endphp

                <div class="footer-stats">
                    <div class="footer-item" style="text-align: left;">Date of issue : {{ date('d/m/Y') }}</div>
                    <div class="footer-item" style="text-align: center;">Overall Percentage : {{ $pct }}%</div>
                    <div class="footer-item" style="text-align: right;">Grade : {{ $grade }}</div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>