<?php
try {
    $con = new PDO('mysql:host=localhost;dbname=biblioteca', 'root', '');
    $con->exec('SET CHARACTER SET UTF8');
} catch (PDOException $e) {
    print "¡Error!: " . $e->getMessage() . "<br/>";
    die();
}
?>