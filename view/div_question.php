<?php
/*****************************************************************************************
* Screen:       view/div_question.php
* admin/user:   admin
* Scope:	    question
* JS:           vew/scriptv1.js
* CSS:          vew/style.css
* 
* Feature (maquette): screen to modify one question (maq-26)
* Trigger: Link "Maj" in div_questions_list.php / index.php/$_REQUEST: "question/update" / class class_question_controller (class_question_controller.php)
* 
* Major tasks:  o Show non-modifiable data question (Links Maj in the list of accounts):
*                 >>the title of the question,
*                 >>its overall success rate,
*                 >>the quizzes to which it is attached, and the success rate of the question for each of these quizzes
*               o Show the modifiable data : data of the question, its keywords and its answers with their data.
*               o Modify the data of the question and its answers (old or new)
*                   - JS:   >>onchange="onChangeDivQuestionData()" //question data
*                           >>onchange="updateQuestionUpdateAnswer(…)" //existing answers
*               o Restore original question data (Button "Rétablir la question d'origine") 
*                   - JS:   onclick="up_questionRestor(widget, status)"
*               o Restore original question keywords (Button "Rétablir les mots clés d'origine")
*                   - JS:   onclick="up_questionKeywordsRestor(strOriginals)"
*               o Restore original question answers (Button "Rétablir les réponses d'origine")
*                   - JS:   >>onclick="up_questionAnswersRestor()"
*                           >>crea_supUpdateQuestionCreateAnswer(divid)
*               o Add / Remove a keyword (Ctrl click on the keyword in the drop-down list)
*                   - JS:   onclick="up_questionKeywordClickSelect()" //Click on the keyword select
*               o Add an answer (button "Ajouter une réponse")
*                   - JS:   onclick="addUpdateQuestionCreateAnswer()
*               o Remove an answer (Clic on the cross)
*                   - JS:   >>onclick="supCreateQuestionCreateAnswer(…) //new answer
*                           >>onclick="up_supUpdateQuestionCreateAnswer(num) //answer already present
*               o Abort modification (Button "Abandonner la Maj")
*               o Submit changes: question data, answers added, deleted or modified, keywords added or removed
*                   (Button "Envoyer toutes les modifications de la page") : form_update_question
*               o Next processing :
*               >> Save changes (insert new answers and update answers already attached)
*                   - index.php/form_update_question / modelfunctions.php : 
*                       >>updateQuestion(…)
*                       >>up_bindKeywords(…)
*                       >>createAnswers(…)
*                       >>deleteAnswers(…)
*                       >>updateAnswers(…)
*******************************************************************************************/

global $message;
//var_dump($question);
//var_dump($keywordsList);
//var_dump($answers);

?>
<br>
<p class="text-center h4 mt-2"><?php echo $title ?></p>

<!-- The button : /////////////////////////////////////////////////////////////////////////////////-->

<div class="row">
    <div class="col-12">
        <div class="text-center">
            <a class="button button-wide mb-2" type="button" href="index.php?controller=question&action=list&from=bt-update-question">Abandonner la Maj</a> 
        </div>
    </div>
</div>

<!-- The div message : /////////////////////////////////////////////////////////////////////////////////-->

<div class="col-12 div-alert text-center"> 
    <?php echo $message ?>
</div>

<!--window to update a question (prefix 'up' for 'update'):///////////////////////////////////////////////////////////////////////-->

<!--
//class_questions - div_questions :

    private $question;
    //QUESTIONID = 0, QUESTION = 1, STATUS = 2, LMDATE = 3, WIDGETID = 4;
    //GUIDELINE = 5, qEXPLANATIONTITLE = 6, qEXPLANATION = 7;
    const CREATIONDATE = 8;

    private $average_success_rate = ['nbok' => 0, 'nb' => 0];

    private $keywords_list;
    private $all_keywords_list;
    //KEYWORDID = 0, KEYWORD = 1

    private $answers;
    // aANSWER = 0, ANSWEROK = 1, STATUS = 2, LMDATE = 3 
    const aCREATIONDATE = 4, aANSWERID = 5;

    private $quiz;
    const QUIZID = 0, TITLE= 1; // STATUS = 2, LMDATE = 3
    const SUBTITLE = 4, NUMOK = 5, NUM = 6;
