<?php
require_once "connection.php";
session_start();

if ($_POST) {
    extract($_POST);
    if (empty(trim($login)) || empty(trim($password))) {
        $_SESSION['info'] = "Champ(s) vide(s) ....";
        header("location:index.php");
        exit;
    } else {
        $login = trim($_POST['login']);
        $password = trim($_POST['password']);
        $query = "SELECT * FROM users WHERE identifiant='$login' AND pass='$password'";
        $result = mysqli_query($con, $query);
        $count = mysqli_num_rows($result);
        if ($count == 1) {
            $row = mysqli_fetch_assoc($result);
            $_SESSION['user'] = $row;
            if ($row['user_type'] == 'Admin') {
                header("location:dashbord1.php");
            } elseif ($row['user_type'] == 'Gestionnaire') {
                header("location:Gestionnaires.php");
            } elseif ($row['user_type'] == 'Membre') {
                header("location:dashbord2.php");
            }
            exit;
        } else {
            $_SESSION['info'] = "Identifiant ou mot de passe incorrect";
            header("location:index.php");
            exit;
        }
    }
}

$info ="";
if(isset($_SESSION["info"])){
    $info = $_SESSION["info"];
}
unset($_SESSION["info"]);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOGIN</title>
    <link rel="stylesheet" href="./styleLogin.css">
</head>
<body>
    <div class="bloc">
        <video autoplay="autoplay" muted="" src="img/blueBg.mp4"></video>
        <div class="logo">
            <div class="up">
                <img src="./img/logo-removebg.png">
            </div>
            <form method="post">
                <h2>Connexion</h2>
                <?php if (!empty($info)) { ?>
                    <p class="error"><?php echo $info; ?></p>
                <?php } ?>
                <label >Identifiant</label>
                <input type="text" name="login" placeholder="identifiant" >
                <label >Mot de passe</label>
                <input type="password" name="password" placeholder="mot de passe">
                <button type="submit">Se connecter</button>
            </form>
        </div>
        <div class="logoButum">
        <img src="./img/steg-removebg.png" alt="">
        <img src="./img/club.png" alt="">
        <img src="./img/amicale.png" alt="">
        </div>
    </div>
</body>
</html>