<?php
require_once "connection.php";
require_once "securite.php";
include "navigation.php";

if (isset($_POST['submit'])) {
    // Get form data
    $cin = $_POST['cin'];
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $num_tel = $_POST['num_tel'];
    $photo = $_FILES['img']['name'];
    $joueur_code = $_POST['joueur_code'];

    if (empty($cin) ||empty($nom) || empty($prenom) || empty($num_tel) ||  empty($joueur_code)) {
        $info = "Veuillez remplir tous les champs requis.";
    } else {
    // Handle file upload
    if (isset($_FILES['img']) && $_FILES['img']['error'] == 0) {
        $target_dir = "img/";
        $target_file = $target_dir . basename($photo);
        move_uploaded_file($_FILES['img']['tmp_name'], $target_file);
    } else {
        $photo = ''; // Handle the case where no file is uploaded
        $target_file = ''; // Initialize $target_file with an empty string
    }
    $sql = "INSERT INTO Parents (cin, nom, prenom, num_tel, photo,  joueur_code) 
            VALUES ('$cin','$nom', '$prenom', '$num_tel', '$target_file',  '$joueur_code')";

    if ($con->query($sql) === TRUE) {
        $infos = "Nouveau Parent ajouté avec succès";
    } else {
        echo "Erreur : " . $sql . "<br>" . $con->error;
    }
}
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Joueurs</title>
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
                    <form action="" class="formADD" method="POST" enctype="multipart/form-data">
                        <h2>Ajouter un Parents</h2>
                        <?php if (!empty($infos)) { ?>
                             <p class="valide"><?php echo $infos; ?></p>
                        <?php } ?>
                        <?php if (!empty($info)) { ?>
                             <p class="error"><?php echo $info; ?></p>
                        <?php } ?>
                            <label for="nom">Nom</label>
                            <input type="text" id="nom" name="nom" placeholder="Nom">
                            <label for="joueur_prenom">Prenom</label>
                            <input type="text" id="prenom" name="prenom" placeholder="Prenom">
                            <label for="num_tel">Telephone</label>
                            <input type="text" id="num_tel" name="num_tel" placeholder="Telephone">
                            <label for="cin">CIN</label>
                            <input type="text" id="cin" name="cin" placeholder="Parent Cin">
                            <label for="joueur_code">Code de l'Enfant</label>
                            <input type="text" id="joueur_code" name="joueur_code" placeholder="Code de l'Enfant">
                            <label for="img">Image</label>
                            <input type="file" class="img" id="img" name="img">
                            <div class="groupeAjout">
                                <button type="submit" name="submit">Ajouter</button>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
    <?php // Close connection
    $con->close(); ?>
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