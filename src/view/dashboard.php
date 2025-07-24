<!-- Conteneur principal avec padding vertical et classe personnalisée pour le graphique -->
<div class="container py-5 chart-container">

  <!-- Titre principal centré avec marge en bas -->
  <h1 class="mb-4 text-center">Statistiques des candidatures</h1>

  <!-- Formulaire de filtrage par mois -->
  <form method="GET" class="mb-4 d-flex justify-content-center">
    <!-- Champ caché pour conserver la page "dashboard" lors de la soumission -->
    <input type="hidden" name="page" value="dashboard">

    <!-- Label du filtre mois avec marge à droite -->
    <label for="mois" class="me-2">Filtrer par mois :</label>

    <!-- Sélecteur mois, largeur automatique -->
    <select name="mois" id="mois" onchange="this.form.submit()" class="form-select w-auto">
      <!-- Option par défaut pour ne filtrer aucun mois -->
      <option value="">Tous les mois</option>

      <!-- Boucle PHP pour générer chaque mois -->
      <?php for ($i = 1; $i <= 12; $i++): ?>
        <option value="<?= $i ?>" <?= (isset($_GET['mois']) && $_GET['mois'] == $i) ? 'selected' : '' ?>>
          <?= strftime('%B', mktime(0, 0, 0, $i, 1)) /* Nom complet du mois en cours de la boucle */ ?>
        </option>
      <?php endfor; ?>
    </select>
  </form>

  <!-- Ligne Bootstrap pour contenir les deux graphiques -->
  <div class="row">

    <!-- Graphique à barres dans une colonne de taille md-6 avec marge en bas -->
    <div class="col-md-6 mb-4">
      <!-- Titre du graphique centré -->
      <h5 class="text-center">Candidatures par statut</h5>
      <!-- Canvas pour afficher le graphique barres -->
      <canvas id="statutChart" style="height: 300px;"></canvas>
    </div>

    <!-- Graphique camembert dans une autre colonne -->
    <div class="col-md-6 mb-4">
      <!-- Titre centré -->
      <h5 class="text-center">Répartition des candidatures</h5>
      <!-- Canvas pour afficher le graphique camembert -->
      <canvas id="pieChart" style="height: 300px;"></canvas>
    </div>

  </div>

  <!-- Intégration de la librairie Chart.js depuis un CDN -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <script>
    // Récupération des labels (statuts) depuis PHP au format JSON
    const labels = <?= json_encode(array_column($stats, 'statut')) ?>;

    // Récupération des valeurs (nombre total) en entier
    const dataValues = <?= json_encode(array_map('intval', array_column($stats, 'total'))) ?>;

    // Couleurs personnalisées pour les barres et parts du camembert
    const colors = ['#007bff', '#ffc107', '#28a745', '#dc3545', '#6f42c1'];

    // Configuration et création du graphique à barres
    new Chart(document.getElementById('statutChart').getContext('2d'), {
      type: 'bar', // Type de graphique
      data: {
        labels: labels, // Les statuts en abscisses
        datasets: [{
          label: 'Nombre de candidatures', // Légende du dataset
          data: dataValues, // Valeurs pour chaque statut
          backgroundColor: colors, // Couleurs des barres
          borderWidth: 1 // Largeur de bordure des barres
        }]
      },
      options: {
        responsive: true, // Graphique responsive
        maintainAspectRatio: false, // Ne pas maintenir le ratio fixe (permet de fixer la hauteur)
        scales: {
          y: {
            beginAtZero: true, // L'axe Y commence à 0
            ticks: { stepSize: 1 }, // Pas d'incrémentation 1 par 1
            title: { display: true, text: 'Nombre' } // Titre axe Y
          },
          x: {
            title: { display: true, text: 'Statut' } // Titre axe X
          }
        },
        plugins: {
          legend: { display: false }, // Pas de légende affichée
          title: { display: false } // Pas de titre du graphique
        }
      }
    });

    // Configuration et création du graphique camembert
    new Chart(document.getElementById('pieChart').getContext('2d'), {
      type: 'pie', // Type camembert
      data: {
        labels: labels, // Statuts en légende
        datasets: [{
          data: dataValues, // Valeurs
          backgroundColor: colors, // Couleurs
          borderWidth: 1 // Bordure
        }]
      },
      options: {
        responsive: true,
        plugins: {
          legend: { position: 'top' }, // Légende en haut
          title: { display: false } // Pas de titre
        }
      }
    });

    // Cette ligne semble être un oubli ou une erreur, peut être supprimée :
    // new Chart(ctx, config);
  </script>

</div>
