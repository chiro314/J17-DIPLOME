<?php
/*****************************************************************************************
* Screen:       view/div_keywords_list.php
* admin/user:   admin
* Scope:	    keyword
* JS:           vew/scriptv1.js
* CSS:          vew/style.css
* 
* Feature 1 (maquette): Consult the list of your keywords (maq-27), create(maq-29)/delete(maq-28)/Modify(maq-30) a keyword.
* Trigger: Menu "Vos keywords" / index.php/$_REQUEST: "keyword/list" / class class_keywords_list_controller (class_keywords_list_controller.php)
* 
* Major tasks:  o Show data of each keyword, and the number of questions using it, with Supp. and Maj links for each keyword.
*               o Show questions using a keyword (Click on the number of questions that use the keyword, in column "Quest.")
*                   - JS: onclick="displayKeywordQuestions(…)"
*
*               o Create a keyword (Button "Créer un mot clé") :
*                 >>Collect keyword data
*                   - JS: $("#bt-create-keyword").click(  function(){…
*                 >>Abort creation (Button "Abandonner la création")
*                 >>Send data (form_create_keyword)
*                 o Next processing :
*                 >>Create a keyword (index.php/form_create_keyword):
*                   - model/class_keywords_list.php
*                   - model/controller/class_keywords_list_controller.php
*                       ->checkExists(…)
*                       ->create(…)
*
*               o Delete a keyword (Links Supp. in the list of keywords)
*                 >>Show the confirmation div with reminder of the keyword to be deleted
*                   - JS: deleteKeyword(…)
*                 >>Show the questions div using the keyword to be deleted
*                 >>Abort deletion (Button "Abandonner la supp.") 
*                   - JS: $("#bt-delete-account").click(  function(){…
*                 >>Submit deletion request (Button Envoyer/form_delete_keyword)
*                 o Next processing :
*                 >>Delete a keyword (index.php/form_delete_keyword):
*                   - index.php/form_delete_keyword: modelfunctions.php/deleteKeyword()
*                   - DB/CIR: keyword <- question_keyword
*
*               o Modify a keyword (Links Maj in the list of keywords)
*                 >>Show the keyword to modify and show the div of questions using the keyword
*                   - JS: updateKeyword(…)
*                 >>Abort modification (Button "Abandonner la Maj")
*                   - JS: $("#bt-update-keyword").click( function(){…
*                 >>Send change (button "Envoyer"/form_update_keyword)
*                 o Next processing :
*                 >>Save change (index.php/form_update_keyword)
*                   - model/class_keywords_list.php
*                   - model/controller/class_keywords_list_controller.php
*                       ->updateKeyword(…)                
********************************************************************************************/

/*
const KEYWORDID = 0, KEYWORD = 1;
const COUNTQUESTIONS = 2;
const kqQUESTION = 0, kqKEYWORDID = 1;
*/
global $message;
?>
<br>

<p class="text-center h4 mt-2"><?php echo $title ?></p>

<div class="row">  <div class="col-12">
    <div class="text-center">
        <button class="button button-wide mb-2" id="bt-create-keyword" type="button">Créer un mot clé</button>
    </div>
</div></div>
<div class="row">  <div class="col-12">
    <div class="text-center">
        <button class="button button-wide mb-2" id="bt-update-keyword" type="button">Abandonner la Maj</button>
    </div>
</div></div>
<div class="row">  <div class="col-12">
    <div class="text-center">
        <button class="button button-wide mb-2" id="bt-delete-keyword" type="button">Abandonner la supp.</button>
    </div>
</div></div>

<div class="col-12 div-alert text-center"> <?php echo $message ?></div>

<!--window to create a keyword :-->
<div class="row center mb-2" id="div-form-create-keyword"> <!--id="div-create-keyword"-->
    <div class="col-12 offset-md-4 col-md-4 bg-warning rounded border border-primary" > <!--id="div-form-create-keyword"-->
        <br>
        <p class="text-center h5">Créer le mot clé</p>
        <!--<div class="div-alert"></div>-->
        <form class="text-center" id="form_create_keyword" name="form_create_keyword" action="index.php" method="POST">

            <input class="input-small" id="keyword" name="keyword" type="text" value="" required>
            
            <input type="hidden" name="form_create_keyword" value="1">
            <div class="text-center pb-2">
                <!--<br><button id="bt-giveup-create-keyword" type="button" class="button button-small">Abandonner</button>-->
                <input type="submit" value="Envoyer" class="button button-small">
            </div>
        </form>

    </div>
</div>

<!--window to update a keyword :-->
<div class="row center mb-2" id="div-form-update-keyword">
    <div class="col-12 offset-md-4 col-md-4 bg-warning rounded border border-primary">
        <br>
        <p class="text-center h5">Maj le mot clé</p>
        <p id="p-keyword-maj" class="text-center h6"></p>
        
        <form class="text-center" id="form_update_keyword" name="form_update_keyword" action="index.php" method="POST">
            <input class="input-small" id="newkeyword" name="newkeyword" type="text" value="" required>
            
            <input type="hidden" id="updatedkeywordid" name="updatedkeywordid">
            <input type="hidden" id="updatedkeyword" name="updatedkeyword">

            <input type="hidden" name="form_update_keyword" value="1">
            <div class="text-center pb-2">
                <!--<br><button id="bt-giveup-create-keyword" type="button" class="button button-small">Abandonner</button>-->
                <input type="submit" value="Envoyer" class="button button-small">
            </div>
        </form>
    </div>
