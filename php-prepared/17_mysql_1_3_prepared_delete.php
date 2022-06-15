<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

    <?php
    require('mysql_utils.php');
    $connect = mysqli_connect(MYSQL_IP, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DB);
    printf("Connexion %s", $connect ? "réussie" : "ratée :(");
    space(2);
    if (!$connect) {
        return;
    }
    $table = "personne";
    $nom_source = 'Brown';
    $req ="DELETE from $table where nom = ? ";
    //Préparation de la requête
    $res = mysqli_prepare($connect,$req);
    //liaison des paramètres
    $var = mysqli_stmt_bind_param($res, 's', $nom_source);


    $var = mysqli_stmt_execute($res); // exécution de la requête
    if (!$var) {
        printf("Echec de l'exécution de la requête.<br />", mysqli_stmt_error($res));
    } else {

        $nbre = mysqli_affected_rows($connect);
        printf("$nbre lignes mises à jour");
        mysqli_stmt_close($res);
    }
    space(2);
    $disconnect = mysqli_close($connect);

    printf("Déconnexion %s", $disconnect ? "réussie" : "ratée :(");
    space(2);

    ?>
</body>

</html>