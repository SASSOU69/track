<?php if (empty($candidatures)) : ?>
  <!-- Si le tableau $candidatures est vide, on affiche un message d'alerte Bootstrap -->
  <div class="alert alert-warning">Aucune candidature trouvée.</div>
<?php else : ?>
  <!-- Sinon, on affiche le tableau avec les résultats -->
  <div class="table-responsive">
    <!-- Tableau Bootstrap avec bordures et alignement vertical centré -->
    <table class="table table-bordered align-middle">
      <thead class="table-light">
        <tr>
          <th>Poste</th>
          <th>Entreprise</th>
          <th>Date</th>
          <th>Statut</th>
          <th>Notes</th>
          <th class="text-center">Actions</th>
        </tr>
      </thead>
      <tbody>
        <!-- Boucle sur chaque objet $candidature pour afficher une ligne du tableau -->
        <?php foreach ($candidatures as $candidature) : ?>
          <tr>
            <!-- Affichage sécurisé du poste -->
            <td><?= htmlspecialchars($candidature->poste) ?></td>

            <!-- Affichage sécurisé de l'entreprise -->
            <td><?= htmlspecialchars($candidature->entreprise) ?></td>

            <!-- Affichage sécurisé de la date (option : tu peux formater en jj/mm/aaaa si tu veux) -->
            <td><?= htmlspecialchars($candidature->date) ?></td>

            <td>
              <?php
              // On récupère le statut de la candidature
              $statut = $candidature->statut;

              // On attribue une classe Bootstrap selon le statut
              $class = match ($statut) {
                'Acceptée'   => 'success',   // vert
                'En attente' => 'primary',   // bleu
                'Refusée'    => 'danger',    // rouge
                default      => 'secondary'  // gris si autre
              };
              ?>
              <!-- Badge Bootstrap coloré selon le statut -->
              <span class="badge bg-<?= $class ?>">
                <?= htmlspecialchars($statut) ?>
              </span>
            </td>

            <!-- Affichage des notes, sécurisé et avec retour à la ligne via nl2br -->
            <td><?= nl2br(htmlspecialchars($candidature->notes ?? '—')) ?></td>

            <td class="text-center">
              <!-- Lien vers la modification de la candidature avec icône ✏️ -->
              <a href="index.php?page=modifier&id=<?= $candidature->id ?>"
                class="text-warning me-2" title="Modifier">
                🖉
              </a>

              <!-- Lien vers la suppression, avec confirmation JS et icône 🗑️ -->
              <a href="index.php?page=supprimer&id=<?= $candidature->id ?>"
                class="text-danger" title="Supprimer"
                onclick="return confirm('Confirmer la suppression ?');">
                🗑️
              </a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
<?php endif; ?>