<?php 
require_once "securite.php";
require_once "connection.php";
include "navigation.php";
if($_GET) {
    extract($_GET);
    }
$req = "SELECT * FROM users where id='$id' ";
$result1 = mysqli_query($con,$req);
while($row = mysqli_fetch_assoc($result1)) {
   
    $identifiant=$row["identifiant"]; 
    $pass=$row["pass"];
    $user_type=$row["user_type"];
}

if($_POST){
    extract($_POST);

   
$req2 = "UPDATE users SET identifiant = '$identifiant', 
pass = '$pass',
user_type = '$user_type' 
WHERE id = '$id'";
$result = mysqli_query($con, $req2);

if ($result) {
    $_SESSION['info'] = "users modifié avec succès";
    header("location: user.php");
    exit;
} 
else 
{
    $_SESSION['info'] = "Échec de la modification.";
    header("location: user.php");
    exit;
}
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modification user </title>
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
                        <h2>Modifier User</h2>
                            <label for="identifiant">*Identifiant :</label>
                            <input type="text" value="<?php echo $identifiant?>" name="identifiant" >
                            <label for="pass">*Mot de Passe :</label>
                            <input type="text" value="<?php echo $pass?>" name="pass" >
                            <label for="user_type">*Type :</label>
                            <select  name="user_type" id="user_type" >
                                <option value="Admin" <?php if($user_type == 'Admin') echo 'selected'; ?>>Admin</option>
                                <option value="Gestionnaire"  <?php if($user_type == 'Gestionnaire') echo 'selected'; ?>>Gestionnaire</option>
                                <option value="Membre"<?php if($user_type == 'Membre') echo 'selected'; ?>>Membre</option>
                            </select>
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

