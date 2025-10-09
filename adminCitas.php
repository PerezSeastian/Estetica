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
    <title>Panel Admin — Citas</title>
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
            <a class="navbar-brand" href="Admin.php"><span class="flaticon-pawprint-1 mr-2"></span> Estética canina - Admin</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav"
                aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="fa fa-bars"></span> Menu
            </button>
            <div class="collapse navbar-collapse" id="ftco-nav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item"><a href="Admin.php" class="nav-link">👥 Usuarios</a></li>
                    <li class="nav-item active"><a href="adminCitas.php" class="nav-link">📅 Agenda</a></li>
                    <li class="nav-item"><a href="#" class="nav-link">⏰ Horarios</a></li>
                    <li class="nav-item"><a href="include/logout.php" class="nav-link">🚪 Cerrar Sesión</a></li>
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

                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h4 class="section-title">📅 Control de Citas</h4>
                                <div class="admin-stats d-flex align-items-center">
                                    <div class="stat-card mr-3">
                                        <div class="stat-icon">📅</div>
                                        <div class="stat-info">
                                            <div class="stat-number">3</div>
                                            <div class="stat-label">Citas hoy</div>
                                        </div>
                                    </div>
                                    <div class="stat-card">
                                        <div class="stat-icon">🐶</div>
                                        <div class="stat-info">
                                            <div class="stat-number">8</div>
                                            <div class="stat-label">Mascotas activas</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="admin-search mb-4 d-flex align-items-center">
                                <div class="search-box mr-3">
                                    <span class="fa fa-calendar"></span>
                                    <input type="date" id="filtroFecha" class="form-control" value="<?= date('Y-m-d') ?>">
                                </div>
                                <button class="btn-filter btn btn-primary mr-2">
                                    <span class="fa fa-search"></span> Buscar
                                </button>

                                <div class="ml-auto d-flex">
                                    <button class="btn btn-outline-secondary mr-2">Ver día</button>
                                    <button class="btn btn-outline-secondary">Ver semana</button>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>🐾 Mascota</th>
                                            <th>👤 Cliente</th>
                                            <th>📞 Teléfono</th>
                                            <th>📍 Sucursal</th>
                                            <th>💈 Servicio</th>
                                            <th>🕒 Horario</th>
                                            <th>📅 Fecha</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Firulais</td>
                                            <td>Juan Pérez</td>
                                            <td>555-123-4567</td>
                                            <td>Sucursal 1</td>
                                            <td>Baño y Corte</td>
                                            <td>09:30 - 10:30</td>
                                            <td>07/10/2025</td>
                                        </tr>
                                        <tr>
                                            <td>Luna</td>
                                            <td>María García</td>
                                            <td>555-987-6543</td>
                                            <td>Sucursal 2</td>
                                            <td>Spa</td>
                                            <td>10:45 - 11:30</td>
                                            <td>07/10/2025</td>
                                        </tr>
                                        <tr>
                                            <td>Max</td>
                                            <td>Carlos López</td>
                                            <td>555-333-2211</td>
                                            <td>Sucursal 1</td>
                                            <td>Consulta</td>
                                            <td>12:45 - 13:30</td>
                                            <td>07/10/2025</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            
                            <div class="d-flex justify-content-between align-items-center mt-4">
                                <div>
                                    <p class="mb-0">Total de citas mostradas: <strong>3</strong></p>
                                    <small class="text-muted">Filtrado por la fecha seleccionada.</small>
                                </div>
                                <div>
                                    <button class="btn btn-success mr-2"><span class="fa fa-check"></span> Marcar todas</button>
                                    <button class="btn btn-danger"><span class="fa fa-times"></span> Cancelar Todas</button>
                                </div>
                            </div>

                        </div> 
                    </div> 
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade" id="userModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Información de Cita</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h6>Detalles</h6>
                    <p><strong>Cliente:</strong> Juan Pérez</p>
                    <p><strong>Teléfono:</strong> 555-123-4567</p>
                    <p><strong>Mascota:</strong> Firulais</p>
                    <p><strong>Servicio:</strong> Baño y Corte</p>
                    <p><strong>Fecha / Hora:</strong> 07/10/2025 - 09:30 - 10:30</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-cancel" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-save">Editar</button>
                </div>
            </div>
        </div>
    </div>

    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>

    <script>
        document.querySelector('.search-box input').addEventListener('input', function () {
            const busqueda = this.value.toLowerCase();
            document.querySelectorAll('tbody tr').forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(busqueda) ? '' : 'none';
            });
        });
        document.querySelector('.btn-filter').addEventListener('click', function() {
            alert('Filtro aplicado (estático) — versión dinámica cargará las citas por fecha.');
        });
    </script>
</body>
</html>
