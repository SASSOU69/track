<!-- Début de la barre de navigation avec Bootstrap -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark px-4">
  <!-- Logo ou nom du site avec un lien vers la page d'accueil -->
  <a class="navbar-brand" href="?page=home">Tracker</a>

  <!-- Bouton de menu pour les petits écrans (responsive) -->
  <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
    <!-- Icône du menu burger -->
    <span class="navbar-toggler-icon"></span>
  </button>

  <!-- Contenu du menu qui se replie/collapse sur mobile -->
  <div class="collapse navbar-collapse" id="navbarNav">

    <!-- Liste de gauche : liens de navigation principaux -->
    <ul class="navbar-nav me-auto">

      <!-- Lien Accueil -->
      <li class="nav-item">
        <!-- Ajout de la classe "active" dynamiquement si la page actuelle est "home" -->
        <a class="nav-link <?= ($_GET['page'] ?? '') === 'home' ? 'active' : '' ?>" href="?page=home">Accueil</a>
      </li>

      <!-- Lien Mes candidatures -->
      <li class="nav-item">
        <!-- Classe active si la page actuelle est "candidatures" -->
        <a class="nav-link <?= ($_GET['page'] ?? '') === 'candidatures' ? 'active' : '' ?>" href="?page=candidatures">Mes candidatures</a>
      </li>

      <!-- Lien Ajouter une candidature -->
      <li class="nav-item">
        <!-- Classe active si la page actuelle est "ajouter" -->
        <a class="nav-link <?= ($_GET['page'] ?? '') === 'ajouter' ? 'active' : '' ?>" href="?page=ajouter">Ajouter</a>
      </li>

      <!-- Lien Dashboard -->
      <li class="nav-item">
        <!-- Classe active si la page actuelle est "dashboard" -->
        <a class="nav-link <?= ($_GET['page'] ?? '') === 'dashboard' ? 'active' : '' ?>" href="?page=dashboard">Dashboard</a>
      </li>
    </ul>

    <!-- Liste de droite : bouton de déconnexion -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <!-- Bouton rouge pour déconnexion -->
        <a class="nav-link text-danger" href="?page=logout">Déconnexion</a>
      </li>
    </ul>

  </div>
</nav>
