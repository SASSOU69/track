<?php

// Définit la constante BASE_URL utilisée pour les liens relatifs dans le projet
define('BASE_URL', '/tracker-candidatures/public');

// Démarre la session PHP (pour stocker des infos entre les pages, comme les messages flash ou la connexion utilisateur)
session_start();

// --- Autoload des classes ---
// Fonction anonyme pour charger automatiquement les classes depuis le dossier /src
spl_autoload_register(function ($class) {
    // Remplace les backslashes des namespaces par des slashes (chemin Unix)
    $file = __DIR__ . '/../src/' . str_replace('\\', '/', $class) . '.php';
    
    // Si le fichier correspondant existe, on l'inclut
    if (file_exists($file)) {
        require_once $file;
    }
});

// On importe la classe principale du contrôleur
use Controller\ApplicationController;

// On récupère le paramètre "page" dans l'URL (ex : index.php?page=candidatures)
// Si aucun paramètre n'est donné, on affiche la page d'accueil
$page = $_GET['page'] ?? 'home';

// On instancie le contrôleur principal
$controller = new ApplicationController();

// --- Routing (système de routes manuel) ---
// En fonction de la page demandée, on appelle la méthode correspondante du contrôleur
switch ($page) {
    case 'home':
        $controller->home();
        break;

    case 'candidatures':
        $controller->listCandidatures();
        break;

    case 'ajouter':
        $controller->addCandidature();
        break;

    case 'modifier':
        $controller->modifierCandidature();
        break;

    case 'supprimer':
        $controller->supprimerCandidature();
        break;

    case 'enregistrer':
        $controller->enregistrerCandidature();
        break;

    case 'enregistrer_modification':
        $controller->enregistrerModification();
        break;

    case 'register':
        $controller->register();
        break;

    case 'login':
        $controller->login();
        break;

    case 'logout':
        $controller->logout();
        break;

    case 'dashboard':
        $controller->dashboard();
        break;

 case 'recherche':  // <-- AJOUTER CETTE LIGNE
        $controller->recherche();
        break;
    // Si aucune des pages ne correspond, on retourne à l'accueil par défaut
    default:
        $controller->home();
        break;
}
