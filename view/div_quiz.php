<?php
/*****************************************************************************************
* Screen:       view/div_quiz.php
* admin/user:   admin
* Scope:	    quiz
* JS:           vew/scriptv1.js
* CSS:          vew/style.css
* 
* Feature (maquette): screen to modify one quiz (maq-23)
* Trigger: Link "Maj" in div_quiz_list.php / index.php/$_REQUEST: "quiz/update" / class class_quiz_controller (class_quiz_controller.php)
* 
* Major tasks:  o Show data quiz (Links Maj in the list of quizzes)
*                 >>the title of the quiz
*                 >>the sessions to which it is attached with the attachment data (duration and opening dates)
*                   - JS: whiteGreyForClass("sessions-list", true) 
*                 >>quiz data
*                 >>quiz questions with attachment data (weight and order)
*               o Modify quiz data and data carried by the links with questions
*                   - JS: onChangeDivQuizData()
*               o Restore quiz data if asked (Button "Rétablir les données du quiz")
*                   - JS: onclick="up_quizRestor(…)"
*               o Propose the questions to add, except those already associated (Button "Ajouter une question")
*                   - JS:   onclick="addUpdateQuizCreatequestionShowQuestions()
*                           selectQuestionConsistency()
*                           selectFilter()
*                           carnationAlternation()
*               o Filter the proposed questions on a keyword (Button "Filtre sur les questions")
*                   - JS: $("#select-filter").change(function(){selectQuestionConsistency();});
*               o Add a question (Click on one of the proposed questions)
*                   - JS: onchange="addUpdateQuizCreatequestion()"
*               o Remove a question (new or already associated) (click on the cross)
*                   - JS :  >>onclick="up_supUpdateQuizExistingQuestion(…) //question already preasent
*                           >>crea_supUpdateQuizCreateQuestion(…) //new question
*               o Modify the data of a question already present
*                   - JS: updateQuizUpdateQuestion(num) //existing question : onchange
*               o Abort update (Button "Abandonner la Maj")
*               o Restore all original data (Button "Rétablir les données")
*               o Submit changes : quiz data, attached and/or modified questions (data of the links) (Button "Envoyer toutes les modifications de la page") : form_update_quiz
*               o Next processing :
*                   >> Save changes ((insert new questions and update questions already associated))
*                       - index.php/form_update_quiz / modelfunctions.php :
*                           updateQuiz(…)
*                           bindQuizQuestions(…)
*                           unbindQuestions(…)
*                           updateQuizQuestions()
*******************************************************************************************/

global $message;
/*
echo "<br>Sessions :";
var_dump($sessions);
echo "<br>quiz :";
var_dump($quiz);
echo "<br>questions du quiz :";
var_dump($questions);

echo "<br>mots clés de toutes les questions :";
var_dump($keywordList);

echo "<br>toutes les questions :";
var_dump($questionList);
*/
?>
<br>
<p class="text-center h4 mt-2"><?php echo $title ?></p>

<!-- The 2 buttons : /////////////////////////////////////////////////////////////////////////////////-->

<div class="row">
    <div class="col-12">
        <div class="text-center">
            <a class="button button-wide mb-2" id="bt-update-quiz" type="button" href="index.php?controller=quiz&action=list&from=bt-update-quiz">Abandonner la Maj</a>      
            <a class="button button-wide mb-2" id="bt-reset-quiz" type="button" href="index.php?controller=quiz&action=update&id=<?php echo $quiz[QUIZID] ?>&from=bt-reset-quiz">Rétablir les données</a>      
        </div>
    </div>
</div>

<!-- The div message : /////////////////////////////////////////////////////////////////////////////////-->

<div class="col-12 div-alert text-center"> 
    <?php echo $message ?>
</div>

<!--window to update a quiz (prefix 'up' for 'update'):///////////////////////////////////////////////////////////////////////-->

<!--
//class_quiz - div_quiz
    //QUIZID = 0, TITLE= 1, STATUS = 2, LMDATE = 3, SUBTITLE = 4, CRDATE = 5 
    //QUESTIONID = 0, QUESTION = 1, STATUS = 2, LMDATE = 3, WIDGETID = 4, NUMORDER = 5
    const QUESTIONWEIGHT = 6;
-->

