<?php
/*****************************************************************************************
* Screen:       view/form_login.php
* admin/user:   admin, user
* Scope:	    account, login
* JS:           vew/scriptv1.js
* CSS:          vew/style.css
* 
* Feature (maquette): Get login and psw (maq-01)
* Trigger: header.php / button "Se connecter"  
* 
* Major tasks:  o Get login data
*               o Get Captcha data (maq-02)
*               o Submit data (Button "Envoyer") : form_login
*
* Next processing   o Check Captcha
*                       - index.php/form_login/functions.php/validerCaptcha()
*                   o Check the existence of the couple (login, psw)
*                       - index.php/form_login/ controller/class_account_controller.php ->checkExists()
*                   o Provide the elements to login and give access to the user or admin menu (maq-04-05)
*                       - header.php : $$_SESSION[], header(...)[], header(...)
*******************************************************************************************/
?>
<br>
<form id="form_login" name="form_login" action="index.php" method="POST" class="text-center">
    <div class="div-alert"> <?php echo $message ?></div>
    <label class="label-basic" for="login">Login</label><input class="input-basic" id="login" name="login" type="text" value="" required><br>
    <label class="label-basic" for="psw">Mot de passe</label><input class="input-basic" id="psw" name="psw" type="password" value="" required>
    <br><br>
    <div class="row">
        <div class="col-12 offset-md-4 col-md-5 pl-1">
            <!--clé du site-->
            <div class="g-recaptcha" data-sitekey="6Ldv5gAkAAAAAIRTSDJqz2RY-DqswWEkqJBYlTOE"></div>
        </div>
    </div>
    <input type="hidden" name="form_login" value="1">
    <br><input type="submit" value="Envoyer" class="button">
</form>
