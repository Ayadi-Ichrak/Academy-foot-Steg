<?php
require_once "connection.php";
require_once "securite.php";

// Récupérer le nombre de lignes pour chaque table
$query = "SELECT COUNT(*) as count FROM Joueur";
$result = mysqli_query($con, $query);
$joueursCount = mysqli_fetch_assoc($result)['count'];

$query = "SELECT COUNT(*) as count FROM Parents";
$result = mysqli_query($con, $query);
$parentsCount = mysqli_fetch_assoc($result)['count'];

$query = "SELECT COUNT(*) as count FROM Entraineur";
$result = mysqli_query($con, $query);
$entraineursCount = mysqli_fetch_assoc($result)['count'];

$query = "SELECT COUNT(*) as count FROM Groupe";
$result = mysqli_query($con, $query);
$groupesCount = mysqli_fetch_assoc($result)['count'];

$query = "SELECT COUNT(*) as count FROM Terrain";
$result = mysqli_query($con, $query);
$terrainsCount = mysqli_fetch_assoc($result)['count'];

$query = "SELECT COUNT(*) as count FROM Materiel";
$result = mysqli_query($con, $query);
$materielCount = mysqli_fetch_assoc($result)['count'];

$query = "SELECT COUNT(*) as count FROM Planning";
$result = mysqli_query($con, $query);
$planningCount = mysqli_fetch_assoc($result)['count'];


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tiger foot Academy</title>
    <link rel="stylesheet" href="styleDashbord.css">
</head>

<body>
    <div class="container">
        <div class="navigation">
            <ul>
                <li><a href="dashbord2.php"><span class="icon"> <img src="./img/logo-removebg.png"></span><span
                            class="title">Tiger foot Academy</span></a></li>
                <li><a href="dashbord2.php"><span class="icon"><ion-icon name="home-outline"></ion-icon></span><span
                            class="title">Home</span></a></li>
                <li><a href="Joueurs2.php"><span class="icon"><ion-icon
                                name="accessibility-outline"></ion-icon></span><span class="title">Joueurs</span></a>
                </li>
                <li><a href="Parents2.php"><span class="icon"><ion-icon name="people-outline"></ion-icon></span><span
                            class="title">Parents</span></a></li>
                <li><a href="Entraineur2.php"><span class="icon"><ion-icon name="person-outline"></ion-icon></span><span
                            class="title">Entraîneurs</span></a></li>
                <li><a href="Groupes2.php"><span class="icon"><ion-icon name="medal-outline"></ion-icon></span><span
                            class="title">Groupes</span></a></li>
                <li><a href="Terrain2.php"><span class="icon"><ion-icon name="cash-outline"></ion-icon></span><span
                            class="title">Terrains</span></a></li>
                <li><a href="Planning2.php"><span class="icon"><ion-icon name="today-outline"></ion-icon></span><span
                            class="title">Planning</span></a></li>
                <li><a href="Materiel2.php"><span class="icon"><ion-icon name="football-outline"></ion-icon></span><span
                            class="title">Matériel</span></a></li>
                <li><a href="HistoriqueAcces2.php"><span class="icon"><ion-icon
                                name="checkmark-done-outline"></ion-icon></span><span class="title">Historique
                            Accès</span></a></li>
                <li><a href="logout.php"><span class="icon"><ion-icon name="power-outline"></ion-icon></span><span
                            class="title">Déconnexion</span></a></li>


            </ul>
        </div>
    </div>
    <div class="main">
        <div class="topbar">
            <div class="toggle"><ion-icon name="menu-outline"></ion-icon></div>
            <div class="user">
                <div class="userType">
                <select id="userTypeSelect">
                        <option value="admin">Membre</option>
                </select>
                </div>
            </div>
        </div>
        <div class="cardBox">
            <a href="Joueurs2.php">
                <div class="card">
                    <div>
                        <div class="numbers"><?php echo $joueursCount; ?></div>
                        <div class="cardName">Joueurs</div>

                    </div>
                    <div class="iconBox"><ion-icon name="accessibility-outline"></ion-icon></div>
                </div>
            </a>
            <a href="Parents2.php">
                <div class="card">
                    <div>
                        <div class="numbers"><?php echo $parentsCount; ?></div>
                        <div class="cardName">Parents</div>

                    </div>
                    <div class="iconBox"><ion-icon name="people-outline"></ion-icon></div>
                </div>
            </a>
            <a href="Entraineur2.php">
                <div class="card">
                    <div>
                        <div class="numbers"><?php echo $entraineursCount; ?></div>
                        <div class="cardName">Entraineurs</div>

                    </div>
                    <div class="iconBox"><ion-icon name="person-outline"></ion-icon></div>
                </div>
            </a>
            <a href="Groupes2.php">
                <div class="card">
                    <div>
                        <div class="numbers"><?php echo $groupesCount; ?></div>
                        <div class="cardName">Groupes</div>

                    </div>
                    <div class="iconBox"><ion-icon name="medal-outline"></ion-icon></div>
                </div>
            </a>
            <a href="Terrain2.php">
                <div class="card">
                    <div>
                        <div class="numbers"><?php echo $terrainsCount; ?></div>
                        <div class="cardName">Terrains</div>

                    </div>
                    <div class="iconBox"><ion-icon name="cash-outline"></ion-icon></div>
                </div>
            </a>
            <a href="Materiel2.php">
                <div class="card">
                    <div>
                        <div class="numbers"><?php echo $materielCount; ?></div>
                        <div class="cardName"> Materiel </div>

                    </div>
                    <div class="iconBox"><ion-icon name="football-outline"></ion-icon></div>
                </div>
            </a>
            <a href="Planning2.php">
                <div class="card">
                    <div>
                        <div class="numbers"><?php echo $planningCount; ?></div>
                        <div class="cardName">Planning</div>

                    </div>
                    <div class="iconBox"><ion-icon name="today-outline"></ion-icon></div>
                </div>
            </a>
            <a href="HistoriqueAcces2.php">
                <div class="card">
                    <div>
                        <div class="cardName">Historique Accès</div>

                    </div>
                    <div class="iconBox"><ion-icon name="checkmark-done-outline"></ion-icon></div>
                </div>
            </a>
        </div>
    </div>
    <script src="./main.js"></script>
    <script>
        document.getElementById('userTypeSelect').addEventListener('change', function () {
            var selectedValue = this.value;
            if (selectedValue === 'user') {
                window.location.href = 'user.php';
            } else if (selectedValue === 'admin') {
                window.location.href = 'dashbord1.php';

            }
        });
    </script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>

</html>