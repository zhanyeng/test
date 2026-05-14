<?php
session_start();
$user = $_SESSION['username'] ?? 'Guest';

$servername  = "localhost";
$username_db = "root";
$password_db = "";
$dbname      = "assignment"; 

$conn = mysqli_connect($servername, $username_db, $password_db, $dbname);
if (!$conn) die("Connection failed: " . mysqli_connect_error());
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
    <h1 class="a">Send Alert</h1>
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
                <th>Send Alert</th>
            </tr>
            <?php
                $data = mysqli_query($conn, "SELECT * FROM electric_usage ORDER BY record_date DESC");
                while ($row = mysqli_fetch_assoc($data)):
            ?>
            <tr>
                <?php if($row['usage_kwh'] > 20): ?>
                    <td><?php echo $row['dorm_block']; ?></td>
                    <td><?php echo $row['room_number']; ?></td>
                    <td><?php echo $row['username']; ?></td>
                    <td style="color: red;"><?php echo $row['usage_kwh']; ?> kWh</td>
                    <td><?php echo $row['record_date']; ?></td>
                    <td>
                        <form action="sendalertfunction.php" method="post">
                            <input type="hidden" name="from_list"   value="1">
                            <input type="hidden" name="room" value="<?php echo $row['room_number']; ?>">
                            <input type="hidden" name="block" value="<?php echo $row['dorm_block']; ?>">
                            <input type="hidden" name="date" value="<?php echo $row['record_date']; ?>">
                            <input type="hidden" name="student" value="<?php echo $row['username']; ?>">
                            <input type="hidden" name="kwh" value="<?php echo $row['usage_kwh']; ?>">
                            <button class="alertbutton" type="submit">Send Alert</button>
                        </form>
                    </td>
                <?php endif; ?>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>

    <?php include 'footer.php' ?>
</body>
</html>