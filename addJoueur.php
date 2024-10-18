<?php
require_once "connection.php";
require_once "securite.php";
include "navigation.php";

if (isset($_POST['submit'])) {
    // Get form data
    $nom = $_POST['Joueur_nom'];
    $prenom = $_POST['joueur_prenom'];
    $date_naissance = $_POST['joueur_DN'];
    $parent_cin = $_POST['parent_cin'];
    $photo = $_FILES['Joueur_img']['name'];
    $groupe_id = $_POST['Groupe_id'];

    if (empty($nom) || empty($prenom) || empty($date_naissance) || empty($parent_cin) || empty($groupe_id)) {
        $info = "Veuillez remplir tous les champs requis.";
    } else {
    // Handle file upload
    if (isset($_FILES['Joueur_img']) && $_FILES['Joueur_img']['error'] == 0) {
        $target_dir = "img/";
        $target_file = $target_dir . basename($photo);
        move_uploaded_file($_FILES['Joueur_img']['tmp_name'], $target_file);
    } else {
        $photo = ''; // Handle the case where no file is uploaded
        $target_file = ''; // Initialize $target_file with an empty string
    }
    // Generate code
    $prenom_part = substr($prenom, 0, 3); // First 3 letters of prenom
    $mois_naissance = date('m', strtotime($date_naissance)); // Month of birth
    $nom_part = substr($nom, -2); // Last 2 letters of nom
    $annee_naissance = date('y', strtotime($date_naissance)); // Last 2 digits of birth year
    $code_QR = strtoupper($prenom_part . $mois_naissance . $nom_part . $annee_naissance);

    // Insert data into the Joueur table
    $sql = "INSERT INTO Joueur (code,nom, prenom, date_naissance, photo,  groupe_id, parent_cin) 
            VALUES ('$code_QR','$nom', '$prenom', '$date_naissance', '$target_file',  '$groupe_id', '$parent_cin')";

    if ($con->query($sql) === TRUE) {
        $infos = "Nouveau joueur ajouté avec succès";
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
                        <h2>Ajouter un joueur</h2>
                        <?php if (!empty($infos)) { ?>
                             <p class="valide"><?php echo $infos; ?></p>
                        <?php } ?>
                        <?php if (!empty($info)) { ?>
                             <p class="error"><?php echo $info; ?></p>
                        <?php } ?>
                        <?php
                        $sql1 = "SELECT * FROM Groupe";
                        $result1 = mysqli_query($con, $sql1);
                        $nb = mysqli_num_rows($result1);

                        if ($nb > 0) { ?>
                            <label for="nom">*Nom</label>
                            <input type="text" id="nom" name="Joueur_nom" placeholder="Nom">
                            <label for="joueur_prenom">*Prenom</label>
                            <input type="text" id="joueur_prenom" name="joueur_prenom" placeholder="Prenom">
                            <label for="Joueur_DN">*Date Naissance</label>
                            <input type="date" id="joueur_DN" name="joueur_DN" placeholder="Date Naissance">
                            <label for="parent_cin">*Parent Cin</label>
                            <input type="text" id="parent_cin" name="parent_cin" placeholder="Parent Cin">
                            <label for="Joueur_img">Image</label>
                            <input type="file" class="img" id="Joueur_img" name="Joueur_img">
                            <label for="Groupe_id">*Groupe</label>
                            <div class="groupeAjout">
                                <select name="Groupe_id">
                                    <?php while ($row = mysqli_fetch_assoc($result1)) { ?>
                                        <option value="<?php echo $row["id"]; ?>"><?php echo $row["nom"]; ?></option>
                                    <?php } ?>
                                </select>
                                <button type="submit" name="submit">Ajouter</button>
                            </div>
                    </form>
                <?php } else { ?>
                    <div class="jumbotron">
                        <h1>Aucun Groupe trouvé pour affecter les joueurs</h1>
                        <p><?php echo $con->error; ?></p>
                    </div>
                <?php } ?>
                </div>
            </div>
        </div>
        <div class="code_qr">
            <img src="" class="qrious" alt="">
            <div class="information">
                <p style="color:#4e4a4a;">Code Joueurs:</p>
                <p style="color:#888;"></p>
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