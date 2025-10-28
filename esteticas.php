<?php
session_start();
$loggedin = isset($_SESSION['loggedin']) && $_SESSION['loggedin'];
$nombre_usuario = $loggedin ? $_SESSION['nombre_usuario'] : '';
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <title>Estética Canina - Servicios</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css?family=Montserrat:200,300,400,500,600,700,800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <link rel="stylesheet" href="css/animate.css">
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/owl.theme.default.min.css">
    <link rel="stylesheet" href="css/magnific-popup.css">
    <link rel="stylesheet" href="css/bootstrap-datepicker.css">
    <link rel="stylesheet" href="css/jquery.timepicker.css">
    <link rel="stylesheet" href="css/flaticon.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="Estilos/estetica.css">

</head>

<body>

    <!-- Header y Nav (igual que tu index) -->
    <div class="wrap">
        <div class="container">
            <div class="row">
                <div class="col-md-6 d-flex align-items-center">
                    <p class="mb-0 phone pl-md-2">
                        <a href="#" class="mr-2"><span class="fa fa-phone mr-1"></span> poner numero</a>
                        <a href="#"><span class="fa fa-paper-plane mr-1"></span> poner correo</a>
                    </p>
                </div>
                <div class="col-md-6 d-flex justify-content-md-end">
                    <div class="social-media">
                        <p class="mb-0 d-flex">
                            <a href="#" class="d-flex align-items-center justify-content-center"><span
                                    class="fa fa-facebook"><i class="sr-only">Facebook</i></span></a>
                            <a href="#" class="d-flex align-items-center justify-content-center"><span
                                    class="fa fa-twitter"><i class="sr-only">Twitter</i></span></a>
                            <a href="#" class="d-flex align-items-center justify-content-center"><span
                                    class="fa fa-instagram"><i class="sr-only">Instagram</i></span></a>
                            <a href="#" class="d-flex align-items-center justify-content-center"><span
                                    class="fa fa-dribbble"><i class="sr-only">Dribbble</i></span></a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
        <div class="container">
            <a class="navbar-brand" href="index.html"><span class="flaticon-pawprint-1 mr-2"></span>Estética Canina</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav"
                aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="fa fa-bars"></span> Menu
            </button>
            <div class="collapse navbar-collapse" id="ftco-nav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item "><a href="index.php" class="nav-link">Inicio</a></li>
                    <?php if ($loggedin): ?>
                        <!-- Usuario LOGUEADO -->
                        <li class="nav-item"><a href="perfil.php" class="nav-link">Perfil</a></li>
                        <li class="nav-item active"><a href="estetica.php" class="nav-link">Sucursales</a></li>
                        <li class="nav-item">
                            <a href="include/logout.php" class="nav-link">
                                <i class="fa fa-sign-out mr-1"></i>Cerrar Sesión (<?php echo $nombre_usuario; ?>)
                            </a>
                        </li>
                    <?php else: ?>
                        <!-- Usuario NO logueado -->
                        <li class="nav-item"><a href="#" class="nav-link">Acerca de</a></li>
                        <li class="nav-item"><a href="iniciosesion.html" class="nav-link">Iniciar sesión</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="services-hero">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 text-center">
                    <h1 class="mb-4">Estética Canina</h1>
                    <p class="lead">Encuentra nuestra sucursal más cercana</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Opciones de Sucursales -->
    <section class="service-options" id="serviceOptions">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-10 text-center mb-5">
                    <h2>Selecciona el tipo de sucursal</h2>
                    <p class="text-muted">Elige entre nuestras sucursales fijas o servicio móvil</p>
                </div>
            </div>
            <div class="row">
                <!-- Opción Fijas (Sucursales Físicas) -->
                <div class="col-md-6 mb-4">
                    <div class="option-card">
                        <div class="option-icon">
                            <i class="fas fa-store"></i>
                        </div>
                        <h3>Sucursales Fijas</h3>
                        <p>Visita alguna de nuestras sucursales físicas equipadas con todo lo necesario para el cuidado
                            de tu mascota.</p>
                        <button class="btn btn-option" onclick="showCatalog('fijas')">
                            Ver Sucursales Fijas
                        </button>
                    </div>
                </div>

                <!-- Opción Móviles (Servicio a Domicilio) -->
                <div class="col-md-6 mb-4">
                    <div class="option-card">
                        <div class="option-icon">
                            <i class="fas fa-truck"></i>
                        </div>
                        <h3>Servicio Móvil</h3>
                        <p>Nuestro equipo se traslada hasta tu ubicación para brindar el servicio en la comodidad de tu
                            hogar.</p>
                        <button class="btn btn-option" onclick="showCatalog('moviles')">
                            Ver Zonas de Cobertura
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Catálogo Fijas (Sucursales Físicas) -->
    <section class="catalog-section" id="catalogFijas">
        <div class="container">
            <button class="btn back-btn" onclick="showOptions()">
                <i class="fa fa-arrow-left mr-2"></i>Volver a Opciones
            </button>

            <div class="catalog-header">
                <h2>Sucursales Fijas</h2>
                <p class="text-muted">Nuestras ubicaciones físicas</p>
            </div>

            <div class="row">
                <!-- Sucursal 1 -->
                <div class="col-lg-6 mb-4">
                    <div class="sucursal-card">
                        <div class="sucursal-icon">
                            <i class="fas fa-paw"></i>
                        </div>
                        <h4>Sucursal Centro</h4>

                        <div class="sucursal-info">
                            <div class="info-item">
                                <div class="info-icon">
                                    <i class="fas fa-map-marker-alt"></i>
                                </div>
                                <div class="info-content">
                                    <strong>Dirección:</strong>
                                    Av. Principal #123, Col. Centro, Ciudad de México
                                </div>
                            </div>

                            <div class="info-item">
                                <div class="info-icon">
                                    <i class="fas fa-clock"></i>
                                </div>
                                <div class="info-content">
                                    <strong>Horario de Atención:</strong>
                                    Lunes a Viernes: 9:00 AM - 7:00 PM<br>
                                    Sábados: 9:00 AM - 3:00 PM
                                </div>
                            </div>
                        </div>

                        <div class="map-placeholder">
                            <i class="fas fa-map mr-2"></i>
                            Mapa de ubicación (próximamente)
                        </div>

                        <button class="btn btn-select">
                            <i class="fas fa-calendar-check mr-2"></i>Seleccionar esta Sucursal
                        </button>
                    </div>
                </div>

                <!-- Sucursal 2 -->
                <div class="col-lg-6 mb-4">
                    <div class="sucursal-card">
                        <div class="sucursal-icon">
                            <i class="fas fa-paw"></i>
                        </div>
                        <h4>Sucursal Norte</h4>

                        <div class="sucursal-info">
                            <div class="info-item">
                                <div class="info-icon">
                                    <i class="fas fa-map-marker-alt"></i>
                                </div>
                                <div class="info-content">
                                    <strong>Dirección:</strong>
                                    Calle Norte #456, Plaza Comercial, Zona Norte
                                </div>
                            </div>

                            <div class="info-item">
                                <div class="info-icon">
                                    <i class="fas fa-clock"></i>
                                </div>
                                <div class="info-content">
                                    <strong>Horario de Atención:</strong>
                                    Lunes a Sábado: 8:00 AM - 8:00 PM<br>
                                    Domingos: 9:00 AM - 2:00 PM
                                </div>
                            </div>
                        </div>

                        <div class="map-placeholder">
                            <i class="fas fa-map mr-2"></i>
                            Mapa de ubicación (próximamente)
                        </div>

                        <button class="btn btn-select">
                            <i class="fas fa-calendar-check mr-2"></i>Seleccionar esta Sucursal
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Catálogo Móviles (Servicio a Domicilio) -->
    <section class="catalog-section" id="catalogMoviles">
        <div class="container">
            <button class="btn back-btn" onclick="showOptions()">
                <i class="fa fa-arrow-left mr-2"></i>Volver a Opciones
            </button>

            <div class="catalog-header">
                <h2>Servicio Móvil</h2>
                <p class="text-muted">Zonas de cobertura para servicio a domicilio</p>
            </div>

            <div class="row">
                <!-- Zona 1 -->
                <div class="col-lg-6 mb-4">
                    <div class="sucursal-card">
                        <div class="sucursal-icon">
                            <i class="fas fa-truck"></i>
                        </div>
                        <h4>Zona Centro</h4>

                        <div class="sucursal-info">
                            <div class="info-item">
                                <div class="info-icon">
                                    <i class="fas fa-map-marker-alt"></i>
                                </div>
                                <div class="info-content">
                                    <strong>Área de Cobertura:</strong>
                                    Colonia Centro, Reforma, Juárez y Condesa
                                </div>
                            </div>

                            <div class="info-item">
                                <div class="info-icon">
                                    <i class="fas fa-clock"></i>
                                </div>
                                <div class="info-content">
                                    <strong>Horario de Servicio:</strong>
                                    Lunes a Domingo: 8:00 AM - 6:00 PM<br>
                                    Cita previa requerida
                                </div>
                            </div>
                        </div>

                        <button class="btn btn-select">
                            <i class="fas fa-truck mr-2"></i>Solicitar Servicio en esta Zona
                        </button>
                    </div>
                </div>

                <!-- Zona 2 -->
                <div class="col-lg-6 mb-4">
                    <div class="sucursal-card">
                        <div class="sucursal-icon">
                            <i class="fas fa-truck"></i>
                        </div>
                        <h4>Zona Norte</h4>

                        <div class="sucursal-info">
                            <div class="info-item">
                                <div class="info-icon">
                                    <i class="fas fa-map-marker-alt"></i>
                                </div>
                                <div class="info-content">
                                    <strong>Área de Cobertura:</strong>
                                    Colonia Norte, Industrial, Vallejo y Azcapotzalco
                                </div>
                            </div>

                            <div class="info-item">
                                <div class="info-icon">
                                    <i class="fas fa-clock"></i>
                                </div>
                                <div class="info-content">
                                    <strong>Horario de Servicio:</strong>
                                    Martes a Sábado: 9:00 AM - 5:00 PM<br>
                                    Cita previa requerida
                                </div>
                            </div>
                        </div>

                        <button class="btn btn-select">
                            <i class="fas fa-truck mr-2"></i>Solicitar Servicio en esta Zona
                        </button>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-12">
                    <div class="alert alert-info">
                        <h5><i class="fas fa-info-circle mr-2"></i>Información del Servicio Móvil</h5>
                        <p class="mb-0">El servicio a domicilio incluye todos los equipos y materiales necesarios. Se
                            requiere espacio adecuado para trabajar y acceso a agua y electricidad.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="footer">
        <div class="container">
            <div class="row mt-5">
                <div class="col-md-12 text-center">
                    <p class="copyright">
                        Copyright &copy;
                        <script>document.write(new Date().getFullYear());</script> All rights reserved | This template
                        is made with <i class="fa fa-heart" aria-hidden="true"></i> by <a href="https://colorlib.com"
                            target="_blank">Colorlib.com</a>
                    </p>
                </div>
            </div>
        </div>
    </footer>

    <script>
        function showCatalog(type) {
            // Ocultar todas las secciones primero
            document.getElementById('serviceOptions').style.display = 'none';
            document.getElementById('catalogFijas').classList.remove('catalog-active');
            document.getElementById('catalogMoviles').classList.remove('catalog-active');

            // Mostrar la sección seleccionada
            if (type === 'fijas') {
                document.getElementById('catalogFijas').classList.add('catalog-active');
            } else if (type === 'moviles') {
                document.getElementById('catalogMoviles').classList.add('catalog-active');
            }

            // Scroll suave hacia arriba
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        function showOptions() {
            // Ocultar catálogos
            document.getElementById('catalogFijas').classList.remove('catalog-active');
            document.getElementById('catalogMoviles').classList.remove('catalog-active');

            // Mostrar opciones
            document.getElementById('serviceOptions').style.display = 'block';

            // Scroll suave hacia arriba
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }
    </script>

    <!-- Scripts (los mismos de tu index) -->
    <script src="js/jquery.min.js"></script>
    <script src="js/jquery-migrate-3.0.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.easing.1.3.js"></script>
    <script src="js/jquery.waypoints.min.js"></script>
    <script src="js/jquery.stellar.min.js"></script>
    <script src="js/jquery.animateNumber.min.js"></script>
    <script src="js/bootstrap-datepicker.js"></script>
    <script src="js/jquery.timepicker.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/jquery.magnific-popup.min.js"></script>
    <script src="js/scrollax.min.js"></script>
    <script src="js/main.js"></script>

    <script>
        const usuarioLogueado = <?php echo $loggedin ? 'true' : 'false'; ?>;
    </script>

    <!-- Script de validación -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Botones de sucursales fijas
            const botonesSucursal = document.querySelectorAll('#catalogFijas .btn-select');

            botonesSucursal.forEach(boton => {
                boton.addEventListener('click', function (e) {
                    e.preventDefault();

                    // Prevenir doble clic
                    if (boton.disabled) return;
                    boton.disabled = true;

                    if (usuarioLogueado) {
                        window.location.href = 'agenda.php';
                    } else {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Inicio de sesión requerido',
                            html: `
                    <p>Para agendar una cita necesitas iniciar sesión primero.</p>
                    <p><small>Será rápido y fácil 🐾</small></p>
                `,
                            showCancelButton: true,
                            confirmButtonText: 'Iniciar Sesión',
                            cancelButtonText: 'Más tarde',
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#6c757d'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = 'iniciosesion.html';
                            } else {
                                // Re-habilitar el botón si canceló
                                boton.disabled = false;
                            }
                        });
                    }
                });
            });

            // Botones de servicio móvil
            const botonesMovil = document.querySelectorAll('#catalogMoviles .btn-select');
            botonesMovil.forEach(boton => {
                boton.addEventListener('click', function (e) {
                    e.preventDefault();

                    // Prevenir doble clic
                    if (boton.disabled) return;
                    boton.disabled = true;

                    if (usuarioLogueado) {
                        Swal.fire({
                            icon: 'info',
                            title: 'Servicio Móvil',
                            text: 'Próximamente disponible - Estamos trabajando en esta funcionalidad',
                            confirmButtonText: 'Entendido'
                        }).then(() => {
                            boton.disabled = false; // Re-habilitar después del alert
                        });
                    } else {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Inicio de sesión requerido',
                            html: `
                    <p>Para solicitar servicio móvil necesitas iniciar sesión primero.</p>
                    <p><small>Será rápido y fácil 🐾</small></p>
                `,
                            showCancelButton: true,
                            confirmButtonText: 'Iniciar Sesión',
                            cancelButtonText: 'Más tarde',
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#6c757d'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = 'iniciosesion.html';
                            } else {
                                // Re-habilitar el botón si canceló
                                boton.disabled = false;
                            }
                        });
                    }
                });
            });
        });
    </script>
</body>

</html>