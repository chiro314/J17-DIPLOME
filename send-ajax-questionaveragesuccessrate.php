<?php //call via AJAX from div_quetion.php to calculate the question average success rate.

session_start();
$questionid =0;
$login = "";

if(isset($_SESSION["login"])){
    $login = $_SESSION["login"];
}
if(isset($_SESSION["questionid"])){
    $questionid = $_SESSION["questionid"];
}

require "model/connexionbdd.php";
require "model/class_question.php";
require "controller/class_question_controller.php";
$ctrl = new class_question_average_success_rate_controller($questionid);
$averageSuccessRate = $ctrl->displayOne();
//var_dump($averageSuccessRate);

//echo '<span id="span-question-success" class="h1">'.(($averageSuccessRate['nbok'] and $averageSuccessRate['nb'] and $averageSuccessRate['nb'] >0) ? (100*round(intval($averageSuccessRate['nbok']) / intval($averageSuccessRate['nb']), 3))." %" : "? %").'</span><br>de réussite';
if(!$averageSuccessRate['nb']) {
    echo '<span id="span-question-success" class="h1">'."? %".'</span><br>de réussite'; 
}
else if(!$averageSuccessRate['nbok']){
    echo '<span id="span-question-success" class="h1">'."0 %".'</span><br>de réussite';
}
else{
    echo '<span id="span-question-success" class="h1">'.(100*round(intval($averageSuccessRate['nbok']) / intval($averageSuccessRate['nb']), 3))." %".'</span><br>de réussite';
}            
