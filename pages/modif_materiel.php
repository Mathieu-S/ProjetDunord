<?php
session_start();
require("fonctions.php");
$materielSelect =  getMaterielByTag($_GET['tag']);
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
    <h1 class="titre">Gestion du Matériel</h1>
</header>

<section>
    <h3>Modifier un Appareil</h3>
    <form action="M_modf_materiel.php" method="post">
        <label for="">Veuillez saisir vos données dans le formulaire ci-dessous :</label>
        <aside class="row">
            <div class="two columns">
                <label class="description" for="element_3">N° Poste</label>
                <input id="element_3" name="id" class="u-full-width" type="number" maxlength="4" value="<?php echo $materielSelect['id']?>" />
            </div>
            <div class="three columns">
                <label class="description" for="element_8">Type d'Appareil</label>
                <select class="u-full-width" name="type" id="">
                    <?php
                    switch ($materielSelect['type']) {
                        case "Desktop":
                            echo '<option value="Desktop">Desktop</option>
                                    <option value="Laptop">Laptop</option>
                                    <option value="Tablet">Tablet</option>
                                    <option value="Smartphone">Smartphone</option>';
                            break;
                        case "Laptop":
                            echo '<option value="Laptop">Laptop</option>
                                    <option value="Desktop">Desktop</option>
                                    <option value="Tablet">Tablet</option>
                                    <option value="Smartphone">Smartphone</option>';
                            break;
                        case "Tablet":
                            echo '<option value="Tablet">Tablet</option>
                                    <option value="Desktop">Desktop</option>
                                    <option value="Laptop">Laptop</option>
                                    <option value="Smartphone">Smartphone</option>';
                            break;
                        case "Smartphone":
                            echo '<option value="Smartphone">Smartphone</option>
                                    <option value="Laptop">Laptop</option>
                                    <option value="Tablet">Tablet</option>
                                    <option value="Desktop">Desktop</option>';
                            break;
                    } ?>
                    <option value="Desktop">Desktop</option>
                    <option value="Laptop">Laptop</option>
                    <option value="Tablet">Tablet</option>
                    <option value="Smartphone">Smartphone</option>
                </select>
            </div>
            <div class="four columns">
                <label for="">Service TAG</label>
                <input id="element_3" name="tag" class="u-full-width" type="text" maxlength="255" disabled value="<?php echo $materielSelect['tag']?>" />
                <input type="hidden" name="tag" value="<?php echo $materielSelect['tag']?>">
            </div>
            <div class="three columns">
                <label for="">Multi-Utilisateurs</label>
                <?php if ($materielSelect['multyUser'] == 1) { ?>
                    <input name="multyUser" type="checkbox" checked>
                <?php } else {?>
                    <input name="multyUser" type="checkbox">
                <?php } ?>
            </div>
        </aside>
        <button class="button-primary button-ajout-user" type="submit">Valider</button>
    </form>
    <a class="fix_link" href="gestion_materiel.php"><button class="btn_annuler">Annuler</button></a>
</section>

</body>

</html>
