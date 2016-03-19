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
</head>

<body>
    <header>
        <?php if ($_SESSION['isAdmin'] == 1) {?>
            <a href="index_admin.php">
                <img src="../css/images/home.png" alt="">
            </a>
        <?php } else {?>
            <a href="index_user.php">
                <img src="../css/images/home.png" alt="">
            </a>
        <?php } ?>
        <h1 class="titre">Gestion du Matériel</h1>
    </header>

    <div class="row">
        <section class="six columns">
            <h3>Liste du Matériel</h3>
            <table class="u-full-width">
                <tr>
                    <th>N° Poste</th>
                    <th>Type d'Appareil</th>
                    <th>Service Tag</th>
                    <th>Multi-Utilisateurs</th>
                    <th>Modifier/Suprimer</th>
                </tr>
                <?php getMateriel();?>
            </table>
        </section>

        <section class="six columns">
            <h3>Ajouter un Appareil</h3>
            <form action="M_ajout_meteriel.php" method="post">
                <label for="">Veuillez saisir vos données dans le formulaire ci-dessous :</label>
                <aside class="row">
                    <div class="two columns">
                        <label class="description" for="element_3">N° Poste</label>
                        <input id="element_3" name="id" class="u-full-width" type="number" maxlength="4" value="" />
                    </div>
                    <div class="three columns">
                        <label class="description" for="element_8">Type d'Appareil</label>
                        <select class="u-full-width" name="type" id="">
                            <option value="Desktop">Desktop</option>
                            <option value="Laptop">Laptop</option>
                            <option value="Tablet">Tablet</option>
                            <option value="Smartphone">Smartphone</option>
                        </select>
                    </div>
                    <div class="four columns">
                        <label for="">Service TAG</label>
                        <input id="element_3" name="tag" class="u-full-width" type="text" maxlength="255" value="" />
                    </div>
                    <div class="three columns">
                        <label for="">Multi-Utilisateurs</label>
                        <input name="multyUser" type="checkbox">
                    </div>
                </aside>
                <button class="button-primary button-ajout-user" type="submit">Valider</button>
            </form>
        </section>
    </div>
</body>

</html>
