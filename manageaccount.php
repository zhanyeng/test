<?php
session_start();
$user = $_SESSION['username'] ?? 'Guest';

$servername = "localhost";
$username_db = "root";
$password_db = "";
$dbname = "assignment"; 

$conn = mysqli_connect($servername, $username_db, $password_db, $dbname);
if (!$conn) die("Connection failed: " . mysqli_connect_error());

// 删除用户
if (isset($_POST['delete_id'])) {
    $id = $_POST['delete_id'];
    mysqli_query($conn, "DELETE FROM user WHERE user_id = '$id'");
    echo "<script>alert('User deleted successfully.'); window.location.href='manageaccount.php';</script>";
    exit();
}

// 编辑用户
if (isset($_POST['edit_id'])) {
    $id       = $_POST['edit_id'];
    $username = $_POST['edit_username'];
    $email    = $_POST['edit_email'];
    $contact  = $_POST['edit_contact'];
    $role     = $_POST['edit_role'];

    mysqli_query($conn, "UPDATE user 
                         SET username = '$username', email = '$email', contact_number = '$contact', role = '$role'
                         WHERE user_id = '$id'");
    echo "<script>alert('User updated successfully.'); window.location.href='manageaccount.php';</script>";
    exit();
}

// 搜索
$search = '';
if (isset($_GET['search'])) {
    $search = $_GET['search'];
    $query = "SELECT * FROM user WHERE role != 'manager' AND (username LIKE '%$search%' OR email LIKE '%$search%' OR role LIKE '%$search%') ORDER BY user_id ASC";
} else {
    $query = "SELECT * FROM user WHERE role != 'manager' ORDER BY user_id ASC";
}

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Account</title>
    <link rel="stylesheet" href="staffpage.css">
    <style>
        .manage-container {
            max-width: 1100px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .search-bar {
            margin-bottom: 20px;
            display: flex;
            gap: 10px;
        }

        .search-bar input {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 8px;
            width: 300px;
            font-size: 14px;
        }

        .search-bar button {
            padding: 10px 20px;
            background-color: #4fb2fd;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
        }

        .search-bar button:hover {
            background-color: #3a9de0;
        }

        .usagetable {
            width: 100%;
            border-collapse: collapse;
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
            color: #444;
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

        /* Modal */
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
            width: 400px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.2);
        }

        .modal-box h3 {
            margin-bottom: 20px;
            color: #1a2a44;
        }

        .modal-box input,
        .modal-box select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 14px;
            box-sizing: border-box;
        }

        .modal-buttons {
            display: flex;
            gap: 10px;
        }

        .cancelbtn {
            background-color: #aaa;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
        }

        .cancelbtn:hover {
            background-color: #888;
        }
    </style>
</head>
<body>
    <?php include 'userheader.php' ?>

    <div class="manage-container">
        <h1 class="a">Manage Account</h1>
        <hr>

        <!-- 搜索栏 -->
        <form action="manageaccount.php" method="get">
            <div class="search-bar">
                <input type="text" name="search" placeholder="Search by username, email or role..." value="<?php echo $search; ?>">
                <button type="submit">Search</button>
                <?php if ($search != ''): ?>
                    <a href="manageaccount.php" style="padding: 10px 16px; background:#aaa; color:white; border-radius:8px; text-decoration:none; font-weight:bold;">Clear</a>
                <?php endif; ?>
            </div>
        </form>

        <!-- 用户列表 -->
        <table class="usagetable">
            <tr class="top">
                <th>ID</th>
                <th>Username</th>
                <th>Email</th>
                <th>Contact</th>
                <th>Role</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?php echo $row['user_id']; ?></td>
                <td><?php echo $row['username']; ?></td>
                <td><?php echo $row['email']; ?></td>
                <td><?php echo $row['contact_number']; ?></td>
                <td><?php echo $row['role']; ?></td>
                <td>
                    <!-- 编辑按钮，点击弹出 modal -->
                    <button class="editbtn" onclick="openEdit(
                        '<?php echo $row['user_id']; ?>',
                        '<?php echo $row['username']; ?>',
                        '<?php echo $row['email']; ?>',
                        '<?php echo $row['contact_number']; ?>',
                        '<?php echo $row['role']; ?>'
                    )">Edit</button>
                </td>
                <td>
                    <!-- 删除按钮 -->
                    <form action="manageaccount.php" method="post" onsubmit="return confirm('Are you sure to delete <?php echo $row['username']; ?>?')">
                        <input type="hidden" name="delete_id" value="<?php echo $row['user_id']; ?>">
                        <button class="deletebtn" type="submit">Delete</button>
                    </form>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>

    <!-- Edit Modal -->
    <div class="modal" id="editModal">
        <div class="modal-box">
            <h3>Edit Account</h3>
            <form action="manageaccount.php" method="post">
                <input type="hidden" name="edit_id" id="modal_id">
                <input type="text"   name="edit_username" id="modal_username" placeholder="Username">
                <input type="text"   name="edit_email"    id="modal_email"    placeholder="Email">
                <input type="text"   name="edit_contact"  id="modal_contact"  placeholder="Contact Number">
                <select name="edit_role" id="modal_role">
                    <option value="student">Student</option>
                    <option value="staff">Staff</option>
                    <option value="admin">Admin</option>
                </select>
                <div class="modal-buttons">
                    <button class="editbtn" type="submit">Save</button>
                    <button class="cancelbtn" type="button" onclick="closeEdit()">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openEdit(id, username, email, contact, role) {
            document.getElementById('modal_id').value       = id;
            document.getElementById('modal_username').value = username;
            document.getElementById('modal_email').value    = email;
            document.getElementById('modal_contact').value  = contact;
            document.getElementById('modal_role').value     = role;
            document.getElementById('editModal').classList.add('active');
        }

        function closeEdit() {
            document.getElementById('editModal').classList.remove('active');
        }
    </script>

    <?php include 'footer.php' ?>
</body>
</html>