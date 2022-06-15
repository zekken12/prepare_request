<!DOCTYPE html>
<html>

<head>
	<title>Exercice PHP</title>
	<meta charset="utf-8">
</head>

<body>
	<a href="ajoutLivre.php"> Ajouter un livre </a> </br>
	<a href="supp_livre.php"> Supprimer un livre </a> </br>
	<a href="affiche.php"> Afficher les livres </a> </br>

	<form action="index.php" method="POST">
		<fieldset>
			<legend>Ajouter un auteur</legend>
			<label for="nom">Nom de l'auteur</label>
			<input type="text" id="nom" name="nom" required autofocus><br />
			<input type="submit" name="AjouterAuteur" value="Ajouter">
		</fieldset>
	</form>

</body>

</html>
<?php
include('fonctions.php');
$connect = connexion();
if (isset($_POST["AjouterAuteur"])) {

	ajoutAuteur($_POST["nom"]);
}
?>