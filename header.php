<style>
body {
    background-color:#080e1a;
    color:#eef2f8;
    overflow-x:hidden;
    margin:0;
    padding: 0;
}


.header {
    position:sticky;
    top:0;
    z-index:1000;
    width:100%;
    border-bottom:1px solid rgba(255,255,255,0.06);
    animation:header 0.6s ease forwards;
}
@keyframes header {
    from {opacity:0;transform:translateY(-100%)}
    to {opacity:1;transform:translateY(0)}
}
.header-content {
    display:flex;
    align-items:center;
    justify-content:space-between;
    max-width:1200px;
    margin:0 auto;
    padding:0 40px;
    height:68px;
}
.logo {
    font-size:22px;
    font-weight:900;
    color:#eef2f8;
    display:flex;
    align-items:center;
    gap:8px;
}
.header-content a{
    color:white;
}
</style>

<div class="header">
    <div class="header-content">
        <h2 class="logo">Voltcampus</h2>
        <a href = "homepage.php">Home</a>
    </div>
</div>
