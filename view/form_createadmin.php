<?php
/*****************************************************************************************
* Screen:       view/form_createadmin.php
* admin/user:   admin, user, nobody
* Scope:	    account, login
* JS:           vew/scriptv1.js
* CSS:          vew/style.css
* 
* Feature (maquette): Create an administrator account (maq-01)
* Trigger: header.php / button "Créer un compte administrateur"  
* 
* Major tasks:  o Get account data
*               o Get Captcha data (maq-03)
*               o Submit data (Button "Envoyer") : form_createadmin
*
* Next processing   o Check Captcha
*                       - index.php/form_createadmin/functions.php/validerCaptcha()
*                   o Check the uniqueness of the login and create the admin account
*                       - index.php/form_createadmin/ modelfunctions.php : createAccountadmin($name, $firstname, $login, $psw)
*******************************************************************************************/
?>
<br>
<p class="text-center h4 mt-2"><?php echo $title ?></p>

<form id="form_createadmin" name="form_createadmin" action="index.php" method="POST" class="text-center">
    <div class="div-alert"> <?php echo $message ?></div>
    <label class="label-basic" for="name">Nom</label><input class="input-basic" id="name" name="name" type="text" value="" required maxlength="IDENTIFY"><br>
    <label class="label-basic" for="firstname">Prénom</label><input class="input-basic" id="firstname" name="firstname" type="text" value="" required maxlength="IDENTIFY"><br>
    <label class="label-basic" for="login">Login</label><input class="input-basic" id="login" name="login" type="text" value="" required maxlength="SECURITY"><br>
    <label class="label-basic" for="psw">Mot de passe</label><input class="input-basic" id="psw" name="psw" type="password" value="" required maxlength="SECURITY">
    <br><br>
    <div class="row">
        <div class="col-12 offset-md-4 col-md-5 pl-1">
            <!--clé du site-->
            <div class="g-recaptcha" data-sitekey="6Ldv5gAkAAAAAIRTSDJqz2RY-DqswWEkqJBYlTOE"></div>
        </div>
    </div>
    <input type="hidden" name="form_createadmin" value="1">
    <br><input type="submit" value="Envoyer" class="button">
</form>
