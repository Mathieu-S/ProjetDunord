<?php
session_start();
if (empty($_SESSION['id'])) {
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
        <h1 class="titre">Ajout panne</h1>
    </header>

    <section>
        <form action="M_ajout_panne.php" method="post">
            <div class="row">
                <div class="four columns">
                    <label for="exampleEmailInput">Nom</label>
                    <input class="u-full-width" id="nomPersonne" name="nomPersonne" type="text" maxlength="255" value="<?php echo $_SESSION['nom'];?>">
                </div>
                <div class="four columns">
                    <label for="exampleEmailInput">Numéro de poste</label>
                    <input class="u-full-width" id="numPoste" name="numPoste" type="number" maxlength="4" value="<?php echo $_SESSION['numPoste'];?>">
                </div>
                <div class="four columns">
                    <label for="exampleRecipientInput">Service</label>
                    <input class="u-full-width" id="service" name="service" type="text" maxlength="255" value="<?php echo $_SESSION['service'];?>">
                </div>
            </div>
            <label for="exampleMessage">Description de la panne</label>
            <textarea class="u-full-width" name="descIncident" value="descIncident"></textarea>
            <button class="button-primary" type="submit">Envoyer</button>
        </form>
    </section>
</body>

</html>
