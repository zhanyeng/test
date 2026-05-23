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
///////send challenges datail to database//////////
if($_SERVER['REQUEST_METHOD'] == "POST"){
    $detail = $_POST['detail'];
    $point =  $_POST['point'];
    $deadline =  $_POST['deadline'];
    $target_kwh =  $_POST['target_kwh'];

    $sql = "INSERT INTO challenge(description, points, deadline, target_kwh)
                VALUES('$detail', '$point', '$deadline', '$target_kwh')";
    if(mysqli_query($conn,$sql)){
        echo "<script>alert('submit complete');window.location.href='staffpage.php';</script>"; 
    }else{
         echo "<script>alert('error')</script>"; 
    }
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
        <h1 class="dashboard">STAFF DASHBOARD</H1>
        <h4 class="welcome">Welcome back : <?php echo $user?>
        <br><br>
        <hr>
        <br>

        <h2 class="a" id="eu">⚡Student Electric Usage</h2>
        <p class="a">all student energy usage</p>
        <br><br>

        <div class="usagebox">
            <table class="usagetable">
                <tr class="top">
                    <th>🏢Block</th>
                    <th>🚪Room Number</th>
                    <th>👤Student Name</th>
                    <th>⚡Usage (kWh)</th>
                    <th>📅Date</th>
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
        <br><br><hr><br><br>
        <h2 class="jc" id="jc">📌joined challenges</h2>
        <p class="j">The challenges that already joined</p>
        <div class="joinedchallenges">
            
            <table class= 'jct'>
                <tr class="top">
                    <th>username</th>
                    <th>challenge_id</th>
                    <th>progress</th>

                <?php 
                    $joinedc = mysqli_query($conn,"SELECT * FROM challenge_participation");
                    while ($row4 = mysqli_fetch_assoc($joinedc)):
                ?>

                </tr>
                <tr>
                    <td><?php echo $row4['username'];?></td>
                    <td><?php echo $row4['challenge_id'];?></td>
                    <td >
                        <?php 
                            if($row4['points_given'] == 1){
                                echo 'Done'; 
                            }else{ echo 'Not Done';} 
                        ?>
                    </td>
                </tr>
                <?php endwhile; ?>
            </table>
        </div>

        <div id="challenges" class="challengebox">
            <h2 class="ac" id="ac">🎯Available Challenges</h2>
            <p class="content1">Join a challenge and earn points</p>
        </div>

    <div class="cardlist">
        <?php
        $allchallenge = mysqli_query($conn, "SELECT * FROM challenge");
        while ($row2 = mysqli_fetch_assoc($allchallenge)):
        ?>
            <div class="card">  
                <p class="carddesc"><?php echo $row2['description']; ?></p>
                <p class="cardinfo">id : <?php echo $row2['challenge_id'];?></p>
                <p class="cardinfo">Target : <?php echo $row2['target_kwh']; ?> kWh</p>
                <p class="cardinfo">Deadline : <?php echo $row2['deadline']; ?></p>
                <p class="cardinfo">Points : <?php echo $row2['points']; ?></p>
            </div>
        <?php endwhile; ?>
    </div>
    <br><hr><br>
    <h2 id="addc">✏️Add new challenge</h2>
    <div class="add">
        <div class="record-content">
            <h3>challenges</h3>
            <form method="POST" action="">

                <div class="input">
                    <label>description</label>
                    <textarea id="detail" name="detail" required cols="30" rows="5" placeholder="enter the challenges datails"></textarea>
                </div>

                <div class="input">
                    <label>point</label>
                    <input type="number" name="point" min="10" placeholder="example: 20" required>
                </div>

                <div class="input">
                    <label>deadline</label>
                    <input type="date" name="deadline" value="<?php echo date('Y-m-d'); ?>" required>
                </div>

                <div class="input">
                    <label>targer kWh</label>
                    <input type="number" name="target_kwh" step="0.01" min="0" placeholder="example: 20" required>
                </div>
                <button type="submit" class="submitbtn">Submit</button>
            </form>
        </div>
    </div>

        
<?php include "footer.php" ?>

</body>
</html>