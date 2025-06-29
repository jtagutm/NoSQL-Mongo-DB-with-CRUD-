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

// Función para escapar HTML y prevenir XSS
function h($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}

// Función para determinar el tipo de input según el valor
function getInputType($key, $value) {
    $key = strtolower($key);
    
    if (strpos($key, 'email') !== false) return 'email';
    if (strpos($key, 'password') !== false || strpos($key, 'pass') !== false) return 'password';
    if (strpos($key, 'url') !== false || strpos($key, 'link') !== false) return 'url';
    if (strpos($key, 'phone') !== false || strpos($key, 'tel') !== false) return 'tel';
    if (strpos($key, 'date') !== false) return 'date';
    if (is_numeric($value)) return 'number';
    if (is_bool($value)) return 'checkbox';
    if (strlen($value) > 100) return 'textarea';
    
    return 'text';
}

// Función para formatear el valor según el tipo
function formatValue($value) {
    if (is_bool($value)) return $value ? '1' : '0';
    if (is_array($value) || is_object($value)) return json_encode($value, JSON_PRETTY_PRINT);
    return $value;
}

// Validación y sanitización de entrada
$coleccion = isset($_GET['coleccion']) ? trim($_GET['coleccion']) : '';
$id = isset($_GET['id']) ? trim($_GET['id']) : '';

if (empty($coleccion) || empty($id)) {
    die('Error: Parámetros requeridos faltantes.');
}

