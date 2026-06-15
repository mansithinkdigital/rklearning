@extends('layouts.client')
@section('title', 'Refund and Cancellation Policy - RK Institute of Commerce')

@section('styles')
<style>
    :root {
        --rk-primary: #0f2d62;
        --rk-secondary: #0f172a;
        --rk-accent: #d4a437;
        --rk-border: #e2e8f0;
    }

    .contact-hero {
        background:
            linear-gradient(rgba(2, 6, 23, .88), rgba(15, 23, 42, .92)),
            url('https://images.unsplash.com/photo-1522202176988-66273c2fd55f?auto=format&fit=crop&w=1600&q=80');
        background-size: cover;
        background-position: center;
        position: relative;
    }

    .contact-hero::before {
        content: '';
        position: absolute;
        inset: 0;
        background:
            radial-gradient(circle at top left, rgba(59, 130, 246, .18), transparent 30%),
            radial-gradient(circle at bottom right, rgba(245, 158, 11, .18), transparent 25%);
    }

    .policy-card {
        background: #ffffff;
        border-radius: 28px;
        border: 1px solid var(--rk-border);
        box-shadow: 0 20px 60px rgba(15, 23, 42, .06);
    }

    .policy-content p {
        color: #475569;
        line-height: 1.5;
        margin-bottom: 20px;
        font-size: 16px;
    }

    .policy-content p b {
        color: #0f172a;
        font-size: 20px;
        display: inline-block;
        margin-bottom: 8px;
    }

    .section-tag {
        letter-spacing: .18em;
    }
</style>
@endsection

@section('content')
<main class="overflow-hidden">
    <section class="contact-hero py-28 md:py-36 overflow-hidden">
        <div class="container mx-auto px-6 relative z-10 text-center">
            <p class="section-tag text-sm uppercase font-black text-amber-400 mb-5">
                Refund & Cancellation
            </p>

            <h1 class="text-5xl md:text-7xl font-black text-white leading-tight mb-8">
                Refund & Cancellation
                <span class="text-amber-400">Policy</span>
            </h1>

            <p class="text-slate-300 text-xl max-w-3xl mx-auto leading-relaxed">
                We strive to provide the best learning experience. Please read our refund and cancellation policy carefully.
            </p>
        </div>
    </section>

    <section class="py-11 bg-slate-60">
        <div class="container mx-auto px-6">
            <div class="max-w-6xl mx-auto policy-card p-8 md:p-14">
                <div class="policy-content">
                    <p><b>Overview</b></p>
                    <p>
                        At RK Institute, we are committed to providing high-quality educational courses and services.
                        This Refund and Cancellation Policy outlines the terms under which refunds and cancellations
                        are processed for course enrollments and purchases made through our platform.
                    </p>

                    <p><b>Cancellation Policy</b></p>
                    <p>
                        Once a course is purchased and access to the content is granted, cancellations are not permitted.
                        However, if you have not accessed any course content and wish to cancel your enrollment,
                        you may request a cancellation within 24 hours of purchase. All cancellation requests must
                        be submitted in writing to our support team at
                        <span class="font-semibold text-blue-700">Rkinstitute.cm@gmail.com</span>.
                    </p>

                    <p><b>Refund Policy</b></p>
                    <p>
                        We want you to be satisfied with your learning experience. Please review the following
                        refund guidelines:
                    </p>
                    <p>
                        <strong>Full Refund:</strong> A full refund may be issued if the cancellation request is
                        made within 7 days of purchase and the student has accessed less than 10% of the course
                        content. A processing fee of up to 5% may be deducted from the refund amount.
                    </p>
                    <p>
                        <strong>Partial Refund:</strong> If the student has accessed between 10% and 25% of the
                        course content, a partial refund of up to 50% of the course fee may be considered at
                        the discretion of the management.
                    </p>
                    <p>
                        <strong>No Refund:</strong> No refund will be provided if the student has accessed more
                        than 25% of the course content, regardless of the reason. Additionally, no refunds will
                        be issued for courses completed or certificates already generated.
                    </p>

                    <p><b>Refund Exceptions</b></p>
                    <p>
                        Refund requests due to medical emergencies, relocation, or other exceptional circumstances
                        will be reviewed on a case-by-case basis. Supporting documentation (such as medical
                        certificates or proof of relocation) must be provided for such requests. The management
                        reserves the right to approve or deny such requests at its sole discretion.
                    </p>

                    <p><b>Refund Processing Time</b></p>
                    <p>
                        Once a refund is approved, it will be processed within 10-15 business days. The refund
                        will be credited back to the original payment method used during the purchase. Please note
                        that the time taken for the refund amount to reflect in your account may vary depending
                        on your bank or payment service provider.
                    </p>

                    <p><b>Course Changes and Modifications</b></p>
                    <p>
                        RK Institute reserves the right to modify, update, or discontinue any course or its content
                        at any time. In the event that a course is discontinued before completion, enrolled students
                        will be offered an alternative course of equivalent value or a pro-rata refund of the
                        course fee.
                    </p>

                    <p><b>Duplicate Payments</b></p>
                    <p>
                        In the event of a duplicate payment made by the student for the same course, the duplicate
                        amount will be refunded in full within 10-15 business days upon verification. The student
                        must notify the support team immediately about the duplicate transaction.
                    </p>

                    <p><b>How to Request a Refund or Cancellation</b></p>
                    <p>
                        To request a refund or cancellation, please follow these steps:
                    </p>
                    <ul class="list-disc pl-6 space-y-2 text-slate-600 mb-6">
                        <li>Send an email to <span class="font-semibold text-blue-700">Rkinstitute.cm@gmail.com</span> with the subject line "Refund Request - [Your Order ID]".</li>
                        <li>Include your full name, registered email address, course name, and order details in the email.</li>
                        <li>Provide a brief reason for the refund or cancellation request.</li>
                        <li>Our support team will review your request and respond within 3-5 business days.</li>
                    </ul>

                    <p><b>Contact Us</b></p>
                    <p>
                        If you have any questions or concerns regarding this Refund and Cancellation Policy,
                        please feel free to contact us:
                    </p>
                    <ul class="list-disc pl-6 space-y-2 text-slate-600 mb-6">
                        <li>Email: <span class="font-semibold text-blue-700">Rkinstitute.cm@gmail.com</span></li>
                        <li>Phone: <span class="font-semibold text-blue-700">+91 8888937680</span></li>
                        <li>Address: Near Maharashtra Book House, Lonar Lane, Ashok Stambha, RK, Nashik</li>
                    </ul>

                    <p class="font-bold text-slate-900 text-lg">
                        Note: By enrolling in any course at RK Institute, you agree to abide by this Refund and
                        Cancellation Policy. We reserve the right to update or modify this policy at any time
                        without prior notice.
                    </p>
                </div>
            </div>
        </div>
    </section>

</main>
@endsection