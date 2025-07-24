<?php
// Déclare le namespace "Model" pour organiser les classes dans un dossier spécifique
namespace Model;

// Inclut le fichier Database.php (situé dans le même dossier) pour pouvoir se connecter à la base de données
require_once __DIR__ . '/Database.php';

// Déclaration de la classe User, qui représente un utilisateur dans l'application
class User
{
    // Déclaration des propriétés publiques de l'utilisateur
    public $id;         // Identifiant de l'utilisateur
    public $username;   // Nom d'utilisateur (login)
    public $password;   // Mot de passe (hashé)

    // Méthode statique qui permet de rechercher un utilisateur par son nom d'utilisateur
    public static function findByUsername(string $username)
    {
        // Récupère une instance PDO de connexion à la base de données
        $pdo = Database::getConnection();

        // Prépare une requête SQL pour chercher un utilisateur avec ce nom
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
        
        // Exécute la requête en liant le nom d'utilisateur à l'emplacement du ?
        $stmt->execute([$username]);

        // Récupère la première ligne de résultat
        $row = $stmt->fetch();

        // Si une ligne est trouvée (utilisateur existant)
        if ($row) {
            // Crée un nouvel objet User
            $user = new self();

            // Remplit ses propriétés à partir des données récupérées
            $user->id = $row['id'];
            $user->username = $row['username'];
            $user->password = $row['password'];

            // Retourne l'objet User
            return $user;
        }

        // Si aucun utilisateur trouvé, retourne null
        return null;
    }

    // Méthode statique pour insérer un nouvel utilisateur dans la base de données
    public static function insert(string $username, string $passwordHash): bool
    {
        // Récupère une connexion PDO
        $pdo = Database::getConnection();

        // Prépare une requête SQL d'insertion d'un nouvel utilisateur
        $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");

        // Exécute la requête avec les données fournies
        return $stmt->execute([$username, $passwordHash]);
    }
}
