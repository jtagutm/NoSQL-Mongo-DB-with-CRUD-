<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo NoSQL - Cinema Database</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --secondary-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            --success-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            --card-shadow: 0 10px 30px rgba(0,0,0,0.1);
            --hover-shadow: 0 20px 40px rgba(0,0,0,0.15);
        }

        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .hero-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: var(--card-shadow);
            border: 1px solid rgba(255, 255, 255, 0.2);
            padding: 3rem;
            margin-top: 5rem;
            animation: fadeInUp 0.8s ease-out;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .main-title {
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-weight: 800;
            font-size: 3.5rem;
            margin-bottom: 1rem;
            text-align: center;
        }

        .subtitle {
            color: #6c757d;
            font-size: 1.2rem;
            text-align: center;
            margin-bottom: 3rem;
        }

        .nav-card {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            text-decoration: none;
            color: inherit;
            transition: all 0.3s ease;
            box-shadow: var(--card-shadow);
            border: none;
            margin-bottom: 1.5rem;
            position: relative;
            overflow: hidden;
        }

        .nav-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--primary-gradient);
            transform: scaleX(0);
            transition: transform 0.3s ease;
        }

        .nav-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--hover-shadow);
            text-decoration: none;
            color: inherit;
        }

        .nav-card:hover::before {
            transform: scaleX(1);
        }

        .nav-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
            display: block;
        }

        .nav-title {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .nav-description {
            color: #6c757d;
            font-size: 0.95rem;
        }

        .movies-card {
            background: var(--primary-gradient);
            color: white;
        }

        .actors-card {
            background: var(--success-gradient);
            color: white;
        }

        .directors-card {
            background: var(--secondary-gradient);
            color: white;
        }

        .floating-elements {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            overflow: hidden;
        }

        .floating-element {
            position: absolute;
            opacity: 0.1;
            animation: float 6s ease-in-out infinite;
        }

        .floating-element:nth-child(1) {
            top: 10%;
            left: 10%;
            animation-delay: 0s;
        }

        .floating-element:nth-child(2) {
            top: 20%;
            right: 10%;
            animation-delay: 2s;
        }

        .floating-element:nth-child(3) {
            bottom: 20%;
            left: 20%;
            animation-delay: 4s;
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0px);
            }
            50% {
                transform: translateY(-20px);
            }
        }

        @media (max-width: 768px) {
            .hero-container {
                margin: 2rem 1rem;
                padding: 2rem;
            }

            .main-title {
                font-size: 2.5rem;
            }

            .nav-card {
                padding: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="floating-elements">
        <i class="fas fa-film floating-element" style="font-size: 4rem;"></i>
        <i class="fas fa-video floating-element" style="font-size: 3rem;"></i>
        <i class="fas fa-star floating-element" style="font-size: 2.5rem;"></i>
    </div>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-xl-6">
                <div class="hero-container">
                    <h1 class="main-title">
                        <i class="fas fa-database me-3"></i>
                        MongoDB
                    </h1>
                    <p class="subtitle">
                        Sistema de gestión para catálogo de películas
                    </p>

                    <div class="row g-4">
                        <div class="col-12">
                            <a href="lista.php?coleccion=peliculas" class="nav-card movies-card d-block">
                                <div class="text-center">
                                    <i class="fas fa-film nav-icon"></i>
                                    <h3 class="nav-title">Películas</h3>
                                    <p class="nav-description mb-0">
                                        Explora y gestiona el catálogo completo de películas
                                    </p>
                                </div>
                            </a>
                        </div>

                        <div class="col-12">
                            <a href="lista.php?coleccion=actores" class="nav-card actors-card d-block">
                                <div class="text-center">
                                    <i class="fas fa-user-circle nav-icon"></i>
                                    <h3 class="nav-title">Actores</h3>
                                    <p class="nav-description mb-0">
                                        Administra la información de actores y actrices
                                    </p>
                                </div>
                            </a>
                        </div>

                        <div class="col-12">
                            <a href="lista.php?coleccion=directores" class="nav-card directors-card d-block">
                                <div class="text-center">
                                    <i class="fas fa-video nav-icon"></i>
                                    <h3 class="nav-title">Directores</h3>
                                    <p class="nav-description mb-0">
                                        Gestiona el directorio de directores de cine
                                    </p>
                                </div>
                            </a>
                        </div>
                    </div>

                    <div class="text-center mt-4">
                        <small class="text-muted">
                            <i class="fas fa-leaf me-1"></i>
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Animación de entrada progresiva para las tarjetas
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.nav-card');
            cards.forEach((card, index) => {
                card.style.animationDelay = `${index * 0.2}s`;
                card.classList.add('animate__fadeInUp');
            });
        });

        // Efecto de paralaje sutil para elementos flotantes
        window.addEventListener('scroll', function() {
            const elements = document.querySelectorAll('.floating-element');
            const scrolled = window.pageYOffset;
            const rate = scrolled * -0.5;

            elements.forEach((element, index) => {
                element.style.transform = `translateY(${rate * (index + 1) * 0.3}px)`;
            });
        });
    </script>
</body>
</html>