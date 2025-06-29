<?php 
require 'db.php'; 
use MongoDB\BSON\ObjectId;  

// Función para determinar si un ID es ObjectId o string
function isObjectId($id) {
    return preg_match('/^[0-9a-fA-F]{24}$/', $id);
}

// Función para crear el filtro correcto según el tipo de ID
function createIdFilter($id) {
    if (isObjectId($id)) {
        return new ObjectId($id);
    } else {
        return $id; // String personalizado
    }
}

$coleccion = $_POST['coleccion']; 
$id = $_POST['id']; 
$datos = $_POST; 
unset($datos['coleccion'], $datos['id']); 

getCollection($coleccion)->updateOne(     
    ['_id' => createIdFilter($id)],     
    ['$set' => $datos] 
); 

header("Location: index.php?coleccion=$coleccion"); 
exit(); 
?>