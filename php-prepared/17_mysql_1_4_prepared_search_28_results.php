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
    $fields = ["nom", "prenom", "age"];

    $criteria_field = $fields[2];
    const MIN_AGE = 27;
    $condition = ">";
    $req_end = "$criteria_field $condition ?";
    $req = "SELECT " .  implode(", ", $fields) . " FROM $table WHERE $req_end";
    printf("Préparons la requête: $req");
    space(2);
    $res = mysqli_prepare($connect, $req); //Préparation de la requete
    $var = mysqli_stmt_bind_param($res, 'i', $age); //liaison des paramètres
    $age = MIN_AGE;
    $var = mysqli_stmt_execute($res);
    if ($var == false) {
        printf("Échec de l'exécution de la requête");
        space();
        printf("Erreur : " . mysqli_stmt_errno($res) . "<br />" . mysqli_stmt_error($res));
    } else { // Association des variables de résultats
        $var = mysqli_stmt_bind_result($res, $nom, $prenom, $age);
        // stocker les valeurs
        // /!\ ATTENTION : que se passe-t-il si on ne l'appelle pas?
        /* // */ $var = mysqli_stmt_store_result($res); 
        printf("Nombre de personnes correspondantes: " . mysqli_stmt_num_rows($res));
        space();

        // libérer les valeurs
        mysqli_stmt_free_result($res);
        mysqli_stmt_close($res);
    }
    
    space();
    $disconnect = mysqli_close($connect);

    printf("Déconnexion %s", $disconnect ? "réussie" : "ratée :(");
    space(2);

    ?>
</body>

</html>