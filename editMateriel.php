<?php 
require_once "securite.php";
require_once "connection.php";
include "navigation.php";
if($_GET) {
    extract($_GET);
    }
$req = "SELECT * FROM Materiel where id='$id' ";
$result1 = mysqli_query($con,$req);
while($row = mysqli_fetch_assoc($result1)) {
   
    $nom=$row["nom"]; 
    $quantite=$row["quantite"];
    $date_achat=$row['date_achat'] ;
}

if($_POST){
    extract($_POST);

   
$req2 = "UPDATE Materiel SET nom = '$nom', 
quantite = '$quantite', 
date_achat = '$date_achat' 
WHERE id = '$id'";
$result = mysqli_query($con, $req2);

if ($result) {
    $_SESSION['info'] = "Materiel modifié avec succès";
    header("location: Materiel.php");
    exit;
} 
else 
{
    $_SESSION['info'] = "Échec de la modification.";
    header("location: Materiel.php");
    exit;
}
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modification Materiel </title>
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
                        <h2>Modifier Materiel</h2>
                            <label for="nom">*Materiel</label>
                            <input type="text" value="<?php echo $nom?>" name="nom" >
                            <label for="quantite">*quantite</label>
                            <input type="text" value="<?php echo $quantite?>" name="quantite" >
                            <label for="date_achat">*Date Achat</label>
                            <input type="text" value="<?php echo $date_achat?>" name="date_achat">
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

