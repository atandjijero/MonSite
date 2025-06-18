<?php
include("connexion.php");

$nom = htmlspecialchars($_POST['nom']);
$matricule = htmlspecialchars($_POST['matricule']);
$filiere_id = intval($_POST['filiere_id']);
$query_filiere = "SELECT id FROM filieres WHERE id = $1";
$result_filiere = pg_query_params($conn, $query_filiere, [$filiere_id]);

if (!$result_filiere || pg_num_rows($result_filiere) == 0) {
    die("<p class='alert alert-danger text-center'>Erreur : Filière non trouvée.</p>");
}
$query_check = "SELECT matricule FROM etudiants WHERE matricule = $1";
$result_check = pg_query_params($conn, $query_check, [$matricule]);

if ($result_check && pg_num_rows($result_check) > 0) {
    die("<p class='alert alert-danger text-center'>Erreur : Matricule déjà utilisé.</p>");
}
$query_insert = "INSERT INTO etudiants (matricule, nom, filiere_id) VALUES ($1, $2, $3)";
$result_insert = pg_query_params($conn, $query_insert, [$matricule, $nom, $filiere_id]);

if ($result_insert) {
    echo "<p class='alert alert-success text-center'>Étudiant ajouté avec succès !</p>";
} else {
    echo "<p class='alert alert-danger text-center'>Erreur lors de l'ajout.</p>";
}
?>