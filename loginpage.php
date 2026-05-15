<?php
session_start(); 

$servername = "localhost";
$username_db = "root";
$password_db = "";
$dbname = "assignment"; 

$conn = mysqli_connect($servername, $username_db, $password_db, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM user WHERE username = '$username' AND password = '$password'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        
       
        $_SESSION['username'] = $row['username'];
        $_SESSION['role'] = $row['role']; //send to header to know what role
        
        $role = $row['role'];

       //if role is student,get room information from student information
        if ($role == 'student') {
            $student_sql = "SELECT room_number, dorm_block FROM student_information WHERE name = '$username'";
            $student_result = mysqli_query($conn, $student_sql);
    
            if ($student_row = mysqli_fetch_assoc($student_result)) {
                $_SESSION['roomnumber'] = $student_row['room_number'];
                $_SESSION['dormblock'] = $student_row['dorm_block'];
            } else {
                $_SESSION['roomnumber'] = "xxxxxx";
                $_SESSION['dormblock'] = "xxxxxx";
            }
        
        echo "<script>alert('✅login succesful,Welcome Student!'); window.location.href='studentpage.php';</script>";
        }
        else if ($role == 'staff') {
            echo "<script>alert('✅login succesful, Welcome Staff!'); window.location.href='staffpage.php';</script>";
        } 
        else if ($role == 'admin') {
            echo "<script>alert('✅login succesful, Welcome Admin!'); window.location.href='adminpage.php';</script>";
        } 
        else if ($role == 'manager') {
            echo "<script>alert('✅login succesful,Welcome Manager!'); window.location.href='managerpage.php';</script>";
        }
    } else {
        echo "<script>alert('Invalid Username or Password!');</script>";
    }
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Voltcampus</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>

    <div class="header">
        <h2 class="logo">Voltcampus</h2>
        <a href="homepage.php">Home</a>
    </div>

    <div class="loginbox">
        <div class="informationbox">
            <h1>Login</h1>
            <form action="" method="POST">
                
                <div class="form">
                    <label>Username</label>
                    <input type="text" name="username" placeholder="Enter your username" required>
                </div>

                <div class="form">
                    <label>Password</label>
                    <input type="password" name="password" placeholder="Enter your password" required>
                </div>

                <button type="submit" class="loginbtn-submit">Login</button>
            </form>

            <div class="signup-link">
                do not have account?  <a href="signuppage.php">Sign Up</a>
            </div>
        </div>
    </div>

    <?php include 'footer.php'; ?>

</body>
</html>