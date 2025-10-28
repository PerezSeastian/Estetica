<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || !isset($_SESSION['es_admin']) || $_SESSION['es_admin'] !== true) {
    header('Location: iniciosesion.php');
    exit;
}

require_once 'include/database.php';
$conexion = conectarBD();

// LÓGICA INTELIGENTE PARA 2025
$dia_actual = date('d');
$mes_actual = date('m');
$ano_actual = date('Y'); // ¡ESTO SERÁ 2025!

echo "<!-- DEBUG: Fecha actual: " . date('Y-m-d') . " -->";
echo "<!-- DEBUG: Año actual: $ano_actual -->";

// Si estamos en los primeros 5 días del mes, mostramos hace 2 meses
// Si estamos después del día 5, mostramos el mes anterior
if ($dia_actual <= 5) {
    // Estamos a principios de mes → mostrar hace 2 meses
    $mes_buscar = date('Y-m', strtotime('-2 months'));
    $mes_nombre = date('F Y', strtotime('-2 months'));
    $explicacion = "Principio de mes - mostrando hace 2 meses";
} else {
    // Estamos a mediados/final de mes → mostrar mes anterior
    $mes_buscar = date('Y-m', strtotime('-1 month'));
    $mes_nombre = date('F Y', strtotime('-1 month'));
    $explicacion = "Mediados/fin de mes - mostrando mes anterior";
}

echo "<!-- DEBUG: Mes a buscar: $mes_buscar -->";
echo "<!-- DEBUG: Lógica: $explicacion -->";

// CONSULTA CON MES COMPLETADO
$sql_clientes_contactar = "
    SELECT DISTINCT
        u.id_usuario,
        u.nombre_completo,
        u.telefono,
        u.correo,
        m.nombre AS nombre_mascota,
        m.raza,
        MAX(a.fecha) AS ultima_visita,
        a.servicio
    FROM agenda a
    INNER JOIN usuarios u ON a.id_usuario = u.id_usuario
    INNER JOIN mascotas m ON a.id_mascota = m.id_mascota
    WHERE a.estado = 'Terminado'
        AND DATE_FORMAT(a.fecha, '%Y-%m') = '$mes_buscar'
        AND u.estado = 'activo'
    GROUP BY u.id_usuario
    ORDER BY ultima_visita DESC
";

$clientes_contactar = $conexion->query($sql_clientes_contactar);

if ($clientes_contactar) {
    $clientes_contactar = $clientes_contactar->fetch_all(MYSQLI_ASSOC);
    echo "<!-- DEBUG: Clientes encontrados: " . count($clientes_contactar) . " -->";
} else {
    echo "<!-- DEBUG: Error en la consulta: " . $conexion->error . " -->";
    $clientes_contactar = [];
}

