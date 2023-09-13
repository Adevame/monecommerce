<?php require('../inc/init.inc.php'); ?>
<?php if (!internauteEstConnecteEtEstAdmin()) {
    header("location: ../connexion.php");
    exit();
}
if (!empty($_POST)) {
    $photo_bdd = "";
    if (!empty($_FILES['photo']['name'])) {
        $nom_photo = $_POST['reference'] . '_' . $_FILES['photo']['name'];
        $photo_bdd = "public/img/$nom_photo";
        $photo_dossier = "../public/img/$nom_photo";
        copy($_FILES['photo']['tmp_name'], $photo_dossier);
    }
    foreach ($_POST as $indice => $valeur) {
        $_POST[$indice] = htmlentities(addslashes($valeur));
    }
    executeRequete("INSERT INTO produit (reference, categorie, titre, description, couleur, taille,public, photo, prix, stock) VALUES('$_POST[reference]', '$_POST[categorie]','$_POST[titre]', '$_POST[description]', '$_POST[couleur]', '$_POST[taille]', '$_POST[public]', '$photo_bdd', '$_POST[prix]', '$_POST[stock]')");
    $contenu .= '<div class="validation">Le produit a bien été enregitré</div>';
}
// Liens Produits
$contenu .= '<a href="?action=affichage">Affichage des produits</a>';
$contenu .= '<a href="?action=ajout">Ajout d\'un produit</a>';
?>
<!-- Affichage des produits -->
<?php
if (isset($_GET['action']) && $_GET['action'] == "affichage") {
    $resultat = executeRequete("SELECT * FROM produit");
    $contenu .= '<h2>Affichage des produits</h2>';
    $contenu .= 'Nombre de produits disponibles : ' . $resultat->num_rows;
    $contenu .= '<table border="1"><tr>';
    while ($colonne = $resultat->fetch_field()) {
        $contenu .= '<th>' . $colonne->name . '</th>';
    }
    $contenu .= '<th>Modification</th>';
    $contenu .= '<th>Suppression</th>';
    $contenu .= '</tr>';
    while ($ligne = $resultat->fetch_assoc()) {
        $contenu .= '<tr>';
        foreach ($ligne as $indice => $informations) {
            if ($indice == "photo") {
                $contenu .= '<td><img src="' . RACINE_SITE . $informations . '" height="70"></td>';
            } else {
                $contenu .= '<td>' . $informations . '</td>';
            }
        }
        $contenu .= '<td><a href="?action=modification&id_produit=' . $ligne['id_produit'] . '"><img src="../inc/assets/icons/edit.png"></a></td>';
        $contenu .= '<td><a href="?action=suppression&id_produit=' . $ligne['id_produit'] . '" OnClick="return(confirm(\'En êtes vous certains\'));"><img src="../inc/assets/icons/delete.png"></a></td>';
        $contenu .= '</tr>';
    }
    $contenu .= '</table>';
}
?>
<?php require('../inc/haut.inc.php'); ?>
<?php echo $contenu; ?>
<?php
if (isset($_GET['action']) && $_GET['action'] == "ajout") {
    echo '
<h1>Formulaire Produits</h1>
<form method="post" action="" enctype="multipart/form-data">
    <label for="titre">Référence</label>
    <input type="text" id="reference" name="reference" placeholder="La référence du produit">
    <label for="categorie">Catégorie</label>
    <input type="text" id="categorie" name="categorie" placeholder="La catégorie du produit">
    <label for="titre">Titre</label>
    <input type="text" id="titre" name="titre" placeholder="Le titre du produit">
    <label for="description">Description</label>
    <textarea id="description" name="description"></textarea>
    <label for="couleur">Couleur</label>
    <input type="text" id="couleur" name="couleur" placeholder="La couleur du produit">
    <label for="taille">Taille
        <select name="taille" id="">
            <option value="S">S</option>
            <option value="M">M</option>
            <option value="L">L</option>
            <option value="XL">XL</option>
        </select>
    </label>
    <label for="public">public</label>
    <div>
        <input type="radio" name="public" value="m" checked>Homme
        <input type="radio" name="public" value="f">Femme
    </div>
    <label for="photo">Photo</label>
    <input type="file" id="photo" name="photo">
    <label for="prix">Prix</label>
    <input type="text" id="prix" name="prix" placeholder="Le prix du produit">
    <label for="stock">Stock</label>
    <input type="text" id="stock" name="stock" placeholder="Le stock du produit">
    <button>Enregistrer le produit</button>
</form>';
}
?>


<?php require('../inc/bas.inc.php'); ?>