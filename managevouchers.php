<?php
session_start();
$user = $_SESSION['username'] ?? 'Guest';

$servername = "localhost";
$username_db = "root";
$password_db = "";
$dbname = "assignment"; 

$conn = mysqli_connect($servername, $username_db, $password_db, $dbname);
if (!$conn) die("Connection failed: " . mysqli_connect_error());

// 删除 voucher
if (isset($_POST['delete_id'])) {
    $id = $_POST['delete_id'];
    mysqli_query($conn, "DELETE FROM voucher WHERE voucher_id = '$id'");
    echo "<script>alert('Voucher deleted successfully!'); window.location.href='managevouchers.php';</script>";
    exit();
}

// 编辑 voucher
if (isset($_POST['edit_id'])) {
    $id          = $_POST['edit_id'];
    $store       = $_POST['edit_store'];
    $description = $_POST['edit_description'];
    $discount    = $_POST['edit_discount'];
    $points      = $_POST['edit_points'];

    mysqli_query($conn, "UPDATE voucher 
                         SET store_name = '$store', description = '$description', discount = '$discount', points_needed = '$points'
                         WHERE voucher_id = '$id'");
    echo "<script>alert('Voucher updated successfully!'); window.location.href='managevouchers.php';</script>";
    exit();
}

// 创建新 voucher
if (isset($_POST['new_store'])) {
    $store       = $_POST['new_store'];
    $description = $_POST['new_description'];
    $discount    = $_POST['new_discount'];
    $points      = $_POST['new_points'];

    mysqli_query($conn, "INSERT INTO voucher (store_name, description, discount, points_needed) 
                         VALUES ('$store', '$description', '$discount', '$points')");
    echo "<script>alert('Voucher created successfully!'); window.location.href='managevouchers.php';</script>";
    exit();
}

$result = mysqli_query($conn, "SELECT * FROM voucher ORDER BY points_needed ASC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Vouchers</title>
    <link rel="stylesheet" href="staffpage.css">
    <style>
        /* ==========================================================================
           1. 电脑端原本样式 (原封不动)
           ========================================================================== */
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
            color: #fffefe;
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
            height: 80px;
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
            padding: 10px 24px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
            font-size: 15px;
            margin-bottom: 20px;
        }

        .cancelbtn:hover {
            background-color: #c0392b;
        }

        /* ==========================================================================
           2. 移动端/电话版专门适配样式 (当检测到屏幕宽度小于 768px 时自动重写)
           ========================================================================== */
        @media (max-width: 768px) {
            .manage-container {
                margin: 24px auto;
                padding: 0 16px;
                width: 100%;
                box-sizing: border-box;
            }

            /* 让标题在手机端排版自适应 */
            .manage-container h1.a {
                font-size: 22px;
                margin-left: 0;
            }
            .manage-container hr {
                margin-left: 0;
                margin-right: 0;
            }

            /* 方便用手指触控，让添加按钮撑满屏幕宽度 */
            .createbtn {
                width: 100%;
                padding: 12px;
                font-size: 16px;
                margin-bottom: 16px;
                box-sizing: border-box;
            }

            /* 核心修改：让过宽的长表格在手机屏幕内支持横向划动，绝不撑爆整个网页 */
            .usagetable {
                display: block;
                width: 100% !important;
                overflow-x: auto;
                -webkit-overflow-scrolling: touch; /* 顺滑滚动 */
                white-space: nowrap; /* 文本不换行 */
                background: #0d1526; /* 统一暗色系背景防止露出白底 */
            }

            .usagetable th, .usagetable td {
                padding: 10px 12px;
                font-size: 13px;
            }

            /* 移动端弹窗盒子宽度自适应与边距调整 */
            .modal {
                padding: 16px;
                box-sizing: border-box;
            }

            .modal-box {
                width: 100%;
                max-width: 400px;
                padding: 20px;
            }

            /* 增加输入框在手机端的触碰高度 */
            .modal-box input,
            .modal-box textarea {
                padding: 12px;
                font-size: 15px;
                margin-bottom: 12px;
            }

            /* 弹窗底部 Save 与 Cancel 按钮并排各占一半 */
            .modal-buttons {
                gap: 8px;
            }
            .modal-buttons button, 
            .modal-buttons .createbtn, 
            .modal-buttons .cancelbtn {
                flex: 1;
                width: auto;
                margin-bottom: 0;
                padding: 12px 0;
                font-size: 14px;
                text-align: center;
                display: inline-block;
            }
        }
    </style>
</head>
<body>
    <?php include 'userheader.php' ?>

    <div class="manage-container">
        <h1 class="a">Manage Vouchers</h1>
        <hr>

        <button class="createbtn" onclick="openCreate()">+ Create New Voucher</button>

        <table class="usagetable">
            <tr class="top">
                <th>ID</th>
                <th>Store Name</th>
                <th>Description</th>
                <th>Discount</th>
                <th>Points Needed</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?php echo $row['voucher_id']; ?></td>
                <td><?php echo $row['store_name']; ?></td>
                <td><?php echo $row['description']; ?></td>
                <td><?php echo $row['discount']; ?></td>
                <td><?php echo $row['points_needed']; ?> pts</td>
                <td>
                    <button class="editbtn" onclick="openEdit(
                        '<?php echo $row['voucher_id']; ?>',
                        '<?php echo addslashes($row['store_name']); ?>',
                        '<?php echo addslashes($row['description']); ?>',
                        '<?php echo addslashes($row['discount']); ?>',
                        '<?php echo $row['points_needed']; ?>'
                    )">Edit</button>
                </td>
                <td>
                    <form action="managevouchers.php" method="post" onsubmit="return confirm('Are you sure to delete this voucher?')">
                        <input type="hidden" name="delete_id" value="<?php echo $row['voucher_id']; ?>">
                        <button class="deletebtn" type="submit">Delete</button>
                    </form>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>

    <div class="modal" id="editModal">
        <div class="modal-box">
            <h3>Edit Voucher</h3>
            <form action="managevouchers.php" method="post">
                <input type="hidden" name="edit_id"          id="modal_id">
                <input type="text"   name="edit_store"       id="modal_store"       placeholder="Store Name">
                <textarea            name="edit_description" id="modal_description" placeholder="Description"></textarea>
                <input type="text"   name="edit_discount"    id="modal_discount"    placeholder="Discount e.g. 10% off">
                <input type="number" name="edit_points"      id="modal_points"      placeholder="Points Needed">
                <div class="modal-buttons">
                    <button class="createbtn"   type="submit">Save</button>
                    <button class="cancelbtn" type="button" onclick="closeEdit()">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <div class="modal" id="createModal">
        <div class="modal-box">
            <h3>Create New Voucher</h3>
            <form action="managevouchers.php" method="post">
                <input type="text"   name="new_store"       placeholder="Store Name"               required>
                <textarea            name="new_description" placeholder="Description"              required></textarea>
                <input type="text"   name="new_discount"    placeholder="Discount e.g. 10% off"    required>
                <input type="number" name="new_points"      placeholder="Points Needed"             required>
                <div class="modal-buttons">
                    <button class="createbtn" type="submit">Create</button>
                    <button class="cancelbtn" type="button" onclick="closeCreate()">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openEdit(id, store, description, discount, points) {
            document.getElementById('modal_id').value          = id;
            document.getElementById('modal_store').value       = store;
            document.getElementById('modal_description').value = description;
            document.getElementById('modal_discount').value    = discount;
            document.getElementById('modal_points').value      = points;
            document.getElementById('editModal').classList.add('active');
        }

        function closeEdit() {
            document.getElementById('editModal').classList.remove('active');
        }

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