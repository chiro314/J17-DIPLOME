<?php
/*****************************************************************************************
* Screen:       view/div_quizresult.php
* admin/user:   user
* Scope:	    quiz result
* JS:           vew/scriptv1.js
* CSS:          vew/style.css
* 
* Feature (maquette): View data about the quiz run and its results (maq-09)
* Trigger:  User dashboard rating links (div_quiz_userlist.php)
*           /index.php/$_REQUEST: "quizresult/display"
*           /class class_accountresult_controller (class_accountresult_controller.php)
*               ->getOne($squizresultId)
*               ->displayOne()
*******************************************************************************************/

/* Object structure :
    private $quizresult = [
        'quizresultId' => 0, //if the argument $quizresultId != 0, then __CONSTRUCT try to get an existing accountresult, else a new accountresult has to be created.

        'loginUser' => "",
        
        'idSession' => 0,
        'sessionTitle' => "",
        'sessionSubtitle' => "",

        'idQuiz' => 0,

        'quizTitle' => "", 
        'quizSubtitle' => "",
        'quizMaxDuration' => 0, //Duration imposed by the trainer in minutes
        'quizStartdate' => 0,
        'quizEnddate' => 0,

        'quizMaxnbquest' => 0,
        'quizNbquestasked' => 0, //If the quiz is time limited and this time reached before the end of the quiz.
        'quizQuestaskedscore' => 0,    //A mark is calculated on the basis of the questions asked,
        'quizMaxquestaskedscore' => 0, //brought back to the maximum score reachable with those questions.
                                       //This relative mark is quizQuestaskedscore / quizMaxquestaskedscore
        'quizMaxscore' => 0, //The real mark is brought back to the maximum score reachable with all the questions.
                             //The real mark is quizQuestaskedscore / quizMaxscore
    ];

    private $failedquestions = [ [] ]; //with result okko - on demand with getQuestionsresults()

    private const QUESTIONID =0, QUESTION = 1, QUIDELINE = 2, WIDGET = 3, WEIGHT = 4, NUMORDER = 5;
    private const ANSWERSIDQUESTION = 6, ANSWER = 7, ANSWEROK = 8; 

    private const OKKO = 1, WIDNAME = 2;
    private const OK = 1, KO = 0;

    private const QUESTIONKO = 0, EXPLANATIONTITLE = 1, EXPLANATION = 2;
*/
?>
<div id="div-quiz-title px-2"> <?php 
    if ($quizresult == null) echo "<span class='text-danger'>Le résultat de ce quiz n'est pas opérationnel.<br>Consultez votre formateur.</span>";
    else {
        //$duration = $quizresult['quizMaxDuration']; ?>
        <br>
        <p class="text-center h5 mt-2"><?php echo $quizresult['sessionTitle'] ?></p>
        <p class="text-center mt-2"><?php echo $quizresult['sessionSubtitle'] ?></p>
        <p class="text-center h5 mt-2 font-weight-bold">RÉSULTAT DE VOTRE QUIZ</p>
        <p class="text-center h5 mt-2"><?php echo $quizresult['quizTitle'] ?></p>
        <p class="text-center mt-2"><?php echo $quizresult['quizSubtitle'] ?></p>
        <br><?php
    } ?>
</div>

<div class="div-alert px-2"></div> 

