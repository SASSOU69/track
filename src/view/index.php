<?php
// Inclusion du contrôleur principal de l'application
require_once '../src/Controller/applicationcontroller.php';

// Affiche le contenu de la variable $_GET pour debug puis stoppe le script
var_dump($_GET);
exit;

// Import de la classe ApplicationController dans l’espace de nom Controller
use Controller\ApplicationController;

// Instanciation du contrôleur principal
$controller = new ApplicationController();

// Démarrage de la temporisation de sortie (buffering) pour capturer le contenu généré
ob_start();

// Récupère le paramètre 'page' dans l'URL, ou 'home' par défaut si absent
$page = $_GET['page'] ?? 'home';

// Gestion du routage selon la valeur de la page demandée
switch ($page) {
  
  // Si page = 'candidatures', on affiche la liste des candidatures
  case 'candidatures':
    $title = 'Mes candidatures';             // Définit le titre de la page
    $controller->listCandidatures();         // Appelle la méthode pour afficher la liste
    break;

  // Si page = 'ajouter', on affiche le formulaire d'ajout
  case 'ajouter':
    $title = 'Ajouter une candidature';      // Définit le titre
    $controller->addCandidature();            // Appelle la méthode pour afficher le formulaire d'ajout
    break;

  // Si page = 'modifier', on affiche le formulaire de modification d'une candidature
  case 'modifier':  // <=== AJOUTÉ CE CASE
    $title = 'Modifier une candidature';     // Titre spécifique à la modification
    $controller->modifierCandidature();       // Méthode pour afficher le formulaire de modification
    break;

  // Si page = 'enregistrer', on traite la soumission du formulaire d'ajout
  case 'enregistrer':
    $controller->enregistrerCandidature();    // Méthode qui enregistre la nouvelle candidature en BDD
    break;

  // Si page = 'enregistrer_modification', on traite la soumission du formulaire de modification
  case 'enregistrer_modification':
    $controller->enregistrerModification();   // Méthode qui met à jour la candidature en BDD
    break;

  // Si page = 'supprimer', on supprime une candidature
  case 'supprimer':
    $controller->supprimerCandidature();      // Méthode qui supprime la candidature sélectionnée
    break;

  // Si page = 'home' ou page non reconnue, on affiche la page d'accueil
  case 'home':
    $title = 'Accueil - Tracker de candidatures';  // Titre pour l'accueil
    $controller->home();                            // Méthode affichant la page d'accueil
    break;

  // Cas par défaut (page inconnue) → redirection ou affichage accueil
  default:
    $title = 'Accueil - Tracker de candidatures';  // Même titre que la home
    $controller->home();                            // Affiche la page d'accueil par défaut
    break;
}

// Récupération du contenu généré dans le buffer de sortie
$content = ob_get_clean();

// Inclusion du layout principal, qui va utiliser $content et $title pour afficher la page complète
require '../src/view/layout.php';
