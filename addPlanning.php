<?php
require_once "connection.php";
require_once "securite.php";
include "navigation.php";

if (isset($_POST['submit'])) {
    // Get form data
    $groupe = $_POST['groupe'];
    $entraineur = $_POST['entraineur'];
    $terrain = $_POST['terrain'];
    $jour = $_POST['jour'];
    $temps_debut = $_POST['temps'];

    if (empty($groupe) || empty($entraineur) || empty($terrain) || empty($jour) || empty($temps_debut)) {
        $info = "Veuillez remplir tous les champs requis.";
    } else {
        $temps_debut_obj = new DateTime($temps_debut);
        $temps_debut_obj->add(new DateInterval('PT1H30M'));
        $temps_fin = $temps_debut_obj->format('H:i');

        // Check for conflicting trainer schedules
        $sql_check_trainer = "SELECT * FROM Planning WHERE entraineur_cin = '$entraineur' AND jour = '$jour' AND (
            (temps_debut <= '$temps_debut' AND temps_fin > '$temps_debut') OR
            (temps_debut < '$temps_fin' AND temps_fin >= '$temps_fin') OR
            (temps_debut >= '$temps_debut' AND temps_fin <= '$temps_fin'))";
        $result_trainer = $con->query($sql_check_trainer);

        if ($result_trainer === false) {
            echo "Erreur lors de la vérification du planning de l'entraîneur : " . $con->error;
        } elseif ($result_trainer->num_rows > 0) {
            $info = "Impossible d'avoir un même entraîneur pour deux groupes au même temps.";
        } else {
            // Check for conflicting field schedules
            $sql_check_terrain = "SELECT * FROM Planning WHERE terrain_id = '$terrain' AND jour = '$jour' AND (
                (temps_debut <= '$temps_debut' AND temps_fin > '$temps_debut') OR
                (temps_debut < '$temps_fin' AND temps_fin >= '$temps_fin') OR
                (temps_debut >= '$temps_debut' AND temps_fin <= '$temps_fin'))";
            $result_terrain = $con->query($sql_check_terrain);

            if ($result_terrain === false) {
                echo "Erreur lors de la vérification du planning du terrain : " . $con->error;
            } elseif ($result_terrain->num_rows > 0) {
                $info = "Impossible d'avoir un même terrain pour deux groupes au même temps.";
            } else {
                // Check if the number of groups at the same time exceeds the number of fields
                $sql_count_groups = "SELECT COUNT(*) as total FROM Planning WHERE jour = '$jour' AND (
                    (temps_debut <= '$temps_debut' AND temps_fin > '$temps_debut') OR
                    (temps_debut < '$temps_fin' AND temps_fin >= '$temps_fin') OR
                    (temps_debut >= '$temps_debut' AND temps_fin <= '$temps_fin'))";
                $result_groups = $con->query($sql_count_groups);

                if ($result_groups === false) {
                    echo "Erreur lors de la vérification du nombre de groupes : " . $con->error;
                } else {
                    $row = $result_groups->fetch_assoc();

                    $sql_count_terrains = "SELECT COUNT(*) as total FROM Terrain";
                    $result_terrains = $con->query($sql_count_terrains);

                    if ($result_terrains === false) {
                        echo "Erreur lors de la vérification du nombre de terrains : " . $con->error;
                    } else {
                        $row_terrains = $result_terrains->fetch_assoc();

                        if ($row['total'] >= $row_terrains['total']) {
                            $info = "Le nombre de groupes qui s'entraînent au même temps ne doit pas dépasser le nombre de terrains disponibles.";
                        } else {
                            // Insert data into the Planning table
    $sql = "INSERT INTO Planning (jour, temps_debut, temps_fin, entraineur_cin, groupe_id, terrain_id) 
            VALUES ('$jour','$temps_debut', '$temps_fin', '$entraineur', '$groupe', '$terrain')";

    if ($con->query($sql) === TRUE) {
        $infos = "Nouvelle Seance ajoutée avec succès";
    } else {
        echo "Erreur : " . $sql . "<br>" . $con->error;
    }
}
}
}
}
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
                        <h2>Ajouter une Seance </h2>
                        <?php if (!empty($infos)) { ?>
                             <p class="valide"><?php echo $infos; ?></p>
                        <?php } ?>
                        <?php if (!empty($info)) { ?>
                             <p class="error"><?php echo $info; ?></p>
                        <?php } ?>
                        <?php
                            $groupes = mysqli_query($con, "SELECT * FROM Groupe");
                            $entraineurs = mysqli_query($con, "SELECT * FROM Entraineur");
                            $terrains = mysqli_query($con, "SELECT * FROM Terrain");
                        ?>            
                            <label for="groupe">Groupe :</label>
                        <select name="groupe" id="groupe">
                            <?php while ($row = mysqli_fetch_assoc($groupes)) { ?>
                                <option value="<?= $row['id']; ?>"><?= $row['nom']; ?></option>
                            <?php } ?>
                        </select>

                        <label for="entraineur">Entraîneur :</label>
                        <select name="entraineur" id="entraineur">
                            <?php while ($row = mysqli_fetch_assoc($entraineurs)) { ?>
                                <option value="<?= $row['cin']; ?>"><?= $row['nom'] . " " . $row['prenom']; ?></option>
                            <?php } ?>
                        </select>

                        <label for="terrain">Terrain :</label>
                        <select name="terrain" id="terrain">
                            <?php while ($row = mysqli_fetch_assoc($terrains)) { ?>
                                <option value="<?= $row['id']; ?>"><?= $row['nom']; ?></option>
                            <?php } ?>
                        </select>

                        <label for="jour">Jour :</label>
                        <select  name="jour" id="jour" >
                            <option value="Lundi">Lundi</option>
                            <option value="Mardi">Mardi</option>
                            <option value="Mercredi">Mercredi</option>
                            <option value="Jeudi">Jeudi</option>
                            <option value="vendredi">vendredi</option>
                            <option value="Samedi">Samedi</option>
                            <option value="Dimanche">Dimanche</option>

                        </select>
                        <label for="temps">Temps debut :</label>
                        <input type="time"name="temps" id="temps" >
                        <div class="groupeAjout">
                                <button type="submit" name="submit">Ajouter</button>
                            </div>
                    </form>
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