<?php
session_start();

if(!isset($_SESSION['student_id'])){
    header("Location: login.php");
    exit();
}

include '../config/db.php';

$student_id = $_SESSION['student_id'];

$query = mysqli_query($conn,"
SELECT * FROM students
WHERE id='$student_id'
");

$student = mysqli_fetch_assoc($query);

$success = "";
$error = "";

/* =========================
   UPDATE PROFILE
========================= */

if(isset($_POST['update_profile'])){

    $name = mysqli_real_escape_string($conn,$_POST['name']);
    $email = mysqli_real_escape_string($conn,$_POST['email']);

    $update = mysqli_query($conn,"
    UPDATE students
    SET
    name='$name',
    email='$email'
    WHERE id='$student_id'
    ");

    if($update){

        $_SESSION['student_name'] = $name;

        $success = "Profile Updated Successfully";

        // Refresh Data
        $query = mysqli_query($conn,"
        SELECT * FROM students
        WHERE id='$student_id'
        ");

        $student = mysqli_fetch_assoc($query);

    }else{

        $error = "Profile Update Failed";

    }
}

/* =========================
   CHANGE PASSWORD
========================= */

if(isset($_POST['change_password'])){

    $old_password = md5($_POST['old_password']);
    $new_password = md5($_POST['new_password']);

    if($old_password == $student['password']){

        $change = mysqli_query($conn,"
        UPDATE students
        SET password='$new_password'
        WHERE id='$student_id'
        ");

        if($change){

            $success = "Password Changed Successfully";

        }else{

            $error = "Password Change Failed";

        }

    }else{

        $error = "Old Password Incorrect";

    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>My Profile</title>

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{
    font-family:Arial;
    background:linear-gradient(135deg,#0f172a,#1e3a8a);
    min-height:100vh;
    color:white;
}

/* NAVBAR */

.navbar{
    background:#111827;
    padding:18px 40px;
    display:flex;
    justify-content:space-between;
    align-items:center;
}

.logo{
    font-size:24px;
    font-weight:bold;
}

.nav-links{
    display:flex;
    gap:15px;
}

.nav-links a{
    text-decoration:none;
    color:white;
    padding:10px 18px;
    border-radius:8px;
    transition:0.3s;
}

.dashboard-btn{
    background:#2563eb;
}

.dashboard-btn:hover{
    background:#1d4ed8;
}

.logout-btn{
    background:#dc2626;
}

.logout-btn:hover{
    background:#b91c1c;
}

/* CONTAINER */

.container{
    width:95%;
    max-width:1000px;
    margin:40px auto;
}

/* PROFILE CARD */

.profile-card{
    background:white;
    color:#111827;
    border-radius:20px;
    padding:40px;
    margin-bottom:30px;
    box-shadow:0 10px 30px rgba(0,0,0,0.3);
}

.profile-header{
    text-align:center;
    margin-bottom:30px;
}

.avatar{
    width:120px;
    height:120px;
    background:#2563eb;
    border-radius:50%;
    margin:auto;
    display:flex;
    justify-content:center;
    align-items:center;
    font-size:50px;
    color:white;
    margin-bottom:15px;
}

.profile-header h1{
    color:#1e3a8a;
    margin-bottom:10px;
}

/* FORM */

.form-group{
    margin-bottom:20px;
}

label{
    display:block;
    margin-bottom:8px;
    font-weight:bold;
}

input{
    width:100%;
    padding:14px;
    border:1px solid #ccc;
    border-radius:10px;
    font-size:16px;
}

button{
    width:100%;
    padding:15px;
    border:none;
    border-radius:10px;
    background:#2563eb;
    color:white;
    font-size:17px;
    cursor:pointer;
    transition:0.3s;
}

button:hover{
    background:#1d4ed8;
}

/* ALERT */

.success{
    background:#dcfce7;
    color:#166534;
    padding:15px;
    border-radius:10px;
    margin-bottom:20px;
}

.error{
    background:#fee2e2;
    color:#991b1b;
    padding:15px;
    border-radius:10px;
    margin-bottom:20px;
}

/* PASSWORD CARD */

.password-card{
    background:white;
    color:#111827;
    border-radius:20px;
    padding:40px;
    box-shadow:0 10px 30px rgba(0,0,0,0.3);
}

.password-card h2{
    margin-bottom:25px;
    color:#1e3a8a;
}

/* MOBILE */

@media(max-width:768px){

    .navbar{
        flex-direction:column;
        gap:15px;
    }

    .nav-links{
        width:100%;
        flex-direction:column;
    }

    .nav-links a{
        text-align:center;
    }

    .profile-card,
    .password-card{
        padding:25px;
    }

}

</style>

</head>

<body>

<!-- NAVBAR -->

<div class="navbar">

    <div class="logo">
        <i class="fas fa-user-circle"></i>
        My Profile
    </div>

    <div class="nav-links">

        <a href="dashboard.php" class="dashboard-btn">
            <i class="fas fa-home"></i>
            Dashboard
        </a>

        <a href="logout.php" class="logout-btn">
            <i class="fas fa-sign-out-alt"></i>
            Logout
        </a>

    </div>

</div>

<div class="container">

<!-- ALERTS -->

<?php if($success != ""){ ?>
<div class="success">
    <?php echo $success; ?>
</div>
<?php } ?>

<?php if($error != ""){ ?>
<div class="error">
    <?php echo $error; ?>
</div>
<?php } ?>

<!-- PROFILE CARD -->

<div class="profile-card">

    <div class="profile-header">

        <div class="avatar">
            <i class="fas fa-user"></i>
        </div>

        <h1>
            <?php echo $student['name']; ?>
        </h1>

        <p>
            Student Profile Information
        </p>

    </div>

    <form method="POST">

        <div class="form-group">

            <label>
                Full Name
            </label>

            <input type="text"
                   name="name"
                   value="<?php echo $student['name']; ?>"
                   required>

        </div>

        <div class="form-group">

            <label>
                Email Address
            </label>

            <input type="email"
                   name="email"
                   value="<?php echo $student['email']; ?>"
                   required>

        </div>

        <button type="submit" name="update_profile">

            <i class="fas fa-save"></i>
            Update Profile

        </button>

    </form>

</div>

<!-- CHANGE PASSWORD -->

<div class="password-card">

    <h2>
        <i class="fas fa-lock"></i>
        Change Password
    </h2>

    <form method="POST">

        <div class="form-group">

            <label>
                Old Password
            </label>

            <input type="password"
                   name="old_password"
                   required>

        </div>

        <div class="form-group">

            <label>
                New Password
            </label>

            <input type="password"
                   name="new_password"
                   required>

        </div>

        <button type="submit" name="change_password">

            <i class="fas fa-key"></i>
            Change Password

        </button>

    </form>

</div>

</div>

</body>
</html>