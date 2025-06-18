<?php
include("connexion.php");

$nom_filiere = htmlspecialchars($_POST['nom_filiere']);


$query_check = "SELECT id FROM filieres WHERE nom_filiere = $1";
$result_check = pg_query_params($conn, $query_check, [$nom_filiere]);

if ($result_check && pg_num_rows($result_check) > 0) {
    die("<p class='alert alert-danger text-center'>Erreur : La filière existe déjà.</p>");
}

$query_insert = "INSERT INTO filieres (nom_filiere) VALUES ($1)";
$result_insert = pg_query_params($conn, $query_insert, [$nom_filiere]);

if ($result_insert) {
    echo "<p class='alert alert-success text-center'>Filière ajoutée avec succès !</p>";
} else {
    echo "<p class='alert alert-danger text-center'>Erreur lors de l'ajout.</p>";
}
?>