try {
    $doc = getCollection($coleccion)->findOne(['_id' => createIdFilter($id)]);
    if (!$doc) {
        throw new Exception('Documento no encontrado.');
    }
} catch (Exception $e) {
    die('Error al obtener el documento: ' . h($e->getMessage()));
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar <?= h(ucfirst($coleccion)) ?></title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #0d6efd;
            --secondary-color: #6c757d;
            --success-color: #198754;
            --danger-color: #dc3545;
        }
        
        body {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            min-height: 100vh;
        }
        
        .main-container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            padding: 2rem;
            margin-top: 2rem;
            margin-bottom: 2rem;
        }
        
        .page-header {
            background: linear-gradient(135deg, var(--primary-color), #0056b3);
            color: white;
            padding: 1.5rem;
            border-radius: 10px;
            margin-bottom: 2rem;
            text-align: center;
        }
        
        .form-floating {
            margin-bottom: 1.5rem;
        }
        
        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
        }
        
        .btn {
            border-radius: 8px;
            padding: 0.75rem 1.5rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }
        
        .action-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
            margin-top: 2rem;
            padding-top: 2rem;
            border-top: 2px solid #e9ecef;
        }
        
        .field-icon {
            color: var(--primary-color);
        }
        
        .required-field {
            border-left: 4px solid var(--danger-color);
        }
        
        @media (max-width: 768px) {
            .action-buttons {
                flex-direction: column;
            }
            
            .btn {
                width: 100%;
            }
        }
        
        .loading {
            display: none;
        }
        
        .form-floating textarea {
            min-height: 120px;
        }
        
        .json-field {
            font-family: 'Courier New', monospace;
            background-color: #f8f9fa;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
                <div class="main-container">
                    <!-- Header -->
                    <div class="page-header">
                        <h1 class="mb-0">
                            <i class="bi bi-pencil-square me-2"></i>
                            Editar Registro
                        </h1>
                        <p class="mb-0 mt-2 opacity-75">
                            Colección: <strong><?= h(ucfirst($coleccion)) ?></strong>
                        </p>
                    </div>

                    <!-- Formulario -->
                    <form action="update.php" method="post" id="editForm" novalidate>
                        <input type="hidden" name="coleccion" value="<?= h($coleccion) ?>">
                        <input type="hidden" name="id" value="<?= h($id) ?>">
                        
                        <?php foreach ($doc as $key => $val): 
                            if ($key === '_id') continue;
                            
                            $inputType = getInputType($key, $val);
                            $formattedValue = formatValue($val);
                            $isRequired = in_array($key, ['name', 'title', 'email']); // Ajusta según tus campos requeridos
                        ?>
                            <div class="form-floating <?= $isRequired ? 'required-field' : '' ?>">
                                <?php if ($inputType === 'textarea'): ?>
                                    <textarea 
                                        class="form-control <?= (is_array($val) || is_object($val)) ? 'json-field' : '' ?>" 
                                        id="<?= h($key) ?>" 
                                        name="<?= h($key) ?>" 
                                        placeholder="<?= h(ucfirst(str_replace('_', ' ', $key))) ?>"
                                        <?= $isRequired ? 'required' : '' ?>
                                    ><?= h($formattedValue) ?></textarea>
                                <?php elseif ($inputType === 'checkbox'): ?>
                                    <div class="form-check form-switch mt-3">
                                        <input 
                                            class="form-check-input" 
                                            type="checkbox" 
                                            id="<?= h($key) ?>" 
                                            name="<?= h($key) ?>" 
                                            value="1"
                                            <?= $val ? 'checked' : '' ?>
                                        >
                                        <label class="form-check-label" for="<?= h($key) ?>">
                                            <i class="bi bi-toggle-on field-icon me-2"></i>
                                            <?= h(ucfirst(str_replace('_', ' ', $key))) ?>
                                        </label>
                                    </div>
                                <?php else: ?>
                                    <input 
                                        type="<?= $inputType ?>" 
                                        class="form-control" 
                                        id="<?= h($key) ?>" 
                                        name="<?= h($key) ?>" 
                                        value="<?= h($formattedValue) ?>"
                                        placeholder="<?= h(ucfirst(str_replace('_', ' ', $key))) ?>"
                                        <?= $isRequired ? 'required' : '' ?>
                                    >
                                <?php endif; ?>
                                
                                <?php if ($inputType !== 'checkbox'): ?>
                                    <label for="<?= h($key) ?>">
                                        <?php
                                        $icon = 'bi-input-cursor-text';
                                        switch($inputType) {
                                            case 'email': $icon = 'bi-envelope'; break;
                                            case 'url': $icon = 'bi-link-45deg'; break;
                                            case 'tel': $icon = 'bi-telephone'; break;
                                            case 'date': $icon = 'bi-calendar'; break;
                                            case 'number': $icon = 'bi-123'; break;
                                            case 'password': $icon = 'bi-lock'; break;
                                            case 'textarea': $icon = 'bi-textarea-resize'; break;
                                        }
                                        ?>
                                        <i class="bi <?= $icon ?> field-icon me-2"></i>
                                        <?= h(ucfirst(str_replace('_', ' ', $key))) ?>
                                        <?= $isRequired ? '<span class="text-danger">*</span>' : '' ?>
                                    </label>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>

                        <!-- Botones de acción -->
                        <div class="action-buttons">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="bi bi-check-circle me-2"></i>
                                <span class="btn-text">Actualizar Registro</span>
                                <span class="loading">
                                    <i class="bi bi-arrow-clockwise spin me-2"></i>
                                    Actualizando...
                                </span>
                            </button>
                            
                            <a href="index.php?coleccion=<?= h($coleccion) ?>" class="btn btn-secondary btn-lg">
                                <i class="bi bi-arrow-left me-2"></i>
                                Volver a la Lista
                            </a>
                            
                            <button type="button" class="btn btn-outline-danger btn-lg" onclick="resetForm()">
                                <i class="bi bi-arrow-counterclockwise me-2"></i>
                                Restablecer
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Animación de carga del botón
        document.getElementById('editForm').addEventListener('submit', function(e) {
            const button = this.querySelector('button[type="submit"]');
            const btnText = button.querySelector('.btn-text');
            const loading = button.querySelector('.loading');
            
            btnText.style.display = 'none';
            loading.style.display = 'inline';
            button.disabled = true;
        });
        
        // Función para restablecer el formulario
        function resetForm() {
            if (confirm('¿Estás seguro de que quieres restablecer todos los campos?')) {
                document.getElementById('editForm').reset();
                location.reload();
            }
        }
        
        // Validación en tiempo real
        document.querySelectorAll('input[required], textarea[required]').forEach(input => {
            input.addEventListener('blur', function() {
                if (!this.value.trim()) {
                    this.classList.add('is-invalid');
                } else {
                    this.classList.remove('is-invalid');
                    this.classList.add('is-valid');
                }
            });
        });
        
        // Animación de carga CSS
        const style = document.createElement('style');
        style.textContent = `
            @keyframes spin {
                0% { transform: rotate(0deg); }
                100% { transform: rotate(360deg); }
            }
            .spin {
                animation: spin 1s linear infinite;
            }
        `;
        document.head.appendChild(style);
        
        // Auto-resize para textareas
        document.querySelectorAll('textarea').forEach(textarea => {
            textarea.addEventListener('input', function() {
                this.style.height = 'auto';
                this.style.height = this.scrollHeight + 'px';
            });
        });
    </script>
</body>
</html>