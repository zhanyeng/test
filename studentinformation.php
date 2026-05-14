<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "assignment"; 

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}


$name = $_SESSION['username'] ?? ($_GET['name'] ?? 'Guest');

if (isset($_POST['btnSave'])) {
    
    
    //get information
    $name = $_POST['username']; 
    $tpnumber = $_POST['tpnumber'];
    $dorm = $_POST['block'];
    $room = $_POST['roomnumber'];

    $_SESSION['roomnumber']=$room;//get room as roomnuber and send to studentpage
    $sql = "INSERT INTO student_information (name, tpnumber, dorm_block, room_number) 
            VALUES ('$name', '$tpnumber', '$dorm', '$room')";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Profile saved successfully!'); window.location.href='studentpage.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complete Profile</title>
    <link rel="stylesheet" href="studentinformation.css">
</head>
<body>
    <div class="header">
        <div class="header-content">
            <h2 class="logo">Voltcampus</h2>
            <div class="header-links"><a href="homepage.php">Home</a></div>
        </div>
    </div>

    <div class="container">
        <div class="info-card">
            <h1>Student Details</h1>
            <p>Complete your information below</p>
            
            <form action="#" method="post">
                <div class="form-group">
                    <label>Full Name:</label>
                    <input type="text" value="<?php echo $name; ?>" disabled>
                    <input type="hidden" name="username" value="<?php echo $display_name; ?>">
                </div>

                <div class="form-group">
                    <label>TP Number:</label>
                    <input type="text" name="tpnumber" placeholder="Enter your TP Number" required>
                </div>

                <div class="form-group">
                    <label>Dormitory Block:</label>
                    <select name="block" required>
                        <option value="">-- Select Block --</option>
                        <option value="Block A">Block A</option>
                        <option value="Block B">Block B</option>
                        <option value="Block C">Block C</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Room Number:</label>
                    <input type="text" name="roomnumber" placeholder="e.g. 305" required>
                </div>

                <input type="submit" value="Save Information" name="btnSave" class="submit-btn">
            </form>
        </div>
    </div>
    <?php
    include "footer.php";
    ?>
</body>
</html>