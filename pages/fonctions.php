<?php

/**
 * @return PDO
 * Permet la connexion à la base de donnée
 */
function connectionDb() {
	$db = new PDO("mysql:host=localhost;dbname=synx;charset=utf8", "root", "");
	return $db;
}

/**
 * Permet de se connecter et d'initialiser une session
 */
function connection() {
	$db = connectionDb();
	$query = $db->prepare("SELECT * FROM utilisateur WHERE login = :login AND pass = :pass");
	$query->bindParam(':login', $_POST['login']);
    $query->bindParam(':pass', $_POST['pass']);
	$query->execute();
    $row = $query->fetch();
    if($query->rowCount()) {
        session_start();
        $_SESSION['id'] = $row['id'];
        $_SESSION['nom'] = $row['nom'];
        $_SESSION['login'] = $row["login"];
        $_SESSION['numPoste'] = $row['numPoste'];
        $_SESSION['service'] = $row['service'];
        $_SESSION['isAdmin'] = $row['isAdmin'];
        if ($row['isAdmin'] == 1) {
            header("location:pages/index_admin.php");
        } elseif ($row['isAdmin'] == 0) {
            header("location:pages/index_user.php");
        }
    } else {
        echo "<script>alert('Nom de compte ou mot de passe incorrecte');</script>";
    }
}

/**
 * @return string
 * Prend la date actuelle et la formate en JJ/MM/AAAA
 */
function traitementDate() {
    $datePhp = getdate();
    $dateTraite = $datePhp['mday']."-".$datePhp['mon']."-".$datePhp['year'];
    return $dateTraite;
}

//TODO Retourner un tableau et non du HTML
/**
 * Récupère les incidents et les formates dans un tableau HTML
 */
function getIncidents() {
	$db=connectionDb();
	$query = $db->prepare("SELECT * FROM `incidents`");
	$query->execute();
	for($i=0; $row = $query->fetch(); $i++) {
        echo "<tr>
                <td>".$row['id']."</td>
                <td>".$row['dateIncid']."</td>
                <td>".$row['nom']."</td>
                <td>".$row['numPoste']."</td>
                <td>".$row['desciption']."</td>";
        switch ($row['statut']) {
            case 'NR':
                echo "<td class='NR'>Non résolus</td>";
                break;
            case 'EC':
                echo "<td class='EC'>En cours</td>";
                break;
            case 'R':
                echo "<td class='R'>Résolut</td>";
                break;
            case 'HS':
                echo "<td>Hors Service</td>";
                break;
        }
        if (empty($row['dateRes'])) {
            echo "<td>N/A</td>";
        } else {
            echo "<td>".$row['dateRes']."</td>";
        }

        if ($_SESSION['isAdmin'] == 1) {
            if ($row['statut'] == "R" || $row['statut'] == "HS") {
                echo "<td>Ticket clôturé</td>
            </tr>";
            } else {
                echo "<td><button onclick='selectTicket(".$row['id'].")' data-js='open'>Modifier Status</button></td>
            </tr>";
            }
        }
    }
}

/**
 * Ajoute un incident à la base de données
 */
function addIncident() {
    $db = connectionDb();;
    $dateIncident = traitementDate();
    $incidLevel = "4";
    $statut = "NR";

    $query = $db->prepare("INSERT INTO `incidents`(`incidLevel`, `dateIncid`, `nom`, `numPoste`, `desciption`, `statut`) VALUES (:incidLevel, :dateIncid, :nom, :numPoste, :desciption, :statut)");
    $query->bindParam(':incidLevel', $incidLevel);
    $query->bindParam(':dateIncid', $dateIncident);
    $query->bindParam(':nom', $_POST['nomPersonne']);
    $query->bindParam(':numPoste', $_POST['numPoste']);
    $query->bindParam(':desciption', $_POST['descIncident']);
    $query->bindParam(':statut', $statut);
    $query->execute();
    if ($_SESSION['isAdmin'] == 1) {
        header("location:index_admin.php");
    } else {
        header("location:index_user.php");
    }
}

