<?php
include "mysqli.php";

$ordre = 'nom_aut ASC';
$cercaNom = '';

if (isset($_POST['ordreNom1'])) {
	$ordre = 'nom_aut DESC';
}
if (isset($_POST['ordreId0'])) {
	$ordre = 'id_aut ASC';
}
if (isset($_POST['ordreId1'])) {
	$ordre = 'id_aut DESC';
}
if (isset($_POST['cercaNom'])) {
	$cercaNom = ' WHERE nom_aut = "' . $_POST['cercaNom'] . '"';
}

?>



<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
          integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <title>Llista autors</title>
</head>
<body>
<form action="" method="post">
    <div class="container mt-5 mb-2">
        <label>Cerca: </label><input type="text" name="cercaNom">
        <button class="btn btn-success" type="submit" name="ordreNom0">A-Z</button>
        <button class="btn btn-success" type="submit" name="ordreNom1">Z-A</button>
        <button class="btn btn-primary" type="submit" name="ordreId0">ID 0</button>
        <button class="btn btn-primary" type="submit" name="ordreId1">ID 1</button>
    </div>
    <div class="container">
        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Nom autors</th>
                </tr>
            </thead>
            <tbody>
                <?php $query = "SELECT id_aut, nom_aut FROM autors $cercaNom ORDER BY $ordre LIMIT 20";?>
                <?php echo $query ?>
                <?php if ($cursor = $mysqli->query($query) OR die($sql)): ?>
                    <?php while ($row = $cursor->fetch_assoc()): ?>
                        <tr>
				            <td><?php echo $row['id_aut']; ?></td>
				            <td><?php echo $row['nom_aut']; ?></td>
				        </tr>
			        <?php endwhile;?>
                <?php endif;?>
            </tbody>
        </table>
    </div>
</form>
</body>




</html>
