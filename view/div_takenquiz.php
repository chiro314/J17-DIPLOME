<?php
/* The questions and the answers of the quiz, got by class_takenquiz_controller.php
*  (index.php/form_lock_quiz from div_quiz_userlist.php), are already sorted at random 
*  (SQL in class_takenquiz.php) and the answers are grouped by question by the class, 
*  so that the programme below is able to build easily the html structure.
*  Below, the all questions are uncluded in the <div id="div-quiz"> and each question 
*  (with its answers) is included in a <div class="row" id="'.$iq.'"> 
*  where $iq is the question's number, so that the JavaScript will be able to use the DOM
*  to display the questions one after the other, using hide() and show().
*  The <div id="div-quiz"> is wraped into a form, submited by JavaScript when the quiz
*  is over, so that index.php get the form back to build a result object.
*/

/*****************************************************************************************
* Screen:       view/div_takenquiz.php
* admin/user:   user
* Scope:	    quiz (run)
* JS:           vew/scriptv1.js
* CSS:          vew/style.css
* 
* Feature (maquette): Run a quiz (with or without time limit) that has just been started (maq-11-12)
* Trigger:  Button "Commencer" in user dashboard confirmation div (form_lock_quiz)
*           / index.php/form_lock_quiz /class class_takenquiz_controller (class_takenquiz_controller.php) ->displayOne()
* 
* Major tasks:  o Display the terms
*                   - JS: hideQuestions()
*               o Show progress (time + questions) with each new question
*                   - JS:   onclickbtshowtimer()
*                           $("#bt-taken-quiz").click(function(){...
*                           if(document.getElementById('bt-taken-quiz') && $("#quizMaxDuration").val() !=0){…
*               o Order the questions (numorder + RAND) and the answers (RAND): model/class_takenquiz.php
*               o Present questions/answers (Button "Commencer" of the div "div-bt-taken-quiz")
*                   - JS:   $("#bt-taken-quiz").click(function(){…   :
*                               o displayQuestion(numQuestion)
*                               o displayButtonWording(what)
*                               o updateInfoBeforeSubmit()
*                               o updateDivProgress()
*                               o cumulateQuizNbanswersaskedNames(numQuestion)
*               o Next processing :
*                   >>Structure the user's answers so that they are processed by the server
*                       - index.php/form_taken_quiz/questionsanswered.php
*                   >>Store result data
*                       - index.php/form_taken_quiz/controller/class_accountresult_controller.php/->insertOne(…)
*******************************************************************************************/

/* Object structure (quiz part) in class_takenquiz.php :
                private $quiz = [
                    'sessionId' => 0,
                    'sessionTitle' => "",
                    'sessionSubtitle' => "",
                    'quizId' => 0,
                    'quizTitle' => "",
                    'quizSubtitle' => "",
                    'quizDuration' => 0
                ];
*/               
global $login, $quizlock_datetime;
?>
<div id="div-quiz-title px-2"> <?php 
    if ($quiz == null) echo "Ce quiz n'est pas opérationnel.<br>Consultez votre formateur.";
    else {
        $duration = $quiz['quizDuration']; ?>
        <br>
        <p class="text-center h5 mt-2"><?php echo $quiz['sessionTitle'] ?></p>
        <p class="text-center mt-2"><?php echo $quiz['sessionSubtitle'] ?></p>
        <p class="text-center h5 mt-2"><?php echo $quiz['quizTitle'] ?></p>
        <p class="text-center mt-2"><?php echo $quiz['quizSubtitle'] ?></p>
        <?php
    } ?>
</div>
<div class="div-alert px-2"><?php
    if ($quiz != null and $questions == null) echo "Les questions de ce quiz ne sont pas opérationnelles.<br>Consultez votre formateur."; ?>
