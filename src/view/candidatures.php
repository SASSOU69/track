<?php
// Sécurité : vérifie que la variable $candidatures est bien définie (par le contrôleur)
if (!isset($candidatures)) exit;
?>

<!-- Titre de la page -->
<h1 class="mb-4">Mes candidatures</h1>

<!-- 🔍 Formulaire de recherche AJAX -->
<form id="rechercheForm" class="mb-3" onsubmit="return false;">
  <div class="input-group">
    <!-- Champ de recherche AJAX -->
    <input
      type="text"
      id="recherche"
      class="form-control"
      placeholder="Rechercher un poste ou une entreprise..."
      aria-label="Rechercher un poste ou une entreprise"
    >
    <!-- Bouton de recherche avec icône -->
    <button
      id="btnRecherche"
      class="btn btn-outline-secondary"
      type="button"
      title="Rechercher"
      aria-label="Rechercher"
    >
      🔍
    </button>
  </div>
</form>

<!-- 📋 Formulaire de filtres classiques (en GET) -->
<form method="get" class="row g-3 align-items-end mb-4" id="filtre-form">
  <!-- Champ caché pour garder la page actuelle -->
  <input type="hidden" name="page" value="candidatures">

  <!-- Champ de recherche (soumis avec GET) -->
  <div class="col-md-4">
    <label for="search" class="form-label">Recherche</label>
    <input
      type="text"
      class="form-control"
      name="search"
      id="search"
      placeholder="Poste, entreprise, statut..."
      value="<?= htmlspecialchars($_GET['search'] ?? '') ?>"
    >
  </div>

  <!-- Sélecteur de statut -->
  <div class="col-md-3">
    <label for="statut" class="form-label">Statut</label>
    <select name="statut" id="statut" class="form-select">
      <option value="">Tous</option>
      <?php foreach ($statutsDisponibles as $statutOption): ?>
        <option
          value="<?= htmlspecialchars($statutOption) ?>"
          <?= ($_GET['statut'] ?? '') === $statutOption ? 'selected' : '' ?>
        >
          <?= htmlspecialchars($statutOption) ?>
        </option>
      <?php endforeach; ?>
    </select>
  </div>

  <!-- Bouton Filtrer -->
  <div class="col-md-2">
    <button type="submit" class="btn btn-primary w-100">Filtrer</button>
  </div>
</form>

<!-- 📦 Zone de résultats (initialement remplie via PHP, modifiable via AJAX) -->
<div id="resultatsCandidatures">
  <?php include __DIR__ . '/includes/partials/tableau-candidatures.php'; ?>
</div>

<!-- Script JS AJAX -->
<script>
document.addEventListener("DOMContentLoaded", () => {
  const btnRecherche = document.getElementById("btnRecherche");
  const inputRecherche = document.getElementById("recherche");
  const resultatsDiv = document.getElementById("resultatsCandidatures");

  if (btnRecherche && inputRecherche && resultatsDiv) {

    const lancerRecherche = () => {
      const query = inputRecherche.value.trim();
      if (!query) return;

      fetch("index.php?page=recherche&q=" + encodeURIComponent(query))
        .then(response => {
          if (!response.ok) throw new Error("Erreur serveur");
          return response.text();
        })
        .then(html => {
          resultatsDiv.innerHTML = html;
        })
        .catch(error => {
          console.error("Erreur AJAX :", error);
        });
    };

    btnRecherche.addEventListener('click', (e) => {
      e.preventDefault();
      lancerRecherche();
    });

    inputRecherche.addEventListener('keypress', function (e) {
      if (e.key === 'Enter') {
        e.preventDefault();
        lancerRecherche();
      }
    });

    inputRecherche.addEventListener('input', () => {
      if (inputRecherche.value.trim() === '') {
        fetch("index.php?page=candidatures")
          .then(response => response.text())
          .then(html => {
            const tempDOM = new DOMParser().parseFromString(html, "text/html");
            const contenu = tempDOM.querySelector('#resultatsCandidatures');
            if (contenu) resultatsDiv.innerHTML = contenu.innerHTML;
          });
      }
    });
  }
});
</script>
