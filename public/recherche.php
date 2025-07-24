<?php
require_once __DIR__ . '/../models/Database.php';
require_once __DIR__ . '/../models/Candidature.php';

use Model\Candidature;

$motCle = trim($_GET['q'] ?? '');

// Si vide, retourner immédiatement un message (optionnel)
if ($motCle === '') {
  echo '<div class="alert alert-info">Veuillez entrer un mot-clé.</div>';
  exit;
}

$candidatures = Candidature::rechercherParMotCle($motCle);

// Vue partielle AJAX (ne contient que le tableau HTML)
include __DIR__ . '/../views/includes/partials/tableau-candidatures.php';
