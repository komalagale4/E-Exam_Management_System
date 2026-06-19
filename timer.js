var timeLeft = 300;

function startTimer(){

var timer = setInterval(function(){

if(timeLeft <= 0){
clearInterval(timer);
document.forms[0].submit();
}

document.getElementById("timer").innerHTML =
"Time Left: " + timeLeft + " sec";

timeLeft -= 1;

},1000);
}