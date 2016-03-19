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
        <h1 class="titre">Gestion des Utilisateurs</h1>
    </header>

    <div class="row">
        <section class="six columns">
            <h3>Liste des utilisateurs</h3>
            <table class="u-full-width">
                <tr>
                    <th>id</th>
                    <th>Nom</th>
                    <th>N° Poste</th>
                    <th>Service</th>
                    <th>Droit</th>
                    <th>Modifier/Suprimer</th>
                </tr>
                <?php getUtilisateur(); ?>
            </table>
        </section>

        <section class="six columns">
            <h3>Ajouter un utilisateur</h3>
            <form action="M_ajout_util.php" method="post">
                <label for="">Veuillez saisir vos données dans le formulaire ci-dessous :</label>
                <aside class="row">
                    <div class="four columns">Nom
                        <input id="element_3" name="nom" class="u-full-width" type="text" maxlength="255"/>
                    </div>
                    <div class="four columns">Login
                        <input id="element_3" name="login" class="u-full-width" type="text" maxlength="255"/>
                    </div>
                    <div class="four columns">Mot de passe
                        <input id="element_3" name="mdp" class="u-full-width" type="password" maxlength="255"/>
                    </div>
                </aside>
                <aside class="row">
                    <div class="two columns">
                        <label class="description" for="element_3">N° Poste</label>
                        <input name="nPoste" class="u-full-width" type="number" maxlength="255"/>
                    </div>
                    <div class="five columns">
                        <label class="description" for="element_8">Type d'utilisateur</label>
                        <select class="u-full-width" name="typeUtil">
                            <option value="0">Utilisateur</option>
                            <option value="1">Administrateur</option>
                        </select>
                    </div>
                    <div class="five columns">
                        <label for="">Service concerné</label>
                        <input name="service" class="u-full-width" type="text" maxlength="255"/>
                    </div>
                </aside>
                <button class="button-primary button-ajout-user" type="submit">Valider</button>
            </form>
        </section>
    </div>
</body>

</html>
