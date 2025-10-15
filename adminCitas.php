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
            <a class="navbar-brand" href="Admin.html.php">
                <span class="flaticon-pawprint-1 mr-2"></span> Estética canina - Admin
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav"
                aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="fa fa-bars"></span> Menu
            </button>
            <div class="collapse navbar-collapse" id="ftco-nav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item"><a href="Admin.php" class="nav-link">
                            <span class="fa fa-users mr-1"></span> Usuarios
                        </a></li>
                    <li class="nav-item active"><a href="adminCitas.php" class="nav-link">
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
                                    <input type="date" id="filtroFecha" class="form-control"
                                        value="<?= date('Y-m-d') ?>">
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
                                            <th><i class="flaticon-pawprint-1 mr-2""></i> Mascota</th>
                                            <th><i class="fa fa-user" aria-hidden="true"></i> Cliente</th>
                                            <th><i class="fa fa-phone" aria-hidden="true"></i> Teléfono</th>
                                            <th><i class="fa fa-map-pin" aria-hidden="true"></i> Sucursal</th>
                                            <th><i class="fa fa-list" aria-hidden="true"></i> Servicio</th>
                                            <th><i class="fa fa-clock-o" aria-hidden="true"></i> Horario</th>
                                            <th><i class="fa fa-calendar" aria-hidden="true"></i>Fecha</th>
                                            <th><i class="fa fa-filter" aria-hidden="true"></i>Estado</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tablaCitas">
                                        <tr>
                                            <td colspan="7" class="text-center text-muted">Cargando citas...</td>
                                        </tr>
                                    </tbody>

                                </table>
                            </div>


                            <div class="d-flex justify-content-between align-items-center mt-4">
                                <div class="d-flex justify-content-between align-items-center mt-4">
                                    <div>
                                        <p class="mb-0 total-citas">Total de citas mostradas: <strong>0</strong></p>
                                        <small class="text-muted texto-filtro">Filtrado por la fecha
                                            seleccionada.</small>
                                    </div>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
let cambiosPendientes = {}; 

function cargarCitas(fechaSeleccionada, rango = "dia") {
  fetch(`include/ObtenerCitas.php?fecha=${fechaSeleccionada}&rango=${rango}`)
    .then(res => res.json())
    .then(data => {
      const tabla = document.getElementById("tablaCitas");
      tabla.innerHTML = "";

      if (!Array.isArray(data) || data.length === 0) {
        tabla.innerHTML = `<tr><td colspan="8" class="text-center text-muted">No hay citas para esta fecha 🐶</td></tr>`;
        actualizarContadores(0, 0);
        return;
      }

      
      actualizarContadores(data.length, contarMascotasUnicas(data));

      data.forEach(cita => {
        const estadoActual = cita.estado ?? 'Pendiente';
        tabla.innerHTML += `
          <tr>
            <td>${cita.nombre_mascota}</td>
            <td>${cita.nombre_cliente}</td>
            <td>${cita.telefono}</td>
            <td>${cita.sucursal}</td>
            <td>${cita.servicio}</td>
            <td>${cita.hora}</td>
            <td>${new Date(cita.fecha).toLocaleDateString('es-MX')}</td>
            <td>
              <select class="form-control estado-select" data-id="${cita.id_cita}">
                <option value="Pendiente" ${estadoActual === 'Pendiente' ? 'selected' : ''}>Pendiente</option>
                <option value="En servicio" ${estadoActual === 'En servicio' ? 'selected' : ''}>En servicio</option>
                <option value="Completada" ${estadoActual === 'Completada' ? 'selected' : ''}>Completada</option>
                <option value="Cancelada" ${estadoActual === 'Cancelada' ? 'selected' : ''}>Cancelada</option>
              </select>
            </td>
          </tr>`;
      });

      
      document.querySelectorAll(".estado-select").forEach(select => {
        select.addEventListener("change", e => {
          const id = e.target.dataset.id;
          const nuevoEstado = e.target.value;
          cambiosPendientes[id] = nuevoEstado;
        });
      });
    })
    .catch(err => {
      console.error("Error al cargar citas:", err);
      document.getElementById("tablaCitas").innerHTML =
        `<tr><td colspan="8" class="text-center text-danger">Error al conectar con el servidor 😿</td></tr>`;
    });
}

// Actualiza los contadores
function actualizarContadores(totalCitas, totalMascotas) {
  document.querySelector(".stat-card:nth-child(1) .stat-number").textContent = totalCitas;
  document.querySelector(".stat-card:nth-child(2) .stat-number").textContent = totalMascotas;
  document.querySelector(".mb-0 strong").textContent = totalCitas;
}

// Contar mascotas únicas
function contarMascotasUnicas(data) {
  return new Set(data.map(c => c.nombre_mascota)).size;
}

function guardarCambios() {
  if (Object.keys(cambiosPendientes).length === 0) {
    Swal.fire("Sin cambios", "No hay estados modificados.", "info");
    return;
  }

  fetch("include/ActualizarEstadoCitas.php", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify(cambiosPendientes)
  })
  .then(res => res.json())
  .then(data => {
    if (data.success) {
      Swal.fire({
        icon: 'success',
        title: '¡Cambios guardados!',
        text: 'Los estados se actualizaron correctamente 🐾',
        confirmButtonText: 'OK'
      }).then(() => {
        const fecha = document.getElementById("filtroFecha").value;
        cargarCitas(fecha);
        cambiosPendientes = {};
      });
    } else {
      Swal.fire("Error", data.message, "error");
    }
  })
  .catch(() => Swal.fire("Error", "Error de conexión con el servidor", "error"));
}

//Ver día / semana
function verDia() {
  const fecha = document.getElementById("filtroFecha").value;
  cargarCitas(fecha, "dia");
}
function verSemana() {
  const fecha = document.getElementById("filtroFecha").value;
  cargarCitas(fecha, "semana");
}

// Al cargar la página
document.addEventListener("DOMContentLoaded", () => {
  const fechaInput = document.getElementById("filtroFecha");
  cargarCitas(fechaInput.value);

  document.querySelector(".btn-filter").addEventListener("click", () => cargarCitas(fechaInput.value));
  document.querySelector(".btn-outline-secondary:nth-child(1)").addEventListener("click", verDia);
  document.querySelector(".btn-outline-secondary:nth-child(2)").addEventListener("click", verSemana);

  // Crear botón Guardar cambios
  const contenedorBotones = document.querySelector(".d-flex.justify-content-between.align-items-center.mt-4 div:last-child");
  const botonGuardar = document.createElement("button");
  botonGuardar.className = "btn btn-primary ml-2";
  botonGuardar.innerHTML = '<span class="fa fa-save"></span> Guardar cambios';
  contenedorBotones.appendChild(botonGuardar);
  botonGuardar.addEventListener("click", guardarCambios);
});
</script>


</body>

</html>