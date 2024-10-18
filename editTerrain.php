<?php 
require_once "securite.php";
require_once "connection.php";
include "navigation.php";
if($_GET) {
    extract($_GET);
    }
$req = "SELECT * FROM Terrain where id='$id' ";
$result1 = mysqli_query($con,$req);
while($row = mysqli_fetch_assoc($result1)) {
   
    $nom=$row["nom"]; 
    $localisation=$row["localisation"];
}

if($_POST){
    extract($_POST);

   
$req2 = "UPDATE Terrain SET nom = '$nom', 
localisation = '$localisation' 
WHERE id = '$id'";
$result = mysqli_query($con, $req2);

if ($result) {
    $_SESSION['info'] = "Terrain modifié avec succès";
    header("location: Terrains.php");
    exit;
} 
else 
{
    $_SESSION['info'] = "Échec de la modification.";
    header("location: Terrains.php");
    exit;
}
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modification Terrain </title>
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
                        <h2>Modifier Entraineur</h2>
                            <label for="nom">*Nom</label>
                            <input type="text" value="<?php echo $nom?>" name="nom" >
                            <label for="localisation">*Localisation</label>
                            <input type="text" value="<?php echo $localisation?>" name="localisation" >
                            <div class="groupeAjout">
                                <button type="submit" name="submit">Modifier</button>
                            </div>
                            <?php if (!empty($info)) echo "<span>" . $info . "</span>"; ?>

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

