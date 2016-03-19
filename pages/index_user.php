<?php
session_start();
require("fonctions.php");
if ($_SESSION['isAdmin'] != 0) {
    header("location:../index.php");
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Projet Dunord</title>

    <!-- Style CSS-->
    <link rel="stylesheet" href="../css/normalize.css">
    <link rel="stylesheet" href="../css/skeleton.css">
    <link rel="stylesheet" href="../css/master.css">
    <link rel="icon" type="image/png" href="../css/images/favicon.png">
    <link href="//fonts.googleapis.com/css?family=Raleway:400,300,600" rel="stylesheet" type="text/css">
</head>

<body>
    <header>
        <h1 class="titre">Tableau de suivi des pannes</h1>
    </header>

    <section class="row">
        <nav class="two columns">
            <a href="ajout_panne.php">
                <button class="u-full-width button-menu">Déclarer un Incident</button>
            </a>
            <a href="deconnexion.php">
                <button class="u-full-width button-menu">Déconnexion</button>
            </a>
        </nav>

        <div class="ten columns">
            <table class="u-full-width">
                <tr>
                    <th>N° incident</th>
                    <th>Date d'incident</th>
                    <th>Nom</th>
                    <th>Numero Poste</th>
                    <th>Description</th>
                    <th>Statut</th>
                    <th>Date de résolution</th>
                </tr>
                <?php
                echo getIncidents();
                ?>
            </table>
        </div>
    </section>
</body>

</html>
