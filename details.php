<?php
// Test de modification de fichier (brice)
require 'inc/config.php';

$currentId = 0;
$filmInfos = array();
// Je récupère le paramètre d'URL "page" de type integer
if (isset($_GET['id'])) {
	$currentId = intval($_GET['id']);
}
$sql = '
	SELECT fil_titre, fil_annee, fil_affiche, fil_synopsis, fil_acteurs, fil_filename, cat_nom, sup_nom
	FROM film
	INNER JOIN categorie ON categorie.cat_id = film.cat_id
	INNER JOIN support ON support.sup_id = film.sup_id
	WHERE fil_id = :filId';
$pdoStatement = $pdo->prepare($sql);
$pdoStatement->bindValue(':filId', $currentId);

if ($pdoStatement->execute()) {
	$filmInfos = $pdoStatement->fetch();
}

require 'html/header.php';

if (sizeof($filmInfos) > 0) {
?>

<article id="details">
	<div class="detailsLeft">
		<div class="affiche"><img src="<?php echo $filmInfos['fil_affiche']; ?>" border="0" width="200" /></div>
		<div class="annee">Sortie en <?php echo $filmInfos['fil_annee']; ?></div>
		<div class="support">Support : <?php echo $filmInfos['sup_nom']; ?></div>
	</div>
	<div class="detailsRight">
		<div class="titre"><?php echo $filmInfos['fil_titre']; ?></div>
		<div class="categorie"><?php echo $filmInfos['cat_nom']; ?></div>
		<br /><br />
		<div class="synopsis"><?php echo $filmInfos['fil_synopsis']; ?></div>
		<div class="acteurs"><?php echo $filmInfos['fil_acteurs']; ?></div>
		<div class="fichier">=> <?php echo $filmInfos['fil_filename']; ?></div>
	</div>
</article>
<?php
}
else {
	echo 'ID non reconnu<br />';
}
require 'html/footer.php';