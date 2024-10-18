<?php
require_once "securite.php";
require_once "connection.php";
include "navigation.php";

$sql1 = "SELECT * FROM Paiement_Entraineur ORDER BY id DESC";
$result1 =mysqli_query($con,$sql1);
$nb=mysqli_num_rows($result1);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historique Paiement Entraineur</title>
    <link rel="stylesheet" href="styleDashbord.css">
</head>

<body>
    <div class="main">
        <div class="topbar">
          <div class="toggle"><ion-icon name="menu-outline"></ion-icon></div>
            <div class="search"><form action="rechercheHistEntraineur.php" method="GET">
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
                    <h2>Historique de Paiment Entraineur</h2>
                </div>
                <?php if ($nb > 0) {   ?>
            <table >
            <thead>
                    <tr>
                        <th>CIN</th>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Montant</th>
                        <th>Debut</th>
                        <th>Fin</th>
                        <th> Mois</th>
                        <th>Imprimer</th>
                        <th colspan="2">Option</th>

                    </tr>
                </thead>
                <tbody>
                <?php while($row = mysqli_fetch_assoc($result1)) { ?>
                    <tr>
                        <td align="center"><?php echo $row['cin']; ?></td>
                        <td align="center"><?php echo $row['nom']; ?></td>
                        <td align="center"><?php echo $row['prenom']; ?></td>
                        <td align="center"><?php echo $row['montant']; ?></td>
                        <td align="center"><?php echo $row['date_debut']; ?></td>
                        <td align="center"><?php echo $row['date_fin']; ?></td>
                        <td align="center"><?php echo $row['nb_mois']; ?></td>
                        <td align="center"><a href="print_page_Entraineur.php?cin=<?= $row["cin"]?>" target="_blank"><ion-icon name="print-outline"></ion-icon></a></td>
                        <td align="center"><a onclick="return confirm('Êtes-vous sûr de vouloir modifier ce Paiment ?')" href="editPaimentEntraineur.php?id=<?php echo ($row["id"]);?>"><ion-icon name="create-outline"></ion-icon></a></td>
                        <td align="center"><a onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce Paiment ?')" href="deletePaimentEntraineur.php?id=<?php echo($row["id"]); ?>"><ion-icon name="trash-outline"></ion-icon></a></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
            <?php } 
                else {?>  
            <div class="jumbotron">
                <h1>Aucun Paiment Enregistré</h1>
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