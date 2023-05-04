<?php
/*****************************************************************************************
* Screen:       view/carousel_demo.php (included into header.php)
* admin/user:   admin, user
* Scope:	    login
* JS:           vew/scriptv1.js
* CSS:          vew/style.css
* 
* Feature : demonstration of a taken quiz
* Trigger: header.php / $loggedin == false  
* 
* Major tasks:  o a 5 slides carousel
*
* Next processing   o Appears/Disappears when click on button "Démo" 
*                   o Disappears when click on buttons "Aide", "Seconnecter", "Créer un compte administrateur"
*******************************************************************************************/

if(!$messageHeader or $messageHeader == "A bientôt"){ ?>

    <!--Carousel-->
    <div id="div-demo" class="row bg-carousel">
        <div class="col-0 col-md-1"></div>
        <div class="col-12 col-md-10">
            <div id="carousel-index" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner">

                    <div class="carousel-item active"> <!--Item 0: "Commencer"----->
                        <div> 
                            <br>
                            <p class="text-center h5 mt-2">Démonstration</p>
                            <p class="text-center h5 mt-2">Les Pourquoi</p>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-8 div-order text-left" id="div-taken-quiz-order">                
                                Pour réaliser ce quiz, vous disposez de <span class='font-weight-bold'>3 minutes.</span><br>Le décompte a commencé à "."22/12/2022"." (heure serveur).     
                                <br><span class='font-weight-bold'><br>ATTENTION</span> : l'utilisation de la flèche 'retour arrière' (<-), en haut à gauche sur votre écran,<br>équivaut à ABANDONNER le quiz qui sera verrouillé.<br>Vos données seront perdues et vous ne pourrez pas relancer le quiz.
                            </div>
                            <div class="col-12 col-md-4">
                                <div row>
                                    <div class="col-12 font-weight-bold">
                                        <p>Avancement à la validation de votre dernière réponse</p>
                                    </div>
                                </div>
                                <div row>
                                    <div class="col-12" id="div-timer">
                                        <div class="row">
                                            <div class="col-3 text-left">
                                                <div>
                                                    <label>Temps écoulé</label>
                                                </div>
                                            </div>
                                            <div class="col-9 pt-1">
                                                <div class="progress">
                                                    <div id="div-progress-time" class="bg-danger progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-3 text-left">
                                                <div>
                                                    <label>Questions traitées</label>
                                                </div>
                                            </div>
                                            <div class="col-9 pt-1">
                                                <div class="progress">
                                                    <div id="div-progress-questions" class="bg-success progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div row>
                                    <div class="col-12">
                                        <button id="bt-show-timer" type="button" onclick="onclickbtshowtimer()">Masquer l'avancement</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-center">
                            <br><a type="button" class="bt_takenquiz" href="#footer">Commencer</a><br><br>  
                        </div>
                    </div>
                    
                    <div class="carousel-item"> <!--Item 1----------->
                        <div> 
                            <br>
                            <p class="text-center h5 mt-2">Démonstration</p>
                            <p class="text-center h5 mt-2">Les Pourquoi</p>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-8 div-order text-left" id="div-taken-quiz-order">                
                                Pour réaliser ce quiz, vous disposez de <span class='font-weight-bold'>3 minutes.</span><br>Le décompte a commencé à "."22/12/2022"." (heure serveur).     
                                <br><span class='font-weight-bold'><br>ATTENTION</span> : l'utilisation de la flèche 'retour arrière' (<-), en haut à gauche sur votre écran,<br>équivaut à ABANDONNER le quiz qui sera verrouillé.<br>Vos données seront perdues et vous ne pourrez pas relancer le quiz.
                            </div>
                            <div class="col-12 col-md-4">
                                <div row>
                                    <div class="col-12 font-weight-bold">
                                        <p>Avancement à la validation de votre dernière réponse</p>
                                    </div>
                                </div>
                                <div row>
                                    <div class="col-12" id="div-timer1">
                                        <div class="row">
                                            <div class="col-3 text-left">
                                                <div>
                                                    <label>Temps écoulé</label>
                                                </div>
                                            </div>
                                            <div class="col-9 pt-1">
                                                <div class="progress">
                                                    <div id="div-progress-time" class="bg-danger progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-3 text-left">
                                                <div>
                                                    <label>Questions traitées</label>
                                                </div>
                                            </div>
                                            <div class="col-9 pt-1">
                                                <div class="progress">
                                                    <div id="div-progress-questions" class="bg-success progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div row>
                                    <div class="col-12">
                                        <button id="bt-show-timer1" type="button" onclick="onclickbtshowtimers('div-timer1', 'bt-show-timer1')">Masquer l'avancement</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-center">
                            <br><a type="button" class="bt_takenquiz" href="#footer">Question suivante (2/3)</a><br><br>  
                        </div>
                        <div id="div-quiz" class="row text-left">
                            <div class="col-0 col-md-2"></div>
                            <div class="col-12 col-md-10">
                                <p class="font-weight-bold">Pourquoi les numéros des modèles Peugeot ont-ils un zéro au milieu ?</p>
                                <input type="radio" id="answer-1-1" name="answer-1"><label class="ml-2" for="answer-1-1">Pour laisser passer une manivelle</label><br>
                                <input type="radio" id="answer-1-2" name="answer-1"><label class="ml-2" for="answer-1-2">Pour rappeler le o de Peugeot</label><br>
                                <input type="radio" id="answer-1-3" name="answer-1"><label class="ml-2" for="answer-1-3">Le zéro était remplacé par une roue dans les premières brochures publicitaires</label><br>
                                <br>
                            </div>
                        </div>
                    </div>

                    <div class="carousel-item"> <!--Item 2----------->
                        <div> 
                            <br>
                            <p class="text-center h5 mt-2">Démonstration</p>
                            <p class="text-center h5 mt-2">Les Pourquoi</p>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-8 div-order text-left" id="div-taken-quiz-order">                
                                Pour réaliser ce quiz, vous disposez de <span class='font-weight-bold'>3 minutes.</span><br>Le décompte a commencé à "."22/12/2022"." (heure serveur).     
                                <br><span class='font-weight-bold'><br>ATTENTION</span> : l'utilisation de la flèche 'retour arrière' (<-), en haut à gauche sur votre écran,<br>équivaut à ABANDONNER le quiz qui sera verrouillé.<br>Vos données seront perdues et vous ne pourrez pas relancer le quiz.
                            </div>
                            <div class="col-12 col-md-4">
                                <div row>
                                    <div class="col-12 font-weight-bold">
                                        <p>Avancement à la validation de votre dernière réponse</p>
                                    </div>
                                </div>
                                <div row>
                                    <div class="col-12" id="div-timer2">
                                        <div class="row">
                                            <div class="col-3 text-left">
                                                <div>
                                                    <label>Temps écoulé</label>
                                                </div>
                                            </div>
                                            <div class="col-9 pt-1">
                                                <div class="progress">
                                                    <div id="div-progress-time" class="bg-danger progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 10%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-3 text-left">
                                                <div>
                                                    <label>Questions traitées</label>
                                                </div>
                                            </div>
                                            <div class="col-9 pt-1">
                                                <div class="progress">
                                                    <div id="div-progress-questions" class="bg-success progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 33.33%" aria-valuenow="33.33" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div row>
                                    <div class="col-12">
                                        <button id="bt-show-timer2" type="button" onclick="onclickbtshowtimers('div-timer2', 'bt-show-timer2')">Masquer l'avancement</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-center">
                            <br><a type="button" class="bt_takenquiz" href="#footer">Question suivante (3/3)</a><br><br>  
                        </div>
                        <div id="div-quiz" class="row text-left">
                            <div class="col-0 col-md-2"></div>
                            <div class="col-12 col-md-10">
                                <p class="font-weight-bold">Pourquoi les aiguilles d'une montre tournent-elle dans le sens des aiguilles d'une montre ?</p>
                                <input type="checkbox" id="answer-2-1"><label class="ml-2" for="answer-2-1">Parce qu'on a inventé l'horloge dans l'hémisphère nord</label><br>
                                <input type="checkbox" id="answer-2-2"><label class="ml-2" for="answer-2-2">Parce que l'ombre du style d'un cadran solaire tourne dans le sens des aiguilles d'une montre</label><br>
                                <input type="checkbox" id="answer-2-3"><label class="ml-2" for="answer-2-3">Parce que l'hémisphère droit trace naturellement les cercles dans le sens des aiguilles d'une montre</label><br>
                                <br>
                            </div>
                        </div>
                    </div>

                    <div class="carousel-item"> <!--Item 3----------->
                        <div> 
                            <br>
                            <p class="text-center h5 mt-2">Démonstration</p>
                            <p class="text-center h5 mt-2">Les Pourquoi</p>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-8 div-order text-left" id="div-taken-quiz-order">                
                                Pour réaliser ce quiz, vous disposez de <span class='font-weight-bold'>3 minutes.</span><br>Le décompte a commencé à "."22/12/2022"." (heure serveur).     
                                <br><span class='font-weight-bold'><br>ATTENTION</span> : l'utilisation de la flèche 'retour arrière' (<-), en haut à gauche sur votre écran,<br>équivaut à ABANDONNER le quiz qui sera verrouillé.<br>Vos données seront perdues et vous ne pourrez pas relancer le quiz.
                            </div>
                            <div class="col-12 col-md-4">
                                <div row>
                                    <div class="col-12 font-weight-bold">
                                        <p>Avancement à la validation de votre dernière réponse</p>
                                    </div>
                                </div>
                                <div row>
                                    <div class="col-12" id="div-timer3">
                                        <div class="row">
                                            <div class="col-3 text-left">
                                                <div>
                                                    <label>Temps écoulé</label>
                                                </div>
                                            </div>
                                            <div class="col-9 pt-1">
                                                <div class="progress">
                                                    <div id="div-progress-time" class="bg-danger progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 20%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-3 text-left">
                                                <div>
                                                    <label>Questions traitées</label>
                                                </div>
                                            </div>
                                            <div class="col-9 pt-1">
                                                <div class="progress">
                                                    <div id="div-progress-questions" class="bg-success progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 66.66%" aria-valuenow="66.66" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div row>
                                    <div class="col-12">
                                        <button id="bt-show-timer3" type="button" onclick="onclickbtshowtimers('div-timer3', 'bt-show-timer3')">Masquer l'avancement</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-center">
                            <br><a type="button" class="bt_takenquiz" href="#footer">Répondre à la dernière question ci-dessous puis cliquer pour valider</a><br><br>  
                        </div>
                        <div id="div-quiz" class="row text-left">
                            <div class="col-0 col-md-2"></div>
                            <div class="col-12 col-md-10">
                                <p class="font-weight-bold">Pourquoi les nus du Radeau de la Méduse portent-ils des chausses ?</p>
                                <input type="radio" id="answer-3-1" name="answer-3"><label class="ml-2" for="answer-3-1">Parce que Louis XVIII avait les pieds déformés</label><br>
                                <input type="radio" id="answer-3-2" name="answer-3"><label class="ml-2" for="answer-3-2">Parce que Géricault avait du mal à peindre les pieds</label><br>
                                <input type="radio" id="answer-3-3" name="answer-3"><label class="ml-2" for="answer-3-3">Parce qu'au XIX<sup>e</sup> siècle, les pieds étaient considérés comme des parties honteuses</label><br>
                                <br>
                            </div>
                        </div>
                    </div>

                    <div class="carousel-item"> <!--Item 4: "Résultat"-----> 
                        <div> 
                            <br>
                            <p class="text-center h5 mt-2">Démonstration</p>
                            <p class="text-center h5 mt-2 font-weight-bold">RÉSULTAT DE VOTRE QUIZ du 05/12/22 16:35</p>
                            <p class="text-center h5 mt-2">Les Pourquoi</p>
                        </div>

                        Pour réaliser ce quiz, vous disposiez de <span class='font-weight-bold'>3 minutes</span>.   
                        <br>Vous avez réalisé ce quiz en <span class='font-weight-bold'>27 secondes</span>, soit <span class='font-weight-bold'>15 %</span> du temps imposé.
                        <br>Vous avez répondu à <span class='font-weight-bold'>3 questions</span> sur les <span class='font-weight-bold'>3</span> prévues, soit <span class='font-weight-bold'>100 %</span> des questions.
                        <br>
                        <br>Vos bonnes réponses vous ont permis de récolter <span class='font-weight-bold'>1 point</span>.
                        <br>Rapporté aux <span class='font-weight-bold'>4 points</span> mis en jeu par les questions du quiz,
                        <br>cela fait un taux de réussite de <span class='font-weight-bold'>25 %</span>, soit une note de <span class='font-weight-bold'>5/20</span>.
                        <br><br>
                        <div class="text-center font-weight-bold h5 text-uppercase">
                            Points à réviser
                        </div>
                        <div class="div-of-rows text-left"> 
                            <div class="row font-weight-bold responsive-hide">
                                <div class="col-12 col-md-3">Question (réponse erronée)</div>
                                <div class="col-12 col-md-3">Titre des explications</div>
                                <div class="col-12 col-md-6">Explications</div> 
                            </div>
                
                            <div class="row">
                                <div class="col-12 col-md-3">
                                    <span class="font-weight-bold responsive-show">Question (réponse erronée)<br></span>
                                    Pourquoi les nus du Radeau de la Méduse portent-ils des chausses ?
                                </div>
                                <div class="col-12 col-md-3">
                                    <span class="font-weight-bold responsive-show">Titre de l'explication<br></span>
                                    Shoes must go on
                                </div>
                                <div class="col-12 col-md-6">
                                    <span class="font-weight-bold responsive-show">Explication<br></span> 
                                    Consultez votre cours, vos notes ou internet.
                                </div> 
                            </div>

                            <div class="row">
                                <div class="col-12 col-md-3">
                                    <span class="font-weight-bold responsive-show">Question (réponse erronée)<br></span>
                                    Pourquoi les aiguilles d'une montre tournent-elle dans le sens des aiguilles d'une montre ?
                                </div>
                                <div class="col-12 col-md-3">
                                    <span class="font-weight-bold responsive-show">Titre des explications<br></span>
                                    Hémisphère et boule de gomme
                                </div>
                                <div class="col-12 col-md-6">
                                    <span class="font-weight-bold responsive-show">Explication<br></span> 
                                    Dans l'hémisphère nord, l'ombre tourne dans le sens des aiguilles d'une montre, là où celle-ci fut inventée. L'hémisphère droit, quant à lui, dirige la main des gauchers.
                                </div> 
                            </div>
                        </div>
                        <br>
                        <br>
                    </div>

                    <!-- Contrôles -->
                    <a class="carousel-control-prev" href="#carousel-index" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Précédent</span>
                    </a>
                    <a class="carousel-control-next" href="#carousel-index" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Suivant</span>
                    </a>
                </div>
            </div>                    
        </div>
    </div>  <?php
} 