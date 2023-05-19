<?php
/*****************************************************************************************
* Screen:       view/div_stat_account_session_quiz.php
* admin/user:   admin
* Scope:	    quiz result
* JS:           vew/scriptv1.js
* CSS:          vew/style.css
* 
* Feature (maquette): Consult the quizzes results of one session, one user (account) and their quizzes (maq-14)
* Trigger:  Link to the account results for this session (Sessions and results column of div_accounts_list.php)
*           / index.php/$_REQUEST: "account/reporting" / class class_report_account_controller (class_report_account_controller.php)
* 
* Major tasks:  o Display :
*                 >>the transversal indicators of the session
*                 >>the cross-functional account indicators
*                 >>the cross-functional indicators for each quiz carried out by the account, with the quiz results of the session next to it
*                 >>quizzes not carried out by the account, with their cross-functional indicators.
*
*               o View the definition of each indicator (Button "Explications")
*                   - JS: showDiv(div)
*******************************************************************************************/

/* Lists :
var_dump($account);
var_dump($session);
var_dump($sessionQuizAccountResults);
*/

global $message;
?>
<br>
<p class="text-center h4 mt-2"><?php echo $title ?></p>

<!-- The button : /////////////////////////////////////////////////////////////////////////////////-->
<div class="row">
    <div class="col-12">
        <div class="text-center">
            <a class="button button-wide mb-2" type="button" href="index.php?controller=account&action=list">Retour</a>      
            <button class="button button-wide mb-2" type="button" onclick="showDiv('div-stat-account-explanations')">Explications</button>      
        </div>
    </div>
