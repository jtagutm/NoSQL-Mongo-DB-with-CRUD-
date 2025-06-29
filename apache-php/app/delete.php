<?php 
require 'db.php'; 
use MongoDB\BSON\ObjectId;  

$coleccion = $_GET['coleccion']; 
$id = $_GET['id']; 

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

// Eliminar el documento principal
getCollection($coleccion)->deleteOne(['_id' => createIdFilter($id)]);

// Si estamos eliminando un actor, también limpiamos las referencias en películas
if ($coleccion === 'actores') {
    // Limpiar referencias del actor en películas (solo usando string, no ObjectId)
    getCollection('peliculas')->updateMany(
        ['actor_id' => $id], 
        ['$unset' => ['actor_id' => '']]
    );
    
    getCollection('peliculas')->updateMany(
        ['id_actor' => $id], 
        ['$unset' => ['id_actor' => '']]
    );
    
    // Si hay arrays de actores
    getCollection('peliculas')->updateMany(
        ['actores' => $id], 
        ['$pull' => ['actores' => $id]]
    );
}

// Si estamos eliminando un director, también limpiamos las referencias en películas
if ($coleccion === 'directores') {
    // Limpiar referencias del director en películas
    getCollection('peliculas')->updateMany(
        ['director_id' => $id], 
        ['$unset' => ['director_id' => '']]
    );
    
    getCollection('peliculas')->updateMany(
        ['id_director' => $id], 
        ['$unset' => ['id_director' => '']]
    );
    
    // Si hay arrays de directores
    getCollection('peliculas')->updateMany(
        ['directores' => $id], 
        ['$pull' => ['directores' => $id]]
    );
}

header("Location: index.php?coleccion=$coleccion"); 
exit(); 
?>