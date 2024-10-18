<?php
require_once "connection.php";
require_once "securite.php";
include "navigation.php";

// Requête pour récupérer les données du planning en groupant par jour
$sql = "SELECT 
            p.id,
            p.jour,
            p.temps_debut,
            p.temps_fin,
            e.nom AS entraineur_nom,
            g.nom AS groupe_nom,
            t.nom AS terrain_nom
        FROM 
            Planning p
        INNER JOIN 
            Entraineur e ON p.entraineur_cin = e.cin
        INNER JOIN 
            Groupe g ON p.groupe_id = g.id
        INNER JOIN 
            Terrain t ON p.terrain_id = t.id
        ORDER BY 
            p.jour, p.temps_debut";

$result = $con->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Planning</title>
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
                    <h2>Emploi du Temps: </h2>
                    <a href="addPlanning.php" class="btn"><ion-icon name="add-outline"></ion-icon>Ajouter</a>
                </div>
                   
                <?php if ($result && $result->num_rows > 0) { ?>
                    <table style="text-align:center;">
                    <thead>
                        <tr>
                            <th>Jours</th>
                            <th>Debut</th>
                            <th>Fin</th>
                            <th>Entraineur</th>
                            <th>Groupe</th>
                            <th>Terrain</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <TBody>
                       <?php 
                        $current_day = '';
                        while($row = $result->fetch_assoc()) {
                            if ($current_day != $row["jour"]) {
                                $current_day = $row["jour"];
                                echo "<tr><td colspan='6' style='font-weight: bold;text-align:left;'>{$row['jour']}</td></tr>";
                            }
                            echo "<tr>";
                            echo "<td></td>";
                            echo "<td>{$row['temps_debut']}</td>";
                            echo "<td>{$row['temps_fin']}</td>";
                            echo "<td>{$row['entraineur_nom']}</td>";
                            echo "<td>{$row['groupe_nom']}</td>";
                            echo "<td>{$row['terrain_nom']}</td>";
                            echo "<td align='center'><a onclick=\"return confirm('Êtes-vous sûr de vouloir supprimer cette séance ?')\" href=\"deletePlanning.php?id={$row['id']}\"><ion-icon name='trash-outline'></ion-icon></a></td>";
                            echo "</tr>";
                        }
                        ?>
                    </TBody>
                </table>    
            </div>
            <?php } 
                else {?>  
            <div class="jumbotron">
                <h1>Aucun joueur trouvé</h1>
                <p> <?php echo $con->error; ?> </p>
            </div>
            <?php } ?> 
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