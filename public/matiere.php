<?php
include("connexion.php");

$nom_matiere = htmlspecialchars($_POST['nom_matiere']);
$filiere_id = intval($_POST['filiere_id']);
$query_filiere = "SELECT id FROM filieres WHERE id = $1";
$result_filiere = pg_query_params($conn, $query_filiere, [$filiere_id]);

if (!$result_filiere || pg_num_rows($result_filiere) == 0) {
    die("<p class='alert alert-danger text-center'>Erreur : Filière non trouvée.</p>");
}
$query_check = "SELECT id FROM matieres WHERE nom_matiere = $1 AND filiere_id = $2";
$result_check = pg_query_params($conn, $query_check, [$nom_matiere, $filiere_id]);

if ($result_check && pg_num_rows($result_check) > 0) {
    die("<p class='alert alert-danger text-center'>Erreur : Cette matière existe déjà pour cette filière.</p>");
}
$query_insert = "INSERT INTO matieres (nom_matiere, filiere_id) VALUES ($1, $2)";
$result_insert = pg_query_params($conn, $query_insert, [$nom_matiere, $filiere_id]);

if ($result_insert) {
    echo "<p class='alert alert-success text-center'>Matière ajoutée avec succès !</p>";
} else {
    echo "<p class='alert alert-danger text-center'>Erreur lors de l'ajout.</p>";
}
?>