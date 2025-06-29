<?php
require 'db.php';
$coleccion = $_GET['coleccion'] ?? 'peliculas';

$directores = getCollection('directores')->find();
$actores = getCollection('actores')->find();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear <?= ucfirst($coleccion) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #3498db;
            --success-color: #27ae60;
            --danger-color: #e74c3c;
            --warning-color: #f39c12;
            --light-bg: #f8f9fa;
            --card-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .main-container {
            background: white;
            border-radius: 20px;
            box-shadow: var(--card-shadow);
            padding: 2rem;
            margin: 2rem auto;
            max-width: 800px;
        }
        
        .page-header {
            text-align: center;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid #e9ecef;
        }
        
        .page-header h2 {
            color: var(--primary-color);
            font-weight: 700;
            margin-bottom: 0.5rem;
        }
        
        .page-header .subtitle {
            color: #6c757d;
            font-size: 1.1rem;
        }
        
        .form-section {
            background: var(--light-bg);
            border-radius: 15px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            border-left: 4px solid var(--secondary-color);
        }
        
        .form-section h5 {
            color: var(--primary-color);
            margin-bottom: 1rem;
            font-weight: 600;
        }
        
        .form-label {
            font-weight: 500;
            color: var(--primary-color);
            margin-bottom: 0.5rem;
        }
        
        .form-control, .form-select {
            border: 2px solid #e9ecef;
            border-radius: 10px;
            padding: 0.75rem 1rem;
            transition: all 0.3s ease;
            font-size: 1rem;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: var(--secondary-color);
            box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.25);
        }
        
        .btn-group-custom {
            display: flex;
            gap: 1rem;
            justify-content: center;
            margin-top: 2rem;
            padding-top: 1.5rem;
            border-top: 2px solid #e9ecef;
        }
        
        .btn {
            border-radius: 10px;
            padding: 0.75rem 2rem;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
        }
        
        .btn-success {
            background: linear-gradient(45deg, var(--success-color), #2ecc71);
            border: none;
        }
        
        .btn-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(39, 174, 96, 0.3);
        }
        
        .btn-secondary {
            background: linear-gradient(45deg, #6c757d, #495057);
            border: none;
        }
        
        .btn-secondary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(108, 117, 125, 0.3);
        }
        
        .icon-input {
            position: relative;
        }
        
        .icon-input i {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
            z-index: 5;
        }
        
        .icon-input .form-control,
        .icon-input .form-select {
            padding-left: 2.5rem;
        }
        
        .required-field::after {
            content: " *";
            color: var(--danger-color);
            font-weight: bold;
        }
        
        .breadcrumb-custom {
            background: transparent;
            padding: 0;
            margin-bottom: 1rem;
        }
        
        .breadcrumb-custom .breadcrumb-item a {
            color: var(--secondary-color);
            text-decoration: none;
        }
        
        .breadcrumb-custom .breadcrumb-item.active {
            color: var(--primary-color);
        }
        
        @media (max-width: 768px) {
            .main-container {
                margin: 1rem;
                padding: 1.5rem;
            }
            
            .btn-group-custom {
                flex-direction: column;
            }
            
            .btn {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="main-container">
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-custom">
                    <li class="breadcrumb-item">
                        <a href="index.php?coleccion=<?= $coleccion ?>">
                            <i class="fas fa-home"></i> Inicio
                        </a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Crear <?= ucfirst($coleccion) ?>
                    </li>
                </ol>
            </nav>

            <!-- Header -->
            <div class="page-header">
                <h2>
                    <i class="fas fa-plus-circle"></i>
                    Crear Nuevo <?= ucfirst($coleccion) ?>
                </h2>
                <p class="subtitle">Complete los campos para agregar un nuevo registro</p>
            </div>

            <!-- Form -->
            <form action="create.php" method="post" id="createForm">
                <input type="hidden" name="coleccion" value="<?= $coleccion ?>">

                <?php if ($coleccion === 'peliculas'): ?>
                    <div class="form-section">
                        <h5><i class="fas fa-film"></i> Información de la Película</h5>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label required-field">Título</label>
                                <div class="icon-input">
                                    <i class="fas fa-video"></i>
                                    <input class="form-control" name="titulo" required placeholder="Ingrese el título">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label required-field">Año</label>
                                <div class="icon-input">
                                    <i class="fas fa-calendar"></i>
                                    <input class="form-control" name="anio" type="number" min="1900" max="2025" required placeholder="Año de estreno">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label required-field">Director</label>
                                <div class="icon-input">
                                    <i class="fas fa-user-tie"></i>
                                    <select name="id_director" class="form-select" required>
                                        <option value="">Seleccione un director</option>
                                        <?php foreach ($directores as $dir): ?>
                                            <option value="<?= $dir['_id'] ?>"><?= $dir['nombre'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label required-field">Actor Principal</label>
                                <div class="icon-input">
                                    <i class="fas fa-user"></i>
                                    <select name="id_actor" class="form-select" required>
                                        <option value="">Seleccione un actor</option>
                                        <?php foreach ($actores as $act): ?>
                                            <option value="<?= $act['_id'] ?>"><?= $act['nombre'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                <?php else: ?>
                    <div class="form-section">
                        <h5>
                            <i class="fas fa-<?= $coleccion === 'actores' ? 'user' : 'user-tie' ?>"></i>
                            Información Personal
                        </h5>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label required-field">Nombre Completo</label>
                                <div class="icon-input">
                                    <i class="fas fa-user"></i>
                                    <input class="form-control" name="nombre" required placeholder="Nombre y apellidos">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label required-field">Nacionalidad</label>
                                <div class="icon-input">
                                    <i class="fas fa-flag"></i>
                                    <input class="form-control" name="nacionalidad" required placeholder="País de origen">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Año de Nacimiento</label>
                                <div class="icon-input">
                                    <i class="fas fa-birthday-cake"></i>
                                    <input class="form-control" name="edad" type="number" min="1900" max="2025" placeholder="Año de nacimiento">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Género</label>
                                <div class="icon-input">
                                    <i class="fas fa-venus-mars"></i>
                                    <select name="genero" class="form-select">
                                        <option value="">Seleccione</option>
                                        <option value="Masculino">Masculino</option>
                                        <option value="Femenino">Femenino</option>
                                        <option value="Otro">Otro</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php if ($coleccion === 'actores'): ?>
                        <div class="form-section">
                            <h5><i class="fas fa-star"></i> Información Profesional</h5>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Premios y Reconocimientos</label>
                                    <div class="icon-input">
                                        <i class="fas fa-trophy"></i>
                                        <input class="form-control" name="premios" placeholder="Premios obtenidos">
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Estado</label>
                                    <div class="icon-input">
                                        <i class="fas fa-toggle-on"></i>
                                        <select name="activo" class="form-select">
                                            <option value="">Seleccione</option>
                                            <option value="Sí">Activo</option>
                                            <option value="No">Inactivo</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                    <?php elseif ($coleccion === 'directores'): ?>
                        <div class="form-section">
                            <h5><i class="fas fa-film"></i> Información Profesional</h5>
                            
                            <div class="mb-3">
                                <label class="form-label">Películas Dirigidas</label>
                                <div class="icon-input">
                                    <i class="fas fa-list-ol"></i>
                                    <input class="form-control" name="peliculas_dirigidas" type="number" min="0" placeholder="Número de películas dirigidas">
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>

                <!-- Buttons -->
                <div class="btn-group-custom">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save"></i> Guardar
                    </button>
                    <a href="index.php?coleccion=<?= $coleccion ?>" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Form validation
        document.getElementById('createForm').addEventListener('submit', function(e) {
            const requiredFields = this.querySelectorAll('[required]');
            let isValid = true;
            
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    field.classList.add('is-invalid');
                    isValid = false;
                } else {
                    field.classList.remove('is-invalid');
                }
            });
            
            if (!isValid) {
                e.preventDefault();
                alert('Por favor, complete todos los campos obligatorios.');
            }
        });
        
        // Remove invalid class on input
        document.querySelectorAll('.form-control, .form-select').forEach(input => {
            input.addEventListener('input', function() {
                this.classList.remove('is-invalid');
            });
        });
    </script>
</body>
</html>