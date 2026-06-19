<?php
$conn = mysqli_connect("localhost","root","","exam_portal");

if(!$conn){
    die("Connection Failed" . mysqli_connect_error());
}
?>