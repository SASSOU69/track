<!DOCTYPE html>
<html lang="fr"> <!-- Déclaration du type de document et langue en français -->

<head>
  <meta charset="UTF-8"> <!-- Encodage des caractères UTF-8 -->
  <meta name="viewport" content="width=device-width, initial-scale=1"> <!-- Responsive : largeur = largeur écran, zoom initial 1 -->
  <title><?= $title ?? 'Tracker de candidatures' ?></title> <!-- Titre dynamique de la page ou titre par défaut -->

  <!-- Intégration de la feuille de style Bootstrap via CDN -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Intégration des icônes Bootstrap -->
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">


  <!-- Lien vers ta feuille de style CSS personnalisée -->
  <link rel="stylesheet" href="<?= BASE_URL ?>/css/style.css">
</head>

<body class="d-flex flex-column min-vh-100"> <!-- Body avec display flex en colonne et hauteur minimum 100vh -->

  <!-- Header avec fond sombre et texte blanc, padding vertical -->
  <header class="bg-dark text-white py-3">
    <?php require __DIR__ . '/templates/header.php'; ?> <!-- Inclusion du template header -->
  </header>

  <!-- Zone d'affichage des messages flash (alertes de succès) -->
  <?php if (!empty($_SESSION['flash'])) : ?>
    <div class="container mt-3"> <!-- Conteneur Bootstrap avec marge en haut -->
      <div class="alert alert-success alert-dismissible fade show" role="alert"> <!-- Alert Bootstrap avec bouton de fermeture -->
        <?= $_SESSION['flash'] ?> <!-- Contenu du message flash -->
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button> <!-- Bouton fermeture alerte -->
      </div>
      <?php unset($_SESSION['flash']); ?> <!-- Suppression du message flash après affichage -->
    </div>
  <?php endif; ?>

  <!-- Contenu principal de la page -->
  <main class="container py-4 flex-grow-1">
    <?php include $view; ?> <!-- Inclusion dynamique de la vue demandée -->
  </main>

  <!-- Pied de page avec fond clair, texte centré, padding vertical, bordure en haut, et position auto en bas -->
  <footer class="bg-light text-center py-3 border-top mt-auto">
    <?php require __DIR__ . '/templates/footer.php'; ?> <!-- Inclusion du template footer -->
  </footer>

  <!-- Scripts JS -->

  <!-- Ton script JS personnalisé chargé en différé -->
  <script src="<?= BASE_URL ?>/js/main.js" defer></script>

  <!-- Bundle JS Bootstrap avec Popper via CDN -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>