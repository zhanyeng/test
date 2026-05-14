<style>
    .footer {
        width: 100%;
        background-color: rgba(255, 255, 255, 0.9);
        padding: 50px 0 30px 0;
        margin-top: 50px;
        color: #333;
        border-top: 1px solid rgba(0, 0, 0, 0.1);
    }

    .footer-container {
        max-width: 1100px;
        margin: 0 auto;
        display: flex;
        justify-content: space-around;
        flex-wrap: wrap;
        padding: 0 20px;
    }

    .footer-section {
        flex: 1;
        min-width: 250px;
        margin-bottom: 30px;
    }

    .footer-section h2 {
        color: #1a2a44;
        font-size: 20px;
        margin-bottom: 20px;
        font-weight: bold;
    }

    .footer-section p {
        line-height: 1.8;
        color: #666;
        font-size: 14px;
        padding-right: 30px;
    }

    .footer-section a {
        display: inline-block;
        margin-top: 10px;
        color: #4fb2fd;
        text-decoration: none;
        font-size: 14px;
        font-weight: bold;
    }

    .footer-section a:hover {
        text-decoration: underline;
    }

    hr {
        border: 0;
        border-top: 1px solid rgba(0, 0, 0, 0.05);
        max-width: 1100px;
        margin: 20px auto;
    }

    .footer-bottom {
        text-align: center;
        font-size: 13px;
        color: #999;
    }
</style>

<footer class="footer">
    <div class="footer-container">
        
        <div class="footer-section">
            <h2>Voltcampus</h2>
            <p>
                Voltcampus is an advanced energy management system designed for modern campuses. 
                We empower students and staff to monitor electricity usage and participate in 
                sustainability challenges to build a greener future together.
            </p>
        </div>
        
        <div class="footer-section">
            <h2>About Us</h2>
            <p>
                We are Group 8, a dedicated team of students committed to creating innovative 
                digital solutions that promote environmental responsibility and reduce 
                electricity waste within our campus community.
            </p>
            <a href="aboutus.php">Meet Our Team</a>
        </div>

    </div>

    <hr>
    
    <div class="footer-bottom">
        <p>&copy; <?php echo date("Y"); ?> Voltcampus Management System. All Rights Reserved.</p>
    </div>
</footer>