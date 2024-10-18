<?php
require_once "connection.php";
require_once "securite.php";
include "navigation.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paiement</title>
    <link rel="stylesheet" href="styleDashbord.css">

</head>
<body>
    <div class="main">
        <div class="topbar">
            <div class="toggle"><ion-icon name="menu-outline"></ion-icon></div>
            <div class="user">
            <div class="notification"><a href="notifications.php"><ion-icon name="notifications-outline"></ion-icon></a></div>
            <div class="userType">
                    <select  id="userTypeSelect">
                        <option value="admin">Admin</option>
                        <option value="user">user</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="cardBox">
            <a href="addPaiementEntraineur.php">
              <div class="card">
                <div>
                    <div class="cardName">Paiement Entraineur</div>

                </div>
                <div class="iconBox"><ion-icon name="person-outline"></ion-icon></div>
              </div>
            </a>
            <a href="historique_paiementEntraineur.php">
             <div class="card">
                <div>
                    <div class="numbers"></div>    
                    <div class="cardName">Historique de Paiement Entraineur</div>
                </div>
                <div class="iconBox"><ion-icon name="receipt-outline"></ion-icon></div>
             </div>
            </a>
            <a href="addPaiementJoueur.php">
             <div class="card">
                <div>
                    <div class="cardName">Paiement Joueur</div>
                </div>
                <div class="iconBox"><ion-icon name="accessibility-outline"></ion-icon></div>
             </div>
            </a>
            <a href="historique_paiementJoueur.php">
             <div class="card">
                <div>
                    <div class="numbers"></div>    
                    <div class="cardName">Historique de Paiement Joueur</div>
                </div>
                <div class="iconBox"><ion-icon name="receipt-outline"></ion-icon></div>
             </div>
            </a>
        </div>
    </div>
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