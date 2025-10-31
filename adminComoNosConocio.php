<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || !isset($_SESSION['es_admin']) || $_SESSION['es_admin'] !== true) {
    header('Location: iniciosesion.php');
    exit;
}

require_once 'include/database.php';
$conexion = conectarBD();

// Consulta para obtener datos de cómo nos conocieron
$sql_estadisticas = "
    SELECT 
        como_nos_conocio,
        COUNT(*) as total
    FROM usuarios 
    WHERE como_nos_conocio IS NOT NULL AND como_nos_conocio != ''
    GROUP BY como_nos_conocio
    ORDER BY total DESC
";

$resultado = $conexion->query($sql_estadisticas);
$datos_conocimiento = [];

if ($resultado) {
    $datos_conocimiento = $resultado->fetch_all(MYSQLI_ASSOC);
}

// Calcular totales
$total_con_datos = array_sum(array_column($datos_conocimiento, 'total'));
$sql_total_usuarios = "SELECT COUNT(*) as total FROM usuarios WHERE estado = 'activo'";
$result_total = $conexion->query($sql_total_usuarios);
$total_usuarios = $result_total->fetch_assoc()['total'];
$total_sin_especificar = $total_usuarios - $total_con_datos;

// Separar datos para las gráficas
$redes_sociales = [];
$otros_medios = [];

foreach ($datos_conocimiento as $dato) {
    $medio = $dato['como_nos_conocio'];
    if (in_array($medio, ['Facebook', 'Instagram', 'Twitter/X'])) {
        $redes_sociales[] = $dato;
    } else {
        $otros_medios[] = $dato;
    }
}

