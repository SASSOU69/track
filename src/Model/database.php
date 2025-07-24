<?php
// Déclare le namespace de la classe (Model) pour organiser le code dans un dossier spécifique
namespace Model;

// Importe la classe PDO (accès à la base de données) et PDOException (gestion des erreurs)
use PDO;
use PDOException;

// Déclaration de la classe Database qui va gérer la connexion à la base de données
class Database
{
    public static function getInstance()
    {
        static $pdo = null;
        if ($pdo === null) {
            $pdo = new PDO('mysql:host=localhost;dbname=tracker;charset=utf8', 'root', '');
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        return $pdo;
    }
    // Propriété statique qui stockera l'instance unique de connexion PDO (singleton)
    private static $pdo;

    // Méthode statique pour récupérer ou créer la connexion à la base de données
    public static function getConnection()
    {
        // Vérifie si une connexion existe déjà
        if (self::$pdo === null) {
            try {
                // Si non, on crée une nouvelle connexion PDO avec les paramètres suivants :
                self::$pdo = new PDO(
                    'mysql:host=localhost;dbname=tracker;charset=utf8', // Adresse du serveur + nom de la base + encodage
                    'root',     // Nom d'utilisateur MySQL (par défaut 'root' sur WAMP)
                    ''          // Mot de passe MySQL (souvent vide sur WAMP)
                );

                // Configure PDO pour qu’il lève des exceptions en cas d’erreur SQL
                self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                // Si une erreur de connexion survient, on relance une exception personnalisée
                throw new \Exception('Erreur de connexion DB : ' . $e->getMessage());
            }
        }

        // Retourne l'objet PDO (soit nouvellement créé, soit déjà existant)
        return self::$pdo;
    }
}