$clientes_por_pagina = 4;
$pagina = isset($_GET['pagina']) ? (int) $_GET['pagina'] : 1;
$inicio = ($pagina - 1) * $clientes_por_pagina;
$clientes_pagina = array_slice($clientes_contactar, $inicio, $clientes_por_pagina);
$total_paginas = ceil(count($clientes_contactar) / $clientes_por_pagina);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <title>Reportes - Panel de Administración</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Mismos estilos que Admin.php -->
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
    <!-- Mismo header y navbar que Admin.php -->
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
                <span class="flaticon-pawprint-1 mr-2"></span> Panel del Admin
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
                    <li class="nav-item"><a href="adminCitas.php" class="nav-link">
                            <span class="fa fa-calendar mr-1"></span> Agenda
                        </a></li>
                    <li class="nav-item"><a href="adminHorarios.php" class="nav-link">
                            <span class="fa fa-clock-o mr-1"></span> Horarios
                        </a></li>
                    <li class="nav-item active"><a href="adminReportes.php" class="nav-link">
                            <span class="fa fa-bar-chart mr-1"></span> Reportes
                        </a></li>
                    <li class="nav-item"><a href="include/logout.php" class="nav-link">
                            <span class="fa fa-sign-out mr-1"></span> Cerrar Sesión
                        </a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Contenido Principal -->
    <section class="profile-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="profile-card">
                        <div class="profile-content">
                            <h4 class="section-title"><span class="fa fa-bar-chart mr-2"></span> Clientes para Contactar
                                - <?php echo $mes_nombre; ?></h4>

                            <div class="report-section">
                                <div class="section-header">
                                    <h5 class="report-title">
                                        <span class="fa fa-bell mr-2"></span>
                                        Clientes que visitaron en <?php echo $mes_nombre; ?>
                                        <span class="badge-count"><?php echo count($clientes_contactar); ?>
                                            clientes</span>
                                    </h5>
                                    <div class="header-info">
                                        <button class="btn-pdf" onclick="generarReportePDF()">
                                            <span class="fa fa-download mr-2"></span> Descargar PDF
                                        </button>
                                        <small class="info-mes">
                                            <span class="fa fa-info-circle mr-1"></span>
                                            <?php echo $explicacion; ?>
                                        </small>
                                    </div>
                                </div>

                                <?php if (count($clientes_contactar) > 0): ?>
                                    <!-- PAGINACIÓN INFO - AGREGA ESTO -->
                                    <div class="paginacion-info">
                                        Página <?php echo $pagina; ?> de <?php echo $total_paginas; ?>
                                        (<?php echo count($clientes_contactar); ?> clientes totales)
                                    </div>

                                    <div class="clientes-grid">
                                        <?php foreach ($clientes_pagina as $cliente): ?>
                                            <div class="cliente-card">
                                                <div class="cliente-header">
                                                    <h6><span class="fa fa-paw mr-2"></span>
                                                        <?php echo htmlspecialchars($cliente['nombre_mascota']); ?></h6>
                                                    <span class="fecha-visita"><span class="fa fa-calendar mr-1"></span>
                                                        <?php echo date('d/m/Y', strtotime($cliente['ultima_visita'])); ?></span>
                                                </div>
                                                <div class="cliente-info">
                                                    <p><span class="fa fa-user mr-2"></span> <strong>Dueño:</strong>
                                                        <?php echo htmlspecialchars($cliente['nombre_completo']); ?></p>
                                                    <p><span class="fa fa-phone mr-2"></span> <strong>Teléfono:</strong>
                                                        <?php echo htmlspecialchars($cliente['telefono']); ?></p>
                                                    <p><span class="fa fa-scissors mr-2"></span> <strong>Servicio:</strong>
                                                        <?php echo htmlspecialchars($cliente['servicio']); ?></p>
                                                    <p><span class="fa fa-paw mr-2"></span> <strong>Raza:</strong>
                                                        <?php echo htmlspecialchars($cliente['raza']); ?></p>
                                                </div>
                                                <div class="cliente-actions">
                                                    <button class="btn-action btn-whatsapp"
                                                        onclick="contactarWhatsApp('<?php echo $cliente['telefono']; ?>', '<?php echo $cliente['nombre_completo']; ?>', '<?php echo $cliente['nombre_mascota']; ?>')">
                                                        <span class="fa fa-whatsapp"></span> Contactar por WhatsApp
                                                    </button>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>

                                    <!-- PAGINACIÓN BOTONES - AGREGA ESTO -->
                                    <?php if ($total_paginas > 1): ?>
                                        <div class="paginacion-botones">
                                            <?php if ($pagina > 1): ?>
                                                <a href="?pagina=<?php echo $pagina - 1; ?>" class="btn-pagina">
                                                    <span class="fa fa-chevron-left"></span> Anterior
                                                </a>
                                            <?php endif; ?>

                                            <?php if ($pagina < $total_paginas): ?>
                                                <a href="?pagina=<?php echo $pagina + 1; ?>" class="btn-pagina">
                                                    Siguiente <span class="fa fa-chevron-right"></span>
                                                </a>
                                            <?php endif; ?>
                                        </div>
                                    <?php endif; ?>

                                <?php else: ?>
                                    <!-- [MANTÉN EL "NO HAY CLIENTES" ORIGINAL] -->
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        function contactarWhatsApp(telefono, nombre, mascota) {
            const mensaje = `Hola ${nombre}!\n\nTe contactamos de Estética Canina.\n\n¿Te gustaría agendar una nueva cita para ${mascota}?\n\n¡Estaremos encantados de atenderlos nuevamente! 🐶`;
            const url = `https://wa.me/${telefono}?text=${encodeURIComponent(mensaje)}`;
            window.open(url, '_blank');
        }

        function generarReportePDF() {
            window.print();
        }
    </script>
</body>

</html>