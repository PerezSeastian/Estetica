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
              <a href="#" class="d-flex align-items-center justify-content-center"><span class="fa fa-facebook"><i
                    class="sr-only">Facebook</i></span></a>
              <a href="#" class="d-flex align-items-center justify-content-center"><span class="fa fa-twitter"><i
                    class="sr-only">Twitter</i></span></a>
              <a href="#" class="d-flex align-items-center justify-content-center"><span class="fa fa-instagram"><i
                    class="sr-only">Instagram</i></span></a>
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
          <li class="nav-item active"><a href="adminCitas.php" class="nav-link">
              <span class="fa fa-calendar mr-1"></span>Agenda
            </a></li>
          <li class="nav-item"><a href="adminHorarios.php" class="nav-link">
              <span class="fa fa-clock-o mr-1"></span>Horarios
            </a></li>
          <li class="nav-item"><a href="adminContactos.php" class="nav-link">
              <span class="fa fa-bar-chart mr-1"></span>Contactar
            </a></li>
          <li class="nav-item"><a href="adminReportes.php" class="nav-link">
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

              <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="section-title">📅 Control de Citas</h4>
                <div class="admin-stats d-flex align-items-center">
                  <div class="stat-card mr-3" id="btnCitasHoy" style="cursor:pointer;">
                    <div class="stat-icon">📅</div>
                    <div class="stat-info">
                      <div class="stat-number">3</div>
                      <div class="stat-label">Citas hoy</div>
                    </div>
                  </div>
                  <div class="stat-card" id="btnCorteDia" style="cursor:pointer;">
                    <div class="stat-icon">🐶</div>
                    <div class="stat-info">
                      <div class="stat-number">8</div>
                      <div class="stat-label">Corte del dia</div>
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
                      <th><i class="flaticon-pawprint-1 mr-2""></i> Mascota</th>
                                            <th><i class=" fa fa-user" aria-hidden="true"></i> Cliente</th>
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

  <!-- Modal: Reporte de Citas del Día -->
  <div class="modal fade" id="modalCitasHoy" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title">📅 Citas del Día</h5>
          <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <table class="table table-bordered table-striped">
            <thead class="thead-dark">
              <tr>
                <th>Mascota</th>
                <th>Cliente</th>
                <th>Servicio</th>
                <th>Hora</th>
                <th>Estado</th>
              </tr>
            </thead>
            <tbody id="tablaCitasHoy">
              <tr>
                <td colspan="5" class="text-center">Cargando...</td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="modal-footer">
          <button class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
          <button class="btn btn-primary" onclick="imprimirCitasHoy()">
            <i class="fa fa-print"></i> Imprimir
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal: Corte del Día -->
  <div class="modal fade" id="modalCorteDia" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header bg-success text-white">
          <h5 class="modal-title">🐕 Corte del Día</h5>
          <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <table class="table table-bordered table-hover">
            <thead class="thead-dark">
              <tr>
                <th>Mascota</th>
                <th>Cliente</th>
                <th>Servicio</th>
                <th>Estado</th>
              </tr>
            </thead>
            <tbody id="tablaCorteDia">
              <tr>
                <td colspan="4" class="text-center">Cargando...</td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="modal-footer">
          <button class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
          <button class="btn btn-success" onclick="imprimirCorteDia()">
            <i class="fa fa-print"></i> Imprimir
          </button>
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
            const usaTaxi = cita.taxi_perruno === 'Sí';

            let opcionesEstado = '';

            if (usaTaxi) {
              opcionesEstado = `
            <option value="Proceso de recolección" ${estadoActual === 'Proceso de recolección' ? 'selected' : ''}>Proceso de recolección</option>
            <option value="En viaje" ${estadoActual === 'En viaje' ? 'selected' : ''}>En viaje</option>
            <option value="Ingreso a estética" ${estadoActual === 'Ingreso a estética' ? 'selected' : ''}>Ingreso a estética</option>
            <option value="En servicio o proceso" ${estadoActual === 'En servicio o proceso' ? 'selected' : ''}>En servicio</option>
            <option value="Terminado servicio" ${estadoActual === 'Terminado servicio' ? 'selected' : ''}>Terminado servicio</option>
            <option value="En traslado" ${estadoActual === 'En traslado' ? 'selected' : ''}>En traslado</option>
            <option value="Entregado al cliente" ${estadoActual === 'Entregado al cliente' ? 'selected' : ''}>Entregado al cliente</option>
            <option value="Cancelar Cita" ${estadoActual === 'Cancelar Cita' ? 'selected' : ''}>Cancelar Cita</option>
          `;
            } else {
              opcionesEstado = `
            <option value="Pendiente" ${estadoActual === 'Pendiente' ? 'selected' : ''}>Pendiente</option>
            <option value="Ingreso a estética" ${estadoActual === 'Ingreso a estética' ? 'selected' : ''}>Ingreso a estética</option>
            <option value="En servicio" ${estadoActual === 'En servicio' ? 'selected' : ''}>En servicio</option>
            <option value="Terminado" ${estadoActual === 'Terminado' ? 'selected' : ''}>Terminado</option>
            <option value="Cancelar Cita" ${estadoActual === 'Cancelar Cita' ? 'selected' : ''}>Cancelar Cita</option>
          `;
            }

            tabla.innerHTML += `
          <tr>
            <td>${cita.nombre_mascota}</td>
            <td>${cita.nombre_cliente}</td>
            <td>${cita.telefono}</td>
            <td>${cita.sucursal}</td>
            <td>${cita.servicio}</td>
            <td>${cita.hora}</td>
            <td>${formatearFecha(cita.fecha)}</td>
            <td>
              <select class="form-control estado-select" data-id="${cita.id_cita}">
                ${opcionesEstado}
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
    function formatearFecha(fechaString) {
      // Dividir la fecha en partes (asumiendo formato YYYY-MM-DD)
      const partes = fechaString.split('-');
      if (partes.length === 3) {
        return `${partes[2]}/${partes[1]}/${partes[0]}`; // DD/MM/YYYY
      }
      return fechaString; // Si no se puede formatear, devolver original
    }
  </script>
  <script>
    document.addEventListener("DOMContentLoaded", () => {


      document.getElementById("btnCitasHoy").addEventListener("click", () => {
        const fechaFiltro = document.getElementById("filtroFecha").value;

        console.log("Buscando citas para:", fechaFiltro);

        fetch(`include/ObtenerCitas.php?fecha=${fechaFiltro}`)
          .then(res => {
            console.log("Respuesta HTTP:", res.status);
            return res.json();
          })
          .then(citas => {
            console.log("Datos recibidos:", citas);
            const tbody = document.getElementById("tablaCitasHoy");
            tbody.innerHTML = "";

            if (!Array.isArray(citas) || citas.length === 0) {
              console.log("No se encontraron citas o el array está vacío");
              tbody.innerHTML = `<tr><td colspan="5" class="text-center text-muted">No hay citas para ${fechaFiltro} 🐶</td></tr>`;
              $("#modalCitasHoy").modal("show");
              return;
            }

            citas.forEach(c => {
              tbody.innerHTML += `
            <tr>
              <td>${c.nombre_mascota}</td>
              <td>${c.nombre_cliente}</td>
              <td>${c.servicio}</td>
              <td>${c.hora}</td>
              <td>${c.estado ?? 'Pendiente'}</td>
            </tr>`;
            });

            $("#modalCitasHoy").modal("show");
          })
          .catch(err => {
            console.error("Error al cargar citas:", err);
            document.getElementById("tablaCitasHoy").innerHTML =
              `<tr><td colspan="5" class="text-center text-danger">Error al conectar con el servidor 😿</td></tr>`;
            $("#modalCitasHoy").modal("show");
          });
      });

      document.getElementById("btnCorteDia").addEventListener("click", () => {
        const fechaFiltro = document.getElementById("filtroFecha").value;

        console.log("Buscando corte del día para:", fechaFiltro);

        fetch(`include/ObtenerCitas.php?fecha=${fechaFiltro}`)
          .then(res => res.json())
          .then(citas => {
            const tbody = document.getElementById("tablaCorteDia");
            tbody.innerHTML = "";

            if (!Array.isArray(citas) || citas.length === 0) {
              tbody.innerHTML = `<tr><td colspan="4" class="text-center text-muted">No hay registros para ${fechaFiltro} 🐾</td></tr>`;
              $("#modalCorteDia").modal("show");
              return;
            }


            const filtradas = citas.filter(c =>
              ['Terminado', 'Cancelar Cita', 'Terminado servicio', 'Entregado al cliente'].includes(c.estado)
            );

            if (filtradas.length === 0) {
              tbody.innerHTML = `<tr><td colspan="4" class="text-center text-muted">No hay registros finalizados para ${fechaFiltro} 🐾</td></tr>`;
            } else {
              filtradas.forEach(c => {
                tbody.innerHTML += `
              <tr>
                <td>${c.nombre_mascota}</td>
                <td>${c.nombre_cliente}</td>
                <td>${c.servicio}</td>
                <td>${c.estado}</td>
              </tr>`;
              });
            }

            $("#modalCorteDia").modal("show");
          })
          .catch(err => {
            console.error("Error al cargar corte del día:", err);
            document.getElementById("tablaCorteDia").innerHTML =
              `<tr><td colspan="4" class="text-center text-danger">Error al conectar con el servidor 😿</td></tr>`;
            $("#modalCorteDia").modal("show");
          });
      });


      window.imprimirCitasHoy = function () {
        const fechaFiltro = document.getElementById("filtroFecha").value;
        const titulo = `REPORTE DE CITAS - ${fechaFiltro}`;

        const filas = Array.from(document.querySelectorAll('#tablaCitasHoy tr'));

        let totalCitas = 0;
        let citasCompletadas = 0;
        let citasCanceladas = 0;
        let citasPendientes = 0;

        let contenidoTabla = '';

        if (filas.length === 1 && filas[0].querySelector('td[colspan]')) {
          contenidoTabla = `<tr><td colspan="5" class="no-data">No hay citas para esta fecha</td></tr>`;
        } else {
          contenidoTabla = `
            <thead>
                <tr>
                    <th>Mascota</th>
                    <th>Cliente</th>
                    <th>Servicio</th>
                    <th>Hora</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
        `;

          filas.forEach(fila => {
            const celdas = fila.querySelectorAll('td');
            if (celdas.length >= 5) { // Asegurar que es una fila con datos
              const estado = celdas[4].textContent.trim().toLowerCase();
              contenidoTabla += fila.outerHTML;
              totalCitas++;

              if (estado.includes('terminado') || estado.includes('completado') || estado.includes('entregado')) {
                citasCompletadas++;
              } else if (estado.includes('cancelada')) {
                citasCanceladas++;
              } else {
                citasPendientes++;
              }
            }
          });

          contenidoTabla += '</tbody>';
        }

        const w = window.open("", "_blank");
        w.document.write(`
      <html>
        <head>
          <title>${titulo}</title>
          <style>
            body { 
                font-family: 'Arial', sans-serif; 
                padding: 15mm; 
                margin: 0;
                color: #333;
            }
            .header { 
                text-align: center; 
                margin-bottom: 20px;
                border-bottom: 3px solid #007bff;
                padding-bottom: 15px;
            }
            h1 { 
                margin: 0 0 5px 0; 
                color: #007bff;
                font-size: 24px;
            }
            .subtitle {
                color: #666;
                font-size: 14px;
                margin: 0;
            }
            .stats-container {
                display: flex;
                justify-content: space-between;
                margin: 20px 0;
                padding: 15px;
                background: #f8f9fa;
                border-radius: 8px;
                border-left: 4px solid #007bff;
            }
            .stat-item {
                text-align: center;
                flex: 1;
            }
            .stat-number {
                font-size: 24px;
                font-weight: bold;
                display: block;
            }
            .stat-label {
                font-size: 12px;
                color: #666;
                margin-top: 5px;
            }
            .stat-completed { color: #28a745; }
            .stat-cancelled { color: #dc3545; }
            .stat-pending { color: #ffc107; }
            .stat-total { color: #007bff; }
            table { 
                width: 100%; 
                border-collapse: collapse; 
                margin-top: 20px;
                font-size: 12px;
            }
            th { 
                background: #007bff; 
                color: white; 
                font-weight: bold;
                padding: 12px 8px;
                border: 1px solid #0056b3;
            }
            td { 
                padding: 10px 8px;
                border: 1px solid #ddd;
            }
            tr:nth-child(even) { 
                background: #f8f9fa; 
            }
            .no-data { 
                text-align: center; 
                color: #6c757d; 
                font-style: italic;
                padding: 30px;
                background: #f8f9fa;
            }
            .footer {
                margin-top: 30px;
                text-align: center;
                font-size: 11px;
                color: #6c757d;
                border-top: 1px solid #dee2e6;
                padding-top: 10px;
            }
            @media print {
                body { padding: 10mm; }
                .header { margin-bottom: 15px; }
                table { margin-top: 15px; }
                .stats-container { margin: 15px 0; }
            }
          </style>
        </head>
        <body>
          <div class="header">
            <h1>REPORTE DE CITAS</h1>
            <p class="subtitle">Fecha: ${fechaFiltro} | Generado: ${new Date().toLocaleString()}</p>
          </div>
          
          <div class="stats-container">
            <div class="stat-item">
              <span class="stat-number stat-total">${totalCitas}</span>
              <span class="stat-label">TOTAL CITAS</span>
            </div>
          </div>
          
          <table>
            ${contenidoTabla}
          </table>
          
          <div class="footer">
            Estética Canina - Sistema de Gestión de Citas
          </div>
        </body>
      </html>
    `);
        w.document.close();

        setTimeout(() => {
          w.print();
          w.close();
        }, 500);
      }
      window.imprimirCorteDia = function () {
        const fechaFiltro = document.getElementById("filtroFecha").value;
        const titulo = `CORTE DEL DÍA - ${fechaFiltro}`;

        const filas = Array.from(document.querySelectorAll('#tablaCorteDia tr'));


        let totalFinalizadas = 0;
        let totalCanceladas = 0;
        let totalServicios = 0;
        const serviciosCount = {};

        let contenidoTabla = '';

        if (filas.length === 1 && filas[0].querySelector('td[colspan]')) {

          contenidoTabla = `<tr><td colspan="4" class="no-data">No hay registros finalizados para esta fecha</td></tr>`;
        } else {

          contenidoTabla = `
            <thead>
                <tr>
                    <th>Mascota</th>
                    <th>Cliente</th>
                    <th>Servicio</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
        `;

          filas.forEach(fila => {
            const celdas = fila.querySelectorAll('td');
            if (celdas.length >= 4) {
              const servicio = celdas[2].textContent.trim();
              const estado = celdas[3].textContent.trim();

              contenidoTabla += fila.outerHTML;
              totalServicios++;


              serviciosCount[servicio] = (serviciosCount[servicio] || 0) + 1;

              if (estado.includes('Cancelar Cita')) {
                totalCanceladas++;
              } else {
                totalFinalizadas++;
              }
            }
          });

          contenidoTabla += '</tbody>';
        }

        // Crear lista de servicios
        let serviciosHTML = '';
        Object.keys(serviciosCount).forEach(servicio => {
          serviciosHTML += `<div style="margin: 5px 0; font-size: 12px;">• ${servicio}: <strong>${serviciosCount[servicio]}</strong></div>`;
        });

        const w = window.open("", "_blank");
        w.document.write(`
      <html>
        <head>
          <title>${titulo}</title>
          <style>
            body { 
                font-family: 'Arial', sans-serif; 
                padding: 15mm; 
                margin: 0;
                color: #333;
            }
            .header { 
                text-align: center; 
                margin-bottom: 20px;
                border-bottom: 3px solid #28a745;
                padding-bottom: 15px;
            }
            h1 { 
                margin: 0 0 5px 0; 
                color: #28a745;
                font-size: 24px;
            }
            .subtitle {
                color: #666;
                font-size: 14px;
                margin: 0;
            }
            .stats-container {
                display: flex;
                justify-content: space-between;
                margin: 20px 0;
                padding: 15px;
                background: #f8f9fa;
                border-radius: 8px;
                border-left: 4px solid #28a745;
            }
            .stat-item {
                text-align: center;
                flex: 1;
            }
            .stat-number {
                font-size: 24px;
                font-weight: bold;
                display: block;
            }
            .stat-label {
                font-size: 12px;
                color: #666;
                margin-top: 5px;
            }
            .stat-completed { color: #28a745; }
            .stat-cancelled { color: #dc3545; }
            .stat-total { color: #17a2b8; }
            .services-breakdown {
                margin: 15px 0;
                padding: 15px;
                background: #e9f7ef;
                border-radius: 8px;
                border-left: 4px solid #20c997;
            }
            .services-title {
                font-weight: bold;
                margin-bottom: 10px;
                color: #155724;
            }
            table { 
                width: 100%; 
                border-collapse: collapse; 
                margin-top: 20px;
                font-size: 12px;
            }
            th { 
                background: #28a745; 
                color: white; 
                font-weight: bold;
                padding: 12px 8px;
                border: 1px solid #1e7e34;
            }
            td { 
                padding: 10px 8px;
                border: 1px solid #ddd;
            }
            tr:nth-child(even) { 
                background: #f8f9fa; 
            }
            .no-data { 
                text-align: center; 
                color: #6c757d; 
                font-style: italic;
                padding: 30px;
                background: #f8f9fa;
            }
            .footer {
                margin-top: 30px;
                text-align: center;
                font-size: 11px;
                color: #6c757d;
                border-top: 1px solid #dee2e6;
                padding-top: 10px;
            }
            @media print {
                body { padding: 10mm; }
                .header { margin-bottom: 15px; }
                table { margin-top: 15px; }
                .stats-container { margin: 15px 0; }
                .services-breakdown { margin: 10px 0; }
            }
          </style>
        </head>
        <body>
          <div class="header">
            <h1>CORTE DEL DÍA</h1>
            <p class="subtitle">Fecha: ${fechaFiltro} | Generado: ${new Date().toLocaleString()}</p>
          </div>
          
          <div class="stats-container">
            <div class="stat-item">
              <span class="stat-number stat-total">${totalServicios}</span>
              <span class="stat-label">TOTAL SERVICIOS</span>
            </div>
            <div class="stat-item">
              <span class="stat-number stat-completed">${totalFinalizadas}</span>
              <span class="stat-label">FINALIZADAS</span>
            </div>
            <div class="stat-item">
              <span class="stat-number stat-cancelled">${totalCanceladas}</span>
              <span class="stat-label">CANCELADAS</span>
            </div>
          </div>
          
          ${totalServicios > 0 ? `
          <div class="services-breakdown">
            <div class="services-title">Desglose por Servicios:</div>
            ${serviciosHTML}
          </div>
          ` : ''}
          
          <table>
            ${contenidoTabla}
          </table>
          
          <div class="footer">
            Estética Canina - Sistema de Gestión de Citas
          </div>
        </body>
      </html>
    `);
        w.document.close();

        setTimeout(() => {
          w.print();
          w.close();
        }, 500);
      }
    });
  </script>


</body>

</html>