</div>
<br>
<!-- The div explanations : /////////////////////////////////////////////////////////////////////////////////-->
<div class="row center mb-2" id="div-stat-account-explanations"> 
    <div class="col-12 bg-warning rounded border border-primary" >
    <br>    
    <p class="text-center text-uppercase"><span class="font-weight-bold">Définition des indicateurs</span></p>
        
        <!--SESSION :-->
        <div class="row">
            <div class="col-1 font-weight-bold">SESSION</div>
            <div class="col-2 font-weight-bold">Quiz</div>
            <div class="col-5 ">Nombre de quiz de la session.</div>
            <div class="col-4 ">Pour être réalisable, un quiz doit avoir été ouvert (cf. QUIZ/Date).</div>
        </div><br>
        <div class="row">
            <div class="col-1 font-weight-bold"></div>
            <div class="col-2 font-weight-bold">Comptes</div>
            <div class="col-5">Nombre de comptes (ou élèves) inscrits à la session.</div>
            <div class="col-4 "></div>
        </div><br>
        <div class="row">
            <div class="col-1 font-weight-bold"></div>
            <div class="col-2 font-weight-bold">Participation</div>
            <div class="col-5 ">Le nombre de résultats constatés (tous quiz et comptes confondus) divisé par le nombre maximal de résultats possible (soit le nombre de quiz multiplié par le nombre de comptes).</div>
            <div class="col-4 ">Un compte ne peut réaliser un quiz qu'une seule fois.</div>
        </div><br>
        <div class="row">
            <div class="col-1 font-weight-bold"></div>
            <div class="col-2 font-weight-bold">Note</div>
            <div class="col-5 ">La moyenne des notes (notation en %) obtenues tous quiz et comptes confondus.</div>
            <div class="col-4 "></div>
        </div><br>

        <!--ACCOUNT :-->
        <div class="row">
            <div class="col-1 font-weight-bold">ACCOUNT</div>
            <div class="col-2 font-weight-bold">Quiz</div>
            <div class="col-5 ">Nombre de quiz réalisés par le compte.</div>
            <div class="col-4 ">Un compte ne peut réaliser un quiz qu'une seule fois.</div>
        </div><br>
        <div class="row">
            <div class="col-1 font-weight-bold"></div>
            <div class="col-2 font-weight-bold">Participation</div>
            <div class="col-5 ">Le nombre de quiz réalisés par le compte (cf. ACCOUNT/Quiz), divisé par le nombre de quiz de la session (cf. SESSION/Quiz).</div>
            <div class="col-4 ">Un compte ne peut réaliser un quiz qu'une seule fois.</div>
        </div><br>
        <div class="row">
            <div class="col-1 font-weight-bold"></div>
            <div class="col-2 font-weight-bold">Note</div>
            <div class="col-5 ">La moyenne des notes (notation en %) obtenues par le compte, aux quiz qu'il a réalisés.</div>
            <div class="col-4 ">Un compte ne peut réaliser un quiz qu'une seule fois.</div>
        </div><br>

        <!--QUIZ :-->
        <div class="row">
            <div class="col-1 font-weight-bold">QUIZ</div>
            <div class="col-2 font-weight-bold">Date</div>
            <div class="col-5 ">Date d'ouverture du quiz, à partir de laquelle le quiz pouvait être lancé par un compte.</div>
            <div class="col-4 ">La précision heure:minute est donnée dans l'écran de modification de la session.</div>
        </div><br>
        <div class="row">
            <div class="col-1 font-weight-bold"></div>
            <div class="col-2 font-weight-bold">Durée</div>
            <div class="col-5 ">Durée maximale imposée pour réaliser le quiz, quand celle-ci a été définie (facultatif).</div>
            <div class="col-4 ">Durée en minutes (min).</div>
        </div><br>
        <div class="row">
            <div class="col-1 font-weight-bold"></div>
            <div class="col-2 font-weight-bold">Performance</div>
            <div class="col-5 ">Temps moyen utilisé pour réaliser le quiz (tous comptes confondus) quand une durée a été définie (cf. QUIZ/Durée).</div>
            <div class="col-4 ">Temps en minutes (min).</div>
        </div><br>
        <div class="row">
            <div class="col-1 font-weight-bold"></div>
            <div class="col-2 font-weight-bold">Questions</div>
            <div class="col-5 ">Le nombre de questions que comporte le quiz.</div>
            <div class="col-4 "></div>
        </div><br>
        <div class="row">
            <div class="col-1 font-weight-bold"></div>
            <div class="col-2 font-weight-bold">Traitées</div>
            <div class="col-5 ">Moyenne du % de questions traitées en temps limité, tous comptes confondus.</div>
            <div class="col-4 ">Quand un temps limité a été imposé (cf. QUIZ/Durée).</div>
        </div><br>
        <div class="row">
            <div class="col-1 font-weight-bold"></div>
            <div class="col-2 font-weight-bold">Participation</div>
            <div class="col-5 ">Le nombre de comptes (inscrits à la session) qui ont réalisé le quiz, divisé par le nombre de comptes (cf. SESSION/Comptes).</div>
            <div class="col-4 "></div>
        </div><br>
        <div class="row">
            <div class="col-1 font-weight-bold"></div>
            <div class="col-2 font-weight-bold">Note</div>
            <div class="col-5 ">La moyenne des notes (notation en %) obtenues à ce quiz, par les comptes qui l'ont réalisé.</div>
            <div class="col-4 ">Un compte ne peut réaliser un quiz qu'une seule fois.</div>
        </div><br>

        <!--RESULTAT DU COMPTE A UN QUIZ :-->
        <div class="row">
            <div class="col-1 font-weight-bold">LOGIN</div>
            <div class="col-2 font-weight-bold">Date</div>
            <div class="col-5 ">Date à laquelle le compte a commencé le quiz.</div>
            <div class="col-4 ">Le login du compte est en tête de la ligne de résultat.</div>
        </div><br>
        <div class="row">
            <div class="col-1 font-weight-bold"></div>
            <div class="col-2 font-weight-bold">Durée</div>
            <div class="col-5 ">Pourcentage de temps utilisé par le compte lorsqu'un temps limité a été défini (cf. QUIZ/Durée).</div>
            <div class="col-4 "></div>
        </div><br>
        <div class="row">
            <div class="col-1 font-weight-bold"></div>
            <div class="col-2 font-weight-bold">Performance</div>
            <div class="col-5 ">Temps utilisé par le compte pour réaliser le quiz lorsqu'un temps limité a été défini (cf. QUIZ/Durée).</div>
            <div class="col-4 ">Temps en minutes</div>
        </div><br>
        <div class="row">
            <div class="col-1 font-weight-bold"></div>
            <div class="col-2 font-weight-bold">Questions</div>
            <div class="col-5 ">Le nombre de questions que le compte a traitées lors du quiz.</div>
            <div class="col-4 "></div>
        </div><br>
        <div class="row">
            <div class="col-1 font-weight-bold"></div>
            <div class="col-2 font-weight-bold">Traitées</div>
            <div class="col-5 ">Pourcentage de questions traitées lors du quiz.</div>
            <div class="col-4 ">Quand un temps limité a été imposé (cf. QUIZ/Durée).</div>
        </div><br>
        <div class="row">
            <div class="col-1 font-weight-bold"></div>
            <div class="col-2 font-weight-bold">Participation</div>
            <div class="col-5 ">'oui' : le compte a forcément répondu à ce quiz puisqu'on affiche ses résultats à ce quiz.</div>
            <div class="col-4 ">Les quiz que le compte n'a pas réalisés sont listés en fin de page.</div>
        </div><br>
        <div class="row">
            <div class="col-1 font-weight-bold"></div>
            <div class="col-2 font-weight-bold">Succès</div>
            <div class="col-5 ">Le pourcentage de bonnes réponses données par le compte aux questions qu'il a eu le temps de traiter. </div>
            <div class="col-4 ">La note finale sera inférieure à ce pourcentage si le compte n'a pas eu le temps de traiter toutes les questions (quand un temps limité a été imposé).</div>
        </div><br>
        <div class="row">
            <div class="col-1 font-weight-bold"></div>
            <div class="col-2 font-weight-bold">Note</div>
            <div class="col-5 ">La note réelle (notation en %) obtenue par le compte à ce quiz.</div>
            <div class="col-4 ">Note et Succès tiennent compte de l'éventuelle pondération des questions (note = nombre de points obtenus, divisé par le nombre de points mis en jeu). Si la pondération est de 1 pour toutes les questions, le nombre de points est égale au nombre de questions.</div>
        </div><br>
    </div>
