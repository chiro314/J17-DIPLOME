<?php
/*****************************************************************************************
* Screen:       view/div_questions_list.php
* admin/user:   admin
* Scope:	    question
* JS:           vew/scriptv1.js
* CSS:          vew/style.css
* 
* Feature 1 (maquette): Consult the list of your questions (maq-24), create(maq-25)/delete(maq-24) a question.
* Trigger: Menu "Vos comptes" / index.php/$_REQUEST: "question/list" / class class_questions_list_controller (class_questions_list_controller.php) ->displayAll()
* 
* Major tasks:  o Show data for each question, with Supp. and Maj links for each account
*                   - JS: carnationAlternation();
*               o Filter questions
*                   - JS:   >>function selectFilter() {... 
*                           >>$("#select-filter").change(function(){selectQuestionConsistency(); });
*
*               o Create a question (Button "Créer une question") :
*                 >>Collect question data and its answers
*                   - JS: $("#bt-create-question").click( function(){…
*                 >>Add an answer (Button "Ajouter une réponse")
*                   - JS: onclick="addCreateQuestionCreateAnswer()"
*                 >>Delete an answer (click on the cross)
*                   - JS: onclick="supCreateQuestionCreateAnswer(divid)"
*                 >>Associate 0, 1 or more keywords with this question: 
*                   o display keywords
*                   o Select or deselect a keyword (Ctrl clic on the keyword)
*                       - JS : <select multiple name="addCreateQuestionKeywords[]" id="addCreateQuestionKeywords">
*                 >>Abort creation (Button "Abandonner la création")
*                 >>Submit data (Button Envoyer /form_create_question)
*                 o Next processing :
*                 >>Save data : index.php/form_create_question /modelfunctions.php :
*                   o createQuestion(…)
*                   o createAnswers(…)
*                   o bindKeywords(…)
*
*               o Delete a question (Links Supp. in the list of questions)
*                 >>Display the confirmation div with a reminder of the title, status (draft/inline) and widget (radio/checkbox) of the question to be deleted
*                   - JS: onclick="deleteQuestion(…)
*                 >>Abort deletion (Button "Abandonner la supp.") 
*                   - JS: $("#bt-delete-question").click(  function(){…
*                 >>Submit deletion request (Button Envoyer/form_delete_account)
*                 o Next processing :
*                 >>Delete a question (index.php/form_delete_question) :
*                   - index.php/form_delete_account: modelfunctions.php/deleteQuestion(questionid)
*                   - DB/CIR:   question <- answer
*                               question <- quiz_question
*                               question  <- questionstat
*                               question <- question_keyword
*                               question <- quizresult_questionko
*******************************************************************************************/

global $message;
?>
<br>
<p class="text-center h4 mt-2"><?php echo $title ?></p>

<!-- The 2 buttons : /////////////////////////////////////////////////////////////////////////////////-->
<div class="row">
    <div class="col-12">
        <div class="text-center">
            <button class="button button-wide mb-2" id="bt-create-question" type="button">Créer une question</button>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="text-center">
            <button class="button button-wide mb-2" id="bt-delete-question" type="button">Abandonner la Supp.</button>
        </div>
    </div>
</div>

<!-- The div message : /////////////////////////////////////////////////////////////////////////////////-->

<div class="col-12 div-alert text-center"> <?php echo $message ?></div>

<!--window to delete a question ://////////////////////////////////////////////////////////////////////-->

<div class="row center mb-2" id="div-form-delete-question">
    <div class="col-12 offset-md-4 col-md-4 bg-warning rounded border border-primary" >
        <br>
        <p class="text-center h5">Supprimer la question</p>   
        <p id="p-question-supp" class="text-center h6"></p>
        <p id="p-question-status-supp" class="text-center"></p>
        
        <form class="text-center" id="form_delete_question" name="form_delete_question" action="index.php" method="POST">
            <input type="hidden" id="deletedquestionid" name="deletedquestionid">
            <input type="hidden" id="deletedquestion" name="deletedquestion">
            <input type="hidden" name="form_delete_question" value="1">
            <div class="text-center pb-2">
                <input type="submit" value="Envoyer" class="input-basic button button-small">
            </div>
        </form>
    </div>
</div>

