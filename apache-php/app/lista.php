<?php   
require 'db.php';
$coleccion = $_GET['coleccion'] ?? 'peliculas';
$datos = getCollection($coleccion)->find();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= getTitulo($coleccion) ?> - Cinema DB</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #6366f1;
            --success-color: #10b981;
            --danger-color: #ef4444;
            --warning-color: #f59e0b;
            --info-color: #3b82f6;
            --dark-color: #1f2937;
            --light-bg: #f8fafc;
            --card-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            --hover-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }

        body {
            background-color: var(--light-bg);
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        }

        .page-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, #8b5cf6 100%);
            color: white;
            padding: 2rem 0;
            margin-bottom: 2rem;
            border-radius: 0 0 1rem 1rem;
        }

        .page-title {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .breadcrumb-custom {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 0.5rem;
            padding: 0.75rem 1rem;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .breadcrumb-custom a {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: color 0.2s;
        }

        .breadcrumb-custom a:hover {
            color: white;
        }

        .data-table {
            background: white;
            border-radius: 1rem;
            box-shadow: var(--card-shadow);
            overflow: hidden;
            border: none;
        }

        .table th {
            background: var(--dark-color);
            color: white;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.875rem;
            letter-spacing: 0.05em;
            border: none;
            padding: 1rem;
        }

        .table td {
            padding: 1rem;
            vertical-align: middle;
            border-color: #e5e7eb;
        }

        .table tbody tr:hover {
            background-color: #f8fafc;
            transition: background-color 0.2s;
        }

        .btn-action {
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            font-size: 0.875rem;
            font-weight: 500;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.2s;
            border: none;
            margin: 0.25rem;
        }

        .btn-edit {
            background: var(--info-color);
            color: white;
        }

        .btn-edit:hover {
            background: #2563eb;
            transform: translateY(-1px);
            color: white;
        }

        .btn-delete {
            background: var(--danger-color);
            color: white;
        }

        .btn-delete:hover {
            background: #dc2626;
            transform: translateY(-1px);
            color: white;
        }

        .btn-create {
            background: var(--success-color);
            color: white;
            padding: 1rem 2rem;
            border-radius: 0.75rem;
            font-size: 1.1rem;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.75rem;
            transition: all 0.3s;
            box-shadow: var(--card-shadow);
        }

        .btn-create:hover {
            background: #059669;
            transform: translateY(-2px);
            box-shadow: var(--hover-shadow);
            color: white;
        }

        .alert-custom {
            border: none;
            border-radius: 0.75rem;
            padding: 1rem 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: var(--card-shadow);
        }

        .alert-success-custom {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
        }

        .alert-danger-custom {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: white;
        }

        .empty-state {
            text-align: center;
            padding: 3rem;
            color: #6b7280;
        }

        .empty-state i {
            font-size: 4rem;
            margin-bottom: 1rem;
            opacity: 0.5;
        }

        .status-badge {
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.875rem;
            font-weight: 500;
        }

        .reference-link {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 500;
        }

        .reference-link:hover {
            color: #4338ca;
            text-decoration: underline;
        }

        @media (max-width: 768px) {
            .page-title {
                font-size: 2rem;
            }
            
            .table-responsive {
                border-radius: 1rem;
            }
            
            .btn-action {
                padding: 0.4rem 0.8rem;
                font-size: 0.8rem;
            }
        }
    </style>
</head>
<body>
    <div class="page-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="page-title">
                        <i class="fas fa-<?= $coleccion === 'peliculas' ? 'film' : ($coleccion === 'actores' ? 'user-circle' : 'video') ?> me-3"></i>
                        <?= getTitulo($coleccion) ?>
                    </h1>
                    <div class="breadcrumb-custom">
                        <a href="index.php">
                            <i class="fas fa-home me-2"></i>Inicio
                        </a>
                        <i class="fas fa-chevron-right mx-2"></i>
                        <span><?= getTitulo($coleccion) ?></span>
                    </div>
                </div>
                <div class="col-md-4 text-end">
                    <a href="create_form.php?coleccion=<?= $coleccion ?>" class="btn-create">
                        <i class="fas fa-plus"></i>
                        Crear <?= getSingular($coleccion) ?>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <?php if (isset($_GET['mensaje'])): ?>
            <div class="alert alert-success-custom alert-dismissible fade show">
                <i class="fas fa-check-circle me-2"></i>
                ¡Registro creado exitosamente!
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-danger-custom alert-dismissible fade show">
                <i class="fas fa-exclamation-triangle me-2"></i>
                Error: <?= htmlspecialchars($_GET['error']) ?>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <div class="data-table">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <?php 
                            $hasData = false;
                            foreach ($datos as $doc) { 
                                $hasData = true;
                                foreach ($doc as $key => $val) {
                                    $headerName = ucfirst(str_replace('_', ' ', $key));
                                    echo "<th>$headerName</th>";
                                }
                                echo "<th width='200'>Acciones</th>"; 
                                break; 
                            } 
                            ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!$hasData): ?>
                            <tr>
                                <td colspan="100%" class="empty-state">
                                    <i class="fas fa-inbox"></i>
                                    <h4>No hay datos disponibles</h4>
                                    <p>Comienza creando tu primer <?= getSingular($coleccion) ?></p>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach (getCollection($coleccion)->find() as $doc): ?>
                                <tr>
                                    <?php foreach ($doc as $key => $val): ?>
                                        <td>
                                            <?php 
                                            // Manejar referencias especiales
                                            if ($key === 'director_id') {
                                                echo '<a href="#" class="reference-link">' . resolveReference($val, 'director') . '</a>';
                                            } elseif ($key === 'actor_principal_id' || $key === 'actor_id') {
                                                echo '<a href="#" class="reference-link">' . resolveReference($val, 'actor') . '</a>';
                                            } elseif ($key === 'activo' && !empty($val)) {
                                                $class = $val === 'Sí' ? 'bg-success' : 'bg-secondary';
                                                echo "<span class='status-badge $class text-white'>$val</span>";
                                            } elseif (is_object($val)) {
                                                echo (string)$val;
                                            } elseif (empty($val)) {
                                                echo '<em class="text-muted">Sin datos</em>';
                                            } else {
                                                echo htmlspecialchars($val);
                                            }
                                            ?>
                                        </td>
                                    <?php endforeach; ?>
                                    <td>
                                        <a class="btn-action btn-edit" href="update_form.php?coleccion=<?= $coleccion ?>&id=<?= $doc['_id'] ?>">
                                            <i class="fas fa-edit"></i> Editar
                                        </a>
                                        <a class="btn-action btn-delete" href="delete.php?coleccion=<?= $coleccion ?>&id=<?= $doc['_id'] ?>" onclick="return confirm('¿Estás seguro de eliminar este registro?')">
                                            <i class="fas fa-trash"></i> Eliminar
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Animación de entrada para las filas de la tabla
        document.addEventListener('DOMContentLoaded', function() {
            const rows = document.querySelectorAll('tbody tr');
            rows.forEach((row, index) => {
                row.style.opacity = '0';
                row.style.transform = 'translateY(20px)';
                setTimeout(() => {
                    row.style.transition = 'all 0.3s ease';
                    row.style.opacity = '1';
                    row.style.transform = 'translateY(0)';
                }, index * 50);
            });
        });
    </script>
</body>
</html>
