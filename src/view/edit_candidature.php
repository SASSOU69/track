<!-- Titre principal centré avec marge en bas -->
<h1 class="text-center mb-4">Modifier la candidature</h1>

<!-- Vérifie que la variable $candidature n'est pas vide (candidature trouvée) -->
<?php if (!empty($candidature)) : ?>

  <!-- Affiche un message flash de succès si défini, puis le supprime -->
  <?php if (!empty($_SESSION['flash'])) : ?>
    <div class="alert alert-success text-center">
      <?= $_SESSION['flash']; unset($_SESSION['flash']); ?>
    </div>
  <?php endif; ?>

  <!-- Formulaire de modification -->
  <form 
    method="post" 
    action="?page=enregistrer_modification&id=<?= $candidature->id ?>" 
    enctype="multipart/form-data" 
    class="mx-auto p-4 bg-white rounded shadow" 
    style="max-width: 600px;"
  >
    <!-- Champ texte pour le poste avec valeur pré-remplie -->
    <div class="mb-3">
      <label for="poste" class="form-label">Poste</label>
      <input 
        type="text" 
        class="form-control" 
        id="poste" 
        name="poste" 
        value="<?= htmlspecialchars($candidature->poste) ?>" 
        required
      >
    </div>

    <!-- Champ texte pour l'entreprise avec valeur pré-remplie -->
    <div class="mb-3">
      <label for="entreprise" class="form-label">Entreprise</label>
      <input 
        type="text" 
        class="form-control" 
        id="entreprise" 
        name="entreprise" 
        value="<?= htmlspecialchars($candidature->entreprise) ?>" 
        required
      >
    </div>

    <!-- Champ date avec valeur pré-remplie -->
    <div class="mb-3">
      <label for="date" class="form-label">Date</label>
      <input 
        type="date" 
        class="form-control" 
        id="date" 
        name="date" 
        value="<?= htmlspecialchars($candidature->date) ?>" 
        required
      >
    </div>

    <!-- Sélecteur pour le statut, sélection dynamique -->
    <div class="mb-3">
      <label for="statut" class="form-label">Statut</label>
      <select name="statut" id="statut" class="form-select" required>
        <?php
          // Tableau des statuts possibles
          $statuts = ['En attente', 'Entretien', 'Refusée', 'Acceptée', 'Relancée'];
          
          // Parcourt chaque statut pour créer une option sélectionnée si correspond au statut actuel
          foreach ($statuts as $statutOption) {
              $selected = ($candidature->statut === $statutOption) ? 'selected' : '';
              echo "<option value=\"$statutOption\" $selected>$statutOption</option>";
          }
        ?>
      </select>
    </div>

    <!-- Champ fichier pour le CV (optionnel) -->
    <div class="mb-3">
      <label for="cv" class="form-label">CV (optionnel)</label>
      <input 
        type="file" 
        name="cv" 
        id="cv" 
        accept=".pdf,.doc,.docx" 
        class="form-control"
      >
      <!-- Si un CV existe déjà, affiche un lien pour le consulter -->
      <?php if (!empty($candidature->cv)) : ?>
        <div class="mt-2">
          <span>CV actuel : </span>
          <a href="uploads/<?= htmlspecialchars($candidature->cv) ?>" target="_blank">📄 Voir</a>
        </div>
      <?php endif; ?>
    </div>

    <!-- Zone de texte pour les notes ou commentaires -->
    <div class="mb-3">
      <label for="notes" class="form-label">Notes / Commentaires</label>
      <textarea 
        name="notes" 
        id="notes" 
        class="form-control" 
        rows="4"
      ><?= htmlspecialchars($candidature->notes ?? '') ?></textarea>
    </div>

    <!-- Boutons d'action alignés horizontalement, espacement entre eux -->
    <div class="d-flex justify-content-between align-items-center mt-4">
      <!-- Bouton annuler qui renvoie à la liste des candidatures -->
      <a href="?page=candidatures" class="btn btn-outline-secondary">← Annuler</a>

      <!-- Bouton pour envoyer le formulaire -->
      <button type="submit" class="btn btn-primary">💾 Enregistrer</button>
    </div>
  </form>

<!-- Si la candidature n'existe pas, message d'erreur -->
<?php else : ?>
  <p class="alert alert-warning text-center mt-4">Candidature introuvable.</p>
<?php endif; ?>
