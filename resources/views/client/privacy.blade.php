@extends('layouts.client')
@section('title', 'Privacy Policy - RK Institute of Commerce')

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
    <!-- HERO -->
    <section class="contact-hero py-28 md:py-36 overflow-hidden">
        <div class="container mx-auto px-6 relative z-10 text-center">
            <p class="section-tag text-sm uppercase font-black text-amber-400 mb-5">
                Privacy Policy
            </p>

            <h1 class="text-5xl md:text-7xl font-black text-white leading-tight mb-8">
                Privacy
                <span class="text-amber-400">Policy</span>
            </h1>

            <p class="text-slate-300 text-xl max-w-3xl mx-auto leading-relaxed">
                We value your trust and are committed to protecting your privacy,
                personal information, and learning experience.
            </p>
        </div>
    </section>

    <!-- PRIVACY CONTENT -->
    <section class="py-11 bg-slate-60">
        <div class="container mx-auto px-6">
            <div class="max-w-6xl mx-auto policy-card p-8 md:p-14">                
                <div class="policy-content">                   
                <p><b>Overview</b></p>
                    <p>
                        We take your privacy seriously and are committed to protecting your right to privacy as a user of our website.
                        We have made every effort to ensure your information is secure. This privacy policy information covers what
                        information is collected, what we do with it, and what you can do about it. You can use this information to
                        make your decisions about your privacy.
                    </p>
                    <p><b>User ID and Password</b></p>
                    <p>
                        By entering into this Agreement, you acknowledge and agree that Your user ID and password
                        ("Participant Account") is for Your exclusive use only. Use or sharing of Your Participant
                        Account with another user is not permitted and is cause for immediate blocking of Your access
                        to the Website, the Services and the Content, the Lecture videos, and termination of this Agreement.
                    </p>
                    <p>
                        You agree that You are solely responsible for maintaining the confidentiality of Your Participant
                        Account and for all activities that occur under it.
                    </p>
                    <p>
                        You agree to immediately notify our Customer Support Team at
                        <span class="font-semibold text-blue-700">support@rkinstitute.com</span>
                        if You become aware of or have reason to believe that there is any unauthorized use of Your
                        Participant Account.
                    </p>
                    <p><b>Content and Lecture Videos</b></p>
                    <p>
                        As a part of our Services offered through our Website, we shall grant you access to our content,
                        Lecture Videos, and other information, documents, and data which may be in audio, video, written,
                        graphic, recorded, photographic, or any machine-readable format in relation to the specific certification
                        training course you have registered for.
                    </p>
                    <p>
                        We reserve the right to amend, revise or update the Content and Lecture videos offered to You.
                        In the event such an amendment, revision or updation occurs, you can access these, without any
                        additional cost during the validity of the subscription.
                    </p>
                    <p>
                        If you are provided with an option to download the content with various degrees of control on web
                        or apps during the period of validity of your paid subscription, you will not be able to access the
                        downloaded content after the termination of your subscription.
                    </p>
                    <p><b>Usage of the Website and Services</b></p>
                    <p>
                        We grant you a personal, restricted, non-transferable, non-exclusive, and revocable license to use
                        the Website, the Services, and the Content and Lecture videos offered through the Website till the
                        predefined time of the completion of the course that You have enrolled for.
                    </p>
                    <p>
                        You are not permitted to reproduce, transmit, distribute, sub-license, broadcast, disseminate,
                        or prepare derivative works of the Content and Lecture videos without Our prior written consent.
                    </p>
                    <p><b>Intellectual Property Rights</b></p>
                    <p>
                        While You are granted a limited and non-exclusive right to use the Website, the Services,
                        and the Content and Lecture Videos for the Restricted Purpose as set forth in this Agreement,
                        You acknowledge and agree that We are the sole and exclusive owner of the Website,
                        the Services and the Content and Lecture videos.
                    </p>
                    <p><b>Usage of Personal Information of Participants</b></p>
                    <p>
                        We reserve the right to feature Your picture in any photos, videos, or other promotional
                        material used by Us. Further, We may use Your personal information to inform You about
                        upcoming lecture videos offered by Us.
                    </p>
                    <p>
                        However, We shall not distribute or share Your personal information with any third party
                        marketing database or disclose Your personal information to any third party except on
                        a case-to-case basis after proper verification or if required under applicable law.
                    </p>
                    <p><b>Limitation of Liability</b></p>
                    <p>
                        You expressly agree that use of the Website, the Services, and the Content and Lecture videos
                        are at Your sole risk. We are not liable for any damages or injury caused by any failure of performance,
                        error, interruption, virus, communication line failure, theft, or unauthorized access.
                    </p>
                    <p><b>Term and Termination</b></p>
                    <p>
                        This Agreement will become effective upon Your acceptance of the terms and conditions and
                        will remain in effect till You maintain a current, fully paid up online Participant Account,
                        or until terminated by Us, whichever is earlier.
                    </p>
                    <p>
                        We reserve the right to terminate this Agreement and block Your access to the Content and
                        Lecture videos with immediate effect in the event of misrepresentation, misconduct,
                        or breach of obligations.
                    </p>
                    <p><b>Indemnity</b></p>
                    <p>
                        You agree to indemnify and hold Us, Our contractors, licensors, directors, officers,
                        employees, and agents harmless from any claims, losses, damages, liabilities,
                        and expenses arising out of unauthorized use of the Website or Services.
                    </p>
                    <p><b>Waiver</b></p>
                    <p>
                        Neither failure nor delay on the part of any party to exercise any right, remedy,
                        power, or privilege hereunder shall operate as a waiver thereof.
                    </p>
                    <p><b>Severability</b></p>
                    <p>
                        In the event any provision of this Agreement is held invalid or unenforceable under
                        applicable laws of India, the remaining provisions shall continue in full force and effect.
                    </p>
                    <p><b>Amendment and Assignment</b></p>
                    <p>
                        We reserve the right to unilaterally amend or modify this Agreement without prior notification.
                        Revised agreements will be published on the Website.
                    </p>
                    <p>
                        You are not permitted to assign this Agreement or the rights and obligations mentioned
                        in this Agreement to any third party.
                    </p>
                    <p><b>Entire Agreement</b></p>
                    <p>
                        This Agreement, along with the Privacy Policy, Refund Policy, Rescheduling Policy,
                        Terms of Use, and any additional guidelines posted on the Website constitutes the
                        entire agreement governing Your use of our Website.
                    </p>
                    <p class="font-bold text-slate-900 text-lg">
                        Note: By clicking “I Agree” button, You are agreeing to all our Policies
                        as listed on the website.
                    </p>
                </div>
            </div>
        </div>
    </section>

</main>
@endsection