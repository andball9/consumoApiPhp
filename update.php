<?php

require 'ConexionDb.php';

$db = new ConexionDb();
$con = $db->conectar();

$Id = $_POST['Id'];
$Img_url = $_POST['Img_url'];
$Title = $_POST['Title'];
$Trailer_url = $_POST['Trailer_url'];
$query = $con->prepare("UPDATE anime SET Img_url=:img, Title=:title, Trailer_url=:trailer WHERE id = :id");
$resultado = $query->execute(array("img" => $Img_url, "title" => $Title, "trailer" => $Trailer_url, "id" => $Id));

?>