<!--window to create a question : ///////////////////////////////////////////////////////////////////////-->

<div class="row mb-2" id="div-form-create-question">
    <div class="col-12 bg-warning rounded border border-primary" >
        <br>
        <p class="text-center h5">Créer la question</p>

        <form  id="form_create_question" name="form_create_question" action="index.php" method="POST">
            
            <!--Question-->
            <div class="row">
                <div class="col-12 col-md-2 ">
                    <label class="label font-weight-bold" for="question_question">Question*</label>
                </div>
                <div class="col-12 col-md-10">
                    <input class="input" id="question_question" name="question_question" type="text" value="" required>
                </div>
            </div>
            
            <div class="row">
                <div class="col-12 col-md-2"><label class="label" for="question_guideline">Instructions</label></div>
                <div class="col-12 col-md-10"><input class="input" id="question_guideline" name="question_guideline" type="text" value=""></div>
            </div>
            <div class="row">    
                <div class="col-12 col-md-2"><label class="label" for="question_explanationtitle">Titre des explications</label></div>
                <div class="col-12 col-md-10"><input class="input" id="question_explanationtitle" name="question_explanationtitle" type="text" value=""></div>
            </div>
            <div class="row">        
                <div class="col-12 col-md-2"><label class="label" for="question_explanation">Explications</label></div>
                <div class="col-12 col-md-10"><textarea class="input" id="question_explanation" name="question_explanation" placeholder="<?php echo TEXTAREA." caractères maximum" ?>" maxlength="<?php echo TEXTAREA ?>"></textarea></div>
            </div>
            <div class="row">
                <div class="col-12 col-md-2"><label class="label" for="question_idwidget">Widget*</label></div>
                <div class="col-12 col-md-5 ml-md-1">
                    <select class="select-small" name="question_idwidget" id="question_idwidget-select" required>
                        <option value="">--Choisir le widget--</option>
                        <option value="radio">Radio bouton</option>
                        <option value="checkbox">Boîte à cocher</option>
                    </select>
                </div>
                <div class="col-12 col-md-1 "><label id="l-question_status" for="question_status">Publier</label></div>
                <div class="col-12 col-md-1 text-left"><input id="question_status" name="question_status" type="checkbox"></div>
            </div>

            <!--Answers-->
            <div class="row mb-2 mt-3" id="div-addCreateQuestionCreateAnswer">

                <div class="col-12 col-md-2 font-weight-bold">Réponses</div>

                <div class="col-12 mb-2 mt-2 col-md-10">
                    <button type="button" onclick="addCreateQuestionCreateAnswer();"><span class="font-weight-bold">Ajouter une Réponse</span></button>
                </div>
            </div>

            <div class="row" id="answer_0">            
                <div class="col-12 col-md-2">
                    <div class="row">
                        <div class="col-12 col-md-3">
                            <button class="border-0 bg-danger text-white rounded-circle" type="button" onclick="supCreateQuestionCreateAnswer('answer_0');">X</button>
                        </div>
                        <div class="col-12 col-md-9">
                            <label class="label" for="answer_answer_0">Réponse</label>
                        </div>
                    </div>               
                </div>
                <div class="col-12 col-md-10">
                    <div class="row">
                        <div class="col-12 col-md-7">
                            <input class="input-answer" id="answer_answer_0" name="answer_answer_0" type="text" value="" required>
                        </div>
                        <div class="col-12 col-md-2">
                            <label for="answer_ok_0">Bonne réponse</label>
                        </div>
                        <div class="col-12 col-md-1">   
                            <input id="answer_ok_0" name="answer_ok_0" type="checkbox">
                        </div>
                        <div class="col-12 col-md-1">
                            <label for="answer_status_0">Publier</label>
                        </div>
                        <div class="col-12 col-md-1">
                            <input id="answer_status_0" name="answer_status_0" type="checkbox">
                        </div>
                    </div>
                </div>
            </div>
            <!--Keywords-->
            <?php 
            if ($keywordList != null){ // null when the table is empty ?>
                
                <div class="row mb-2 mt-3">
                    <div class="col-12 col-md-2"></div>

                    <div class="col-12 col-md-10"><span class="font-weight-bold">Associer 0, 1 ou plusieurs mots clés à la question</span></div>
                </div>
            
                <div class="row">
                    <div class="col-12 col-md-2 font-weight-bold">Mots clés</div>

                    <div class="col-12 col-md-5 ">
                        <select class="select-basic" size="<?php echo count($keywordList) ?>" multiple name="addCreateQuestionKeywords[]" id="addCreateQuestionKeywords"><?php
                            foreach($keywordList as $keyword){ ?>
                                <option value="<?php echo $keyword[KEYWORDID] ?>"><?php echo $keyword[KEYWORD] ?></option><?php    
                            } 
                            //Get the values : https://forum.phpfrance.com/php-debutant/recuperer-valeurs-select-multiple-t4448.html#:~:text=%24keywords%20%3D%20%24_POST%5B'keywords'%5D%3B
                            ?>
                        </select>
                    </div>
                </div>   <?php
            } ?>
            <!--Send the form-->
            <input id="nb-responses-max" type="hidden" name="nb-responses-max" value="1"><!--new answers (one empty shell already displayed)-->
            <input id="nb-responses-up" type="hidden" name="nb-responses-up" value=""><!--existing answers (already displayed)-->

            <input type="hidden" name="form_create_question" value="1">
            <div class="text-center pb-3">
                <!--<br><button id="bt-giveup-create-keyword" type="button" class="button button-small">Abandonner</button>-->
                <input type="submit" value="Envoyer" class="button mt-3">
            </div>
        </form>

    </div>
