<?php
include '../config/db.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    $hashed_password = md5($password);

    // Check Existing Email
    $check = mysqli_query($conn,
    "SELECT * FROM students WHERE email='$email'");

    if(mysqli_num_rows($check) > 0){

        $error = "Email already exists";

    } else {

        $insert = mysqli_query($conn,
        "INSERT INTO students(name,email,password)
        VALUES('$name','$email','$hashed_password')");

        if($insert){

            $success = "Registration Successful";

            echo "
            <script>
            setTimeout(function(){
                window.location='login.php';
            },2000);
            </script>
            ";

        } else {

            $error = "Registration Failed";

        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<title>Student Register</title>

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
    display:flex;
    justify-content:center;
    align-items:center;
    background:linear-gradient(135deg,#141e30,#243b55);
    overflow:hidden;
}

/* Animated Background */

body::before{
    content:'';
    position:absolute;
    width:600px;
    height:600px;
    background:rgba(255,255,255,0.05);
    border-radius:50%;
    top:-200px;
    left:-200px;
}

body::after{
    content:'';
    position:absolute;
    width:500px;
    height:500px;
    background:rgba(255,255,255,0.05);
    border-radius:50%;
    bottom:-180px;
    right:-180px;
}

/* Register Card */

.login-container{
    position:relative;
    width:420px;
    background:rgba(255,255,255,0.12);
    backdrop-filter:blur(15px);
    padding:40px;
    border-radius:20px;
    box-shadow:0 10px 30px rgba(0,0,0,0.3);
    color:white;
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
    width:90px;
    height:90px;
    background:white;
    border-radius:50%;
    margin:auto;
    display:flex;
    justify-content:center;
    align-items:center;
    margin-bottom:20px;
}

.logo i{
    font-size:40px;
    color:#243b55;
}

h2{
    text-align:center;
    margin-bottom:30px;
    font-size:30px;
}

/* Input Box */

.input-box{
    position:relative;
    margin-bottom:20px;
}

.input-box i{
    position:absolute;
    left:15px;
    top:15px;
    color:#666;
}

.input-box input{
    width:100%;
    padding:14px 14px 14px 45px;
    border:none;
    border-radius:10px;
    outline:none;
    font-size:15px;
}

/* Button */

button{
    width:100%;
    padding:14px;
    border:none;
    border-radius:10px;
    background:#00b894;
    color:white;
    font-size:17px;
    cursor:pointer;
    transition:0.3s;
    font-weight:bold;
}

button:hover{
    background:#019875;
    transform:scale(1.03);
}

/* Alerts */

.error{
    background:#ff4757;
    padding:12px;
    border-radius:8px;
    margin-bottom:20px;
    text-align:center;
}

.success{
    background:#2ed573;
    padding:12px;
    border-radius:8px;
    margin-bottom:20px;
    text-align:center;
}

/* Links */

.links{
    margin-top:20px;
    text-align:center;
}

.links a{
    color:#fff;
    text-decoration:none;
    font-weight:bold;
}

.links a:hover{
    text-decoration:underline;
}

/* Login Button */

.login-btn{
    margin-top:15px;
    display:block;
    text-align:center;
    padding:12px;
    border-radius:10px;
    background:#0984e3;
    color:white;
    text-decoration:none;
    transition:0.3s;
    font-weight:bold;
}

.login-btn:hover{
    background:#0866b3;
}

/* Responsive */

@media(max-width:450px){

.login-container{
    width:90%;
    padding:30px;
}

}

</style>

</head>

<body>

<div class="login-container">

<div class="logo">
<i class="fas fa-user-plus"></i>
</div>

<h2>Student Register</h2>

<?php if ($error): ?>

<div class="error">
<?= htmlspecialchars($error) ?>
</div>

<?php endif; ?>

<?php if ($success): ?>

<div class="success">
<?= htmlspecialchars($success) ?>
</div>

<?php endif; ?>

<form method="POST">

<div class="input-box">

<i class="fas fa-user"></i>

<input type="text"
name="name"
placeholder="Enter Full Name"
required>

</div>

<div class="input-box">

<i class="fas fa-envelope"></i>

<input type="email"
name="email"
placeholder="Enter Email Address"
required>

</div>

<div class="input-box">

<i class="fas fa-lock"></i>

<input type="password"
name="password"
placeholder="Create Password"
required>

</div>

<button type="submit">

<i class="fas fa-user-check"></i>
 Register

</button>

</form>

<div class="links">

<p>
Already have an account?
<a href="login.php">
Login Here
</a>
</p>

<a href="login.php"
class="login-btn">

<i class="fas fa-sign-in-alt"></i>
 Student Login

</a>

</div>

</div>

</body>
</html>