<div class="px-2"><?php
if ($quizresult != null){ ?>
    <div class="div-quiz-order"> <?php 
        if($quizresult['quizMaxDuration']) {
            
            $strDuration = minHoursMin($quizresult['quizMaxDuration']);

            echo "Pour réaliser ce quiz, vous disposiez de <span class='font-weight-bold'>".$strDuration."</span>.";     
        }
        else echo "Aucune limite de temps n'était imposée pour réaliser ce quiz.";
        ?>
    </div> <?php
    
    $durationInSec = $quizresult['quizEnddate'] - $quizresult['quizStartdate'];
    $strDuration = secHoursMinSec($durationInSec);
    echo "Vous avez réalisé ce quiz en <span class='font-weight-bold'>".$strDuration."</span>";
    
    if($quizresult['quizMaxDuration']) {
        echo " : vous avez donc utilisé <span class='font-weight-bold'>"
            .timeusedpercent($durationInSec, $quizresult['quizMaxDuration'])
            ." %</span> du temps disponible.";
    }
    else echo ".";

    if ($quizresult['quizNbquestasked'] == $quizresult['quizMaxnbquest']){
        echo "<br>Vous avez répondu aux <span class='font-weight-bold'>".$quizresult['quizMaxnbquest']."</span> questions du quiz.";
        echo "<br><br>Vous avez obtenu <span class='font-weight-bold'>".$quizresult['quizQuestaskedscore']."</span> point".($quizresult['quizQuestaskedscore']>1 ? "s" : "")." sur les <span class='font-weight-bold'>".$quizresult['quizMaxscore']."</span> point".($quizresult['quizMaxscore']>1 ? "s" : "")." en jeu.";
        
        if ($quizresult['quizMaxscore'] != 0) {
            $successRate = 100 * round($quizresult['quizQuestaskedscore'] / $quizresult['quizMaxscore'], 2);
            echo "<br>Soit un taux de réussite de <span class='font-weight-bold'>".$successRate." %</span>";
            $successRate = round(20 * $quizresult['quizQuestaskedscore'] / $quizresult['quizMaxscore'], 2);
            echo " qui équivaut à une note de <span class='font-weight-bold'>".$successRate." / 20</span>.";
        }
        else echo "<br>Score non disponible.";
    }
    else {
        if($quizresult['quizMaxnbquest'] !=0){
            $perCentOfResponses = 100 * round($quizresult['quizNbquestasked'] / $quizresult['quizMaxnbquest'], 2);
            echo "<br>Vous avez répondu à <span class='font-weight-bold'>".$quizresult['quizNbquestasked']."</span> question".($quizresult['quizNbquestasked']>1 ? "s" : "")." sur les <span class='font-weight-bold'>".$quizresult['quizMaxnbquest']."</span> du quiz : ";
            echo " soit à <span class='font-weight-bold'>".$perCentOfResponses." %</span> des questions.";
        }
        else echo "<br>Nombre de questions non disponible.";

        if($quizresult['quizMaxquestaskedscore'] != 0 and $quizresult['quizMaxscore'] !=0){
            $successRate = 100 * round($quizresult['quizQuestaskedscore'] / $quizresult['quizMaxquestaskedscore'], 2);
            echo "<br><br>Vos bonnes réponses vous ont permis de récolter <span class='font-weight-bold'>".$quizresult['quizQuestaskedscore']."</span> point".($quizresult['quizQuestaskedscore']>1 ? "s" : "").".";
            echo "<br>Rapporté".($quizresult['quizQuestaskedscore']>1 ? "s" : "")." au".($quizresult['quizMaxquestaskedscore']>1 ? "x" : "")." <span class='font-weight-bold'>".$quizresult['quizMaxquestaskedscore']."</span> point".($quizresult['quizMaxquestaskedscore']>1 ? "s" : "")." mis en jeu par les questions auxquelles vous avez répondu,<br>cela fait un taux de réussite de <span class='font-weight-bold'>".$successRate. "%</span>.";
            $successRate = 100 * round($quizresult['quizQuestaskedscore'] / $quizresult['quizMaxscore'], 2);    
            echo "<br>Rapporté".($quizresult['quizQuestaskedscore']>1 ? "s" : "")." aux <span class='font-weight-bold'>".$quizresult['quizMaxscore']."</span> point".($quizresult['quizMaxscore']>1 ? "s" : "")." mis en jeu par les questions du quiz,<br>cela fait un taux de réussite de <span class='font-weight-bold'>".$successRate." %</span>,";
            $successRate = round(20 * $quizresult['quizQuestaskedscore'] / $quizresult['quizMaxscore'], 2);
            echo " soit une note de <span class='font-weight-bold'>".$successRate." / 20</span>.";
        }
        else echo "<br>Votre note est de <span class='font-weight-bold'>0 / 20</span>.";
    }
}    
if ($failedquestions != null){ /////////////////////////////////////////////////////////////////////
        
    /*  Array structure :
        $this->failedquestions[$i][self::QUESTIONKO] = $row['question_question'];
        $this->failedquestions[$i][self::EXPLANATIONTITLE] = $row['question_explanationtitle'];
        $this->failedquestions[$i][self::EXPLANATION] = $row['question_explanation'];
    */
    //Questions KO explanations :
    ?>
    <br> <br>
    
    <div class="text-center font-weight-bold h5 text-uppercase">Point<?php echo ((!is_null($failedquestions) and count($failedquestions)>1) ? "s" : "") ?> à réviser</div>
    
    <div class="div-of-rows"> 
        <div class="row font-weight-bold responsive-hide">
            <div class="col-12 col-md-3">Question (réponse erronée)</div>
            <div class="col-12 col-md-3">Titre des explications</div>
            <div class="col-12 col-md-6">Explications</div> 
        </div>
        <?php
        //$i  =  0; //ligns counter

        foreach($failedquestions as $question){  ?>
            <div class="row">
                <div class="col-12 col-md-3">
                    <span class="font-weight-bold responsive-show">Question (réponse erronée)<br></span><?php 
                    echo $question[QUESTIONKO] ?>
                </div>
                <div class="col-12 col-md-3">
                    <span class="font-weight-bold responsive-show">Titre de l'explication<br></span><?php 
                    echo $question[EXPLANATIONTITLE] ? $question[EXPLANATIONTITLE] : " - " ?>
                </div>
                <div class="col-12 col-md-6">
                    <span class="font-weight-bold responsive-show">Explication<br></span><?php 
                    echo $question[EXPLANATION] ? $question[EXPLANATION] : "Consultez votre cours, vos notes ou internet." ?>
                </div> 
            </div><?php 
        } ?>
    </div><?php
} ?>
</div>