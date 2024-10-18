<?php
require_once "connection.php";
require_once "securite.php";
include "navigation2.php";
$sql1 = "SELECT * FROM Parents;";
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
            <div class="search"><form action="rechercheParents.php" method="GET">
                <input type="text" name="search" placeholder="Recherche">
                <button type="submit"><ion-icon name="search-outline"></ion-icon></button>
            </form>
        </div>
            <div class="user">
                <div class="userType">
                <select id="userTypeSelect">
                        <option value="admin">Membre</option>
                </select>
            </div>
            </div>
        </div>
        <div class="detaille">
            <div class="affichageTable">
                <div class="cardHeader">
                    <h2>Table Parents</h2>
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
                            <th>Enfant</th>
                       </tr>
                    </thead>
                    <TBody>
                        <?php while($row = mysqli_fetch_assoc($result1)) { ?>
                        <tr>
                            <td class="photobx"><div class="imgBX"><img src="img/<?php echo $row["photo"];?>" ></div></td>
                            <td align="center"><?php echo $row["cin"]; ?></td>
                            <td align="center"><?php echo $row["nom"]; ?></td>
                            <td align="center"><?php echo $row["prenom"]; ?></td>
                            <td align="center"><?php echo $row["num_tel"]; ?></td>
                            <td align="center"><a href="rechercheEnfant.php?joueur_code=<?php echo $row["joueur_code"]?>">Enfant</a></td>
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
    <script src="./main.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>