<?php
session_start();
require("fonctions.php");
$utilSelect =  getUtilisateurById($_GET['id']);
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

<body class="ajout-panne">
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
        <h1 class="titre">Modification de l'utilisateur</h1>
    </header>

    <section>
        <form action="M_modf_utilisateur.php" method="post">
            <label for="">Veuillez modifier les données dans le formulaire ci-dessous :</label>
            <aside class="row">
                <div class="four columns"><label>Nom</label>
                    <input id="element_3" name="nom" class="u-full-width" type="text" maxlength="255" value="<?php echo $utilSelect['nom'];?>"/>
                </div>
                <div class="four columns"><label>Login</label>
                    <input id="element_3" name="login" class="u-full-width" type="text" maxlength="255" value="<?php echo $utilSelect['login'];?>"/>
                </div>
                <div class="four columns"><label>Mot de passe</label>
                    <input id="element_3" name="mdp" class="u-full-width" type="password" maxlength="255" value="NONE"/>
                </div>
                <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>">
            </aside>
            <aside class="row">
                <div class="two columns">
                    <label class="description" for="element_3">N° Poste</label>
                    <input name="nPoste" class="u-full-width" type="number" maxlength="255" value="<?php echo $utilSelect['numPoste'];?>"/>
                </div>
                <div class="five columns">
                    <label class="description" for="element_8">Type d'utilisateur</label>
                    <?php if ($utilSelect['isAdmin'] == 1) { ?>
                        <select class="u-full-width" name="typeUtil">
                            <option value="1">Administrateur</option>
                            <option value="0">Utilisateur</option>
                        </select>
                    <?php } else { ?>
                        <select class="u-full-width" name="typeUtil">
                            <option value="0">Utilisateur</option>
                            <option value="1">Administrateur</option>
                        </select>
                    <?php } ?>
                </div>
                <div class="five columns">
                    <label for="">Service concerné</label>
                    <input name="service" class="u-full-width" type="text" maxlength="255" value="<?php echo $_SESSION['service'];?>"/>
                </div>
            </aside>
            <button class="button-primary button-ajout-user" type="submit">Valider</button>
        </form>
        <a class="fix_link" href="gestion_utilisateur.php"><button class="btn_annuler">Annuler</button></a>
    </section>
</div>
</body>

</html>
