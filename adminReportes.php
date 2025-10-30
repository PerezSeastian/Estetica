<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || !isset($_SESSION['es_admin']) || $_SESSION['es_admin'] !== true) {
    header('Location: iniciosesion.php');
    exit;
}
$nombre_admin = $_SESSION['nombre_usuario'] ?? 'Admin';
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <title>Panel Admin — Reportes</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:200,300,400,500,600,700,800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/animate.css">
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/owl.theme.default.min.css">
    <link rel="stylesheet" href="css/magnific-popup.css">
    <link rel="stylesheet" href="css/bootstrap-datepicker.css">
    <link rel="stylesheet" href="css/jquery.timepicker.css">
    <link rel="stylesheet" href="css/flaticon.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="Estilos/style.css">
    <link rel="stylesheet" href="Estilos/EstilosAdmin.css">
    <link rel="stylesheet" href="Estilos/EstilosReportes.css">
</head>

<body class="admin-profesional">

    <div class="wrap">
        <div class="container">
            <div class="row">
                <div class="col-md-6 d-flex align-items-center">
                    <p class="mb-0 phone pl-md-2">
                        <a href="#" class="mr-2"><span class="fa fa-phone mr-1"></span> +00 1234 567</a>
                        <a href="#"><span class="fa fa-paper-plane mr-1"></span> admin@estetica.com</a>
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
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
        <div class="container">
            <a class="navbar-brand" href="Admin.html.php">
                <span class="flaticon-pawprint-1 mr-2"></span>Panel Admin
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav"
                aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="fa fa-bars"></span> Menu
            </button>
            <div class="collapse navbar-collapse" id="ftco-nav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item"><a href="Admin.php" class="nav-link">
                            <span class="fa fa-users mr-1"></span>Usuarios
                        </a></li>
                    <li class="nav-item"><a href="adminCitas.php" class="nav-link">
                            <span class="fa fa-calendar mr-1"></span>Agenda
                        </a></li>
                    <li class="nav-item"><a href="adminHorarios.php" class="nav-link">
                            <span class="fa fa-clock-o mr-1"></span>Horarios
                        </a></li>
                    <li class="nav-item active"><a href="adminReportes.php" class="nav-link">
                            <span class="fa fa-bar-chart mr-1"></span>Reportes
                        </a></li>
                    <li class="nav-item"><a href="include/logout.php" class="nav-link">
                            <span class="fa fa-sign-out mr-1"></span>Cerrar Sesión
                        </a></li>
                </ul>
            </div>
        </div>
    </nav>

    <section class="profile-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="profile-card">
                        <div class="profile-content">
                            <h4 class="section-title">📊 Panel de Reportes</h4>
                            <p class="section-subtitle">Selecciona el tipo de reporte que deseas generar</p>

                            <div class="reportes-grid">
                                <!-- Botón 1: Contactar -->
                                <div class="reporte-card" onclick="window.location.href='adminContactos.php'">
                                    <div class="reporte-icon">
                                        <span class="fa fa-users"></span>
                                    </div>
                                    <div class="reporte-content">
                                        <h5>Contactar</h5>
                                        <p>Gestionar contactos de clientes</p>
                                        <div class="reporte-badge activo">Disponible</div>
                                    </div>
                                </div>

                                <!-- Botón 2: Próximamente -->
                                <!-- Botón 6: Citas de Hoy -->
                                <div class="reporte-card" onclick="window.location.href='adminReporteCitasHoy.php'">
                                    <div class="reporte-icon">
                                        <span class="fa fa-calendar-check-o"></span>
                                    </div>
                                    <div class="reporte-content">
                                        <h5>Citas de Hoy</h5>
                                        <p>Reporte completo de citas del día</p>
                                        <div class="reporte-badge activo">Disponible</div>
                                    </div>
                                </div>

                                <!-- Botón 3: Próximamente -->
                                <div class="reporte-card proximamente">
                                    <div class="reporte-icon">
                                        <span class="fa fa-calendar"></span>
                                    </div>
                                    <div class="reporte-content">
                                        <h5>proximamente</h5>
                                        <p>---(Breve descripción)---</p>
                                        <div class="reporte-badge">No disponible</div>
                                    </div>
                                </div>

                                <!-- Botón 4: Próximamente -->
                                <div class="reporte-card proximamente">
                                    <div class="reporte-icon">
                                        <span class="fa fa-paw"></span>
                                    </div>
                                    <div class="reporte-content">
                                        <h5>proximamente</h5>
                                        <p>---(Breve descripción)---</p>
                                        <div class="reporte-badge">No disponible</div>
                                    </div>
                                </div>

                                <!-- Botón 5: Próximamente -->
                                <div class="reporte-card proximamente">
                                    <div class="reporte-icon">
                                        <span class="fa fa-line-chart"></span>
                                    </div>
                                    <div class="reporte-content">
                                        <h5>proximamente</h5>
                                        <p>---(Breve descripción)---</p>
                                        <div class="reporte-badge">No disponible</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>

</body>

</html>