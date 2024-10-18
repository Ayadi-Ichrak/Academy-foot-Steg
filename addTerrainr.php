<?php 
require_once "securite.php";
require_once "connection.php";
include "navigation.php";

if (isset($_POST['submit'])) {
    // Get form data
    $nom = $_POST['nom'];
    $localisation = $_POST['localisation'];
    
    if (empty($nom) || empty($localisation))  {
        $info = "Veuillez remplir tous les champs requis.";
    } else {
      // Insert data into the Joueur table
    $sql = "INSERT INTO Terrain ( nom, localisation) 
            VALUES ('$nom', '$localisation')";

    if ($con->query($sql) === TRUE) {
        $infos = "Nouveau Terrain ajouté avec succès";
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
    <title>Terrain</title>
    <link rel="stylesheet" href="styleDashbord.css">
</head>
<body>
    <div class="main">
        <div class="topbar">
            <div class="toggle"><ion-icon name="menu-outline"></ion-icon></div>
            <div class="search">
                <form action="rechercheJoueurs.php" method="GET">
                    <input type="text" name="search" placeholder="Recherche">
                    <button type="submit"><ion-icon name="search-outline"></ion-icon></button>
                </form>
            </div>
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
                        <h2>Ajouter un Terrain</h2>
                        <?php if (!empty($infos)) { ?>
                             <p class="valide"><?php echo $infos; ?></p>
                        <?php } ?>
                        <?php if (!empty($info)) { ?>
                             <p class="error"><?php echo $info; ?></p>
                        <?php } ?>
                        <label for="Joueur_nom">Nom</label>
                        <input type="text" id="Joueur_nom" name="nom" placeholder="Nom">
                        <label for="localisation">Localisation </label>
                        <input type="text" id="localisation" name="localisation" placeholder="Localisation">
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