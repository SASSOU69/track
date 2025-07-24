<h1>Créer un compte</h1>
<!-- Titre principal de la page -->

<?php if (!empty($error)) : ?>
  <!-- Si une erreur est définie, on l'affiche -->

  <div class="flash-message flash-error"><?= htmlspecialchars($error) ?></div>
  <!-- Message d'erreur sécurisé avec une classe CSS spécifique -->
<?php endif; ?>

<form method="post" class="form-candidature">
  <!-- Formulaire d'inscription envoyé en POST avec une classe personnalisée -->

  <div class="form-group">
    <!-- Groupe de champ du formulaire -->

    <label for="username">Nom d'utilisateur</label>
    <!-- Label lié au champ username -->

    <input type="text" name="username" id="username" required>
    <!-- Champ texte obligatoire pour le nom d'utilisateur -->
  </div>

  <div class="form-group">
    <!-- Groupe de champ du formulaire -->

    <label for="password">Mot de passe</label>
    <!-- Label lié au champ password -->

    <input type="password" name="password" id="password" required>
    <!-- Champ mot de passe obligatoire, masque les caractères -->
  </div>

  <button type="submit" class="btn-submit">S'inscrire</button>
  <!-- Bouton de soumission avec classe personnalisée -->
</form>

<div class="back-link">
  <!-- Section lien pour revenir à la page de connexion -->

  <a href="?page=login">Déjà un compte ? Se connecter</a>
  <!-- Lien vers la page de connexion -->
</div>
