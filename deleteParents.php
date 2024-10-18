<?php
require_once 'securite.php';
require_once 'connection.php';
if (isset($_GET['cin'])) {  
    $cin = trim($_GET["cin"]);
    $query = "DELETE FROM Parents WHERE cin='$cin'";
    $result = mysqli_query($con, $query);
    
    if ($result) {
        $_SESSION['info'] = " Parent supprimé avec succès";
        header("location: Parents.php");
        exit;
    } else {
        echo "Erreur lors de la suppression : " . mysqli_error($con); // Debugging line
    }
}
?>