$nombre_admin = $_SESSION['nombre_usuario'] ?? 'Admin';
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <title>Panel Admin — ¿Cómo nos Conocieron?</title>
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
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <div>
                                    <h4 class="section-title">📊 ¿CÓMO NOS CONOCIERON?</h4>
                                    <p class="section-subtitle mb-0">Análisis de medios de descubrimiento</p>
                                </div>
                                <button class="btn btn-success" onclick="generarReportePDF()">
                                    <span class="fa fa-download mr-2"></span> Descargar PDF
                                </button>
                            </div>

                            <!-- Estadísticas Principales -->
                            <div class="row mb-4">
                                <div class="col-md-4">
                                    <div class="stat-card primary">
                                        <div class="stat-icon">👥</div>
                                        <div class="stat-info">
                                            <div class="stat-number"><?php echo $total_usuarios; ?></div>
                                            <div class="stat-label">Total Clientes</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="stat-card success">
                                        <div class="stat-icon">✅</div>
                                        <div class="stat-info">
                                            <div class="stat-number"><?php echo $total_con_datos; ?></div>
                                            <div class="stat-label">Con Datos Completos</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="stat-card warning">
                                        <div class="stat-icon">❓</div>
                                        <div class="stat-info">
                                            <div class="stat-number"><?php echo $total_sin_especificar; ?></div>
                                            <div class="stat-label">Sin Especificar</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <!-- Gráfica 1: Redes Sociales (Pastel) -->
                                <div class="col-md-6">
                                    <div class="reporte-seccion">
                                        <div class="seccion-header text-center">
                                            <h5>📱 REDES SOCIALES</h5>
                                        </div>
                                        <div class="grafica-container" style="height: 300px;">
                                            <canvas id="graficaRedesSociales"></canvas>
                                        </div>
                                        <div class="grafica-leyenda" id="leyendaRedesSociales">
                                            <?php if (empty($redes_sociales)): ?>
                                                <div class="text-center text-muted">No hay datos de redes sociales</div>
                                            <?php else: ?>
                                                <?php foreach ($redes_sociales as $red):
                                                    $porcentaje = $total_con_datos > 0 ? round(($red['total'] / $total_con_datos) * 100, 1) : 0;
                                                    $icono = $red['como_nos_conocio'] == 'Facebook' ? '🎯' :
                                                        ($red['como_nos_conocio'] == 'Instagram' ? '📷' : '🐦');
                                                    ?>
                                                    <div class="leyenda-item">
                                                        <span class="leyenda-color"
                                                            style="background-color: <?php echo obtenerColorRedSocial($red['como_nos_conocio']); ?>"></span>
                                                        <span class="leyenda-texto">
                                                            <strong><?php echo $icono . ' ' . $red['como_nos_conocio']; ?>:</strong>
                                                            <?php echo $red['total']; ?> clientes (<?php echo $porcentaje; ?>%)
                                                        </span>
                                                    </div>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>

                                <!-- Gráfica 2: Otros Medios (Barras) -->
                                <div class="col-md-6">
                                    <div class="reporte-seccion">
                                        <div class="seccion-header text-center">
                                            <h5>📰 OTROS MEDIOS</h5>
                                        </div>
                                        <div class="grafica-container" style="height: 300px;">
                                            <canvas id="graficaOtrosMedios"></canvas>
                                        </div>
                                        <div class="grafica-leyenda" id="leyendaOtrosMedios">
                                            <?php if (empty($otros_medios)): ?>
                                                <div class="text-center text-muted">No hay datos de otros medios</div>
                                            <?php else: ?>
                                                <?php foreach ($otros_medios as $medio):
                                                    $porcentaje = $total_con_datos > 0 ? round(($medio['total'] / $total_con_datos) * 100, 1) : 0;
                                                    $icono = $medio['como_nos_conocio'] == 'Volantes' ? '📄' :
                                                        ($medio['como_nos_conocio'] == 'Conocidos' ? '👥' :
                                                            ($medio['como_nos_conocio'] == 'Vio el local' ? '🏪' : '❓'));
                                                    ?>
                                                    <div class="leyenda-item">
                                                        <span class="leyenda-color"
                                                            style="background-color: <?php echo obtenerColorOtroMedio($medio['como_nos_conocio']); ?>"></span>
                                                        <span class="leyenda-texto">
                                                            <strong><?php echo $icono . ' ' . $medio['como_nos_conocio']; ?>:</strong>
                                                            <?php echo $medio['total']; ?> clientes
                                                            (<?php echo $porcentaje; ?>%)
                                                        </span>
                                                    </div>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Resumen General -->
                            <div class="row mt-4">
                                <div class="col-12">
                                    <div class="reporte-seccion">
                                        <div class="seccion-header">
                                            <h5>📈 RESUMEN GENERAL</h5>
                                        </div>
                                        <div class="row text-center">
                                            <div class="col-md-3">
                                                <div class="resumen-item">
                                                    <div class="resumen-valor" style="color: #1877f2;">
                                                        <?php echo array_sum(array_column($redes_sociales, 'total')); ?>
                                                    </div>
                                                    <div class="resumen-label">Por Redes Sociales</div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="resumen-item">
                                                    <div class="resumen-valor" style="color: #28a745;">
                                                        <?php echo array_sum(array_column($otros_medios, 'total')); ?>
                                                    </div>
                                                    <div class="resumen-label">Por Otros Medios</div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="resumen-item">
                                                    <div class="resumen-valor" style="color: #6c757d;">
                                                        <?php echo $total_sin_especificar; ?>
                                                    </div>
                                                    <div class="resumen-label">Sin Especificar</div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="resumen-item">
                                                    <div class="resumen-valor" style="color: #007bff;">
                                                        <?php echo $total_usuarios; ?>
                                                    </div>
                                                    <div class="resumen-label">Total Clientes</div>
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
        </div>
    </section>

    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // Datos para las gráficas
        const datosRedesSociales = <?php echo json_encode($redes_sociales); ?>;
        const datosOtrosMedios = <?php echo json_encode($otros_medios); ?>;
        const totalConDatos = <?php echo $total_con_datos; ?>;

        // Colores para las gráficas
        const coloresRedesSociales = {
            'Facebook': '#1877f2',
            'Instagram': '#e4405f',
            'Twitter/X': '#1da1f2'
        };

        const coloresOtrosMedios = {
            'Volantes': '#28a745',
            'Conocidos': '#ffc107',
            'Vio el local': '#fd7e14',
            'Otro': '#6f42c1'
        };

        // Inicializar gráficas cuando el documento esté listo
        document.addEventListener('DOMContentLoaded', function () {
            inicializarGraficaRedesSociales();
            inicializarGraficaOtrosMedios();
        });

        function inicializarGraficaRedesSociales() {
            if (datosRedesSociales.length === 0) return;

            const ctx = document.getElementById('graficaRedesSociales').getContext('2d');
            const labels = datosRedesSociales.map(item => item.como_nos_conocio);
            const data = datosRedesSociales.map(item => item.total);
            const backgroundColors = datosRedesSociales.map(item => coloresRedesSociales[item.como_nos_conocio]);

            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: labels,
                    datasets: [{
                        data: data,
                        backgroundColor: backgroundColors,
                        borderWidth: 3,
                        borderColor: '#fff',
                        hoverOffset: 15
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                padding: 20,
                                usePointStyle: true,
                                pointStyle: 'circle'
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function (context) {
                                    const label = context.label || '';
                                    const value = context.raw || 0;
                                    const percentage = totalConDatos > 0 ? Math.round((value / totalConDatos) * 100) : 0;
                                    return `${label}: ${value} clientes (${percentage}%)`;
                                }
                            }
                        }
                    },
                    cutout: '50%'
                }
            });
        }

        function inicializarGraficaOtrosMedios() {
            if (datosOtrosMedios.length === 0) return;

            const ctx = document.getElementById('graficaOtrosMedios').getContext('2d');
            const labels = datosOtrosMedios.map(item => item.como_nos_conocio);
            const data = datosOtrosMedios.map(item => item.total);
            const backgroundColors = datosOtrosMedios.map(item => coloresOtrosMedios[item.como_nos_conocio]);

            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: labels,
                    datasets: [{
                        data: data,
                        backgroundColor: backgroundColors,
                        borderWidth: 3,
                        borderColor: '#fff',
                        hoverOffset: 15
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                padding: 20,
                                usePointStyle: true,
                                pointStyle: 'circle'
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function (context) {
                                    const label = context.label || '';
                                    const value = context.raw || 0;
                                    const percentage = totalConDatos > 0 ? Math.round((value / totalConDatos) * 100) : 0;
                                    return `${label}: ${value} clientes (${percentage}%)`;
                                }
                            }
                        }
                    },
                    cutout: '50%'
                }
            });
        }

        function generarReportePDF() {
            const w = window.open("", "_blank");
            const fechaGeneracion = new Date().toLocaleString('es-ES');

            // Preparar datos - CORREGIDO
            const totalUsuarios = <?php echo $total_usuarios; ?>;
            const totalConDatos = <?php echo $total_con_datos; ?>;
            const totalSinEspecificar = <?php echo $total_sin_especificar; ?>;

            // El resto del código se mantiene igual...
            // Combinar todos los datos
            const todosLosDatos = [
                ...<?php echo json_encode($redes_sociales); ?>,
                ...<?php echo json_encode($otros_medios); ?>
            ];
            // Generar las barras IDÉNTICAS al ejemplo de tu amiga
            let seccionGrafica = '';
            if (todosLosDatos.length > 0) {
                const maxVal = Math.max(...todosLosDatos.map(item => item.total));

                seccionGrafica = `
            <div class="grafica-impresa">
                <h3 style="text-align: center; color: #007bff; margin: 20px 0;">📊 Distribución por Medios</h3>
                <div style="display: flex; justify-content: center; margin: 20px 0;">
                    <div style="display: flex; flex-wrap: wrap; gap: 20px; align-items: center;">
                        ${generarGraficaSimplificada(todosLosDatos, totalConDatos, maxVal)}
                        ${generarLeyendaImpresion(todosLosDatos, totalConDatos)}
                    </div>
                </div>
            </div>
        `;
            }

            w.document.write(`
        <!DOCTYPE html>
        <html>
        <head>
            <title>Reporte - ¿Cómo nos Conocieron?</title>
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
                .stat-pending { background: #6c757d; }
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
                /* Estilos para gráfica impresa - IDÉNTICOS al de tu amiga */
                .grafica-impresa {
                    margin: 30px 0;
                    padding: 20px;
                    border: 2px solid #e9ecef;
                    border-radius: 10px;
                    background: #f8f9fa;
                }
                .grafica-simplificada {
                    display: flex;
                    flex-direction: column;
                    align-items: center;
                    gap: 10px;
                }
                .barra-container {
                    display: flex;
                    align-items: center;
                    gap: 10px;
                    width: 300px;
                }
                .barra-label {
                    width: 120px;
                    font-weight: bold;
                    font-size: 14px;
                }
                .barra {
                    flex: 1;
                    height: 25px;
                    background: #e9ecef;
                    border-radius: 5px;
                    overflow: hidden;
                    position: relative;
                }
                .barra-fill {
                    height: 100%;
                    border-radius: 5px;
                    transition: width 0.3s ease;
                }
                .barra-valor {
                    position: absolute;
                    right: 8px;
                    top: 50%;
                    transform: translateY(-50%);
                    font-weight: bold;
                    font-size: 12px;
                    color: #333;
                    text-shadow: 1px 1px 1px white;
                }
                .leyenda-impresa {
                    display: flex;
                    flex-direction: column;
                    gap: 8px;
                    margin-left: 20px;
                }
                .item-leyenda {
                    display: flex;
                    align-items: center;
                    gap: 8px;
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
                    .grafica-impresa { margin: 20px 0; }
                }
                @page {
                    size: landscape;
                    margin: 10mm;
                }
            </style>
        </head>
        <body>
            <div class="header">
                <h1>REPORTE: ¿CÓMO NOS CONOCIERON?</h1>
                <div class="subtitle">Fecha: ${fechaGeneracion}</div>
                <div class="subtitle">Generado el: ${new Date().toLocaleString('es-ES')}</div>
            </div>

            <div class="stats-container">
                <div class="stat-card stat-total">
                    <span class="stat-number">${totalUsuarios}</span>
                    <span class="stat-label">TOTAL CLIENTES</span>
                </div>
                <div class="stat-card stat-completed">
                    <span class="stat-number">${totalConDatos}</span>
                    <span class="stat-label">CON DATOS</span>
                </div>
                <div class="stat-card stat-pending">
                    <span class="stat-number">${totalSinEspecificar}</span>
                    <span class="stat-label">SIN ESPECIFICAR</span>
                </div>
            </div>

            ${seccionGrafica}

            <!-- Tabla de datos -->
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Medio</th>
                            <th>Clientes</th>
                            <th>Porcentaje</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${generarFilasTabla(todosLosDatos, totalConDatos)}
                    </tbody>
                </table>
            </div>

            <div class="footer">
                Estética Canina - Sistema de Gestión de Clientes
            </div>
        </body>
        </html>
    `);

            w.document.close();

            setTimeout(() => {
                w.print();
            }, 500);
        }

        // Función para generar las barras (IDÉNTICA a la de tu amiga)
        function generarGraficaSimplificada(datos, totalConDatos, maxVal) {
            return `
        <div class="grafica-simplificada">
            ${datos.map((item, index) => {
                const porcentaje = totalConDatos > 0 ? Math.round((item.total / totalConDatos) * 100) : 0;
                const ancho = maxVal > 0 ? (item.total / maxVal) * 100 : 0;
                const color = item.como_nos_conocio in coloresRedesSociales ?
                    coloresRedesSociales[item.como_nos_conocio] :
                    coloresOtrosMedios[item.como_nos_conocio];

                return `
                    <div class="barra-container">
                        <div class="barra-label">${item.como_nos_conocio}</div>
                        <div class="barra">
                            <div class="barra-fill" style="width: ${ancho}%; background-color: ${color};"></div>
                            <div class="barra-valor">${item.total} (${porcentaje}%)</div>
                        </div>
                    </div>
                `;
            }).join('')}
        </div>
    `;
        }

        // Función para generar la leyenda (IDÉNTICA a la de tu amiga)
        function generarLeyendaImpresion(datos, totalConDatos) {
            return `
        <div class="leyenda-impresa">
            <h4 style="margin: 0 0 10px 0; color: #495057;">Resumen:</h4>
            ${datos.map((item, index) => {
                const porcentaje = totalConDatos > 0 ? Math.round((item.total / totalConDatos) * 100) : 0;
                const color = item.como_nos_conocio in coloresRedesSociales ?
                    coloresRedesSociales[item.como_nos_conocio] :
                    coloresOtrosMedios[item.como_nos_conocio];

                return `
                    <div class="item-leyenda">
                        <div class="color-leyenda" style="background-color: ${color}"></div>
                        <div style="font-size: 14px;">
                            <strong>${item.como_nos_conocio}:</strong> ${item.total} clientes (${porcentaje}%)
                        </div>
                    </div>
                `;
            }).join('')}
            <div style="margin-top: 10px; padding-top: 10px; border-top: 1px solid #dee2e6;">
                <strong>Total con datos: ${totalConDatos} clientes</strong>
            </div>
        </div>
    `;
        }

        // Función para generar las filas de la tabla
        function generarFilasTabla(datos, totalConDatos) {
            if (datos.length === 0) {
                return '<tr><td colspan="3" class="text-center">No hay datos disponibles</td></tr>';
            }

            return datos.map(item => {
                const porcentaje = totalConDatos > 0 ? Math.round((item.total / totalConDatos) * 100) : 0;
                return `
            <tr>
                <td>${item.como_nos_conocio}</td>
                <td>${item.total}</td>
                <td>${porcentaje}%</td>
            </tr>
        `;
            }).join('');
        }
    </script>

</body>

</html>

<?php
function obtenerColorRedSocial($redSocial)
{
    $colores = [
        'Facebook' => '#1877f2',
        'Instagram' => '#e4405f',
        'Twitter/X' => '#1da1f2'
    ];
    return $colores[$redSocial] ?? '#6c757d';
}

function obtenerColorOtroMedio($medio)
{
    $colores = [
        'Volantes' => '#28a745',
        'Conocidos' => '#ffc107',
        'Vio el local' => '#fd7e14',
        'Otro' => '#6f42c1'
    ];
    return $colores[$medio] ?? '#6c757d';
}
?>