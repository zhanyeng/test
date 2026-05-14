<style>
    body {
        margin: 0;
        padding: 0;
        background: linear-gradient(to top, rgb(123, 215, 255), rgb(246, 255, 252));
    }

    .header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin: 0;
        padding: 0 20px; 
        font-family: Arial, sans-serif;
        width: 100%;
        height: 70px; 
        background-color: #4fb2fd;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
        box-sizing: border-box;
    }

    .header-left {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .logo {
        margin: 0;
        font-size: 24px;
        font-weight: bold;
        color: #ffffff;
    }

    .username {
        color: white;
        font-weight: bold;
    }

    .menu-btn {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        width: 25px;
        height: 18px;
    }

    .menu-btn span {
        display: block;
        height: 3px;
        width: 100%;
        background-color: white;
        border-radius: 3px;
        transition: 0.3s;
    }

    .side-menu {
        position: fixed;
        z-index: 1000;

        top: 0;
        left: -250px;
        width: 250px;
        height: 100%;
        background-color: #ffffff;
        box-shadow: 2px 0px 15px rgba(0, 0, 0, 0.2);
        transition: 0.4s ease;
        padding-top: 60px;
    }

    .side-menu.active {
        left: 0;
    }

    .side-menu a,.menu {
        display: block;
        padding: 15px 25px;
        text-decoration: none;
        color: #333;
        font-size: 18px;
        border-bottom: 1px solid #f0f0f0;
        transition: 0.3s;
    }
    .menu{
        font-size:150%;
    }

    .side-menu a:hover {
        background-color: #4fb2fd;
        color: white;
    }

    .overlay {
        z-index: 999;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        display: none;
    }

    .overlay.active {
        display: block;
    }

    .close-btn {
        position: absolute;
        top: 15px;
        right: 20px;
        font-size: 30px;
        cursor: pointer;
        color: #888;
    }
    .frame{
        width: 30px;
        height: 30px;
        overflow:hidden;
        boder:1px solid black;
        boder-radius:50%;
       
    }
    .userpicture{
        width: 100%;
        height: 100%;
    }
    @keyframes header {
    from {
        opacity: 0;
        transform: translateY(-50px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}.header {
    animation: header 1.2s ease-out forwards;
}
</style>

<?php

$role = $_SESSION['role'] ?? "unknow";
$current_user = $_SESSION['username'] ?? 'Guest';
?>

<div class="overlay" id="overlay" onclick="openmenu()"></div>

<div class="side-menu" id="sideMenu">
    <?php if($role == 'student'): ?>
        <h1 class="menu">MENU</h1>
        <a href="studentpage.php">Dashboard</a>
        <a href="#energy">Energy usage</a>
        <a href="#challenges">challenges</a>
        <a href="#mychallenges">my challenges</a>
        <a href="#pointstore">point store</a>
        <a href="homepage.php" style="color: #ff4d4d;">Logout</a>

    <?php elseif ($role == 'staff'): ?>
        <h1 class="menu">MENU</h1>
        <a href="staffpage.php">Dashboard</a>
        <a href="#eu">energy usage</a>
        <a href="#ac">available challenges</a>
        <a href="#jc">joined challenges</a>
        <a href="#addc">add challenge</a>
        <a href="homepage.php" style="color: #ff4d4d;">Logout</a>

    <?php elseif ($role == 'admin'): ?>
        <h1 class="menu">MENU</h1>
        <a href="adminpage.php">Dashboard</a>
        <a href="sendalertpage.php">Send Alert</a>
        <a href="publishvoucher.php">Publish Voucher</a>
        <a href="#settings">Settings</a>
        <a href="homepage.php" style="color: #ff4d4d;">Logout</a>

    <?php elseif ($role == 'manager'): ?>
        <h1 class="menu">MENU</h1></a>
        <a href="managerpage.php">Dashboard</a>
        <a href="managewastedelectricity.php">Manage Wasted Electricity</a>
        <a href="manageaccounts.php">Manage Accounts</a>
        <a href="managechallenges.php">Manage Challenges</a>
        <a href="managevouchers.php">Manage Vouchers</a>
        <a href="homepage.php" style="color: #ff4d4d;">Logout</a>

    <?php endif; ?>

        
</div>

<div class="header">
    <div class="header-left">
        <div class="menu-btn" onclick="openmenu()">
            <span></span>
            <span></span>
            <span></span>
        </div>
        <h2 class="logo">Voltcampus</h2>
    </div>
    
    
    <div style="display:flex; align-items:center; gap:10px;">
        <span class="username"><?php echo $current_user; ?></span>
        <div class="frame">
            <img class="userpicture" src="https://pluspng.com/img-png/user-png-icon-big-image-png-2240.png">
        </div>
    </div>
</div>

<script>
    function openmenu() {
        const menu = document.getElementById('sideMenu');
        const overlay = document.getElementById('overlay');
        
        menu.classList.toggle('active');
        overlay.classList.toggle('active');
    }
</script>