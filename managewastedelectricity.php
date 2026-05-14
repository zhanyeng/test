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
    <div class="usagebox">
            <table class="usagetable">
                <tr class="top">
                    <th>Block</th>
                    <th>Room Number</th>
                    <th>Student Name</th>
                    <th>Usage (kWh)</th>
                    <th>Date</th>
                    <th>Send Alert</th>
                    <th>Alert Description</th>
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
                        <td>
                            <?php
                            $checkalert = mysqli_query($conn, "SELECT * FROM electric_usage WHERE alert_level = 1 AND room_number = '$row3[room_number]' AND dorm_block = '$row3[dorm_block]'");
                            if(mysqli_num_rows($checkalert) > 0): ?>
                                <button class="alertsent" disabled>Alert Sent</button>
                            <?php else: ?>
                                <form action="" method="post">
                                    <input type="hidden" name="room_number" value="<?php echo $row3['room_number']; ?>">
                                    <input type="hidden" name="dorm_block" value="<?php echo $row3['dorm_block']; ?>">
                                    <button class="remindbutton" type="submit">Remind Admin to Alert</button>
                                    <?php                                    
                                    $sql = "UPDATE electric_usage SET remind = 1 
                                    WHERE room_number = '$row3[room_number]' 
                                    AND dorm_block = '$row3[dorm_block]'
                                    order by record_date DESC
                                    LIMIT 1";

                                    mysqli_query($conn, $sql);
                                    ?>
                                </form>
                            <?php endif; ?>
                        </td>
                        <td><?php echo $row3['alert_description']; ?></td>
                    <?php endif; ?>
                    
                </tr>
                <?php endwhile; ?>
            </table>
    </div>
    
</body>
</html>