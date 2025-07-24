<!-- Conteneur principal avec marge haute -->
<div class="container mt-5">

  <!-- Ligne Bootstrap avec alignement vertical centré -->
  <div class="row align-items-center">

    <!-- Colonne gauche (6 colonnes en md) avec texte centré sur petit écran, aligné à gauche sur md+ -->
    <div class="col-md-6 text-center text-md-start">
      
      <!-- Titre principal avec marge en bas -->
      <h1 class="mb-3">Bienvenue sur mon tracker de candidatures</h1>

      <!-- Paragraphe descriptif -->
      <p>Ce projet permet de gérer mes candidatures facilement.</p>

      <!-- Paragraphe compteur avec condition pluriel et emoji -->
      <p class="compteur">
        Vous avez actuellement 
        <!-- Affiche nombre candidatures en gras -->
        <strong><?= $nbCandidatures ?></strong> 
        candidature<?= $nbCandidatures > 1 ? 's' : '' ?> <!-- Pluriel si > 1 -->
        enregistrée<?= $nbCandidatures > 0 ? ' 🗂️' : '' ?>. <!-- Emoji dossier si au moins 1 -->
      </p>

      <!-- Bouton pour accéder à la page des candidatures avec marge en haut -->
      <a href="?page=candidatures" class="btn btn-primary mt-3">Voir mes candidatures</a>
    </div>

    <!-- Colonne droite (6 colonnes en md) avec image centrée sur petit écran et marge en haut sur petit écran uniquement -->
    <div class="col-md-6 text-center mt-4 mt-md-0">
      <!-- Image responsive avec largeur max limitée -->
      <img src="<?= BASE_URL ?>/img/tracker-cv.webp" alt="Illustration" class="img-fluid" style="max-width: 250px;">
    </div>

  </div>

  <!-- Ligne horizontale avec marges verticales -->
  <hr class="my-5">

  <!-- Section fonctionnalités, texte centré -->
  <section class="features text-center">
    <!-- Titre secondaire avec marge en bas -->
    <h2 class="mb-4">Fonctionnalités</h2>

    <!-- Liste non stylisée, sans puces -->
    <ul class="list-unstyled">
      <!-- Chaque item avec marge en bas -->
      <li class="mb-2">📄 Suivi des candidatures (entreprise, poste, statut…)</li>
      <li class="mb-2">➕ Ajouter une nouvelle candidature</li>
      <li class="mb-2">✏️ Modifier ou supprimer une candidature</li>
      <li class="mb-2">🔍 Filtrer par statut (en attente, relancé…)</li>
    </ul>
  </section>

</div>
