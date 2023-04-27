<?php

/*
const KEYWORDID = 0, KEYWORD = 1;
const COUNTQUESTIONS = 2;
*/

?>
<br>
<p class="text-center h4 mt-2"><?php echo $title ?></p>

<div class="text-center">
    <!--<a class="button mb-1" type="button" href="index.php?controller=question&action=createQuestion">Créer un mot clé</a>-->
    <button type="button">Créer un mot clé</button>
</div>
<div class="col-12 div-alert text-center"> <?php echo $message ?></div>

<div class="div-of-rows ">
    <div class="row font-weight-bold">
        <div class="col-12 col-md-1"></div> <!--supp-->
        <div class="col-12 col-md-1"></div> <!--Maj-->
        <div class="col-12 col-md-2">Mot clé</div>
        <div class="col-12 col-md-1">Questions</div>
    </div>
    <?php
    if ($keywordsList != null){ // null when the table is empty

        foreach($keywordsList as $keyword){ ?>
            <div class="row keywords-list">
                <!--link 'delete'-->
                <div class="col-12 col-md-1">
                    <a class="text-danger" href="<?php //echo 'index.php?controller=keyword&action=delete&id='.$keyword[KEYWORDID]?>">Supp.</a>
                </div>
                <!--link 'update'-->
                <div class="col-12 col-md-1">
                    <a class="text-success supp-keyword" href="<?php //echo 'index.php?controller=keyword&action=update&id='.$keyword[KEYWORDID]?>">Maj</a>
                </div>
                <!--link 'display questions concerned'-->
                <div class="col-12 col-md-2">
                    <?php echo $keyword[KEYWORD] ?>
                </div>
                <div class="col-12 col-md-1"> <?php 
                    if ($keyword[COUNTQUESTIONS] == null) echo 0;
                    else { ?>
                        <a class="text-success supp-keyword" href="<?php //echo 'index.php?controller=keyword&action=listQuestions&id='.$keyword[KEYWORDID]?>"><?php echo $keyword[COUNTQUESTIONS] ?></a><?php 
                    } ?>
                </div>
            </div> <?php
        }
    } ?>
</div>