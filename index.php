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





//DELETE
if (isset($_GET['eliminar'])) {
	$sql = "DELETE FROM AUTORS WHERE ID_AUT = " . $_GET['eliminar'];
	$pdo = $con->prepare($sql);
	$pdo->execute();
}
		


//INSERTAR
if (isset($_GET['crearAutorB'])) {
	$sql = "SELECT max(id_aut) FROM AUTORS";
	$pdo = $con->prepare($sql);
	$pdo->execute();
	$idautResult = $pdo->fetch(PDO::FETCH_ASSOC);
	$idaut = $idautResult['max(id_aut)'] + 1;
	$sql = "INSERT INTO AUTORS (ID_AUT, NOM_AUT) VALUES (" . $idaut . ",'" . $_GET['crearAutor'] . "')";
	$pdo = $con->prepare($sql);
	$pdo->execute();
}



//EDITAR
if (isset($_GET['confirmarEdit'])) {
	$nomEditar = $_GET['editarNom'];
	$idEdit = $_GET['confirmarEdit'];
	$sql = "UPDATE AUTORS SET NOM_AUT = '$nomEditar' WHERE ID_AUT = '$idEdit'";
	$pdo = $con->prepare($sql);
	$pdo->execute();
}






//Consulta para tabla
$nombre = isset($_GET['nombre']) ? "WHERE NOM_AUT LIKE '%" . $_GET['nombre'] . "%'" : "";
$sql = "SELECT ID_AUT, NOM_AUT FROM autors $nombre $orden LIMIT $paginas,$pagina_maximo";
$pdo = $con->prepare($sql);
$pdo->execute();
$row = $pdo->fetchAll(PDO::FETCH_ASSOC);





//Total de paginas
$sql = "SELECT ID_AUT FROM autors $nombre";
$pdo = $con->prepare($sql);
$pdo->execute();
$row_total = $pdo->rowCount();
$pagina_total = ceil($row_total / $pagina_maximo);

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
					<i class="material-icons prefix">account_circle</i>
					<input id="name" type="text" name="nombre" class="validate" value="<?= isset($_GET['nombre']) ? $_GET['nombre'] : '' ?>">
					<label for="name">Buscar autor</label>
				</div>
				<div class="input-field col s2">
					<button type="submit" class="blue lighten-2 waves-effect waves-light btn"><i class="material-icons">search</i></button>
				</div>
				<div class="input-field col s4">
					<i class="material-icons prefix">mode_edit</i>
					<input type="text" name="crearAutor" id="crearAutor">
					<label for="crearAutor">Crear autor</label>
				</div>
				<div  class="input-field col s2">
					<button class="btn" name="crearAutorB"><i class="material-icons">add</i></button>
				</div>
				
		</div>
		<table class="striped">
			<tr>
				<th>ID
				<?php if ($orden == " ORDER BY ID_AUT DESC ") : ?>
					<button type="submit" class="blue lighten-2 waves-effect waves-light btn" name="ascID" value="<?= $orden ?>"><i class="material-icons ">arrow_upward</i></button>
				<?php else : ?>
					<button type="submit" class="blue lighten-2 waves-effect waves-light btn" name="descID" value="<?= $orden ?>"><i class="material-icons ">arrow_downward</i></button>
				<?php endif ?></th>
				<th>AUTOR
				<?php if ($orden == " ORDER BY NOM_AUT DESC ") : ?>
					<button type="submit" class="blue lighten-2 waves-effect waves-light btn" name="nomASC" value="<?= $orden ?>"><i class="material-icons ">arrow_upward</i></button>
				<?php else : ?>
					<button type="submit" class="blue lighten-2 waves-effect waves-light btn" name="nomDESC" value="<?= $orden ?>"><i class="material-icons ">arrow_downward</i></button>
				<?php endif ?>
				</th>
				<th>ACTION</th>
			</tr>
			<?php foreach ($row as $value) : ?>
			<tr>
				<td>
					<?= $value['ID_AUT'] ?>
				</td>
				<td>
				<?php if(isset($_GET['editar']) && $_GET['editar'] == $value['ID_AUT']): ?>
						<input type="text" name="editarNom" value="<?= $value['NOM_AUT'] ?>">
				<?php else: ?>
					<?= $value['NOM_AUT'] ?>
				<?php endif ?>
				</td>
				<td>
				<?php if(isset($_GET['editar']) && $value['ID_AUT'] == $_GET['editar'] ): ?>
					<button type="submit" class="btn waves-effect waves-light blue" name="confirmarEdit" value="<?= $value['ID_AUT'] ?>"><i class="material-icons">check</i></button>
					<button type="submit" class="btn waves-effect waves-light red" name="eliminar"><i class="material-icons">clear</i></button>
				<?php else: ?>
					<button type="submit" class="btn waves-effect waves-light" name="editar" value="<?= $value['ID_AUT'] ?>"><i class="material-icons">create</i></button>
					<button type="submit" class="btn waves-effect waves-light red" name="eliminar" value="<?= $value['ID_AUT'] ?>"><i class="material-icons">delete</i></button>
				<?php endif ?>
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

<?php 

// if (!isset($_GET['editar']) :?>