</div>

<!--window to delete a keyword :-->
<div class="row center mb-2" id="div-form-delete-keyword">
    <div class="col-12 offset-md-4 col-md-4 bg-warning rounded border border-primary" >
        <br>
        <p class="text-center h5">Supp. le mot clé</p>
        <p id="p-keyword-supp" class="text-center h6"></p>

        <form class="text-center" id="form_delete_keyword" name="form_delete_keyword" action="index.php" method="POST">
            <input type="hidden" id="deletedkeywordid" name="deletedkeywordid">
            <input type="hidden" id="deletedkeyword" name="deletedkeyword">
            <input type="hidden" name="form_delete_keyword" value="1">
            <div class="text-center pb-2">
                <!--<br><button id="bt-giveup-create-keyword" type="button" class="button button-small">Abandonner</button>-->
                <input type="submit" value="Envoyer" class="input-basic button button-small">
            </div>
        </form>
    </div>
</div>

<!--List : Keywords and their questions :-->
<div class="row">
    <!--Keywords :-->
    <div class="col-12 col-md-5 div-of-rows">
        <!--Keyword headings :-->
        <div class="row font-weight-bold responsive-hide">
            <div class="col-12 col-md-2"></div> <!--supp-->
            <div class="col-12 col-md-2"></div> <!--Maj-->
            <div class="col-12 col-md-5">Mot clé</div>
            <div class="col-12 col-md-3 text-center">Quest.</div>
        </div>
        
        <?php
        if ($keywordsList != null){ // null when the table is empty

            //$keywordsList :
            foreach($keywordsList as $keyword){ ?>
                <div class="row keywords-list">
                    <!--link 'delete'-->
                    <div class="col-12 col-md-2">
                        <!--<a class="text-danger" href="<?php //echo 'index.php?controller=keyword&action=delete&id='.$keyword[KEYWORDID]?>">Supp.</a>-->
                        <a class="text-danger a-supp" onclick="deleteKeyword(<?php echo $keyword[KEYWORDID] ?>, '<?php echo $keyword[KEYWORD] ?>', <?php echo $keyword[COUNTQUESTIONS] ?>)">Supp.</a>
                    
                    </div>
                    <!--link 'update'-->
                    <div class="col-12 col-md-2">
                        <!--<a class="text-success" href="<?php //echo 'index.php?controller=keyword&action=update&id='.$keyword[KEYWORDID]?>">Maj</a>-->
                        <a class="text-success a-update" onclick="updateKeyword(<?php echo $keyword[KEYWORDID] ?>, '<?php echo $keyword[KEYWORD] ?>', <?php echo $keyword[COUNTQUESTIONS] ?>)">Maj</a>
                    </div>
                    <!--link 'display questions concerned'-->
                    <div class="col-12 col-md-5">
                        <span class="font-weight-bold responsive-show">Mot clé<br></span><?php 
                        echo $keyword[KEYWORD] ?>
                    </div>
                    <div class="col-12 col-md-3 text-md-center">
                        <span class="font-weight-bold responsive-show">Nombre de questions<br></span><?php 
                        if ($keyword[COUNTQUESTIONS] == null) echo 0;
                        else { ?>
                            <a class="text-success a-countquestions" onclick="displayKeywordQuestions(<?php echo $keyword[KEYWORDID] ?>, '<?php echo $keyword[KEYWORD] ?>', <?php echo $keyword[COUNTQUESTIONS] ?>)"><?php echo $keyword[COUNTQUESTIONS] ?></a><?php                         
                        } ?>
                    </div>
                </div> <?php
            }
        } ?>
    </div>

    <!--Questions list for one keyword :-->
    <div id="div-keyword-questions" class="col-12 col-md-6 ml-md-4 mt-4 mt-md-0"> <!--///div-of-rows-->
        <!--Keyword questions heading :-->
        <div id="div-keyword-questions-heading" class="font-weight-bold">
            Les n questions d'un mot clé (à cliquer)
        </div><!--///div-->
        <?php
        if ($keywordsList != null){
            //$KeywordsQuestionsList :
            foreach($KeywordsQuestionsList as $keywordQuestion){ ?>
            
                <!--JS can display only questions with a class matching a chosen keyword-->
                <div class="row question-list<?php foreach($keywordQuestion[kqKEYWORDID] as $keywordid) {echo " ".$keywordid;} ?>">    
                    <div class="col-12 bg-white">
                        <li><?php echo $keywordQuestion[kqQUESTION] ?></li>
                    </div>
                </div> <?php
            }
        } ?>
    </div>
</div>