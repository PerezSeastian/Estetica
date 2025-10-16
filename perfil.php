<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: iniciosesion.php');
    exit;
}

require_once 'include/database.php';
$conexion = conectarBD();

$id_usuario = $_SESSION['id_usuario'];
$sql_usuario = "SELECT nombre_completo, correo, telefono, direccion FROM usuarios WHERE id_usuario = $id_usuario";
$resultado_usuario = $conexion->query($sql_usuario);
$usuario = $resultado_usuario->fetch_assoc();

$sql_mascotas = "SELECT id_mascota, nombre, especie, raza, edad, foto FROM mascotas WHERE id_usuario = $id_usuario";
$resultado_mascotas = $conexion->query($sql_mascotas);
$mascotas = $resultado_mascotas->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <title>Perfil de Usuario</title>
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

</head>

<body>

    <!-- Tu header y nav originales -->
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
            <a class="navbar-brand" href="index.html"><span class="flaticon-pawprint-1 mr-2"></span>Pet sitting</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav"
                aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="fa fa-bars"></span> Menu
            </button>
            <div class="collapse navbar-collapse" id="ftco-nav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item"><a href="index.php" class="nav-link">Inicio</a></li>
                    <li class="nav-item active"><a href="" class="nav-link">Perfil</a></li>
                    <li class="nav-item"><a href="include/logout.php" class="nav-link">
                            Cerrar Sesión (<?php echo $usuario['nombre_completo']; ?>)
                        </a></li>
                </ul>
            </div>
        </div>
    </nav>


    <!-- SECCIÓN DE PERFIL - NUEVO DISEÑO -->
    <section class="profile-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="profile-card">
                        <div class="row">
                            <!-- Sidebar izquierdo con foto -->
                            <div class="col-lg-4">
                                <div class="profile-sidebar">
                                    <div class="profile-avatar">
                                        <span class="fa fa-user"></span>
                                    </div>
                                    <h3 id="userName"><?php echo $usuario['nombre_completo']; ?></h3>
                                    <p>Dueño de mascotas</p>
                                    <button class="btn btn-edit-profile" data-toggle="modal"
                                        data-target="#editProfileModal">
                                        <span class="fa fa-edit mr-2"></span>Editar Perfil
                                    </button>
                                </div>
                            </div>

                            <!-- Contenido principal a la derecha -->
                            <div class="col-lg-8">
                                <div class="profile-content">
                                    <h4 class="section-title">Información Personal</h4>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="info-group">
                                                <div class="info-label">Email</div>
                                                <div class="info-value" id="userEmail"><?php echo $usuario['correo']; ?>
                                                </div>
                                            </div>
                                            <div class="info-group">
                                                <div class="info-label">Teléfono</div>
                                                <div class="info-value" id="userPhone">
                                                    <?php echo $usuario['telefono']; ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="info-group">
                                                <div class="info-label">Dirección</div>
                                                <div class="info-value" id="userAddress">
                                                    <?php echo $usuario['direccion']; ?>
                                                </div>
                                            </div>
                                            <div class="info-group">
                                                <div class="info-label">Perfil</div>
                                                <div class="info-value" id="userSince">Miembro Activo</div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Sección de Mascotas -->
                                    <div class="pets-section">
                                        <h4 class="section-title">Mis Mascotas</h4>

                                        <?php if (empty($mascotas)): ?>
                                            <div class="no-pets">
                                                <p>No tienes mascotas registradas aún.</p>
                                            </div>
                                        <?php else: ?>
                                            <?php foreach ($mascotas as $index => $mascota): ?>
                                                <div class="pet-card">
                                                    <!-- Aquí va la foto de la mascota -->
                                                    <div class="pet-photo">
                                                        <?php if (!empty($mascota['foto'])): ?>
                                                            <img src="uploads/mascotas/<?php echo $mascota['foto']; ?>"
                                                                alt="<?php echo $mascota['nombre']; ?>" class="pet-image">
                                                        <?php else: ?>
                                                            <div class="no-photo">
                                                                <span class="fa fa-paw"></span>
                                                            </div>
                                                        <?php endif; ?>
                                                    </div>

                                                    <div class="pet-info">
                                                        <h5><?php echo $mascota['nombre']; ?></h5>
                                                        <p><strong>Especie:</strong> <?php echo $mascota['especie']; ?></p>
                                                        <p><strong>Raza:</strong> <?php echo $mascota['raza']; ?></p>
                                                        <p><strong>Edad:</strong> <?php echo $mascota['edad']; ?> años</p>
                                                    </div>
                                                    <div class="pet-actions">
                                                        <button class="btn btn-edit"
                                                            onclick="editPet(<?php echo $mascota['id_mascota']; ?>)">
                                                            <span class="fa fa-edit"></span>
                                                        </button>

                                                        <button class="btn btn-delete"
                                                            onclick="showDeleteConfirm(<?php echo $mascota['id_mascota']; ?>)">
                                                            <span class="fa fa-trash"></span>
                                                        </button>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </div>

                                    <button class="btn btn-add-pet" data-toggle="modal" data-target="#petModal"
                                        onclick="showAddPetModal()">
                                        <span class="fa fa-plus mr-2"></span>Agregar Nueva Mascota
                                    </button>

                                    <!-- Sección de Mis Citas -->
                                    <div class="citas-section mt-5">
                                        <h4 class="section-title">📅 Mis Citas</h4>

                                        <div id="cargandoCitas" class="text-center">
                                            <p>Cargando mis citas...</p>
                                        </div>

                                        <div id="listaCitas">
                                            <!-- Aquí se cargarán las citas con JavaScript -->
                                        </div>

                                        <div id="sinCitas" class="no-citas" style="display: none;">
                                            <p>No tienes citas programadas aún.</p>
                                            <a href="servicios.html" class="btn btn-primary">Agendar mi primera cita</a>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>

    <!-- Modal Editar Perfil -->
    <div class="modal fade" id="editProfileModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Editar Perfil</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editProfileForm" onsubmit="saveProfile(); return false;">
                        <div class="form-group">
                            <label for="editName">Nombre</label>
                            <input type="text" class="form-control" id="editName"
                                value="<?php echo $usuario['nombre_completo']; ?>">
                        </div>
                        <div class="form-group">
                            <label for="editEmail">Email</label>
                            <input type="email" class="form-control" id="editEmail"
                                value="<?php echo $usuario['correo']; ?>">
                        </div>
                        <div class="form-group">
                            <label for="editPhone">Teléfono</label>
                            <input type="tel" class="form-control" id="editPhone"
                                value="<?php echo $usuario['telefono']; ?>">
                        </div>
                        <div class="form-group">
                            <label for="editAddress">Dirección</label>
                            <textarea class="form-control" id="editAddress"
                                rows="3"><?php echo $usuario['direccion']; ?></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-cancel" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-save" onclick="saveProfile(); return false;">Guardar
                        Cambios</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Agregar/Editar Mascota -->
    <div class="modal fade" id="petModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="petModalTitle">Agregar Mascota</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="petForm" enctype="multipart/form-data">
                        <input type="hidden" id="editPetId">

                        <!-- Campo para la foto -->
                        <div class="form-group text-center">
                            <div class="photo-preview mb-3" id="photoPreview">
                                <img id="previewImage" src="#" alt="Vista previa"
                                    style="max-width: 200px; max-height: 150px; border-radius: 8px; display: none;">
                                <div id="noPhotoText" class="text-muted">No hay foto seleccionada</div>
                            </div>
                            <label for="petPhoto" class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-camera"></i> Seleccionar Foto
                            </label>
                            <input type="file" class="form-control-file d-none" id="petPhoto" accept="image/*"
                                name="foto" required>
                            <small class="form-text text-muted">Formatos: JPG, PNG, GIF (Máx. 2MB)</small>
                        </div>

                        <div class="form-group">
                            <label for="petName">Nombre de la Mascota *</label>
                            <input type="text" class="form-control" id="petName" name="nombre" required>
                        </div>
                        <div class="form-group">
                            <label for="petSpecies">Especie *</label>
                            <input type="text" class="form-control" id="petSpecies" name="especie" required
                                placeholder="Ej: Perro, Gato, Ave, etc.">
                        </div>
                        <div class="form-group">
                            <label for="petBreed">Raza</label>
                            <input type="text" class="form-control" id="petBreed" name="raza"
                                placeholder="Ej: Schnauzer, Siames, etc.">
                        </div>
                        <div class="form-group">
                            <label for="petAge">Edad</label>
                            <input type="text" class="form-control" id="petAge" name="edad"
                                placeholder="Ej: 3 años, 5 meses">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-cancel" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-save" onclick="savePet()">Guardar Mascota</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Confirmación Eliminar -->
    <div class="modal fade" id="deleteConfirmModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirmar Eliminación</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>¿Estás seguro de que quieres eliminar esta mascota? Esta acción no se puede deshacer.</p>
                    <input type="hidden" id="deletePetIndex">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-cancel" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-delete-pet" onclick="confirmDeletePet()">Eliminar</button>
                </div>
            </div>
        </div>
    </div>

    <footer class="footer">
        <div class="container">
            <div class="row mt-3">
                <div class="col-md-12">
                    <p class="mb-0">
                        Copyright &copy;
                        <script>document.write(new Date().getFullYear());</script>
                        Todos los derechos reservados | Hazlo por tus <i class="fa fa-paw" aria-hidden="true"></i>
                    </p>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="js/perfil.js"></script>
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery-migrate-3.0.1.min.js"></script>
    <script src="js/popper.min.js"></script>
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
</body>

</html>