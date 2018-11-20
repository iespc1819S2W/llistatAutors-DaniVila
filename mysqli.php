<?php

//Conectar con BDD

$mysqli = new mysqli("localhost", "root", "", "biblioteca");
$mysqli->set_charset("utf8mb4");