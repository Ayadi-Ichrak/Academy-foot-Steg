<?php
session_start();
if(!isset($_SESSION['user'])&& !isset($_SESSION['admin'])){
    $_SESSION['info'] = "Accèss non autorisé";
    header("location:index.php");
    exit;
}
?>