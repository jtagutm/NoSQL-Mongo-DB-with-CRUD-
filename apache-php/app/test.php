<?php
require 'db.php';

echo "Películas: " . $db->peliculas->countDocuments() . "<br>";
echo "Actores: " . $db->actores->countDocuments() . "<br>";
echo "Directores: " . $db->directores->countDocuments() . "<br>";
