<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || !isset($_SESSION['es_admin']) || $_SESSION['es_admin'] !== true) {
    header('Location: iniciosesion.php');
    exit;
}

require_once 'include/database.php';
$conexion = conectarBD();

$sql_usuarios = "SELECT u.id_usuario, u.nombre_completo, u.correo, u.telefono, COUNT(m.id_mascota) as total_mascotas FROM usuarios u LEFT JOIN mascotas m ON u.id_usuario = m.id_usuario GROUP BY u.id_usuario";
$resultado_usuarios = $conexion->query($sql_usuarios);
$usuarios = $resultado_usuarios->fetch_all(MYSQLI_ASSOC);

$total_usuarios = count($usuarios);

$sql_mascotas = "SELECT COUNT(*) as total FROM mascotas";
$total_mascotas = $conexion->query($sql_mascotas)->fetch_assoc()['total'];
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
                    <li class="nav-item active"><a href="Admin.php" class="nav-link">
                            <span class="fa fa-users mr-1"></span> Usuarios
                        </a></li>
                    <li class="nav-item"><a href="adminCitas.php" class="nav-link">
                            <span class="fa fa-calendar mr-1"></span> Agenda
                        </a></li>
                    <li class="nav-item"><a href="adminHorarios.php" class="nav-link">
                            <span class="fa fa-clock-o mr-1"></span> Horarios
                        </a></li>
                    <li class="nav-item"><a href="include/logout.php" class="nav-link">
                            <span class="fa fa-sign-out mr-1"></span> Cerrar Sesión
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
                                        <div class="stat-number"><?php echo $total_usuarios; ?></div>
                                        <div class="stat-label">Usuarios</div>
                                    </div>
                                </div>
                                <div class="stat-card">
                                    <div class="stat-icon">🐕</div>
                                    <div class="stat-info">
                                        <div class="stat-number"><?php echo $total_mascotas; ?></div>
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

                            <!-- En el grid de usuarios -->
                            <div class="users-grid">
                                <?php foreach ($usuarios as $usuario): ?>
                                    <div class="user-card-pro">
                                        <div class="user-main">
                                            <h5><?php echo $usuario['nombre_completo']; ?></h5>
                                            <div class="user-contact">
                                                <span class="fa fa-envelope"></span> <?php echo $usuario['correo']; ?>
                                            </div>
                                        </div>
                                        <div class="user-meta">
                                            <span class="meta-badge"><span class="fa fa-phone mr-1"></span>
                                                <?php echo $usuario['telefono']; ?></span>
                                            <span class="meta-badge">
                                                <?php
                                                if ($usuario['total_mascotas'] == 0) {
                                                    echo '<span class="fa fa-paw mr-1"></span> Sin mascotas';
                                                } elseif ($usuario['total_mascotas'] == 1) {
                                                    echo '<span class="fa fa-paw mr-1"></span> 1 mascota';
                                                } else {
                                                    echo '<span class="fa fa-paw mr-1"></span> ' . $usuario['total_mascotas'] . ' mascotas';
                                                }
                                                ?>
                                            </span>
                                        </div>
                                        <div class="user-actions-pro">
                                            <button class="btn-pro btn-view-pro"
                                                onclick="cargarUsuario(<?php echo $usuario['id_usuario']; ?>)">
                                                <span class="fa fa-eye"></span> Ver
                                            </button>
                                            <button class="btn-pro btn-delete-pro"
                                                onclick="eliminarUsuario(<?php echo $usuario['id_usuario']; ?>, '<?php echo $usuario['nombre_completo']; ?>')">
                                                <span class="fa fa-trash"></span> Eliminar
                                            </button>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
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
                </div>
            </div>
        </div>
    </div>

    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="js/Admin.js"></script>

</body>

</html>