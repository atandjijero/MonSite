<?php
$conn = pg_connect("host=localhost dbname=resultat user=jd password=jd");

if (!$conn) {
die("Pas de connexion à postgres");
}
?>
