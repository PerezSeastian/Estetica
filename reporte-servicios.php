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
    <title>Panel Admin — Reporte de Servicios</title>
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
                    <li class="nav-item dropdown active">
                        <a class="nav-link dropdown-toggle" href="#" id="reportesDropdown" role="button" 
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="fa fa-bar-chart mr-1"></span>Reportes
                        </a>
                        <div class="dropdown-menu" aria-labelledby="reportesDropdown">
                            <a class="dropdown-item" href="adminReporteCitasHoy.php">
                                <span class="fa fa-calendar mr-2"></span>Reporte Diario
                            </a>
                            <a class="dropdown-item active" href="reporte-servicios.php">
                                <span class="fa fa-star mr-2"></span>Servicios Más Solicitados
                            </a>
                        </div>
                    </li>
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
                                    <h4 class="section-title">⭐ Reporte de Servicios Más Solicitados</h4>
                                    <p class="section-subtitle mb-0">Análisis de popularidad de servicios</p>
                                </div>
                                <div class="fecha-selector">
                                    <span class="fa fa-calendar mr-2"></span>
                                    <input type="month" id="filtroMes" class="form-control" 
                                           value="<?= date('Y-m') ?>">
                                    <button class="btn btn-primary ml-2" onclick="cargarReporteServicios()">
                                        <span class="fa fa-refresh"></span> Actualizar
                                    </button>
                                    <button class="btn btn-success ml-2" onclick="imprimirReporteServicios()">
                                        <span class="fa fa-print"></span> Imprimir
                                    </button>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-3">
                                    <div class="stat-card primary">
                                        <div class="stat-icon">📊</div>
                                        <div class="stat-info">
                                            <div class="stat-number" id="totalServicios">0</div>
                                            <div class="stat-label">Total Servicios</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="stat-card success">
                                        <div class="stat-icon">⭐</div>
                                        <div class="stat-info">
                                            <div class="stat-number" id="servicioTop">-</div>
                                            <div class="stat-label">Servicio Más Popular</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="stat-card warning">
                                        <div class="stat-icon">📈</div>
                                        <div class="stat-info">
                                            <div class="stat-number" id="totalCitasServicios">0</div>
                                            <div class="stat-label">Total Citas</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="stat-card info">
                                        <div class="stat-icon">📅</div>
                                        <div class="stat-info">
                                            <div class="stat-number" id="promedioMensual">0</div>
                                            <div class="stat-label">Promedio Mensual</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-8">
                                    <div class="reporte-seccion">
                                        <div class="seccion-header">
                                            <h5>📊 Distribución de Servicios</h5>
                                        </div>
                                        <div class="grafica-container" style="height: 400px;">
                                            <canvas id="graficaServicios"></canvas>
                                        </div>
                                        <div class="grafica-leyenda" id="leyendaServicios">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="reporte-seccion">
                                        <div class="seccion-header">
                                            <h5>🏆 Ranking de Servicios</h5>
                                        </div>
                                        <div class="ranking-container" id="rankingServicios">
                                            <div class="text-center text-muted py-4">
                                                Cargando ranking...
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                
                            <div class="reporte-seccion">
                                <div class="seccion-header">
                                    <h5>📋 Detalle de Servicios por Mes</h5>
                                    <span class="badge badge-primary" id="contadorServicios">0 servicios</span>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th>#</th>
                                                <th>Servicio</th>
                                                <th>Total de Citas</th>
                                                <th>Porcentaje</th>
                                                <th>Frecuencia Mensual</th>
                                                <th>Tendencia</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tablaServicios">
                                            <tr>
                                                <td colspan="6" class="text-center text-muted">Cargando servicios...</td>
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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        function cargarReporteServicios() {
            const mes = document.getElementById('filtroMes').value;
            
            console.log('🔍 Solicitando reporte de servicios para:', mes);
            
            document.getElementById('tablaServicios').innerHTML = '<tr><td colspan="6" class="text-center text-muted">Cargando servicios...</td></tr>';
            document.getElementById('rankingServicios').innerHTML = '<div class="text-center text-muted py-4">Cargando ranking...</div>';
            document.getElementById('leyendaServicios').innerHTML = '<div class="text-muted">Cargando...</div>';

            fetch(`include/ObtenerServicios.php?mes=${mes}`)
                .then(response => {
                    console.log('📡 Respuesta HTTP:', response.status, response.statusText);
                    if (!response.ok) {
                        throw new Error(`Error HTTP: ${response.status}`);
                    }
                    return response.json();
                })
                .then(servicios => {
                    console.log('✅ Servicios recibidos:', servicios);
                    if (servicios.error) {
                        throw new Error(servicios.error);
                    }
                    
                    if (!Array.isArray(servicios)) {
                        throw new Error('Los datos recibidos no son válidos');
                    }
                    
                    actualizarEstadisticasServicios(servicios);
                    actualizarGraficaServicios(servicios);
                    actualizarRankingServicios(servicios);
                    mostrarTablaServicios(servicios);
                })
                .catch(error => {
                    console.error('❌ Error completo:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'No se pudo cargar el reporte: ' + error.message,
                        confirmButtonText: 'OK'
                    });
                    document.getElementById('tablaServicios').innerHTML = '<tr><td colspan="6" class="text-center text-danger">Error al cargar los servicios: ' + error.message + '</td></tr>';
                    document.getElementById('rankingServicios').innerHTML = '<div class="text-center text-danger py-4">Error al cargar datos</div>';
                    document.getElementById('leyendaServicios').innerHTML = '<div class="text-danger">Error al cargar datos</div>';
                });
        }

        function actualizarEstadisticasServicios(servicios) {
            const totalServicios = servicios.length;
            const totalCitas = servicios.reduce((sum, servicio) => sum + parseInt(servicio.total_citas), 0);
            
            const servicioTop = servicios.length > 0 ? 
                servicios.reduce((max, servicio) => 
                    parseInt(servicio.total_citas) > parseInt(max.total_citas) ? servicio : max
                ) : null;

            const promedioMensual = totalServicios > 0 ? Math.round(totalCitas / totalServicios) : 0;

            document.getElementById('totalServicios').textContent = totalServicios;
            document.getElementById('servicioTop').textContent = servicioTop ? servicioTop.servicio.substring(0, 15) + '...' : '-';
            document.getElementById('totalCitasServicios').textContent = totalCitas;
            document.getElementById('promedioMensual').textContent = promedioMensual;
            document.getElementById('contadorServicios').textContent = `${totalServicios} servicios`;
        }

        function actualizarGraficaServicios(servicios) {
            if (typeof Chart === 'undefined') {
                console.error('Chart.js no está cargado');
                return;
            }

            const ctx = document.getElementById('graficaServicios');
            
            if (!ctx) {
                console.error('No se encontró el canvas graficaServicios');
                return;
            }

            if (window.graficaServicios && typeof window.graficaServicios.destroy === 'function') {
                window.graficaServicios.destroy();
            }

            const serviciosOrdenados = [...servicios]
                .sort((a, b) => parseInt(b.total_citas) - parseInt(a.total_citas))
                .slice(0, 10);

            const labels = serviciosOrdenados.map(s => s.servicio);
            const data = serviciosOrdenados.map(s => parseInt(s.total_citas));
            const totalCitas = data.reduce((sum, count) => sum + count, 0);

            const backgroundColors = generarColoresServicios(serviciosOrdenados.length);

            try {
                window.graficaServicios = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Número de Citas',
                            data: data,
                            backgroundColor: backgroundColors,
                            borderColor: backgroundColors.map(color => color.replace('0.8', '1')),
                            borderWidth: 2,
                            borderRadius: 8,
                            borderSkipped: false,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        const value = context.raw || 0;
                                        const percentage = totalCitas > 0 ? Math.round((value / totalCitas) * 100) : 0;
                                        return `Citas: ${value} (${percentage}%)`;
                                    }
                                }
                            },
                            title: {
                                display: true,
                                text: 'Top 10 Servicios Más Solicitados',
                                font: {
                                    size: 16,
                                    weight: 'bold'
                                },
                                padding: 20
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'Número de Citas'
                                },
                                ticks: {
                                    stepSize: 1
                                }
                            },
                            x: {
                                title: {
                                    display: true,
                                    text: 'Servicios'
                                },
                                ticks: {
                                    maxRotation: 45,
                                    minRotation: 45
                                }
                            }
                        },
                        animation: {
                            duration: 1000,
                            easing: 'easeInOutQuart'
                        }
                    }
                });

                actualizarLeyendaServicios(serviciosOrdenados, totalCitas);
                
            } catch (error) {
                console.error('Error al crear gráfica de servicios:', error);
                document.getElementById('leyendaServicios').innerHTML = 
                    '<div class="text-danger">Error al cargar gráfica</div>';
            }
        }

        function generarColoresServicios(cantidad) {
            const coloresBase = [
                'rgba(255, 99, 132, 0.8)',
                'rgba(54, 162, 235, 0.8)',
                'rgba(255, 206, 86, 0.8)',
                'rgba(75, 192, 192, 0.8)',
                'rgba(153, 102, 255, 0.8)',
                'rgba(255, 159, 64, 0.8)',
                'rgba(199, 199, 199, 0.8)',
                'rgba(83, 102, 255, 0.8)',
                'rgba(40, 159, 64, 0.8)',
                'rgba(210, 99, 132, 0.8)'
            ];
            
            if (cantidad <= coloresBase.length) {
                return coloresBase.slice(0, cantidad);
            }
            
            const coloresAdicionales = [];
            for (let i = coloresBase.length; i < cantidad; i++) {
                const r = Math.floor(Math.random() * 255);
                const g = Math.floor(Math.random() * 255);
                const b = Math.floor(Math.random() * 255);
                coloresAdicionales.push(`rgba(${r}, ${g}, ${b}, 0.8)`);
            }
            
            return [...coloresBase, ...coloresAdicionales];
        }

        function actualizarLeyendaServicios(servicios, totalCitas) {
            const leyenda = document.getElementById('leyendaServicios');
            
            if (servicios.length === 0) {
                leyenda.innerHTML = '<div class="text-center text-muted">No hay datos para mostrar</div>';
                return;
            }

            let leyendaHTML = '<div class="leyenda-header"><strong>Resumen de Servicios (Top 10)</strong></div>';
            
            servicios.forEach((servicio, index) => {
                const porcentaje = totalCitas > 0 ? Math.round((parseInt(servicio.total_citas) / totalCitas) * 100) : 0;
                const colores = generarColoresServicios(servicios.length);
                
                leyendaHTML += `
                    <div class="leyenda-item">
                        <span class="leyenda-color" style="background-color: ${colores[index]}"></span>
                        <span class="leyenda-texto">
                            <strong>${servicio.servicio}:</strong> ${servicio.total_citas} citas (${porcentaje}%)
                        </span>
                    </div>
                `;
            });
            
            leyendaHTML += `<div class="leyenda-total mt-2 pt-2 border-top">
                <strong>Total de citas analizadas: ${totalCitas}</strong>
            </div>`;
            
            leyenda.innerHTML = leyendaHTML;
        }

        function actualizarRankingServicios(servicios) {
            const rankingContainer = document.getElementById('rankingServicios');
            
            if (!Array.isArray(servicios) || servicios.length === 0) {
                rankingContainer.innerHTML = '<div class="text-center text-muted py-4">No hay servicios para mostrar</div>';
                return;
            }

            const topServicios = [...servicios]
                .sort((a, b) => parseInt(b.total_citas) - parseInt(a.total_citas))
                .slice(0, 5);

            let rankingHTML = '';
            
            topServicios.forEach((servicio, index) => {
                const emojis = ['🥇', '🥈', '🥉', '4️⃣', '5️⃣'];
                const totalCitas = servicios.reduce((sum, s) => sum + parseInt(s.total_citas), 0);
                const porcentaje = totalCitas > 0 ? Math.round((parseInt(servicio.total_citas) / totalCitas) * 100) : 0;
                
                rankingHTML += `
                    <div class="ranking-item ${index < 3 ? 'ranking-top' : ''}">
                        <div class="ranking-posicion">
                            <span class="ranking-emoji">${emojis[index]}</span>
                            <span class="ranking-numero">#${index + 1}</span>
                        </div>
                        <div class="ranking-info">
                            <div class="ranking-servicio">${servicio.servicio}</div>
                            <div class="ranking-stats">
                                <span class="ranking-citas">${servicio.total_citas} citas</span>
                                <span class="ranking-porcentaje">${porcentaje}%</span>
                            </div>
                            <div class="ranking-bar">
                                <div class="ranking-bar-fill" style="width: ${porcentaje}%"></div>
                            </div>
                        </div>
                    </div>
                `;
            });
            
            rankingContainer.innerHTML = rankingHTML;
        }