</div>

<!-- The div message : /////////////////////////////////////////////////////////////////////////////////-->

<div class="col-12 div-alert text-center"> <?php echo $message ?></div>


<!--///////////////////////SESSION/////////////////////////////////////////////////////////:-->
<div class="row">
    <div class="col-12 col-md-1">
        <div class="row"><div class="col-12 font-weight-bold"><br></div></div>
        <div class="row"><div class="col-12 font-weight-bold text-uppercase text-wrap">Session</div></div>
    </div> 
    <div class="col-12 col-md-5 text-center text-md-left">
        <div class="row"><div class="col-12 font-weight-bold">Titre</div></div>
        <div class="row"><div class="col-12 bg-white"><?php echo $session[STITLE].($session[SSUBTITLE] ? " (".$session[SSUBTITLE].")" : "" ) ?></div></div>
    </div> 
    <div class="col-12 col-md-1 text-center">
        <div class="row"><div class="col-12 font-weight-bold">Début</div></div>
        <div class="row"><div class="col-12 bg-white"><?php echo $session[SSTARTDATE] ? date('d/m/y',$session[SSTARTDATE]):'-' ?></div></div>
    </div>
    <div class="col-12 col-md-1 text-center">
        <div class="row"><div class="col-12 font-weight-bold">Fin</div></div>
        <div class="row"><div class="col-12 bg-white"><?php echo $session[SENDDATE] ? date('d/m/y',$session[SENDDATE]):'-' ?></div></div>
    </div>
    <div class="col-12 col-md-1 text-center">
        <div class="row"><div class="col-12 font-weight-bold">Quiz</div></div>
        <div class="row"><div class="col-12 bg-white"><?php echo $session[NBQUIZ] ?></div></div>
    </div> 
    <div class="col-12 col-md-1 text-center">
        <div class="row"><div class="col-12 font-weight-bold">Comptes</div></div>
        <div class="row"><div class="col-12 bg-white"><?php echo $session[NBACCOUNTS] ?></div></div>
    </div> 
    <div class="col-12 col-md-1 text-center">
        <div class="row"><div class="col-12 font-weight-bold">Particip°</div></div>
        <div class="row"><div class="col-12 bg-white"><?php echo $session[SPARTICIPRATE]=='' ? "-" : ($session[SPARTICIPRATE]*100)." %" ?></div></div>
    </div> 
    <div class="col-12 col-md-1 text-center">
        <div class="row"><div class="col-12 font-weight-bold">Note</div></div>
        <div class="row"><div class="col-12 bg-white"><?php echo $session[SSUCCESSRATE]=='' ? "-" : ($session[SSUCCESSRATE]*100)." %" ?></div></div>
    </div> 
