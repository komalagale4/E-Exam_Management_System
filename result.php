<?php
session_start();

if(!isset($_SESSION['student_id'])){
    header("Location: login.php");
    exit();
}

include '../config/db.php';

$student_id = $_SESSION['student_id'];

$results = mysqli_query($conn,"
SELECT * FROM results
WHERE student_id='$student_id'
ORDER BY exam_date DESC
");

$completed_exams = mysqli_num_rows($results);

if(isset($_SESSION['exam_result'])){
    $latest_result = $_SESSION['exam_result'];
    unset($_SESSION['exam_result']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Student Results</title>

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
    background:linear-gradient(135deg,#1d2671,#c33764);
    min-height:100vh;
    color:white;
}

/* NAVBAR */

.navbar{
    width:100%;
    padding:18px 40px;
    background:rgba(255,255,255,0.1);
    backdrop-filter:blur(10px);
    display:flex;
    justify-content:space-between;
    align-items:center;
    position:sticky;
    top:0;
    z-index:100;
}

.logo{
    font-size:24px;
    font-weight:bold;
    display:flex;
    align-items:center;
    gap:10px;
}

.nav-buttons{
    display:flex;
    gap:15px;
    align-items:center;
}

.dashboard-btn{
    padding:10px 18px;
    background:#2563eb;
    color:white;
    text-decoration:none;
    border-radius:8px;
    transition:0.3s;
    font-weight:bold;
}

.dashboard-btn:hover{
    background:#1d4ed8;
}

.logout-btn{
    padding:10px 18px;
    background:#ff4757;
    color:white;
    text-decoration:none;
    border-radius:8px;
    transition:0.3s;
}

.logout-btn:hover{
    background:#ff2e43;
}

/* CONTAINER */

.container{
    width:95%;
    max-width:1200px;
    margin:40px auto;
}

/* RESULT CARD */

.result-card{
    background:white;
    color:#333;
    border-radius:20px;
    padding:40px;
    text-align:center;
    margin-bottom:40px;
    box-shadow:0 10px 40px rgba(0,0,0,0.3);
    animation:fadeIn 1s ease;
}

.result-card h1{
    margin-bottom:20px;
    color:#1d2671;
}

.score-circle{
    width:200px;
    height:200px;
    border-radius:50%;
    margin:20px auto;
    display:flex;
    justify-content:center;
    align-items:center;
    background:conic-gradient(#2ed573 0deg, #2ed573 0deg, #ddd 0deg);
    position:relative;
    transition:1s;
}

.score-circle::before{
    content:'';
    position:absolute;
    width:150px;
    height:150px;
    background:white;
    border-radius:50%;
}

.score-content{
    position:relative;
    z-index:2;
}

.score-content h2{
    font-size:40px;
    color:#1d2671;
}

.score-content p{
    font-size:18px;
    color:#555;
}

.status{
    margin-top:20px;
    font-size:22px;
    font-weight:bold;
}

.pass{
    color:#2ed573;
}

.fail{
    color:#ff4757;
}

.btn{
    display:inline-block;
    margin-top:25px;
    padding:14px 30px;
    background:#1d2671;
    color:white;
    text-decoration:none;
    border-radius:10px;
    transition:0.3s;
}

.btn:hover{
    background:#111a5e;
    transform:translateY(-3px);
}

/* TABLE */

.table-box{
    background:white;
    border-radius:20px;
    padding:30px;
    color:#333;
    box-shadow:0 10px 40px rgba(0,0,0,0.3);
    animation:fadeIn 1.2s ease;
}

.table-box h2{
    margin-bottom:20px;
    color:#1d2671;
}

table{
    width:100%;
    border-collapse:collapse;
}

table th{
    background:#1d2671;
    color:white;
    padding:15px;
}

table td{
    padding:15px;
    border-bottom:1px solid #ddd;
    text-align:center;
}

table tr:hover{
    background:#f5f5f5;
}

/* STATUS BADGE */

.badge{
    padding:8px 14px;
    border-radius:20px;
    color:white;
    font-weight:bold;
}

.badge-pass{
    background:#2ed573;
}

.badge-fail{
    background:#ff4757;
}

/* NO RESULT */

.no-result{
    text-align:center;
    padding:60px;
}

.no-result i{
    font-size:80px;
    margin-bottom:20px;
    color:#ddd;
}

.no-result h2{
    color:#555;
}

/* ANIMATION */

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

/* RESPONSIVE */

@media(max-width:768px){

    .navbar{
        padding:15px 20px;
        flex-direction:column;
        gap:15px;
    }

    .container{
        width:100%;
        padding:15px;
    }

    .result-card{
        padding:25px;
    }

    .score-circle{
        width:160px;
        height:160px;
    }

    .score-circle::before{
        width:120px;
        height:120px;
    }

    .score-content h2{
        font-size:30px;
    }

    table{
        font-size:14px;
    }

    table th,
    table td{
        padding:10px;
    }

    .nav-buttons{
        flex-direction:column;
        width:100%;
    }

    .dashboard-btn,
    .logout-btn{
        width:100%;
        text-align:center;
    }
}

</style>
</head>

<body>

<!-- NAVBAR -->

<div class="navbar">

    <div class="logo">
        <i class="fas fa-graduation-cap"></i>
        Exam Portal
    </div>

    <div class="nav-buttons">

        <!-- GO TO DASHBOARD BUTTON -->
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

<!-- LATEST RESULT -->

<?php if(isset($latest_result)){ ?>

<div class="result-card">

    <h1>
        <i class="fas fa-chart-line"></i>
        Latest Exam Result
    </h1>

    <div class="score-circle" id="scoreCircle">

        <div class="score-content">
            <h2>
                <?php echo round($latest_result['percentage']); ?>%
            </h2>

            <p>
                <?php echo $latest_result['score']; ?>
                /
                <?php echo $latest_result['total']; ?>
            </p>
        </div>

    </div>

    <div class="status
    <?php echo $latest_result['percentage'] >= 60 ? 'pass' : 'fail'; ?>">

        <?php
        if($latest_result['percentage'] >= 60){
            echo "🎉 Congratulations! You Passed!";
        }else{
            echo "❌ Failed! Try Again.";
        }
        ?>

    </div>

    <a href="submit_exam.php" class="btn">
        <i class="fas fa-pen"></i>
        Take Another Exam
    </a>

</div>

<?php } ?>

<!-- RESULT HISTORY -->

<div class="table-box">

<h2>
<i class="fas fa-history"></i>
Exam History
</h2>

<?php if($completed_exams > 0){ ?>

<table>

<tr>
<th>Date</th>
<th>Score</th>
<th>Percentage</th>
<th>Status</th>
</tr>

<?php
mysqli_data_seek($results,0);

while($row = mysqli_fetch_assoc($results)){
?>

<tr>

<td>
<?php echo date('d M Y',strtotime($row['exam_date'])); ?>
</td>

<td>
<?php echo $row['score']; ?>/<?php echo $row['total']; ?>
</td>

<td>
<?php echo round($row['percentage']); ?>%
</td>

<td>

<?php if($row['percentage'] >= 60){ ?>

<span class="badge badge-pass">
PASS
</span>

<?php } else { ?>

<span class="badge badge-fail">
FAIL
</span>

<?php } ?>

</td>

</tr>

<?php } ?>

</table>

<?php } else { ?>

<div class="no-result">

<i class="fas fa-chart-bar"></i>

<h2>No Results Found</h2>

<p style="margin-top:10px;color:#777;">
Start your first exam now.
</p>

<a href="submit_exam.php" class="btn">
Start Exam
</a>

</div>

<?php } ?>

</div>

</div>

<script>

/* Animated Score Circle */

<?php if(isset($latest_result)){ ?>

let percentage = <?php echo round($latest_result['percentage']); ?>;

let scoreCircle = document.getElementById("scoreCircle");

let degree = (percentage / 100) * 360;

scoreCircle.style.background =
`conic-gradient(
${percentage >= 60 ? '#2ed573' : '#ff4757'} ${degree}deg,
#ddd ${degree}deg
)`;

<?php } ?>

/* Table Animation */

const rows = document.querySelectorAll("table tr");

rows.forEach((row,index)=>{
    row.style.opacity = "0";
    row.style.transform = "translateY(20px)";

    setTimeout(()=>{
        row.style.transition = "0.5s";
        row.style.opacity = "1";
        row.style.transform = "translateY(0)";
    },index * 100);
});

</script>

</body>
</html>