<?php
session_start();
$user = $_SESSION['username'] ?? 'Guest';

$servername = "localhost";
$username_db = "root";
$password_db = "";
$dbname = "assignment"; 

$conn = mysqli_connect($servername, $username_db, $password_db, $dbname);
if (!$conn) die("Connection failed: " . mysqli_connect_error());

// 删除 challenge
if (isset($_POST['delete_id'])) {
    $id = $_POST['delete_id'];
    mysqli_query($conn, "DELETE FROM challenge WHERE challenge_id = '$id'");
    echo "<script>alert('Challenge deleted successfully!'); window.location.href='managechallenges.php';</script>";
    exit();
}

// 编辑 challenge
if (isset($_POST['edit_id'])) {
    $id          = $_POST['edit_id'];
    $description = $_POST['edit_description'];
    $points      = $_POST['edit_points'];
    $deadline    = $_POST['edit_deadline'];
    $target      = $_POST['edit_target'];

    mysqli_query($conn, "UPDATE challenge 
                         SET description = '$description', points = '$points', deadline = '$deadline', target_kwh = '$target'
                         WHERE challenge_id = '$id'");
    echo "<script>alert('Challenge updated successfully!'); window.location.href='managechallenges.php';</script>";
    exit();
}

// 创建新 challenge
if (isset($_POST['new_description'])) {
    $description = $_POST['new_description'];
    $points      = $_POST['new_points'];
    $deadline    = $_POST['new_deadline'];
    $target      = $_POST['new_target'];

    mysqli_query($conn, "INSERT INTO challenge (description, points, deadline, target_kwh) 
                         VALUES ('$description', '$points', '$deadline', '$target')");
    echo "<script>alert('Challenge created successfully!'); window.location.href='managechallenges.php';</script>";
    exit();
}

$result = mysqli_query($conn, "SELECT * FROM challenge ORDER BY deadline ASC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Challenges</title>
    <link rel="stylesheet" href="staffpage.css">
    <style>
        /* ==========================================
           1. 电脑端原本样式 (完全保留，不作任何变动)
           ========================================== */
        .manage-container {
            max-width: 1100px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .usagetable {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 40px;
        }

        .usagetable th {
            background-color: #4fb2fd;
            color: white;
            padding: 12px 15px;
            text-align: left;
        }

        .usagetable td {
            padding: 12px 15px;
            border-bottom: 1px solid #f0f0f0;
            color: #fefefe;
        }

        .deletebtn {
            background-color: #e74c3c;
            color: white;
            border: none;
            padding: 7px 16px;
            border-radius: 6px;
            cursor: pointer;
            font-weight: bold;
        }

        .deletebtn:hover {
            background-color: #c0392b;
        }

        .editbtn {
            background-color: #4fb2fd;
            color: white;
            border: none;
            padding: 7px 16px;
            border-radius: 6px;
            cursor: pointer;
            font-weight: bold;
        }

        .editbtn:hover {
            background-color: #3a9de0;
        }

        .createbtn {
            background-color: #2ecc71;
            color: white;
            border: none;
            padding: 10px 24px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
            font-size: 15px;
            margin-bottom: 20px;
        }

        .createbtn:hover {
            background-color: #27ae60;
        }

        .modal {
            display: none;
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 999;
            justify-content: center;
            align-items: center;
        }

        .modal.active {
            display: flex;
        }

        .modal-box {
            background: white;
            padding: 30px;
            border-radius: 12px;
            width: 450px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.2);
        }

        .modal-box h3 {
            margin-bottom: 20px;
            color: #1a2a44;
        }

        .modal-box input,
        .modal-box textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 14px;
            box-sizing: border-box;
        }

        .modal-box textarea {
            height: 100px;
            resize: vertical;
        }

        .modal-buttons {
            display: flex;
            gap: 10px;
        }

        .cancelbtn {
            background-color: #e74c3c;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
        }

        .cancelbtn:hover {
            background-color: #c0392b;
        }
        
        .createbtn2{
            background-color: #2ecc71;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
        }
        
        .createbtn2:hover {
            background-color: #27ae60;
        }
        
        .expired {
            color: red;
            font-weight: bold;
        }

        .active-challenge {
            color: green;
            font-weight: bold;
        }

        /* ==========================================
           2. 手机/电话版适配样式 (小于 768px 时自动生效)
           ========================================== */
        @media (max-width: 768px) {
            /* 调整手机端外边距，与你的 header/footer 对齐 */
            .manage-container {
                margin: 24px auto;
                padding: 0 16px;
                width: 100%;
                box-sizing: border-box;
            }

            /* 让标题和分割线在手机端缩进与大货一致 */
            .manage-container h1.a {
                font-size: 22px;
                margin-left: 0;
            }
            .manage-container hr {
                margin-left: 0;
                margin-right: 0;
            }

            /* 铺满宽度的创建按钮 */
            .createbtn {
                width: 100%;
                padding: 12px;
                font-size: 16px;
                margin-bottom: 16px;
            }

            /* CRITICAL: 给表格套一层横向滚动，防止长表格把手机网页撑裂出现左右滑动的死角 */
            .usagetable {
                display: block;
                width: 100% !important;
                overflow-x: auto;
                -webkit-overflow-scrolling: touch; /* 让 iOS 滑动更流畅 */
                white-space: nowrap; /* 确保表格内容在一行内不换行折叠 */
                border: 1px solid rgba(255, 255, 255, 0.05);
                background: #0d1526; /* 适配暗色网页底色 */
            }

            .usagetable th, .usagetable td {
                padding: 10px 12px;
                font-size: 13px;
            }

            /* ===== 手机端模态框弹窗微调 ===== */
            .modal {
                padding: 16px;
                box-sizing: border-box;
            }

            .modal-box {
                width: 100%; /* 宽度自动缩减为手机屏幕宽度 */
                max-width: 400px;
                padding: 20px;
                background: #ffffff;
            }

            /* 增大手机端输入框的触控面积 */
            .modal-box input,
            .modal-box textarea {
                padding: 12px;
                font-size: 15px;
                margin-bottom: 12px;
            }

            /* 手机端的弹窗底部的两个按钮对半分包裹 */
            .modal-buttons {
                gap: 8px;
            }
            .modal-buttons button {
                flex: 1;
                padding: 12px 0;
                font-size: 14px;
                text-align: center;
            }
        }
    </style>
</head>
<body>
    <?php include 'userheader.php' ?>

    <div class="manage-container">
        <h1 class="a">Manage Challenges</h1>
        <hr>

        <button class="createbtn" onclick="openCreate()">+ Create New Challenge</button>

        <table class="usagetable">
            <tr class="top">
                <th>ID</th>
                <th>Description</th>
                <th>Points</th>
                <th>Deadline</th>
                <th>Target (kWh)</th>
                <th>Status</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?php echo $row['challenge_id']; ?></td>
                <td><?php echo $row['description']; ?></td>
                <td><?php echo $row['points']; ?></td>
                <td><?php echo $row['deadline']; ?></td>
                <td><?php echo $row['target_kwh']; ?> kWh</td>
                <td>
                    <?php if ($row['deadline'] < date('Y-m-d')): ?>
                        <span class="expired">Expired</span>
                    <?php else: ?>
                        <span class="active-challenge">Active</span>
                    <?php endif; ?>
                </td>
                <td>
                    <button class="editbtn" onclick="openEdit(
                        '<?php echo $row['challenge_id']; ?>',
                        '<?php echo addslashes($row['description']); ?>',
                        '<?php echo $row['points']; ?>',
                        '<?php echo $row['deadline']; ?>',
                        '<?php echo $row['target_kwh']; ?>'
                    )">Edit</button>
                </td>
                <td>
                    <form action="managechallenges.php" method="post" onsubmit="return confirm('Are you sure to delete this challenge?')">
                        <input type="hidden" name="delete_id" value="<?php echo $row['challenge_id']; ?>">
                        <button class="deletebtn" type="submit">Delete</button>
                    </form>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>

    <div class="modal" id="editModal">
        <div class="modal-box">
            <h3>Edit Challenge</h3>
            <form action="managechallenges.php" method="post">
                <input type="hidden"  name="edit_id"          id="modal_id">
                <textarea            name="edit_description"  id="modal_description"  placeholder="Description"></textarea>
                <input type="number" name="edit_points"       id="modal_points"       placeholder="Points">
                <input type="date"   name="edit_deadline"     id="modal_deadline">
                <input type="number" name="edit_target"       id="modal_target"       placeholder="Target kWh" step="0.01">
                <div class="modal-buttons">
                    <button class="editbtn"   type="submit">Save</button>
                    <button class="cancelbtn" type="button" onclick="closeEdit()">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <div class="modal" id="createModal">
        <div class="modal-box">
            <h3>Create New Challenge</h3>
            <form action="managechallenges.php" method="post">
                <textarea            name="new_description"  placeholder="Description" required></textarea>
                <input type="number" name="new_points"       placeholder="Points"      required>
                <input type="date"   name="new_deadline"                                required>
                <input type="number" name="new_target"       placeholder="Target kWh"  step="0.01" required>
                <div class="modal-buttons">
                    <button class="createbtn2" type="submit">Create</button>
                    <button class="cancelbtn" type="button" onclick="closeCreate()">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Edit modal
        function openEdit(id, description, points, deadline, target) {
            document.getElementById('modal_id').value          = id;
            document.getElementById('modal_description').value = description;
            document.getElementById('modal_points').value      = points;
            document.getElementById('modal_deadline').value    = deadline;
            document.getElementById('modal_target').value      = target;
            document.getElementById('editModal').classList.add('active');
        }

        function closeEdit() {
            document.getElementById('editModal').classList.remove('active');
        }

        // Create modal
        function openCreate() {
            document.getElementById('createModal').classList.add('active');
        }

        function closeCreate() {
            document.getElementById('createModal').classList.remove('active');
        }
    </script>

    <?php include 'footer.php' ?>
</body>
</html>