</div> 
<br>
<!--///////////////////////ACCOUNT/////////////////////////////////////////////////////////:-->
<div class="row">
    <div class="col-12 col-md-1">
        <div class="row"><div class="col-12 font-weight-bold"><br></div></div>
        <div class="row"><div class="col-12 font-weight-bold text-uppercase">Compte</div></div>
    </div> 
    <div class="col-12 col-md-4 text-center text-md-left">
        <div class="row"><div class="col-12 font-weight-bold">Prénom Nom (login) - Société</div></div>
        <div class="row"><div class="col-12 bg-white"><?php echo $account[FIRSTNAME]." ".$account[NAME]." (".$account[LOGIN].")".($account[COMPANY] ? " - ".$account[COMPANY] :"") ?></div></div>
    </div> 
    <div class="col-12 col-md-3 text-center text-md-left">
        <div class="row"><div class="col-12 font-weight-bold">Email</div></div>
        <div class="row"><div class="col-12 bg-white"><?php echo $account[AEMAIL] ?></div></div>
    </div>
    <div class="col-12 col-md-1 text-center">
        <div class="row"><div class="col-12 font-weight-bold">Quiz</div></div>
        <div class="row"><div class="col-12 bg-white"><?php echo $account[ANBQUIZRESULTS] ?></div></div>
    </div> 
    <div class="col-12 col-md-1 text-center">
        <div class="row"><div class="col-12 font-weight-bold"><br></div></div>
        <div class="row"><div class="col-12 bg-white"><br></div></div>
    </div> 
    <div class="col-12 col-md-1 text-center">
        <div class="row"><div class="col-12 font-weight-bold">Particip°</div></div>
        <div class="row"><div class="col-12 bg-white"><?php echo $account[APARTICIPRATE]=='' ? "-" : ($account[APARTICIPRATE]*100)." %" ?></div></div>
    </div> 
    <div class="col-12 col-md-1 text-center">
        <div class="row"><div class="col-12 font-weight-bold">Note</div></div>
        <div class="row"><div class="col-12 bg-white"><?php echo $account[ASUCCESSRATE]=='' ? "-" : ($account[ASUCCESSRATE]*100)." %" ?></div></div>
    </div> 
