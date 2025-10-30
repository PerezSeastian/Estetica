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
    <title>Panel Admin — Reporte Citas de Hoy</title>
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
                    <li class="nav-item"><a href="adminContactos.php" class="nav-link">
                            <span class="fa fa-bar-chart mr-1"></span>Contactar
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
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <div>
                                    <h4 class="section-title">📅 Reporte de Citas del Día</h4>
                                    <p class="section-subtitle mb-0">Todas las citas programadas para hoy</p>
                                </div>
                                <div class="fecha-selector">
                                    <span class="fa fa-calendar mr-2"></span>
                                    <input type="date" id="filtroFecha" class="form-control" value="<?= date('Y-m-d') ?>">
                                    <button class="btn btn-primary ml-2" onclick="cargarReporte()">
                                        <span class="fa fa-refresh"></span> Actualizar
                                    </button>
                                    <button class="btn btn-success ml-2" onclick="imprimirReporte()">
                                        <span class="fa fa-print"></span> Imprimir
                                    </button>
                                </div>
                            </div>

                            <!-- Estadísticas Principales -->
                            <div class="row mb-4">
                                <div class="col-md-3">
                                    <div class="stat-card primary">
                                        <div class="stat-icon">📅</div>
                                        <div class="stat-info">
                                            <div class="stat-number" id="totalCitas">0</div>
                                            <div class="stat-label">Total Citas</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="stat-card success">
                                        <div class="stat-icon">✅</div>
                                        <div class="stat-info">
                                            <div class="stat-number" id="citasCompletadas">0</div>
                                            <div class="stat-label">Completadas</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="stat-card warning">
                                        <div class="stat-icon">⏳</div>
                                        <div class="stat-info">
                                            <div class="stat-number" id="citasPendientes">0</div>
                                            <div class="stat-label">Pendientes</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="stat-card danger">
                                        <div class="stat-icon">❌</div>
                                        <div class="stat-info">
                                            <div class="stat-number" id="citasCanceladas">0</div>
                                            <div class="stat-label">Canceladas</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Tabla de Citas -->
                            <div class="reporte-seccion">
                                <div class="seccion-header">
                                    <h5>📋 Lista de Citas del Día</h5>
                                    <span class="badge badge-primary" id="contadorCitas">0 citas</span>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th>Mascota</th>
                                                <th>Cliente</th>
                                                <th>Teléfono</th>
                                                <th>Servicio</th>
                                                <th>Hora</th>
                                                <th>Estado</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tablaCitas">
                                            <tr>
                                                <td colspan="6" class="text-center text-muted">Cargando citas...</td>
                                            </tr>
                                        </tbody>
                                    </table>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
    // Función para cargar el reporte
    function cargarReporte() {
        const fecha = document.getElementById('filtroFecha').value;
        
        // Mostrar loading
        document.getElementById('tablaCitas').innerHTML = '<tr><td colspan="6" class="text-center text-muted">Cargando citas...</td></tr>';

        fetch(`include/ObtenerCitas.php?fecha=${fecha}`)
            .then(response => response.json())
            .then(citas => {
                console.log('Citas recibidas:', citas);
                actualizarEstadisticas(citas);
                mostrarCitas(citas);
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire('Error', 'No se pudo cargar el reporte', 'error');
                document.getElementById('tablaCitas').innerHTML = '<tr><td colspan="6" class="text-center text-danger">Error al cargar las citas</td></tr>';
            });
    }

    // Actualizar estadísticas
    function actualizarEstadisticas(citas) {
        const totalCitas = citas.length;
        const completadas = citas.filter(c => 
            c.estado && (c.estado.includes('Terminado') || c.estado.includes('Entregado') || c.estado.includes('Terminado servicio'))
        ).length;
        const canceladas = citas.filter(c => 
            c.estado && c.estado.includes('Cancelar Cita')
        ).length;
        const pendientes = totalCitas - completadas - canceladas;

        // Actualizar contadores
        document.getElementById('totalCitas').textContent = totalCitas;
        document.getElementById('citasCompletadas').textContent = completadas;
        document.getElementById('citasPendientes').textContent = pendientes;
        document.getElementById('citasCanceladas').textContent = canceladas;
        document.getElementById('contadorCitas').textContent = `${totalCitas} citas`;
    }

    // Mostrar citas en la tabla
    function mostrarCitas(citas) {
        const tbody = document.getElementById('tablaCitas');
        
        if (!Array.isArray(citas) || citas.length === 0) {
            tbody.innerHTML = '<tr><td colspan="6" class="text-center text-muted">No hay citas para esta fecha</td></tr>';
            return;
        }

        tbody.innerHTML = '';
        citas.forEach(cita => {
            tbody.innerHTML += `
                <tr>
                    <td><strong>${cita.nombre_mascota || 'N/A'}</strong></td>
                    <td>${cita.nombre_cliente || 'N/A'}</td>
                    <td>${cita.telefono || 'N/A'}</td>
                    <td>${cita.servicio || 'N/A'}</td>
                    <td>${cita.hora || 'N/A'}</td>
                    <td>
                        <span class="badge ${obtenerClaseEstado(cita.estado)}">
                            ${cita.estado || 'Pendiente'}
                        </span>
                    </td>
                </tr>
            `;
        });
    }

    // Obtener clase CSS para el estado
    function obtenerClaseEstado(estado) {
        if (!estado) return 'badge-secondary';
        
        if (estado.includes('Terminado') || estado.includes('Entregado')) {
            return 'badge-success';
        } else if (estado.includes('Cancelar Cita')) {
            return 'badge-danger';
        } else if (estado.includes('Pendiente')) {
            return 'badge-warning';
        } else if (estado.includes('En servicio') || estado.includes('Proceso')) {
            return 'badge-info';
        } else {
            return 'badge-primary';
        }
    }

    // Función para imprimir el reporte
    function imprimirReporte() {
        const fecha = document.getElementById('filtroFecha').value;
        const fechaFormateada = new Date(fecha).toLocaleDateString('es-ES');
        
        // Obtener datos actuales de la tabla
        const citas = obtenerDatosTabla();
        const estadisticas = calcularEstadisticas(citas);
        
        // Crear contenido para impresión
        const contenido = generarContenidoImpresion(citas, estadisticas, fechaFormateada);
        
        // Crear ventana de impresión
        const ventanaImpresion = window.open('', '_blank', 'width=1000,height=700');
        ventanaImpresion.document.write(contenido);
        ventanaImpresion.document.close();
        
        // Esperar a que cargue el contenido y luego imprimir
        setTimeout(() => {
            ventanaImpresion.print();
        }, 500);
    }

    // Obtener datos actuales de la tabla
    function obtenerDatosTabla() {
        const citas = [];
        const filas = document.querySelectorAll('#tablaCitas tr');
        
        filas.forEach(fila => {
            const celdas = fila.querySelectorAll('td');
            if (celdas.length >= 6) {
                citas.push({
                    mascota: celdas[0].textContent,
                    cliente: celdas[1].textContent,
                    telefono: celdas[2].textContent,
                    servicio: celdas[3].textContent,
                    hora: celdas[4].textContent,
                    estado: celdas[5].textContent
                });
            }
        });
        
        return citas;
    }

    // Calcular estadísticas para impresión
    function calcularEstadisticas(citas) {
        const total = citas.length;
        const completadas = citas.filter(c => 
            c.estado.includes('Terminado') || c.estado.includes('Entregado') || c.estado.includes('Terminado servicio')
        ).length;
        const canceladas = citas.filter(c => c.estado.includes('Cancelar Cita')).length;
        const pendientes = total - completadas - canceladas;
        
        return { total, completadas, canceladas, pendientes };
    }

    // Generar contenido para impresión
    function generarContenidoImpresion(citas, estadisticas, fechaFormateada) {
        // Generar filas de la tabla
        let filasTabla = '';
        if (citas.length > 0) {
            citas.forEach(cita => {
                filasTabla += `
                    <tr>
                        <td>${cita.mascota}</td>
                        <td>${cita.cliente}</td>
                        <td>${cita.telefono}</td>
                        <td>${cita.servicio}</td>
                        <td>${cita.hora}</td>
                        <td>${cita.estado}</td>
                    </tr>
                `;
            });
        } else {
            filasTabla = '<tr><td colspan="6" class="text-center">No hay citas para esta fecha</td></tr>';
        }

        return `
            <!DOCTYPE html>
            <html>
            <head>
                <title>Reporte de Citas - ${fechaFormateada}</title>
                <meta charset="utf-8">
                <style>
                    body { 
                        font-family: 'Arial', sans-serif; 
                        margin: 20px; 
                        color: #333;
                        background: white;
                    }
                    .header { 
                        text-align: center; 
                        margin-bottom: 30px;
                        border-bottom: 3px solid #007bff;
                        padding-bottom: 20px;
                    }
                    h1 { 
                        color: #007bff; 
                        margin-bottom: 5px;
                        font-size: 28px;
                    }
                    .subtitle {
                        color: #666;
                        font-size: 16px;
                    }
                    .stats-container {
                        display: flex;
                        justify-content: space-between;
                        margin: 25px 0;
                        gap: 15px;
                    }
                    .stat-card {
                        flex: 1;
                        padding: 20px;
                        border-radius: 8px;
                        text-align: center;
                        color: white;
                        font-weight: bold;
                    }
                    .stat-total { background: #007bff; }
                    .stat-completed { background: #28a745; }
                    .stat-pending { background: #ffc107; color: black; }
                    .stat-cancelled { background: #dc3545; }
                    .stat-number {
                        font-size: 24px;
                        display: block;
                        margin-bottom: 5px;
                    }
                    .stat-label {
                        font-size: 14px;
                        opacity: 0.9;
                    }
                    .table-container {
                        margin: 30px 0;
                    }
                    table {
                        width: 100%;
                        border-collapse: collapse;
                        margin-bottom: 20px;
                        font-size: 12px;
                    }
                    th {
                        background: #343a40;
                        color: white;
                        padding: 12px 8px;
                        text-align: left;
                        border: 1px solid #454d55;
                    }
                    td {
                        padding: 10px 8px;
                        border: 1px solid #dee2e6;
                    }
                    tr:nth-child(even) {
                        background: #f8f9fa;
                    }
                    .footer {
                        text-align: center;
                        margin-top: 30px;
                        color: #666;
                        font-size: 12px;
                        border-top: 1px solid #dee2e6;
                        padding-top: 15px;
                    }
                    @media print {
                        body { margin: 0; }
                        .header { margin-bottom: 20px; }
                        .stats-container { margin: 20px 0; }
                        .table-container { margin: 20px 0; }
                    }
                    @page {
                        size: landscape;
                        margin: 10mm;
                    }
                </style>
            </head>
            <body>
                <div class="header">
                    <h1>REPORTE DE CITAS DEL DÍA</h1>
                    <div class="subtitle">Fecha: ${fechaFormateada}</div>
                    <div class="subtitle">Generado el: ${new Date().toLocaleString('es-ES')}</div>
                </div>

                <div class="stats-container">
                    <div class="stat-card stat-total">
                        <span class="stat-number">${estadisticas.total}</span>
                        <span class="stat-label">TOTAL CITAS</span>
                    </div>
                    <div class="stat-card stat-completed">
                        <span class="stat-number">${estadisticas.completadas}</span>
                        <span class="stat-label">COMPLETADAS</span>
                    </div>
                    <div class="stat-card stat-pending">
                        <span class="stat-number">${estadisticas.pendientes}</span>
                        <span class="stat-label">PENDIENTES</span>
                    </div>
                    <div class="stat-card stat-cancelled">
                        <span class="stat-number">${estadisticas.canceladas}</span>
                        <span class="stat-label">CANCELADAS</span>
                    </div>
                </div>

                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Mascota</th>
                                <th>Cliente</th>
                                <th>Teléfono</th>
                                <th>Servicio</th>
                                <th>Hora</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            ${filasTabla}
                        </tbody>
                    </table>
                </div>

                <div class="footer">
                    Estética Canina - Sistema de Gestión de Citas
                </div>
            </body>
            </html>
        `;
    }

    // Cargar reporte al iniciar la página
    document.addEventListener('DOMContentLoaded', function() {
        cargarReporte();
        
        // Actualizar automáticamente cuando cambia la fecha
        document.getElementById('filtroFecha').addEventListener('change', cargarReporte);
    });
    </script>

</body>
</html>