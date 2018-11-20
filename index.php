<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
          integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <title>Document</title>
</head>
<body>
<form action="" method="post">
    <button type="submit" name="order2">A-Z</button>
    <button type="submit" name="order1">Z-A</button>
</form>
</body>

<?php
include("mysqli.php");
//$vars = get_defined_vars();
//echo "<pre>";
//print_r($vars);
//echo "<pre>";

if (!isset($_POST['order2'])) {
    $query = "SELECT id_aut, nom_aut FROM autors ORDER BY nom_aut DESC LIMIT 20";
    if ($cursor = $mysqli->query($query) OR die($sql)) {
        echo "<table class=\"table\">";
        echo "<thead class=\"thead-dark\">";
        echo "<tr><th scope=\"col\">ID</th>
                  <th scope=\"col\">AUTOR</th></tr>";
        echo "</thead>";
        while ($resultat = mysqli_fetch_assoc($cursor)) {
            echo "<tr>";
            echo "<td>" . $resultat['id_aut'] . "</td>";
            echo "<td>" . $resultat['nom_aut'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    }
} else {
    $query = "SELECT id_aut, nom_aut FROM autors ORDER BY nom_aut LIMIT 20";
    if ($cursor = $mysqli->query($query) OR die($sql)) {
        echo "<table class=\"table\">";
        while ($resultat = mysqli_fetch_assoc($cursor)) {
            echo "<tr>";
            echo "<td>" . $resultat['id_aut'] . "</td>";
            echo "<td>" . $resultat['nom_aut'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    }
}

?>


</html>