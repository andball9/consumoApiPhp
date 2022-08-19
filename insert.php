<?php
require 'ConexionDb.php';
$db = new ConexionDb();
$con = $db->conectar();

$Img_url = $_POST['$Img_url'];
$Title = $_POST['$Title'];
$Trailer_url = $_POST['$Trailer_url'];

$query = $con->prepare("INSERT INTO anime (Img_url, Title, Trailer_url) VALUES(:img, :title, :trailer)");
$resultado = $query->execute(array("img" => $Img_url, "title" => $Title,"trailer" => $Trailer_url));
?>