function mostrarTablaServicios(servicios) {
    const tbody = document.getElementById('tablaServicios');
    
    if (!Array.isArray(servicios) || servicios.length === 0) {
        tbody.innerHTML = '<tr><td colspan="6" class="text-center text-muted">No hay servicios para esta fecha</td></tr>';
        return;
    }

    // Ordenar por popularidad
    const serviciosOrdenados = [...servicios].sort((a, b) => 
        parseInt(b.total_citas) - parseInt(a.total_citas)
    );

    const totalCitas = serviciosOrdenados.reduce((sum, servicio) => sum + parseInt(servicio.total_citas), 0);

    tbody.innerHTML = '';
    serviciosOrdenados.forEach((servicio, index) => {
        const porcentaje = totalCitas > 0 ? Math.round((parseInt(servicio.total_citas) / totalCitas) * 100) : 0;
        // Calcular frecuencia mensual (citas por mes)
        const frecuenciaMensual = parseInt(servicio.total_citas);
        
        tbody.innerHTML += `
            <tr>
                <td><strong>${index + 1}</strong></td>
                <td><strong>${servicio.servicio}</strong></td>
                <td>
                    <span class="badge badge-primary badge-pill">${servicio.total_citas}</span>
                </td>
                <td>
                    <div class="progress" style="height: 20px;">
                        <div class="progress-bar" role="progressbar" 
                             style="width: ${porcentaje}%; background-color: ${generarColorPorIndice(index)};">
                            ${porcentaje}%
                        </div>
                    </div>
                </td>
                <td>
                    <span class="text-info font-weight-bold">
                        ${frecuenciaMensual} citas/mes
                    </span>
                </td>
                <td>
                    <span class="badge ${obtenerTendencia(parseInt(servicio.total_citas), index)}">
                        ${obtenerIconoTendencia(parseInt(servicio.total_citas), index)}
                    </span>
                </td>
            </tr>
        `;
    });
}

        function generarColorPorIndice(index) {
            const colores = [
                '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF',
                '#FF9F40', '#FF6384', '#C9CBCF', '#4BC0C0', '#FF6384'
            ];
            return colores[index % colores.length];
        }

        function obtenerTendencia(totalCitas, index) {
            if (index < 3) return 'badge-success';
            if (index < 6) return 'badge-warning';
            return 'badge-secondary';
        }

        function obtenerIconoTendencia(totalCitas, index) {
            if (index < 3) return '📈 Alta demanda';
            if (index < 6) return '📊 Media demanda';
            return '📉 Baja demanda';
        }

        // Función para imprimir el reporte de servicios
