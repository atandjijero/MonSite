<?php
include 'connexion.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $mot_de_passe = $_POST["mot_de_passe"];
    $email = pg_escape_string($conn, $email);
    $sql = "SELECT * FROM administrateurs WHERE email = '$email'";
    $result = pg_query($conn, $sql);
    $admin = pg_fetch_assoc($result);

    if ($admin && password_verify($mot_de_passe, $admin["mot_de_passe"])) {
        $_SESSION["admin_id"] = $admin["id"];
        header("Location: admi_espace.html");
        exit();
    } else {
        $error_message = "Email ou mot de passe incorrect.";
        header("Location: login.html?error=" . urlencode($error_message));
        exit();
    }
}
?>