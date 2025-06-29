<?php
require 'db.php';

$peliculas = $db->peliculas->find();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Listado de Películas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
<h1>Listado de Películas</h1>
<a href="index.php" class="btn btn-secondary mb-3">Volver</a>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Título</th>
            <th>Año</th>
            <th>Duración</th>
            <th>Género</th>
            <th>Director</th>
            <th>Actores</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($peliculas as $p):
            $director = $db->directores->findOne(['_id' => $p['director_id']]);
            $actorNombres = [];
            foreach ($p['actores'] as $id) {
                $actor = $db->actores->findOne(['_id' => $id]);
                $actorNombres[] = $actor['nombre'];
            }
        ?>
        <tr>
            <td><?= $p['titulo'] ?></td>
            <td><?= $p['año'] ?></td>
            <td><?= $p['duracion'] ?> min</td>
            <td><?= implode(', ', $p['genero']) ?></td>
            <td><?= $director['nombre'] ?></td>
            <td><?= implode(', ', $actorNombres) ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
</body>
</html>
