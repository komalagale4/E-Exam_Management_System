<?php
session_start();
include '../config/db.php';

if(!isset($_SESSION['admin_logged_in']))
{
    header("Location: login.php");
    exit();
}

/* DELETE STUDENT */

if(isset($_GET['delete']))
{
    $id = $_GET['delete'];

    mysqli_query($conn,
    "DELETE FROM students WHERE id='$id'");

    header("Location: manage_student.php");
    exit();
}

/* FETCH STUDENTS */

$students = mysqli_query($conn,
"SELECT * FROM students ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>

<head>

<title>Manage Students</title>

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

.container{
    padding:40px;
}

.title{
    font-size:45px;
    margin-bottom:30px;
    font-weight:bold;
}

.table-box{
    background:white;
    border-radius:20px;
    padding:30px;
    overflow:auto;
}

table{
    width:100%;
    border-collapse:collapse;
}

th{
    background:#1e3a8a;
    color:white;
    padding:18px;
    text-align:center;
    font-size:20px;
}

td{
    padding:20px;
    border-bottom:1px solid #ddd;
    text-align:center;
    color:#333;
    font-size:18px;
}

tr:hover{
    background:#f3f4f6;
}

.delete-btn{
    background:#ef4444;
    color:white;
    padding:12px 18px;
    border-radius:10px;
    text-decoration:none;
    transition:0.3s;
    display:inline-block;
}

.delete-btn:hover{
    background:#dc2626;
    transform:scale(1.05);
}

.back-btn{
    display:inline-block;
    margin-bottom:20px;
    background:white;
    color:#1e3a8a;
    padding:12px 20px;
    border-radius:10px;
    text-decoration:none;
    font-weight:bold;
}

.back-btn:hover{
    background:#e2e8f0;
}

.empty{
    text-align:center;
    color:#666;
    padding:40px;
    font-size:20px;
}

</style>

</head>

<body>

<div class="container">

<a href="dashboard.php" class="back-btn">
<i class="fas fa-arrow-left"></i>
Back Dashboard
</a>

<h1 class="title">
<i class="fas fa-users"></i>
Manage Students
</h1>

<div class="table-box">

<table>

<tr>
<th>ID</th>
<th>Name</th>
<th>Email</th>
<th>Action</th>
</tr>

<?php

if(mysqli_num_rows($students)>0)
{
while($row=mysqli_fetch_assoc($students))
{
?>

<tr>

<td>
<?php echo $row['id']; ?>
</td>

<td>
<?php echo $row['name']; ?>
</td>

<td>
<?php echo $row['email']; ?>
</td>

<td>

<a class="delete-btn"
href="manage_student.php?delete=<?php echo $row['id']; ?>"
onclick="return confirm('Delete this student?')">

<i class="fas fa-trash"></i>
Delete

</a>

</td>

</tr>

<?php
}
}
else
{
?>

<tr>
<td colspan="4" class="empty">
No Students Found.
</td>
</tr>

<?php
}
?>

</table>

</div>

</div>

</body>
</html>