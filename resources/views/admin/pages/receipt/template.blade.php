<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Receipt - {{ $receipt_no }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 13px;
            color: #1a1a1a;
            margin: 0;
            padding: 20px;
        }

        .container {
            border: 2px solid #000;
            padding: 10px;
            width: 100%;
        }

        .header {
            text-align: center;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
            margin-bottom: 10px;
        }

        .rk-institute {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 2px;
        }

        .learning-hub {
            font-size: 12px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .reg-details {
            font-size: 12px;
            margin-bottom: 2px;
        }

        .branch-box {
            display: table;
            width: 100%;
            border-top: 1px solid #000;
            border-bottom: 1px solid #000;
            margin-bottom: 10px;
        }

        .branch-col {
            display: table-cell;
            width: 50%;
            padding: 5px;
            border-right: 1px solid #000;
            font-size: 10px;
            vertical-align: top;
        }

        .branch-col:last-child {
            border-right: none;
        }

        .details-row {
            margin-bottom: 15px;
            overflow: hidden;
        }

        .receipt-no {
            float: left;
            font-weight: bold;
        }

        .receipt-no span {
            color: red;
            font-size: 18px;
        }

        .date {
            float: right;
            font-weight: bold;
        }

        .student-name {
            margin-top: 10px;
            padding-bottom: 5px;
            border-bottom: 1px solid #000;
            font-weight: bold;
        }

        .fees-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            border: 1px solid #000;
        }

        .fees-table th,
        .fees-table td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }

        .fees-table th {
            background-color: #f2f2f2;
        }

        .particulars-col {
            height: 250px;
            vertical-align: top;
        }

        .footer-row {
            margin-top: 10px;
            border-top: 2px solid #000;
            padding-top: 10px;
        }

        .total-row {
            text-align: right;
            font-weight: bold;
            padding: 5px;
            border-bottom: 2px solid #000;
        }

        .signatures {
            margin-top: 30px;
            display: table;
            width: 100%;
        }

        .sig-col {
            display: table-cell;
            width: 50%;
            font-weight: bold;
        }

        .sig-student {
            text-align: right;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <div class="rk-institute">RK INSTITUTE</div>
            <div class="learning-hub">RAMESH KOLHE'S LEARNING HUB PVT. LTD.</div>
            <div class="reg-details">
                Reg. Add. C6, Plot No. 7S, Shree Sai Village, Pathardi Road, Pathardi, Nashik 422009 Mob. 8275468369<br>
                CIN : U85301MH2023PTC401715
            </div>
        </div>
        <div style="border-top: 1px solid #000; border-bottom: 1px solid #000; margin-bottom: 10px; padding: 5px; text-align: center;">
            <div style="font-weight: bold; font-size: 11px; margin-bottom: 2px; text-transform: uppercase; letter-spacing: 1px;">Branch Address</div>
            <div style="font-size: 10px;">Near New India Book House, Lonar Lane Ravivar Peth, Nashik - 422002</div>
        </div>
        <table style="width: 100%; margin-bottom: 15px; border-bottom: 1px solid #000; padding-bottom: 5px;">
            <tr>
                <td style="width: 40%; font-weight: bold;">
                    Receipt No. <span style="color: red; font-size: 18px;">{{ $receipt_no }}</span>
                </td>
                <td style="width: 30%; text-align: center;">
                    Branch: <strong>{{ $branch_name }}</strong>
                </td>
                <td style="width: 30%; text-align: right; font-weight: bold;">
                    Date: {{ $date }}
                </td>
            </tr>
        </table>

        <table style="width: 100%; border-bottom: 2px solid #000; padding-bottom: 5px; margin-bottom: 10px;">
            <tr>
                <td style="width: 130px; font-size: 15px; font-weight: bold; white-space: nowrap;">Name of Students :-</td>
                <td style="font-size: 15px; font-weight: normal; padding-left: 10px;">{{ $student_name }}</td>
            </tr>
        </table>
        <table class="fees-table">
            <thead>
                <tr>
                    <th style="width: 10%;">Sr.No</th>
                    <th style="width: 70%;">Particulars</th>
                    <th style="width: 20%;">Amount (INR)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td class="particulars-col">
                        <div style="font-size: 14px; font-weight: bold; margin-bottom: 5px;">{{ $course_name }} Coaching Fees</div>
                        <div style="font-size: 11px; color: #555;">Full enrollment for the selected academic duration.</div>
                    </td>
                    <td>{{ number_format($amount, 2) }}</td>
                </tr>
            </tbody>
        </table>
        <div class="total-row">
            Total Fee Received: <strong>INR {{ number_format($amount, 2) }}</strong>
        </div>
        <div style="margin-top: 15px;">
            <div style="float: left; width: 50%;">Paid By: <strong>{{ $payment_method }}</strong></div>
            <div style="float:right; width: 50%; text-align: right;">Remaining Fee: <strong>INR {{ number_format($balance_amount, 2) }}</strong></div>
        </div>
        <table style="width: 100%; margin-top: 50px;">
            <tr>
                <td style="width: 50%; font-weight: bold;">Sign of Centre Head</td>
                <td style="width: 50%; font-weight: bold; text-align: right;">Sign of Students</td>
            </tr>
        </table>
    </div>
</body>

</html>