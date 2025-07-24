<?php

// Déclaration du namespace du contrôleur
namespace Controller;

// Importation des classes nécessaires
use Model\Candidature;
use Model\User;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


// Inclusion manuelle des fichiers de classes
require_once __DIR__ . '/../Model/candidature.php';
require_once __DIR__ . '/../Model/user.php';
require __DIR__ . '/../../vendor/autoload.php'; // Autoload de Composer pour PHPMailer

// Définition de la classe principale du contrôleur
class ApplicationController
{
    // Constructeur : vérifie si l'utilisateur est connecté sauf pour login et register
    public function __construct()
    {
        $page = $_GET['page'] ?? ''; // Récupération de la page demandée (ou chaîne vide par défaut)

        // Redirection vers la page de login si l'utilisateur n'est pas connecté
        if (!in_array($page, ['login', 'register', 'recherche']) && !isset($_SESSION['user'])) {
            header('Location: ?page=login');
            exit;
        }
    }

    // Affiche la page d'accueil
    public function home()
    {
        $candidatures = Candidature::getAll(); // Récupère toutes les candidatures
        $nbCandidatures = count($candidatures); // Compte le nombre de candidatures

        $title = 'Accueil'; // Titre de la page
        $view = __DIR__ . '/../View/home.php'; // Fichier de vue
        include __DIR__ . '/../View/layout.php'; // Inclusion du layout principal
    }

    // Liste les candidatures avec filtres et tri
  public function listCandidatures()
{
    // Récupération des filtres GET sécurisée
    $entrepriseFilter = $_GET['entreprise'] ?? '';
    $statutFilter = $_GET['statut'] ?? '';
    $search = trim($_GET['search'] ?? '');

    $sort = $_GET['sort'] ?? 'date';
    $direction = $_GET['direction'] ?? 'desc';

    // On récupère la liste des entreprises distinctes (pour un filtre par exemple)
    $entreprises = \Model\Candidature::getAllEntreprises();

    // Récupération des candidatures avec filtres et tri
    $candidatures = \Model\Candidature::getAll($entrepriseFilter, $statutFilter, $search, $sort, $direction);

    // Statuts disponibles (pour affichage dans filtre)
    $statutsDisponibles = Candidature::getStatutsDisponibles();

    $title = 'Mes candidatures';
    $view = __DIR__ . '/../View/candidatures.php';
    include __DIR__ . '/../View/layout.php';
}
public function recherche()
{
    $motCle = trim($_GET['q'] ?? '');
 error_log("Recherche AJAX appelée avec motCle: $motCle"); // log dans error_log
    // Appelle ta méthode modèle qui fait la recherche (à créer ou adapter)
    $candidatures = Candidature::rechercherParMotCle($motCle);

    // Inclut uniquement la vue partielle (ton tableau-candidature.php)
include __DIR__ . '/../View/includes/partials/tableau-candidatures.php';


        exit; // stoppe tout pour s'assurer qu'on ne renvoie rien d'autre
}


    // Affiche le formulaire d'ajout de candidature
    public function addCandidature()
    {
        $title = 'Ajouter une candidature';
        $view = __DIR__ . '/../View/add_candidature.php';
        include __DIR__ . '/../View/layout.php';
    }

    // Traite l'ajout d'une nouvelle candidature
    public function enregistrerCandidature()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $poste = $_POST['poste'] ?? '';
            $entreprise = $_POST['entreprise'] ?? '';
            $date = $_POST['date'] ?? date('Y-m-d');
            $statut = $_POST['statut'] ?? 'En attente';
            $notes = $_POST['notes'] ?? '';

            $cvFilename = null;

            // Traitement de l'upload de CV
            if (isset($_FILES['cv']) && $_FILES['cv']['error'] === UPLOAD_ERR_OK) {
                $allowedExtensions = ['pdf', 'doc', 'docx'];
                $fileInfo = pathinfo($_FILES['cv']['name']);
                $extension = strtolower($fileInfo['extension']);
                $maxFileSize = 5 * 1024 * 1024; // 5 Mo

                if (in_array($extension, $allowedExtensions) && $_FILES['cv']['size'] <= $maxFileSize) {
                    $tmpName = $_FILES['cv']['tmp_name'];
                    $cvFilename = uniqid() . '-' . basename($_FILES['cv']['name']);
                    $destination = __DIR__ . '/../../public/uploads/' . $cvFilename;

                    if (!move_uploaded_file($tmpName, $destination)) {
                        $_SESSION['flash'] = "Erreur lors de l'upload du fichier.";
                        header('Location: ?page=ajouter');
                        exit;
                    }
                } else {
                    $_SESSION['flash'] = "Fichier non autorisé ou trop volumineux (max 5 Mo).";
                    header('Location: ?page=ajouter');
                    exit;
                }
            }

            // Insertion en base
            Candidature::insert($poste, $entreprise, $date, $statut, $cvFilename, $notes);

            // Envoi d'e-mail de notification (optionnel)
            $this->envoyerMailCandidature($poste, $entreprise, $date, $statut);

