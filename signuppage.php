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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user    = $_POST['username'];
    $pass    = $_POST['password']; 
    $email   = $_POST['email'];
    $contact = $_POST['contact_number'];
    $role    = $_POST['role'];

    $check = mysqli_query($conn, "SELECT * FROM user WHERE username = '$user'");
    if (mysqli_num_rows($check) > 0) {
        echo "<script>alert('Username already taken, please choose another one.'); window.location.href='signuppage.php';</script>";
        exit();
    }

    $sql = "INSERT INTO user (username, password, email, contact_number, role) 
            VALUES ('$user', '$pass', '$email', '$contact', '$role')";

    if (mysqli_query($conn, $sql)) {
        $_SESSION['username'] = $user;
        
        if ($role == "student") {
            echo "<script>
                    alert('you need to complete your information'); 
                    window.location.href='studentinformation.php';
                  </script>";
        } else {
            echo "<script>
                    alert('Account created successfully!'); 
                    window.location.href='loginpage.php';
                  </script>";
        }
    } else {
        echo "Error: " . mysqli_error($conn);
    }
    
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup - Voltcampus</title>
    <link rel="stylesheet" href="signuppage.css">

    </style>
</head>
<body>

       <?php include "header.php"?>


    <div class="signupbox">
        <div class="informationbox">
            <h1>Sign Up</h1>
            <form action="" method="POST">

                <div class="form"> 
                    <label>Username</label>
                    <input type="text" name="username" placeholder="enter your name" required>


                </div>
                
                <div class="form">
                    <label>Email Address</label>
                    <input type="email" name="email" placeholder="xxxxxxxx@gmail.com" required>
                </div>

                <div class="form">
                    <label>Contact Number</label>
                    <input type="text" name="contact_number" placeholder="enter your contact number" required>
                </div>

                <div class="form">
                    <label>Password</label>
                    <input type="password" name="password" placeholder="Enter your password" required>
                </div>

                <div class="form">
                    <label>Role</label>
                    <select name="role" required>
                        <option value="student">Student</option>
                        <option value="staff">Staff</option>
                        <option value="admin">Admin</option>
                        <option value="manager">Facility Manager</option>
                    </select>
                </div>

                <button type="submit" class="signupbtn">Create Account</button>
            </form>

            <div class="loginbtn">
                Already a member? <a href="loginpage.php">Login</a>
            </div>
        </div>
    </div>
    <?php
        include 'footer.php';
        ?>

</body>
</html>