<?php
/*****************************************************************************************
* Screen:       view/form_password.php
* admin/user:   admin, user
* Scope:	    account, login
* JS:           vew/scriptv1.js
* CSS:          vew/style.css
* 
* Feature (maquette): Change password (maq-06-07)
* Trigger: header.php / button "Mot de passe"  
* 
* Major tasks:  o Get current login data
*               o Get the new password
*               o Check the new password (double entry)
*               o Get Captcha data (maq-02)
*               o Submit data (Button "Envoyer") : form_password
*
* Next processing   o Check Captcha
*                       - index.php/form_password/functions.php/validerCaptcha()
*                   o Check the existence of the couple (login, psw)
*                       - index.php/form_password/ controller/class_account_controller.php ->checkExists()
*                   o Change the password
*                       - index.php/form_password/ controller/class_account_controller.php ->updatePassword($login, $newpsw)
*******************************************************************************************/
?>
<br>
<p class="text-center h4 mt-2"><?php echo $title ?></p>

<form id="form_password" name="form_password" action="index.php" method="POST" class="text-center">
    <div class="div-alert"> <?php echo $message ?></div>
    <label class="label-basic label-wide" for="login">Login</label><input class="input-basic" id="login" name="login" type="text" value="" required><br>
    <label class="label-basic label-wide" for="psw">Mot de passe actuel</label><input class="input-basic" id="psw" name="psw" type="password" value="" required><br>
    <label class="label-basic label-wide" for="newpsw">Nouveau mot de passe</label><input class="input-basic" id="newpsw" name="newpsw" type="password" value="" required><br>
    <label class="label-basic label-wide" for="confirmpsw">à ressaisir pour vérification</label><input class="input-basic" id="confirmpsw" name="confirmpsw" type="password" value="" required>
    <br><br>
    <div class="row">
        <div class="col-12 offset-md-4 col-md-5 pl-1">
            <!--clé du site-->
            <div class="g-recaptcha" data-sitekey="6LfpDcElAAAAAKPtFW3f12NIfxCRA9xZDwJ3ZntW"></div>
        </div>
    </div>
    <input type="hidden" name="form_password" value="1">
    <br><input type="submit" value="Envoyer" class="button">
</form>
