<?php
//CO>NNEXION au SERVEUR
$servername = 'localhost';
$username = 'root';
$password = '';
$dbname= "db_quiz";
//On établit la connexion
$conn = new mysqli($servername, $username, $password);        
//On vérifie la connexion
if($conn->connect_error){
    die('Erreur : ' .$conn->connect_error);
}
else
{
    //echo "connexion réussie";

    //SELECTION DE LE BASE DE DONNEES
    $conn -> select_db($dbname);
} 
?>