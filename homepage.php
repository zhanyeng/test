<?php
session_start();
$user  = $_SESSION['username'] ?? 'Guest';

$servername  = "localhost";
$username_db = "root";
$password_db = "";
$dbname      = "assignment";

$conn = mysqli_connect($servername, $username_db, $password_db, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Voltcampus — Smart Campus Energy</title>
    <link rel="stylesheet" href="homepage.css">
</head>
<body>

<div class="header">
    <div class="header-content">
        <h2 class="logo">⚡Voltcampus</h2>
        <div class="header-links">
            <a href="signuppage.php" class="signup">Sign Up</a>
            <a href="loginpage.php" class="login">Login</a>
        </div>
    </div>
</div>

<div class="main-content">
    <div class="content1">
        <div class="smart">⚡ SMART ENERGY</div>
        <h1>Use Less.<br>Earn More.<br><em>Go Greener.</em></h1>
        <br>
        <p class="aaa">Monitor your dorm's electricity in real-time, compete in weekly eco-challenges, and turn every kilowatt saved into rewards you can actually spend on campus.</p>
        <div class="header-links">
            <a href="signuppage.php" class="signup">Get Started</a>
            <a href="loginpage.php" class="login">Login</a>
        </div>
        <div class="hero-stats">
            <div class="stat-item">
                <div class="stat-num">10<span>k+</span></div>
                <div class="stat-label">kWh Saved</div>
            </div>
            <div class="stat-item">
                <div class="stat-num">1<span>k+</span></div>
                <div class="stat-label">Students</div>
            </div>
            <div class="stat-item">
                <div class="stat-num">25<span>t</span></div>
                <div class="stat-label">CO₂ Reduced</div>
            </div>
        </div>
    </div>

    <div class="image">
        <img src="https://thumbs.dreamstime.com/b/energy-crisis-earth-hour-concept-man-switch-off-lightbulb-to-save-consumption-city-buildings-world-environment-day-sustainable-259157581.jpg" alt="Green Campus Energy">
        <div class="float-badge">
            <div class="float-icon">🌿</div>
            <div>
                <div class="float-num">-32%</div>
                <div class="float-desc">This Week's Reduction</div>
            </div>
        </div>
    </div>
</div>

<h2 class="function">📃 What We Offer</h2>


<div class="second-content">
    <div class="Electricity-consumption">
        <div class="Electricity-consumption-image">
            <img src="https://cdn-icons-png.flaticon.com/512/6292/6292156.png" alt="Electricity Consumption">
        </div>
        <h3>Real-Time Monitoring</h3>
        <p>Track your dorm's electricity usage live. Spot wasteful habits and get personalised tips to cut consumption every day.</p>
    </div>

    <div class="challenge">
        <div class="challenge-image">
            <img src="https://cdn1.iconfinder.com/data/icons/travel-flat-icons/130/challenge-1024.png" alt="Challenges">
        </div>
        <h3>Dorm Challenges</h3>
        <p>Compete in weekly dorm-vs-dorm challenges. Hit collective savings targets and climb the leaderboard together.</p>
    </div>

    <div class="reward">
        <div class="reward-image">
            <img src="https://static.vecteezy.com/system/resources/previews/018/817/961/original/reward-medal-icon-png.png" alt="Rewards">
        </div>
        <h3>Earn Rewards</h3>
        <p>Every kWh saved earns you points. Spend them on food vouchers, campus perks, and exclusive partner deals.</p>
    </div>
</div>

<hr>

<div class="how-section">
    <div class="how-section-inner">
        <div class="section-label">How It Works</div>
        <div class="section-title">Save Energy in 3 Simple Steps</div>
        <p class="section-sub">Getting started takes under two minutes — and savings begin on day one.</p>
        <div class="how-grid">
            <div class="how-card">
                <div class="how-num">01</div>
                <div class="how-title">Log Your Usage</div>
                <p class="how-desc">Sign up and visit your Student Dashboard. Record daily electricity readings — the system tracks weekly and monthly trends automatically.</p>
            </div>
            <div class="how-card">
                <div class="how-num">02</div>
                <div class="how-title">Join a Challenge</div>
                <p class="how-desc">Browse live challenges and join with one tap. Hit energy-saving targets as a dorm and earn points for every milestone reached.</p>
            </div>
            <div class="how-card">
                <div class="how-num">03</div>
                <div class="how-title">Claim Rewards</div>
                <p class="how-desc">Spend your points in the Rewards Store — food vouchers, bookstore credits, and more. All earned by being eco-conscious.</p>
            </div>
        </div>
    </div>
</div>



<h2 class="function">📌 Track Your Energy Usage</h2>
<div class="info-section">
    <div class="info-box">
        <div class="info-icon">📊</div>
        <h3>Why Track Your Usage?</h3>
        <p>Recording your daily electricity consumption helps you understand your habits, identify waste, and take action. Every 1 kWh saved reduces carbon emissions by approximately 0.5 kg — a real contribution to our planet.</p>
    </div>
    <div class="info-box2">
        <div class="info-icon">📝</div>
        <h3>How to Record?</h3>
        <p>Log in and go to the Student Dashboard. Click "Record Usage", select the date, and enter your daily electricity usage (kWh). The system automatically calculates your weekly and monthly usage with energy-saving tips.</p>
    </div>
    <div class="info-box3">
        <div class="info-icon">🎯</div>
        <h3>Benefits of Tracking</h3>
        <p>Accurate tracking helps you complete energy-saving challenges, earn points, and redeem vouchers. The school can also use aggregated data to optimise energy distribution and build a greener campus.</p>
    </div>
</div>

<hr>

<div class="rank-section">
    <div class="rank-left">
        <div class="rank-header">
            <h2>🏆 Electric Usage Rank</h2>
            <p>Lowest usage — Top 3 this week</p>
        </div>
        <div class="rank-steps">
            <?php
            $leaderboard = mysqli_query($conn, "
                SELECT dorm_block, room_number, SUM(usage_kwh) AS total_kwh
                FROM electric_usage
                WHERE record_date BETWEEN '" . date('Y-m-d', strtotime('monday last week')) . "'
                  AND '" . date('Y-m-d', strtotime('sunday last week')) . "'
                GROUP BY dorm_block, room_number
                ORDER BY total_kwh ASC LIMIT 3
            ");
            $medals = ['🥇', '🥈', '🥉'];
            $i = 0;
            while ($row = mysqli_fetch_assoc($leaderboard)):
            ?>
            <div class="rank-card rank-<?php echo $i; ?>">
                <div class="rank-medal"><?php echo $medals[$i]; ?></div>
                <div class="rank-dorm"><?php echo htmlspecialchars($row['dorm_block']); ?></div>
                <div class="rank-room">Room <?php echo htmlspecialchars($row['room_number']); ?></div>
                <div class="rank-usage"><?php echo number_format($row['total_kwh'], 1); ?> kWh</div>
            </div>
            <?php $i++; endwhile; ?>
        </div>
    </div>

    <div class="rank-right">
        <div class="info-card">
            <div class="info-card-icon">💡</div>
            <h3>Why Save Electricity?</h3>
            <p>Every <strong>1 kWh</strong> saved cuts roughly <strong>0.5 kg of CO₂</strong> — that adds up fast across an entire dorm block.</p>
            <p>Rankings refresh every <strong>Monday</strong>. Top 3 dorms earn bonus points automatically!</p>
            <a href="signuppage.php" class="info-btn">Join a Challenge 🎯</a>
        </div>
    </div>
</div>

<hr>

<?php $vouchers = mysqli_query($conn, "SELECT * FROM voucher LIMIT 3"); ?>

<div class="function">
    <h2>Available Vouchers ‼️</h2>
    <p>Earn points through challenges and redeem them for real rewards. New vouchers added every week.</p>
</div>

<div class="second-content">
    <?php while ($row = mysqli_fetch_assoc($vouchers)): ?>
    <div class="Electricity-consumption" style="text-align:center;">
        <p style="font-size:2.5rem;margin:0;">🎁</p>
        <h3><?= htmlspecialchars($row['store_name']) ?></h3>
        <p><?= htmlspecialchars($row['description']) ?></p>
        <p style="color:var(--accent);font-weight:700;">🏷️ <?= htmlspecialchars($row['discount']) ?></p>
    </div>
    <?php endwhile; ?>
</div>

<?php include 'footer.php'; ?>

</body>
</html>