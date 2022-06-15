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
    $fields = ["id_personne", "nom", "prenom", "age"];
    
    $criteria_field = $fields[3];
    const MIN_AGE = 28;
    $condition = ">";
    $req_end = "$criteria_field $condition ?";
    $req = "SELECT " .  implode(", ", $fields) . " FROM $table WHERE $req_end";
    printf("Préparons la requête: $req");
    space(2);

    //Préparation de la requête
    $res = mysqli_prepare($connect, $req);
    //liaison des paramètres
    
    //$var = mysqli_stmt_bind_param($res, 'i', MIN_AGE);
    $v = MIN_AGE; // attention, le mixed tableau d'arguments finaux de msqli_stmt_bind_param doit etre une VARIABLE 
    $var = mysqli_stmt_bind_param($res, 'i', $v);
    $var = mysqli_stmt_execute($res);
    if (!$var) {
        printf("Echec de l'exécution de la requête.<br />", mysqli_stmt_error($res));
    } else {
        // Association des variables de résultats
        $var = mysqli_stmt_bind_result($res, $id_personne, $nom, $prenom, $age);
        //lecture des valeurs
        printf("ID, Nom et Prénom des personnes ayant un âge > %d ans:", MIN_AGE);
        space();
        while (mysqli_stmt_fetch($res)) {
            printf("id_personne: $id_personne, nom: $nom, prenom: $prenom, âge: $age");
            space();
        }
        mysqli_stmt_close($res);
    }
    space();
    $disconnect = mysqli_close($connect);

    printf("Déconnexion %s", $disconnect ? "réussie" : "ratée :(");
    space(2);

    ?>
</body>

</html>