function imprimirReporteServicios() {
    const mes = document.getElementById('filtroMes').value;
    const mesFormateado = new Date(mes + '-01').toLocaleDateString('es-ES', { 
        year: 'numeric', 
        month: 'long' 
    });
    
    const servicios = obtenerDatosTablaServicios();
    const estadisticas = calcularEstadisticasServicios(servicios);
    const datosGrafica = obtenerDatosGraficaServiciosActual();
    
    const contenido = generarContenidoImpresionServicios(servicios, estadisticas, mesFormateado, datosGrafica);
    
    const ventanaImpresion = window.open('', '_blank', 'width=1000,height=700');
    ventanaImpresion.document.write(contenido);
    ventanaImpresion.document.close();
    
    setTimeout(() => {
        ventanaImpresion.print();
    }, 500);
}

function obtenerDatosTablaServicios() {
    const servicios = [];
    const filas = document.querySelectorAll('#tablaServicios tr');
    
    filas.forEach(fila => {
        const celdas = fila.querySelectorAll('td');
        if (celdas.length >= 6) {
            servicios.push({
                posicion: celdas[0].textContent.trim(),
                servicio: celdas[1].textContent.trim(),
                total_citas: celdas[2].textContent.trim(),
                porcentaje: celdas[3].querySelector('.progress-bar')?.textContent.trim() || '0%',
                ingreso: celdas[4].textContent.trim(),
                tendencia: celdas[5].textContent.trim()
            });
        }
    });
    
    return servicios;
}