</div> 
<br>
<!--///////////////////////QUIZ REALISES/////////////////////////////////////////////////////////:-->
<br>
<div class="row"><div class="col-12 h4"><?php echo "Quiz réalisés par ".$account[FIRSTNAME]." ".$account[NAME] ?></div></div>
<?php
if( $sessionQuizAccountResults != null){
    //var_dump($sessionQuizAccountResults);
    foreach ($sessionQuizAccountResults as $SesQuizActResult){ ?>

        <div class="row">
            <div class="col-12 col-md-1">
                <div class="row"><div class="col-12 font-weight-bold"><br></div></div>
                <div class="row"><div class="col-12 font-weight-bold text-uppercase text-info">Quiz</div></div>
                <!--<div class="row"><div class="col-12 font-weight-bold text-uppercase text-danger"><?php //echo $account[LOGIN] ?></div></div>-->
                <div class="row"><div class="col-12 font-weight-bold text-uppercase text-danger">User</div></div>
            </div> 
            <div class="col-12 col-md-2 text-center text-md-left">
                <div class="row"><div class="col-12 font-weight-bold">Nom</div></div>
                <div class="row"><div class="col-12 bg-white text-info"><?php echo $SesQuizActResult[TITLE] ?></div></div>
                <div class="row"><div class="col-12 bg-white text-danger"><?php echo $account[FIRSTNAME]." ".$account[NAME] ?></div></div>
            </div> 
            
            <div class="col-12 col-md-1 text-center">
                <div class="row"><div class="col-12 font-weight-bold text-danger">Supp.</div></div>
                <div class="row"><div class="col-12 bg-white text-info">-</div></div>
                <div class="row"><div class="col-12 bg-white text-danger">
                    <?php if($SesQuizActResult[QUIZID]){ ?>  
                        <input class="resultsToBeDeleted" type="checkbox" value="<?php echo $SesQuizActResult[QUIZID] ?>">    <?php
                    }
                    else echo "-"; ?>
                </div></div>
            </div>

            <div class="col-12 col-md-1 text-center">
                <div class="row"><div class="col-12 font-weight-bold">Date</div></div>
                <div class="row"><div class="col-12 bg-white text-info"><?php echo $SesQuizActResult[SQZOPENINGDATE] ? date('d/m/y',$SesQuizActResult[SQZOPENINGDATE]):'-' ?></div></div>
                <div class="row"><div class="col-12 bg-white text-danger"><?php echo $SesQuizActResult[QRSTARTDATE] ? date('d/m/y',$SesQuizActResult[QRSTARTDATE]):'-' ?></div></div>
            </div>

            <div class="col-12 col-md-1 text-center">
                <div class="row"><div class="col-12 font-weight-bold">Durée</div></div>
                <div class="row"><div class="col-12 bg-white text-info"><?php echo $SesQuizActResult[DURATION] ? $SesQuizActResult[DURATION]." min" : "-" ?></div></div>
                <div class="row"><div class="col-12 bg-white text-danger"><?php echo $SesQuizActResult[SQAQRDURATIONRATE] ? round($SesQuizActResult[SQAQRDURATIONRATE],1)." %" : "-" ?></div></div>
            </div> 
            <div class="col-12 col-md-1 text-center">
                <div class="row"><div class="col-12 font-weight-bold">Perf.</div></div>
                <div class="row"><div class="col-12 bg-white text-info"><?php echo $SesQuizActResult[AVGDURSEC] ? intdiv($SesQuizActResult[AVGDURSEC],60)." min" : "-" ?></div></div>
                <div class="row"><div class="col-12 bg-white text-danger"><?php echo intdiv($SesQuizActResult[SQAQRDURATION],60)." min" ?></div></div>
            </div> 
            <div class="col-12 col-md-1 text-center">
                <div class="row"><div class="col-12 font-weight-bold">Quest<sup>s</sup></div></div>
                <div class="row"><div class="col-12 bg-white text-info"><?php echo $SesQuizActResult[NBQUIZQUESTIONS] ?></div></div>
                <div class="row"><div class="col-12 bg-white text-danger"><?php echo $SesQuizActResult[QRNBQUESTASKED] ?></div></div>
            </div>
            <div class="col-12 col-md-1 text-center">
                <div class="row"><div class="col-12 font-weight-bold">Traitées</div></div>
                <div class="row"><div class="col-12 bg-white text-info"><?php echo $SesQuizActResult[QTREATEDQUESTRATE] ? ($SesQuizActResult[QTREATEDQUESTRATE]*100)." %" : "-" ?></div></div>
                <div class="row"><div class="col-12 bg-white text-danger"><?php echo $SesQuizActResult[SQAQRNBQUESTRATE] ? ($SesQuizActResult[SQAQRNBQUESTRATE]*100)." %" : "-" ?></div></div>
            </div>
            <div class="col-12 col-md-1 text-center">
                <div class="row"><div class="col-12 font-weight-bold">Particip°</div></div>
                <div class="row"><div class="col-12 bg-white text-info"><?php echo $SesQuizActResult[QPARTICIPATIONRATE] ? ($SesQuizActResult[QPARTICIPATIONRATE]*100)." %" : "-" ?></div></div>
                <div class="row"><div class="col-12 bg-white text-danger">oui</div></div>
            </div> 
            <div class="col-12 col-md-1 text-center">
                <div class="row"><div class="col-12 font-weight-bold">Succès</div></div>
                <div class="row"><div class="col-12  text-info"><br></div></div>
                <div class="row"><div class="col-12 bg-white text-danger"><?php echo ($SesQuizActResult[SQAQRQUESTASKEDSCORERATE]*100)." %" ?></div></div>
            </div> 
            <div class="col-12 col-md-1 text-center">
                <div class="row"><div class="col-12 font-weight-bold">Note</div></div>
                <div class="row"><div class="col-12 bg-white text-info"><?php echo ($SesQuizActResult[QSUCCESSRATE]*100)." %" ?></div></div>
                <div class="row"><div class="col-12 bg-white text-danger"><?php echo ($SesQuizActResult[SQAQRSCORERATE]*100)." %" ?></div></div>
            </div> 
        </div> 
        <br><?php
    } 
} ?>
<br>

