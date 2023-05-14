<?php
/*****************************************************************************************
* Screen:       view/div_quiz_list.php
* admin/user:   admin
* Scope:	    quiz
* JS:           vew/scriptv1.js
* CSS:          vew/style.css
* 
* Feature (maquette): Consult the list of your quizzes (maq-21), create(maq-21)/delete(maq-22) a quiz.
* Trigger: Menu "Vos quiz" / index.php/$_REQUEST: "quiz/list" / class class_quiz_list_controller (class_quiz_list_controller.php)
* 
* Major tasks:  o Display the data of each quiz as well as its number of sessions and its number of questions; with additional Supp. and Maj links for each quiz
*
*               o Create a quiz (Button "Créer un quiz") :
*                 >>Collect quiz data and its questions
*                   - JS: $("#bt-create-quiz").click( function(){
*                 >>Show questions to add
*                   - DB: class_accounts_list.php
*                 >>Filter the proposed questions on a keyword ("Filtre" drop-down list, on questions)
*                   - JS: selectFilter()
*                 >>Add/Remove question (Ctrl Click on the question)
*                   - JS: select multiple name="addCreateQuizQuestions[]" id="addCreateQuizQuestions"
*                 >>Abort creation (Button "Abandonner la création")
*                 >>Send data (Button "Envoyer" / form_create_quiz)
*                 o Next processing :
*                   >>Save data : index.php/form_create_quiz /modelfunctions.php:
*                       - createQuiz(…), bindQuestions(…)
*
*               o Delete a quiz (Links Supp.  in the list of quizzes)
*                 >>Display the confirmation div with a reminder of the title and the status (draft/inline) of the quiz to be deleted
*                   - JS: deleteQuiz(...)
*                 >>Abort deletion (Button "Abandonner la supp.") 
*                   - JS: $("#bt-delete-quiz").click( function(){…
*                 >>Submit deletion request (Button Envoyer/form_delete_quiz)
*                 o Next processing :
*                   >>Delete a user account and its results (index.php/form_delete_account) :
*                       - index.php/form_delete_account: modelfunctions.php/deleteAccount($deletedaccountlogin, $login)
*                       - DB/CIR: account <- quizresult ; account <- session_user
*                   >>Delete a quiz (index.php/form_delete_quiz):
*                       - index.php/form_delete_quiz: modelfunctions.php/deleteQuiz(quizid)
*******************************************************************************************/

/* Lists :
    $quizList = $this->quiz_list->getQuiz(); 
    $questionList = $this->questions_list->getQuestions();
    $keywordList = $this->questions_list->getKeywords(); //keywords used with the questions 

var_dump($quizList);
var_dump($keywordList);
var_dump($questionList);
*/

global $message;
?>
<br>
<p class="text-center h4 mt-2"><?php echo $title ?></p>

<!--<div class="text-center">
        <a class="button mb-1 button-wide" type="button" href="index.php?controller=question&action=createQuestion">Créer une question</a>
</div>-->

<!-- The 2 buttons : /////////////////////////////////////////////////////////////////////////////////-->
<div class="row">  <div class="col-12">
    <div class="text-center">
        <button class="button button-wide mb-2" id="bt-create-quiz" type="button">Créer un quiz</button>
    </div>
</div></div>

<div class="row">  <div class="col-12">
    <div class="text-center">
        <button class="button button-wide mb-2" id="bt-delete-quiz" type="button">Abandonner la Supp.</button>
    </div>
</div></div>

<!-- The div message : /////////////////////////////////////////////////////////////////////////////////-->

<div class="col-12 div-alert text-center"> <?php echo $message ?></div>

<!--window to create a quiz : ///////////////////////////////////////////////////////////////////////-->

<div class="row mb-2" id="div-form-create-quiz">
    <div class="col-12 bg-warning rounded border border-primary" >
        <br>
        <p class="text-center h5">Créer un quiz</p>

        <form class="pl-2" id="form_create_quiz" name="form_create_quiz" action="index.php" method="POST">
            
            <!--Quiz-->
            <div class="row">
                <div class="col-12 col-md-2 "><label class="label" for="quiz_title">Titre*</label></div>
                <div class="col-12 col-md-10"><input class="input" id="quiz_title" name="quiz_title" type="text" value="" required></div>
            </div>
            <div class="row">
                <div class="col-12 col-md-2"><label class="label" for="quiz_subtitle">Soustitre</label></div>
                <div class="col-12 col-md-10"><input class="input" id="quiz_subtitle" name="quiz_subtitle" type="text" value=""></div>
            </div>
            <div class="row">
                <div class="col-12 col-md-2 "><label id="l-quiz_status" for="quiz_status">Publier</label></div>
                <div class="col-12 col-md-1 text-left"><input id="quiz_status" name="quiz_status" type="checkbox"></div>
            </div>

            <!--Questions-->
            <div class="row mb-2 mt-3">
                <div class="col-12">
                    <span class="font-weight-bold">Associer 0, 1 ou plusieurs questions à ce quiz</span>
                </div>
            </div>
            <!--keywords of the filter-->
            <div class="row">
                <div class="col-12 offset-md-2 col-md-10 pb-2">
                    <p class="d-inline">Filtre sur les questions<br>
                        <select id="select-filter" name="keyword" class="text-center">
                            <?php foreach($keywordList as $keyword) {echo '<option value="'.$keyword[KEYWORDID].'">'.$keyword[KEYWORD].'</option>';} ?>
                        </select>
                    </p>
                </div>   
            </div>   <?php 

            if ($questionList != null){ // null when the table is empty ?>
                <div class="row">
                    <div class="col-12 offset-md-2 col-md-10 pr-5">
                        <p class="d-inline">Questions<br>
                            <select class="w-100" multiple name="addCreateQuizQuestions[]" id="addCreateQuizQuestions"><?php //size="<?php echo count($questionList)
                                foreach($questionList as $question){ ?>
                                    <option class="text-wrap question-list <?php foreach($question[qKEYWORDID] as $keywordid) {echo " ".$keywordid;} ?>" value="<?php echo $question[QUESTIONID] ?>"><?php echo $question[STATUS] ?> - <?php echo $question[WIDGETID] ?> - <?php echo $question[QUESTION] ?></option>    <?php
                                } 
                                //Get the values : https://forum.phpfrance.com/php-debutant/recuperer-valeurs-select-multiple-t4448.html#:~:text=%24keywords%20%3D%20%24_POST%5B'keywords'%5D%3B
                                ?>
                            </select>
                        </p>
                    </div>
                </div>  <?php
            } ?>

            <!--Send the form-->
            <!--<input id="nb-questions-max" type="hidden" name="nb-questions-max" value="<?php //count($questionList) ?>">-->

            <input type="hidden" name="form_create_quiz" value="1">
            <div class="text-center pb-2">
                <input type="submit" value="Envoyer" class="button mt-3">
            </div>
        </form>
    </div>
