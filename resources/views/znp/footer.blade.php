{{--
    ZNP Footer — standalone blade include.
    CSS is scoped to footer.znp-footer so it never conflicts with Bootstrap.
    Relies on CSS variables defined in znp/header.blade.php (:root).
--}}
<style>
/* ── ZNP FOOTER ── */
footer.znp-footer {
    background: var(--blue);
    padding: 0 40px 24px;
    border-top: 4px solid var(--orange);
    font-family: 'Inter', sans-serif;
}
footer.znp-footer * {
    font-family: 'Inter', sans-serif;
    box-sizing: border-box;
}
footer.znp-footer a { text-decoration: none; }
.znp-footer-inner {
    max-width: 1120px;
    margin: 0 auto;
    padding-top: 44px;
}
.znp-footer-grid {
    display: grid;
    grid-template-columns: 1.8fr 1fr 1fr 1fr;
    gap: 40px;
    margin-bottom: 40px;
}
.znp-footer-brand {
    font-size: 18px;
    font-weight: 800;
    color: #fff;
    margin-bottom: 14px;
}
.znp-footer-brand-text {
    font-size: 42px;
    font-weight: 800;
    letter-spacing: -0.03em;
    line-height: 1;
    display: inline-flex;
    flex-wrap: wrap;
    gap: 0;
}
.znp-footer-brand-text .brand-white { color: #ffffff; }
.znp-footer-brand-text .brand-orange { color: #ffffff; }
.znp-footer-addr {
    font-size: 12.5px;
    color: rgba(255,255,255,0.5);
    line-height: 1.75;
    margin-bottom: 10px;
    margin-top: 0;
}
.znp-footer-email {
    font-size: 12.5px;
    color: var(--orange);
    text-decoration: none;
    font-weight: 600;
}
.znp-footer-email:hover { text-decoration: underline; color: var(--orange); }
.znp-footer-col-title {
    font-size: 11.5px;
    font-weight: 700;
    color: var(--orange);
    text-transform: uppercase;
    letter-spacing: 0.08em;
    margin-bottom: 12px;
    margin-top: 0;
}
.znp-footer-links {
    list-style: none;
    display: flex;
    flex-direction: column;
    gap: 8px;
    padding: 0;
    margin: 0;
}
.znp-footer-links a {
    font-size: 12.5px;
    color: rgba(255,255,255,0.45);
    text-decoration: none;
    transition: color 0.15s;
}
.znp-footer-links a:hover { color: var(--orange); text-decoration: none; }
.znp-footer-bottom {
    border-top: 1px solid rgba(249,115,22,0.35);
    padding-top: 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.znp-footer-copy {
    font-size: 12px;
    color: rgba(255,255,255,0.35);
}
.znp-footer-socials { display: flex; gap: 10px; }
.znp-social-icon {
    width: 40px;
    height: 40px;
    background: rgba(255,255,255,0.10);
    border: 1px solid rgba(255,255,255,0.16);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #ffffff;
    text-decoration: none;
    transition: all 0.15s;
}
.znp-social-icon:hover {
    background: var(--orange);
    color: #fff;
    border-color: var(--orange);
    text-decoration: none;
    transform: translateY(-2px);
}
.znp-footer-logo-link { display: inline-block; text-decoration: none; margin-bottom: 14px; }
.znp-footer-copy-link { color: rgba(255,255,255,0.5); text-decoration: none; }
.znp-footer-copy-link:hover { color: var(--orange); }
.znp-social-img {
    width: 18px;
    height: 18px;
    object-fit: contain;
    display: block;
}
.znp-social-svg{
    width: 18px;
    height: 18px;
    display: block;
}
.footer-brand{
    font-size: 18px;
    font-weight: 800;
    color: #fff;
    margin-bottom: 14px;
    }
@media (max-width: 960px) {
    .znp-footer-grid { grid-template-columns: 1fr 1fr; gap: 28px; }
}
@media (max-width: 600px) {
    footer.znp-footer { padding: 32px 16px 20px; }
    .znp-footer-grid { grid-template-columns: 1fr; }
}
</style>

<footer class="znp-footer">
    <div class="znp-footer-inner">
        <div class="znp-footer-grid">

            <div>
                   <div class="footer-brand">ZeroNoticePeriod</div>
                <p class="znp-footer-addr">Evolve, SNN Raj Serenity, Begur - Koppa Rd,<br>Yelenahalli, Bengaluru, Karnataka 560114</p>
                <a href="mailto:hello@zeronoticeperiod.com" class="znp-footer-email">hello@zeronoticeperiod.com</a>
            </div>

            <div>
                <div class="znp-footer-col-title">Jobs by Metros</div>
                <ul class="znp-footer-links">
                    <li><a href="{{ url('/jobs?location=Bengaluru') }}">Jobs in Bengaluru</a></li>
                    <li><a href="{{ url('/jobs?location=Hyderabad') }}">Jobs in Hyderabad</a></li>
                    <li><a href="{{ url('/jobs?location=Chennai') }}">Jobs in Chennai</a></li>
                    <li><a href="{{ url('/jobs?location=Mumbai') }}">Jobs in Mumbai</a></li>
                    <li><a href="{{ url('/jobs?location=Delhi') }}">Jobs in Delhi</a></li>
                </ul>
            </div>

            <div>
                <div class="znp-footer-col-title">Jobs by Work Mode</div>
                <ul class="znp-footer-links">
                    <li><a href="{{ url('/jobs?searchfield=Hybrid') }}">Jobs (Hybrid)</a></li>
                    <li><a href="{{ url('/jobs?searchfield=Work From Office') }}">Jobs (Work From Office)</a></li>
                    <li><a href="{{ url('/jobs?searchfield=Remote') }}">Jobs (Remote/WFH)</a></li>
                    <li><a href="{{ url('/jobs?searchfield=WFH during Covid') }}">Jobs (Temp WFH)</a></li>
                </ul>
            </div>

            <div>
                <div class="znp-footer-col-title">Jobs by Job Type</div>
                <ul class="znp-footer-links">
                    <li><a href="{{ url('/jobs?searchfield=Full time') }}">Jobs (Full time)</a></li>
                    <li><a href="{{ url('/jobs?searchfield=Contract') }}">Jobs (Contract)</a></li>
                </ul>
                <div class="znp-footer-col-title" style="margin-top:20px;">Links</div>
                <ul class="znp-footer-links">
                    <li><a href="{{ url('terms-and-conditons') }}">Terms &amp; Conditions</a></li>
                    <li><a href="{{ url('privacy-policy') }}">Privacy Policy</a></li>
                </ul>
            </div>

        </div>

        <div class="znp-footer-bottom">
            <span class="znp-footer-copy">&copy; {{ date('Y') }} ZeroNoticePeriod. All rights reserved.</span>
            <div class="znp-footer-socials">
                <a href="https://www.facebook.com/profile.php?id=100078635680624" class="znp-social-icon" title="Facebook" aria-label="Facebook"><img src="{{ asset('asset/images/fb.png') }}" alt="Facebook" class="znp-social-img"></a>
                <a href="https://www.linkedin.com/company/zeronoticeperiod/" class="znp-social-icon" title="LinkedIn" aria-label="LinkedIn"><img src="{{ asset('asset/images/linkedin.png') }}" alt="LinkedIn" class="znp-social-img"></a>
                <a href="https://twitter.com/ZNPTEAM" class="znp-social-icon" title="Twitter" aria-label="Twitter"><img src="{{ asset('asset/images/twitter.png') }}" alt="Twitter" class="znp-social-img"></a>
                <a href="https://www.instagram.com/_zeronotice_/" class="znp-social-icon" title="Instagram" aria-label="Instagram">
                    <svg class="znp-social-svg" viewBox="0 0 24 24" aria-hidden="true">
                        <path fill="currentColor" d="M7.8 2h8.4A5.8 5.8 0 0 1 22 7.8v8.4A5.8 5.8 0 0 1 16.2 22H7.8A5.8 5.8 0 0 1 2 16.2V7.8A5.8 5.8 0 0 1 7.8 2Zm8.4 2H7.8A3.8 3.8 0 0 0 4 7.8v8.4A3.8 3.8 0 0 0 7.8 20h8.4a3.8 3.8 0 0 0 3.8-3.8V7.8A3.8 3.8 0 0 0 16.2 4ZM12 7a5 5 0 1 1 0 10 5 5 0 0 1 0-10Zm0 2a3 3 0 1 0 0 6 3 3 0 0 0 0-6Zm6.25-2.35a1.15 1.15 0 1 1 0 2.3 1.15 1.15 0 0 1 0-2.3Z"/>
                    </svg>
                </a>
            </div>
        </div>
    </div>
</footer>
