<style>
/* ===== FOOTER ===== */
/* 依赖 homepage.css（或任意页面 CSS）中定义的 CSS 变量 */
/* 如果某页面没有引入 homepage.css，请在该页面的 <head> 补上字体和变量 */

.footer {
    background: var(--bg-surface, #0d1526);
    border-top: 1px solid var(--border, rgba(255,255,255,0.06));
    padding: 70px 40px 30px;
    margin-top: 0;
    width: 100%;
    font-family: var(--font-body, 'DM Sans', sans-serif);
    color: var(--text-primary, #eef2f8);
}

.footer-container {
    max-width: 1200px;
    margin: 0 auto;
    display: grid;
    grid-template-columns: 1.4fr 1fr;
    gap: 60px;
    margin-bottom: 48px;
}

.footer-brand .logo {
    font-family: var(--font-display, 'Syne', sans-serif);
    font-size: 20px;
    font-weight: 800;
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 18px;
    color: var(--text-primary, #eef2f8);
}
.footer-brand p {
    font-size: 14px;
    color: var(--text-muted, #4a5a78);
    line-height: 1.8;
    max-width: 340px;
}

.footer-section h4 {
    font-family: var(--font-display, 'Syne', sans-serif);
    font-size: 13px;
    font-weight: 700;
    color: var(--text-primary, #eef2f8);
    letter-spacing: 0.8px;
    text-transform: uppercase;
    margin-bottom: 18px;
}
.footer-section p {
    font-size: 13px;
    color: var(--text-muted, #4a5a78);
    line-height: 1.8;
    margin-bottom: 14px;
}
.footer-section a {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    color: var(--accent, #00e87a);
    text-decoration: none;
    font-size: 13px;
    font-weight: 600;
    transition: color 0.25s ease;
}
.footer-section a:hover {
    color: #1fffa0;
}

.footer-bottom {
    max-width: 1200px;
    margin: 0 auto;
    padding-top: 24px;
    border-top: 1px solid var(--border, rgba(255,255,255,0.06));
    display: flex;
    align-items: center;
    justify-content: space-between;
}
.footer-bottom p {
    font-size: 12px;
    color: var(--text-muted, #4a5a78);
}
.footer-bottom-logo {
    font-family: var(--font-display, 'Syne', sans-serif);
    font-size: 14px;
    font-weight: 700;
    color: var(--text-muted, #4a5a78);
    display: flex;
    align-items: center;
    gap: 6px;
}

/* Responsive */
@media (max-width: 1024px) {
    .footer-container { grid-template-columns: 1fr; gap: 36px; }
}
@media (max-width: 768px) {
    .footer { padding: 50px 20px 24px; }
    .footer-bottom { flex-direction: column; gap: 8px; text-align: center; }
}
</style>

<footer class="footer">
    <div class="footer-container">

        <div class="footer-brand">
            <div class="logo">
                <span style="filter:drop-shadow(0 0 6px #00e87a)">⚡</span>Voltcampus
            </div>
            <p>
                An energy management platform built for modern campuses.
                We help students track consumption, join sustainability challenges,
                and build a greener campus — one kilowatt at a time.
            </p>
        </div>

        <div class="footer-section">
            <h4>About the Team</h4>
            <p>
                We are Group 8 — a team of students passionate about using technology
                to drive environmental responsibility and reduce electricity waste
                across our campus community.
            </p>
            <a href="aboutus.php">Meet Our Team →</a>
        </div>

    </div>

    <div class="footer-bottom">
        <p>&copy; <?php echo date("Y"); ?> Voltcampus Management System. All rights reserved.</p>
        <div class="footer-bottom-logo">⚡ Voltcampus</div>
    </div>
</footer>