<div class="row center mb-2" id="div-form-update-quiz">
    <div class="col-12 bg-warning rounded border border-primary" >
        <br>
        <p id="up_p-quiz-maj" class="text-center h5 font-weight-bold"><?php echo $quiz[TITLE] ?></p>
        <br>
        <!--Sessions :-->
        <div class="row">
            <div class="col-0 col-md-2">
            </div>
            <div class="col-12 col-md-9 ml-md-3 " id="#div-majquiz-sessions">
                <!--Column headings-->
                <div class="row font-weight-bold div-quiz-sessions-titles responsive-hide">
                    <div class="col-12 col-md-5">Session</div>
                    <div class="col-12 col-md-2 text-center">du au</div> <!--draft, inline-->
                    <div class="col-12 col-md-1 ">Quiz</div> 
                    <div class="col-12 col-md-2 text-center">ouvert de</div>
                    <div class="col-12 col-md-2 text-center">à</div>
                </div>
            
                <!--Each Session--> <?php
                if($sessions != null){
                    foreach($sessions as $oneSession) { ?>
                        <div class="row sessions-list">
                            <div class="col-12 col-md-5">
                                <span class="font-weight-bold responsive-show">Session<br></span><?php 
                                echo $oneSession[STITLE].($oneSession[SSUBTITLE] ? " - ".$oneSession[SSUBTITLE] : "" ) ?>
                            </div>
                            <div class="col-12 col-md-2 text-md-center">
                                <span class="font-weight-bold responsive-show">du / au<br></span><?php 
                                echo ($oneSession[SSTARTDATE] ? date('d/m/y', $oneSession[SSTARTDATE]) : "-").($oneSession[SENDDATE] ? "<br>".date('d/m/y', $oneSession[SENDDATE]) : "-") ?>
                            </div>
                            <div class="col-12 col-md-1 text-md-center">
                                <span class="font-weight-bold responsive-show">Durée du quiz<br></span><?php 
                                echo ($oneSession[SQZDURATION] ? $oneSession[SQZDURATION]." min" : "-") ?>
                            </div> 
                            <div class="col-12 col-md-2 text-md-center">
                                <span class="font-weight-bold responsive-show">Ouverture du quiz<br></span><?php 
                                echo ($oneSession[SQZOPENINGDATE] ? date('d/m/y', $oneSession[SQZOPENINGDATE])
                                .'<span class="responsive-hide"><br></span>'
                                ." ".date('h:i', $oneSession[SQZOPENINGDATE]) : "-") ?>
                            </div>
                            <div class="col-12 col-md-2 text-md-center">
                                <span class="font-weight-bold responsive-show">Fermeture du quiz<br></span><?php 
                                echo ($oneSession[SQZCLOSINGDATE] ? date('d/m/y', $oneSession[SQZCLOSINGDATE])
                                .'<span class="responsive-hide"><br></span>'
                                ." ".date('h:i', $oneSession[SQZCLOSINGDATE]) : "-") ?>
                            </div>
                        </div><?php 
                    } 
                } 
                else{ ?>
                    <div class="row sessions-list">
                        <div class="col-12 col-md-5">
                            <span class="font-weight-bold responsive-show">Session<br></span>
                            ---------
                        </div>
                        <div class="col-12 col-md-2 text-md-center">
                            <span class="font-weight-bold responsive-show">du / au<br></span>
                            -
                        </div>
                        <div class="col-12 col-md-1 text-md-center">
                            <span class="font-weight-bold responsive-show">Durée du quiz<br></span>
                            -
                        </div> 
                        <div class="col-12 col-md-2 text-md-center">
                            <span class="font-weight-bold responsive-show">Ouverture du quiz<br></span>
                            -
                        </div>
                        <div class="col-12 col-md-2 text-md-center">
                            <span class="font-weight-bold responsive-show">Fermeture du quiz<br></span>
                            -
                        </div>
                    </div> <?php
                }  ?>
            </div>
        </div><br>

        <form class="px-2" id="form_update_quiz" name="form_update_quiz" action="index.php" method="POST">
            
            <!--Quiz : ///////////////////-->

            <div class="row mb-2 mt-3">
                <div class="col-12 col-md-2">
                    <p><span class="font-weight-bold">QUIZ</span></p>
                </div>
                <div class="col-12 col-md-3">
                    <button class="button button-max" type="button" onclick="up_quizRestor('<?php echo $quiz[STATUS] ?>')">Rétablir les données du quiz</button>
                </div>              
            </div>

            <!--data-->

            <div onchange="onChangeDivQuizData()">
                <div class="row mt-3">
                    <div class="col-12">
                        <div class="row">
                            <div class="col-12 col-md-2">
                                <label class="label" for="up_quiz_title">Titre*</label>
                            </div>
                            <div class="col-12 col-md-10">
                                <input class="input" id="up_quiz_title" name="quiz_title" type="text" value="<?php echo $quiz[TITLE] ?>" required>
                                <input id="up_quiz_title_old" name="quiz_title_old" type="hidden" value="<?php echo $quiz[TITLE] ?>">                    
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-12 col-md-2"><label class="label" for="up_quiz_subtitle">Soustitre</label></div>
                    <div class="col-12 col-md-10"><input class="input" id="up_quiz_subtitle" name="quiz_subtitle" type="text" value="<?php echo $quiz[SUBTITLE] ?>"></div>
                    <input id="quiz_subtitle_old" name="quiz_subtitle_old" type="hidden" value="<?php echo $quiz[SUBTITLE] ?>"> 
                </div>
                <div class="row mt-3">
                    <div class="col-12 col-md-2 "><label id="l-quiz_status" for="up_quiz_status">Publier</label></div>
                    <div class="col-12 col-md-1 text-left"><input id="up_quiz_status" name="quiz_status" type="checkbox" <?php echo ($quiz[STATUS] == 'inline' ? ' checked' : '') ?>></div>
                    <input id="up_quiz_status_old" name="quiz_status_old" type="hidden" value="<?php echo $quiz[STATUS] ?>"> 
                </div>           
            </div> 
            
            <!--Questions : //////////////////-->

            <!--Existing questions-->

            <div class="row mb-2 mt-3" id="div-addUpdateQuizCreatequestion">
                <div class="col-0 col-md-2">
                    <p><span class="font-weight-bold">QUESTIONS DU QUIZ</p>
                </div>
                <div class="col-12 col-md-3">
                    <button class="button button-max" type="button" onclick="addUpdateQuizCreatequestionShowQuestions();">Ajouter une question</button>
                </div>
            </div>

            <!--Existing Questions"--> <?php
            if($questions != null){  
                $i=0;                      
                foreach($questions as $question){  ?>  
                    <div class="row py-2" id="up_question_<?php echo $i ?>">            
                        <div class="col-12 col-md-2">
                            <button class="mr-2 border-0 bg-danger text-white rounded-circle" type="button" onclick="up_supUpdateQuizExistingQuestion('<?php echo $i ?>');">X</button>
                            Question            
                        </div>
                        <div class="col-12 col-md-10">
                            <div class="row" onchange="updateQuizUpdateQuestion(<?php echo $i ?>);">
                                <div class="col-12 col-md-7">
                                    <input disabled="disabled" class="input-question" id="question_question_<?php echo $i ?>" name="question_question_<?php echo $i ?>" type="text" value="<?php echo $question[STATUS]." - ".$question[WIDGETID]." - ".$question[QUESTION] ?>">
                                    <input id="question_id_<?php echo $i ?>" name="question_id_<?php echo $i ?>" type="hidden" value="<?php echo $question[QUESTIONID] ?>">
                                    <input id="up_question_action_<?php echo $i ?>" name="up_question_action_<?php echo $i ?>" type="hidden" value="">
                                </div>

                                <div class="col-12 col-md-2 ml-md-3">
                                    <span class="d-inline-block mr-0">Ordre</span>
                                    <select class="d-inline-block my-1 my-md-0" name="quiz_question_numorder_<?php echo $i ?>" id="quiz_question_numorder_<?php echo $i ?>" value="<?php echo $question[NUMORDER] ?>">
                                        <option value="0" <?php echo $question[NUMORDER] == 0 ? " selected" : "" ?>>0</option>
                                        <option value="1" <?php echo $question[NUMORDER] == 1 ? " selected" : "" ?>>1</option>
                                        <option value="2" <?php echo $question[NUMORDER] == 2 ? " selected" : "" ?>>2</option>
                                        <option value="3" <?php echo $question[NUMORDER] == 3 ? " selected" : "" ?>>3</option>
                                        <option value="4" <?php echo $question[NUMORDER] == 4 ? " selected" : "" ?>>4</option>
                                    </select>
                                </div>
                                
                                <div class="col-12 col-md-2 ml-md-3">
                                    <span class="d-inline-block mr-0">Poids</span>   
                                    <select class="d-inline-block my-1 my-md-0" name="quiz_question_weight_<?php echo $i ?>" id="quiz_question_weight_<?php echo $i ?>" value="<?php echo $question[QUESTIONWEIGHT] ?>">
                                        <option value="1" <?php echo $question[QUESTIONWEIGHT] == 1 ? " selected" : "" ?>>1</option>
                                        <option value="2" <?php echo $question[QUESTIONWEIGHT] == 2 ? " selected" : "" ?>>2</option>
                                        <option value="3" <?php echo $question[QUESTIONWEIGHT] == 3 ? " selected" : "" ?>>3</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div> <?php
                    $i++;
                }
                $nbquestions = $i;
            } 
            else $nbquestions = 0;
            ?>

            <!--The 'select' list of questions, to add one question or more : -->
            
            <div id="div-addUpdateQuizCreatequestionShowQuestions">
                <div class="row">
                    <div class="col-12 offset-md-2 col-md-10 pb-2">
                        <p>Filtre sur les questions<br> <!--p class="d-inline"-->
                            <select id="select-filter" name="keyword" class="text-center">
                                <?php foreach($keywordList as $keyword) {echo '<option value="'.$keyword[KEYWORDID].'">'.$keyword[KEYWORD].'</option>';} ?>
                            </select>
                        </p>
                    </div>   
                </div>   <?php 

                if ($questionList != null){ // null when the table is empty ?>
                    <div class="row">
                        <div class="col-12 offset-md-2 col-md-10">
                            <select name="addCreateQuizQuestions[]" id="addCreateQuizQuestions" onchange="addUpdateQuizCreatequestion()" size="<?php echo min(count($questionList), SIZEQUESTIONS) ?>"><?php 
                                $i=0;
                                $question=[];
                                foreach($questionList as $question){ ?>
                                    <option id="option-select-question_<?php echo $i ?>" class="text-wrap question-list <?php foreach($question[qKEYWORDID] as $keywordid) {echo " ".$keywordid;} ?>" value="<?php echo $question[QUESTIONID]."_" ?>"><?php echo $question[STATUS]." - ".$question[WIDGETID]." - ".$question[QUESTION] ?></option>    <?php
                                    $i++;
                                }
                                $nbquestionsdb = $i; 
                                //Get the values : https://forum.phpfrance.com/php-debutant/recuperer-valeurs-select-multiple-t4448.html#:~:text=%24keywords%20%3D%20%24_POST%5B'keywords'%5D%3B
                                ?>
                            </select>
                        </div>
                    </div>  <?php
                } ?>
            </div>

            <!--update or not-->
            <input type="hidden" id="up_quiz" name="up_quiz" value="0"> <!-- 1 means at least one change in the data quiz-->
             
            <input id="nb-max-questions-new" type="hidden" name="nb-max-questions-new" value="0"><!--number of new questions-->
            <input id="nb-questions_original" type="hidden" name="nb-questions_original" value="<?php echo $nbquestions ?>"><!--number of existing original questions-->
            <input id="nb-questions-db" type="hidden" name="nb-questions-db" value="<?php echo $nbquestionsdb ?>"><!--number of questions in the DB (select)-->

            <!--Quiz ref.-->
            <input type="hidden" id="updatedquizdid" name="updatedquizdid" value="<?php echo $quiz[QUIZID] ?>">
            <input type="hidden" id="updatedquiz" name="updatedquiz" value="<?php echo $quiz[TITLE] ?>">
            
            <!--submit-->
            <input type="hidden" name="form_update_quiz" value="1">
            <div class="text-center pb-2">
                <!--<input type="submit" value="Envoyer toutes les modifications de la page" class="button button-max mt-md-4">-->
                <button type="submit" class="button button-max mt-md-4">Envoyer toutes les modifications de la page</button>
            </div>
        </form>
    </div>
</div>