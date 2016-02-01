<?php

include 'inc/config.php';

$categorieList=array();
$sql = '
	SELECT categorie.cat_id, cat_nom, count(*) as nb
	FROM categorie
	INNER JOIN film ON film.cat_id = categorie.cat_id
	GROUP BY categorie.cat_id, cat_nom
	ORDER BY nb DESC
	LIMIT 0,4
';
$pdoStatement = $pdo->query($sql);
if ($pdoStatement && $pdoStatement->rowCount() > 0) {
	$categorieList = $pdoStatement->fetchAll();
}

include 'html/header.php';
?>

<section>
	<p id="homeItro">GCLF est une superbe et ingénieuse application permettant de gérer la localisation et la recherche de ses copies presque-légales de films</p>
	<br /><br />
	<form action="catalogue.php" method="get" id="homeSearch">
		<input type="text" class="searchInput" placeholder="Titre, acteur, etc." name="q" value="" />
		<input type="submit" class="searchSubmit" value="Rechercher"/>
	</form>
</section>
<section class="listeCategories">
	<?php foreach ($categorieList as $curCategorieInfos) : ?>
	<a href="catalogue.php?cat_id=<?php echo $curCategorieInfos['cat_id']; ?>"><?php echo $curCategorieInfos['cat_nom'].' ('.$curCategorieInfos['nb'].')'; ?></a>&nbsp; &nbsp;
	<?php endforeach; ?>
</section>


<?php
include 'html/footer.php';