<?php
/*****************************************************************************************
* Screen:       view/div_quiz_userlist.php
* admin/user:   user
* Scope:	    quiz
* JS:           vew/scriptv1.js
* CSS:          vew/style.css
* 
* Feature (maquette): dashboard to consult the list of sessions and quizzes (maq-08), launch and lock a quiz (maq-10), Show grades (maq-08).
* Trigger: Menu "Vos quiz" / index.php/$_REQUEST: "quiz/userlist" / class class_quiz_userlist_controller (class_quiz_userlist_controller.php)
* 
* Major tasks:  o Show sessions and quizzes, the quiz start date (or a link "Commencer" to start the quiz), the grade if the quiz was taken
*               o Check the eligibility of quizzes to be launched
*               o Lock and launch the quiz (confirmation screen) (Link "Commencer" in the column "Démarré le" /form_lock_quiz)
*                   - JS: lockQuiz(…)
*               o Abort quiz launch (Button "Ne pas lancer le quiz")
*                   - JS: $("#bt-lock-quiz").click(  function(){…
*               o Show grades (column Note) with links to the Result screen
*******************************************************************************************/

/* defined in function.php :
const ANAME = 0, AFIRSTNAME = 1, STITLE = 2, SSTARTDATE = 3, SENDDATE = 4;
const SQZOPENINGDATE = 5, SQZCLOSINGDATE = 6, SQZDURATION = 7;
const QZTITLE = 8, QZRID = 9, QZRSTARTDATE = 10, QZRSCORE = 11, QZRMAXSCORE = 12;
const QZID = 13, SSID = 14; //pb avec SID qui serait déjà définie...
*/

global $message;
date_default_timezone_set("Europe/Paris");
?>
<br>
<h2 class="text-center h4 mt-2"><?php echo $title ?></h2>

<div class="row">  
    <div class="col-12 text-center">
            <button class="button button-wide" id="bt-lock-quiz" type="button">Ne pas lancer le quiz</button>
    </div>
</div>

<div class="div-alert text-center"> <?php echo $message ?>
</div>
<br>

<!--window to lock a quiz ://////////////////////////////////////////////////////////////////////-->

<div class="row center mb-2" id="div-form-lock-quiz">
    <div class="col-12 offset-md-4 col-md-4 bg-warning rounded border border-primary" >
        <br>
        <p class="text-center h5">Lancer le quiz</p>  
        <p id="p-quiz-lock" class="text-center h6"></p>
        <p id="p-quiz-duration" class="text-center"></p>
        
        <form class="text-center" id="form_lock_quiz" name="form_lock_quiz" action="index.php" method="POST">
            <input type="hidden" id="lockedquizid" name="lockedquizid">
            <input type="hidden" id="quizduration" name="quizduration">
            <input type="hidden" id="quizsessionid" name="quizsessionid">
            <input type="hidden" name="form_lock_quiz" value="1">
            <div class="text-center pb-2">
                <input type="submit" value="Commencer le quiz" class="input-basic button button-wide">
            </div>
        </form>
    </div>
</div>

<!--quizzes list ://////////////////////////////////////////////////////////////////////-->