</div>

<!--window to delete a quiz ://////////////////////////////////////////////////////////////////////-->

<div class="row center mb-2 px-2" id="div-form-delete-quiz">
    <div class="col-12 offset-md-4 col-md-4 bg-warning rounded border border-primary" >
        <br>
        <p class="text-center h5">Supprimer le quiz</p>  
        <p id="p-quiz-supp" class="text-center h6"></p> 
        <p id="p-quiz-status-supp" class="text-center"></p>

        <form class="text-center" id="form_delete_quiz" name="form_delete_quiz" action="index.php" method="POST">
            <input type="hidden" id="deletedquizid" name="deletedquizid">
            <input type="hidden" id="deletedquiz" name="deletedquiz">
            <input type="hidden" name="form_delete_quiz" value="1">
            <div class="text-center pb-2">
                <input type="submit" value="Envoyer" class="input-basic button button-small">
            </div>
        </form>
    </div>
</div>

<!--THE QUIZ LIST : ////////////////////////////////////////////////////////////////////////////////:-->

<div class="row">
    <div class="col-12 col-md-12 div-of-rows">
        <!--Column headings :-->
        <div class="row font-weight-bold  responsive-hide">
            <div class="col-12 col-md-1"></div> <!--supp-->
            <div class="col-12 col-md-1"></div> <!--Maj-->
            <div class="col-12 col-md-1">Statut</div> <!--draft, inline-->
            <div class="col-12 col-md-1">Maj le</div> <!--LMDATE-->
            <div class="col-12 col-md-6">Quiz</div> <!--Title + subtitle-->
            <div class="col-12 col-md-1">Questions</div> <!--nb of Questions-->
            <div class="col-12 col-md-1">Sessions</div> <!--nb of Sessions not closed-->
        </div><?php

        //The list :

        if ($quizList != null){ // null when the table is empty
            $i=0;
            foreach($quizList as $quiz){ ?>

                <div id="<?php echo 'div-quiz-list-'.$i ?>" class="row">
                    <!--link 'delete'-->
                    <div class="col-12 col-md-1">
                        <div class="px-2 px-md-0">
                            <a class="text-danger a-supp" href="#bt-delete-quiz"  onclick="deleteQuiz(<?php echo $quiz[QUIZID] ?>, '<?php echo $quiz[TITLE] ?>', '<?php echo $quiz[STATUS] ?>')">Supp.</a>      
                        </div>
                    </div>
                    <!--link 'update'-->
                    <div class="col-12 col-md-1">
                        <div class="px-2 px-md-0">
                            <a class="text-info a-update" href="<?php echo 'index.php?controller=quiz&action=update&id='.$quiz[QUIZID] ?>">Maj</a>       
                        </div>
                    </div>
                    <!--Status-->
                    <div class="col-12 col-md-1">
                        <span class="px-2 font-weight-bold responsive-show">Statut<br></span>
                        <div class="px-2 px-md-0"><?php echo $quiz[STATUS] ?></div>
                    </div>
                    <!--LMDATE-->
                    <div class="col-12 col-md-1">
                        <span class="px-2 font-weight-bold responsive-show">Mis à jour le<br></span>
                        <div class="px-2 px-md-0"><?php echo date('d/m/y', $quiz[LMDATE]) ?></div>
                    </div>
                    <!--Quiz title-subtitle-->
                    <div class="col-12 col-md-6">
                        <span class="px-2 font-weight-bold responsive-show">Quiz<br></span> 
                        <div class="px-2 px-md-0"><?php echo $quiz[TITLE].($quiz[SUBTITLE] == "" ? "" : " - ".$quiz[SUBTITLE]) ?></div>
                    </div>

                    <!--Number of questions-->
                    <div class="col-12 col-md-1 text-md-center">
                        <span class="px-2 font-weight-bold responsive-show">Nombre de questions<br></span>
                        <div class="px-2 px-md-0"><?php echo $quiz[NBQUESTIONS] ? $quiz[NBQUESTIONS] : "-" ?></div>
                    </div>
                    <!--Number of ongoing sessions (without an end date or with an end date in the future)-->
                    <div class="col-12 col-md-1 text-md-center">
                        <span class="px-2 font-weight-bold responsive-show">Sessions en cours<br></span>
                        <div class="px-2 px-md-0"><?php echo $quiz[NBONGOINGSESSIONS] ? $quiz[NBONGOINGSESSIONS] : "-" ?></div>
                    </div>
                </div><?php 
                $i++;
            }
        } ?>
    </div>
</div>