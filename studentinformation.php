<?php
session_start();

// 1. 连接数据库
$servername = "localhost";
$username_db = "root";
$password_db = "";
$dbname = "assignment"; 

$conn = mysqli_connect($servername, $username_db, $password_db, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// 获取当前从注册/登录页面传过来的用户名，如果没有则默认为 Guest
$name = $_SESSION['username'] ?? ($_GET['name'] ?? 'Guest');

// 2. 检查用户是否点击了保存按钮
if (isset($_POST['btnSave'])) {

    // 接收表单提交过来的数据
    $name = $_POST['username']; 
    $tpnumber = $_POST['tpnumber'];
    $dorm = $_POST['block'];      // 🎯 修复 HTML 属性后，这里能完美拿到 "Block A/B/C" 了
    $room = $_POST['roomnumber'];

    /* * 🎯 核心修复点 1：把数据完整同步到 Session 中
     * 这样跳转到 studentpage.php 后，主页和 userheader 就能立刻读取，免去再次查询数据库
     */
    $_SESSION['username'] = $name;
    $_SESSION['roomnumber'] = $room;   // 传递房间号给主页
    $_SESSION['dormblock'] = $dorm;    // 🎯 成功将选中的宿舍楼存入 Session，解决主页显示 xxxxx 的问题
    $_SESSION['role'] = 'student';     // 🎯 激活学生角色，让侧边栏 Menu 菜单正常展开

    // 3. 写入数据库 student_information 表
    $sql = "INSERT INTO student_information (name, tpnumber, dorm_block, room_number) 
            VALUES ('$name', '$tpnumber', '$dorm', '$room')";

    if (mysqli_query($conn, $sql)) {
        // 提示成功并利用 JavaScript 重定向跳转
        echo "<script>alert('Profile saved successfully!'); window.location.href='studentpage.php';</script>";
        exit();
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
    <title>Student Information — Voltcampus</title>
    <link rel="stylesheet" href="studentinformation.css">
</head>
<body>
    <?php include "userheader.php"; ?>
    
    <div class="container">
        <div class="info-card">
            <h1>Personal Information</h1>
            <p>Complete your information below</p>
            
            <form action="studentinformation.php" method="post">
                <div class="form-group">
                    <label>Full Name:</label>
                    <input type="text" value="<?php echo htmlspecialchars($name); ?>" disabled>
                    <input type="hidden" name="username" value="<?php echo htmlspecialchars($name); ?>">
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
    
    <?php include "footer.php"; ?>
</body>
</html>