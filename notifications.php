<?php
require_once "connection.php";
require_once "securite.php";
include "navigation.php";
// Date du système
$today = date('Y-m-d');
$notification_date = date('Y-m-d', strtotime($today . ' + 5 days'));

// Vérification pour les joueurs
$query_joueur = "SELECT * FROM Paiement_Joueur WHERE date_fin = '$notification_date'";
$result_joueur = mysqli_query($con, $query_joueur);

while ($row_joueur = mysqli_fetch_assoc($result_joueur)) {
    // Vérifier si la notification existe déjà
    $check_notification_joueur = "SELECT * FROM Notification_paiement WHERE type_utilisateur = 'Joueur' AND utilisateur_id = '{$row_joueur['code']}' AND date_fin = '{$row_joueur['date_fin']}'";
    $result_check_joueur = mysqli_query($con, $check_notification_joueur);

    if (mysqli_num_rows($result_check_joueur) == 0) {
        // Insérer la notification si elle n'existe pas
        $insert_notification_joueur = "INSERT INTO Notification_paiement (type_utilisateur, utilisateur_id, nom, prenom, date_fin, date_notification)
                                       VALUES ('Joueur', '{$row_joueur['code']}', '{$row_joueur['nom']}', '{$row_joueur['prenom']}', '{$row_joueur['date_fin']}', '$today')";
        mysqli_query($con, $insert_notification_joueur);
    }
}

// Vérification pour les entraîneurs
$query_entraineur = "SELECT * FROM Paiement_Entraineur WHERE date_fin = '$notification_date'";
$result_entraineur = mysqli_query($con, $query_entraineur);

while ($row_entraineur = mysqli_fetch_assoc($result_entraineur)) {
    // Vérifier si la notification existe déjà
    $check_notification_entraineur = "SELECT * FROM Notification_paiement WHERE utilisateur_id = '{$row_entraineur['cin']}' AND type_utilisateur = 'Entraineur' AND date_fin = '{$row_entraineur['date_fin']}'";
    $result_check_entraineur = mysqli_query($con, $check_notification_entraineur);

    if (mysqli_num_rows($result_check_entraineur) == 0) {
        // Si aucune notification trouvée, on insère une nouvelle notification
        $insert_notification_entraineur = "INSERT INTO Notification_paiement (type_utilisateur, utilisateur_id, nom, prenom, date_fin, date_notification)
                                           VALUES ('Entraineur', '{$row_entraineur['cin']}', '{$row_entraineur['nom']}', '{$row_entraineur['prenom']}', '{$row_entraineur['date_fin']}', '$today')";
        mysqli_query($con, $insert_notification_entraineur);
    }
}

$sql1 = "SELECT * FROM Notification_paiement  ;";
$result1 =mysqli_query($con,$sql1);
$nb=mysqli_num_rows($result1);

if (isset($_SESSION['info'])) {
    $info = $_SESSION['info'];
    unset($_SESSION['info']); 
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parents</title>
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
                    <h2>Notification Paiement </h2>
                </div>
                <?php if ($nb > 0) {   ?>
                <table>
                    <thead>
                        <tr>
                            <th>Notification</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <TBody>
                    <?php while ($row = mysqli_fetch_assoc($result1)) { ?>
                    <tr>
                        <td >
                            <?php 
                            if ($row["type_utilisateur"] == 'Entraineur') {
                                echo "Paiement de l'entraîneur " . $row["nom"] . " " . $row["prenom"] . "(CIN : " . $row["utilisateur_id"] . ") prend fin le " . $row["date_fin"] . ".";
                            } elseif ($row["type_utilisateur"] == 'Joueur') {
                                echo "Paiement du joueur " . $row["nom"] . " " . $row["prenom"] . "(Code : " . $row["utilisateur_id"] . ") prend fin le " . $row["date_fin"] . ".";
                            }
                            ?>
                        </td>
                         <td align="center"><a  href="deleteNotification.php?id=<?php echo($row["id"]); ?>"><ion-icon name="trash-outline"></ion-icon></a></td>
                    </tr>
                        <?php } ?>
                    </TBody>
                </table>    
            </div>
            <?php } 
                else {?>  
            <div class="jumbotron">
                <h1>Aucun Notification trouvé</h1>
                <p> <?php echo $con->error; ?> </p>
            </div>
            <?php } ?> 
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