/**
 * Modifie le status de l'incident
 */
function modfIncident() {
    $db = connectionDb();;
    $dateRes = traitementDate();

    if ($_POST['status'] == "EC") {
        $query = $db->prepare("UPDATE `incidents` SET `statut`= :statut WHERE `id`= :ticket");
        $query->bindParam(':statut', $_POST['status']);
        $query->bindParam(':ticket', $_POST['ticket']);
        $query->execute();
    } else {
        $query = $db->prepare("UPDATE `incidents` SET `statut`= :statut,`dateRes`= :dateRes WHERE `id`= :ticket");
        $query->bindParam(':statut', $_POST['status']);
        $query->bindParam(':dateRes', $dateRes);
        $query->bindParam(':ticket', $_POST['ticket']);
        $query->execute();
    }
    header("location:index_admin.php");
}

//TODO Retourner un tableau et non du HTML
/**
 * Récupère la liste des utilisateur et les affiche dans un tableau HTML
 */
function getUtilisateur() {
    $db=connectionDb();
    $query = $db->prepare("SELECT * FROM `utilisateur`");
    $query->execute();

    for($i=0; $row = $query->fetch(); $i++) {
        echo "<tr>
                <td>".$row['id']."</td>
                <td>".$row['nom']."</td>
                <td>".$row['numPoste']."</td>
                <td>".$row['service']."</td>";
        if ($row['isAdmin'] == 1) {
            echo "<td>Admin</td>";
        } else {
            echo "<td>User</td>";
        }
        echo "<td >
                <a href='modif_utilisateur.php?id=".$row['id']."'><button > Modifier</button ></a>&nbsp;
                <a href='M_supp_utilisateur.php?id=".$row['id']."'><button class='delete' >&nbsp;</button ></a>
              </td >
        </tr >";
    }
}

/**
 * @param $id
 * @return mixed
 * Récupère les information d'un utilisateur par son ID
 */
function getUtilisateurById($id) {
    $db=connectionDb();
    $query = $db->prepare("SELECT * FROM `utilisateur` WHERE `id`= :id");
    $query->bindParam(':id', $id);
    $query->execute();
    return $query->fetch();
}

/**
 * Ajoute un utilisateur à la base de données
 */
function addUtilisateur() {
    $db=connectionDb();
    $query = $db->prepare("INSERT INTO `utilisateur`(`login`, `pass`, `nom`, `numPoste`, `service`, `isAdmin`) VALUES (:login, :pass, :nom, :numPoste, :service, :isAdmin)");
    $query->bindParam(':login', $_POST['login']);
    $query->bindParam(':pass', $_POST['mdp']);
    $query->bindParam(':nom', $_POST['nom']);
    $query->bindParam(':numPoste', $_POST['nPoste']);
    $query->bindParam(':service', $_POST['service']);
    $query->bindParam(':isAdmin', $_POST['typeUtil']);
    $query->execute();
    header("location:gestion_utilisateur.php");
}

/**
 * Modifie les informations de l'utilisateur
 */
function modfUtilisateur() {
    $db=connectionDb();
    if ($_POST['mdp'] != "NONE") {
        $query = $db->prepare("UPDATE `utilisateur` SET `login`= :login,`pass`= :pass,`nom`= :nom,`numPoste`= :numPoste,`service`= :service,`isAdmin`= :isAdmin WHERE `id`= :id");
        $query->bindParam(':login', $_POST['login']);
        $query->bindParam(':pass', $_POST['mdp']);
        $query->bindParam(':nom', $_POST['nom']);
        $query->bindParam(':numPoste', $_POST['nPoste']);
        $query->bindParam(':service', $_POST['service']);
        $query->bindParam(':isAdmin', $_POST['typeUtil']);
        $query->bindParam(':id', $_POST['id']);
    } else {
        $query = $db->prepare("UPDATE `utilisateur` SET `login`= :login,`nom`= :nom,`numPoste`= :numPoste,`service`= :service,`isAdmin`= :isAdmin WHERE `id`= :id");
        $query->bindParam(':login', $_POST['login']);
        $query->bindParam(':nom', $_POST['nom']);
        $query->bindParam(':numPoste', $_POST['nPoste']);
        $query->bindParam(':service', $_POST['service']);
        $query->bindParam(':isAdmin', $_POST['typeUtil']);
        $query->bindParam(':id', $_POST['id']);
    }
    $query->execute();
    $query->errorInfo();
    header("location:gestion_utilisateur.php");
}