-->

<div class="row center mb-2 px-2" id="div-form-update-question">
    <div class="col-12 bg-warning rounded border border-primary" >
        <br>
        <p id="up_p-question-maj" class="text-center h5"><span class="font-weight-bold"><?php echo $question[QUESTION] ?></span></p>
        <br>
        <!--Quiz (information):-->
        <div class="row">

            <!--Question success rate:-->

            <div class="col-0 col-md-2 text-center" id="div-questionaveragesuccessrate">
                
                <?php $_SESSION["questionid"] = $question[QUESTIONID] ?>
                
                <script>
                    let xhr = new XMLHttpRequest();
                    xhr.open('GET', 'send-ajax-questionaveragesuccessrate.php');
                    xhr.onreadystatechange = function () {
                        const DONE = 4; // readyState 4 means the request is done.
                        const OK = 200; // status 200 is a successful return.
                        if (xhr.readyState === DONE) {
                            if (xhr.status === OK) {
                                const myDiv = document.getElementById("div-questionaveragesuccessrate");
                                myDiv.innerHTML = xhr.responseText; 
                            } else {
                                console.log('Error: ' + xhr.status); // An error occurred during the request.
                            }
                        }
                    };
                    xhr.send(null);
                </script>
            </div>

            <!--Question quizzes success rates (for this question):-->

            <div class="col-12 col-md-9 ml-md-3 rounded  border-none" id="div-majquestion-quiz">
                <!--Column headings-->
                <div class="row font-weight-bold responsive-hide">
                    <div class="col-12 col-md-6">Titre du quiz</div>
                    <div class="col-12 col-md-1 text-center">Statut</div> <!--draft, inline-->
                    <div class="col-12 col-md-2">Maj le</div>
                    <div class="col-12 col-md-1 text-center">Succès</div> 
                    <div class="col-12 col-md-1 text-center">Sur</div>
                    <div class="col-12 col-md-1 text-center">%</div>
                </div>

                <script>
                    let xhr2 = new XMLHttpRequest();
                    xhr2.open('GET', 'send-ajax-quizquestionaveragesuccessrate.php');
                    xhr2.onreadystatechange = function () {
                        const DONE = 4; // readyState 4 means the request is done.
                        const OK = 200; // status 200 is a successful return.
                        if (xhr2.readyState === DONE) {
                            if (xhr2.status === OK) {
                                const myDiv = document.getElementById("div-majquestion-quiz");
                                if(xhr2.responseText) myDiv.innerHTML += xhr2.responseText;
                                else {
                                    /*
                                    myDiv.innerHTML+='<div class="row"><div class="col-12 col-md-6">----------</div>';
                                    myDiv.innerHTML+='<div class="col-12 col-md-1 text-center">-</div>';
                                    myDiv.innerHTML+='<div class="col-12 col-md-2">-</div>';
                                    myDiv.innerHTML+='<div class="col-12 col-md-1 text-center">-</div>';
                                    myDiv.innerHTML+='<div class="col-12 col-md-1 text-center">-</div>';
                                    myDiv.innerHTML+='<div class="col-12 col-md-1 text-center">-</div></div>';
                                    */
                                    myDiv.innerHTML+='<div class="row responsive-hide"><div class="col-12 col-md-6">----------</div>'+
                                    '<div class="col-12 col-md-1 text-center">-</div>'+
                                    '<div class="col-12 col-md-2">-</div>'+
                                    '<div class="col-12 col-md-1 text-center">-</div>'+
                                    '<div class="col-12 col-md-1 text-center">-</div>'+
                                    '<div class="col-12 col-md-1 text-center">-</div></div>';
                                }
                            } 
                            else console.log('Error: ' + xhr2.status); // An error occurred during the request.
                        }
                    };
                    xhr2.send(null);
                </script>
            </div>
        </div><br>

        <form id="form_update_question" name="form_update_question" action="index.php" method="POST">
            
            <!--Question : ///////////////////-->
            <div class="row mb-2 mt-3">
                <div class="col-12 col-md-2">
                    <p><span class="font-weight-bold text-uppercase">Question</span></p>
                </div>
                <div class="col-12 col-md-3">   
                    <button class="button button-max" type="button" id="up_question-restor" onclick="up_questionRestor('<?php echo $question[WIDGETID] ?>','<?php echo $question[STATUS] ?>')">Rétablir la question d'origine</button>
                </div>
            </div>
            <!--data-->

            <div onchange="onChangeDivQuestionData()">
                <div class="row mt-3">
                    <div class="col-12" id="div-question-data" >
                        <div class="row">
                            <div class="col-12 col-md-2">
                                <label class="label" for="up_question_question">Question*</label>
                            </div>
                            <div class="col-12 col-md-10">
                                <input class="input" id="up_question_question" name="question_question" type="text" value="<?php echo $question[QUESTION] ?>" required>
                                <input id="up_question_question_old" name="question_question_old" type="hidden" value="<?php echo $question[QUESTION] ?>">                    
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-12 col-md-2"><label class="label" for="up_question_guideline">Instructions</label></div>
                    <div class="col-12 col-md-10"><input class="input" id="up_question_guideline" name="question_guideline" type="text" value="<?php echo $question[GUIDELINE] ?>"></div>
                    <input id="up_question_guideline_old" name="question_guideline_old" type="hidden" value="<?php echo $question[GUIDELINE] ?>"> 
                </div>
                <div class="row mt-3">    
                    <div class="col-12 col-md-2"><label class="label" for="up_question_explanationtitle">Titre des explications</label></div>
                    <div class="col-12 col-md-10"><input class="input" id="up_question_explanationtitle" name="question_explanationtitle" type="text" value="<?php echo $question[qEXPLANATIONTITLE] ?>"></div>
                    <input id="up_question_explanationtitle_old" name="question_explanationtitle_old" type="hidden" value="<?php echo $question[qEXPLANATIONTITLE] ?>"> 
                </div>
                <div class="row mt-3">        
                    <div class="col-12 col-md-2"><label class="label" for="up_question_explanation">Explications</label></div>
                    <div class="col-12 col-md-10"><textarea class="input" id="up_question_explanation" name="question_explanation" placeholder="<?php echo TEXTAREA." caractères maximum" ?>" maxlength="<?php echo TEXTAREA ?>"><?php echo $question[qEXPLANATION] ?></textarea></div>
                    <input id="up_question_explanation_old" name="question_explanation_old" type="hidden" value="<?php echo $question[qEXPLANATION] ?>">
                </div>
                
                <div class="row mt-3">
                    <div class="col-12 col-md-2">
                        <label class="label" for="up_question_idwidget">Widget</label>
                    </div>
                    <div class="col-12 col-md-5 ml-md-1">
                        <select class="select-basic" name="question_idwidget" id="up_question_idwidget-select">
                            <option value="radio" <?php echo ($question[WIDGETID] == 'radio' ? ' selected' : '') ?>>Radio bouton</option>
                            <option value="checkbox" <?php echo ($question[WIDGETID] == 'checkbox' ? ' selected' : '') ?> >Boîte à cocher</option>
                        </select>
                        <input id="question_idwidget_old" name="question_idwidget_old" type="hidden" value="<?php echo $question[WIDGETID] ?>">
                    </div>

                    <div class="col-12 col-md-1"><label id="l-question_status" for="up_question_status">Publier</label></div>
                    <div class="col-12 col-md-1 text-left"><input id="up_question_status" name="question_status" type="checkbox" <?php echo ($question[STATUS] == 'inline' ? ' checked' : '') ?>></div>
                    <input id="question_status_old" name="question_status_old" type="hidden" value="<?php echo $question[STATUS] ?>"> 
                </div>
            </div> 
            <!--Keywords : //////////////////-->
            <?php 
            //test ok: foreach($allKeywordsList as $keyword) echo "<br>".$keyword[KEYWORDID]." - ".array_search($keyword[KEYWORDID], $keywordsList)." - ".(array_search($keyword[KEYWORDID], $keywordsList) ===false ? "" : " selected");
            ?>
            <div class="row mt-4">
                <div class="col-0 col-md-2">
                    <p><span class="font-weight-bold text-uppercase">Mots clés</p>
                </div>
                <div class="col-12 col-md-3 ">
                    <button class="button button-max" type="button" id="up_question-keywords-restor" onclick="up_questionKeywordsRestor('<?php echo $keywordsList ? implode(' ', $keywordsList) : ''; ?>')">Rétablir les mots clés d'origine</button>
                </div>
            </div>
            <div class="row">
                <div class="col-0 col-md-2">
                </div>
                <div class="col-12 col-md-3 ml-md-1">
                    <select class="select-basic" size="<?php echo count($allKeywordsList) ?>" multiple name="addCreateQuestionKeywords[]" id="up_addCreateQuestionKeywords" onclick="up_questionKeywordClickSelect()"><?php
                        if($keywordsList != null){  
                            //for each posible keyword :                      
                            foreach($allKeywordsList as $keyword){   
                                //List the keyword and select it if the keyword id is found in the list of the keywords of the question :
                                ?>
                                <option value="<?php echo $keyword[KEYWORDID] ?>" <?php echo array_search($keyword[KEYWORDID], $keywordsList)===false ? "" : " selected" ?>><?php echo $keyword[KEYWORD] ?></option><?php 
                            } ?>
                            <input id="question_status_old" name="addCreateQuestionKeywords_old" type="hidden" value="<?php echo implode(',',$keywordsList) ?>"><?php
                        }
                        else {
                            foreach($allKeywordsList as $keyword){  ?>
                                <option value="<?php echo $keyword[KEYWORDID] ?>"><?php echo $keyword[KEYWORD] ?></option><?php 
                            } ?>
                            <input id="question_status_old" name="addCreateQuestionKeywords_old" type="hidden" value=""><?php
                        }
                        //Get the values : https://forum.phpfrance.com/php-debutant/recuperer-valeurs-select-multiple-t4448.html#:~:text=%24keywords%20%3D%20%24_POST%5B'keywords'%5D%3B
                        ?>
                    </select>  
                </div>   
            </div>

            <!--Answers : //////////////////-->

            <!--Created answers-->
            <!--Button "Ajouter une Réponse"-->
            <div class="row mb-2 mt-3" id="div-addUpdateQuestionCreateAnswer">
                <div class="col-0 col-md-2">
                    <p><span class="font-weight-bold text-uppercase">Réponses</p>
                </div>
                <div class="col-12 col-md-3">
                    <button class="button button-max" id="button-answer" type="button" onclick="up_questionAnswersRestor()">Rétablir les réponses d'origine</button>
                </div>
                <div class="col-12 col-md-3">
                    <button class="button button-max" type="button" onclick="addUpdateQuestionCreateAnswer();">Ajouter une réponse</button>
                </div>
            </div>

            <!--Existing answers"--> <?php
            if($answers != null){  
                $i=0;                      
                foreach($answers as $answer){  ?>  
                    <div class="row" id="up_answer_<?php echo $i ?>">            
                        <div class="col-12 col-md-2">
                            <button class="mr-1 border-0 bg-danger text-white rounded-circle" type="button" onclick="up_supUpdateQuestionCreateAnswer('<?php echo $i ?>');">X</button>
                            Réponse</label>             
                        </div>
                        <div class="col-12 col-md-10">
                            <div class="row" onchange="updateQuestionUpdateAnswer(<?php echo $i ?>);">
                                <div class="col-12 col-md-7">
                                    <input class="input-answer" id="answer_answer_<?php echo $i ?>" name="answer_answer_<?php echo $i ?>" type="text" value="<?php echo $answers[$i][aANSWER] ?>">
                                    <input id="answer_answer_<?php echo $i ?>_old" name="answer_answer_<?php echo $i ?>_old" type="hidden" value="<?php echo $answers[$i][aANSWER] ?>">
                                    <input id="answer_id_<?php echo $i ?>" name="answer_id_<?php echo $i ?>" type="hidden" value="<?php echo $answers[$i][aANSWERID] ?>">
                                    <input id="up_answer_action_<?php echo $i ?>" name="up_answer_action_<?php echo $i ?>" type="hidden" value="">
                                
                                </div>
                                <div class="col-12 col-md-3">
                                    <label for="answer_ok_<?php echo $i ?>">Bonne réponse</label>  
                                    <input id="answer_ok_<?php echo $i ?>" name="answer_ok_<?php echo $i ?>" type="checkbox" <?php echo ($answers[$i][aANSWEROK] == '1' ? ' checked' : '') ?>>  <!--onclick="up_questionAnswerAnswerok(<?php /* echo $i */ ?>)"-->
                                    <input id="answer_ok_<?php echo $i ?>_old" name="answer_ok_<?php echo $i ?>_old" type="hidden" value="<?php echo $answers[$i][aANSWEROK] ?>">
                                </div>
                                <div class="col-12 col-md-2">
                                    <label for="answer_status_<?php echo $i ?>">Publier</label>
                                    <input id="answer_status_<?php echo $i ?>" name="answer_status_<?php echo $i ?>" type="checkbox" <?php echo ($answers[$i][STATUS] == 'inline' ? ' checked' : '') ?>>
                                    <input id="answer_status_<?php echo $i ?>_old" name="answer_status_<?php echo $i ?>_old" type="hidden" value="<?php echo $answers[$i][STATUS] ?>">
                                </div>
                            </div>
                        </div>
                    </div> <?php
                    $i++;
                }
                $nbAnswers = $i;
            }
            else { ?>
                <div class="row" id="answer_0_new">            
                    <div class="col-12 col-md-2">
                        <button class="mr-1 border-0 bg-danger text-white rounded-circle" type="button" onclick="crea_supUpdateQuestionCreateAnswer('answer_0_new');">X</button>
                        Réponse              
                    </div>
                    <div class="col-12 col-md-10">
                        <div class="row">
                            <div class="col-12 col-md-7">
                                <input class="input-answer" id="answer_answer_0_new" name="answer_answer_0_new" type="text" value="" required>
                            </div>
                            <div class="col-12 col-md-3">
                                <label for="answer_ok_0_new">Bonne réponse</label>  
                                <input id="answer_ok_0_new" name="answer_ok_0_new" type="checkbox">
                            </div>
                            <div class="col-12 col-md-2">
                                <label for="answer_status_0_new">Publier</label>
                                <input id="answer_status_0_new" name="answer_status_0_new" type="checkbox">
                            </div>
                        </div>
                    </div>
                </div> <?php
                $nbAnswers = 0;
            } 
            ?>

            <!--update or not-->
            <input type="hidden" id="up_question" name="up_question" value="0"> <!-- 1 means at least one change in the data question-->
            <input type="hidden" id="up_question-keywords_click" name="up_question-keywords_click" value="0"><!--click on the select : 0 means no modification-->
            <input type="hidden" id="up_question-keywords" name="up_question-keywords" value=""><!--the new id keywords: 2,5,9 --> 
            
            <input id="nb-max-answers-new" type="hidden" name="nb-max-answers-new" value="<?php echo $nbAnswers ? 0 : 1 ?>"><!--number of new answers (one empty shell is already displayed)-->
            <input id="nb-answers_original" type="hidden" name="nb-answers_original" value="<?php echo $nbAnswers ?>"><!--number of existing original answers-->

            <!--Question ref.-->
            <input type="hidden" id="updatedquestiondid" name="updatedquestiondid" value="<?php echo $question[QUESTIONID] ?>">
            <input type="hidden" id="updatedquestion" name="updatedquestion" value="<?php echo $question[QUESTION] ?>">
            <!--submit-->
            <input type="hidden" name="form_update_question" value="1">
            <div class="text-center pb-2">
                <!--<input type="submit" value="Envoyer toutes les modifications de la page" class="button button-max mt-md-4">-->
                <button type="submit" class="button button-max mt-md-4">Envoyer toutes les modifications de la page</button>
            </div>
        </form>
    </div>
</div>