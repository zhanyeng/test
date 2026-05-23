<style>

    body {
        background-color: #080e1a;
        color: #eef2f8;
        overflow-x: hidden;
        margin: 0;
        padding: 0;
        font-family: Arial, sans-serif;
    }

    .header {
        position: sticky;
        top: 0;
        z-index: 1000;
        width: 100%;
        background: rgba(8, 14, 26, 0.85); 
        backdrop-filter: blur(12px);
        border-bottom: 1px solid rgba(255, 255, 255, 0.06);
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0 24px;
        height: 64px;
        box-sizing: border-box;
        animation: header 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }

    .header-left {
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .logo {
        font-size: 20px;
        font-weight: 900;
        color: #eef2f8;
        display: flex;
        align-items: center;
        gap: 8px;
        margin: 0;
        letter-spacing: -0.5px;
    }

    .username {
        color: #eef2f8;
        font-weight: bold;
        font-size: 14px;
    }

  
    .menu-btn {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        width: 22px;
        height: 15px;
        cursor: pointer;
    }

    .menu-btn span {
        display: block;
        height: 2px;
        width: 100%;
        background-color: #00e87a; 
        border-radius: 2px;
        transition: 0.3s ease;
    }
    
    .menu-btn:hover span {
        background-color: #1fffa0;
    }

    .side-menu {
        position: fixed;
        z-index: 1001; 
        top: 0;
        left: -280px; 
        width: 280px;
        height: 100%;
        background-color: #0d1526; 
        border-right: 1px solid rgba(255, 255, 255, 0.06);
        box-shadow: 10px 0px 40px rgba(0, 0, 0, 0.5);
        transition: transform 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        padding-top: 40px;
        box-sizing: border-box;
    }

    .side-menu.active {
        transform: translateX(280px);
    }

    .menu {
        font-family: 'Arial Black', Arial, sans-serif;
        font-size: 22px;
        font-weight: 900;
        color: #00e87a; 
        padding: 20px 24px;
        margin: 0;
        letter-spacing: 1px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.06);
    }

    .side-menu a {
        display: block;
        padding: 16px 24px;
        text-decoration: none;
        color: #8a9ab8;
        font-size: 15px;
        font-weight: 500;
        border-bottom: 1px solid rgba(255, 255, 255, 0.03);
        transition: all 0.3s ease;
    }

    .side-menu a:hover {
        background-color: rgba(0, 232, 122, 0.08);
        color: #1fffa0;
        padding-left: 32px; 
        border-left: 4px solid #00e87a; 
    }

    .overlay {
        z-index: 999;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(4, 10, 18, 0.6);
        backdrop-filter: blur(4px); 
        display: none;
    }

    .overlay.active {
        display: block;
    }

    .frame {
        width: 32px;
        height: 32px;
        overflow: hidden;
        border: 2px solid rgba(0, 232, 122, 0.4); 
        border-radius: 50%; 
        box-sizing: border-box;
        background: #0d1526;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .userpicture {
        width: 100%;
        height: 100%;
        object-fit: cover;
        background-color:white;
    }

    @keyframes header {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }


    @media(max-width: 768px) {
        .header {

            padding: 0 16px;
        }
        .username {
            display: none;
        }
        .side-menu {
            width: 260px; 
        }
        .side-menu.active {
            transform: translateX(260px);
        }
    }
</style>

<?php
$role = $_SESSION['role'] ?? "unknown";
$current_user = $_SESSION['username'] ?? 'Guest';
?>

<div class="overlay" id="overlay" onclick="openmenu()"></div>

<div class="side-menu" id="sideMenu">
    <h1 class="menu">⚡ MENU</h1>
    
    <?php if($role == 'student'): ?>
        <a href="studentpage.php">📊 Dashboard</a>
        <a href="#energy">⚡ Energy Usage</a>   
        <a href="#challenges">🎯 Challenges</a>
        <a href="#mychallenges">📌 My Challenges</a>
        <a href="#pointstore">🎁 Point Store</a>
        <a href="homepage.php" style="color: #ff4d4d; border-top: 1px solid rgba(255,77,77,0.15);">🚪 Logout</a>

    <?php elseif ($role == 'staff'): ?>
        <a href="staffpage.php">📊 Dashboard</a>
        <a href="#eu">⚡ Energy Usage</a>
        <a href="#ac">🏆 Available Challenges</a>
        <a href="#jc">✅ Joined Challenges</a>
        <a href="#addc">➕ Add Challenge</a>
        <a href="homepage.php" style="color: #ff4d4d; border-top: 1px solid rgba(255,77,77,0.15);">🚪 Logout</a>

    <?php elseif ($role == 'admin'): ?>
        <a href="adminpage.php">🛠️ Dashboard</a>
        <a href="sendalertpage.php">🔔 Send Alert</a>
        <a href="publishvoucher.php">🎟️ Publish Voucher</a>
        <a href="#settings">⚙️ Settings</a>
        <a href="homepage.php" style="color: #ff4d4d; border-top: 1px solid rgba(255,77,77,0.15);">🚪 Logout</a>

    <?php elseif ($role == 'manager'): ?>
        <a href="managerpage.php">📊 Dashboard</a>
        <a href="managewastedelectricity.php">⚡ Manage Wasted Electricity</a>
        <a href="manageaccount.php">👥 Manage Accounts</a>
        <a href="managechallenges.php">🏆 Manage Challenges</a>
        <a href="managevouchers.php">🎁 Manage Vouchers</a>
        <a href="homepage.php" style="color: #ff4d4d; border-top: 1px solid rgba(255,77,77,0.15);">🚪 Logout</a>

    <?php else: ?>
        <a href="loginpage.php">🔑 Login</a>
        <a href="signuppage.php">📝 Sign Up</a>
    <?php endif; ?>
</div>

<div class="header">
    <div class="header-left">
        <div class="menu-btn" onclick="openmenu()">
            <span></span>
            <span></span>
            <span></span>
        </div>
        <h2 class="logo">⚡ Voltcampus</h2>
    </div>
    
    <div style="display: flex; align-items: center; gap: 12px;">
        <span class="username"><?php echo htmlspecialchars($current_user); ?></span>
        <div class="frame">
            <img class="userpicture" src="https://pluspng.com/img-png/user-png-icon-big-image-png-2240.png" alt="User Profile">
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