            $_SESSION['flash'] = "Candidature ajoutée avec succès.";
            header('Location: ?page=candidatures');
            exit;
        }

        header('Location: ?page=ajouter');
        exit;
    }

    // Affiche le formulaire de modification d'une candidature
    public function modifierCandidature()
    {
        $id = $_GET['id'] ?? null;

        if (!$id) {
            header('Location: ?page=candidatures');
            exit;
        }

        $candidature = Candidature::findById($id);

        if (!$candidature) {
            $_SESSION['flash'] = "Candidature introuvable.";
            header('Location: ?page=candidatures');
            exit;
        }

        $title = 'Modifier une candidature';
        $view = __DIR__ . '/../View/edit_candidature.php';
        include __DIR__ . '/../View/layout.php';
    }

    // Traite la modification d'une candidature
    public function enregistrerModification()
    {
        $id = $_GET['id'] ?? null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $id) {
            $poste = $_POST['poste'] ?? '';
            $entreprise = $_POST['entreprise'] ?? '';
            $date = $_POST['date'] ?? '';
            $statut = $_POST['statut'] ?? 'En attente';
            $notes = $_POST['notes'] ?? '';

            $candidature = Candidature::findById($id);
            $cvFilename = $candidature->cv ?? null;

            // Upload d'un nouveau CV (optionnel)
            if (isset($_FILES['cv']) && $_FILES['cv']['error'] === UPLOAD_ERR_OK) {
                $allowedExtensions = ['pdf', 'doc', 'docx'];
                $fileInfo = pathinfo($_FILES['cv']['name']);
                $extension = strtolower($fileInfo['extension']);
                $maxFileSize = 5 * 1024 * 1024;

                if (in_array($extension, $allowedExtensions) && $_FILES['cv']['size'] <= $maxFileSize) {
                    $tmpName = $_FILES['cv']['tmp_name'];
                    $newFilename = uniqid() . '-' . basename($_FILES['cv']['name']);
                    $destination = __DIR__ . '/../../public/uploads/' . $newFilename;

                    if (move_uploaded_file($tmpName, $destination)) {
                        // Supprime l'ancien CV
                        if ($cvFilename && file_exists(__DIR__ . '/../../public/uploads/' . $cvFilename)) {
                            unlink(__DIR__ . '/../../public/uploads/' . $cvFilename);
                        }
                        $cvFilename = $newFilename;
                    } else {
                        $_SESSION['flash'] = "Erreur lors de l'upload du fichier.";
                        header('Location: ?page=modifier&id=' . $id);
                        exit;
                    }
                } else {
                    $_SESSION['flash'] = "Fichier non autorisé ou trop volumineux (max 5 Mo).";
                    header('Location: ?page=modifier&id=' . $id);
                    exit;
                }
            }

            Candidature::update($id, $poste, $entreprise, $date, $statut, $cvFilename, $notes);

            $_SESSION['flash'] = "Candidature modifiée avec succès.";
            header('Location: ?page=candidatures');
            exit;
        }

        header('Location: ?page=candidatures');
        exit;
    }

    // Supprime une candidature
    public function supprimerCandidature()
    {
        $id = $_GET['id'] ?? null;

        if ($id) {
            Candidature::delete($id);
            $_SESSION['flash'] = "Candidature supprimée.";
        }

        header('Location: ?page=candidatures');
        exit;
    }

    // Affiche et gère le formulaire d'inscription
    public function register()
    {
        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? '');
            $password = $_POST['password'] ?? '';

            if ($username === '' || $password === '') {
                $error = "Tous les champs sont obligatoires.";
            } elseif (User::findByUsername($username)) {
                $error = "Ce nom d'utilisateur est déjà utilisé.";
            } else {
                $hashedPassword = password_hash($password, PASSWORD_BCRYPT); // Hachage du mot de passe
                $success = User::insert($username, $hashedPassword);

                if ($success) {
                    $_SESSION['user'] = $username;
                    header('Location: ?page=candidatures');
                    exit;
                } else {
                    $error = "Erreur lors de l'inscription, veuillez réessayer.";
                }
            }
        }

        $title = "Inscription";
        $view = __DIR__ . '/../View/register.php';
        include __DIR__ . '/../View/layout.php';
    }

    // Gère la connexion de l'utilisateur
    public function login()
    {
        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';

            $user = User::findByUsername($username);

            if ($user && password_verify($password, $user->password)) {
                $_SESSION['user'] = $user->username;
                header('Location: ?page=candidatures');
                exit;
            } else {
                $error = "Nom d'utilisateur ou mot de passe incorrect.";
            }
        }

        $title = 'Connexion';
        $view = __DIR__ . '/../View/login.php';
        include __DIR__ . '/../View/layout.php';
    }

    // Déconnecte l'utilisateur
    public function logout()
    {
        
        session_destroy(); // Supprime toutes les données de session
        header('Location: ?page=home');
        exit;
    }

    // Envoie un e-mail lorsqu'une candidature est ajoutée (optionnel)
    private function envoyerMailCandidature($poste, $entreprise, $date, $statut)
    {
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.exemple.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'ton-email@exemple.com';
            $mail->Password = 'ton-mot-de-passe';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom('ton-email@exemple.com', 'Tracker Candidatures');
            $mail->addAddress('ton-email@exemple.com', 'Administrateur');

            $mail->isHTML(true);
            $mail->Subject = 'Nouvelle candidature ajoutée';
            $mail->Body = "
                <h3>Nouvelle candidature ajoutée</h3>
                <p><strong>Poste :</strong> $poste</p>
                <p><strong>Entreprise :</strong> $entreprise</p>
                <p><strong>Date :</strong> $date</p>
                <p><strong>Statut :</strong> $statut</p>
            ";

            $mail->send();
        } catch (Exception $e) {
            error_log("Erreur mail : " . $mail->ErrorInfo);
        }
    }

    // Affiche le tableau de bord avec statistiques
    public function dashboard()
    {
        $stats = Candidature::getStatsByStatut(); // Récupère des stats groupées par statut

        $title = 'Dashboard';
        $view = __DIR__ . '/../View/dashboard.php';

        include __DIR__ . '/../View/layout.php';
    }
}
