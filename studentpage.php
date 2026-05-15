<?php
session_start(); 
///////////////////////cannect database///////////////
$servername = "localhost";
$username_db = "root";
$password_db = "";
$dbname = "assignment"; 

$conn = mysqli_connect($servername, $username_db, $password_db, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

///////////////////////////////session(from login information)//////////////////////////////////
$user  = $_SESSION['username'] ?? 'Guest';
$room  = $_SESSION['roomnumber'] ?? 'xxxxxx';
$block = $_SESSION['dormblock'] ?? 'xxxxx';

////////////////////////////////////write daily usage/////////////////////////////////////////
if (isset($_POST['usage'])) {
    $usage = $_POST['usage'];
    $date = $_POST['date'];
    $sql = "INSERT INTO electric_usage (username, room_number, dorm_block, usage_kwh, record_date)
                 VALUES ('$user', '$room', '$block', '$usage', '$date')";
    mysqli_query($conn, $sql);
    echo "<script>alert('Usage recorded!'); window.location.href='studentpage.php';</script>";
}

if (isset($_POST['join'])) {
    $cid = $_POST['challenge_id'];
    $checkduplicate = mysqli_query($conn, "SELECT * FROM challenge_participation WHERE username = '$user' AND challenge_id = '$cid'");
    if (mysqli_num_rows($checkduplicate) == 0) {
        mysqli_query($conn, "INSERT INTO challenge_participation (username, challenge_id) VALUES ('$user', '$cid')");
    }
    echo "<script>window.location.href='studentpage.php#challenges';</script>";
}

////////point store//////
if (isset($_POST['redeem'])) {
    $vid = $_POST['voucher_id'];
    
    $voucherinfo = mysqli_query($conn, "SELECT * FROM voucher WHERE voucher_id = '$vid'");
    $voucherrow = mysqli_fetch_assoc($voucherinfo);
    $pointsneed = $voucherrow['points_needed'];
    
    $studentinfo = mysqli_query($conn, "SELECT points FROM student_information WHERE name = '$user'");
    $studentrow = mysqli_fetch_assoc($studentinfo);
    $mypoints = $studentrow['points'];
    
    $checkredeemed = mysqli_query($conn, "SELECT * FROM redeemed WHERE username = '$user' AND voucher_id = '$vid'");
    
    if ($mypoints >= $pointsneed && mysqli_num_rows($checkredeemed) == 0) {
        mysqli_query($conn, "INSERT INTO redeemed (username, voucher_id, redeemed_date) VALUES ('$user', '$vid', CURDATE())");
        mysqli_query($conn, "UPDATE student_information SET points = points - $pointsneed WHERE name = '$user'");
        echo "<script>alert('Redeemed successfully!'); window.location.href='studentpage.php#pointstore';</script>";
    } else if (mysqli_num_rows($checkredeemed) > 0) {
        echo "<script>alert('Already redeemed!'); window.location.href='studentpage.php#pointstore';</script>";
    } else {
        echo "<script>alert('Not enough points!'); window.location.href='studentpage.php#pointstore';</script>";
    }
}

////////////////////////////////////////---------energy usage form sql------------------///////////////////////////////////////////////
$records = mysqli_query($conn, "SELECT record_date, usage_kwh FROM electric_usage 
                                    WHERE username = '$user' ORDER BY record_date DESC LIMIT 7");

$totaluse = mysqli_query($conn, "SELECT SUM(usage_kwh) as total FROM electric_usage 
                                    WHERE username = '$user'");

$totalrow = mysqli_fetch_assoc($totaluse);
$total = $totalrow['total'] ?? 0;

$weekuse = mysqli_query($conn, "SELECT SUM(usage_kwh) as week FROM electric_usage 
                                    WHERE username = '$user' AND record_date >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)");

$weekrow = mysqli_fetch_assoc($weekuse);
$week = $weekrow['week'] ?? 0;
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//////////////////ADD POINT////////////////
$mychallenge2 = mysqli_query($conn, "SELECT challenge.* FROM challenge 
                JOIN challenge_participation ON challenge.challenge_id = challenge_participation.challenge_id 
                WHERE challenge_participation.username = '$user'");

while ($crow = mysqli_fetch_assoc($mychallenge2)) {
    if ($week <= $crow['target_kwh']) {
        $checkgiven = mysqli_query($conn, "SELECT * FROM challenge_participation WHERE username = '$user' AND challenge_id = '$crow[challenge_id]' AND points_given = 1");
        if (mysqli_num_rows($checkgiven) == 0) {
            mysqli_query($conn, "UPDATE student_information SET points = points + $crow[points] WHERE name = '$user'");
            mysqli_query($conn, "UPDATE challenge_participation SET points_given = 1 WHERE username = '$user' AND challenge_id = '$crow[challenge_id]'");
        }
    }
}

$studentpoints = mysqli_query($conn, "SELECT points FROM student_information WHERE name = '$user'");
$studentpointsrow = mysqli_fetch_assoc($studentpoints);
$mypoints = $studentpointsrow['points'] ?? 0;
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard - Voltcampus</title>
    <link rel="stylesheet" href="studentpage.css">
</head>
<body>

    <?php include 'userheader.php' ?>

    <div class="content">
        <h1 class="dashboard">STUDENT DASHBOARD</h1>
        <h4 class="welcome">Welcome back : <?php echo $user; ?></h4>
        <h4 class="room">Room number : <?php echo $block; ?>-<?php echo $room; ?></h4>
    </div>

    <hr ><br><br>
    <div class="content2">
        <h2 class="energyuse" id="energy">⚡Energy use</h2>
        <p class="recorddaily">Record your daily energy use</p>
    </div>

    <div class="energyusage">

        <div class="total-and-week-use">

            <div class="bigusagebox">

                <div class="usagebox">
                    <p class="stat-label">Weekly Usage</p>
                    <p class="usage"><?php echo $week; ?> kWh</p>
                </div>

                <div class="usagebox">
                    <p class="stat-label">Total Usage</p>
                    <p class="usage"><?php echo $total; ?> kWh</p>

                </div>
            </div>

            <div class="dailyuse">
                <h3>Daily Usage (Past 7 Days)</h3>
                <table>
                    <tr>
                        <th>Date</th>
                        <th>Usage (kWh)</th>
                    </tr>
                    <?php if (mysqli_num_rows($records) > 0): ?>
                        <?php while ($row = mysqli_fetch_assoc($records)): ?>
                            <tr>
                                <td>📅<?php echo $row['record_date']; ?></td>
                                <td><?php echo $row['usage_kwh']; ?></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="2">No records yet.</td>
                        </tr>
                    <?php endif; ?>
                </table>
            </div>
        </div>

        <div class="recordusage">
            <div class="record-content">
                <h3>Record Usage</h3>
                <form method="POST" action="">
                    <div class="input">
                        <label>📅Date</label>
                        <input type="date" name="date" value="<?php echo date('Y-m-d'); ?>" required>
                    </div>
                    <div class="input">
                        <label>⚡Usage (kWh)</label>
                        <input type="number" name="usage" step="0.01" min="0" placeholder="e.g. 3.50" required>
                    </div>
                    <button type="submit" class="submitbtn">Submit</button>
                </form>
            </div>
        </div>

    </div><br><br><hr>





<div id="challenges" class="challengebox">
        <h2 class="energyuse">🎯challenges</h2>
        <p class="recorddaily">The challenges that available to join now</p>

    <div class="cardlist">
        <?php
        $allchallenge = mysqli_query($conn, "SELECT * FROM challenge");
        while ($row2 = mysqli_fetch_assoc($allchallenge)):
            $checkjoin = mysqli_query($conn, "SELECT * FROM challenge_participation WHERE username = '$user' AND challenge_id = '$row2[challenge_id]'");
            $isjoined = mysqli_num_rows($checkjoin) > 0;
        ?>
            <div class="card">
                <p class="carddesc"><?php echo $row2['description']; ?></p>
                <p class="cardinfo">Target : <?php echo $row2['target_kwh']; ?> kWh</p>
                <p class="cardinfo">Deadline : <?php echo $row2['deadline']; ?></p>
                <p class="cardinfo">Points : <?php echo $row2['points']; ?></p>
                <?php if ($isjoined): ?>
                    <button class="joinedbtn" disabled>Joined</button>
                <?php else: ?>
                    <form method="POST" action="">
                        <input type="hidden" name="challenge_id" value="<?php echo $row2['challenge_id']; ?>">
                        <button type="submit" name="join" class="joinbtn">Join</button>
                    </form>
                <?php endif; ?>
            </div>
        <?php endwhile; ?>
    </div>
</div>
<br><br>
<div class="mychallengebox">
    <h2 class="energyuse" id="mychallenges">📌My Challenges</h2>
    <p class="recorddaily">Challenges you have joined</p>

    <div class="cardlist">
        <?php
        $mychallenge = mysqli_query($conn, "SELECT challenge.* FROM challenge 
                        JOIN challenge_participation ON challenge.challenge_id = challenge_participation.challenge_id 
                        WHERE challenge_participation.username = '$user'");
        if (mysqli_num_rows($mychallenge) > 0):
            while ($row3 = mysqli_fetch_assoc($mychallenge)):
                $done = $week <= $row3['target_kwh'];
        ?>
            <div class="card">
                <p class="carddesc"><?php echo $row3['description']; ?></p>
                <p class="cardinfo">Target : <?php echo $row3['target_kwh']; ?> kWh</p>
                <p class="cardinfo">Deadline : <?php echo $row3['deadline']; ?></p>
                <p class="cardinfo">Points : <?php echo $row3['points']; ?></p>
                <?php if ($done): ?>
                    <span class="successtext">✅Success</span>
                <?php else: ?>
                    <span class="failtext">❎In Progress</span>
                <?php endif; ?>
            </div>
        <?php endwhile; else: ?>
            <p class="recorddaily">No challenges joined yet.</p>
        <?php endif; ?>
    </div>
</div>
<br><br><hr>

<div id="pointstore" class="pointstorebox">
    <h2 class="energyuse">🎁Point Store</h2>
    <p class="recorddaily">My Points : <?php echo $mypoints; ?></p>

    <div class="cardlist">
        <?php
        $allvoucher = mysqli_query($conn, "SELECT * FROM voucher");
        while ($row4 = mysqli_fetch_assoc($allvoucher)):
            $checkredeemed2 = mysqli_query($conn, "SELECT * FROM redeemed WHERE username = '$user' AND voucher_id = '$row4[voucher_id]'");
            $isredeemed = mysqli_num_rows($checkredeemed2) > 0;
        ?>
            <div class="card">
                <p class="carddesc"><?php echo $row4['store_name']; ?></p>
                <p class="cardinfo"><?php echo $row4['description']; ?></p>
                <p class="cardinfo">Discount : <?php echo $row4['discount']; ?></p>
                <p class="cardinfo">Points needed : <?php echo $row4['points_needed']; ?></p>
                <?php if ($isredeemed): ?>
                    <button class="joinedbtn" disabled>Redeemed</button>
                <?php else: ?>
                    <form method="POST" action="">
                        <input type="hidden" name="voucher_id" value="<?php echo $row4['voucher_id']; ?>">
                        <button type="submit" name="redeem" class="joinbtn">Redeem</button>
                    </form>
                <?php endif; ?>
            </div>
        <?php endwhile; ?>
    </div>
</div>

<div class="myvoucherbox">
    <h2 class="energyuse">📥My Vouchers</h2>
    <p class="recorddaily">Vouchers you have redeemed</p>

    <div class="cardlist">
        <?php
        $myvoucher = mysqli_query($conn, "SELECT voucher.* , redeemed.redeemed_date FROM voucher 
                        JOIN redeemed ON voucher.voucher_id = redeemed.voucher_id 
                        WHERE redeemed.username = '$user'");
        if (mysqli_num_rows($myvoucher) > 0):
            while ($row5 = mysqli_fetch_assoc($myvoucher)):
        ?>
            <div class="card">
                <p class="carddesc"><?php echo $row5['store_name']; ?></p>
                <p class="cardinfo"><?php echo $row5['description']; ?></p>
                <p class="cardinfo">Discount : <?php echo $row5['discount']; ?></p>
                <p class="cardinfo">Redeemed on : <?php echo $row5['redeemed_date']; ?></p>
            </div>
        <?php endwhile; else: ?>
            <p class="recorddaily">No vouchers redeemed yet.</p>
        <?php endif; ?>
    </div>
</div>



    <?php include "footer.php" ?>

</body>
</html>