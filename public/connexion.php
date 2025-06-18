<?php
// Lecture des variables d’environnement
$host = getenv("DB_HOST");
$dbname = getenv("DB_NAME");
$user = getenv("DB_USER");
$password = getenv("DB_PASSWORD");

// Vérification rapide avant de tenter la connexion
if (!$host || !$dbname || !$user || !$password) {
    die("⚠️ Une ou plusieurs variables d’environnement sont manquantes !");
}

// Tentative de connexion
$conn = pg_connect("host=$host dbname=$dbname user=$user password=$password port=5432 sslmode=require");

if (!$conn) {
    die("❌ Échec de la connexion à PostgreSQL");
}
?>