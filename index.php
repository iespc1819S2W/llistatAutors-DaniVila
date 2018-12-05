<?php 

    include_once 'conexion.php';
		
		
		// Session
    session_start();
		$nombre = isset($_SESSION['nombre']) ? $_SESSION['nombre'] : '';
		$orden = isset($_SESSION['orden']) ? $_SESSION['orden'] : " ORDER BY ID_AUT ASC ";



		//Ordenación
		if (isset($_GET['ascID'])) {
			$orden = " ORDER BY ID_AUT ASC ";			
		}

		if (isset($_GET['descID'])) {
			$orden = " ORDER BY ID_AUT DESC ";
		}

		if (isset($_GET['nomASC'])) {
			$orden = " ORDER BY NOM_AUT ASC ";
		}

		if (isset($_GET['nomDESC'])) {
			$orden = " ORDER BY NOM_AUT DESC ";
		}

		$_SESSION['orden'] = $orden;




    //Total registros máximos
    $pagina_maximo = 10;
    $pagina = !empty($_GET['pagina']) ? $_GET['pagina'] : 0;
    $paginas = $pagina * $pagina_maximo;





    //Consulta para tabla
    $nombre = isset($_GET['nombre']) ? "WHERE NOM_AUT LIKE '%". $_GET['nombre'] . "%'" : "";
    $sql = "SELECT ID_AUT, NOM_AUT FROM autors $nombre $orden LIMIT $paginas,$pagina_maximo";
    // echo($sql);
    $pdo = $con->prepare($sql);
    $pdo->execute();
		$row = $pdo->fetchAll(PDO::FETCH_ASSOC);
		// echo("<pre>");
		// print_r($row);
		// echo("<pre>");




    //Total de paginas
    $sql = "SELECT ID_AUT FROM autors $nombre ORDER BY ID_AUT ASC";
    $pdo = $con->prepare($sql);
    $pdo->execute();
    $row_total = $pdo->rowCount();
		$pagina_total = ceil($row_total / $pagina_maximo);
		


		// if (isset($_POST['nuevo'])) {
		// 	$sql = "INSERT INTO AUTORS(NOM_AUT) VALUES ('DANI')";
		// 	$pdo = $con->prepare($sql);
		// 	$pdo->execute();

		// }



		//DELETE

		if(isset($_GET['eliminar'])){

			$sql = "DELETE FROM AUTORS WHERE ID = " . $_GET['eliminar'];
		}
?>



<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<title>Llista</title>
</head>

<body>
	<nav>
		<div class="blue-grey darken-4 nav-wrapper">
			<a href="logout.php" class="brand-logo center">Biblioteca</a>
		</div>
	</nav>
	<br>
	<div class="container">
		<div class="row">
			<form action="" method="get">
				<div class="input-field col s4">
					<input id="name" type="text" name="nombre" class="validate" value="<?= isset($_GET['nombre']) ? $_GET['nombre'] : '' ?>">
					<label for="name">Buscar autor</label>
				</div>
				<div class="input-field col s3">
					<button type="submit" class="blue lighten-2 waves-effect waves-light btn"><i class="material-icons left">search</i>Buscar</button>
				</div>
				<div class="input-field col s4">
				<?php if ($orden == " ORDER BY ID_AUT DESC "): ?>
					<button type="submit" class="blue lighten-2 waves-effect waves-light btn" name="ascID" value="<?= $orden ?>"><i class="material-icons left">arrow_upward</i>ID</button>
				<?php else :?>
					<button type="submit" class="blue lighten-2 waves-effect waves-light btn" name="descID" value="<?= $orden ?>"><i class="material-icons left">arrow_downward</i>ID</button>
				<?php endif ?>
				<?php if ($orden == " ORDER BY NOM_AUT DESC "): ?>
					<button type="submit" class="blue lighten-2 waves-effect waves-light btn" name="nomASC" value="<?= $orden ?>"><i class="material-icons left">arrow_upward</i>Nom</button>
				<?php else: ?>
					<button type="submit" class="blue lighten-2 waves-effect waves-light btn" name="nomDESC" value="<?= $orden ?>"><i class="material-icons left">arrow_downward</i>Nom</button>
				<?php endif ?>
				</div>
		</div>
		<table class="striped">
			<tr>
				<th>ID</th>
				<th>AUTOR</th>
				<th>ACTION</th>
			</tr>
			<?php foreach($row as $value): ?>
			<tr>
				<td>
					<?= $value['ID_AUT'] ?>
				</td>
				<td>
					<?= $value['NOM_AUT'] ?>
				</td>
				<td>
					<button type="submit" class="btn waves-effect waves-light" value="<?php $value['ID_AUT'] ?>"><i class="material-icons">create</i></button>
					<button type="submit" class="btn waves-effect waves-light red" name="eliminar" value="<?php $value['ID_AUT'] ?>"><i class="material-icons">delete</i></button>
				</td>
			</tr>
			<?php endforeach ?>

		</table>
		<ul class="pagination">
			<li><button type="submit" class="btn waves-effect" name="pagina" value="0"><i class="material-icons">first_page</i></button></li>
			<li><button type="submit" class="btn waves-effect" name="pagina" value="<?= $pagina > 0 ? $pagina - 1 : 0 ?>"><i
					 class="material-icons">chevron_left</i></a></li>
			<li><button type="submit" class="btn waves-effect" name="pagina" value="<?= $pagina < ($pagina_total - 1) ? $pagina + 1 : $pagina_total - 1 ?>"><i
					 class="material-icons">chevron_right</i></a></li>
			<li><button type="submit" class="btn waves-effect" name="pagina" value="<?= $pagina_total - 1 ?>"><i class="material-icons">last_page</i></a></li>
		</ul>
		</form>
	</div>
</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>

</html>