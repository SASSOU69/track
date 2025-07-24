# Cette directive s'applique à tous les fichiers dont l'extension est .php, .php5, .phtml ou .phar
<FilesMatch "\.(php|php5|phtml|phar)$">

  # Interdit l'accès à ces fichiers via HTTP (le navigateur ne pourra pas les ouvrir ou exécuter)
  Deny from all

</FilesMatch>
