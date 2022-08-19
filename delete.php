<?php
    require 'ConexionDb.php';
    $db = new ConexionDb();
    $con = $db->conectar();
    $Id = $_POST['$Id'];
    $query = $con->prepare("DELETE FROM anime WHERE id = :id");
    $resultado=$query->execute(array("id"=>$Id));

?>