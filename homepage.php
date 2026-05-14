<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
    <link rel="stylesheet" href="homepage.css">
<body>
    <div class="header">
        <div class="header-content">
            <h2 class="logo">Voltcampus</h2>
            <div class="header-links"> 
                <a href="signuppage.php" class="signup">Signup</a>
                <a href="loginpage.php" class="login">Login</a>
               
            </div>
        </div>
    </div>

    <div class="main-content">
        <div class="content1">
            <h1>Empowering Green Living in Dorms</h1>
            <br><br>
            <p>Empower your sustainable lifestyle by tracking daily energy consumption and joining community challenges. Every kilowatt saved earns you points that can be redeemed for exclusive rewards, making green living both impactful and rewarding for every student.</p>
            <div class="header-links">
                <a href="signuppage.php" class="signup">Signup</a>
                <a href="loginpage.php" class="login">Login</a>
                
            </div>
        </div>
        <div class="image">
            <img src="https://www.uliege.be/upload/docs/image/png/2022-10/saveenergy-news.png" alt="Green Living" >
        </div>
    </div>

    <h2 class="function">Function of this website</h2><br>
    <hr>
    <div class=second-content>
        <div class ="Electricity-consumption">
            <div class="Electricity-consumption-image">
                <img src="https://cdn-icons-png.flaticon.com/512/6292/6292156.png" alt="Electricity Consumption" >
            </div>
            <h3>Electricity Consumption</h3>
            <p>Track your energy usage in real-time and receive personalized tips to reduce your carbon footprint.</p>
        </div>

        <div class="challenge">
            <div class="challenge-image">
                <img src="https://cdn1.iconfinder.com/data/icons/travel-flat-icons/130/challenge-1024.png" >
            </div>
            <h3>Challenges</h3>
            <p>Participate in fun challenges to reduce your energy consumption and compete with your peers.</p>
        </div>

        <div class="reward">
            <div class="reward-image">
                <img src="https://static.vecteezy.com/system/resources/previews/018/817/961/original/reward-medal-icon-png.png" alt="Rewards" >
            </div>
            <h3>Rewards</h3>
            <p>Earn points and rewards for your eco-friendly actions and achievements.</p>
        </div>
    </div>

    <?php
        include 'footer.php';
    ?>


    
</body>
</html>