<style>
.footer {
    background: #0d1526;
    border-top: 1px solid rgba(255,255,255,0.06);
    padding: 70px 40px 30px;
    margin-top: 0;
    color: #eef2f8;
    box-sizing: border-box;
}

.footer-container {
    max-width: 1200px;
    margin: 0 auto;
    display: grid;
    gap: 60px;
    margin-bottom: 48px;
    box-sizing: border-box;
}

.footer-brand .logo {
    font-size: 20px;
    font-weight: 800;
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 18px;
    color: #eef2f8;
}
.footer-brand p {
    font-size: 14px;
    color: #4a5a78;
    line-height: 1.8;
    max-width: 340px;
}

.footer-section h4 {
    font-size: 13px;
    font-weight: 700;
    color: #eef2f8;
    letter-spacing: 0.8px;
    text-transform: uppercase;
    margin-bottom: 18px;
}
.footer-section p {
    font-size: 13px;
    color: #4a5a78;
    line-height: 1.8;
    margin-bottom: 14px;
}
.footer-section a {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    color: #00e87a;
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
    border-top: 1px solid rgba(255,255,255,0.06);
    display: flex;
    align-items: center;
    justify-content: space-between;
    box-sizing: border-box;
}
.footer-bottom p {
    font-size: 12px;
    color: #4a5a78;
}
.footer-bottom-logo {
    font-size: 14px;
    font-weight: 700;
    color: #4a5a78;
    display: flex;
    align-items: center;
    gap: 6px;
}

@media (max-width: 768px) {
    body .footer { 
        padding: 40px 16px 24px; 
        width: 100%;
        max-width: 100%;
        overflow: hidden;
    }
    body .footer-container {
        display: flex; 
        flex-direction: column; 
        gap: 32px;
        width: 100%;
        max-width: 100%;
        margin-bottom: 32px;
        padding: 0;
    }
    body .footer-brand p {
        max-width: 100%;
    }
    body .footer-bottom { 
        flex-direction: column; 
        gap: 12px; 
        text-align: center;
        width: 100%;
        max-width: 100%;
    }
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