<?php
include('fonctions.php');
$connect = connexion();
if (isset($_POST["AjouterAuteur"])) {

    ajoutAuteur($_POST["nom"]);
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Exercice PHP</title>
    <meta charset="utf-8">
</head>

<body>
    <form action="ajout_livre.php" method="POST">
        <fieldset>
            <legend>Ajouter un livre</legend>
            <table>
                <tr>
                    <td> <label for="titre">Titre du livre</label></td>
                    <td><input type="text" id="titre" name="titre" required autofocus></td>
                </tr>
                <tr>
                    <td><label for="auteur">Auteur </label></td>
                    <td> <select id="auteur" name="auteur[]" multiple="multiple" required>
                            <?php
                            $req = "SELECT * from auteur";
                            $res = mysqli_query($connect, $req);
                            if (mysqli_num_rows($res) > 0) {
                                // Récupérer des informations 
                                while ($row = mysqli_fetch_assoc($res)) {
                                    echo "<option value=" . $row["idAuteur"] . ">" . $row["nom"] . "</option>";
                                }
                            }

                            ?>
                        </select></td>
                </tr>
            </table>
            <input type="submit" name="AjouterLivre" value="Ajouter">
        </fieldset>
    </form>

</body>