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

// 接收从按钮传过来的资料
$room_number = $_POST['room_number'];
$dorm_block  = $_POST['dorm_block'];

// 如果按了 Confirm，更新 alert_level 然后跳回
if (isset($_POST['confirm']) && $_POST['confirm'] == 1) {
    $description = $_POST['description']; // 获取描述信息
    $username = $_POST['username'];
    $update = "UPDATE electric_usage 
               SET alert_level = 1,
               alert_description = '$description'
               WHERE username = '$username' 
               AND room_number = '$room_number' 
               AND dorm_block = '$dorm_block'
               ORDER BY record_date DESC 
               LIMIT 1";
    mysqli_query($conn, $update);
    echo "<script>alert('Alert sent to $username !'); window.location.href='sendalertpage.php';</script>";
    exit();
}

// 用 room_number 和 dorm_block 查询最新那一条记录
$sql = "SELECT * FROM electric_usage 
        WHERE room_number = '$room_number' AND dorm_block = '$dorm_block' 
        ORDER BY record_date DESC 
        LIMIT 1";

$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Send Alert - Voltcampus</title>
    <link rel="stylesheet" href="staffpage.css">
    <style>
        .alert-container {
            max-width: 700px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .alert-card {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            padding: 30px;
            margin-top: 20px;
        }

        .alert-card h2 {
            color: #1a2a44;
            margin-bottom: 20px;
            font-size: 22px;
        }

        .alert-card table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
        }

        .alert-card th {
            background-color: #4fb2fd;
            color: white;
            padding: 12px 15px;
            text-align: left;
        }

        .alert-card td {
            padding: 12px 15px;
            border-bottom: 1px solid #f0f0f0;
            color: #444;
        }

        .alert-card tr:last-child td {
            border-bottom: none;
        }

        .high-usage {
            color: red;
            font-weight: bold;
        }

        .warning-box {
            background-color: #fff3cd;
            border: 1px solid #ffc107;
            border-radius: 8px;
            padding: 15px 20px;
            margin-bottom: 25px;
            color: #856404;
            font-size: 15px;
        }

        .warning-box span {
            font-weight: bold;
        }

        .btn-row {
            display: grid;
            gap: 15px;
        }

        .confirmbtn {
            background-color: #e74c3c;
            color: white;
            border: none;
            padding: 12px 28px;
            border-radius: 8px;
            font-size: 15px;
            cursor: pointer;
            font-weight: bold;
            transition: 0.3s;
        }

        .confirmbtn:hover {
            background-color: #c0392b;
        }

        .cancelbtn {
            background-color: #aaa;
            color: white;
            border: none;
            padding: 12px 28px;
            border-radius: 8px;
            font-size: 15px;
            cursor: pointer;
            font-weight: bold;
            transition: 0.3s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
        }
        .description{
            width: 100%;

        }

        .cancelbtn:hover {
            background-color: #888;
        }
    </style>
</head>
<body>
    <?php include 'userheader.php' ?>

    <div class="alert-container">
        <h1 class="a">Send Alert</h1>
        <p class="a">Please review the details below before confirming the alert.</p>
        <hr>

        <div class="alert-card">
            <h2>Room Detail</h2>

            <table>
                <tr class="top">
                    <th>Block</th>
                    <th>Room Number</th>
                    <th>Student Name</th>
                    <th>Usage (kWh)</th>
                    <th>Date</th>
                </tr>
                <tr>
                    <td><?php echo $row['dorm_block']; ?></td>
                    <td><?php echo $row['room_number']; ?></td>
                    <td><?php echo $row['username']; ?></td>
                    <td class="high-usage"><?php echo $row['usage_kwh']; ?> kWh</td>
                    <td><?php echo $row['record_date']; ?></td>
                </tr>
            </table>


            <div class="warning-box">
                This student's electricity usage exceeds <span>20 kWh</span>. 
                Sending an alert will notify <span><?php echo $row['username']; ?></span> 
                to reduce their energy consumption.
            </div>
            

            <div class="btn-row">
                <!-- Confirm 按钮：把所有资料传回同一个页面处理 -->
                <form action="sendalertfunction.php" method="post">
                    <input type="hidden" name="room_number" value="<?php echo $row['room_number']; ?>">
                    <input type="hidden" name="dorm_block"  value="<?php echo $row['dorm_block']; ?>">
                    <input type="hidden" name="username"    value="<?php echo $row['username']; ?>">
                    <input type="hidden" name="confirm"     value="1">
                    <div class="description-box">
                        <p>Description:</p>
                        <textarea class='description' id="description" name="description" rows="4" cols="50" placeholder="Enter alert description..."></textarea>
                    </div>
                        <div>

                <!-- Cancel 按钮：回到 staffpage -->
                            <button class="confirmbtn" type="submit">Confirm Send Alert</button>

                            <a href="sendalertpage.php" class="cancelbtn">Cancel</a>
                        </div>
                    
                </form>
                
            </div>
        </div>
    </div>

    <?php include 'footer.php' ?>
</body>
</html>