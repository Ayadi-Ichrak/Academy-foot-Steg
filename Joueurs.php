<?php
require_once "connection.php";
require_once "securite.php";
include "navigation.php";
$sql1 = "SELECT Joueur.code ,Joueur.nom,Joueur.prenom,Joueur.date_naissance, Joueur.photo,Joueur.parent_cin ,Joueur.groupe_id AS groupe FROM Joueur;";
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
    <title>Joueurs</title>
    <link rel="stylesheet" href="styleDashbord.css">
</head>
<body>
<div class="main">
        <div class="topbar">
            <div class="toggle"><ion-icon name="menu-outline"></ion-icon></div>
            <div class="search"><form action="rechercheJoueurs.php" method="GET">
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
                    <h2>Table Joueurs</h2>
                    <a href="addJoueur.php" class="btn"><ion-icon name="add-outline"></ion-icon>Ajouter</a>
                </div>
                <?php if ($nb > 0) {   ?>
                <table>
                    <thead>
                        <tr>
                            <th></th>
                            <th>code</th>
                            <th>Nom</th>
                            <th>Prenom</th>
                            <th>Date Naissance</th>
                            <th>Groupe</th>
                            <th>Parent</th>
                            <th>Badge</th>
                            <th colspan="2">Option</th>
                        </tr>
                    </thead>
                    <TBody>
                        <?php while($row = mysqli_fetch_assoc($result1)) { ?>
                        <tr>
                            <td class="photobx"><div class="imgBX"><img src="img/<?php echo $row["photo"];?>" ></div></td>
                            <td align="center"><?php echo $row["code"]; ?></td>
                            <td align="center"><?php echo $row["nom"]; ?></td>
                            <td align="center"><?php echo $row["prenom"]; ?></td>
                            <td align="center"><?php echo $row["date_naissance"]; ?></td>
                            <td align="center"><?php echo $row["groupe"]; ?></td>
                            <td align="center"><a href="rechercheParentDeJoueur.php?parent_cin=<?php echo $row["parent_cin"]?>">Parent</a></td>
                            <td align="center"><a href="printBadge.php?code=<?php echo $row["code"]?>" ><ion-icon name="print-outline"></ion-icon></a></td>
                            <td align="center"><a onclick="return confirm('Êtes-vous sûr de vouloir modifier ce joueur ?')" href="editJoueurs.php?code=<?php echo ($row["code"]);?>"><ion-icon name="create-outline"></ion-icon></a></td>
                            <td align="center"><a onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce joueur ?')" href="deleteJoueurs.php?code=<?php echo($row["code"]); ?>"><ion-icon name="trash-outline"></ion-icon></a></td>
                        </tr>
                        <?php } ?>
                    </TBody>
                </table>    
            </div>
            <?php } 
                else {?>  
            <div class="jumbotron">
                <h1>Aucun joueur trouvé</h1>
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