<?php //header.php is required by index.php only

session_start();
$login = "";
$profile = ""; //(admin, user)
$firstname = ""; 
$loggedin = false;
$hello="Bienvenue, connectez-vous !";
$helloFooter="Bienvenue, connectez-vous !";

if(isset($_SESSION["login"])){
    $login = $_SESSION["login"];
    $profile = $_SESSION["profile"]; //(admin, user)
    $firstname = $_SESSION["firstname"];
    $loggedin = true;
    if($profile == "admin"){
        $hello = "Bienvenue ".$firstname." (".$login."), bonne intendance !";
        $helloFooter = "Quiztiti est petit mais il est gratis";
    }
    else { //$profile == "user"
        $hello = "Bienvenue ".$firstname." (".$login."), bon quiz !";
        $helloFooter = "Quiztiti";
    } 
}
if(isset($_REQUEST["msghdr"])){
    $messageHeader=$_REQUEST["msghdr"];
}
else $messageHeader="";

if(isset($_SESSION["questionid"])){
    unset($_SESSION["questionid"]);
}

//functions :
require "functions.php";
require "model/modelfunctions.php";
?>
<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title>DIPLOME</title>
    <meta content="width=device-width, initial-scale=1" name="viewport"/> <!--Responsive-->
    <link rel="stylesheet" href="view/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link href='https://fonts.googleapis.com/css?family=Arvo' rel='stylesheet' type='text/css'>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>
<body>
<div id="container">
    <header>
        <div id="div-h1">
            <h1 id="h1-title" class="text-center py-2">Quiztiti</h1>
        </div>
        <div id="div-hello"><p class="text-center"><?php echo $hello ?></p></div>
        <div id="div-menu" class="text-center">
            <?php if($loggedin){ 
                if ($profile == "user"){ ?>
                    <a class="button" type="button" href="index.php?controller=account&action=disconnection">Quitter Quiztiti</a>
                    <a class="button" type="button" href="index.php?controller=account&action=password">Mot de passe</a>
                    <a class="button" type="button" href="index.php?controller=quiz&action=userList">Vos quiz</a> <!--Quiz list for 'user'-->                   
                    <button class="button" type="button" onclick="showDiv('div-help-user')"><a class="text-white text-decoration-none" href="#bt-leave-help-user1">Aide</a></button>
                <?php }
                else{ // "admin" ?> 
                    <a class="button" type="button" href="index.php?controller=account&action=disconnection">Quitter Quiztiti</a>
                    <a class="button" type="button" href="index.php?controller=account&action=password">Mot de passe</a>
                    <a class="button" type="button" href="index.php?controller=account&action=list">Vos comptes</a>
                    <a class="button" type="button" href="index.php?controller=session&action=list">Vos sessions</a>
                    <a class="button" type="button" href="index.php?controller=quiz&action=list">Vos quiz</a>
                    <a class="button" type="button" href="index.php?controller=question&action=list">Vos questions</a>
                    <a class="button" type="button" href="index.php?controller=keyword&action=list">Vos mots clés</a>
                    <button class="button" type="button" onclick="showDiv('div-help-admin')"><a class="text-white text-decoration-none" href="#bt-leave-help-admin1">Aide</a></button>
                <?php }
            }
            else { // $loggedin == false ?>
                <br>
                <div class="px-2">
                    <p class="h4 h4-responsive">Utilisez le login fourni par votre administrateur, pour retrouver vos résultats ou démarrer un quiz qui est ouvert.</p>
                    <p class="h4 h4-responsive">Ou bien connectez-vous en tant qu'administrateur pour créer vos propres quiz et sessions d'utilisateurs.</p>
                </div>
                <br>
                <a class="button button-superwide" type="button" href="index.php?controller=account&action=createadmin">Créer un compte admin</a>
                <a class="button" type="button" href="index.php?controller=account&action=connection">Se connecter</a>
                <button class="button" type="button" onclick="showDivHelpConnection()"><a class="text-white text-decoration-none" href="#div-hello-footer">Aide</a></button>
                <button class="button" type="button" onclick="showCarouselDemo()" id="bt-demo"><a class="text-white text-decoration-none" href="#div-hello-footer">Démo</a></button>
                <br>
                <p class="text-center h5 mt-2 text-danger"><?php echo $messageHeader ?></p>
                <?php
                // Carousel :
                include 'view/carousel_demo.php'; 
            } ?>
        </div>
    </header>
