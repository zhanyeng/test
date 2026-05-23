<?php
session_start();
$user = $_SESSION['username'] ?? 'Guest';

$conn = mysqli_connect("localhost", "root", "", "assignment");
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
    </style>
</head>
<body>
    <?php include 'userheader.php' ?>

    <div class="manage-container">
        <h1 class="a">Manage Challenges</h1>
        <hr>

        <!-- 创建按钮 -->
        <button class="createbtn" onclick="openCreate()">+ Create New Challenge</button>

        <!-- Challenges 列表 -->
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

    <!-- Edit Modal -->
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

    <!-- Create Modal -->
    <div class="modal" id="createModal">
        <div class="modal-box">
            <h3>Create New Challenge</h3>
            <form action="managechallenges.php" method="post">
                <textarea            name="new_description"  placeholder="Description" required></textarea>
                <input type="number" name="new_points"       placeholder="Points"      required>
                <input type="date"   name="new_deadline"                               required>
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