function calcularEstadisticasServicios(servicios) {
    const totalServicios = servicios.length;
    const totalCitas = servicios.reduce((sum, servicio) => {
        const citas = parseInt(servicio.total_citas) || 0;
        return sum + citas;
    }, 0);
    
    const servicioTop = servicios.length > 0 ? servicios[0] : null;
    const promedioMensual = totalServicios > 0 ? Math.round(totalCitas / totalServicios) : 0;
    
    return { 
        totalServicios, 
        totalCitas, 
        servicioTop: servicioTop?.servicio || '-', 
        promedioMensual 
    };
}

function obtenerDatosGraficaServiciosActual() {
    if (!window.graficaServicios) return null;
    
    const chart = window.graficaServicios;
    return {
        labels: chart.data.labels,
        data: chart.data.datasets[0].data,
        colors: chart.data.datasets[0].backgroundColor,
        total: chart.data.datasets[0].data.reduce((a, b) => a + b, 0)
    };
}

function generarContenidoImpresionServicios(servicios, estadisticas, mesFormateado, datosGrafica) {
    let filasTabla = '';
    if (servicios.length > 0) {
        servicios.forEach(servicio => {
            filasTabla += `
                <tr>
                    <td style="text-align: center;"><strong>${servicio.posicion}</strong></td>
                    <td><strong>${servicio.servicio}</strong></td>
                    <td style="text-align: center;">${servicio.total_citas}</td>
                    <td>
                        <div style="background: #e9ecef; border-radius: 10px; height: 20px; position: relative;">
                            <div style="background: #007bff; height: 100%; border-radius: 10px; width: ${servicio.porcentaje}; display: flex; align-items: center; justify-content: center; color: white; font-size: 11px; font-weight: bold;">
                                ${servicio.porcentaje}
                            </div>
                        </div>
                    </td>
                    <td style="text-align: right; color: #28a745; font-weight: bold;">${servicio.ingreso}</td>
                    <td style="text-align: center;">
                        <span style="background: #28a745; color: white; padding: 4px 8px; border-radius: 12px; font-size: 11px;">
                            ${servicio.tendencia}
                        </span>
                    </td>
                </tr>
            `;
        });
    } else {
        filasTabla = '<tr><td colspan="6" class="text-center">No hay servicios para este mes</td></tr>';
    }

    let seccionGrafica = '';
    if (datosGrafica && datosGrafica.total > 0) {
        seccionGrafica = `
            <div style="margin: 25px 0; padding: 20px; border: 2px solid #e9ecef; border-radius: 10px; background: #f8f9fa;">
                <h3 style="text-align: center; color: #007bff; margin: 0 0 20px 0;">📊 Distribución de Servicios - Top 10</h3>
                <div style="display: flex; justify-content: center; gap: 40px; flex-wrap: wrap;">
                    ${generarGraficaBarrasImpresion(datosGrafica)}
                    ${generarLeyendaImpresionServicios(datosGrafica)}
                </div>
            </div>
        `;
    }

    return `
        <!DOCTYPE html>
        <html>
        <head>
            <title>Reporte de Servicios - ${mesFormateado}</title>
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
                .stat-primary { background: linear-gradient(135deg, #007bff, #0056b3); }
                .stat-success { background: linear-gradient(135deg, #28a745, #20c997); }
                .stat-warning { background: linear-gradient(135deg, #ffc107, #fd7e14); }
                .stat-info { background: linear-gradient(135deg, #17a2b8, #138496); }
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
                /* Estilos para gráfica impresa */
                .grafica-barras {
                    display: flex;
                    flex-direction: column;
                    gap: 12px;
                    min-width: 300px;
                }
                .barra-container {
                    display: flex;
                    align-items: center;
                    gap: 10px;
                }
                .barra-label {
                    width: 120px;
                    font-weight: bold;
                    font-size: 12px;
                    text-align: right;
                }
                .barra {
                    flex: 1;
                    height: 20px;
                    background: #e9ecef;
                    border-radius: 4px;
                    overflow: hidden;
                    position: relative;
                    min-width: 150px;
                }
                .barra-fill {
                    height: 100%;
                    border-radius: 4px;
                    display: flex;
                    align-items: center;
                    justify-content: flex-end;
                    padding-right: 8px;
                    color: white;
                    font-weight: bold;
                    font-size: 10px;
                }
                .leyenda-impresa {
                    display: flex;
                    flex-direction: column;
                    gap: 8px;
                    min-width: 250px;
                }
                .item-leyenda {
                    display: flex;
                    align-items: center;
                    gap: 8px;
                    padding: 5px;
                }
                .color-leyenda {
                    width: 16px;
                    height: 16px;
                    border-radius: 4px;
                    border: 2px solid #fff;
                    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
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
                <h1>REPORTE DE SERVICIOS MÁS SOLICITADOS</h1>
                <div class="subtitle">Período: ${mesFormateado}</div>
                <div class="subtitle">Generado el: ${new Date().toLocaleString('es-ES')}</div>
            </div>

            <div class="stats-container">
                <div class="stat-card stat-primary">
                    <span class="stat-number">${estadisticas.totalServicios}</span>
                    <span class="stat-label">TOTAL SERVICIOS</span>
                </div>
                <div class="stat-card stat-success">
                    <span class="stat-number">${estadisticas.servicioTop}</span>
                    <span class="stat-label">SERVICIO MÁS POPULAR</span>
                </div>
                <div class="stat-card stat-warning">
                    <span class="stat-number">${estadisticas.totalCitas}</span>
                    <span class="stat-label">TOTAL CITAS</span>
                </div>
                <div class="stat-card stat-info">
                    <span class="stat-number">${estadisticas.promedioMensual}</span>
                    <span class="stat-label">PROMEDIO MENSUAL</span>
                </div>
            </div>

            ${seccionGrafica}

            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th style="width: 5%; text-align: center;">#</th>
                            <th style="width: 25%;">Servicio</th>
                            <th style="width: 15%; text-align: center;">Total Citas</th>
                            <th style="width: 20%;">Porcentaje</th>
                            <th style="width: 20%; text-align: right;">Ingreso Estimado</th>
                            <th style="width: 15%; text-align: center;">Tendencia</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${filasTabla}
                    </tbody>
                </table>
            </div>

            <div class="footer">
                Estética Canina - Sistema de Gestión de Citas<br>
                Reporte de Servicios Más Solicitados
            </div>
        </body>
        </html>
    `;
}

