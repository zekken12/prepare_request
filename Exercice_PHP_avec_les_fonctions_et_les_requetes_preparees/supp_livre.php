<html>

<body>

    <?php
    include('fonctions.php');
    $connect = connexion();
    $sql = "select idLivre from livre";
    $ress = mysqli_query($connect, $sql);
    printf("<form action=supp_livre.php method=POST>\n");
    printf("Identifiant du livre :");
    printf("<select id=iden name=iden required>\n");
    if (mysqli_num_rows($ress) > 0) {
        // Récupérer des informations 
        while ($row = mysqli_fetch_assoc($ress)) {
            printf("<option>" . $row["idLivre"] . "</option>\n");
        }
    }
    printf("</select><input type=submit name=supprimer value =Supprimer></form>\n");

    if (isset($_POST["supprimer"])) {
        $req = "delete from livre where idLivre = ?";
        //Préparation de la requete
        $res = mysqli_prepare($connect, $req);
        //liaison des paramètres 
        $var = mysqli_stmt_bind_param($res, 's', $iden);
        $iden = $_POST['iden'];
        $var = mysqli_stmt_execute($res); // exécution de la requête
        if ($var == false){
            printf("Échec de l'exécution de la requête: " . mysqli_stmt_error($res)) ;
        } 
        else {
            printf("Le livre avec l'id #".$iden . "est supprimé");
        }
        space();
        mysqli_stmt_close($res);
    }
    printf("<a href='index.php'>Retour</a>\n");
    ?>
</body>

</html>