<?php
// Ce fichier retourne un tableau associatif contenant les paramètres de configuration SMTP
return [
    // Adresse du serveur SMTP utilisé pour l'envoi des emails
    'host' => 'smtp.exemple.com', // Exemple : smtp.gmail.com pour Gmail

    // Nom d'utilisateur du compte email (souvent l'adresse email)
    'username' => 'ton-email@example.com',

    // Mot de passe du compte email utilisé pour se connecter au serveur SMTP
    'password' => 'ton-motdepasse',

    // Port utilisé pour la connexion SMTP
    // 587 pour TLS, 465 pour SSL, 25 parfois utilisé sans chiffrement
    'port' => 587,

    // Type de chiffrement utilisé pour sécuriser la connexion
    // "tls" ou "ssl" selon les exigences du fournisseur SMTP
    'encryption' => 'tls',

    // Adresse email qui apparaîtra comme expéditeur du message
    'from_email' => 'ton-email@example.com',

    // Nom qui apparaîtra comme expéditeur (ex : nom de ton application ou site)
    'from_name' => 'Tracker Candidatures',

    // Adresse email du destinataire principal (à personnaliser ou à générer dynamiquement)
    // Ici, c'est une valeur par défaut, utile pour les tests ou pour centraliser les envois
    'to_email' => 'ton-email@example.com',
];
