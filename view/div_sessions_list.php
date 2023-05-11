<?php
/*****************************************************************************************
* Screen:       view/div_sessions_list.php
* admin/user:   admin
* Scope:	    session
* JS:           vew/scriptv1.js
* CSS:          vew/style.css
* 
* Feature (maquette): Consult the list of your sessions (maq-18-19), create(maq-18)/delete(maq-19) a session.
* Trigger: Menu "Vos sessions" / index.php/$_REQUEST: "session/list" / class class_sessions_list_controller (class_sessions_list_controller.php)
* 
* Major tasks:  o Show data from each session and quizzes, with Supp. and Maj links for each session
*               
*               o Collect session data to create a session (Button "Créer une session"):
*                 >>Collect account data
*                   - JS: $("#bt-create-session").click( function(){...
*                 >>Abort creation (Button "Abandonner la création")
*                 >>Send data Button "Envoyer" /form_create_session)
*                 o Next processing :
*                   >>Save data : index.php/form_create_session /modelfunctions.php/createSession(...)
*
*               o Delete a session (Links Supp. in the list of the sessions)
*                 >>Display the confirmation div with session information reminder and propose the deletion of all accounts belonging only to this session
*                   - JS: onclick="deleteSession(…)
*                 >>Abort deletion (Button "Abandonner la supp.") 
*                   - JS: $("#bt-delete-session").click( function(){...
*                 >>Submit deletion request (Button Envoyer/form_delete_session)
*                 o Next processing :
*                   >>Delete a session: index.php/form_delete_session /modelfunctions.php/deleteSession($deletedsessionid, $login, $suppWhollyOwnedAccounts)
*                       - DB/CIR:   session <- session_quiz
*                                   account <- session_user
*                   >>Delete a session and accounts belonging only to this session: index.php/form_delete_session /modelfunctions.php/deleteSession($deletedsessionid, $login, $suppWhollyOwnedAccounts)
*                       - DB/CIR:   session <- session_quiz
*                                   session <- session_user
*                                   account <- quizresut
*                                   quizresult <- quizresult_questionko
*******************************************************************************************/

global $message;
//var_dump($sessionsList);
?>
<br>
<p class="text-center h4 mt-2"><?php echo $title ?></p>

<!-- The 2 buttons : /////////////////////////////////////////////////////////////////////////////////-->
<div class="row">  <div class="col-12">
    <div class="text-center">
        <button class="button button-wide mb-2" id="bt-create-session" type="button">Créer une session</button>
    </div>
</div></div>

<div class="row">  <div class="col-12">
    <div class="text-center">
        <button class="button button-wide mb-2" id="bt-delete-session" type="button">Abandonner la Supp.</button>
    </div>
</div></div>

<!-- The div message : /////////////////////////////////////////////////////////////////////////////////-->

<div class="col-12 div-alert text-center"> <?php echo $message ?></div>

<!--window to delete a session ://////////////////////////////////////////////////////////////////////-->

<div class="row center mb-2 px-2" id="div-form-delete-session">
    <div class="col-12 offset-md-2 col-md-8 bg-warning rounded border border-primary" >
        <br>
        <p id="p-session-supp-title" class="text-center h5">Supprimer la session</p>   
        <p id="p-session-supp" class="text-center h6"></p>
        <p id="p-session-supp-subtitle" class="text-center h5"></p>   

        <form class="text-center" id="form_delete_session" name="form_delete_session" action="index.php" method="POST">
            <label for="checksuppaccount">Supprimer aussi tous les comptes et résultats n'appartenant qu'à cette session :</label>
            <input type="checkbox" id="checksuppaccount" name="checksuppaccount">
            <input type="hidden" id="deletedsessionid" name="deletedsessionid">
            <input type="hidden" id="deletedsessiontitle" name="deletedsessiontitle">
            <input type="hidden" name="form_delete_session" value="1">
            <div class="text-center pb-2">
                <input type="submit" value="Envoyer" class="input-basic button button-small">
            </div>
        </form>
    </div>
</div>

<!--window to create a session : ///////////////////////////////////////////////////////////////////////-->

