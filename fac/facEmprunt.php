<?php
require "../connexion.php";
require "fpdf.php";

// Assurez-vous que votre script PHP utilise UTF-8
header('Content-Type: text/html; charset=utf-8');

// Récupérer l'identifiant de la demande d'emprunt
$id_demande = $_GET['complet'];

// Récupérer les détails de la demande d'emprunt
$req = "SELECT * FROM demande_emprunt WHERE id_de = '$id_demande'";
$stmt = $conn->query($req);
$ligne = mysqli_fetch_assoc($stmt);
// Convertir les dates en objets DateTime
$date_pret = new DateTime($ligne['date_pret']);
$date_rembou = new DateTime($ligne['date_rembou']);

// Calculer la différence entre les deux dates en jours
$interval = $date_pret->diff($date_rembou);
$jours = $interval->days; // Obtenir le nombre total de jours
// Assurez-vous que les données récupérées sont converties en UTF-8
foreach ($ligne as $key => $value) {
    $ligne[$key] = mb_convert_encoding($value, 'UTF-8', 'auto');
}

// Récupérer les détails de l'association
$id_association = $ligne['id_association'];
$req_asso = "SELECT * FROM association WHERE id_association = '$id_association'";
$asso = mysqli_fetch_assoc($conn->query($req_asso));

// Récupérer les détails du membre
$id_membre = $ligne['id_membre'];
$req_membre = "SELECT * FROM membres WHERE id_membre = '$id_membre'";
$membre = mysqli_fetch_assoc($conn->query($req_membre));

// Créer le PDF
$pdf = new FPDF('P', 'mm', 'A4');
$pdf->AddPage();

// Ajouter le logo de l'association en haut à gauche
$pdf->Image($asso['photo'], 10, 10, 40, 40); // 40x40 mm

// Ajouter la photo du membre en haut à droite
$pdf->Image($membre['photo'], 150, 10, 40, 40); // 40x40 mm

// Ajouter le nom de l'association et d'autres informations
$pdf->SetFont('Arial', 'B', 16);
$pdf->SetXY(60, 10); // Position au centre de la page
$pdf->Cell(90, 10, $asso['nom'], 0, 1, 'C'); // Nom de l'association centré

// Ajouter les informations de l'association sous le logo
$pdf->SetFont('Arial', '', 10);
$pdf->SetXY(10, 60); // Juste en dessous de l'image du logo
$pdf->MultiCell(90, 5, 
    "Responsable: " . $asso['responsable'] . "\n" .
    "Téléphone: " . $asso['telephone'] . "\n" .
    "Email: " . $asso['email']
);

// Ajouter les informations du membre sous la photo
$pdf->SetXY(150, 60); // Juste en dessous de l'image de la photo du membre
$pdf->MultiCell(90, 5, 
    "Nom: " . $membre['nom'] . "\n" .
    "Prénom: " . $membre['prenom'] . "\n" .
    "Adresse: " . $membre['adresse'] . "\n" .
    "Téléphone: " . $membre['numero_telephone']
);

// Titre de la facture
$pdf->SetFont('Arial', 'B', 20);
$pdf->SetXY(10, 80); // Positionnez le titre après l'en-tête
$pdf->Cell(190, 10, 'Facture', 0, 1, 'C'); // Centré

// Créer un texte avec les détails du prêt et autres informations
$texte = "
Bonjour Monsieur/Madame " . $ligne['nom'] . " " . $ligne['prenom'] . ",

Nous vous remercions d'avoir contracté un prêt auprès de notre association le " . date("d-m-Y", strtotime($ligne['date_pret'])) . ".

Voici les détails de votre prêt :

- Montant emprunté : " . number_format($ligne['montant'], 2) . " euros
- Taux d'intérêt : " . number_format($ligne['interet'], 2) . " %
- Durée du prêt : " . $jours . " jours
- Date de remboursement : " . date("d-m-Y", strtotime($ligne['date_rembou'])) . "

Le montant total à rembourser est de " . number_format($ligne['total'], 2) . " euros.

Nous vous rappelons que le remboursement doit être effectué à la date prévue. Tout retard de paiement peut entraîner des frais supplémentaires ou des pénalités.

Veuillez nous contacter si vous avez des questions ou des préoccupations. Nous restons à votre disposition pour toute information complémentaire.

Nous vous remercions de votre confiance et espérons vous servir à l'avenir.

Bien cordialement,

[Nom de l'association]

";

// Ajouter le texte à la facture
$pdf->SetFont('Arial', '', 12);
$pdf->MultiCell(0, 10, $texte);

// Sortie du PDF
$pdf->Output();
?>
