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

    $req = "INSERT INTO $table (nom, prenom, age) values (?,?,?)";
    //Préparation de la requête
    $res = mysqli_prepare($connect, $req);
    //liaison des paramètres
    $var = mysqli_stmt_bind_param($res, 'ssi', $nom, $prenom, $age);
    $nom = 'McFly';
    $prenom = 'Marty';
    $age = 28;
    $var = mysqli_stmt_execute($res); // exécution de la requête
    if (!$var) {
        printf("Echec de l'exécution de la requête.<br />", mysqli_stmt_error($res));
    } else {
        // Association des variables de résultats
        $id = mysqli_insert_id($connect);
        printf("Personne %s enregistrée avec id %d", json_encode([$nom, $prenom, $age]), $id);
        mysqli_stmt_close($res);
    }
    space(2);
    $disconnect = mysqli_close($connect);

    printf("Déconnexion %s", $disconnect ? "réussie" : "ratée :(");
    space(2);

    ?>
</body>

</html>