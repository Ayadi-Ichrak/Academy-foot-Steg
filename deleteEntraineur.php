<?php
require_once 'securite.php';
require_once 'connection.php';
if (isset($_GET['cin'])) {  
    $cin = trim($_GET["cin"]);
    $query = "DELETE FROM Entraineur WHERE cin='$cin'";
    $result = mysqli_query($con, $query);
    
    if ($result) {
        $_SESSION['info'] = " Entraineur supprimé avec succès";
        header("location: Entraineurs.php");
        exit;
    } else {
        echo "Erreur lors de la suppression : " . mysqli_error($con); // Debugging line
    }
}
?>