function generarGraficaBarrasImpresion(datosGrafica) {
    const maxVal = Math.max(...datosGrafica.data);
    
    return `
        <div class="grafica-barras">
            ${datosGrafica.labels.map((label, index) => {
                const valor = datosGrafica.data[index];
                const porcentaje = datosGrafica.total > 0 ? Math.round((valor / datosGrafica.total) * 100) : 0;
                const ancho = maxVal > 0 ? (valor / maxVal) * 100 : 0;
                
                return `
                    <div class="barra-container">
                        <div class="barra-label">${label}</div>
                        <div class="barra">
                            <div class="barra-fill" style="width: ${ancho}%; background-color: ${datosGrafica.colors[index]};">
                                ${valor} (${porcentaje}%)
                            </div>
                        </div>
                    </div>
                `;
            }).join('')}
        </div>
    `;
}

function generarLeyendaImpresionServicios(datosGrafica) {
    return `
        <div class="leyenda-impresa">
            <h4 style="margin: 0 0 15px 0; color: #495057; text-align: center;">Resumen de Servicios</h4>
            ${datosGrafica.labels.map((label, index) => {
                const valor = datosGrafica.data[index];
                const porcentaje = datosGrafica.total > 0 ? Math.round((valor / datosGrafica.total) * 100) : 0;
                
                return `
                    <div class="item-leyenda">
                        <div class="color-leyenda" style="background-color: ${datosGrafica.colors[index]}"></div>
                        <div style="font-size: 12px; flex: 1;">
                            <strong>${label}:</strong> ${valor} citas
                        </div>
                        <div style="font-size: 11px; color: #666; font-weight: bold;">
                            ${porcentaje}%
                        </div>
                    </div>
                `;
            }).join('')}
            <div style="margin-top: 15px; padding-top: 10px; border-top: 2px solid #dee2e6; text-align: center;">
                <strong style="color: #007bff;">Total: ${datosGrafica.total} citas analizadas</strong>
            </div>
        </div>
    `;
}

        document.addEventListener('DOMContentLoaded', function () {
            cargarReporteServicios();
            
            document.getElementById('filtroMes').addEventListener('change', cargarReporteServicios);
        });
    </script>

</body>
</html>