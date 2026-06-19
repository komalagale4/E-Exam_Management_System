<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<title>Online Exam Portal</title>

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{
    font-family:Arial,sans-serif;
    height:100vh;
    overflow:hidden;
    background:linear-gradient(135deg,#0f172a,#1e3a8a,#2563eb);
    display:flex;
    justify-content:center;
    align-items:center;
    position:relative;
}

/* Animated Background */

.circle{
    position:absolute;
    border-radius:50%;
    background:rgba(255,255,255,0.08);
    animation:float 8s infinite ease-in-out;
}

.circle:nth-child(1){
    width:250px;
    height:250px;
    top:-80px;
    left:-80px;
}

.circle:nth-child(2){
    width:180px;
    height:180px;
    bottom:-60px;
    right:-60px;
}

.circle:nth-child(3){
    width:120px;
    height:120px;
    top:60%;
    left:15%;
}

@keyframes float{
    0%{
        transform:translateY(0px);
    }
    50%{
        transform:translateY(-20px);
    }
    100%{
        transform:translateY(0px);
    }
}

/* Main Card */

.container{
    width:450px;
    background:rgba(255,255,255,0.12);
    backdrop-filter:blur(15px);
    padding:45px;
    border-radius:25px;
    text-align:center;
    color:white;
    box-shadow:0 15px 40px rgba(0,0,0,0.3);
    z-index:10;
    animation:fadeIn 1s ease;
}

@keyframes fadeIn{
    from{
        opacity:0;
        transform:translateY(30px);
    }
    to{
        opacity:1;
        transform:translateY(0);
    }
}

.logo{
    width:110px;
    height:110px;
    background:white;
    border-radius:50%;
    margin:auto;
    display:flex;
    justify-content:center;
    align-items:center;
    margin-bottom:20px;
}

.logo i{
    font-size:50px;
    color:#2563eb;
}

h1{
    font-size:38px;
    margin-bottom:15px;
}

p{
    font-size:16px;
    color:#e5e7eb;
    margin-bottom:35px;
    line-height:1.6;
}

/* Buttons */

.btn{
    display:block;
    width:100%;
    padding:16px;
    margin-bottom:18px;
    border-radius:12px;
    text-decoration:none;
    font-size:18px;
    font-weight:bold;
    transition:0.3s;
}

.student-btn{
    background:#10b981;
    color:white;
}

.student-btn:hover{
    background:#059669;
    transform:translateY(-3px);
}

.admin-btn{
    background:#f59e0b;
    color:white;
}

.admin-btn:hover{
    background:#d97706;
    transform:translateY(-3px);
}

/* Footer */

.footer{
    margin-top:25px;
    font-size:14px;
    color:#d1d5db;
}

/* Responsive */

@media(max-width:500px){

.container{
    width:90%;
    padding:35px 25px;
}

h1{
    font-size:30px;
}

}

</style>

</head>

<body>

<!-- Background Circles -->

<div class="circle"></div>
<div class="circle"></div>
<div class="circle"></div>

<!-- Main Container -->

<div class="container">

<div class="logo">

<i class="fas fa-graduation-cap"></i>

</div>

<h1>Online Exam Portal</h1>

<p>
Welcome to the Smart Online Examination System.
Login as Student or Admin to continue.
</p>

<a href="student/login.php"
class="btn student-btn">

<i class="fas fa-user-graduate"></i>
 Student Login

</a>

<a href="admin/login.php"
class="btn admin-btn">

<i class="fas fa-user-shield"></i>
 Admin Login

</a>

<div class="footer">

© 2026 Online Exam Portal

</div>

</div>

</body>
</html>