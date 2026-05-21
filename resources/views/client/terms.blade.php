@extends('layouts.client')
@section('title', 'Terms & Conditions - RK Institute of Commerce')

@section('styles')
    <style>
        :root {
            --rk-primary: #0f2d62;
            --rk-secondary: #0f172a;
            --rk-accent: #d4a437;
            --rk-border: #e2e8f0;
        }

        .terms-hero {
            background:
                linear-gradient(rgba(2, 6, 23, .88), rgba(15, 23, 42, .92)),
                url('https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&w=1600&q=80');
            background-size: cover;
            background-position: center;
            position: relative;
        }

        .terms-hero::before {
            content: '';
            position: absolute;
            inset: 0;
            background:
                radial-gradient(circle at top left, rgba(59, 130, 246, .18), transparent 30%),
                radial-gradient(circle at bottom right, rgba(245, 158, 11, .18), transparent 25%);
        }

        .terms-card {
            background: #ffffff;
            border-radius: 28px;
            border: 1px solid var(--rk-border);
            box-shadow: 0 20px 60px rgba(15, 23, 42, .06);
        }

        .terms-content p {
            color: #475569;
            line-height: 1.7;
            margin-bottom: 20px;
            font-size: 16px;
        }

        .terms-content p b {
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
        <!-- HERO -->
        <section class="terms-hero py-28 md:py-36 overflow-hidden">
            <div class="container mx-auto px-6 relative z-10 text-center">
                <p class="section-tag text-sm uppercase font-black text-amber-400 mb-5">
                    Terms & Conditions
                </p>
                <h1 class="text-5xl md:text-7xl font-black text-white leading-tight mb-8">
                    Terms &
                    <span class="text-amber-400">Conditions</span>
                </h1>
                <p class="text-slate-300 text-xl max-w-3xl mx-auto leading-relaxed">
                    Please read our terms carefully before using our website,
                    services, educational content, and learning platform.
                </p>
            </div>
        </section>

        <!-- TERMS CONTENT -->
        <section class="py-12 bg-slate-60">
            <div class="container mx-auto px-6">
                <div class="max-w-6xl mx-auto terms-card p-8 md:p-14">
                    <div class="terms-content">
                        <p><b>Account:</b></p>
                        <p>
                            In order to use certain features of the Website, you must register for an account.
                            You may be asked to provide a password in connection with your account.
                            You are solely responsible for maintaining the confidentiality of your account
                            and password, and you agree to accept responsibility for all activities that
                            occur under your account or password.
                        </p>
                        <p>
                            The information you provide to Ramesh Kolhe's Learning Hub, whether at registration
                            or at any other time, will be true, accurate, current, and complete.
                        </p>
                        <p>
                            If you have reason to believe that your account is no longer secure,
                            then you should immediately notify Ramesh Kolhe's Learning Hub at
                            <span class="font-semibold text-blue-700">
                                rkinstitute1.o@gmail.com
                            </span>.
                        </p>
                        <p><b>Modification of the Terms</b></p>
                        <p>
                            Ramesh Kolhe's Learning Hub reserves the right, at our discretion,
                            to change, modify, add, or remove portions of the Terms at any time.
                            Please check the Terms and any Guidelines periodically for changes.
                        </p>
                        <p>
                            The schedule of uploading of videos announced in advance is indicative
                            in nature only and may be modified depending on future circumstances.
                        </p>
                        <p>
                            Your continued use of the Website after the posting of changes
                            constitutes your binding acceptance of such changes.
                        </p>
                        <p>
                            Such amended terms will be effective against you on the earlier of
                            your actual notice of such changes or thirty days after notice is provided.
                        </p>
                        <p>
                            Disputes arising under these Terms will be resolved in accordance with
                            the version of the Terms in place at the time the dispute arose.
                        </p>
                        <p><b>Proprietary Materials & Licences</b></p>
                        <p><b>Proprietary Materials:</b></p>
                        <p>
                            The Website is owned and operated by Ramesh Kolhe's Learning Hub.
                            The visual interfaces, graphics, design, educational videos,
                            software, and all other elements of the Website are protected by
                            copyright, patent, trademark, and intellectual property laws.
                        </p>
                        <p><b>Licensed Educational Content:</b></p>
                        <p>
                            Ramesh Kolhe's Learning Hub may make available educational videos,
                            exercises, and supplementary materials owned by the organization
                            or its third-party licensors.
                        </p>
                        <p>
                            You are granted a non-exclusive, non-transferable right to access
                            and use the Licensed Educational Content solely for personal,
                            non-commercial purposes.
                        </p>
                        <p>
                            Unless expressly permitted, you may not download, distribute,
                            sell, lease, modify, or otherwise provide access to the content
                            to any third party.
                        </p>
                        <p>
                            For Special Subscription Plans, restrictions may apply to the content
                            you can access.
                        </p>
                        <p><b>Other Licenses:</b></p>
                        <p>
                            In certain cases, Licensed Educational Content may be available
                            under other license terms. By using such content, you agree to comply
                            fully with those terms and conditions.
                        </p>
                        <p><b>Termination</b></p>
                        <p><b>Termination by Ramesh Kolhe's Learning Hub:</b></p>
                        <p>
                            Ramesh Kolhe's Learning Hub may terminate your account or access
                            to the Website at any time, with or without notice, for any reason.
                        </p>
                        <p>
                            Any suspected fraudulent, abusive, or illegal activity may be referred
                            to appropriate law enforcement authorities.
                        </p>
                        <p>
                            The Website does not permit copyright, trademark, or intellectual
                            property infringing activities and may terminate repeat offenders.
                        </p>
                        <p><b>Termination by You:</b></p>
                        <p>
                            If you are dissatisfied with the Website, Terms, policies, or services,
                            you may terminate your account at any time by discontinuing use
                            of the Website.
                        </p>
                        <p><b>Prohibited Conduct</b></p>
                        <p><b>YOU AGREE NOT TO:</b></p>
                        <p>1. Use the Website for any commercial purpose unless expressly permitted.</p>
                        <p>2. Impersonate any person or entity or perform fraudulent activities.</p>
                        <p>3. Delete copyright or proprietary notices from the Website.</p>
                        <p>4. Assert intellectual property infringement claims against the organization.</p>
                        <p>5. Send spam, advertisements, or promotional materials to other users.</p>
                        <p>6. Use the Website for illegal purposes or in violation of applicable laws.</p>
                        <p>7. Defame, harass, abuse, threaten, or collect personal information without consent.</p>
                        <p>8. Interfere with security-related features of the Website.</p>
                        <p>9. Reverse engineer, decompile, or disassemble the Website.</p>
                        <p>10. Modify, adapt, translate, or create derivative works of the Website.</p>
                        <p>11. Upload viruses, spyware, malicious code, or disrupt Website functionality.</p>
                        <p class="font-semibold text-slate-900">
                            Note: By clicking the “I Accept” button, you are agreeing to the
                            Terms & Conditions as well as the Privacy Policy.
                        </p>
                        <p><b>Disputes:</b></p>
                        <p>
                            In case of any dispute arising out of this Agreement,
                            the same shall be subject to the jurisdiction of the Courts of Lucknow only.
                        </p>
                        <p><b>Disclosures:</b></p>
                        <p>
                            The Website is hosted in India, and the services are offered by
                            RK Institute of Commerce,
                            Near Maharashtra Book House,
                            Lonar Lane, Ashok Stambha,
                            RK, Nashik
                        </p>
                        <p>
                            Email:
                            <span class="font-semibold text-blue-700">
                                Rkinstitute2026@gmail.com
                            </span>
                        </p>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
