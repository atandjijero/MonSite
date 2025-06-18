<?php
include 'connexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $_POST["nom"];
    $email = $_POST["email"];
    $mot_de_passe = password_hash($_POST["mot_de_passe"], PASSWORD_DEFAULT);

    $sql = "INSERT INTO administrateurs (nom, email, mot_de_passe) VALUES ('$nom', '$email', '$mot_de_passe')";
    $result = pg_query($conn, $sql);

    if ($result) {
        echo "<div class='alert alert-success'>Inscription réussie !</div>";
    } else {
        echo "<div class='alert alert-danger'>Erreur : " . pg_last_error($conn) . "</div>";
    }
}
?>