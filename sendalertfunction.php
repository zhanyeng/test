<?php
session_start();

$conn = mysqli_connect("localhost", "root", "", "assignment");
if (!$conn) die("Connection failed: " . mysqli_connect_error());

// 从列表页点击 Send Alert 进来，存入 session
if (isset($_POST['from_list']) && $_POST['from_list'] == 1) {
    $_SESSION['room'] = $_POST['room'];
    $_SESSION['block'] = $_POST['block'];
    $_SESSION['date'] = $_POST['date'];
    $_SESSION['student'] = $_POST['student'];
    $_SESSION['kwh'] = $_POST['kwh'];
}

// 按了 Confirm 按钮，写入数据库
if (isset($_POST['confirm']) && $_POST['confirm'] == 1) {
    $desc = mysqli_real_escape_string($conn, $_POST['desc']);
    $room = $_SESSION['room'];
    $block = $_SESSION['block'];
    $date = $_SESSION['date'];
    $student = $_SESSION['student'];

    $sql = "UPDATE electric_usage 
            SET alert_level = 1, alert_description = '$desc'
            WHERE username = '$student' 
            AND room_number = '$room' 
            AND dorm_block = '$block'
            AND record_date = '$date'";

    $done= mysqli_query($conn, $sql);

    if ($done) {
        echo "<script>alert('Alert sent to $student !'); window.location.href='sendalertpage.php';</script>";
    } else {
        echo "<script>alert('Something went wrong, please try again.');</script>";
    }
    exit();
}

// 从 session 拿数据显示页面
$room = $_SESSION['room'] ?? '';
$block = $_SESSION['block'] ?? '';
$date = $_SESSION['date'] ?? '';
$student = $_SESSION['student'] ?? '';
$kwh = $_SESSION['kwh'] ?? '';

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

        .description {
            width: 100%;
        }

        .cancelbtn:hover {
            background-color: #888;
        }

        .description-box {
            margin-bottom: 15px;
        }

        .description-box p {
            font-weight: bold;
            margin-bottom: 8px;
            color: #1a2a44;
        }

        .btn-group {
            display: flex;
            gap: 15px;
            align-items: center;
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
                    <td><?php echo $block; ?></td>
                    <td><?php echo $room; ?></td>
                    <td><?php echo $student; ?></td>
                    <td class="high-usage"><?php echo $kwh; ?> kWh</td>
                    <td><?php echo $date; ?></td>
                </tr>
            </table>

            <div class="warning-box">
                This student's electricity usage exceeds <span>20 kWh</span>. 
                Sending an alert will notify <span><?php echo $student; ?></span> 
                to reduce their energy consumption.
            </div>

            <div class="btn-row">
                <form action="sendalertfunction.php" method="post">
                    <input type="hidden" name="confirm" value="1">

                    <div class="description-box">
                        <p>Description:</p>
                        <textarea class="description" name="desc" rows="4" placeholder="Enter alert description..."required></textarea>
                    </div>

                    <div class="btn-group">
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