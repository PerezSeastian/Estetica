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
    <title>Panel de Administración - Horarios</title>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
                                    class="fa fa-facebook"></span></a>
                            <a href="#" class="d-flex align-items-center justify-content-center"><span
                                    class="fa fa-instagram"></span></a>
                            <a href="#" class="d-flex align-items-center justify-content-center"><span
                                    class="fa fa-twitter"></span></a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
    <nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light">
        <div class="container">
            <a class="navbar-brand" href="Admin.php"><span class="flaticon-pawprint-1 mr-2"></span> Estética Canina -
                Admin</a>
            <div class="collapse navbar-collapse" id="ftco-nav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item"><a href="Admin.php" class="nav-link">👥 Usuarios</a></li>
                    <li class="nav-item"><a href="adminCitas.php" class="nav-link">📅 Agenda</a></li>
                    <li class="nav-item active"><a href="adminHorarios.php" class="nav-link">⏰ Horarios</a></li>
                    <li class="nav-item"><a href="include/logout.php" class="nav-link">🚪 Cerrar Sesión</a></li>
                </ul>
            </div>
        </div>
    </nav>


    <section class="profile-section">
        <div class="container">
            <div class="profile-card">
                <div class="profile-content">
                    <h4 class="section-title">⏰ Control de Horarios por Sucursal</h4>
                    <p class="text-muted mb-4">Define los horarios de apertura, cierre y los intervalos de atención de
                        cada sucursal 🐾</p>

                    <div class="users-grid">

                        <!-- Sucursal 1 -->
                        <div class="user-card-pro">
                            <div class="user-main">
                                <h5>Sucursal 1</h5>
                                <div class="user-contact">
                                    <span class="fa fa-map-marker"></span> Centro
                                </div>
                            </div>
                            <div class="user-meta">
                                <label>Hora de apertura:</label>
                                <input type="time" value="09:00" class="form-control mb-2">
                                <label>Hora de cierre:</label>
                                <input type="time" value="18:00" class="form-control mb-2">
                            </div>

                            <h6 class="mt-3">🕒 Intervalos de atención</h6>
                            <div class="intervalos-lista" id="intervalos1">
                                <div class="intervalo-item">
                                    <input type="time" value="09:30" class="form-control d-inline w-25"> -
                                    <input type="time" value="10:30" class="form-control d-inline w-25">
                                    <button class="btn btn-sm btn-danger ml-2 eliminar"><i
                                            class="fa fa-trash"></i></button>
                                </div>
                                <div class="intervalo-item mt-2">
                                    <input type="time" value="10:45" class="form-control d-inline w-25"> -
                                    <input type="time" value="11:30" class="form-control d-inline w-25">
                                    <button class="btn btn-sm btn-danger ml-2 eliminar"><i
                                            class="fa fa-trash"></i></button>
                                </div>
                            </div>
                            <button class="btn btn-sm btn-success mt-2 agregar" data-target="#intervalos1">
                                <i class="fa fa-plus"></i> Agregar intervalo
                            </button>

                            <div class="user-actions-pro mt-3 text-center">
                                <button class="btn-guardar btn-save-pro">
                                    <i class="fa fa-save"></i> Guardar Cambios
                                </button>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>

    <script>
        // Agregar un nuevo intervalo
        document.querySelectorAll('.agregar').forEach(btn => {
            btn.addEventListener('click', function () {
                const target = document.querySelector(this.dataset.target);
                const nuevo = document.createElement('div');
                nuevo.className = 'intervalo-item mt-2';
                nuevo.innerHTML = `
                <input type="time" class="form-control d-inline w-25"> -
                <input type="time" class="form-control d-inline w-25">
                <button class="btn btn-sm btn-danger ml-2 eliminar"><i class="fa fa-trash"></i></button>
            `;
                target.appendChild(nuevo);
            });
        });

        // Eliminar intervalo
        document.addEventListener('click', function (e) {
            if (e.target.closest('.eliminar')) {
                e.target.closest('.intervalo-item').remove();
            }
        });

        // Guardar cambios 
        document.querySelectorAll('.btn-save-pro').forEach(btn => {
            btn.addEventListener('click', () => {
                Swal.fire({
                    icon: 'success',
                    title: 'Cambios guardados',
                    text: 'Los intervalos y horarios se han actualizado correctamente 🐶',
                    confirmButtonColor: '#3085d6'
                });
            });
        });
    </script>
</body>

</html>