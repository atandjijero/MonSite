<?php
$dsn = "pgsql:host=" . getenv('DB_HOST') . ";port=" . getenv('DB_PORT') . ";dbname=" . getenv('DB_NAME');
$user = getenv('DB_USER');
$password = getenv('DB_PASSWORD');

try {
    $pdo = new PDO($dsn, $user, $password);
    echo "Connexion réussie à la base de données PostgreSQL !";
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
