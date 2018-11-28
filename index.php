<?php
include "mysqli.php";

// Filtres per ordre
$ordre = isset($_GET['ordreHidden']) ? $_GET['ordreHidden'] : 'nom_aut ASC' ;
if (isset($_GET['ordreNom0'])) {
    $ordre = 'nom_aut ASC';
}
if (isset($_GET['ordreNom1'])) {
    $ordre = 'nom_aut DESC';
}
if (isset($_GET['ordreId0'])) {
    $ordre = 'id_aut ASC';
}
if (isset($_GET['ordreId1'])) {
    $ordre = 'id_aut DESC';
}


//Filtres per cerca
$cercaNom = isset($_GET['cercaHidden']) ? $_GET['cercaHidden'] : '';

if (!empty($_GET['cercaNom'])) {
    $cercaNom = " WHERE id_aut = '" . $_GET['cercaNom'] . "' OR " . " nom_aut LIKE '%" . $_GET['cercaNom'] . "%'";
} else {
    $cercaNom = '';
}

// Paginacio
$numero_per_pagina = '5';

if (isset($_GET['paginaHidden'])) {
    $pagina =  $_GET['paginaHidden'];    
} else {
    $pagina = 0;
}


// TOTAL ROWS
$consulta = "SELECT count(id_aut) FROM autors $cercaNom";
if ($cursor =  $mysqli->query($consulta) or die($sql)) {
    $row = $cursor->fetch_row();
    $total_registres = $row[0];
    $total_pagines = ceil($total_registres / $numero_per_pagina);
}

if (isset($_GET['seguent'])) {
    if ($total_pagines > $pagina+1) {
        $pagina++;
    } 
}

if (isset($_GET['atras'])) {
    if ($pagina > 0) {
        $pagina--;
    }
}

if (isset($_GET['ultim'])) {
    $pagina = $total_pagines - 1;
}

if (isset($_GET['primera'])) {
    $empieza = 0;
    $pagina = 0;
}
$empieza = $pagina * $numero_per_pagina;

?>



<!doctype html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO"
        crossorigin="anonymous">
    <title>Llista autors</title>
</head>

<body>
    <form action="" method="get">
        <div class="container mt-5 mb-2">
            <label>Cerca : </label><input type="text" name="cercaNom" value="<?= (isset($_GET['cercaNom'])) ? $_GET['cercaNom'] : ""; ?>">
            <input type="hidden" name="cercaHidden" value="<?= $cercaNom ?>">
            <input type="hidden" name="paginaHidden" value="<?= $pagina ?>">
            <input type="hidden" name="ordreHidden" value="<?= $ordre ?>">
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
                <?php $query = "SELECT id_aut, nom_aut FROM autors $cercaNom ORDER BY $ordre LIMIT  $empieza,$numero_per_pagina"; ?>
                <?php echo $query ?>;
                <?php if ($cursor = $mysqli->query($query) or die($sql)) : ?>
                <?php while ($row = $cursor->fetch_assoc()) : ?>
                <tr>
                    <td>
                        <?php echo $row['id_aut']; ?>
                    </td>
                    <td>
                        <?php echo $row['nom_aut']; ?>
                    </td>
                </tr>
                <?php endwhile; ?>
                <?php endif; ?>
            </tbody>
        </table>
            <button class="btn btn-primary" type="submit" name="primera"> <<- </button>
            <button class="btn btn-primary" type="submit" name="atras"> <- </button>
            <button class="btn btn-primary" type="submit" name="seguent"> -> </button>
            <button class="btn btn-primary" type="submit" name="ultim"> ->> </button>
            
        </form>
    </div>
</body>

</html>