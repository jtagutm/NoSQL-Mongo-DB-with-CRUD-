<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $coleccion = $_POST['coleccion'];
    $collection = getCollection($coleccion);
    
    // Preparar datos
    $datos = $_POST;
    unset($datos['coleccion']); // Remover campo coleccion de los datos
    
    // Generar ID corto personalizado
    $customId = getNextSequentialId($coleccion);
    $datos['_id'] = $customId;
    
    try {
        $result = $collection->insertOne($datos);
        header("Location: lista.php?coleccion=$coleccion&mensaje=creado");
    } catch (Exception $e) {
        header("Location: lista.php?coleccion=$coleccion&error=" . urlencode($e->getMessage()));
    }
    exit();
}
?>