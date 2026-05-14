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
if($_SERVER['REQUEST_METHOD'] == "POST"){
    $description = $_POST['description'];
    $point_needed =  $_POST['point_needed'];
    $storename =  $_POST['store_name'];
    $discount =  $_POST['discount'];

    $sql = "INSERT INTO voucher(store_name, description, discount, points_needed)
                VALUES('$storename', '$description', '$discount', '$point_needed')";
    if(mysqli_query($conn,$sql)){
        echo "<script>alert('submit complete');window.location.href='adminpage.php';</script>"; 
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
    <link rel="stylesheet" href="studentpage.css">
</head>
<body>
<?php include 'userheader.php' ?>
<br>
<div id="pointstore" class="pointstorebox">
    <h2 class="energyuse">Available Vouchers</h2>

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
                
            </div>
        <?php endwhile; ?>
    </div>
</div>
<h1 id="addc">Publish new voucher</h1>
    <div class="add">
        <div class="record-content">
            <h2>Vouchers</h2>
            <form method="POST" action="">

                <div class="input">
                    <label>store name</label>
                    <input type="text" class="voucher" name="store_name" required cols="30" rows="5" placeholder="enter the store name">
                </div>

                <div class="input">
                    <label>description</label>
                    <textarea type="text" name="description" required placeholder="enter the voucher description" cols="30" rows="5"></textarea>
                </div>

                <div class="input">
                    <label>point needed</label>
                    <input type="number" name="point_needed" min="10" placeholder="example: 20" required>
                </div>

                <div class="input">
                    <label>discount</label>
                    <input type="text" class="voucher" name="discount" required placeholder="example: 20% off">
                </div>
                <button type="submit" class="submitbtn">Submit</button>
            </form>
        </div>
    </div>
<?php include 'footer.php' ?>
</body>
</html>