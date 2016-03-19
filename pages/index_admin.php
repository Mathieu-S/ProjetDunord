<?php
session_start();
require("fonctions.php");
if (empty($_SESSION['isAdmin'])) {
    header("location:../index.php");
} else if ($_SESSION['isAdmin'] != 1) {
    header("location:index_user.php");
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

    <!-- JavaScript -->
    <script type="text/javascript" src="https://code.jquery.com/jquery-2.2.2.min.js"></script>
    <script type="text/javascript" src="../js/master.js"></script>
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
            <a href="gestion_utilisateur.php">
                <button class="u-full-width button-menu">Gérer les Utilisateurs</button>
            </a>
            <a href="gestion_materiel.php">
                <button class="u-full-width button-menu">Gestion du Matériel</button>
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
                    <th>Option</th>
                </tr>
                <?php
                echo getIncidents();
                ?>
            </table>
        </div>
    </section>

    <article class="popup">
        <h2>Modifier le status</h2>
        <form action="M_modf_ticket.php" method="post">
            <select name="status">
                <option value="EC">En cours</option>
                <option value="R">Résolut</option>
                <option value="HS">Hors Service</option>
            </select>
            <input type="hidden" name="ticket" id="ticket" value="">
            <button class="button-primary mrg-l" type="submit">Valider</button>
        </form>
    </article>
</body>

</html>
