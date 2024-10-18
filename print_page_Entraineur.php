<?php
// Database connection
require_once "connection.php";
require_once "securite.php";


// Get the ID from the URL
$cin = isset($_GET['cin']) ? intval($_GET['cin']) : '';

// Fetch the row based on the ID
$query = "SELECT * FROM Paiement_Entraineur WHERE cin = $cin;";
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
    <title>Reçu Paiement Entraineur</title>
    <link rel="stylesheet" href="stylePrint.css">


    <script>
        function printPage() {
            window.print();
        }
    </script>
</head>

<body>

    <div class="receipt-container">
        <div class="logo_pic">
            <div class="logo_Badge">
                <img src="./img/logo.jpg" alt="Tiger Foot Academy Logo">
            </div>
            <img src="img/club.jpg">
        </div>
        <div class="header">
            <div class="title"><h3>Reçu N° <?php echo htmlspecialchars($row['id']); ?></h3>
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
                <h3>Saison sportive  <?php echo $startYear . '-' . $endYear; ?></h3>
                </div>
        </div>

        <div class="content">
            <p>Je soussigné Mr.<?php echo htmlspecialchars($row['prenom'] . ' ' . $row['nom']); ?>, titulaire de la C.I.N N° <?php echo htmlspecialchars($row['cin']); ?> du <?php echo htmlspecialchars($row['date_cin']); ?>, avoir reçu en espèce la somme de (<?php echo htmlspecialchars($row['montant']); ?>DT) en tant que rémunération du staff technique pour les séances d'entrainement de l'académie de foot « Tigreau Foot Academy » pour la période du <?php echo htmlspecialchars($row['date_debut']); ?> au <?php echo htmlspecialchars($row['date_fin']); ?></p>
        </div>

        <div class="signature">
            <p>Le: <?php echo date('d/m/Y'); ?></p>
            <p>Signature  du Bénéficiaire:</p>
        </div>
    </div>
    <button class="print-button" onclick="printPage()">Imprimer</button>

</body>

</html>