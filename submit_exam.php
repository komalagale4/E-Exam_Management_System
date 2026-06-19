<?php
session_start();

if(!isset($_SESSION['student_id'])){
    header("Location: login.php");
    exit();
}

include '../config/db.php';

$student_id = $_SESSION['student_id'];
$student_name = $_SESSION['student_name'];

/* =========================================
   SELECT SUBJECT
========================================= */

$subject = isset($_GET['subject']) ? $_GET['subject'] : 'java';

/* =========================================
   JAVA QUESTIONS
========================================= */

$java_questions = [

[
'qid'=>1,
'question'=>'Who invented Java?',
'options'=>['A) Dennis Ritchie','B) James Gosling','C) Guido','D) Bjarne'],
'answer'=>'B'
],

[
'qid'=>2,
'question'=>'Which keyword creates object?',
'options'=>['A) object','B) make','C) new','D) class'],
'answer'=>'C'
],

[
'qid'=>3,
'question'=>'Which method is entry point?',
'options'=>['A) run()','B) main()','C) start()','D) init()'],
'answer'=>'B'
],

[
'qid'=>4,
'question'=>'Java is ___ language.',
'options'=>['A) Procedural','B) Object Oriented','C) Assembly','D) Machine'],
'answer'=>'B'
],

[
'qid'=>5,
'question'=>'Which package contains Scanner?',
'options'=>['A) java.io','B) java.net','C) java.util','D) java.awt'],
'answer'=>'C'
]
];

/* =========================================
   PYTHON QUESTIONS
========================================= */

$python_questions = [

[
'qid'=>101,
'question'=>'Who invented Python?',
'options'=>['A) James Gosling','B) Guido van Rossum','C) Dennis Ritchie','D) Elon Musk'],
'answer'=>'B'
],

[
'qid'=>102,
'question'=>'Python is a ___ language.',
'options'=>['A) Compiled','B) Machine','C) Interpreted','D) Binary'],
'answer'=>'C'
],

[
'qid'=>103,
'question'=>'Which symbol is used for comments?',
'options'=>['A) //','B) <!-- -->','C) #','D) **'],
'answer'=>'C'
],

[
'qid'=>104,
'question'=>'Which keyword defines function?',
'options'=>['A) function','B) define','C) def','D) fun'],
'answer'=>'C'
],

[
'qid'=>105,
'question'=>'Which function prints output?',
'options'=>['A) echo()','B) printf()','C) print()','D) cout'],
'answer'=>'C'
]
];

/* =========================================
   MYSQL QUESTIONS
========================================= */

$mysql_questions = [

[
'qid'=>201,
'question'=>'MySQL is a ___',
'options'=>['A) Language','B) Database','C) Browser','D) IDE'],
'answer'=>'B'
],

[
'qid'=>202,
'question'=>'Which command retrieves data?',
'options'=>['A) GET','B) FETCH','C) SELECT','D) SHOW'],
'answer'=>'C'
],

[
'qid'=>203,
'question'=>'Which command inserts data?',
'options'=>['A) ADD','B) INSERT','C) PUT','D) CREATE'],
'answer'=>'B'
],

[
'qid'=>204,
'question'=>'Which clause filters records?',
'options'=>['A) WHERE','B) SORT','C) FILTER','D) HAVING'],
'answer'=>'A'
],

[
'qid'=>205,
'question'=>'Which command creates database?',
'options'=>['A) NEW DATABASE','B) MAKE DATABASE','C) CREATE DATABASE','D) DATABASE CREATE'],
'answer'=>'C'
]
];

/* =========================================
   SUBJECT LOGIC
========================================= */

if($subject == "python"){
    $questions = $python_questions;
    $exam_title = "Python Online Exam";
}
else if($subject == "mysql"){
    $questions = $mysql_questions;
    $exam_title = "MySQL Online Exam";
}
else{
    $questions = $java_questions;
    $exam_title = "Java Online Exam";
}

/* =========================================
   SUBMIT EXAM
========================================= */

