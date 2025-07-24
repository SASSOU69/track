<div class="container mt-5">
  <!-- Conteneur Bootstrap avec marge haute -->

  <div class="card mx-auto shadow p-4" style="max-width: 400px;">
    <!-- Carte Bootstrap centrée horizontalement avec ombre et padding, largeur max 400px -->

    <h2 class="text-center mb-4 text-primary">Connexion</h2>
    <!-- Titre de la carte, centré, marge en bas, texte en couleur primaire -->

    <?php if (!empty($error)) : ?>
      <!-- Si une erreur existe, affichage d'une alerte -->

      <div class="alert alert-danger text-center"><?= htmlspecialchars($error) ?></div>
      <!-- Message d'erreur sécurisé affiché au centre avec style danger -->
    <?php endif; ?>

    <form method="post">
      <!-- Formulaire d'envoi en POST -->

      <div class="mb-3">
        <!-- Marge en bas -->

        <label for="username" class="form-label">Nom d'utilisateur</label>
        <!-- Label associé au champ username -->

        <input type="text" class="form-control" name="username" id="username" required>
        <!-- Champ texte pour le nom d'utilisateur, obligatoire -->
      </div>

      <div class="mb-3">
        <!-- Marge en bas -->

        <label for="password" class="form-label">Mot de passe</label>
        <!-- Label associé au champ password -->

        <input type="password" class="form-control" name="password" id="password" required>
        <!-- Champ mot de passe masqué, obligatoire -->
      </div>

      <button type="submit" class="btn btn-primary w-100">🔐 Se connecter</button>
      <!-- Bouton de soumission, style Bootstrap primaire, largeur 100% -->
    </form>

    <div class="text-center mt-3">
      <!-- Bloc texte centré avec marge haute -->

      <a href="?page=register" class="text-decoration-none">Pas encore inscrit ? <strong>Créer un compte</strong></a>
      <!-- Lien vers la page d'inscription, sans soulignement, texte en gras -->
    </div>
  </div>
</div>
