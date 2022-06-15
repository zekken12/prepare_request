<?php

require ('../../utils.php');

const MYSQL_IP = "127.0.0.1";
const MYSQL_USER = "root";
const MYSQL_PASSWORD = "";
const MYSQL_DB = "gestion_livre_2";

// créer une FK dans la table livre: ajouter colonne avec property INDEX
// puis dans la vue relationnelle: 
// ALTER TABLE `livre` ADD FOREIGN KEY (`idAuteur`) REFERENCES `auteur`(`idAuteur`) ON DELETE RESTRICT ON UPDATE RESTRICT; 
function connexion()
{
    $connect = mysqli_connect(MYSQL_IP, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DB);
    if ($connect == false) {
        printf("Échec de connexion à la base " . MYSQL_DB . ": " . mysqli_connect_error());
        space();
    }
    return $connect;
}


function check_if_exists($conn, $table, $field, $value): bool
	{
		$found = false;
		$sql = "SELECT " . $field . " FROM " . $table;
        //printf("check_if_exists: " . $sql);
		$result = mysqli_query($conn, $sql);

		while ($row = mysqli_fetch_array($result)) {

			/*	
			print_r($row);
			space(); 
			*/
			if ($row[$field] == $value) {
				$found = true;
				break;
			}
		}

		return $found;
	}
function ajoutAuteur($name)
{
    $req = "INSERT INTO auteur (nom) values (?)";
    //Préparation de la requête
    $connect = connexion();
    $exists = check_if_exists($connect, "auteur", "nom", $name);
    if ($exists)  {
        printf("Auteur $name déjà existant!");
        return;
    }
    printf("Preparation de l'ajout de l'auteur: requete: " . $req);
    space();
    $res = mysqli_prepare($connect, $req);
    //liaison des paramètres 
    $var = mysqli_stmt_bind_param($res, 's', $nom);
    $nom = $name;
    $var = mysqli_stmt_execute($res); // exécution de la requête
    if ($var == false) {
    printf("Échec de l'exécution de la requête: " . mysqli_stmt_error($res));
    } else {
        printf("Auteur $name est bien enregistré");
    }
    space();
    mysqli_stmt_close($res);
    
}

function verifTitre($titre, array $auteur)
{
    //printf("verifTitre: " . $titre . " auteur: " . json_encode($auteur));
    if (preg_match("#^[A-Z]([A-Za-z])+$#", $titre)) {
        $connect = connexion();
        $exists = check_if_exists($connect, "livre", "titre", $titre);
        if ($exists)  {
            printf("Titre $titre déjà existant!");
            return;
        }
        $sql = "INSERT INTO livre (titre, idAuteur) VALUES (?, ?)";
        $res = mysqli_prepare($connect, $sql);
        //liaison des paramètres 
        $var = mysqli_stmt_bind_param($res, 'si', $titres, $idAuteur);
        $titres = $titre;
        foreach ($auteur as $idAuteur) {
            $var = mysqli_stmt_execute($res); // exécution de la requête
        }
        if ($var == false) { 
            printf("Échec de l'exécution de la requête: " . mysqli_stmt_error($res));
        } else {
            printf("Le Livre $titre est bien enregistré");
        }       
        mysqli_stmt_close($res);
    } else {
        printf("Erreur: titre $titre non conforme (Majuscule ?  pas de chiffres?)");
    }
    space();
}

function afficheLivre($nomA)
{
    $connect = connexion();
    $req = "SELECT DISTINCT l.titre FROM livre l JOIN auteur a ON l.idAuteur=a.idAuteur WHERE a.nom = ? ";
    //Préparation de la requête
    $res = mysqli_prepare($connect, $req);
    //liaison des paramètres 
    $var = mysqli_stmt_bind_param($res, 's', $nom);
    $nom = $nomA;
    $var = mysqli_stmt_execute($res);
    if ($var == false) {
        printf("Échec de l'exécution de la requête: " . mysqli_stmt_error($res));
    }
    else {
        // Association des variables de résultats 
        $var = mysqli_stmt_bind_result($res, $titre);
        //lecture des valeurs
        printf("<b>Voici les titres de livres de l'auteur $nom:</b>");
        space();
        while (mysqli_stmt_fetch($res)) {
            printf($titre);
            space();
        }
        space();
        mysqli_stmt_close($res);
    }
}
?>
