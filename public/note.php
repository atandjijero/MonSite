<?php
include("connexion.php");

$nom_etudiant = trim(htmlspecialchars($_POST['nom_etudiant']));
$nom_matiere = trim(htmlspecialchars($_POST['nom_matiere']));
$note_devoir = floatval($_POST['note_devoir']);
$note_examen = floatval($_POST['note_examen']);
$query_etudiant = "SELECT matricule FROM etudiants WHERE nom = $1";
$result_etudiant = pg_query_params($conn, $query_etudiant, [$nom_etudiant]);

if (!$result_etudiant || pg_num_rows($result_etudiant) == 0) {
    die("<p class='alert alert-danger'>Erreur : L'étudiant '$nom_etudiant' n'existe pas.</p>");
}
$etudiant_id = pg_fetch_assoc($result_etudiant)['matricule'];
$query_matiere = "SELECT id FROM matieres WHERE nom_matiere = $1";
$result_matiere = pg_query_params($conn, $query_matiere, [$nom_matiere]);

if (!$result_matiere || pg_num_rows($result_matiere) == 0) {
    die("<p class='alert alert-danger'>Erreur : La matière '$nom_matiere' n'existe pas.</p>");
}
$matiere_id = pg_fetch_assoc($result_matiere)['id'];
$moyenne = ($note_devoir * 0.4) + ($note_examen * 0.6);
$valide = ($moyenne >= 10) ? 'true' : 'false';
$query_insert = "INSERT INTO notes (etudiant_id, matiere_id, note_devoir, note_examen, moyenne, valide) VALUES ($1, $2, $3, $4, $5, $6)";
$result_insert = pg_query_params($conn, $query_insert, [$etudiant_id, $matiere_id, $note_devoir, $note_examen, $moyenne, $valide]);

if ($result_insert) {
    echo "<p class='alert alert-success text-center'>Note ajoutée avec succès ! Moyenne : $moyenne</p>";
} else {
    echo "<p class='alert alert-danger text-center'>Erreur lors de l'ajout.</p>";
}
?>