/**
 * @param $id
 * Supprime l'utilisateur par son ID
 */
function delUtilisateur($id) {
    $db=connectionDb();
    $query = $db->prepare("DELETE FROM `utilisateur` WHERE `id` = :id");
    $query->bindParam(':id', $id);
    $query->execute();
    header("location:gestion_utilisateur.php");
}

//TODO Retourner un tableau et non du HTML
/**
 * Récupère la liste du matériel et l'affiche dans un tableau HTML
 */
function getMateriel() {
    $db=connectionDb();
    $query = $db->prepare("SELECT * FROM `materiel`");
    $query->execute();

    for($i=0; $row = $query->fetch(); $i++) {
        echo "<tr>
                <td>".$row['id']."</td>
                <td>".$row['type']."</td>
                <td>".$row['tag']."</td>";
        if ($row['multyUser'] == 1) {
            echo "<td>Oui</td>";
        } else {
            echo "<td>Non</td>";
        }
        echo "<td >
                <a href='modif_materiel.php?tag=".$row['tag']."'><button > Modifier</button ></a>&nbsp;
                <a href='M_supp_materiel.php?tag=".$row['tag']."'><button class='delete' >&nbsp;</button ></a>
              </td >
        </tr >";
    }
}

/**
 * @param $tag
 * @return mixed
 * Récupère les information d'un matériel par son service TAG
 */
function getMaterielByTag($tag) {
    $db=connectionDb();
    $query = $db->prepare("SELECT * FROM `materiel` WHERE `tag`= :tag");
    $query->bindParam(':tag', $tag);
    $query->execute();
    return $query->fetch();
}

/**
 * Ajoute un matériel à la base de données
 */
function addMateriel() {
    $db=connectionDb();
    $multyUser = 0;
    if ($_POST['multyUser'] == "on") {
        $multyUser = 1;
    }
    $query = $db->prepare("INSERT INTO `materiel`(`id`, `type`, `tag`, `multyUser`) VALUES (:id, :type, :tag, :multyUser)");
    $query->bindParam(':id', $_POST['id']);
    $query->bindParam(':type', $_POST['type']);
    $query->bindParam(':tag', $_POST['tag']);
    $query->bindParam(':multyUser', $multyUser);
    $query->execute();
    header("location:gestion_materiel.php");
}

/**
 * Modifie les information d'un matériel. Impossible de modifier le service TAG
 */
function modfMateriel(){
    $db=connectionDb();
    $multyUser = 0;
    if (isset($_POST['multyUser'])) {
        if ($_POST['multyUser'] == "on") {
            $multyUser = 1;
        }
    } else {
        $multyUser = 0;
    }
    $query = $db->prepare("UPDATE `materiel` SET `id`= :id,`type`= :type,`multyUser`= :multyUser WHERE `tag` = :tag");
    $query->bindParam(':id', $_POST['id']);
    $query->bindParam(':type', $_POST['type']);
    $query->bindParam(':multyUser', $multyUser);
    $query->bindParam(':tag', $_POST['tag']);
    $query->execute();
    header("location:gestion_materiel.php");
}

/**
 * @param $tag
 * Supprime le matériel par son service TAG
 */
function delMateriel($tag) {
    $db=connectionDb();
    $query = $db->prepare("DELETE FROM `materiel` WHERE `tag`= :tag");
    $query->bindParam(':tag', $tag);
    $query->execute();
    header("location:gestion_materiel.php");
}
?>