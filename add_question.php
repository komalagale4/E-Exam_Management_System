<?php
session_start();
include '../config/db.php';

if(!isset($_SESSION['admin_logged_in']))
{
    header("Location: login.php");
    exit();
}

$message = "";

if(isset($_POST['add_question']))
{
    $question = mysqli_real_escape_string($conn,$_POST['question']);
    $option1 = mysqli_real_escape_string($conn,$_POST['option1']);
    $option2 = mysqli_real_escape_string($conn,$_POST['option2']);
    $option3 = mysqli_real_escape_string($conn,$_POST['option3']);
    $option4 = mysqli_real_escape_string($conn,$_POST['option4']);
    $correct_answer = mysqli_real_escape_string($conn,$_POST['correct_answer']);

    $insert = mysqli_query($conn,"INSERT INTO questions
    (question,option1,option2,option3,option4,correct_answer)
    VALUES
    ('$question','$option1','$option2','$option3','$option4','$correct_answer')");

    if($insert)
    {
        $message = "Question Added Successfully!";
    }
    else
    {
        $message = "Failed To Add Question!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>

<title>Add Question</title>

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
    background:linear-gradient(135deg,#1e3c72,#2a5298);
    min-height:100vh;
    padding:40px;
}

.container{
    max-width:750px;
    background:white;
    margin:auto;
    padding:40px;
    border-radius:20px;
    box-shadow:0 10px 30px rgba(0,0,0,0.2);
}

.top-bar{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:30px;
    flex-wrap:wrap;
}

h1{
    color:#22448d;
    font-size:32px;
}

.back-btn{
    background:#22448d;
    color:white;
    padding:12px 20px;
    border-radius:10px;
    text-decoration:none;
    transition:0.3s;
    font-weight:bold;
}

.back-btn:hover{
    background:#18346d;
    transform:translateY(-3px);
}

input,
textarea,
select{
    width:100%;
    padding:14px;
    margin-top:10px;
    margin-bottom:20px;
    border-radius:10px;
    border:1px solid #ccc;
    font-size:16px;
    outline:none;
}

textarea{
    min-height:120px;
    resize:vertical;
}

input:focus,
textarea:focus,
select:focus{
    border-color:#22448d;
    box-shadow:0 0 8px rgba(34,68,141,0.3);
}

button{
    width:100%;
    padding:15px;
    background:#22448d;
    color:white;
    border:none;
    border-radius:10px;
    font-size:18px;
    cursor:pointer;
    transition:0.3s;
}

button:hover{
    background:#18346d;
    transform:translateY(-3px);
}

.message{
    background:#d1fae5;
    padding:15px;
    border-radius:10px;
    margin-bottom:20px;
    color:green;
    text-align:center;
    font-weight:bold;
}

</style>

</head>

<body>

<div class="container">

<div class="top-bar">

<h1>
<i class="fas fa-plus-circle"></i>
Add Question
</h1>

<a href="dashboard.php" class="back-btn">
<i class="fas fa-arrow-left"></i>
Back Dashboard
</a>

</div>

<?php if($message!=""){ ?>

<div class="message">
<?php echo $message; ?>
</div>

<?php } ?>

<form method="POST">

<textarea
name="question"
placeholder="Enter Question"
required></textarea>

<input
type="text"
name="option1"
placeholder="Option 1"
required>

<input
type="text"
name="option2"
placeholder="Option 2"
required>

<input
type="text"
name="option3"
placeholder="Option 3"
required>

<input
type="text"
name="option4"
placeholder="Option 4"
required>

<select name="correct_answer" required>

<option value="">
Select Correct Answer
</option>

<option value="option1">
Option 1
</option>

<option value="option2">
Option 2
</option>

<option value="option3">
Option 3
</option>

<option value="option4">
Option 4
</option>

</select>

<button type="submit" name="add_question">

<i class="fas fa-save"></i>
Add Question

</button>

</form>

</div>

</body>
</html>