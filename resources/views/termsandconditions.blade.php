@extends('layouts.app')

@section('content')

{{-- @include('includes.header') --}}
<style>
    h2 {
        margin-bottom: 15px !important;
        font-weight: 600;
        font-size:25px;
    }
    h1{
        font-weight: 600;
    }
    ul li {
        color: #000;
        padding-bottom: 5px;
    }
    ul {
        padding-left: 30px;
    }
</style>
<section class="section-p-content pt-4 pb-2 pt-sm-5 pb-sm-4">
    <div class="container">
        <h1 class="text-center mb-4">Terms and Conditions</h1>

        <p>These Terms of Use (&ldquo;Terms&rdquo;) govern access to and use of the ZeroNoticePeriod platform (&ldquo;Platform&rdquo;). By using the Platform, you agree to be bound by these Terms.</p>

        <h2>1. Nature of Platform</h2>
        <p>ZeroNoticePeriod&trade; operates as a technology platform facilitating professional connections between job seekers and recruiters. The Platform does not guarantee employment, candidate selection, or response outcomes.</p>

        <h2>2. User Responsibility &amp; Representations</h2>
        <p>Users agree that:</p>
        <ul>
            <li>All information submitted is accurate, current, and not misleading</li>
            <li>They have the legal capacity to enter into this agreement</li>
            <li>Their use of the Platform will comply with applicable laws, including the Information Technology Act, 2000</li>
        </ul>
        <p>Users are solely responsible for:</p>
        <ul>
            <li>Verifying the authenticity of jobs, employers, and candidates</li>
            <li>Any decisions, actions, or transactions arising from Platform interactions</li>
        </ul>

        <h2>3. Acceptable Use &amp; Restrictions</h2>
        <p>Users shall not:</p>
        <ul>
            <li>Upload or distribute unlawful, abusive, defamatory, or harmful content</li>
            <li>Engage in spam, unsolicited communication, or misleading outreach</li>
            <li>Attempt unauthorized access, scraping, reverse engineering, or data extraction</li>
            <li>Interfere with platform functionality or other users&rsquo; experience</li>
            <li>Misrepresent identity, affiliation, or authority</li>
        </ul>
        <p>Violation may result in suspension, termination, and legal action.</p>

        <h2>4. Data, Content &amp; Intellectual Rights</h2>
        <p>Users retain ownership of their submitted data but grant ZeroNoticePeriod the right to host, display, process, and distribute such data within the Platform ecosystem.</p>
        <p>Users must have necessary rights to all content they upload.</p>
        <p>Unauthorized copying, resale, sublicensing, or commercial exploitation of Platform data is prohibited.</p>

        <h2>5. Resume &amp; Profile Visibility</h2>
        <p>Information shared on the Platform, including resumes and profiles, may be accessed by other users globally. Users are responsible for controlling visibility settings and avoiding disclosure of sensitive information.</p>
        <p>ZeroNoticePeriod does not control third-party usage of publicly accessible data.</p>

        <h2>6. Recruiter &amp; Database Usage</h2>
        <p>Recruiters agree:</p>
        <ul>
            <li>Job listings must be genuine and authorized</li>
            <li>Candidate data will be used strictly for recruitment purposes</li>
            <li>No fees will be charged to candidates for job opportunities sourced through the Platform</li>
            <li>Applicable data protection laws will be followed</li>
        </ul>
        <p>Recruiters act as independent data controllers once data is accessed.</p>

        <h2>7. Payments &amp; Subscriptions</h2>
        <p>Services are provided on a prepaid basis unless otherwise agreed.</p>
        <p>Fees are non-transferable and generally non-refundable, except at Company discretion.</p>
        <p>Service access is limited to the subscription duration and defined usage scope.</p>

        <h2>8. Platform Availability &amp; Liability</h2>
        <p>Services are provided on a best-effort basis. ZeroNoticePeriod:</p>
        <ul>
            <li>Does not guarantee uptime, accuracy, or uninterrupted access</li>
            <li>Is not liable for data loss, delays, or service interruptions beyond reasonable control</li>
            <li>Disclaims responsibility for user interactions, outcomes, or third-party conduct</li>
        </ul>
        <p>Liability, if any, is limited to the fees paid for the relevant service.</p>

        <h2>9. Security &amp; Account Responsibility</h2>
        <p>Users are responsible for maintaining account credentials and all activities conducted under their account. The Company is not liable for misuse resulting from compromised credentials.</p>

        <h2>10. Anti-Spam &amp; Communication Policy</h2>
        <p>The Platform must not be used for:</p>
        <ul>
            <li>Bulk unsolicited communication</li>
            <li>Non-recruitment outreach</li>
            <li>Misleading or fraudulent messaging</li>
        </ul>
        <p>Violation may result in immediate suspension without refund.</p>

        <h2>11. Termination &amp; Enforcement</h2>
        <p>ZeroNoticePeriod may suspend or terminate access:</p>
        <ul>
            <li>For violation of these Terms</li>
            <li>For misuse of services</li>
            <li>At its discretion to protect platform integrity</li>
        </ul>

        <h2>12. Indemnity</h2>
        <p>Users agree to indemnify and hold harmless ZeroNoticePeriod, its affiliates, and representatives from any claims, damages, or liabilities arising from their use of the Platform or breach of these Terms.</p>

        <h2>13. Third-Party Interactions</h2>
        <p>ZeroNoticePeriod is not a party to agreements between users. Any disputes between users must be resolved independently. If the Company is involved in legal proceedings due to user actions, associated costs may be recovered.</p>

        <h2>14. Modifications</h2>
        <p>The Company reserves the right to modify these Terms at any time. Continued use of the Platform constitutes acceptance of updated Terms.</p>

        <h2>15. Governing Law &amp; Dispute Resolution</h2>
        <p>These Terms are governed by the laws of India.</p>
        <p>Disputes shall be resolved through arbitration in Bangalore under the Arbitration &amp; Conciliation Act, 1996.</p>
        <p>Courts in Bangalore shall have exclusive jurisdiction.</p>

        <h2>16. General Provisions</h2>
        <p>The Platform does not provide exclusivity to any user.</p>
        <p>The Company may modify platform features, design, or services without notice.</p>
        <p>No agency relationship is created unless explicitly stated.</p>

        <h2>17. Contact</h2>
        <p>For any queries, users may contact us through official communication channels listed on the Platform.</p>

    </div>
</section>

{{-- @include('includes.footer') --}}

@endsection
