<?php //call via AJAX from div_quetion.php to calculate the question average success rate for each quiz.

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
$ctrl = new class_quiz_question_average_success_rate_controller($questionid);
$qQaverageSuccessRate = $ctrl->displayAll();

if(!$qQaverageSuccessRate) echo "";
else{
//var_dump($qQaverageSuccessRate);
    foreach ($qQaverageSuccessRate as $quiz){
        echo '<div class="row">'.
            '<div class="col-12 col-md-6">'.
            '<span class="font-weight-bold responsive-show">Titre du quiz<br></span>'.
            $quiz['title'].'</div>'.
            '<div class="col-12 col-md-1 text-md-center">'.
            '<span class="font-weight-bold responsive-show">Statut<br></span>'.
            $quiz['status'].'</div>'.
            '<div class="col-12 col-md-2">'.
            '<span class="font-weight-bold responsive-show">Mis à jour le<br></span>'. 
            date('d/m/Y', $quiz['lmd']).'</div>'. 
            '<div class="col-12 col-md-1 text-md-center">'.
            '<span class="font-weight-bold responsive-show">Nombre de succès<br></span>'.
            (($quiz['nbok'] or $quiz['nbok'] == '0') ? $quiz['nbok'] : "-").'</div>'.
            '<div class="col-12 col-md-1 text-md-center">'.
            '<span class="font-weight-bold responsive-show">Nombre de réponses<br></span>'.
            ($quiz['nbresults'] ? $quiz['nbresults'] : "-").'</div>'.
            '<div class="col-12 col-md-1 text-md-center">'.
            '<span class="font-weight-bold responsive-show">Taux de succès<br></span>'.
            ($quiz['nbresults'] ? (100 * round($quiz['nbok'] / $quiz['nbresults'], 3)) : "-").'</div>'.
        '</div>';
    }
}