<?php
// Déclare le namespace "Utils" pour organiser cette classe dans un dossier utilitaire
namespace Utils;

// Importe les classes PHPMailer nécessaires
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Charge automatiquement toutes les classes via Composer (nécessaire pour PHPMailer)
require_once __DIR__ . '/../../vendor/autoload.php';

// Déclaration de la classe Mailer, qui permet d'envoyer des emails via SMTP
class Mailer
{
    // Propriété privée pour l'objet PHPMailer
    private $mail;

    // Propriété privée pour stocker la configuration SMTP (hôte, port, identifiants, etc.)
    private $config;

    // Constructeur de la classe, reçoit un tableau associatif de configuration SMTP
    public function __construct(array $config)
    {
        // Stocke la configuration dans la propriété privée
        $this->config = $config;

        // Initialise un nouvel objet PHPMailer avec gestion des exceptions
        $this->mail = new PHPMailer(true);

        // Configure PHPMailer pour utiliser SMTP
        $this->mail->isSMTP();

        // Définit le serveur SMTP à utiliser (ex : smtp.gmail.com)
        $this->mail->Host = $config['host'];

        // Active l’authentification SMTP
        $this->mail->SMTPAuth = true;

        // Définit le nom d'utilisateur SMTP (adresse e-mail de l'expéditeur)
        $this->mail->Username = $config['username'];

        // Définit le mot de passe SMTP
        $this->mail->Password = $config['password'];

        // Définit le type de chiffrement (tls ou ssl)
        $this->mail->SMTPSecure = $config['encryption'];

        // Définit le port SMTP (587 pour TLS, 465 pour SSL en général)
        $this->mail->Port = $config['port'];

        // Définit l'adresse e-mail et le nom de l'expéditeur
        $this->mail->setFrom($config['from_email'], $config['from_name']);
    }

    // Méthode publique pour envoyer un e-mail
    public function send(string $toEmail, string $toName, string $subject, string $body): bool
    {
        try {
            // Supprime les anciennes adresses (au cas où le même objet serait réutilisé)
            $this->mail->clearAddresses();

            // Ajoute le destinataire avec son e-mail et son nom
            $this->mail->addAddress($toEmail, $toName);

            // Indique que le contenu de l'e-mail est au format HTML
            $this->mail->isHTML(true);

            // Définit le sujet de l'e-mail
            $this->mail->Subject = $subject;

            // Définit le corps du message (HTML autorisé)
            $this->mail->Body = $body;

            // Envoie l'e-mail et retourne true si l'envoi réussit
            return $this->mail->send();
        } catch (Exception $e) {
            // En cas d'erreur, enregistre un message dans le journal système
            error_log("Mailer Error: " . $this->mail->ErrorInfo);

            // Retourne false pour indiquer l'échec de l'envoi
            return false;
        }
    }
}
