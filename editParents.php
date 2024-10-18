<?php 
require_once "securite.php";
require_once "connection.php";
include "navigation.php";
if($_GET) {
    extract($_GET);
    }
$req = "SELECT * FROM Parents where cin='$cin' ";
$result1 = mysqli_query($con,$req);
while($row = mysqli_fetch_assoc($result1)) {
   
    $nom=$row["nom"]; 
    $prenom=$row["prenom"];
    $num_tel=$row['num_tel'] ;
    $photo=$row["photo"];
    $joueur_code=$row["joueur_code"];
}

if($_POST){
    extract($_POST);

    if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
        $target_dir = "img/";
        $target_file = $target_dir . basename($_FILES["photo"]["name"]);
        if (move_uploaded_file($_FILES['photo']['tmp_name'], $target_file)) {
            $photo = $_FILES["photo"]["name"];
        } else {
            $photo = $row['photo'];
            $info = "Échec de l'upload de l'image.";
        }
    }
    
    
   
$req2 = "UPDATE Parents SET nom = '$nom', 
prenom = '$prenom', 
num_tel = '$num_tel', 
photo = '$photo', 
joueur_code = '$joueur_code' 
WHERE cin = '$cin'";
$result = mysqli_query($con, $req2);

if ($result) {
    $_SESSION['info'] = "Parents modifié avec succès";
    header("location: Parents.php");
    exit;
} 
else 
{
    $_SESSION['info'] = "Échec de la modification.";
    header("location: Parents.php");
    exit;
}
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modification Parents </title>
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
                        <h2>Modifier Parents</h2>
                            <label for="nom">*Nom</label>
                            <input type="text" value="<?php echo $nom?>" name="nom" >
                            <label for="prenom">*Prenom</label>
                            <input type="text" value="<?php echo $prenom?>" name="prenom" >
                            <label for="num_tel">*Telephone</label>
                            <input type="text" value="<?php echo $num_tel?>" name="num_tel">
                            <label for="joueur_code">*Joueur Code</label>
                            <input type="text" value="<?php echo $joueur_code?>" name="joueur_code">
                            <label for="photo">Image</label>
                            <input type="file" class="img" value="<?php echo $photo?>" name="photo">
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