</div> 
<div class="px-2"><?php
if ($quiz != null and $questions != null){ 
    if(!$quiz['quizDuration']){ //without timer ?>
        <div id="div-taken-quiz-order" class="div-order text-center"> 
                echo "Pour réaliser ce quiz, aucune limite de temps n'a été définie. Suivez les consignes de votre professeur.";
                echo "<br><span class='font-weight-bold'><br>ATTENTION</span> : l'utilisation de la flèche 'retour arrière' (<-), en haut à gauche sur votre écran,<br>équivaut à ABANDONNER le quiz qui sera verrouillé.<br>Vos données seront perdues et vous ne pourrez pas relancer le quiz.";
                echo "<br>L'avancement du temps est fourni à titre indicatif. Tout dépassement du temps constaté sur le serveur, après la fin du quiz, se traduira au prorata par la mise à l'écart des dernières questions auxquelles vous aurez répondu.";
        </div> <?php
    } 
    else{ // with timer ?> 
        <div class="row">
            <div class="col-12 col-md-8 div-order" id="div-taken-quiz-order"><?php                 
                if($quiz['quizDuration'] > 59) {
                    $strDuration = intdiv($quiz['quizDuration'], 60);
                    if ($strDuration > 1) $strDuration = strval($strDuration)." heures.";
                    else $strDuration = strval($strDuration)." heure";
                    if($quiz['quizDuration']%60) {
                        $strDuration.= " et ".strval($quiz['quizDuration']%60)." minutes.";
                    }
                }
                else $strDuration = $quiz['quizDuration']." minutes.";

                date_default_timezone_set('Europe/Paris');
                echo "Pour réaliser ce quiz, vous disposez de <span class='font-weight-bold'>".$strDuration."</span><br>Le décompte a commencé à ".date('d/m/Y H:i',$quizlock_datetime)." (heure serveur).";     
                echo "<br><span class='font-weight-bold'><br>ATTENTION</span> : l'utilisation de la flèche 'retour arrière' (<-), en haut à gauche sur votre écran,<br>équivaut à ABANDONNER le quiz qui sera verrouillé.<br>Vos données seront perdues et vous ne pourrez pas relancer le quiz."; ?>
            </div>
            <div class="col-12 col-md-4">
                <div row>
                    <div class="col-12 font-weight-bold">
                        <p>Avancement à la validation de votre dernière réponse</p>
                    </div>
                </div>
                <div row>
                    <div class="col-12" id="div-timer">

                        <div class="row">
                            <div class="col-3">
                                <div>
                                    <label>Temps écoulé</label>
                                </div>
                            </div>
                            <div class="col-9 pt-1">
                                <div class="progress">
                                    <div id="div-progress-time" class="bg-danger progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-3">
                                <div>
                                    <label>Questions traitées</label>
                                </div>
                            </div>
                            <div class="col-9 pt-1">
                                <div class="progress">
                                    <div id="div-progress-questions" class="bg-success progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div row>
                    <div class="col-12">
                        <button id="bt-show-timer" type="button" onclick="onclickbtshowtimer()">Masquer l'avancement</button>
                    </div>
                </div>
            </div>
        </div> <?php
    } ?>
    <div id="div-bt-taken-quiz" class="text-center">
        <br><button id="bt-taken-quiz"><a href="#div-hello-footer">Commencer</a></button><br><br>  
    </div>
    <?php

    /*  Oject array structure (questions part) in class_takenquiz.php :

        $this->questions[$i][self::QUESTIONID] = $row['question_id'];
        $this->questions[$i][self::QUESTION] = $row['question_question'];
        $this->questions[$i][self::QUIDELINE] = $row['question_guideline'];
        $this->questions[$i][self::WIDGET] = $row['widget_id'];
        $this->questions[$i][self::WEIGHT] = $row['quiz_question_weight'];
        $this->questions[$i][self::NUMORDER] = $row['quiz_question_numorder'];
                   
        $this->questions[$i][self::ANSWERSIDQUESTION] = $row['answer_idquestion'];
        $this->questions[$i][self::ANSWER] = $row['answer_answer'];
        $this->questions[$i][self::ANSWEROK] = $row['answer_ok'];
        $this->questions[$i][self::ANSWERID] = $row['answer_id'];
    */  
    ?>
    <form id="form_taken_quiz" name="form_taken_quiz" action="index.php" method="POST">
        <div id="div-quiz">
            <?php
            $iq = -1;   //question number
            $i  =  0; // answer id
            $iname = -1; // for answers : the same for radio, different for box 
            $firstTime = true;
            $newQuestion = true;
            foreach($questions as $question){ //from displayOne() / getQuestions() in class_takenquiz_controller.php
                if($iq == -1 or $question[QUESTIONID] != $questions[$i -1][QUESTIONID]){
                    $iq++;  //for the new question
                    $newQuestion = true;
                }
                if($newQuestion){
                    if(!$firstTime) echo '</div></div>';      //close the col and the row
                    echo '<div class="row" id="div-'.$iq.'">';    //open the row and the col  
                    echo '<div class="col-12 offset-md-2 col-md-9">'; 
                    echo '<p class="font-weight-bold">'.$question[QUESTION].'</p>';
                    echo '<p>'.$question[QUIDELINE].'</p>';

                    echo '<input type="hidden" id="question-'.$iq.'" name="question-'.$iq.'" value="'.$question[WIDGET]."-".$question[QUESTIONID].'">';
                
                    if($question[WIDGET] == "radio") $iname++;
                }
                // answer :

                if($question[WIDGET] == "radio"){ 
                    echo '<input class="'.$iq.'" type="radio" id="'.$i.'" name="'.$iname.'" value="radio-'.$question[QUESTIONID].'-'.$question[ANSWERID].'">'; //id = answer_id ; name = num answer ; value = widget-id - question_id - answer_id
                    echo '<label class="ml-2" for="'.$i.'">'.$question[ANSWER].'</label>';
                }
                else if ($question[WIDGET] == "checkbox"){  
                    $iname++;
                    echo '<input class="'.$iq.'" type="checkbox" id="'.$i.'" name="'.$iname.'" value="checkbox-'.$question[QUESTIONID].'-'.$question[ANSWERID].'">'; //id = answer_id ; name = num answer ; value = widget-id - question_id - answer_id
                    echo '<label class="ml-2" for="'.$i.'">'.$question[ANSWER].'</label>';
                }
                echo '<br>';
                        
                $i++; //for the next lign
                $newQuestion = false;
                $firstTime = false;   
            } ?>
            </div></div>  <!--/close the last div col and the last div row $iq-->  
        </div> <!--div-quiz-->

        <!--For the timer : -->
        <!--<input type="hidden" name="lockDate" value="<?php //echo $quizlock_datetime ?>" id="quizlock_datetime">-->

        <!--For the accountresult object : -->
        <input type="hidden" name="loginUser" value="<?php echo $login ?>">
        <input type="hidden" name="sessionId" value="<?php echo $quiz['sessionId'] ?>">
        <input type="hidden" name="sessionTitle" value="<?php echo $quiz['sessionTitle'] ?>">
        <input type="hidden" name="sessionSubtitle" value="<?php echo $quiz['sessionSubtitle'] ?>">
        <input type="hidden" name="quizId" value="<?php echo $quiz['quizId'] ?>">
        <input type="hidden" name="quizTitle" value="<?php echo $quiz['quizTitle'] ?>">
        <input type="hidden" name="quizSubtitle" value="<?php echo $quiz['quizSubtitle'] ?>">
        <input type="hidden" name="quizMaxDuration" value="<?php echo $quiz['quizDuration'] ?>" id="quizMaxDuration">
        <!--From JavaScript : -->
        <input type="hidden" name="quizStartdate" id="quizStartdate"> <!--JS-->
        <input type="hidden" name="quizEnddate" id="quizEnddate"> <!--JS-->
        <input type="hidden"  name="quizMaxnbquest" id="quizMaxnbquest"> <!--JS-->
        <input type="hidden" name="quizNbquestasked" id="quizNbquestasked"> <!--JS--><!--each time you click on the button "Question suivante" (next question)-->

        <?php echo '<input type="hidden" name="quizMaxnbanswersNames" id="quizMaxnbanswersNames" value="'.($iname +1).'">'; ?>
        <input type="hidden" name="quizNbanswersaskedNames" id="quizNbanswersaskedNames"> <!--JS-->

        <input type="hidden" name="form_taken_quiz" value="1">
        <div class="text-center d-none">
            <br><input type="submit" value="Envoyer" class="button"> <!--submited by JavaScript-->
        </div>
    </form> <?php
} ?>
</div>