<div class="div-of-rows">
    <div class="row font-weight-bold responsive-hide">
        <div class="col-12 col-md-1">Form.</div> <!--Former-->
        <div class="col-12 col-md-2">Session</div> 
        <div class="col-12 col-md-2">du / au</div> <!--From to-->
        <div class="col-12 col-md-2">Quiz</div>
        <div class="col-12 col-md-1">Durée (min)</div> <!--Duration-->
        <div class="col-12 col-md-2">Ouvert du / au</div> <!--Open from to-->
        <div class="col-12 col-md-1">Démarré le</div> <!--Begun the-->
        <div class="col-12 col-md-1">Note</div> <!--Result (mark)-->
    </div>
    <?php
    if ($quiz != null){ // null when the table is empty

        foreach($quiz as $oneQuiz){ ?>
            <div class="row">
                <!--Former name-->
                <div class="col-12 col-md-1">
                    <span class="font-weight-bold responsive-show">Formateur<br></span>
                    <?php echo $oneQuiz[AFIRSTNAME] ?> <?php echo $oneQuiz[ANAME] ?>
                </div>
                <!--Session title-->
                <div class="col-12 col-md-2">
                    <span class="font-weight-bold responsive-show">Session<br></span>
                    <?php echo $oneQuiz[STITLE] ?>
                </div>
                <!--From to-->
                <div class="col-12 col-md-2">
                    
                    du <?php echo $oneQuiz[SSTARTDATE] == 0 ? '<span class="font-italic">non défini</span>' : date('d/m/Y', $oneQuiz[SSTARTDATE]) ?><br>au <?php echo $oneQuiz[SENDDATE]==0? '<span class="font-italic">non défini</span>': date('d/m/Y', $oneQuiz[SENDDATE]) ?>
                </div>
                <!--Quiz title-->
                <div class="col-12 col-md-2">
                    <span class="font-weight-bold responsive-show">Quiz<br></span>
                    <?php echo $oneQuiz[QZTITLE] ?>
                </div>
                <!--Duration-->
                <div class="col-12 col-md-1">
                    <span class="font-weight-bold responsive-show">Durée du quiz<br></span>
                    <?php echo $oneQuiz[SQZDURATION]==0 ? '<span class="font-italic">non défini</span>' : $oneQuiz[SQZDURATION].' min' ?>
                </div>
                <!--Open from to-->
                <div class="col-12 col-md-2">
                    <span class="font-weight-bold responsive-show">Quiz ouvert du/au<br></span>
                    du <?php echo $oneQuiz[SQZOPENINGDATE] ==0? '<span class="font-italic">non défini</span>': date('d/m/y H:i', $oneQuiz[SQZOPENINGDATE]) ?><br>au <?php echo $oneQuiz[SQZCLOSINGDATE]==0? '<span class="font-italic">non défini</span>' :  date('d/m/y H:i', $oneQuiz[SQZCLOSINGDATE]) ?>
                </div>
                <!--start date or link 'Begin' (='Commencer')-->
                <div class="col-12 col-md-1"> <?php 
                    if (!is_null($oneQuiz[QZRSTARTDATE])) { //the startdate in the result table may be null ?>
                        <span class="font-weight-bold responsive-show">Démarré le<br></span><?php
                        echo date('d/m/y H:i', $oneQuiz[QZRSTARTDATE]);

                       //https://www.developpez.net/forums/d984223/php/langage/definir-timezone-fonction-choix-l-utilisateur/
                       //$datetime = new DateTime('now', new DateTimeZone('UTC'));
                       //echo $datetime->format('d/m/Y H:i');
                    }
                    //else if a quiz exists with at least one inline question, and if opening date < time() < closing date
                    else if(strlen($oneQuiz[QZTITLE]) 
                            and $oneQuiz[SQZOPENINGDATE] <= time()
                            and time() <= $oneQuiz[SQZCLOSINGDATE]
                            and $oneQuiz[NBINLINEQUESTIONS] >0) { ?>
                        <span class="font-weight-bold responsive-show">Démarrer<br></span>
                        <a class="text-danger a-supp" onclick="lockQuiz(<?php echo $oneQuiz[SSID] ?>, <?php echo $oneQuiz[QZID] ?>, <?php echo $oneQuiz[SQZDURATION] ?>, '<?php echo $oneQuiz[QZTITLE] ?>')">Commencer</a>      <?php
                    } 
                    else if ($oneQuiz[NBINLINEQUESTIONS] == 0) { ?>
                        <span class="font-weight-bold responsive-show">Anomalie<br></span><?php
                        echo "Pas de question";
                    }
                    else{ ?>
                        <span class="font-weight-bold responsive-show">Démarrer<br></span><?php
                        echo " - ";
                    } ?>
                </div>  
                <!--mark with link to detail, or nothing-->
                <div class="col-12 col-md-1">
                    <span class="font-weight-bold responsive-show">Note<br></span><?php
                    if (!is_null($oneQuiz[QZRID])){  ?>
                        <a class="text-success" href="<?php echo 'index.php?controller=quizresult&action=display&qzrid='.$oneQuiz[QZRID].'&qzid='.$oneQuiz[QZID].'&sid='.$oneQuiz[SSID]?>"><span class="text-right"><?php echo (round($oneQuiz[QZRSCORE] / $oneQuiz[QZRMAXSCORE], 2)*100 ) ?> %</span></a><?php 
                    }
                    else{
                        echo " - ";
                    } ?>
                </div> 
            </div><?php 
        }
    }  ?>
</div>