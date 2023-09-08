<?php require('./inc/init.inc.php'); ?>

<?php
if ($_POST) {
    // debug($_POST);
    $verif_caractere = preg_match("#^[a-zA-Z0-9._-]+$#", $_POST['pseudo']);
    if (!$verif_caractere || (strlen($_POST['pseudo']) < 1 || strlen($_POST['pseudo']) > 20)) {
        $contenu .= "<div class='erreur'>Le pseudo doit contenir entre 1 et 20 caractères. <br> 
            Caractères adaptés : lettre de a à z et chiffres de 1 à 9</div>";
    } else {
        $utilisateur = executeRequete("SELECT * FROM utilisateur WHERE pseudo='$_POST[pseudo]'");
        if ($utilisateur->num_rows > 0) {
            $contenu .= "<div class='erreur'>Pseudo indisponible. Veuillez en choisir un autre.</div>";
        } else {
            // $_POST['mdp'] = md5($_POST['mdp']);
            $_POST['mdp'] = password_hash($_POST['mdp'], PASSWORD_BCRYPT);
            foreach ($_POST as $indice => $valeur) {
                $_POST[$indice] = htmlspecialchars(addslashes($valeur));
            }
            executeRequete("INSERT INTO utilisateur (pseudo, mdp, nom, prenom, email, 
            civilite, ville, code_postal, adresse) VALUES ('$_POST[pseudo]', '$_POST[mdp]', 
            '$_POST[nom]', '$_POST[prenom]', '$_POST[email]', '$_POST[civilite]', '$_POST[ville]', 
            '$_POST[code_postal]', '$_POST[adresse]')");
            $contenu .= "<div class='validation'>Vous êtes inscrit à notre site web. 
            <a href=\"connexion.php\"><u>Cliquez ici pour vous connecter</u></a></div>";
            // $_POST['mdp'] = password_verify($_POST['mdp'], PASSWORD_BCRYPT); ---> Connexion
        }
    }
}

?>

<?php require('./inc/haut.inc.php'); ?>
<?php echo $contenu ?>

<form method="post" action="">
    <label for="pseudo">Pseudo</label>
    <input type="text" id="pseudo" name="pseudo" placeholder="Pseudo" required maxlength="20" pattern="[a-zA-Z0-9-_.]{1, 20}" title="caractères acceptés : a-z A-Z 0-9 -_.">

    <label for="mdp">Mot de passe</label>
    <input type="password" id="mdp" name="mdp" placeholder="*******" required>

    <label for="nom">Nom</label>
    <input type="text" id="nom" name="nom" placeholder="votre nom">

    <label for="prenom">Prénom</label>
    <input type="text" id="prenom" name="prenom" placeholder="votre prénom" required>

    <label for="email">Email</label>
    <input type="email" id="email" name="email" placeholder="exemple@gmail.com" required>

    <label for="civilite">Civilité</label>
    <div class="civilite">
        <input name="civilite" value="m" checked="" type="radio">Homme
        <input name="civilite" value="f" type="radio">Femme
    </div>

    <label for="ville">Ville</label>
    <input type="text" id="ville" name="ville" placeholder="votre ville" pattern="[a-zA-Z0-9-_.]{5,15}" title="caractères acceptés : a-z A-Z 0-9 -_." required>

    <label for="code_postal">Code Postal</label>
    <input type="text" id="code_postal" name="code_postal" placeholder="code postal" pattern="[0-9]{5}" title="5 chiffres requis : 0-9" required>

    <label for="adresse">Adresse</label>
    <textarea id="adresse" name="adresse" placeholder="votre adresse" pattern="[a-zA-Z0-9-_.]{5,15}" title="caractères acceptés :  a-z A-Z 0-9 -_." required></textarea>

    <button class="inscription">S'inscrire</button>
</form>
<?php require('./inc/bas.inc.php'); ?>