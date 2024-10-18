<?php
// Database connection
require_once "connection.php";
require_once "securite.php";

$userType = $_SESSION['user']['user_type']; // Récupérer le type d'utilisateur depuis la session
if ($userType == 'Admin') { 
    include "navigation.php";
}else{
    include "navigation2.php";
}

// Get the ID from the URL
$parent_cin = isset($_GET['parent_cin']) ? intval($_GET['parent_cin']) :'';

// Fetch the row based on the ID
$query = "SELECT * FROM Parents WHERE cin = '$parent_cin';"  ;
$result = mysqli_query($con, $query);
$nb=mysqli_num_rows($result);


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parents Joueurs</title>
    <link rel="stylesheet" href="styleDashbord.css">
</head>
<body>
<div class="main">
        <div class="topbar">
            <div class="toggle"><ion-icon name="menu-outline"></ion-icon></div>
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
                    <h2>Parents du Joueur: </h2>
                </div>
                <?php if ($nb > 0) {   ?>
                <table>
                    <thead>
                        <tr>
                            <th></th>
                            <th>CIN</th>
                            <th>Nom</th>
                            <th>Prenom</th>
                            <th>Telephone</th>
                            <th>Badge</th>
                            <?php if ($userType == 'Admin') { ?>
                                <th colspan="2">Option</th>
                            <?php } ?>                        
                        </tr>
                    </thead>
                    <TBody>
                        <?php while($row = mysqli_fetch_assoc($result)) { ?>
                        <tr>
                            <td class="photobx"><div class="imgBX"><img src="img/<?php echo $row["photo"];?>" ></div></td>
                            <td align="center"><?php echo $row["cin"]; ?></td>
                            <td align="center"><?php echo $row["nom"]; ?></td>
                            <td align="center"><?php echo $row["prenom"]; ?></td>
                            <td align="center"><?php echo $row["num_tel"]; ?></td>
                            <td align="center"><a href="printBadgeParent.php?cin=<?php echo $row["cin"]?>" target="_blank"><ion-icon name="print-outline"></ion-icon></a></td>
                            <?php if ($userType == 'Admin') { ?>
                            <td align="center"><a onclick="return confirm('Êtes-vous sûr de vouloir modifier ce Parents ?')" href="editParents.php?cin=<?php echo ($row["cin"]);?>"><ion-icon name="create-outline"></ion-icon></a></td>
                            <td align="center"><a onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce Parents ?')" href="deleteParents.php?cin=<?php echo($row["cin"]); ?>"><ion-icon name="trash-outline"></ion-icon></a></td>
                            <?php } ?>
                        </tr>
                        <?php } ?>
                    </TBody>
                </table>    
            </div>
            <?php } 
                else {?>  
            <div class="jumbotron">
                <h1>Aucun Parents trouvé</h1>
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
