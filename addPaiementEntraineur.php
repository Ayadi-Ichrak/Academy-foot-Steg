<?php
require_once "securite.php";
require_once "connection.php";
include "navigation.php";

// Récupérer les entraîneurs pour le select
$sql_entraineurs = "SELECT cin, nom, prenom FROM Entraineur";
$result_entraineurs = $con->query($sql_entraineurs);


if (isset($_POST['submit'])) {
    // Get form data
    $cin = $_POST['cin'];
    $montant = $_POST['montant'];
    $date_debut = $_POST['date_debut'];
    $nb_mois = $_POST['nb_mois'];
    if (empty($cin) || empty($montant) || empty($date_debut) || empty($nb_mois)) {
        $info = "Veuillez remplir tous les champs requis.";
    } else {
        // Vérifier si l'entraîneur existe dans la table Entraineur
        $sql_verif = "SELECT nom, prenom, date_cin FROM Entraineur WHERE cin = '$cin'";
        $result_verif = $con->query($sql_verif);

        if ($result_verif->num_rows > 0) {
            // L'entraîneur existe, récupérer son nom et prénom
            $row = $result_verif->fetch_assoc();
            $nom = $row['nom'];
            $prenom = $row['prenom'];
            $date_cin = $row['date_cin'];

            $date_debut_obj = new DateTime($date_debut);
            $date_debut_obj->modify("+$nb_mois months");
            $date_fin = $date_debut_obj->format('Y-m-d');

            // Insert data into the Joueur table
            $sql = "INSERT INTO Paiement_Entraineur (cin, date_cin, nom, prenom, montant,date_debut,date_fin, nb_mois) 
            VALUES ('$cin', '$date_cin', '$nom', '$prenom', '$montant', '$date_debut','$date_fin','$nb_mois')";
            if ($con->query($sql) === TRUE) {
                $infos = "Nouveau Paiement ajouté avec succès";
            } else {
                echo "Erreur : " . $sql . "<br>" . $con->error;
            }
        } else {
            $info = "L'entraîneur avec ce CIN n'existe pas.";
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
    <title>Paiement Entraineur</title>
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
                        <h2>Ajouter un Paiement Entraineur</h2>
                        <?php if (!empty($infos)) { ?>
                            <p class="valide"><?php echo $infos; ?></p>
                        <?php } ?>
                        <?php if (!empty($info)) { ?>
                            <p class="error"><?php echo $info; ?></p>
                        <?php } ?>
                        <label for="cin">Sélectionnez un Entraîneur</label>
                        <select id="cin" name="cin">
                            <?php if ($result_entraineurs->num_rows > 0) { ?>
                                <?php while ($row = $result_entraineurs->fetch_assoc()) { ?>
                                    <option value="<?php echo $row['cin']; ?>">
                                        <?php echo $row['nom'] . ' ' . $row['prenom']; ?>
                                    </option>
                                <?php } ?>
                            <?php } else { ?>
                                <option value="">Aucun entraîneur disponible</option>
                            <?php } ?>
                        </select>
                        <label for="montant">Montant </label>
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