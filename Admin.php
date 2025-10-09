<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || !isset($_SESSION['es_admin']) || $_SESSION['es_admin'] !== true) {
    header('Location: iniciosesion.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <title>Panel de Administración</title>
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
</head>

<body class="admin-profesional">


    <div class="wrap">
        <div class="container">
            <div class="row">
                <div class="col-md-6 d-flex align-items-center">
                    <p class="mb-0 phone pl-md-2">
                        <a href="#" class="mr-2"><span class="fa fa-phone mr-1"></span> +00 1234 567</a>
                        <a href="#"><span class="fa fa-paper-plane mr-1"></span> youremail@email.com</a>
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
            <a class="navbar-brand" href="Admin.html.php">
                <span class="flaticon-pawprint-1 mr-2"></span> Estética canina - Admin
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav"
                aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="fa fa-bars"></span> Menu
            </button>
            <div class="collapse navbar-collapse" id="ftco-nav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item active"><a href="Admin.html" class="nav-link">👥 Usuarios</a></li>
                    <li class="nav-item"><a href="adminCitas.php" class="nav-link">📅 Agenda</a></li>
                    <li class="nav-item"><a href="adminHorarios.php" class="nav-link">⏰ Horarios</a></li>
                    <li class="nav-item"><a href="include/logout.php" class="nav-link">
                            🚪 Cerrar Sesión
                        </a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Contenido Principal del Admin -->
    <section class="profile-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="profile-card">
                        <div class="profile-content">
                            <h4 class="section-title">👥 Gestión de Usuarios</h4>

                            <div class="admin-stats">
                                <div class="stat-card">
                                    <div class="stat-icon">👥</div>
                                    <div class="stat-info">
                                        <div class="stat-number">24</div>
                                        <div class="stat-label">Usuarios</div>
                                    </div>
                                </div>
                                <div class="stat-card">
                                    <div class="stat-icon">🐕</div>
                                    <div class="stat-info">
                                        <div class="stat-number">42</div>
                                        <div class="stat-label">Mascotas</div>
                                    </div>
                                </div>
                            </div>

                            <!--estadísticas -->
                            <div class="admin-search">
                                <div class="search-box">
                                    <span class="fa fa-search"></span>
                                    <input type="text" placeholder="Buscar usuario por nombre o email...">
                                </div>
                                <button class="btn-filter">
                                    <span class="fa fa-filter"></span> Filtros
                                </button>
                            </div>

                            <div class="users-grid">
                                <!-- Usuario 1 -->
                                <div class="user-card-pro">
                                    <div class="user-main">
                                        <h5>Juan Pérez</h5>
                                        <div class="user-contact">
                                            <span class="fa fa-envelope"></span> juan@email.com
                                        </div>
                                    </div>
                                    <div class="user-meta">
                                        <span class="meta-badge">📞 123-456-7890</span>
                                        <span class="meta-badge">🐕 3 mascotas</span>
                                    </div>
                                    <div class="user-actions-pro">
                                        <button class="btn-pro btn-view-pro" data-toggle="modal"
                                            data-target="#userModal">
                                            <span class="fa fa-eye"></span> Ver
                                        </button>
                                        <button class="btn-pro btn-delete-pro">
                                            <span class="fa fa-trash"></span> Eliminar
                                        </button>
                                    </div>
                                </div>

                                <!-- Usuario 2 -->
                                <div class="user-card-pro">
                                    <div class="user-main">
                                        <h5>María García</h5>
                                        <div class="user-contact">
                                            <span class="fa fa-envelope"></span> maria@email.com
                                        </div>
                                    </div>
                                    <div class="user-meta">
                                        <span class="meta-badge">📞 987-654-3210</span>
                                        <span class="meta-badge">🐱 1 mascota</span>
                                    </div>
                                    <div class="user-actions-pro">
                                        <button class="btn-pro btn-view-pro" data-toggle="modal"
                                            data-target="#userModal">
                                            <span class="fa fa-eye"></span> Ver
                                        </button>
                                        <button class="btn-pro btn-delete-pro">
                                            <span class="fa fa-trash"></span> Eliminar
                                        </button>
                                    </div>
                                </div>

                                <!-- Usuario 3 -->
                                <div class="user-card-pro">
                                    <div class="user-main">
                                        <h5>Carlos López</h5>
                                        <div class="user-contact">
                                            <span class="fa fa-envelope"></span> carlos@email.com
                                        </div>
                                    </div>
                                    <div class="user-meta">
                                        <span class="meta-badge">📞 555-123-4567</span>
                                        <span class="meta-badge">🐕 2 mascotas</span>
                                    </div>
                                    <div class="user-actions-pro">
                                        <button class="btn-pro btn-view-pro" data-toggle="modal"
                                            data-target="#userModal">
                                            <span class="fa fa-eye"></span> Ver
                                        </button>
                                        <button class="btn-pro btn-delete-pro">
                                            <span class="fa fa-trash"></span> Eliminar
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal de usuario  -->
    <div class="modal fade" id="userModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Información de Usuario</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h6>Datos Personales</h6>
                    <p><strong>Nombre:</strong> Juan Pérez</p>
                    <p><strong>Email:</strong> juan@email.com</p>
                    <p><strong>Teléfono:</strong> 123-456-7890</p>
                    <p><strong>Dirección:</strong> Calle 123, Ciudad</p>

                    <hr>

                    <h6>Mascotas</h6>
                    <div class="pet-card">
                        <div class="pet-photo">
                            <div class="no-photo">
                                <span class="fa fa-paw"></span>
                            </div>
                        </div>
                        <div class="pet-info">
                            <h6>Fido</h6>
                            <p><strong>Especie:</strong> Perro</p>
                            <p><strong>Raza:</strong> Labrador</p>
                            <p><strong>Edad:</strong> 3 años</p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-cancel" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-save">Editar Usuario</button>
                </div>
            </div>
        </div>
    </div>


    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>


    <script>
        document.querySelector('.search-box input').addEventListener('input', function () {
            const busqueda = this.value.toLowerCase();

            document.querySelectorAll('.user-card-pro').forEach(tarjeta => {
                const texto = tarjeta.textContent.toLowerCase();
                tarjeta.style.display = texto.includes(busqueda) ? 'block' : 'none';
            });
        });
    </script>
</body>

</html>