<?php
session_start();
$user  = $_SESSION['username'] ?? 'Guest';
///////////////////////cannect database///////////////
$servername = "localhost";
$username_db = "root";
$password_db = "";
$dbname = "assignment"; 

$conn = mysqli_connect($servername, $username_db, $password_db, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
    <link rel="stylesheet" href="homepage.css">
<body>
    <div class="header">
        <div class="header-content">
            <h2 class="logo">Voltcampus</h2>
            <div class="header-links"> 
                <a href="signuppage.php" class="signup">Signup</a>
                <a href="loginpage.php" class="login">Login</a>
               
            </div>
        </div>
    </div>

    <div class="main-content">
        <div class="content1">
            <h1>Empowering Green Living in Dorms</h1>
            <br><br>
            <p class="aaa">Empower your sustainable lifestyle by tracking daily energy consumption and joining community challenges. Every kilowatt saved earns you points that can be redeemed for exclusive rewards, making green living both impactful and rewarding for every student.<p>
            <div class="header-links">
                <a href="signuppage.php" class="signup">Signup</a>
                <a href="loginpage.php" class="login">Login</a>
                
            </div>
        </div>
        <div class="image">
            <img src="https://www.uliege.be/upload/docs/image/png/2022-10/saveenergy-news.png" alt="Green Living" >
        </div>
    </div>

    <h2 class="function">📃Function of this website</h2><br>
<BR>
    <div class=second-content>
        <div class ="Electricity-consumption">
            <div class="Electricity-consumption-image">
                <img src="https://cdn-icons-png.flaticon.com/512/6292/6292156.png" alt="Electricity Consumption" >
            </div>
            <h3>Electricity Consumption</h3>
            <p>Track your energy usage in real-time and receive personalized tips to reduce your carbon footprint.</p>
        </div>

        <div class="challenge">
            <div class="challenge-image">
                <img src="https://cdn1.iconfinder.com/data/icons/travel-flat-icons/130/challenge-1024.png" >
            </div>
            <h3>Challenges</h3>
            <p>Participate in fun challenges to reduce your energy consumption and compete with your peers.</p>
        </div>

        <div class="reward">
            <div class="reward-image">
                <img src="https://static.vecteezy.com/system/resources/previews/018/817/961/original/reward-medal-icon-png.png" alt="Rewards" >
            </div>
            <h3>Rewards</h3>
            <p>Earn points and rewards for your eco-friendly actions and achievements.</p>
        </div>
    </div>
<br><hr>

<h2 class="function">📌Track energy usage</h2>
<BR>
<BR>
<div class="info-section">
    <div class="info-box">
        <div class="info-icon">📊</div>
        <h3>Why Track Your Energy Usage?</h3>
        <p>By recording your daily electricity consumption, you can clearly understand your energy habits, identify waste, and take action to save energy. Every 1 kWh saved reduces carbon emissions by approximately 0.5 kg — a real contribution to our planet.</p>
    </div>
    <div class="info-box2">
        <div class="info-icon">📝</div>
        <h3>How to Record?</h3>
        <p>Log in and go to the Student Dashboard, click “Record Usage”, select the date and enter your daily electricity usage (kWh). The system will automatically calculate your weekly/monthly usage and provide energy-saving tips.</p>
    </div>
    <div class="info-box3">
        <div class="info-icon">🎯</div>
        <h3>Benefits of Tracking</h3>
        <p>Accurate tracking helps you complete energy-saving challenges, earn points, and redeem vouchers. At the same time, the school can use aggregated data to optimize energy distribution and build a greener campus.</p>
    </div>
</div>
<br>
<hr>
<br>

<div class="rank-section">
    <div class="rank-left">
        <div class="rank-header">
            <h2>🏆 Electric Usage Rank</h2>
            <p>less usage top3</p>
        </div>
        <div class="rank-steps">
            <?php
            $leaderboard = mysqli_query($conn, "
                SELECT dorm_block, room_number, SUM(usage_kwh) AS total_kwh
                FROM electric_usage
                WHERE record_date BETWEEN '" . date('Y-m-d', strtotime('monday last week')) . "' AND '" . date('Y-m-d', strtotime('sunday last week')) . "'
                GROUP BY dorm_block, room_number
                ORDER BY total_kwh ASC LIMIT 3
            ");
            $medals = ['🥇', '🥈', '🥉'];
            $i = 0;
            while ($row = mysqli_fetch_assoc($leaderboard)):
            ?>
            <div class="rank-card rank-<?php echo $i; ?>">
                <div class="rank-medal"><?php echo $medals[$i]; ?></div>
                <div class="rank-dorm"><?php echo $row['dorm_block']; ?></div>
                <div class="rank-room">Room <?php echo $row['room_number']; ?></div>
                <div class="rank-usage"><?php echo number_format($row['total_kwh'], 1); ?> kWh</div>
            </div>
            <?php $i++; endwhile; ?>
        </div>
    </div>

    <div class="rank-right">
        <div class="info-card">
            <h3>💡 Why save electricity?</h3>
            <p>Every save <strong>1 kWh</strong> Electricity consumption can be reduced by approximately <strong>0.5 kg</strong> Carbon emissions.</p>
            <p>Dormitory electricity consumption ranking, <strong>updates Weekly. </strong>Let's strive to be pioneers in campus energy conservation!</p>
            <a href="signuppage.php" class="info-btn">join chanllenges 🎯</a>
        </div>
    </div>
</div>
<br>
    <?php
        $vouchers = mysqli_query($conn, "SELECT * FROM voucher LIMIT 3");
    ?>
    
    <div class="function">
        <h2>Available Vouchers‼️</h2>
        <p>Earn points through challenges and redeem coupons. Many more coupons await your discovery.</p>
    </div>
                
    <div class="second-content">
        <?php while ($row = mysqli_fetch_assoc($vouchers)): ?>
        <div class="Electricity-consumption" style="text-align:center;">
            <p style="font-size:2.5rem;margin:0;">🎁</p>
            <h3 style="color:#333;margin:10px 0 5px;"><?= $row['store_name'] ?></h3>
            <p style="color:#444;"><?= $row['description'] ?></p>
            <p style="color:#444;">Discount: <?= $row['discount'] ?></p>
        </div>
        <?php endwhile; ?>
    </div>
    <?php
        include 'footer.php';
    ?>


    
</body>
</html>