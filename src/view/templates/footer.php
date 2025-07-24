<!-- Début du pied de page avec les classes Bootstrap pour le style -->
<footer class="bg-dark text-white text-center py-4 mt-auto">
  <!-- Conteneur Bootstrap pour centrer et encadrer le contenu -->
  <div class="container">

    <!-- Paragraphe avec une petite marge en bas et affichage de l’année actuelle dynamiquement -->
    <p class="mb-1">
      &copy; <?= date('Y') ?> Tracker de candidatures — Tous droits réservés
      <!-- &copy; = symbole copyright, <?= date('Y') ?> = affiche l’année en cours -->
    </p>

    <!-- Lien vers ton profil GitHub avec une marge en bas nulle -->
    <p class="mb-0">
      <a href="https://github.com/sassou69" target="_blank" class="text-white text-decoration-underline">
        Voir le code sur GitHub
        <!-- Lien qui s’ouvre dans un nouvel onglet, en blanc et souligné -->
      </a>
    </p>

  </div>
</footer>
