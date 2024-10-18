<?php
require_once "connection.php";
require_once "securite.php";
include "navigation.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $code = mysqli_real_escape_string($con, $_POST['code']);
    $nom = mysqli_real_escape_string($con, $_POST['nom']);
    $prenom = mysqli_real_escape_string($con, $_POST['prenom']);
    $montant = mysqli_real_escape_string($con, $_POST['montant']);
    $date = mysqli_real_escape_string($con, $_POST['date']);
    $nb_mois = mysqli_real_escape_string($con, $_POST['nb_mois']);

    // Validate the data (you might want to add additional validation here)
    if (!empty($code) && !empty($montant) && !empty($date) && !empty($nb_mois)) {
        // Insert data into the database
        $query = "INSERT INTO  Paiement_Joueur (code, nom, prenom, montant, date_paiement, nb_mois) VALUES ('$code', '$nom', '$prenom', '$montant', '$date', '$nb_mois')";
        $result = mysqli_query($con, $query);

        if ($result) {
            // Display success message
            $infos ='Informations ajoutées avec succès.';
            // Clear form fields (by redirecting)
        } else {
            // Display error message
            echo "<script>alert('Erreur lors de l\'ajout des informations: " . mysqli_error($con) . "');</script>";
        }
    } else {
        $info ='Veuillez remplir tous les champs.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paiement Joueur</title>
    <link rel="stylesheet" href="styleDashbord.css">
</head>

<body>
    <div style="position:relative;" class="main">
        <div class="topbar">
            <div class="toggle"><ion-icon name="menu-outline"></ion-icon></div>
            <div class="user">
            <div class="notification"><a href="notifications.php"><ion-icon name="notifications-outline"></ion-icon></a></div>
                <div class="userType">
                    <select id="userTypeSelect">
                        <option value="admin">Admin</option>
                        <option value="user">user</option>
                    </select>
                </div>
            </div>
        </div>
        <form method="POST" onsubmit="return validationEntraineur(event)"  action="">
            <h1 style="text-align:center; padding:1em 0">Payment Entraineur</h1>
            <fieldset style="border-radius:1.5em; width:50%; margin:0 auto; padding:2em; display:flex; flex-direction:column; gap:1em">
                <div>
                    <label >CIN : </label>
                    <input style="padding:.3em;  border-radius:.3em; border:0; border:1px solid black;" type="text" id="cin" name="cin" placeholder="012345678">
                </div>
                <div>
                    <label style="font-weight:bold;">Montant :</label>
                    <input style="padding:.3em;  border-radius:.3em; border:0; border:1px solid black;" type="text" id="montant" name="montant">
                </div>
                <div>
                    <label style="font-weight:bold;">Date Paiment :</label>
                    <input style="padding:.3em;  border-radius:.3em; border:0; border:1px solid black;" type="date" id="date" name="date">
                </div>
                <div>
                    <label style="font-weight:bold;">Mois Payé :</label>
                    <input style="padding:.3em;  border-radius:.3em; border:0; border:1px solid black;" type="text" id="moisPaye" name="nb_mois">
                </div>
                <input style="font-weight:bold; cursor:pointer; border:0; border:2px solid black; background:transparent; padding:.6em; border-radius:1.5em; width:50%; margin: 0 auto;" type="submit" value="Valider">
            </fieldset>
        </form>
    </div>
    <script>
    document.getElementById('userTypeSelect').addEventListener('change', function() {
        if (this.value === 'user') {
            window.location.href = 'user.php';
        }
    });
</script>
    <script src="./main.js"></script>
    <script src="./validation.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>

</html>