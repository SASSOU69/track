<!-- Titre principal de la page -->
<h1 class="mb-4 text-center">Ajouter une candidature</h1>

<!-- Lien pour revenir à la liste des candidatures -->
<div class="mb-3 text-center">
  <a href="?page=candidatures" class="text-decoration-none fw-bold text-primary">
    ← Retour à la liste des candidatures
  </a>
</div>

<!-- Affichage d'un message flash s'il existe dans la session -->
<?php if (!empty($_SESSION['flash'])) : ?>
  <!-- Message de succès -->
  <div class="alert alert-success text-center"><?= $_SESSION['flash'] ?></div>
  <!-- Suppression du message après affichage -->
  <?php unset($_SESSION['flash']); ?>
<?php endif; ?>

<!-- Début du formulaire d'ajout de candidature -->
<form action="?page=enregistrer" method="POST" enctype="multipart/form-data" class="form-candidature">
  
  <!-- Champ pour le nom du poste -->
  <div class="mb-3">
    <label for="poste" class="form-label">Poste :</label>
    <input type="text" id="poste" name="poste" class="form-control" required>
  </div>

  <!-- Champ pour le CV (fichier PDF) -->
  <div class="mb-3">
    <label for="cv" class="form-label">CV (PDF) :</label>
    <input type="file" name="cv" id="cv" accept=".pdf" class="form-control">
  </div>
  
  <!-- Champ pour le nom de l'entreprise -->
  <div class="mb-3">
    <label for="entreprise" class="form-label">Entreprise :</label>
    <input type="text" id="entreprise" name="entreprise" class="form-control" required>
  </div>

  <!-- Champ pour la date de candidature -->
  <div class="mb-3">
    <label for="date" class="form-label">Date :</label>
    <input type="date" id="date" name="date" class="form-control" required>
  </div>

  <!-- Champ pour ajouter des notes ou commentaires -->
  <div class="mb-3">
    <label for="notes" class="form-label">Notes / Commentaires</label>
    <textarea name="notes" id="notes" class="form-control" rows="4"></textarea>
  </div>

  <!-- Sélection du statut de la candidature -->
  <div class="mb-4">
    <label for="statut" class="form-label">Statut :</label>
    <select name="statut" id="statut" class="form-select" required>
      <option value="En attente">En attente</option>
      <option value="Entretien">Entretien</option>
      <option value="Refusée">Refusée</option>
      <option value="Acceptée">Acceptée</option>
      <option value="Relancée">Relancée</option>
    </select>
  </div>

  <!-- Bouton d'envoi du formulaire -->
  <div class="text-center">
    <button type="submit" class="btn btn-primary px-4">➕ Ajouter</button>
  </div>
</form>
