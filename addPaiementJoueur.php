<?php
require_once "securite.php";
require_once "connection.php";
include "navigation.php";

// Récupérer les joueurs pour le select
$sql_joueurs = "SELECT code, nom, prenom FROM Joueur";
$result_joueurs = $con->query($sql_joueurs);


if (isset($_POST['submit'])) {
    // Get form data
    $code = $_POST['code'];
    $montant = $_POST['montant'];
    $date_debut = $_POST['date_debut'];
    $nb_mois = $_POST['nb_mois'];
    if (empty($code) || empty($montant) || empty($date_debut) || empty($nb_mois)) {
        $info = "Veuillez remplir tous les champs requis.";
    } else {
        // Vérifier si le joueur existe dans la table joueur
        $sql_verif = "SELECT * FROM Joueur where code='$code'";
        $result_verif = $con->query($sql_verif);
        if ($result_verif->num_rows > 0) {
            // L'entraîneur existe, récupérer son nom et prénom
            $row = $result_verif->fetch_assoc();
            $nom = $row['nom'];
            $prenom = $row['prenom'];

            $date_debut_obj = new DateTime($date_debut);
            $date_debut_obj->modify("+$nb_mois months");
            $date_fin = $date_debut_obj->format('Y-m-d');

            // Insert data into the Joueur table
            $sql = "INSERT INTO Paiement_Joueur (code, nom, prenom, montant,date_debut,date_fin, nb_mois) 
            VALUES ('$code', '$nom', '$prenom', '$montant', '$date_debut','$date_fin','$nb_mois')";

            if ($con->query($sql) === TRUE) {
                $infos = "Nouveau Paiement ajouté avec succès";
            } else {
                echo "Erreur : " . $sql . "<br>" . $con->error;
            }
        } else {
            $info = "Le joueur avec ce code n'existe pas.";
        }

    }


    // Close connection
    $con->close();
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
                    <form action="" class="formADD" onsubmit="return validationJoueur(event)" method="POST">
                        <h2>Ajouter un Paiement Joueur</h2>
                        <?php if (!empty($infos)) { ?>
                            <p class="valide"><?php echo $infos; ?></p>
                        <?php } ?>
                        <?php if (!empty($info)) { ?>
                            <p class="error"><?php echo $info; ?></p>
                        <?php } ?>
                        <label for="code">Sélectionnez un Joueur</label>
                        <select id="code" name="code">
                            <?php
                            if ($result_joueurs->num_rows > 0) {
                                while ($row = $result_joueurs->fetch_assoc()) {
                                    echo "<option value='" . $row['code'] . "'>" . $row['nom'] . " " . $row['prenom'] . "</option>";
                                }
                            } else {
                                echo "<option value=''>Aucun joueur disponible</option>";
                            }
                            ?>
                        </select>                        <label for="montant">Montant </label>
                        <input type="text" id="montant" name="montant" placeholder="Montant">
                        <label for="date_debut">Date Debut</label>
                        <input type="date" id="date_debut" name="date_debut" placeholder="Date Debut Paiement">
                        <label for="nb_mois">Nombres de Mois</label>
                        <input type="text" id="nb_mois" name="nb_mois" placeholder="Nombres de Mois">
                        <label for=""></label>
                        <div class="groupeAjout2"><button type="submit" name="submit">Ajouter</button></div>
                </div>
                </form>
            </div>
        </div>
    </div>
    </div>
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