<?php 
require_once "securite.php";
require_once "connection.php";
include "navigation.php";

if (isset($_POST['submit'])) {
    // Get form data
    $nom = $_POST['nom'];
    $quantite = $_POST['quantite'];
    $date_achat = $_POST['date_achat'];
    
    if (empty($nom) || empty($quantite)||empty($date_achat))  {
        $info = "Veuillez remplir tous les champs requis.";
    } else {
      // Insert data into the Joueur table
    $sql = "INSERT INTO Materiel ( nom, quantite, date_achat) 
            VALUES ('$nom', '$quantite','$date_achat')";

    if ($con->query($sql) === TRUE) {
        $infos = "Nouveau Materiel ajouté avec succès";
    } else {
        echo "Erreur : " . $sql . "<br>" . $con->error;
    }
    }
    

   // Close connection
    $con->close();}
    ?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Materiel</title>
    <link rel="stylesheet" href="styleDashbord.css">
</head>
<body>
    <div class="main">
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
        <div class="detaille">
            <div class="affichageTable">
                <div class="cardHeader">
                    <form action="" class="formADD"  method="POST">
                        <h2>Ajouter un Materiel</h2>
                        <?php if (!empty($infos)) { ?>
                             <p class="valide"><?php echo $infos; ?></p>
                        <?php } ?>
                        <?php if (!empty($info)) { ?>
                             <p class="error"><?php echo $info; ?></p>
                        <?php } ?>
                        <label for="Joueur_nom">Nom du Materiel</label>
                        <input type="text" id="Joueur_nom" name="nom" placeholder="Nom">
                        <label for="quantite">Quantite</label>
                        <input type="text" id="quantite" name="quantite" placeholder="Quantite">
                        <label for="date_achat">Date Achat </label>
                        <input type="date" id="date_achat" name="date_achat" placeholder="Date Achat">
                        <label for=""></label>
                        <div class="groupeAjout2"><button type="submit" name="submit">Ajouter</button></div>
                        </div>
                    </form>
                </div>   
            </div>  
        </div>  
    </div> 
    <script>
    document.getElementById('userTypeSelect').addEventListener('change', function() {
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