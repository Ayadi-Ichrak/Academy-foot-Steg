<?php
// Database connection
require_once "connection.php";
require_once "securite.php";


// Get the ID from the URL
$code = isset($_GET['code']) ? $_GET['code'] : '';

// Fetch the row based on the ID
$query = "SELECT Joueur.code, Joueur.nom, Joueur.prenom, Joueur.date_naissance, Joueur.photo, Joueur.groupe_id AS groupe FROM Joueur WHERE Joueur.code = '$code'";
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
    <title>Badge Joueurs</title>
    <link rel="stylesheet" href="stylePrint.css">

    <script>
        function printPage() {
            window.print();
        }
    </script>
</head>

<body>

    <div class="receipt_container_Badge">
        <div class="logo_pic">
            <div class="logo_Badge">
                <img src="./img/logo.jpg" alt="Tiger Foot Academy Logo">
            </div>
            <img src="img/<?php echo $row["photo"]; ?>">
        </div>
        <div class="Content_qr">
            <div class="content">
                <p>Code: <strong><?php echo htmlspecialchars($row['code']); ?> </strong></p>
                <p>Nom: <strong><?php echo htmlspecialchars($row['nom']); ?> </strong></p>
                <p>Prenom: <strong><?php echo htmlspecialchars($row['prenom']); ?></strong> </p>
                <p>Groupe: <strong><?php echo htmlspecialchars($row['groupe']); ?></strong> </p>
            </div>
            <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=<?php echo urlencode($row['code']); ?>" alt="QR Code">
        </div>
    </div>
    <button class="print-button" onclick="printPage()">Imprimer</button>

</body>

</html>