<!--///////////////////////QUIZ NON REALISES/////////////////////////////////////////////////////////:-->
<br>
<div class="row"><div class="col-12 h4"><?php echo "Quiz non réalisés par ".$account[FIRSTNAME]." ".$account[NAME] ?></div></div>
<?php
if( $sessionQuizWithoutAccountResult != null){
$i=0;//blocked quiz id
//var_dump($sessionQuizWithoutAccountResult);
foreach ($sessionQuizWithoutAccountResult as $SesQuizActResult){ //$SesQuizWITHOUTActResult ?> 
    <br>
    <div class="row">
        <div class="col-12 col-md-1">
            <div class="row"><div class="col-12 font-weight-bold"><br></div></div>
            <div class="row"><div class="col-12 font-weight-bold text-uppercase">Quiz</div></div>
        </div> 
        <div class="col-12 col-md-3 text-center text-md-left">
            <div class="row"><div class="col-12 font-weight-bold">Nom</div></div>
            <div class="row"><div class="col-12 bg-white"><?php echo $SesQuizActResult[TITLE] ?></div></div>
        </div> 
        <div class="col-12 col-md-1 text-center">
            <div class="row"><div class="col-12 font-weight-bold">Date</div></div>
            <div class="row"><div class="col-12 bg-white"><?php echo $SesQuizActResult[SQZOPENINGDATE] ? date('d/m/y',$SesQuizActResult[SQZOPENINGDATE]):'-' ?></div></div>
        </div>
        <div class="col-12 col-md-1 text-center">
            <div class="row"><div class="col-12 font-weight-bold">Durée</div></div>
            <div class="row"><div class="col-12 bg-white"><?php echo $SesQuizActResult[DURATION] ? $SesQuizActResult[DURATION]." min" : "-" ?></div></div>
        </div> 
        <div class="col-12 col-md-1 text-center">
            <div class="row"><div class="col-12 font-weight-bold">Perf.</div></div>
            <div class="row"><div class="col-12 bg-white"><?php echo $SesQuizActResult[AVGDURSEC] ? intdiv($SesQuizActResult[AVGDURSEC],60)." min" : "-" ?></div></div>
        </div> 
        <div class="col-12 col-md-1 text-center">
            <div class="row"><div class="col-12 font-weight-bold">Quest<sup>s</sup></div></div>
            <div class="row"><div class="col-12 bg-white"><?php echo $SesQuizActResult[NBQUIZQUESTIONS] ?></div></div>
        </div>
        <div class="col-12 col-md-1 text-center">
            <div class="row"><div class="col-12 font-weight-bold">Traitées</div></div>
            <div class="row"><div class="col-12 bg-white"><?php echo $SesQuizActResult[QTREATEDQUESTRATE] ? ($SesQuizActResult[QTREATEDQUESTRATE]*100)." %" : "-" ?></div></div>
        </div>
        <div class="col-12 col-md-1 text-center">
            <div class="row"><div class="col-12 font-weight-bold">Particip°</div></div>
            <div class="row"><div class="col-12 bg-white"><?php echo $SesQuizActResult[QPARTICIPATIONRATE] ? ($SesQuizActResult[QPARTICIPATIONRATE]*100)." %" : "-" ?></div></div>
        </div> 
        <div class="col-12 col-md-1 text-center">
            <div class="row"><div class="col-12 font-weight-bold">Bloqué</div></div>
            <div class="row"><div class="col-12 "><?php
                if($SesQuizActResult[BLOCKED]) { ?>
                    <input class="blockedquiz" type="checkbox" id="<?php echo $i ?>" name="blockedquiz_<?php echo $i ?>" value="<?php echo $SesQuizActResult[QUIZID] ?>" checked><?php
                    $i++;
                }   
                else echo "-"; ?>
            </div></div>
        </div> 
        <div class="col-12 col-md-1 text-center">
            <div class="row"><div class="col-12 font-weight-bold">Note</div></div>
            <div class="row"><div class="col-12 bg-white"><?php echo $SesQuizActResult[QSUCCESSRATE] ? ($SesQuizActResult[QSUCCESSRATE]*100)." %" : "-" ?></div></div>
        </div> 
    </div> <?php
} 
} ?>

<form id="form_update_results" name="form_update_results" action="index.php" method="POST">
    <input id="update_results_session" type="hidden" name="update_results_session" value="<?php echo $session[SESSIONID] ?>">
    <input id="update_results_account" type="hidden" name="update_results_account" value="<?php echo $account[LOGIN] ?>">
    <input id="unblocked_quizzes" type="hidden" name="unblocked_quizzes" value=""> 
    <input id="deleted_results" type="hidden" name="deleted_results" value=""> <!--value = quizzes ids-->
    <input type="hidden" name="form_update_results" value="1">
    <div class="text-center">
        <button class="button button-max mt-md-4" type="button" onclick="btFormUpdateResults()">Supprimer les résultats cochés et/ou débloquer les quiz décochés</button> 
    </div>
</form>   
