<?php
require_once 'securite.php';
require_once 'connection.php';
if (isset($_GET['id'])) {  
    $id = trim($_GET["id"]);
    $query = "DELETE FROM Paiement_Entraineur WHERE id='$id'";
    $result = mysqli_query($con, $query);
    
    if ($result) {
        $_SESSION['info'] = " Paiement supprimé avec succès";
        header("location: historique_paiementEntraineur.php");
        exit;
    } else {
        echo "Erreur lors de la suppression : " . mysqli_error($con); // Debugging line
    }
}
?>
