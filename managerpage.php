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
    <link rel="stylesheet" href="staffpage.css">
</head>
<body>
    <?php include 'userheader.php' ?>
    <h1 class="dashboard">MANAGER DASHBOARD</H1>
    <h4 class="welcome">Welcome back : <?php echo $user?>
    <br>
    <br><hr>

    <h2 class="a" id="eu">Student Electric Usage</h2>
        <p class="a">all student energy usage</p>
        <br><br>

        <div class="usagebox">
            <table class="usagetable">
                <tr class="top">
                    <th>Block</th>
                    <th>Room Number</th>
                    <th>Student Name</th>
                    <th>Usage (kWh)</th>
                    <th>Date</th>
                </tr>
                <?php
                    $allusage = mysqli_query($conn, "SELECT * FROM electric_usage ORDER BY record_date DESC");
                    while ($row3 = mysqli_fetch_assoc($allusage)):
                ?>
                <tr>
                    <td color:white><?php echo $row3['dorm_block']; ?></td>
                    <td><?php echo $row3['room_number']; ?></td>
                    <td><?php echo $row3['username']; ?></td>
                    <td style="color: 
                        <?php if($row3['usage_kwh'] > 20){
                             echo 'red'; 
                        } else { echo '#ffffff'; } ?>">
                        <?php echo $row3['usage_kwh']; ?> kWh
                    </td>               
                    <td><?php echo $row3['record_date']; ?></td>
                </tr>
                <?php endwhile; ?>
            </table>
        </div>
    
</body>
</html>