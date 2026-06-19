<?php
session_start();

if (isset($_SESSION['admin_logged_in'])) {
    header('Location: dashboard.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Demo Login
    if ($username === 'admin' && $password === 'password123') {

        $_SESSION['admin_logged_in'] = $username;

        header('Location: dashboard.php');
        exit;

    } else {

        $error = "Invalid username or password";

    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<title>Admin Login</title>

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
    background:linear-gradient(135deg,#1e3c72,#2a5298);
    height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
}

.login-container{
    width:400px;
    background:white;
    padding:40px;
    border-radius:20px;
    box-shadow:0 10px 30px rgba(0,0,0,0.3);
    animation:fadeIn 0.6s ease;
}

@keyframes fadeIn{
    from{
        opacity:0;
        transform:translateY(20px);
    }
    to{
        opacity:1;
        transform:translateY(0);
    }
}

.logo{
    text-align:center;
    margin-bottom:25px;
}

.logo i{
    font-size:60px;
    color:#1e3c72;
}

.logo h2{
    margin-top:10px;
    color:#1e3c72;
}

.input-box{
    position:relative;
    margin-bottom:20px;
}

.input-box i{
    position:absolute;
    top:15px;
    left:15px;
    color:#666;
}

input{
    width:100%;
    padding:14px 14px 14px 45px;
    border:1px solid #ccc;
    border-radius:10px;
    font-size:16px;
    outline:none;
    transition:0.3s;
}

input:focus{
    border-color:#1e3c72;
    box-shadow:0 0 10px rgba(30,60,114,0.2);
}

button{
    width:100%;
    padding:14px;
    background:#1e3c72;
    color:white;
    border:none;
    border-radius:10px;
    font-size:18px;
    cursor:pointer;
    transition:0.3s;
}

button:hover{
    background:#16315d;
    transform:translateY(-2px);
}

.error{
    background:#fee2e2;
    color:#dc2626;
    padding:12px;
    border-radius:10px;
    margin-bottom:20px;
    text-align:center;
}

.back-btn{
    margin-top:20px;
    text-align:center;
}

.back-btn a{
    display:inline-block;
    text-decoration:none;
    background:#f3f4f6;
    color:#1e3c72;
    padding:12px 20px;
    border-radius:10px;
    font-weight:bold;
    transition:0.3s;
}

.back-btn a:hover{
    background:#dbeafe;
    transform:translateY(-2px);
}

</style>

</head>

<body>

<div class="login-container">

<div class="logo">

<i class="fas fa-user-shield"></i>

<h2>Admin Login</h2>

</div>

<?php if ($error): ?>

<div class="error">

<?php echo htmlspecialchars($error); ?>

</div>

<?php endif; ?>

<form method="POST">

<div class="input-box">

<i class="fas fa-user"></i>

<input
type="text"
name="username"
placeholder="Enter Username"
required
autofocus>

</div>

<div class="input-box">

<i class="fas fa-lock"></i>

<input
type="password"
name="password"
placeholder="Enter Password"
required>

</div>

<button type="submit">

<i class="fas fa-sign-in-alt"></i>
Login

</button>

</form>

<div class="back-btn">

<a href="../student/login.php">

<i class="fas fa-arrow-left"></i>
Go Back To Student Login

</a>

</div>

</div>

</body>
</html>