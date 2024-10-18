<?php
// Database connection
require_once "connection.php";
require_once "securite.php";


// Get the ID from the URL
$code = isset($_GET['code']) ? $_GET['code'] : '';

// Fetch the row based on the ID
$query = "SELECT * FROM Paiement_Joueur WHERE code = '$code'";
$result = mysqli_query($con, $query);

if (!$result) {
    die("Query failed: " . mysqli_error($con));
}

// Fetch the row
$row = mysqli_fetch_assoc($result);

// Close database connection
mysqli_close($con);

if (!$row) {
    die("No data found.");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reçu Paiement Joueurs</title>
    <link rel="stylesheet" href="stylePrint.css">

    <script>
        function printPage() {
            window.print();
        }
    </script>
</head>

<body>

    <div class="receipt-container_recu">
        <div class="tete">
            <div class="logo_tete">
                <h3>TIGER FOOT ACADEMY</h3>
                <h3>STEG EL OMRANE</h3>
            </div>
            <div class="logo_milieu">
                <h3>TIGER FOOT ACADEMY</h3>
                <h3>STEG EL OMRANE</h3>
            </div>
            <div class="logo_droit">
                <img src="img/logo.jpg" alt="">
            </div>
        </div>
        <div class="header_milieux">
            <div class="header_title">Reçu Paiement Joueurs</div>
            <div class="header_title_2">Reçu Paiement Joueurs</div>
        </div>

        <div class="content_recu">
            <div class="gauche">
                <?php
                $currentMonth = date("n"); // Mois en cours (numérique, sans zéro initial)
                $currentYear = date("Y"); // Année en cours
                
                if ($currentMonth >= 9) {
                    // Si on est en septembre ou plus tard dans l'année, la saison commence cette année et se termine l'année suivante
                    $startYear = $currentYear;
                    $endYear = $currentYear + 1;
                } else {
                    // Si on est avant septembre, la saison a commencé l'année précédente et se termine cette année
                    $startYear = $currentYear - 1;
                    $endYear = $currentYear;
                }
                ?>
                <p>Saison sportive: <?php echo $startYear . '-' . $endYear; ?></p>
                <p>Joueur:<?php echo $row['nom'] . ' ' . $row['prenom']; ?></p>
                <p>Payer par(Mr/Mme): </p>
                <p>Montant:<?php echo htmlspecialchars($row['montant']); ?>DT</p>
                <p>Du <?php echo htmlspecialchars($row['date_debut']); ?> au
                    <?php echo htmlspecialchars($row['date_fin']); ?></p>
                <p>signature:</p>
            </div>
            <div class="droit">
                <?php
                $currentYear = date("Y"); // Année en cours
                $previousYear = $currentYear - 1; // Année précédente
                ?>
                <p>Saison sportive: <?php echo $startYear . '-' . $endYear; ?></p>
                <p>Joueur: <?php echo $row['nom'] . ' ' . $row['prenom']; ?></p>
                <p>Payer par(Mr/Mme): </p>
                <p>Montant:<?php echo htmlspecialchars($row['montant']); ?>DT</p>
                <p>Du <?php echo htmlspecialchars($row['date_debut']); ?> au
                    <?php echo htmlspecialchars($row['date_fin']); ?></p>
                <p>signature:</p>
            </div>
        </div>
    </div>
    <button class="print-button" onclick="printPage()">Imprimer</button>

</body>

</html>