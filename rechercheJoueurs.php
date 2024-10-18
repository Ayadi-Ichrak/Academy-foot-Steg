<?php 
require_once "connection.php";
require_once "securite.php";
$search = ""; 
$info ="";
$userType = $_SESSION['user']['user_type']; // Récupérer le type d'utilisateur depuis la session
if ($userType == 'Admin') { 
    include "navigation.php";
}else{
    include "navigation2.php";
}

if(isset($_GET['search'])) {
	$search = $_GET['search'];
}

// Requête SQL avec la clause WHERE pour la recherche
$req = "SELECT * FROM Joueur 
        WHERE nom LIKE '%$search%' 
        OR prenom LIKE '%$search%' 
        OR code LIKE '%$search%' 
        OR groupe_id LIKE '%$search%'";
$result1 = mysqli_query($con, $req);
mysqli_query($con, "SET NAMES 'utf8'");
$count = mysqli_num_rows($result1);
if (isset($_SESSION['info'])) {
    $info = $_SESSION['info'];
    unset($_SESSION['info']); 
}
?>

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
                    <input type="text"name="search" placeholder="Recherche">
                    <button type="submit"><ion-icon name="search-outline"></ion-icon></button>
                </form>
            </div>
            <div class="user">
            <?php if ($userType == 'Admin') { ?>

            <div class="notification"><a href="notifications.php"><ion-icon name="notifications-outline"></ion-icon></a></div>
            <?php } ?>

            <div class="userType">
            <?php if ($userType == 'Admin') { ?>
                    <select id="userTypeSelect">
                        <option value="admin">Admin</option>
                        <option value="user">User</option>
                    </select>
                <?php } else { ?>
                    <select id="userTypeSelect">
                        <option value="admin">Membre</option>
                </select>
                <?php } ?>

                </div>
            </div>
        </div>
        <div class="detaille">
            <div class="affichageTable">
                <div class="cardHeader">
                    <h2>Table Joueurs</h2>
                    <?php if ($userType == 'admin') { ?>
                    <a href="addJoueurs.php" class="btn"><ion-icon name="add-outline"></ion-icon>Ajouter</a>
                    <?php } ?>
                </div>
                <?php if ($count > 0) {   ?>
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
                            <?php if ($userType == 'Admin') { ?>
                                <th colspan="2">Option</th>
                            <?php } ?>
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
                            <td align="center"><?php echo $row["groupe_id"]; ?></td>
                            <td align="center"><a href="rechercheParentDeJoueur.php?parent_cin=<?php echo $row["parent_cin"]?>">Parent</a></td>
                            <td align="center"><a href="printBadge.php?code=<?php echo $row["code"]?>" target="_blank"><ion-icon name="print-outline"></ion-icon></a></td>
                            <?php if ($userType == 'Admin') { ?>
                            <td align="center"><a onclick="return confirm('Êtes-vous sûr de vouloir modifier ce joueur ?')" href="editJoueurs.php?code=<?php echo ($row["code"]);?>"><ion-icon name="create-outline"></ion-icon></a></td>
                            <td align="center"><a onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce joueur ?')" href="deleteJoueurs.php?code=<?php echo($row["code"]); ?>"><ion-icon name="trash-outline"></ion-icon></a></td>
                            <?php } ?>
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
        <div class="rectangle"></div>
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