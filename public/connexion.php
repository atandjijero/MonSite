<?php
$conn = pg_connect(getenv("DATABASE_URL"));

if (!$conn) {
  die("Échec de la connexion à PostgreSQL 😞");
}
?>