if(isset($_POST['submit_exam'])){

    $score = 0;
    $total = count($questions);

    foreach($questions as $q){

        if(
            isset($_POST['answer'.$q['qid']]) &&
            $_POST['answer'.$q['qid']] == $q['answer']
        ){
            $score++;
        }
    }

    $percentage = ($score / $total) * 100;

    $exam_date = date('Y-m-d H:i:s');

    mysqli_query($conn,"
    INSERT INTO results
    (student_id,score,total,percentage,exam_date)
    VALUES
    ('$student_id','$score','$total','$percentage','$exam_date')
    ");

    $_SESSION['exam_result'] = [
        'score'=>$score,
        'total'=>$total,
        'percentage'=>$percentage
    ];

    header("Location: result.php");
    exit();
}

$totalQuestions = count($questions);

?>

<!DOCTYPE html>
<html>
<head>

<title><?php echo $exam_title; ?></title>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

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
    background:linear-gradient(135deg,#1e3a8a,#0f172a);
    color:white;
}

/* NAVBAR */

.navbar{
    background:#111827;
    padding:18px 25px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    flex-wrap:wrap;
    box-shadow:0 5px 15px rgba(0,0,0,0.3);
}

.logo{
    font-size:26px;
    font-weight:bold;
    color:white;
}

.nav-right{
    display:flex;
    align-items:center;
    gap:15px;
    flex-wrap:wrap;
}

.student{
    font-size:18px;
    color:white;
    background:#1e3a8a;
    padding:10px 18px;
    border-radius:10px;
}

.nav-btn{
    text-decoration:none;
    padding:10px 18px;
    border-radius:10px;
    color:white;
    font-weight:bold;
    transition:0.3s;
}

.dashboard-btn{
    background:#2563eb;
}

.dashboard-btn:hover{
    background:#1d4ed8;
    transform:translateY(-2px);
}

.logout-btn{
    background:#dc2626;
}

.logout-btn:hover{
    background:#b91c1c;
    transform:translateY(-2px);
}

/* CONTAINER */

.container{
    width:95%;
    max-width:1100px;
    margin:30px auto;
}

/* SUBJECT BUTTONS */

.subjects{
    display:flex;
    gap:15px;
    margin-bottom:25px;
    flex-wrap:wrap;
}

.subject-btn{
    text-decoration:none;
    padding:12px 20px;
    background:white;
    color:#111827;
    border-radius:10px;
    font-weight:bold;
    transition:0.3s;
}

.subject-btn:hover{
    background:#2563eb;
    color:white;
    transform:translateY(-2px);
}

/* HEADER */

.exam-header{
    background:white;
    color:#111827;
    padding:30px;
    border-radius:15px;
    margin-bottom:25px;
    text-align:center;
}

.exam-header h1{
    color:#1e3a8a;
    margin-bottom:10px;
}

.timer{
    margin-top:15px;
    color:red;
    font-size:22px;
    font-weight:bold;
}

/* PROGRESS */

.progress-bar{
    width:100%;
    height:18px;
    background:#ddd;
    border-radius:20px;
    overflow:hidden;
    margin-top:15px;
}

.progress{
    width:0%;
    height:100%;
    background:linear-gradient(90deg,#22c55e,#16a34a);
    transition:0.4s;
}

/* QUESTIONS */

.question-card{
    background:white;
    color:#111827;
    padding:30px;
    border-radius:15px;
    margin-bottom:25px;
    box-shadow:0 10px 20px rgba(0,0,0,0.2);
}

.question-number{
    background:#2563eb;
    color:white;
    display:inline-block;
    padding:8px 15px;
    border-radius:8px;
    margin-bottom:15px;
}

.question-card h3{
    margin-bottom:20px;
}

.option{
    display:block;
    background:#f3f4f6;
    padding:15px;
    margin-bottom:12px;
    border-radius:10px;
    cursor:pointer;
    transition:0.3s;
}

.option:hover{
    background:#dbeafe;
}

.option input{
    margin-right:10px;
}

/* SUBMIT */

.submit-btn{
    width:100%;
    padding:18px;
    background:linear-gradient(90deg,#22c55e,#15803d);
    border:none;
    color:white;
    border-radius:12px;
    font-size:20px;
    cursor:pointer;
    transition:0.3s;
}

.submit-btn:hover{
    transform:scale(1.02);
}

/* MOBILE */

@media(max-width:768px){

    .navbar{
        flex-direction:column;
        gap:15px;
        text-align:center;
    }

    .nav-right{
        justify-content:center;
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

    <div class="nav-right">

        <a href="dashboard.php" class="nav-btn dashboard-btn">
            <i class="fas fa-home"></i>
            Dashboard
        </a>

        <div class="student">
            <i class="fas fa-user"></i>
            <?php echo $student_name; ?>
        </div>

        <a href="logout.php" class="nav-btn logout-btn">
            <i class="fas fa-sign-out-alt"></i>
            Logout
        </a>

    </div>

</div>

<div class="container">

<!-- SUBJECT BUTTONS -->

<div class="subjects">

<a href="?subject=java" class="subject-btn">
<i class="fab fa-java"></i> Java Exam
</a>

<a href="?subject=python" class="subject-btn">
<i class="fab fa-python"></i> Python Exam
</a>

<a href="?subject=mysql" class="subject-btn">
<i class="fas fa-database"></i> MySQL Exam
</a>

</div>

<!-- EXAM HEADER -->

<div class="exam-header">

<h1><?php echo $exam_title; ?></h1>

<p>
<?php echo $totalQuestions; ?> Questions
</p>

<div class="timer">
Time Left:
<span id="time">15:00</span>
</div>

<div class="progress-bar">
<div class="progress" id="progress"></div>
</div>

</div>

<!-- FORM -->

<form method="POST" id="examForm">

<?php
$count = 1;

foreach($questions as $q){
?>

<div class="question-card">

<div class="question-number">
Question <?php echo $count; ?>
</div>

<h3>
<?php echo $q['question']; ?>
</h3>

<?php
foreach($q['options'] as $option){

$optKey = substr($option,0,1);
?>

<label class="option">

<input type="radio"
name="answer<?php echo $q['qid']; ?>"
value="<?php echo $optKey; ?>">

<?php echo $option; ?>

</label>

<?php } ?>

</div>

<?php
$count++;
}
?>

<button type="submit"
name="submit_exam"
class="submit-btn">

<i class="fas fa-paper-plane"></i>
Submit Exam

</button>

</form>

</div>

<script>

/* PROGRESS BAR */

const totalQuestions = <?php echo $totalQuestions; ?>;

const radios = document.querySelectorAll('input[type="radio"]');

const progress = document.getElementById('progress');

function updateProgress(){

    const answered =
    document.querySelectorAll('input[type="radio"]:checked').length;

    const percent =
    (answered / totalQuestions) * 100;

    progress.style.width = percent + "%";
}

radios.forEach(radio => {

    radio.addEventListener('change', updateProgress);

});

/* TIMER */

let timeLeft = 900;

const timer = document.getElementById("time");

const countdown = setInterval(function(){

    let minutes = Math.floor(timeLeft / 60);
    let seconds = timeLeft % 60;

    seconds = seconds < 10 ? '0'+seconds : seconds;

    timer.innerHTML = minutes + ":" + seconds;

    timeLeft--;

    if(timeLeft < 0){

        clearInterval(countdown);

        alert("Time Over! Exam Submitted.");

        document.getElementById("examForm").submit();
    }

},1000);

</script>

</body>
</html>