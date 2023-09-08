<?php require('./inc/init.inc.php'); ?>

<?php
?>

<?php require('./inc/haut.inc.php'); ?>

<h2>Bonjour</h2>

<form method="post" action="">
    <label for="pseudo">Pseudo</label>
    <input type="text" id="pseudo" name="pseudo" placeholder="Pseudo" required maxlength="20" pattern="[a-zA-Z0-9-_.]{1, 20}" title="caractères acceptés : a-z A-Z 0-9 -_.">

    <label for="mdp">Mot de passe</label>
    <input type="password" id="mdp" name="mdp" placeholder="*******" required>

    <button class="connexion">Se connecter</button>
</form>

<?php require('./inc/bas.inc.php'); ?>