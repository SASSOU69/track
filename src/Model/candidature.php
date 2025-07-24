<?php
// Déclare le namespace pour organiser les classes dans des dossiers spécifiques
namespace Model;

// Importe la classe PDO pour interagir avec la base de données
use PDO;

// Inclut le fichier Database.php qui contient la logique de connexion à la BDD
require_once 'Database.php';



// Déclaration de la classe Candidature
class Candidature
{
    // Déclaration des propriétés publiques correspondant aux colonnes de la table "candidatures"
    public $id;
    public $poste;
    public $entreprise;
    public $date;
    public $statut;
    public $cv;
    public $notes;

    // Constructeur pour créer une instance de Candidature
    public function __construct($id, $poste, $entreprise, $date, $statut = 'En attente', $cv = null, $notes = '')
    {
        $this->id = $id;
        $this->poste = $poste;
        $this->entreprise = $entreprise;
        $this->date = $date;
        $this->statut = $statut;
        $this->cv = $cv;
        $this->notes = $notes;
    }

    // Récupère toutes les entreprises distinctes (utile pour les filtres par entreprise)
    public static function getAllEntreprises(): array
    {
        $pdo = Database::getConnection();
        $stmt = $pdo->query("SELECT DISTINCT entreprise FROM candidatures ORDER BY entreprise ASC");
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    // Récupère toutes les candidatures avec filtres, recherche et tri
    public static function getAll($entrepriseFilter = '', $statutFilter = '', $search = '', $sort = 'date', $direction = 'desc')
    {
        $pdo = Database::getConnection();

        // Liste blanche des champs autorisés pour le tri
        $allowedSort = ['poste', 'entreprise', 'date', 'statut'];
        $allowedDir = ['asc', 'desc'];

        // Sécurisation du tri
        if (!in_array($sort, $allowedSort)) $sort = 'date';
        if (!in_array(strtolower($direction), $allowedDir)) $direction = 'desc';

        // Requête de base
        $query = "SELECT * FROM candidatures WHERE 1=1";
        $params = [];

        // Filtre entreprise
        if ($entrepriseFilter !== '') {
            $query .= " AND entreprise = ?";
            $params[] = $entrepriseFilter;
        }

        // Filtre statut
        if ($statutFilter !== '') {
            $query .= " AND statut = ?";
            $params[] = $statutFilter;
        }

        // Recherche mots-clés
        if ($search !== '') {
            $query .= " AND (poste LIKE ? OR entreprise LIKE ? OR notes LIKE ?)";
            $params[] = "%$search%";
            $params[] = "%$search%";
            $params[] = "%$search%";
        }

        // Ajout du tri
        $query .= " ORDER BY $sort $direction";

        // Préparation et exécution de la requête
        $stmt = $pdo->prepare($query);
        $stmt->execute($params);

        // Retourne les résultats sous forme d'objets
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
    
    public static function getStatutsDisponibles(): array
    {
        return ['En attente', 'Entretien', 'Refusée', 'Acceptée', 'Relancée'];
    }


  public static function rechercherParMotCle($motCle)
{
    $pdo = Database::getInstance();
    $stmt = $pdo->prepare("SELECT * FROM candidatures WHERE poste LIKE :motCle OR entreprise LIKE :motCle OR statut LIKE :motCle OR notes LIKE :motCle");
    $stmt->execute([
        'motCle' => '%' . $motCle . '%'
    ]);
    
    $resultats = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    $candidatures = [];
    foreach ($resultats as $row) {
        $candidatures[] = new Candidature(
            $row['id'],
            $row['poste'],
            $row['entreprise'],
            $row['date'],
            $row['statut'],
            $row['cv'] ?? null,
            $row['notes'] ?? ''
        );
    }

    return $candidatures;
}




    // Insère une nouvelle candidature dans la base de données
    public static function insert($poste, $entreprise, $date, $statut = 'En attente', $cv = null, $notes = '')
    {
        $pdo = Database::getConnection();

        // Insertion des données dans la table
        $stmt = $pdo->prepare("INSERT INTO candidatures (poste, entreprise, date, statut, cv, notes) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$poste, $entreprise, $date, $statut, $cv, $notes]);

        // Validation du statut (inutile ici car après insertion)
        $validStatuts = ['En attente', 'Entretien', 'Refusée', 'Acceptée', 'Relancée'];
        if (!in_array($statut, $validStatuts)) {
            $statut = 'En attente';
        }
    }

    // Trouve une candidature par son identifiant
    public static function findById($id): ?Candidature
    {
        $pdo = Database::getConnection();

        // Requête préparée pour sécuriser la recherche par ID
        $stmt = $pdo->prepare("SELECT * FROM candidatures WHERE id = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // Si une ligne est trouvée, on retourne une instance de Candidature
        if ($row) {
            return new Candidature(
                $row['id'],
                $row['poste'],
                $row['entreprise'],
                $row['date'],
                $row['statut'] ?? 'En attente',
                $row['cv'] ?? null,
                $row['notes'] ?? ''
            );
        }

        // Si aucune candidature trouvée, on retourne null
        return null;
    }

    // Met à jour une candidature existante
    public static function update($id, $poste, $entreprise, $date, $statut, $cv = null, $notes = '')
    {
        $pdo = Database::getConnection();

        // Si un nouveau CV est fourni, on met aussi à jour le champ "cv"
        if ($cv !== null) {
            $stmt = $pdo->prepare("UPDATE candidatures SET poste = ?, entreprise = ?, date = ?, statut = ?, cv = ?, notes = ? WHERE id = ?");
            $stmt->execute([$poste, $entreprise, $date, $statut, $cv, $notes, $id]);
        } else {
            // Sinon, on ne modifie pas le champ "cv"
            $stmt = $pdo->prepare("UPDATE candidatures SET poste = ?, entreprise = ?, date = ?, statut = ?, notes = ? WHERE id = ?");
            $stmt->execute([$poste, $entreprise, $date, $statut, $notes, $id]);
        }
    }

    // Supprime une candidature selon son ID
    public static function delete($id): bool
    {
        $pdo = Database::getConnection();

        // Suppression sécurisée avec requête préparée
        $stmt = $pdo->prepare("DELETE FROM candidatures WHERE id = ?");
        return $stmt->execute([$id]);
    }

    // Récupère des statistiques : nombre de candidatures par statut
    public static function getStatsByStatut()
    {
        $pdo = Database::getConnection();

        // Requête SQL groupée par statut
        $stmt = $pdo->query("
            SELECT statut, COUNT(*) as total
            FROM candidatures
            GROUP BY statut
        ");

        // Retourne les résultats sous forme de tableau associatif
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
