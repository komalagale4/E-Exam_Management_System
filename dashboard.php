<?php
session_start();

if(!isset($_SESSION['admin_logged_in']))
{
    header("Location: login.php");
    exit();
}

include '../config/db.php';

$admin_name = $_SESSION['admin_logged_in'];

/* =========================
   SAFE TABLE CHECKS
========================= */

$total_students = 0;
$total_questions = 0;
$total_results = 0;

/* Students Count */
$check_students = mysqli_query($conn,
"SHOW TABLES LIKE 'students'");

if(mysqli_num_rows($check_students) > 0)
{
    $students_result = mysqli_query($conn,
    "SELECT COUNT(*) as total FROM students");

    $students_row = mysqli_fetch_assoc($students_result);

    $total_students = $students_row['total'];
}

/* Questions Count */
$check_questions = mysqli_query($conn,
"SHOW TABLES LIKE 'questions'");

if(mysqli_num_rows($check_questions) > 0)
{
    $questions_result = mysqli_query($conn,
    "SELECT COUNT(*) as total FROM questions");

    $questions_row = mysqli_fetch_assoc($questions_result);

    $total_questions = $questions_row['total'];
}

/* Results Count */
$check_results = mysqli_query($conn,
"SHOW TABLES LIKE 'results'");

if(mysqli_num_rows($check_results) > 0)
{
    $results_result = mysqli_query($conn,
    "SELECT COUNT(*) as total FROM results");

    $results_row = mysqli_fetch_assoc($results_result);

    $total_results = $results_row['total'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<title>Admin Dashboard</title>

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{
    font-family:'Segoe UI',sans-serif;
    background:linear-gradient(135deg,#0f172a,#1e3a8a);
    min-height:100vh;
    overflow-x:hidden;
}

/* SIDEBAR */

.sidebar{
    width:280px;
    height:100vh;
    position:fixed;
    top:0;
    left:0;
    background:rgba(15,23,42,0.95);
    backdrop-filter:blur(10px);
    padding:30px 0;
    color:white;
    box-shadow:4px 0 20px rgba(0,0,0,0.4);
    z-index:1000;
}

.sidebar-header{
    text-align:center;
    margin-bottom:35px;
}

.admin-avatar{
    width:90px;
    height:90px;
    border-radius:50%;
    background:linear-gradient(135deg,#f59e0b,#ef4444);
    display:flex;
    justify-content:center;
    align-items:center;
    margin:auto;
    font-size:2.5rem;
    animation:pulse 2s infinite;
}

@keyframes pulse{
    0%{
        box-shadow:0 0 0 0 rgba(245,158,11,0.7);
    }
    70%{
        box-shadow:0 0 0 20px rgba(245,158,11,0);
    }
    100%{
        box-shadow:0 0 0 0 rgba(245,158,11,0);
    }
}

.admin-name{
    margin-top:15px;
    font-size:1.3rem;
    font-weight:bold;
}

.menu a{
    display:flex;
    align-items:center;
    gap:12px;
    color:white;
    text-decoration:none;
    padding:16px 30px;
    transition:0.3s;
    font-size:16px;
}

.menu a:hover{
    background:#1e293b;
    padding-left:40px;
    border-left:4px solid #f59e0b;
}

.logout{
    position:absolute;
    bottom:20px;
    width:100%;
}

.logout a{
    display:flex;
    align-items:center;
    gap:12px;
    color:white;
    text-decoration:none;
    padding:15px 30px;
    transition:0.3s;
}

.logout a:hover{
    background:#dc2626;
}

/* MAIN CONTENT */

.content{
    margin-left:280px;
    padding:40px;
}

/* TOP HEADER */

.header{
    background:rgba(255,255,255,0.1);
    backdrop-filter:blur(10px);
    border-radius:20px;
    padding:35px;
    color:white;
    margin-bottom:35px;
    animation:fadeIn 1s ease;
}

.header h1{
    font-size:2.5rem;
    margin-bottom:10px;
}

.header p{
    font-size:18px;
    opacity:0.9;
}

/* STATS */

.stats{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(250px,1fr));
    gap:25px;
}

.card{
    background:white;
    border-radius:20px;
    padding:35px;
    text-align:center;
    transition:0.4s;
    position:relative;
    overflow:hidden;
}

.card::before{
    content:'';
    position:absolute;
    top:0;
    left:0;
    width:100%;
    height:5px;
    background:linear-gradient(90deg,#3b82f6,#9333ea);
}

.card:hover{
    transform:translateY(-10px) scale(1.03);
    box-shadow:0 20px 40px rgba(0,0,0,0.2);
}

.card i{
    font-size:3.5rem;
    margin-bottom:15px;
}

.students i{
    color:#3b82f6;
}

.questions i{
    color:#f59e0b;
}

.results i{
    color:#10b981;
}

.card h2{
    font-size:3rem;
    margin-bottom:10px;
    color:#111827;
}

.card p{
    color:#6b7280;
    font-size:17px;
}

/* ACTIONS */

.actions{
    margin-top:40px;
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
    gap:25px;
}

.action-box{
    background:rgba(255,255,255,0.12);
    backdrop-filter:blur(12px);
    border-radius:20px;
    padding:35px;
    text-align:center;
    color:white;
    cursor:pointer;
    transition:0.4s;
    border:1px solid rgba(255,255,255,0.1);
}

.action-box:hover{
    transform:translateY(-10px);
    background:rgba(255,255,255,0.2);
}

.action-box i{
    font-size:3rem;
    margin-bottom:18px;
    color:#fbbf24;
}

.action-box h3{
    font-size:20px;
}

/* FOOTER */

.footer{
    margin-top:50px;
    text-align:center;
    color:white;
    opacity:0.7;
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

/* MOBILE */

.mobile-btn{
    display:none;
    position:fixed;
    top:20px;
    left:20px;
    background:#111827;
    color:white;
    padding:12px 15px;
    border-radius:10px;
    z-index:2000;
    cursor:pointer;
}

@media(max-width:768px){

.mobile-btn{
    display:block;
}

.sidebar{
    left:-100%;
    transition:0.4s;
}

.sidebar.active{
    left:0;
}

.content{
    margin-left:0;
    padding:20px;
}

.header h1{
    font-size:2rem;
}

.stats{
    grid-template-columns:1fr;
}

.actions{
    grid-template-columns:1fr;
}

}

</style>

</head>

<body>

<!-- MOBILE BUTTON -->

<div class="mobile-btn" id="menuBtn">
<i class="fas fa-bars"></i>
</div>

<!-- SIDEBAR -->

<div class="sidebar" id="sidebar">

<div class="sidebar-header">

<div class="admin-avatar">
<i class="fas fa-user-shield"></i>
</div>

<div class="admin-name">
<?php echo $admin_name; ?>
</div>

</div>

<div class="menu">

<a href="dashboard.php">
<i class="fas fa-home"></i>
Dashboard
</a>

<a href="add_question.php">
<i class="fas fa-plus-circle"></i>
Add Questions
</a>


<a href="student_result.php">
<i class="fas fa-chart-bar"></i>
View Results
</a>

<a href="manage_student.php">
<i class="fas fa-users"></i>
Manage Students
</a>

</div>

<div class="logout">

<a href="logout.php">

<i class="fas fa-sign-out-alt"></i>
Logout

</a>

</div>

</div>

<!-- MAIN CONTENT -->

<div class="content">

<div class="header">

<h1>
Welcome Admin 👋
</h1>

<p>
Manage your Online Exam Portal Easily.
</p>

</div>

<!-- STATS -->

<div class="stats">

<div class="card students">

<i class="fas fa-user-graduate"></i>

<h2 id="studentCount">
<?php echo $total_students; ?>
</h2>

<p>Total Students</p>

</div>

<div class="card questions">

<i class="fas fa-question-circle"></i>

<h2 id="questionCount">
<?php echo $total_questions; ?>
</h2>

<p>Total Questions</p>

</div>

<div class="card results">

<i class="fas fa-chart-line"></i>

<h2 id="resultCount">
<?php echo $total_results; ?>
</h2>

<p>Total Results</p>

</div>

</div>

<!-- QUICK ACTIONS -->

<div class="actions">

<div class="action-box"
onclick="window.location.href='add_question.php'">

<i class="fas fa-plus"></i>

<h3>Add Question</h3>

</div>


<div class="action-box"
onclick="window.location.href='student_result.php'">

<i class="fas fa-chart-bar"></i>

<h3>View Results</h3>

</div>

<div class="action-box"
onclick="window.location.href='manage_student.php'">

<i class="fas fa-users"></i>

<h3>Manage Students</h3>

</div>

</div>

<div class="footer">

<p>
© 2026 Online Exam Portal | Admin Panel
</p>

</div>

</div>

<script>

/* MOBILE SIDEBAR */

const menuBtn = document.getElementById("menuBtn");
const sidebar = document.getElementById("sidebar");

menuBtn.addEventListener("click",function(){
    sidebar.classList.toggle("active");
});

/* COUNT ANIMATION */

function animateValue(id,start,end,duration)
{
    let obj = document.getElementById(id);

    let range = end - start;

    let current = start;

    let increment = end > start ? 1 : -1;

    let stepTime = Math.abs(Math.floor(duration / range));

    let timer = setInterval(function(){

        current += increment;

        obj.innerHTML = current;

        if(current == end)
        {
            clearInterval(timer);
        }

    },stepTime);
}

animateValue("studentCount",0,
<?php echo $total_students; ?>,1000);

animateValue("questionCount",0,
<?php echo $total_questions; ?>,1000);

animateValue("resultCount",0,
<?php echo $total_results; ?>,1000);

</script>

</body>
</html>