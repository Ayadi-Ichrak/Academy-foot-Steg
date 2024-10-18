<?php
require_once 'securite.php';
require_once 'connection.php';
if (isset($_GET['code'])) {  
    $code = trim($_GET["code"]);
    $query = "DELETE FROM Joueur WHERE code='$code'";
    $result = mysqli_query($con, $query);
    
    if ($result) {
        $_SESSION['info'] = " Joueur supprimé avec succès";
        header("location: Joueurs.php");
        exit;
    } else {
        echo "Erreur lors de la suppression : " . mysqli_error($con); // Debugging line
    }
}
?>
