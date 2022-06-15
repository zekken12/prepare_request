<html>
<body>
    <?php

    include('fonctions.php');
    $connect = connexion();
    $sql = "select nom from auteur";
    $ress = mysqli_query($connect, $sql);
    echo "<form action=affiche.php method=POST>";
    echo "Nom de l'auteur :";
    echo "<select name=nom required>";
    if (mysqli_num_rows($ress) > 0) {
        // Récupérer des informations 
        while ($row = mysqli_fetch_assoc($ress)) {
            printf("<option>" . $row["nom"] . "</option>\n");
        }
    }
    echo "</select><input type=submit name=affiche value =Afficher Livres></form>";

    if (isset($_POST["affiche"])) {

        afficheLivre($_POST["nom"]);
    }
    printf("<a href='index.php'>Retour</a>\n");
    ?>
</body>

</html>