<div class="row mb-2" id="div-form-create-session">
    <div class="col-12 bg-warning rounded border border-primary" >
        <br>
        <p class="text-center h5">Créer une session</p>

        <form class="pl-2" id="form_create_session" name="form_create_session" action="index.php" method="POST">
            
            <!--Session-->
            <div class="row">
                <div class="col-12 col-md-2 "><label class="label" for="session_title">Titre*</label></div>
                <div class="col-12 col-md-10"><input class="input" id="session_title" name="session_title" type="text" maxlength="INTITULE" value="" required></div>
            </div>
            <div class="row">    
                <div class="col-12 col-md-2"><label class="label" for="session_subtitle">Sous-titre</label></div>
                <div class="col-12 col-md-10"><input class="input" id="session_subtitle" name="session_subtitle" type="text" maxlength="INTITULE" value=""></div>
            </div>
            <div class="row">    
                <div class="col-12 col-md-2"><label class="label" for="session_startdate">Début</label></div>
                <div class="col-12 col-md-10"><input class="input" id="session_startdate" name="session_startdate" type="date" value=""></div>
            </div>
            <div class="row">    
                <div class="col-12 col-md-2"><label class="label" for="session_enddate">Fin</label></div>
                <div class="col-12 col-md-10"><input class="input" id="session_enddate" name="session_enddate" type="date" value=""></div>
            </div>
            
            <!--Send the form-->
            <input type="hidden" name="form_create_session" value="1">
            <div class="text-center pb-2">
                <input type="submit" value="Envoyer" class="button">
            </div>
        </form>
    </div>
</div>

<!--THE SESSIONS LIST : ////////////////////////////////////////////////////////////////////////////////:-->
<div class="row"><div class="col-12 div-of-rows">
<!--Column headings :-->
<div class="row font-weight-bold responsive-hide">
    <div class="col-12 col-md-1"></div> <!--supp-->
    <div class="col-12 col-md-1"></div> <!--Maj-->
    <div class="col-12 col-md-1 text-center">Début</div> <!--draft, inline-->
    <div class="col-12 col-md-1 text-center">Fin</div>
    <div class="col-12 col-md-1 text-center">Users</div>
    <div class="col-12 col-md-4">Titre</div> <!--radio, checkbox-->
    <div class="col-12 col-md-3">Quiz</div>
</div><?php

//The list :

if ($sessionsList != null){ // null when the table is empty
    $i=0;
    foreach($sessionsList as $session){ ?>

        <div class="row session-list">
            <!--link 'delete'-->
            <div class="col-12 col-md-1">
                <div class="px-2 px-md-0">
                    <a class="text-danger a-supp" onclick="deleteSession(<?php echo $session[SESSIONID] ?>, '<?php echo $session[TITLE] ?>', '<?php echo $session[SUBTITLE] ?>', <?php echo $session[ENDDATE] ?>)">Supp.</a>      
                </div>
            </div>
            <!--link 'update'-->
            <div class="col-12 col-md-1">
                <div class="px-2 px-md-0">
                    <a class="text-info a-update" href="<?php echo 'index.php?controller=session&action=update&id='.$session[SESSIONID] ?>">Maj</a>       
                </div>
            </div>
            <div class="col-12 col-md-1 text-md-center">
                <span class="px-2 font-weight-bold responsive-show">Début<br></span>
                <div class="px-2 px-md-0"><?php echo ($session[SSTARTDATE] == 0 ? "-" : date("d/m/y", $session[SSTARTDATE])) ?></div>
            </div>
            <div class="col-12 col-md-1 text-md-center">
                <span class="px-2 font-weight-bold responsive-show">Fin<br></span>
                <div class="px-2 px-md-0"><?php echo ($session[ENDDATE] == 0 ? "-" : date("d/m/y", $session[ENDDATE])) ?></div>
            </div>
            <div class="col-12 col-md-1 text-md-center">
                <span class="px-2 font-weight-bold responsive-show">Users<br></span>
                <div class="px-2 px-md-0"><?php echo $session[NBUSERS] ?></div>
            </div>
            <div class="col-12 col-md-4">
                <span class="px-2 font-weight-bold responsive-show">Titre<br></span>
                <div class="px-2 px-md-0"><?php echo $session[TITLE].($session[SUBTITLE]=="" ? "" : " - ".$session[SUBTITLE]) ?></div>
            </div>
                <!--Quiz-->
            <div class="col-12 col-md-3">
                <span class="px-2 font-weight-bold responsive-show">Quiz<br></span>
                <?php
                foreach($session[SESSIONQUIZ] as $sessionQuiz){ ?>   
                    <li class="px-2 px-md-0"><?php echo $sessionQuiz[STATUS]." - ".$sessionQuiz[TITLE] ?></li><?php
            } ?> 
            </div>
        </div><?php 
        $i++;
    }
} ?>
</div></div> <!--div-of-rows-->