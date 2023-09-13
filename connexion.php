<?php require('./inc/init.inc.php'); ?>
<!-- Traitement -->
<?php
if (isset($_GET['action']) && $_GET['action'] == "deconnexion") {
    session_destroy();
}
if (internauteEstConnecte()) {
    header("location: profil.php");
}
if ($_POST) {
    $resultat = executeRequete("SELECT * FROM utilisateur WHERE pseudo='$_POST[pseudo]'");
    if ($resultat->num_rows != 0) {
        $membre = $resultat->fetch_assoc();
        if (password_verify($_POST['mot_de_passe'], $membre['mot_de_passe'])) {
            foreach ($membre as $indice => $element) {
                if ($indice != 'mot_de_passe') {
                    $_SESSION['membre'][$indice] = $element;
                }
            }
            header("location: profil.php");
        } else {
            $contenu .= '<div class="erreur">Erreur de mot de passe</div>';
        }
        // si tout est bon on redirige vers le profil

    } else {
        $contenu .= '<div class="erreur">Erreur de pseudo</div>';
    }
}
?>
<?php require('./inc/haut.inc.php'); ?>
<?php echo $contenu ?>
<form method="post" action="">
    <label for="pseudo">Pseudo</label>
    <input type="text" id="pseudo" name="pseudo">
    <label for="mot_de_passe" id="mot_de_passe">Mot de passe</label>
    <input type="password" name="mot_de_passe">
    <button>Se connecter</button>
</form>
<?php require('./inc/bas.inc.php'); ?>