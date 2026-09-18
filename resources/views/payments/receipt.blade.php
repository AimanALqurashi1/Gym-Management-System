<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Payment Receipt - {{ $payment->receipt_number }}</title>
    <style>
        /* Receipt Styles - Clean Print-Ready Design */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            background: white;
            padding: 40px;
        }

        .receipt {
            max-width: 800px;
            margin: 0 auto;
            border: 1px solid #ddd;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        }

        /* Header Section - Keep Orange Gradient for Branding */
        .header {
            background: linear-gradient(135deg, #ff5500, #e04e00);
            color: white;
            padding: 30px;
            text-align: center;
        }

        .header h1 {
            margin-bottom: 10px;
            font-size: 28px;
            letter-spacing: 2px;
        }

        .header p {
            opacity: 0.9;
            margin: 5px 0;
        }

        /* Content Section */
        .content {
            padding: 30px;
        }

        .receipt-title {
            text-align: center;
            margin-bottom: 30px;
        }

        .receipt-title h2 {
            color: #333;
            border-bottom: 3px solid #ff5500;
            display: inline-block;
            padding-bottom: 8px;
        }

        /* Info Rows */
        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 12px;
            padding-bottom: 8px;
            border-bottom: 1px solid #eee;
        }

        .info-label {
            font-weight: bold;
            color: #555;
        }

        .info-value {
            color: #333;
        }

        /* Amount Section */
        .amount-section {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            text-align: center;
        }

        .amount-section .label {
            font-size: 14px;
            color: #666;
            margin-bottom: 5px;
        }

        .amount-section .value {
            font-size: 32px;
            font-weight: bold;
            color: #ff5500;
        }

        /* Course Details */
        .course-section {
            background: #f5f5f5;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
        }

        .course-section h3 {
            color: #333;
            margin-bottom: 15px;
            font-size: 16px;
            border-left: 3px solid #ff5500;
            padding-left: 10px;
        }

        .course-detail-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px dashed #ddd;
        }

        .course-detail-row:last-child {
            border-bottom: none;
        }

        .course-detail-row .label {
            color: #666;
        }

        .course-detail-row .value {
            color: #333;
            font-weight: 500;
        }

        /* Footer */
        .footer {
            text-align: center;
            padding: 20px;
            background: #f9f9f9;
            border-top: 1px solid #eee;
            font-size: 11px;
            color: #999;
        }

        /* Signature Section */
        .signature-section {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px dashed #ddd;
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 20px;
        }

        .signature-box {
            text-align: center;
            width: 200px;
        }

        .signature-line {
            border-top: 1px solid #333;
            margin-top: 30px;
            padding-top: 8px;
            font-size: 11px;
            color: #666;
        }

        .stamp {
            text-align: center;
            margin-top: 20px;
        }

        .stamp span {
            border: 2px solid #ff5500;
            padding: 5px 15px;
            color: #ff5500;
            font-weight: bold;
            font-size: 12px;
            display: inline-block;
            transform: rotate(-10deg);
        }

        /* ADDED: Company Info Section */
        .company-info {
            text-align: center;
            margin-bottom: 20px;
        }

        .company-info .logo {
            font-size: 24px;
            font-weight: bold;
            color: #ff5500;
            margin-bottom: 10px;
        }

        .company-info .address,
        .company-info .contact {
            font-size: 12px;
            color: #666;
            margin: 3px 0;
        }

        /* ADDED: Receipt Number Highlight */
        .receipt-number {
            background: #f8f9fa;
            padding: 8px 15px;
            border-radius: 5px;
            text-align: center;
            margin: 15px 0;
        }

        .receipt-number span {
            font-weight: bold;
            color: #ff5500;
        }

        /* ADDED: Payment Method Icon */
        .payment-method {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .payment-method i {
            color: #ff5500;
            font-size: 1.1rem;
        }

        /* ADDED: QR Code Section (Optional) */
        .qr-section {
            text-align: center;
            margin: 20px 0;
        }

        .qr-section img {
            width: 100px;
            height: 100px;
        }

        .qr-section p {
            font-size: 10px;
            color: #999;
            margin-top: 5px;
        }

        /* Print Styles - Important for Receipt Printing */
        @media print {
            body {
                background: white;
                padding: 0;
                margin: 0;
            }

            .receipt {
                box-shadow: none;
                border: 1px solid #ddd;
                margin: 0;
                max-width: 100%;
            }

            .header {
                background: #ff5500;
                print-color-adjust: exact;
                -webkit-print-color-adjust: exact;
            }

            .amount-section {
                background: #f8f9fa;
                print-color-adjust: exact;
                -webkit-print-color-adjust: exact;
            }

            .stamp span {
                print-color-adjust: exact;
                -webkit-print-color-adjust: exact;
            }

            .no-print {
                display: none;
            }
        }

        /* Responsive for smaller screens */
        @media (max-width: 600px) {
            body {
                padding: 20px;
            }

            .content {
                padding: 20px;
            }

            .info-row {
                flex-direction: column;
                gap: 5px;
            }

            .signature-section {
                flex-direction: column;
                align-items: center;
            }

            .signature-box {
                width: 100%;
            }

            .course-detail-row {
                flex-direction: column;
                gap: 5px;
            }
        }

        /* Animation for receipt load */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .receipt {
            animation: fadeIn 0.3s ease forwards;
        }
    </style>
</head>

<body>
    <div class="receipt">
        <!-- Header -->
        <div class="header">
            <h1>POWERGO GYM</h1>
            <p>Your Fitness Journey Starts Here</p>
            <p>123 Fitness Avenue, Dubai, UAE | Tel: +971 50 123 4567</p>
        </div>

        <div class="content">
            <!-- Title -->
            <div class="receipt-title">
                <h2>PAYMENT RECEIPT</h2>
            </div>

            <!-- Receipt Info -->
            <div class="info-row">
                <span class="info-label">Receipt Number:</span>
                <span class="info-value">{{ $payment->receipt_number }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Payment Date:</span>
                <span class="info-value">{{ \Carbon\Carbon::parse($payment->payment_date)->format('F j, Y') }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Payment Method:</span>
                <span class="info-value">Cash</span>
            </div>
            <div class="info-row">
                <span class="info-label">Transaction ID:</span>
                <span class="info-value">{{ $payment->id }}</span>
            </div>

            <!-- Member Info -->
            <div class="info-row">
                <span class="info-label">Member Name:</span>
                <span class="info-value">{{ $payment->member->name ?? 'N/A' }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Member Code:</span>
                <span class="info-value">{{ $payment->member->code ?? 'N/A' }}</span>
            </div>

            <!-- Amount -->
            <div class="amount-section">
                <div class="label">Amount Paid</div>
                <div class="value">${{ number_format($payment->amount, 2) }}</div>
            </div>

            <!-- Course Details if available -->
            @if (isset($enrollment) && $enrollment)
                <div class="course-section">
                    <h3>Course Information</h3>
                    <div class="course-detail-row">
                        <span>Course Name:</span>
                        <strong>{{ $enrollment->schedule->course->name ?? 'N/A' }}</strong>
                    </div>
                    <div class="course-detail-row">
                        <span>Trainer:</span>
                        <strong>{{ $enrollment->schedule->trainer->name ?? 'N/A' }}</strong>
                    </div>
                    <div class="course-detail-row">
                        <span>Schedule:</span>
                        <strong>{{ ucfirst($enrollment->schedule->day_of_week ?? '') }} at
                            {{ \Carbon\Carbon::parse($enrollment->schedule->start_time ?? '')->format('g:i A') }}</strong>
                    </div>
                    <div class="course-detail-row">
                        <span>Total Amount:</span>
                        <strong>${{ number_format($enrollment->total_amount, 2) }}</strong>
                    </div>
                    <div class="course-detail-row">
                        <span>Amount Paid:</span>
                        <strong>${{ number_format($enrollment->amount_paid, 2) }}</strong>
                    </div>
                    <div class="course-detail-row">
                        <span>Remaining Balance:</span>
                        <strong>${{ number_format($enrollment->total_amount - $enrollment->amount_paid, 2) }}</strong>
                    </div>
                </div>
            @endif

            <!-- Notes -->
            @if ($payment->notes)
                <div class="course-section">
                    <h3>Notes</h3>
                    <p style="color: #555; line-height: 1.6;">{{ $payment->notes }}</p>
                </div>
            @endif

            <!-- Signature Section -->
            <div class="signature-section">
                <div class="signature-box">
                    <div class="signature-line">Member Signature</div>
                </div>
                <div class="signature-box">
                    <div class="signature-line">Authorized Signature</div>
                </div>
            </div>

            <!-- Stamp -->
            <div class="stamp">
                <span>PAID</span>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>Thank you for choosing Yangzhou Gym!</p>
            <p>No signature is required.</p>
            <p>issued on: {{ now()->format('F j, Y g:i A') }}</p>
            <p style="margin-top: 5px;">For any inquiries, please contact us at Yangzhou@gym.com</p>
        </div>
    </div>
</body>

</html>
