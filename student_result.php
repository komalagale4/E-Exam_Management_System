<?php
session_start();
include '../config/db.php';

if(!isset($_SESSION['admin_logged_in'])){
    header("Location: login.php");
    exit();
}

$results = mysqli_query($conn,"
SELECT results.*, students.name
FROM results
JOIN students
ON results.student_id = students.id
ORDER BY results.id DESC
");
?>

<!DOCTYPE html>
<html>
<head>

<title>Student Results</title>

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>

body{
    margin:0;
    font-family:Arial;
    background:linear-gradient(135deg,#111827,#1e40af);
    color:white;
}

.container{
    padding:40px;
}

.top-bar{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:30px;
    flex-wrap:wrap;
}

.title{
    font-size:35px;
}

.back-btn{
    background:white;
    color:#1e40af;
    text-decoration:none;
    padding:12px 20px;
    border-radius:10px;
    font-weight:bold;
    transition:0.3s;
}

.back-btn:hover{
    background:#dbeafe;
    transform:translateY(-3px);
}

.result-box{
    background:white;
    border-radius:20px;
    padding:25px;
    overflow:auto;
}

table{
    width:100%;
    border-collapse:collapse;
    color:#333;
}

th{
    background:#2563eb;
    color:white;
    padding:15px;
    text-align:center;
}

td{
    padding:15px;
    border-bottom:1px solid #ddd;
    text-align:center;
}

tr:hover{
    background:#f3f4f6;
}

.pass{
    color:#16a34a;
    font-weight:bold;
}

.fail{
    color:#dc2626;
    font-weight:bold;
}

.no-data{
    text-align:center;
    padding:30px;
    font-size:20px;
    color:#666;
}

</style>

</head>

<body>

<div class="container">

<div class="top-bar">

<h1 class="title">
<i class="fas fa-chart-line"></i>
Student Results
</h1>

<a href="dashboard.php" class="back-btn">
<i class="fas fa-arrow-left"></i>
Back to Dashboard
</a>

</div>

<div class="result-box">

<table>

<tr>
<th>Student</th>
<th>Score</th>
<th>Percentage</th>
<th>Status</th>
<th>Date</th>
</tr>

<?php
if(mysqli_num_rows($results)>0)
{
while($row=mysqli_fetch_assoc($results))
{
?>

<tr>

<td>
<?php echo $row['name']; ?>
</td>

<td>
<?php echo $row['score']; ?>/<?php echo $row['total']; ?>
</td>

<td>
<?php echo round($row['percentage']); ?>%
</td>

<td>

<?php if($row['percentage'] >= 60){ ?>

<span class="pass">PASS</span>

<?php } else { ?>

<span class="fail">FAIL</span>

<?php } ?>

</td>

<td>
<?php echo date('d M Y',strtotime($row['exam_date'])); ?>
</td>

</tr>

<?php
}
}
else
{
?>

<tr>
<td colspan="5" class="no-data">
No Results Found.
</td>
</tr>

<?php } ?>

</table>

</div>

</div>

</body>
</html>