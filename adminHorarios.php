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

    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,600,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="Estilos/style.css">
    <link rel="stylesheet" href="Estilos/EstilosAdmin.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="admin-profesional">

    <nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light">
        <div class="container">
            <a class="navbar-brand" href="Admin.php">
                <span class="flaticon-pawprint-1 mr-2"></span> Estética Canina - Admin
            </a>
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
                    <h4 class="section-title">⏰ Control de Horarios</h4>
                    <p class="text-muted mb-4">Define los horarios de apertura, cierre e intervalos de atención. 🐾</p>

                    <div class="users-grid">
                        <div class="user-card-pro" data-sucursal="1">
                            <div class="user-main">
                                <h5>Sucursal 1</h5>
                                <div class="user-contact"><span class="fa fa-map-marker"></span> Centro</div>
                            </div>

                            <div class="user-meta">
                                <label>Hora de apertura:</label>
                                <input type="time" id="apertura1" class="form-control mb-2">

                                <label>Hora de cierre:</label>
                                <input type="time" id="cierre1" class="form-control mb-2">
                            </div>

                            <h6 class="mt-3">🕒 Intervalos de atención</h6>
                            <div class="intervalos-lista" id="intervalos1"></div>

                            <button class="btn btn-sm btn-success mt-2 agregar" data-target="#intervalos1">
                                <i class="fa fa-plus"></i> Agregar intervalo
                            </button>

                            <div class="user-actions-pro mt-3 text-center">
                                <button class="btn-guardar btn-save-pro" onclick="guardarHorarios(1)">
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
function cargarHorarios(idSucursal) {
    fetch(`include/ObtenerHorarios.php?sucursal=${idSucursal}`)
        .then(res => res.json())
        .then(data => {
            if (!data) return;

            document.getElementById(`apertura${idSucursal}`).value = data.hora_apertura || "";
            document.getElementById(`cierre${idSucursal}`).value = data.hora_cierre || "";

            const contenedor = document.getElementById(`intervalos${idSucursal}`);
            contenedor.innerHTML = "";

            if (Array.isArray(data.intervalos)) {
                data.intervalos.forEach(int => {
                    const div = document.createElement("div");
                    div.className = "intervalo-item mt-2";
                    div.innerHTML = `
                        <input type="time" value="${int.inicio}" class="form-control d-inline w-25"> -
                        <input type="time" value="${int.fin}" class="form-control d-inline w-25">
                        <button class="btn btn-sm btn-danger ml-2 eliminar"><i class="fa fa-trash"></i></button>`;
                    contenedor.appendChild(div);
                });
            }
        });
}

// Agregar un nuevo intervalo manualmente
document.querySelectorAll('.agregar').forEach(btn => {
    btn.addEventListener('click', function () {
        const target = document.querySelector(this.dataset.target);
        const nuevo = document.createElement('div');
        nuevo.className = 'intervalo-item mt-2';
        nuevo.innerHTML = `
            <input type="time" class="form-control d-inline w-25"> -
            <input type="time" class="form-control d-inline w-25">
            <button class="btn btn-sm btn-danger ml-2 eliminar"><i class="fa fa-trash"></i></button>`;
        target.appendChild(nuevo);
    });
});


document.addEventListener('click', e => {
    if (e.target.closest('.eliminar')) {
        e.target.closest('.intervalo-item').remove();
    }
});

function guardarHorarios(idSucursal) {
    const horaApertura = document.getElementById(`apertura${idSucursal}`).value;
    const horaCierre = document.getElementById(`cierre${idSucursal}`).value;

    const intervalos = [];
    document.querySelectorAll(`#intervalos${idSucursal} .intervalo-item`).forEach(div => {
        const [inicio, fin] = div.querySelectorAll("input[type='time']");
        if (inicio.value && fin.value) {
            intervalos.push({ inicio: inicio.value, fin: fin.value });
        }
    });

    fetch("include/GuardarHorarios.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({
            sucursal: idSucursal,
            apertura: horaApertura,
            cierre: horaCierre,
            intervalos: intervalos
        })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            Swal.fire('Guardado', 'Los horarios fueron actualizados correctamente', 'success');
        } else {
            Swal.fire('Error', data.message, 'error');
        }
    })
    .catch(() => Swal.fire('Error', 'No se pudo conectar con el servidor.', 'error'));
}


document.addEventListener("DOMContentLoaded", () => {
    cargarHorarios(1);
});
</script>

</body>
</html>