</div>

<!--THE QUESTIONS LIST : ////////////////////////////////////////////////////////////////////////////////:-->

<div class="text-center">
        <p class="d-inline">Filtre sur les questions<br>
            <select id="select-filter" name="keyword" class="text-center">
                <?php foreach($keywordsList as $keyword) {echo '<option value="'.$keyword[KEYWORDID].'">'.$keyword[KEYWORD].'</option>';} ?>
            </select>
        </p>
</div>

<!--Column headings :-->
<div class="row font-weight-bold responsive-hide">
    <div class="col-12 col-md-1"></div> <!--supp-->
    <div class="col-12 col-md-1"></div> <!--Maj-->
    <div class="col-12 col-md-1">Statut</div> <!--draft, inline-->
    <div class="col-12 col-md-1">Maj le</div>
    <div class="col-12 col-md-1">Widget</div> <!--radio, checkbox-->
    <div class="col-12 col-md-7">Question</div> 
</div><?php

//The list :

if ($questionsList != null){ // null when the table is empty
    $i=0;
    foreach($questionsList as $question){ ?>
        <!--JS can display only rows with class matching a chosen keyword-->
        <div id="<?php echo 'div-question-list-'.$i ?>" class="row question-list<?php foreach($question[qKEYWORDID] as $keywordid) {echo " ".$keywordid;} ?>">
            <!--link 'delete'-->
            <div class="col-12 col-md-1">
                <a class="text-danger a-supp" onclick="deleteQuestion(<?php echo $question[QUESTIONID] ?>, '<?php echo $question[QUESTION] ?>', '<?php echo $question[STATUS] ?>', '<?php echo $question[WIDGETID] ?>')">Supp.</a>      
            </div>
            <!--link 'update'-->
            <div class="col-12 col-md-1">
                <a class="text-info a-update" href="<?php echo 'index.php?controller=question&action=update&id='.$question[QUESTIONID] ?>">Maj</a>       
            </div>
            <!--Status-->
            <div class="col-12 col-md-1">
                <span class="font-weight-bold responsive-show">Statut<br></span><?php 
                echo $question[STATUS] ?>
            </div>
            <!--Session title-->
            <div class="col-12 col-md-1">
                <span class="font-weight-bold responsive-show">Maj le<br></span><?php     
                echo date('d/m/y', $question[LMDATE]) ?>
            </div>
            <!--From to-->
            <div class="col-12 col-md-1">
                <span class="font-weight-bold responsive-show">Widget<br></span><?php 
                echo $question[WIDGETID] ?>
            </div>
            <!--Quiz title-->
            <div class="col-12 col-md-7">
                <span class="font-weight-bold responsive-show">Question<br></span><?php 
                echo $question[QUESTION] ?>
            </div>
            <!--Duration-->
        </div><?php 
        $i++;
    }
} ?>