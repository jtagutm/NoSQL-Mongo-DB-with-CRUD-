<?php
require 'vendor/autoload.php';

try {
    $client = new MongoDB\Client("mongodb://mongo:27017");
    $db = $client->selectDatabase('peliculasDB');
    
    $colecciones = [
        'peliculas' => $db->peliculas,
        'directores' => $db->directores,
        'actores' => $db->actores
    ];
} catch (Exception $e) {
    die("Error de conexión a MongoDB: " . $e->getMessage());
}

function getCollection($nombre) {
    global $colecciones;
    if (!isset($colecciones[$nombre])) {
        throw new Exception("Colección '$nombre' no encontrada");
    }
    return $colecciones[$nombre];
}

function getAvailableCollections() {
    global $colecciones;
    return array_keys($colecciones);
}

// Función para obtener el siguiente ID secuencial
function getNextSequentialId($coleccion) {
    $prefijos = [
        'peliculas' => 'PEL',
        'directores' => 'DIR', 
        'actores' => 'ACT'
    ];
    
    $collection = getCollection($coleccion);
    $prefijo = $prefijos[$coleccion] ?? 'XXX';
    
    // Buscar el último ID usado
    $lastDoc = $collection->findOne(
        ['_id' => ['$regex' => '^' . $prefijo]],
        ['sort' => ['_id' => -1]]
    );
    
    if ($lastDoc) {
        $lastNumber = (int)str_replace($prefijo, '', $lastDoc['_id']);
        $nextNumber = $lastNumber + 1;
    } else {
        $nextNumber = 1;
    }
    
    return $prefijo . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
}

// Función para resolver referencias y mostrar nombres
function resolveReference($value, $type) {
    if (empty($value) || $value === null) {
        return '<em class="text-muted">Sin asignar</em>';
    }
    
    try {
        if ($type === 'director') {
            $director = getCollection('directores')->findOne(['_id' => $value]);
            return $director ? htmlspecialchars($director['nombre']) : '<em class="text-danger">Director eliminado</em>';
        } elseif ($type === 'actor') {
            $actor = getCollection('actores')->findOne(['_id' => $value]);
            return $actor ? htmlspecialchars($actor['nombre']) : '<em class="text-danger">Actor eliminado</em>';
        }
    } catch (Exception $e) {
        return '<em class="text-danger">Error al cargar</em>';
    }
    
    return htmlspecialchars($value);
}

function getSingular($coleccion) {
    $singulares = [
        'peliculas' => 'película',
        'actores' => 'actor',
        'directores' => 'director',
        'generos' => 'género',
        'estudios' => 'estudio'
    ];
    
    return isset($singulares[$coleccion]) ? $singulares[$coleccion] : $coleccion;
}

// Función para obtener el nombre plural correcto
function getPlural($coleccion) {
    $plurales = [
        'pelicula' => 'películas',
        'actor' => 'actores',
        'director' => 'directores',
        'genero' => 'géneros',
        'estudio' => 'estudios'
    ];
    
    return isset($plurales[$coleccion]) ? $plurales[$coleccion] : $coleccion;
}

// Función para capitalizar correctamente
function getTitulo($coleccion, $singular = false) {
    if ($singular) {
        return ucfirst(getSingular($coleccion));
    } else {
        return ucfirst($coleccion);
    }
}
?>