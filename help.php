<?php //help.php is required by index.php only
?>
        <!-------------- CONNECTION----------------------------------------------------->

        <div id="div-help-connection" class="row help px-2">
            <div id="bt-leave-help-connection" class="col-12 text-center">
                <button class="button my-3" type="button" onclick="showDiv('div-help-connection')">Quitter l'Aide</button>
            </div>
            <br>
            <div class="col-12 col-md-1">
            </div>
            <div class="col-12 col-md-10">
                Pour <span class="font-weight-bold">répondre à un quiz</span>, vous devez vous connecter avec un login utilisateur.
                <br>
                
                <div class="row">
                    <div class="col-12 col-md-9">
                        Utilisez pour cela le login que vous a fourni l'administrateur et le mot de passe 'quiztiti' (sans majuscule).
                        <br>Il vous sera demandé de changer ce mot de passe, dès votre première connexion.
                    </div>
                    <div class="col-12 col-md-3">
                        <button class="button button-superwide" type="button">Se connecter</button>
                    </div>
                </div>
                <br>
                Pour <span class="font-weight-bold">créer des quiz</span> et des sessions de participants, vous devez vous loguer avec un login administrateur.
                <div class="row">
                    <div class="col-12 col-md-9">
                        Pour créer un compte administrateur, utilisez le bouton suivant :
                    </div>
                    <div class="col-12 col-md-3">
                        <button class="button button-superwide" type="button">Créer un compte administrateur</button>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-12 col-md-9">
                        Puis connectez-vous en utilisant le login et le mot de passe que vous avez créés :
                    </div>
                    <div class="col-12 col-md-3 mb-3">
                        <button class="button button-superwide" type="button">Se connecter</button>
                    </div>
                </div>
            </div>
            
        </div>
        <br><br>

        <!-------------------USER--------------------------------------------------------->
        
        <div id="div-help-user" class="row help px-2">
            <div id="bt-leave-help-user1" class="col-12 text-center my-2">
                <button class="button" type="button" onclick="showDiv('div-help-user')">Quitter l'Aide</button>
            </div>
            <div class="col-12 col-md-1">
            </div>
            <div class="col-12 col-md-10">
                <h3 class="h4">Mot de passe</h3>            
                <div class="row">
                    <div class="col-12 col-md-9">
                        Pour <span class="font-weight-bold">changer de mot de passe</span>, utilisez le bouton suivant :
                    </div>
                    <div class="col-12 col-md-3">
                        <button class="button button-superwide" type="button">Mot de passe</button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-md-9">
                        Il vous sera demandé de saisir votre mot de passe actuel : si vous ne vous en souvenez plus, demandez à l'organisateur de le réinitialiser à "quiztiti".
                    </div>
                </div>
                <br>
                <h3 class="h4">Tableau de bord</h3>
                <div class="row">
                    <div class="col-12 col-md-9">
                        Pour <span class="font-weight-bold">afficher votre tableau de bord</span>, utilisez le bouton suivant :
                    </div>
                    <div class="col-12 col-md-3">
                        <button class="button button-superwide" type="button">Vos quiz</button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-md-9">
                        Vos quiz sont regroupés par sessions.
                    </div>
                </div>
                <br>
                <h3 class="h4">Commencer un quiz</h3>
                <div class="row">                        
                    <div class="col-12 col-md-9">
                        Pour <span class="font-weight-bold">démarrer un quiz</span>, attendez que votre formateur vous donne le signal.
                        <br>Vous aurez la possibilité de lancer le quiz entre les deux dates de la colonne <span class="font-weight-bold">Ouvert du / au</span>, si elles sont renseignées.
                        <br>Si le quiz est en temps limité, sa durée est indiquée en minutes dans la colonne <span class="font-weight-bold">Durée</span>.
                        <br>Pour <span class="font-weight-bold">répondre à un quiz</span> de votre tableau de bord, cliquez sur le lien <span class="text-danger">Commencer</span> qui se trouve à la fin de la ligne du quiz que vous voulez lancer (colonne <span class="font-weight-bold">Démarré le</span>).
                    </div>
                    <div class="col-12 col-md-3">  
                    </div> 
                </div>

                <div class="row">    
                    <div class="col-12 col-md-9">
                        Une fenêtre de confirmation vous proposera, soit de ne pas lancer le quiz :
                    </div>
                    <div class="col-12 col-md-3">  
                        <button class="button button-superwide" type="button">Ne pas lancer le quiz</button>
                    </div>                           
                </div>
                <div class="row">    
                    <div class="col-12 col-md-9">
                        Soit de commencer le quiz (si le quiz est en temps limité, le décompte commence alors) :
                    </div>
                    <div class="col-12 col-md-3">  
                        <button class="button button-superwide" type="button">Commencer le quiz</button>
                    </div>                           
                </div>
                <br>
                <h3 class="h4">Déroulement d'un quiz</h3>
                <div class="row">    
                    <div class="col-12 col-md-9">
                        ATTENTION : l'utilisation de la flèche 'retour arrière' (<-) de votre navigateur, en haut à gauche sur votre écran, revient à ABANDONNER le quiz qui sera bloqué.
                        <br> Vos données seront perdues et vous ne pourrez pas relancer le quiz : contactez l'organisateur.
                    </div>
                    <div class="col-12 col-md-3">  
                    </div>                           
                </div>
                <div class="row">    
                    <div class="col-12 col-md-9">
                        Si le quiz est en temps limité, un avancement affiche sous forme de jauges, le temps écoulé et le nombre de questions traitées.
                        <br>N'hésitez pas à utiliser au maximum le temps qui vous est donné.
                    </div>
                    <div class="col-12 col-md-3">
                    </div>                           
                </div>
                <div class="row">    
                    <div class="col-12 col-md-9">
                        Si cela vous déconcentre, vous pouvez masquer cet avancement au moyen du bouton suivant : 
                    </div>
                    <div class="col-12 col-md-3">
                        <button><a >Masquer l'avancement</a></button><br>
                    </div>                           
                </div>
                <div class="row">    
                    <div class="col-12 col-md-9">
                        Pour afficher de nouveau l'avancement, cliquez sur le bouton suivant : 
                    </div>
                    <div class="col-12 col-md-3 mt-md-2">
                        <button><a >Afficher l'avancement</a></button><br>
                    </div>                           
                </div>
                <br>
                <div class="row">    
                    <div class="col-12 col-md-9">
                        Affichez la première question au moyen du bouton suivant : 
                    </div>
                    <div class="col-12 col-md-3">
                        <button><a >Commencer</a></button>
                    </div>                           
                </div>
                <br>
                <div class="row">    
                    <div class="col-12 col-md-9">
                        Répondez à la question.
                        </div>
                    <div class="col-12 col-md-3">
                    </div>                           
                </div>
                <div class="row">    
                    <div class="col-12 col-md-9">
                        Pour valider votre réponse et afficher la question suivante, cliquez sur le bouton suivant : 
                    </div>
                    <div class="col-12 col-md-3">
                        <button><a >Question suivante (2/10)</a></button>
                    </div>                           
                </div>
                <div class="row">    
                    <div class="col-12 col-md-9">
                        <br>Lorsque la dernière question sera affichée, répondez-y et validez votre réponse en cliquant sur le bouton suivant qui indiquera les instructions suivantes : 
                    </div>
                    <div class="col-12 col-md-3 mt-md-2">
                        <button><a >Répondez à la dernière question ci-dessous puis cliquez ici pour valider</a></button>
                    </div>                           
                </div>
                <br>
                <h3 class="h4">Les deux sortes de questions</h3>
                <div class="row">    
                    <div class="col-12 col-md-9">
                        Une question sous forme de <span class="font-weight-bold">boutons radio</span> admet une et une seule réponse.
                        <br>Il y a donc n réponses possibles avec des boutons radio (n étant le nombre de boutons radio proposés), mais il n'y a qu'une seule bonne réponse.
                        <br><br>Une question sous forme de <span class="font-weight-bold">boîtes à cocher</span> admet 0 à n réponses (n étant le nombre de boîtes à cocher proposées) : vous pouvez ne rien cocher, tout cocher, ou cocher une ou plusieurs cases.
                        <br>Il y a donc 2<sup>n</sup> réponses possibles avec des boîtes à cocher, mais il n'y a qu'une seule bonne réponse.
                        <br><br>Il est donc beaucoup plus difficile de trouver la bonne réponse avec des boîtes à cocher. 
                    </div>
                    <div class="col-12 col-md-3 mt-md-2">
                    </div>                           
                </div>
                <br>
                <h3 class="h4">Consultez votre résultat</h3>
                <div class="row">    
                    <div class="col-12 col-md-9">
                        Le détail de vos résultats est consultable en cliquant dans la colonne <span class="font-weight-bold">Note</span> de votre <span class="font-weight-bold">tableau de bord</span>, sur la note qui figure en %, au bout de la ligne du quiz.
                        <br>Dans la colonne <span class="font-weight-bold">Démarré le</span> figure maintenant la date et l’heure auxquelles vous avez démarré le quiz.
                        <br>Les informations disponibles sont les suivantes :
                        <ul>
                            <li>Le temps que vous avez utilisé (si le temps était limité) par rapport au temps dont vous disposiez</li>
                            <li>Le nombre de questions qui ont été prises en compte pour calculer le résultat</li>
                            <li>Le nombre de points que vous avez obtenus, par rapport au total des points mis en jeu (certaines questions peuvent valoir double ou triple)</li>
                            <li>Votre taux de réussite aux questions que vous avez traitées (en % du nombre de points mis en jeu par ces questions)</li>
                            <li>Votre note en % du nombre total de points mis en jeu (et sa conversion sur 20), y compris par les questions que vous n'avez peut-être pas eu le temps de traiter.</li>
                        </ul>
                    </div>
                    <div class="col-12 col-md-3 mt-md-2">
                    </div>                           
                </div>
                <br>
                <h3 class="h4">Révisez vos points faibles</h3>
                <div class="row">    
                    <div class="col-12 col-md-9">
                        Votre résultat fournit la liste des questions auxquelles vous avez mal répondu.
                        <br>Les questions auxquelles vous n’avez pas eu le temps de répondre ne figurent pas dans cette liste.
                        <br><br>
                        Des explications sont fournies pour vous faciliter ces révisions.    
                    </div>
                    <div class="col-12 col-md-3 mt-md-2">
                    </div>  
                    <br><br>                         
                </div>

            </div>
            <div id="bt-leave-help-user2" class="col-12 text-center my-2">
                <button class="button" type="button" onclick="showDiv('div-help-user')">Quitter l'Aide</button>
            </div>
        </div>
        
        <!---------------ADMIN--------------------------------------------------------->

        <div id="div-help-admin" class="row help px-2 text-justify">
            <div id="bt-leave-help-admin1" class="col-12 text-center my-2">
                <button class="button" type="button" onclick="showDiv('div-help-admin')">Quitter l'Aide</button>
            </div>
            <div class="col-12 col-md-1">
            </div>
            <div class="col-12 col-md-10">
                <div class="row">
                <div class="col-12 col-md-9 bg-light">
                <h3 class="h4">Sommaire</h3>
                <ul>
                    <li><a href="#h3-quiztiti" class="font-weight-bold">Présentation de Quiztiti</a></li>
                    <li><a href="#h3-quiz" class="font-weight-bold">Mise en place et exploitation d’un quiz en 7 étapes</a></li>
                        <ol>
                            <li><a href="#h4-create-keyword">Créez un mot clé de travail</a></li>
                            <li><a href="#h4-create-question">Créez des questions</a></li>
                            <li><a href="#h4-create-quiz">Créez un quiz</a></li>
                            <li><a href="#h4-create-account">Créez les comptes utilisateurs</a></li>
                            <li><a href="#h4-create-session">Créez une session</a></li>
                            <li><a href="#h4-result">Suivez les résultats d’un participant</a></li>
                            <li><a href="#h4-audit">Auditez chaque question</a></li>
                        </ol>
                    <li><a href="#h3-delete" class="font-weight-bold">La gestion des suppressions</a></li>
                        <ul>
                            <li><a href="#h4-delete-result">La vie des résultats, des comptes et des sessions</a></li>
                            <li><a href="#h4-delete-quiz">La vie des quiz</a></li>
                            <li><a href="#h4-delete-question">La vie des questions et des mots clés</a></li> 
                        </ul>   
                </ul>
                </div>
                </div>
                <br>
                <h3 id="h3-quiztiti" class="h4">Présentation de Quiztiti</h3>            
                <div class="row">
                    <div class="col-12 col-md-9">
                        Quiztiti est une application qui permet de construire des quiz avec leurs questions et leurs réponses.
                        <br>Ces quiz peuvent être ensuite proposés à des participants (vos comptes) inscrits à des sessions. 
                        <br>Les participants qui ont répondu aux questions du quiz peuvent consulter leurs résultats et réviser les notions sur lesquelles ils ont achoppé.
                        <br>De son côté, l’organisateur dispose d'indicateurs pour suivre les résultats d'un participant.
                        <br>Le taux de bonnes réponses de chaque question vous permet d’ajuster les quiz et leurs questions.
                    </div>
                    <div class="col-12 col-md-3">
                    </div>
                </div>
                <br>
                <h3 id="h3-quiz" class="h4 mb-3">Mise en place et exploitation d’un quiz en 7 étapes</h3>
                <h4 id="h4-create-keyword" class="h5">1. Créez un mot clé de travail</h4>           
                <div class="row">
                    <div class="col-12 col-md-9">
                        Ce <span class="font-weight-bold">mot clé de travail</span> va vous permettre de qualifier vos questions afin de les retrouver facilement (filtre) lorque vous allez les associer à un quiz. Il pourra être supprimé (ou conservé) une fois le quiz mis en place.
                    </div>
                    <div class="col-12 col-md-3">
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-md-9">
                        Pour <span class="font-weight-bold">créer un mot clé</span>, utilisez ce bouton :
                    </div>
                    <div class="col-12 col-md-3 help-instructions">
                        <button class="button" type="button">Vos mots clés</button>
                        <br>Puis ce bouton pour valider votre action :
                        <br><button class="button" type="button">Envoyer</button>
                    </div>
                </div> 
                <br>          
                <div class="row">
                    <div class="col-12 col-md-9">
                        Un <span class="font-weight-bold">mot clé</span> peut être associé à plusieurs questions, et une question admet plusieurs mots clés.
                        <br>Plus généralement, réfléchissez à l’organisation de vos mots clés pour qu’ils soient pertinents et qu'ils ne se multiplient pas à l'infinie.
                    </div>
                    <div class="col-12 col-md-3">
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-md-9">
                        Quoi qu’il en soit vous pouvez supprimer ou renommer un mot clé à votre guise :
                    </div>
                    <div class="col-12 col-md-3 help-instructions">
                        <button class="button" type="button">Vos mots clés</button>
                        <br>Puis lien <span class="font-weight-bold">Supp.</span> ou <span class="font-weight-bold">Maj</span> de la ligne du mot clé
                        <br>Puis ce bouton pour valider votre action :
                        <br><button class="button" type="button">Envoyer</button>
                    </div>
                </div>
                <br>
                <h4 id="h4-create-question" class="h5">2. Créez des questions</h4>
                <div class="row">
                    <div class="col-12 col-md-9">
                        Créez chaque nouvelle question avec <span class="font-weight-bold">ses réponses</span> et les <span class="font-weight-bold">explications</span> qui aideront le participant à réviser en cas de mauvaise réponse.
                        <br>Associez chaque question à votre mot clé de travail afin de la retrouver facilement (filtre) au moment de l'associer à un quiz.
                        <br>Remarque : une question peut être utilisée dans plusieurs quiz mais une réponse est propre à une question (et ne peut donc pas être associée en l’état à une autre question).                       
                    </div>
                    <div class="col-12 col-md-3">
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-md-9">
                        Pour faire tout cela, cliquez successivement sur les boutons suivants :                        
                    </div>
                    <div class="col-12 col-md-3 help-instructions">
                        <button class="button" type="button">Vos questions</button>
                        <button class="button button-free" type="button">Créer une question</button>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-12 col-md-9">
                        N'oubliez pas de <span class="font-weight-bold">publier</span> vos questions <span class="font-weight-bold">et</span> vos réponses pour qu'elles soient proposées aux participants qui répondront au quiz (cochez le champ <span class="font-weight-bold">Publier</span>).
                        <br>N'oubliez pas non plus de cocher la case <span class="font-weight-bold">Bonne réponse</span> pour indiquer s'il s'agit d'une bonne réponse : une seule "bonne réponse" si le <span class="font-weight-bold">widget</span> choisi est le bouton radio ("<span class="font-weight-bold">radio</span>"), 0 à n bonnes réponses si le widget choisi est la boîte à cocher ("<span class="font-weight-bold">checkbox</span>").
                        <br><br>Gardez à l'esprit qu'il est beaucoup plus difficile de trouver la bonne réponse avec des boîtes à cocher.
                        <br>En effet, une question sous forme de <span class="font-weight-bold">n boutons radio</span> a <span class="font-weight-bold">n</span> réponses possibles (1 chance sur n de trouver la bonne réponse).
                        <br>En revanche, une question sous forme de <span class="font-weight-bold">n boîtes à cocher</span> a <span class="font-weight-bold">2<sup>n</sup></span> réponses possibles : on peut ne rien cocher, tout cocher, ou cocher une ou plusieurs cases (1 chance sur 2<sup>n</sup> de trouver la bonne réponse).
                        <br>
                        <br>Concernant les <span class="font-weight-bold">Explications</span>, il suffit d’indiquer un chapitre de cours, un concept, ou tout autre indication permettant de trouver la bonne réponse.
                        <br>Ces explications apparaîtront dans le résultat mis à disposition du participant pour les questions auxquelles il aura mal répondu.
                        <br>Si vous ne renseignez pas ce champ, la phrase suivante apparaîtra : « Consultez votre cours, vos notes ou internet. »
                    </div>
                    <div class="col-12 col-md-3">
                    </div>
                </div>
                <br>
                <h4 id="h4-create-quiz" class="h5">3. Créez un quiz</h4>
                <div class="row">
                    <div class="col-12 col-md-9">
                        Pour créer un quiz cliquez successivement sur les boutons suivants :                       
                    </div>
                    <div class="col-12 col-md-3 help-instructions">
                        <button class="button" type="button">Vos quiz</button>
                        <button class="button" type="button">Créer un quiz</button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-md-9">
                        Arrangez-vous pour que les titres de vos quiz soient uniques. Exemple : Titre « Python <span class="font-weight-bold">1</span> », Sous-titre (facultatif) « Initiation » ;  Titre « Python <span class="font-weight-bold">2</span> », Sous-titre (facultatif) « Intermédiaire ».
                        <br>
                        <br>N'oubliez pas de publier votre quiz pour qu'il apparaisse dans le tableau de bord des participants (Statut 'draft' = brouillon ; Statut 'inline' = en ligne = publié).
                    </div>
                    <div class="col-12 col-md-3">
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-12 col-md-9">
                        Il est possible d’associer des questions dès la création du quiz (Ctrl clic dans la liste).
                        <br>Mais il est plus pratique de les ajouter dans l'écran de modification :
                    </div>
                    <div class="col-12 col-md-3 help-instructions">
                        <button class="button" type="button">Vos quiz</button>
                        <br>Puis lien <span class="font-weight-bold">Maj</span> du quiz.
                    </div>
                </div>
                <br>
                <div class="row mt-md-3">
                    <div class="col-12 col-md-9">
                        Pour un quiz donné, vous pouvez, pour chaque question, définir un <span class="font-weight-bold">ordre</span> (de 0 à 4) et un <span class="font-weight-bold">poids</span> (de 1 à 3) :
                    </div>
                    <div class="col-12 col-md-3 help-instructions">
                        <button class="button" type="button">Vos quiz</button>
                        <br>Puis lien <span class="font-weight-bold">Maj</span> du quiz
                        <br>Champs <span class="font-weight-bold">Ordre</span> et <span class="font-weight-bold">Poids</span><div class=""></div>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-12 col-md-9">
                        <span class="font-weight-bold">Poids</span> : une réponse exacte est multipliée par son poids pour définir le nombre de points rapportés par la question. Par défaut le poids vaut 1 (une réponse juste rapporte 1 point).
                        <br>On peut par exemple surpondérer des questions relativement simples mais qui font appel à des notions importantes.
                        <br>
                        <br><span class="font-weight-bold">Ordre</span> : toutes les questions ont par défaut portent le numéro d'ordre 0. On peut définir des paquets de questions, chaque paquet portant un numéro d'ordre différent. Les questions portant le même numéro sont présentées dans un ordre aléatoire au sein du paquet. Mais les paquets sont présentés en respectant l’ordre (0 en premier, 4 en dernier). 
                        <br>On peut par exemple rassembler les questions difficiles (boites à cocher) pour la fin en donnant un poids de 1 à ces questions et en laissant les autres à 0.
                        <br><br>Remarque : dans tous les cas, les <span class="font-weight-bold">réponses</span> à une question sont proposées dans un ordre aléatoire.
                    </div>
                    <div class="col-12 col-md-3">
                    </div>
                </div>
                <br>
                <h4 id="h4-create-account" class="h5">4. Créez les comptes utilisateurs</h4>
                <div class="row">
                    <div class="col-12 col-md-9">
                        Pour créer un compte de type '<span class="font-weight-bold">user</span>', cliquez successivement sur les boutons suivants :                       
                    </div>
                    <div class="col-12 col-md-3 help-instructions">
                        <button class="button" type="button">Vos comptes</button>
                        <button class="button button-free" type="button">Créer un compte</button>
                    </div>
                </div>
                <br>
                <div class="row mt-md-3">
                    <div class="col-12 col-md-9">
                        Il est possible d’associer des sessions dès la création du compte (Ctrl clic dans la liste).
                        <br>Mais il est plus pratique de les ajouter dans l'écran de modification du compte :
                    </div>
                    <div class="col-12 col-md-3 help-instructions">
                        <button class="button" type="button">Vos comptes</button>
                        <br>Puis lien <span class="font-weight-bold">Maj</span> du compte.
                    </div>
                </div>
                <div class="row mt-md-3">
                    <div class="col-12 col-md-9">
                        Cependant, il est encore plus simple d'ajouter les comptes créés à une session, en utilisant l'écran de mise à jour de la session. 
                        <br>Pour cela, associez vos comptes à une <span class="font-weight-bold">société</span>, même fictive, afin de les retrouver facilement (filtre) lorsque vous les associerez à la session.
                    </div>
                    <div class="col-12 col-md-3 help-instructions">
                        <button class="button" type="button">Vos sessions</button>
                        <br>Puis lien <span class="font-weight-bold">Maj</span> de la session.
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-12 col-md-9">
                        Les logins de type 'user' sont créés avec le <span class="font-weight-bold">mot de passe par défaut</span> 'quiztiti' (à communiquer au participant) : Quiztiti demandera automatiquement au participant de changer ce mot de passe.               
                    </div>
                    <div class="col-12 col-md-3">
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-md-9">
                        L’administrateur peut <span class="font-weight-bold">réinitialiser à 'quiztiti', un mot de passe</span> 'user' oublié.
                    </div>
                    <div class="col-12 col-md-3 help-instructions">
                        <button class="button" type="button">Vos comptes</button>
                        <br>Puis lien <span class="font-weight-bold">Maj</span> du compte
                        <br>Puis champ <span class="font-weight-bold">RAZ mot de passe</span>
                        <br>Puis validez avec le bouton :
                        <br><button class="button button-free" type="button">Envoyer toutes les modifications de la page</button>
                    </div>
                </div>
                <br>
                <h4 id="h4-create-session" class="h5">5. Créez une session</h4>
                <div class="row">
                    <div class="col-12 col-md-9">
                        Pour <span class="font-weight-bold">créer une session</span>, cliquez successivement sur les boutons suivants :                       
                    </div>
                    <div class="col-12 col-md-3 help-instructions">
                        <button class="button" type="button">Vos sessions</button>
                        <button class="button button-free" type="button">Créer une session</button>
                    </div>
                </div>
                <div class="row mt-md-3">
                    <div class="col-12 col-md-9">
                        Puis <span class="font-weight-bold">modifiez la session</span> :
                    </div>
                    <div class="col-12 col-md-3 help-instructions">
                        Lien <span class="font-weight-bold">Maj</span> de la session
                    </div>
                </div>
                <div class="row mt-md-3">
                    <div class="col-12 col-md-9">
                        Pour y <span class="font-weight-bold">ajouter des comptes</span> :
                    </div>
                    <div class="col-12 col-md-3 help-instructions">
                        <button class="button button-free" type="button">Ajouter un compte</button>                   
                    </div>
                </div>
                <div class="row mt-md-3">
                    <div class="col-12 col-md-9">
                        Et pour y <span class="font-weight-bold">ajouter des quiz</span> (un même quiz peut être proposé dans plusieurs de vos sessions) :
                    </div>
                    <div class="col-12 col-md-3 help-instructions">
                        <button class="button button-free" type="button">Ajouter un quiz</button>                   
                    </div>
                </div>
                <br>
                <div class="row mt-md-3">
                    <div class="col-12 col-md-9">
                        Dans le cadre de son rattachement à une session, un quiz dispose de données particulières :
                        <br>
                        <ol>
                        <li><span class="font-weight-bold">Durée du quiz (en minutes)</span> : il est conseillé de la définir (quiz en temps limité) afin de fournir des indicateurs plus riches et de mettre à disposition des participants, un avancement qui leur permet de ne pas se précipiter lors du déroulement du quiz. 
                        <br>Remarque : pour un quiz donné, sa durée peut être différente d’une session à l’autre (selon le niveau des participants, par exemple).
                        </li>
                        <li><span class="font-weight-bold">Dates/heures d’ouverture et de fermeture du quiz</span> : un quiz ne peut être lancé, depuis le tableau de bord d’un participant, qu’entre ces deux dates/heures (quelle que soit la durée du quiz).
                        </li></ol>
                        <br>Une fois lancé, le quiz est verrouillé et il n’est plus possible de le relancer si l’on en sort.
                    </div>
                    <div class="col-12 col-md-3">
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-md-9">
                        L'administrateur peut toutefois <span class="font-weight-bold">débloquer un quiz</span> pour un participant :
                    </div>
                    <div class="col-12 col-md-3 help-instructions">
                        <button class="button" type="button">Vos comptes</button>                   
                        <br>Puis lien sur le nom de la session dans la colonne "<span class="font-weight-bold">Sessions et résultats</span>"
                        <br>Puis liste "<span class="font-weight-bold">Quiz non réalisés par prénom/nom du participant</span>"
                        <br>Puis colonne "<span class="font-weight-bold">Bloqué</span>" : décocher.
                        <br>Puis validez avec le bouton :
                        <br><button class="button button-free" type="button">Supprimer les résultats cochés et/ou débloquer les quiz décochés</button> 
                    </div>
                </div>
                <br>
                <div class="row mt-md-3">
                    <div class="col-12 col-md-9">
                        L'administrateur peut aussi <span class="font-weight-bold">supprimer un résultat</span> :
                    </div>
                    <div class="col-12 col-md-3 help-instructions">
                        <button class="button" type="button">Vos comptes</button>                   
                        <br>Puis lien sur le nom de la session dans la colonne <span class="font-weight-bold">Sessions et résultats</span>
                        <br>Puis liste <span class="font-weight-bold">Quiz réalisés par prénom/nom du participant</span>
                        <br>Puis colonne <span class="font-weight-bold text-alert">Supp.</span> : cocher.
                        <br>Puis validez avec le bouton :
                        <br><button class="button button-free" type="button">Supprimer les résultats cochés et/ou débloquer les quiz décochés</button> 
                    </div>
                </div>
                <br> 
                <h4 id="h4-result" class="h5">6. Suivez les résultats d’un participant</h4>
                <div class="row">
                    <div class="col-12 col-md-9">
                        Pour suivre les résultats d'un participant à une session :                       
                    </div>
                    <div class="col-12 col-md-3 help-instructions">
                        <button class="button" type="button">Vos comptes</button>                   
                        <br>Puis lien sur le nom de la session du participant, dans la colonne "<span class="font-weight-bold">Sessions et résultats</span>"
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-12 col-md-9">
                        Les indicateurs, sont de quatre sortes :                       
                        <ul>
                            <li>Indicateurs transverses sur la session</li>
                            <li>Indicateurs transverses sur le participant</li>
                            <li>Résultats détaillés de chacun des quiz réalisés par chaque participant,<br>en regard d’indicateurs transverses sur le quiz.</li>
                        </ul>
                    </div>
                    <div class="col-12 col-md-3">
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-md-9">
                        Pour avoir la définition exacte de chaque indicateur, cliquez sur le bouton suivant :                       
                    </div>
                    <div class="col-12 col-md-3 help-instructions">
                        <button class="button" type="button">Explications</button>                   
                    </div>
                </div>
                <br> 
                <h4 id="h4-audit" class="h5">7. Auditez chaque question</h4>
                <div class="row">
                    <div class="col-12 col-md-9">
                        Consultez l'écran de mise à jour de la question :
                    </div>
                    <div class="col-12 col-md-3 help-instructions">
                        <button class="button" type="button">Vos questions</button>                   
                        <br>Puis lien <span class="font-weight-bold">Maj</span> de la question à auditer.
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-12 col-md-9">
                        Les informations disponibles sont :
                        <ul>
                            <li>Le taux de réussite global de la question, tous quiz et sessions confondus (en haut à gauche)</li>
                            <li>Le détail de ce taux par quiz, pour éventuellement affiner et trouver des pistes d’explication liées au quiz (différences de niveau, de formation, etc.)</li>
                        </ul>
                    </div>
                    <div class="col-12 col-md-3">
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-md-9">
                        Un taux de réussite trop faible peut avoir des origines variées :
                        <ul>
                            <li>Question trop difficile (boites à cocher)</li>
                            <li>Nombre de réponses proposées trop élevé</li>
                            <li>Question mal formulée ou ambiguë</li>
                            <li>Réponses proposées ambiguës</li>
                            <li>Question inadaptée aux connaissances des apprenants</li>
                            <li>Sessions constituées d’apprenants de niveaux hétérogènes</li>
                            <li>Enseignement insuffisant ou trop abstrait (manque d’exercices).</li></ul>
                        </ul>
                    </div>
                    <div class="col-12 col-md-3">
                    </div>
                </div>
                <br>
                <h3 id="h3-delete" class="h4">La gestion des suppressions</h3>

                <h4 id="h4-delete-result" class="h5">La vie des résultats, des comptes et des sessions</h4>           
                <div class="row">
                    <div class="col-12 col-md-9">
                        Pour qu’un participant puisse continuer à accéder à ses <span class="font-weight-bold">résultats</span>, il suffit que son compte ne soit pas supprimé. 
                        <br>Le participant n’accèdera plus aux explications (POINTS À RÉVISER) relatives à une question à laquelle il a mal répondu, si cette question est supprimée. Mais il continuera à accéder au reste du résultat. 
                        <br>Le participant continuera à accéder à son résultat même si le quiz ou la session sont supprimés.
                        <br>
                        <br>Parcontre, si la session est supprimée, l’administrateur n’aura plus accès aux résultats.
                        <br><span class="font-weight-bold">Conservez la session tant que vous voulez pouvoir consulter des résultats.</span>
                    </div>
                    <div class="col-12 col-md-3">
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-12 col-md-9">
                        Lorsque vous n’avez plus besoin des résultats, vous pouvez supprimer la session.
                        <br>N. B. : vous pouvez ou non cochez l'option <span class="font-weight-bold">Supprimer aussi tous les comptes et résultats n'appartenant qu'à cette session</span>.
                        Si vous cochez cette option, les comptes inscrits à d'autres sessions que celle-ci ne seront pas supprimés.
                        <br>vous pouvez supprimer la session de la façon suivante :
                    </div>
                    <div class="col-12 col-md-3 help-instructions">
                        <button class="button" type="button">Vos sessions</button>                   
                        <br>Puis lien <span class="font-weight-bold">Supp.</span> en début de ligne de la session
                        <br>Puis validez avec le bouton :
                        <button class="button" type="button">Envoyer</button>                   
                    </div>
                </div>
                <br>
                <h4 id="h4-delete-quiz" class="h5">La vie des quiz</h4>           
                <div class="row">
                    <div class="col-12 col-md-9">
                        Les quiz ont pour vocation d’être réutilisés dans différentes sessions. Aussi, la suppression d’une session n’entrainera jamais la suppression d’un quiz.
                        <br>Un quiz ne peut être supprimé qu’isolément de la façon suivante (si un quiz est supprimé, il l’est pour toutes les sessions qui l’utilisent) :
                    </div>
                    <div class="col-12 col-md-3 help-instructions">
                        <button class="button" type="button">Vos quiz</button>                   
                        <br>Puis lien <span class="font-weight-bold">Supp.</span> en début de ligne du quiz
                        <br>Puis validez avec le bouton :
                        <button class="button" type="button">Envoyer</button>
                    </div>
                </div>
                <br>
                <div class="row mt-md-3">
                    <div class="col-12 col-md-9">
                        Un quiz peut être dépublié à tout moment, de la façon suivante (si un quiz est dépublié, il l’est pour toutes les sessions qui l’utilisent) :
                    </div>
                    <div class="col-12 col-md-3 help-instructions">
                        <button class="button" type="button">Vos quiz</button>                   
                        <br>Puis lien <span class="font-weight-bold">Maj</span> de la ligne du quiz
                        <br>Puis décochez le champ <span class="font-weight-bold">Publier</span> 
                        <br>Puis validez avec le bouton :
                        <button class="button button-free" type="button">Envoyer toutes les modifications de la page</button>                   
                    </div>
                </div>
                <br>
                <h4 id="h4-delete-question" class="h5">La vie des questions et des mots clés</h4>           
                <div class="row">
                    <div class="col-12 col-md-9">
                        Les questions ont pour vocation d’être réutilisées dans différents quiz. Aussi, la suppression d’un quiz n’entrainera jamais la suppression d’une question. Mais si une question est supprimée, elle l’est pour tous les quiz et sessions qui l’utilisent. 
                        <br>Une question ne peut être supprimée qu’isolément, de la façon suivante :
                    </div>
                    <div class="col-12 col-md-3 help-instructions">
                        <button class="button" type="button">Vos questions</button>                   
                        <br>Puis lien <span class="font-weight-bold">Supp.</span> en début de ligne de la question
                        <br>Puis validez avec le bouton :
                        <button class="button" type="button">Envoyer</button>
                    </div>
                </div>
                <br>
                <div class="row mt-md-3">
                    <div class="col-12 col-md-9">
                        Si une question est dépubliée, elle l’est pour tous les quiz et sessions qui l’utilisent.
                        <br>Une question peut être dépubliée à tout moment de la façon suivante :
                    </div>    
                    <div class="col-12 col-md-3 help-instructions">
                        <button class="button" type="button">Vos quiz</button>                   
                        <br>Puis lien <span class="font-weight-bold">Maj</span> de la ligne de la question
                        <br>Puis décochez le champ <span class="font-weight-bold">Publier</span> 
                        <br>Puis validez avec le bouton :
                        <button class="button button-free" type="button">Envoyer toutes les modifications de la page</button>                   
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-12 col-md-9">
                        La suppression d’un mot clé n’affecte pas les questions qui l’utilisent. Vous ne pourrez simplement plus filtrer les questions sur ce mot clé.
                    </div>
                    <div class="col-12 col-md-3">
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-md-9">
                        Remarque : pour information, la liste des questions qui utilisent le mot clé qu’on veut supprimer est alors automatiquement affichée dans la partie droite de l’écran (ou à la fin de la liste des mots clés, sur un petit écran).
                        N.B. : c'est aussi le cas lorsqu'on veut modifier un mot clé. Mais cette liste peut aussi être affichée pour n’importe quel mot clé, en cliquant dans la colonne <span class="font-weight-bold">Quest.</span> sur le nombre de questions qui le concernent.
                    </div>
                    <div class="col-12 col-md-3">
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-12 col-md-9">
                        Pour supprimer un mot clé, procédez de la façon suivante :
                    </div>
                    <div class="col-12 col-md-3 help-instructions">
                        <button class="button" type="button">Vos mots clés</button>                   
                        <br>Puis lien <span class="font-weight-bold">Supp.</span> de la ligne du mot clé
                        <br>Puis validez avec le bouton :
                        <button class="button" type="button">Envoyer</button>                   
                    </div>
                </div>
                <br><br>
            </div>
            
            <div id="bt-leave-help-admin2" class="col-12 text-center my-2">
                <button class="button" type="button" onclick="showDiv('div-help-admin')">Quitter l'Aide</button>
            </div>
        </div>