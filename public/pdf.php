<?php
require('fpdf.php');
include("connexion.php");

$matricule = htmlspecialchars($_GET['matricule']);
$filiere_id = intval($_GET['filiere_id']);

// Vérifier si l'étudiant existe
$query_etudiant = "SELECT e.matricule, e.nom, f.nom_filiere FROM etudiants e 
                   JOIN filieres f ON e.filiere_id = f.id 
                   WHERE e.matricule = $1 AND f.id = $2";
$result_etudiant = pg_query_params($conn, $query_etudiant, [$matricule, $filiere_id]);

if (!$result_etudiant || pg_num_rows($result_etudiant) == 0) {
    die("Erreur : Étudiant non trouvé.");
}

$etudiant = pg_fetch_assoc($result_etudiant);
$nom_etudiant = $etudiant['nom'];
$nom_filiere = $etudiant['nom_filiere'];

// Récupérer les notes de l'étudiant
$query_notes = "SELECT m.nom_matiere, n.note_devoir, n.note_examen, n.moyenne, n.valide 
                FROM notes n 
                JOIN matieres m ON n.matiere_id = m.id 
                WHERE n.etudiant_id = $1";
$result_notes = pg_query_params($conn, $query_notes, [$matricule]);

// Calcul de la moyenne générale
$moyenne_generale = 0;
$total_matieres = pg_num_rows($result_notes);

// Création du PDF
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 14);
$pdf->SetTextColor(0, 51, 102); // Bleu foncé
$pdf->SetFillColor(220, 220, 220); // Gris clair
$pdf->Cell(190, 10, utf8_decode("Résultats de $nom_etudiant ($matricule)"), 0, 1, 'C', true);
$pdf->Cell(190, 10, utf8_decode("Filière : $nom_filiere"), 0, 1, 'C', true);
$pdf->Ln(10);

// Ajout du tableau des notes
$pdf->SetFont('Arial', 'B', 12);
$pdf->SetFillColor(0, 51, 102);
$pdf->SetTextColor(255, 255, 255);
$pdf->Cell(50, 10, utf8_decode("Matière"), 1, 0, 'C', true);
$pdf->Cell(30, 10, utf8_decode("Devoir"), 1, 0, 'C', true);
$pdf->Cell(30, 10, utf8_decode("Examen"), 1, 0, 'C', true);
$pdf->Cell(30, 10, utf8_decode("Moyenne"), 1, 0, 'C', true);
$pdf->Cell(30, 10, utf8_decode("Validé"), 1, 1, 'C', true);

$pdf->SetFont('Arial', '', 12);
$pdf->SetTextColor(0, 0, 0);

while ($row = pg_fetch_assoc($result_notes)) {
    $valide = ($row['valide'] == 't') ? "✅ Oui" : "❌ Non";
    $pdf->SetFillColor(240, 240, 240);
    $pdf->Cell(50, 10, utf8_decode($row['nom_matiere']), 1, 0, 'C', true);
    $pdf->Cell(30, 10, $row['note_devoir'], 1, 0, 'C', true);
    $pdf->Cell(30, 10, $row['note_examen'], 1, 0, 'C', true);
    $pdf->Cell(30, 10, $row['moyenne'], 1, 0, 'C', true);
    $pdf->Cell(30, 10, utf8_decode($valide), 1, 1, 'C', true);
    
    $moyenne_generale += $row['moyenne'];
}

// Calcul de la moyenne générale
if ($total_matieres > 0) {
    $moyenne_generale /= $total_matieres;
}

// Déterminer la mention
$mention = "Insuffisant";
if ($moyenne_generale >= 16) {
    $mention = "Très Bien";
} elseif ($moyenne_generale >= 14) {
    $mention = "Bien";
} elseif ($moyenne_generale >= 12) {
    $mention = "Assez Bien";
} elseif ($moyenne_generale >= 10) {
    $mention = "Passable";
}

// Ajout de la moyenne générale et de la mention
$pdf->Ln(10);
$pdf->SetFont('Arial', 'B', 12);
$pdf->SetTextColor(0, 51, 102);
$pdf->Cell(190, 10, utf8_decode("📊 Moyenne Générale : $moyenne_generale"), 0, 1, 'C', true);
$pdf->Cell(190, 10, utf8_decode("🏅 Mention : $mention"), 0, 1, 'C', true);

// Pied de page
$pdf->Ln(10);
$pdf->SetTextColor(100, 100, 100);
$pdf->Cell(190, 10, utf8_decode("🔹 Généré automatiquement par le système 🔹"), 0, 1, 'C');

// Générer et télécharger le fichier PDF
$pdf->Output("resultat_$matricule.pdf", 'D');
?>