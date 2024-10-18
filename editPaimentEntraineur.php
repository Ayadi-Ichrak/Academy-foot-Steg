<?php
require_once "securite.php";
require_once "connection.php";
include "navigation.php";
if ($_GET) {
    extract($_GET);
}
$req = "SELECT * FROM Paiement_Entraineur where id='$id' ";
$result1 = mysqli_query($con, $req);
while ($row = mysqli_fetch_assoc($result1)) {
    $cin = $row['cin'];
    $date_cin = $row['date_cin'];
    $nom = $row['nom'];
    $prenom = $row['prenom'];
    $montant = $row['montant'];
    $date_debut = $row['date_debut'];
    $nb_mois = $row['nb_mois'];

}

if ($_POST) {
    extract($_POST);
    // Calcul de la date_fin
    $date_debut_obj = new DateTime($date_debut);
    $date_debut_obj->modify("+$nb_mois months");
    $date_fin = $date_debut_obj->format('Y-m-d');


    $req2 = "UPDATE Paiement_Entraineur SET cin='$cin',
date_cin = '$date_cin'
nom = '$nom', 
prenom = '$prenom', 
montant = '$montant',
date_debut = '$date_debut',
date_fin='$date_fin', 
nb_mois = '$nb_mois' 
WHERE id = '$id'";
    $result = mysqli_query($con, $req2);

    if ($result) {
        $_SESSION['info'] = "paiement modifié avec succès";
        header("location: historique_paiementEntraineur.php");
        exit;
    } else {
        $_SESSION['info'] = "Échec de la modification.";
        header("location: historique_paiementEntraineur.php");
        exit;
    }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modification Paiement Entraineur </title>
    <link rel="stylesheet" href="styleDashbord.css">

</head>

<body>
    <div class="main">
        <div class="topbar">
            <div class="toggle"><ion-icon name="menu-outline"></ion-icon></div>
            <div class="user">
                <div class="notification"><a href="notifications.php"><ion-icon
                            name="notifications-outline"></ion-icon></a></div>
                <div class="userType">
                    <select id="userTypeSelect">
                        <option value="admin">Admin</option>
                        <option value="user">user</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="detaille">
            <div class="affichageTable">
                <div class="cardHeader">
                    <form action="" class="formADD" method="POST" enctype="multipart/form-data">
                        <h2>Modifier Paiement Entraineur</h2>
                        <label for="cin">*CIN</label>
                        <input type="text" value="<?php echo $cin ?>" name="cin">

                        <label for="date_cin">*Date CIN</label>
                        <input type="date" value="<?php echo $date_cin ?>" name="date_cin">

                        <label for="nom">*Nom</label>
                        <input type="text" value="<?php echo $nom ?>" name="nom">

                        <label for="prenom">*Prénom</label>
                        <input type="text" value="<?php echo $prenom ?>" name="prenom">

                        <label for="montant">*Montant</label>
                        <input type="text" value="<?php echo $montant ?>" name="montant">

                        <label for="date_debut">*Date Début</label>
                        <input type="date" value="<?php echo $date_debut ?>" name="date_debut">

                        <label for="nb_mois">*Nombre de Mois</label>
                        <input type="number" value="<?php echo $nb_mois ?>" name="nb_mois">
                        <div class="groupeAjout">
                            <button type="submit" name="submit">Modifier</button>
                        </div>
                        <?php if (!empty($info))
                            echo "<span>" . $info . "</span>"; ?>

                    </form>

                </div>
            </div>
        </div>
    </div>
    </div>
    <?php // Close connection
    $con->close(); ?>
    <script>
        document.getElementById('userTypeSelect').addEventListener('change', function () {
            if (this.value === 'user') {
                window.location.href = 'user.php';
            }
        });
    </script>
    <script src="./main.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>

</html>