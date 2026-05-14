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
//////////////////////////////////////////


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
    <h1 class="a">Send Alert</H1>
        <h4 class="a">Room number that has high usage this week :</h4>

        <hr>
        
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
                    <?php
                    if($row3['usage_kwh'] > 20):?>
                        <td color:white><?php echo $row3['dorm_block']; ?></td>
                        <td><?php echo $row3['room_number']; ?></td>
                        <td><?php echo $row3['username']; ?></td>
                        <td style="color: red;"><?php echo $row3['usage_kwh']; ?> kWh</td>
                        <td><?php echo $row3['record_date']; ?></td>
                    <?php endif; ?>
                    
                </tr>
                <?php endwhile; ?>
            </table>
    </div>



    <?php include 'footer.php' ?>
</body>
</html>