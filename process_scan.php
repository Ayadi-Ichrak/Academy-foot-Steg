<?php
require_once "connection.php";
require_once "securite.php";
$message = "";
$player = null; // Variable to hold player details, if valid
$terrain_id = null; // Initialize terrain_id
$current_time = null; // Initialize current_time

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['code_joueur'])) {
    $code_joueur = $_GET['code_joueur'];

    // 1. Vérifier si le joueur existe dans la table Joueur
    $query = "SELECT * FROM Joueur WHERE code = '$code_joueur'";
    $result = mysqli_query($con, $query);

    if (mysqli_num_rows($result) > 0) {
        $player = mysqli_fetch_assoc($result);

        // 2. Vérifier si la date de fin de paiement est supérieure à la date du jour
        $current_time = date("H:i:s");
        $today = date("Y-m-d");
        $query_payment = "SELECT * FROM Paiement_Joueur WHERE code = '$code_joueur' AND date_fin >= '$today'";
        $result_payment = mysqli_query($con, $query_payment);

        if (mysqli_num_rows($result_payment) > 0) {
            date_default_timezone_set("Africa/Tunis");

            // 3. Vérifier si le joueur a une séance aujourd'hui et à l'heure actuelle
            $currentDay = date('l');

            // Traduire le jour en français
            $jours = [
                'Monday' => 'Lundi',
                'Tuesday' => 'Mardi',
                'Wednesday' => 'Mercredi',
                'Thursday' => 'Jeudi',
                'Friday' => 'Vendredi',
                'Saturday' => 'Samedi',
                'Sunday' => 'Dimanche'
            ];
            $jour_francais = $jours[$currentDay];

            $query_planning = "SELECT * FROM Planning 
                               WHERE groupe_id = '{$player['groupe_id']}' 
                               AND jour = '$jour_francais'";
            $result_planning = mysqli_query($con, $query_planning);

            if (mysqli_num_rows($result_planning) > 0) {
                $session = mysqli_fetch_assoc($result_planning);
                $startTime = date('H:i:s', strtotime($session['temps_debut'] . ' -1 hour'));
                if ($current_time > $startTime && $current_time < $session['temps_fin']) {
                    $message = "Joueur validé";
                    $background_color = "rgba(0, 128, 0, 0.362)";
                    $border = "green"; // Couleur verte pour succès
                    $terrain_id = $session['terrain_id'];
                    $validiter = "Entrée valide";
                    // Insertion dans la table historique_acces avec validité
                    $insertQuery = "INSERT INTO historique_acces (joueur_code, nom, prenom, validiter, groupe_id, date_acces, terrain_id, heure) 
                                    VALUES ('{$player['code']}', '{$player['nom']}', '{$player['prenom']}', '$validiter', '{$player['groupe_id']}', '$today', '$terrain_id', '$current_time')";
                    mysqli_query($con, $insertQuery);

                } else {
                    $message = "La séance n'est pas prévue à cette heure";
                    $background_color = "rgba(255, 0, 0, 0.249)"; // Couleur rouge pour échec
                    $border = "2px solid red";
                    $validiter = "Heure invalide";
                    // Insertion dans la table historique_acces avec validité
                    $insertQuery = "INSERT INTO historique_acces (joueur_code, nom, prenom, validiter, groupe_id, date_acces, terrain_id, heure) 
                                    VALUES ('{$player['code']}', '{$player['nom']}', '{$player['prenom']}', '$validiter', '{$player['groupe_id']}', '$today', '$terrain_id', '$current_time')";
                    mysqli_query($con, $insertQuery);

                }
            } else {
                $message = "La séance n'est pas prévue aujourd'hui";
                $background_color = "rgba(255, 0, 0, 0.249)";
                $border = "2px solid red";
                $validiter = "Jour invalide";
                // Insertion dans la table historique_acces avec validité
                $insertQuery = "INSERT INTO historique_acces (joueur_code, nom, prenom, validiter, groupe_id, date_acces, terrain_id, heure) 
                                VALUES ('{$player['code']}', '{$player['nom']}', '{$player['prenom']}', '$validiter', '{$player['groupe_id']}', '$today', '$terrain_id', '$current_time')";
                mysqli_query($con, $insertQuery);

            }
        } else {
            $message = "Le paiement n'est pas valide";
            $background_color = "rgba(255, 0, 0, 0.249)";
            $border = "2px solid red";
            $validiter = "Paiement invalide";
            // Insertion dans la table historique_acces avec validité
            $insertQuery = "INSERT INTO historique_acces (joueur_code, nom, prenom, validiter, groupe_id, date_acces, terrain_id, heure) 
                            VALUES ('{$player['code']}', '{$player['nom']}', '{$player['prenom']}', '$validiter', '{$player['groupe_id']}', '$today', '$terrain_id', '$current_time')";
            mysqli_query($con, $insertQuery);

        }


    } else {
        $message = "Le joueur n'est pas trouvé";
        $background_color = "rgba(255, 0, 0, 0.249)";
        $border = "2px solid red";
    }

    mysqli_close($con);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styleGestionnaire.css">
    <title>SCAN QR CODE Joueur</title>
</head>

<body>
    <div class="navbar">
        <div class="logo">
            <img src="./img/logo-removebg.png">
            <span class="title">Tiger foot Academy</span>
        </div>
        <a href="logout.php"><ion-icon name="power-outline"></ion-icon></a>
    </div>
    <div class="container">
        <div class="block" style="background-color: <?= $background_color ?>; border:<?= $border ?>">
            <h3 style="color: <?= $border ?>"><?php echo $message; ?></h3>
            <?php if ($player) { ?>
                <img src="img/<?= $player['photo'] ?>" alt="Photo du joueur"><br>
                <p><strong>Nom: </strong> <?= $player['nom'] ?></p>
                <p><strong>Prénom: </strong> <?= $player['prenom'] ?></p>
                <p><strong>Groupe: </strong><?= $player['groupe_id'] ?></p>
                <p><strong>Date de Naissance: </strong><?= $player['date_naissance'] ?></p>
            <?php } ?>
        </div>
    </div>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>

</html>"

