<?php
session_start();
$loggedin = isset($_SESSION['loggedin']) && $_SESSION['loggedin'];
$nombre_usuario = $loggedin ? $_SESSION['nombre_usuario'] : '';
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <title>Estética Canina</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <link href="https://fonts.googleapis.com/css?family=Montserrat:200,300,400,500,600,700,800&display=swap"
    rel="stylesheet">

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">


  <link rel="stylesheet" href="css/animate.css">

  <link rel="stylesheet" href="css/owl.carousel.min.css">
  <link rel="stylesheet" href="css/owl.theme.default.min.css">
  <link rel="stylesheet" href="css/magnific-popup.css">


  <link rel="stylesheet" href="css/bootstrap-datepicker.css">
  <link rel="stylesheet" href="css/jquery.timepicker.css">

  <link rel="stylesheet" href="css/flaticon.css">
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="Estilos/style.css">

  <!-- Flatpickr CSS base -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

  <!-- Puedes usar un tema y luego personalizar -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/themes/material_blue.css">

</head>

<body>

  <div class="wrap">
    <div class="container">
      <div class="row">
        <div class="col-md-6 d-flex align-items-center">
          <p class="mb-0 phone pl-md-2">
            <a href="#" class="mr-2"><span class="fa fa-phone mr-1"></span> Telefono a poner</a>
            <a href="#"><span class="fa fa-paper-plane mr-1"></span> Correo a poner</a>
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
              <a href="#" class="d-flex align-items-center justify-content-center"><span class="fa fa-dribbble"><i
                    class="sr-only">Dribbble</i></span></a>
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
  <nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
    <div class="container">
      <a class="navbar-brand" href="index.html"><span class="flaticon-pawprint-1 mr-2"></span>Estética Canina</a>
      <div class="collapse navbar-collapse" id="ftco-nav">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item"><a href="index.html" class="nav-link">Inicio</a></li>

          <?php if ($loggedin): ?>
            <!-- Usuario LOGUEADO -->
            <li class="nav-item"><a href="perfil.php" class="nav-link">Perfil</a></li>
            <li class="nav-item active"><a href="agenda.php" class="nav-link">Agenda</a></li>
            <li class="nav-item">
              <a href="include/logout.php" class="nav-link">
                <i class="fa fa-sign-out mr-1"></i>Cerrar Sesión (<?php echo $nombre_usuario; ?>)
              </a>
            </li>
          <?php else: ?>
            <!-- Usuario NO logueado -->
            <li class="nav-item"><a href="#" class="nav-link">Acerca de</a></li>
            <li class="nav-item"><a href="iniciosesion.html" class="nav-link">Iniciar sesión</a></li>
          <?php endif; ?>
        </ul>
      </div>
    </div>
  </nav>

  <section class="ftco-section ftco-register" style="background-image: url(images/bg_3.jpg);">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
          <div class="card shadow-lg rounded-lg p-4 ftco-animate" style="background: #fff;">
            <div class="text-center mb-4">
              <div class="bg-light rounded-circle d-inline-flex justify-content-center align-items-center"
                style="width: 80px; height: 80px;">
                <span class="fa fa-calendar-check fa-3x text-primary"></span>
              </div>
              <h3 class="mt-3">Agendar Cita</h3>
              <p class="text-muted">Completa los siguientes datos para reservar una cita para tu mascota 🐾</p>
            </div>

            <div id="formularios">
              <form action="#" method="POST" class="appointment petForm">
                <!-- Fecha -->
                <div class="form-group d-flex align-items-center border rounded mb-3 px-3 py-2 date-select">
                  <span class="fa fa-calendar text-success mr-3"></span>
                  <input type="text" id="fecha" class="form-control border-0 shadow-none" name="fecha"
                    placeholder="Selecciona una fecha" required>
                </div>

                <!-- Hora -->
                <div class="form-group d-flex align-items-center border rounded mb-3 px-2 ">
                  <span class="fa fa-clock mr-2"></span>
                  <select class="form-control border-0" name="hora" required id="horaSelect">
                    <option value="">Selecciona un horario</option>
                  </select>

                </div>

                <!-- Sucursal -->
                <div class="form-group d-flex align-items-center border rounded mb-3 px-2">
                  <span class="fa fa-store mr-2"></span>
                  <select class="form-control border-0" name="sucursal" required>
                    <option value="">Selecciona una sucursal</option>
                    <option value="sucursal1">Sucursal 1</option>
                    <option value="sucursal2">Sucursal 2</option>
                    <option value="sucursal3">Sucursal 3</option>
                  </select>
                </div>

                <!-- Mascota -->
                <div class="form-group d-flex align-items-center border rounded mb-3 px-2">
                  <span class="fa fa-dog mr-2"></span>
                  <select class="form-control border-0" name="mascota" required>
                    <option value="">Selecciona tu mascota</option>
                  </select>
                </div>

                <!-- Servicio -->
                <div class="form-group d-flex align-items-center border rounded mb-3 px-2">
                  <span class="fa fa-cut mr-2"></span>
                  <select class="form-control border-0" name="servicio" required>
                    <option value="">Selecciona un servicio</option>
                    <option value="baño">Baño</option>
                    <option value="corte">Corte de pelo</option>
                    <option value="spa">Spa</option>
                    <option value="guarderia">Guardería</option>
                    <option value="hotel">Hotel</option>
                    <option value="consulta">Consulta veterinaria</option>
                  </select>
                </div>
                <!-- Taxi Perruno -->
                <div class="form-group d-flex align-items-center border rounded mb-3 px-2">
                  <span class="fa fa-taxi mr-2"></span>
                  <select class="form-control border-0" name="taxi_perruno" required>
                    <option value="">¿Deseas taxi perruno?</option>
                    <option value="Sí">Sí</option>
                    <option value="No">No</option>
                  </select>
                </div>


                <!-- Botón -->
                <div class="form-group">
                  <input type="submit" value="Agendar Cita" class="btn btn-primary btn-block py-2">
                </div>
              </form>

            </div>
          </div>
        </div>
      </div>
    </div>
  </section>



  <!--Pie de pagina-->

  <footer class="footer">
    <div class="container">
      <div class="row mt-5">
        <div class="col-md-12 text-center">
          <p class="copyright">
            <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
            Copyright &copy;
            <script>document.write(new Date().getFullYear());</script> All rights reserved | This template
            is made with <i class="fa fa-heart" aria-hidden="true"></i> by <a href="https://colorlib.com"
              target="_blank">Colorlib.com</a>
            <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
          </p>
        </div>
      </div>
    </div>
  </footer>


  <script src="js/jquery.min.js"></script>
  <script src="js/jquery-migrate-3.0.1.min.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/jquery.easing.1.3.js"></script>
  <script src="js/jquery.waypoints.min.js"></script>
  <script src="js/jquery.stellar.min.js"></script>
  <script src="js/jquery.animateNumber.min.js"></script>
  <script src="js/bootstrap-datepicker.js"></script>
  <script src="js/jquery.timepicker.min.js"></script>
  <script src="js/owl.carousel.min.js"></script>
  <script src="js/jquery.magnific-popup.min.js"></script>
  <script src="js/scrollax.min.js"></script>
  <script
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBVWaKrjvy3MaE7SQ74_uJiULgl1JY0H2s&sensor=false"></script>
  <script src="js/google-map.js"></script>
  <script src="js/main.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
  <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/es.js"></script>

  <script>
    flatpickr("#fecha", {
      dateFormat: "d/m/Y",
      minDate: "today",
      locale: "es",      // idioma español

    });
  </script>

  <script>
    document.querySelector("form.appointment").addEventListener("submit", function (e) {
      const fecha = document.getElementById("fecha").value.trim();

      if (!fecha) {
        e.preventDefault();
        Swal.fire({
          icon: 'warning',
          title: 'Campo obligatorio',
          text: 'Por favor selecciona una fecha para la cita.',
          confirmButtonColor: '#28a745'
        });
      }
    });
  </script>
  <script>
    document.addEventListener("DOMContentLoaded", function () {
      fetch("include/ObtenerMascotas.php")
        .then(res => res.json())
        .then(data => {
          let selectMascota = document.querySelector("select[name='mascota']");
          selectMascota.innerHTML = '<option value="">Selecciona tu mascota</option>';
          if (data.length > 0) {
            data.forEach(m => {
              selectMascota.innerHTML += `<option value="${m.id_mascota}">${m.nombre}</option>`;
            });
          } else {
            selectMascota.innerHTML += `<option value="">No tienes mascotas registradas</option>`;
          }
        });
    });
    // guardar cita
    document.querySelector("form.appointment").addEventListener("submit", function (e) {
      e.preventDefault();
      let formData = new FormData(this);

      Swal.fire({
        title: 'Agendando...',
        text: 'Por favor espera 🐾',
        icon: 'info',
        allowOutsideClick: false,
        showConfirmButton: false,
        didOpen: () => Swal.showLoading()
      });

      fetch("include/RegistroCita.php", { method: "POST", body: formData })
        .then(res => res.json())
        .then(data => {
          Swal.close();
          if (data.success) {
            Swal.fire({
              icon: 'success',
              title: '¡Cita agendada!',
              text: data.message,
              showDenyButton: true,
              confirmButtonText: 'Agendar otra mascota',
              denyButtonText: 'Finalizar'
            }).then(result => {
              if (result.isConfirmed) {
                const form = document.querySelector("form.appointment");
                form.querySelector("select[name='mascota']").value = "";

                Swal.fire({
                  icon: 'info',
                  title: 'Selecciona otra mascota 🐾',
                  text: 'Los demás datos se mantuvieron iguales',
                  confirmButtonText: 'OK'
                });
              } else {
                window.location.href = "index.php";
              }
            });
          } else {
            Swal.fire('Error', data.message, 'error');
          }
        })
        .catch(() => {
          Swal.close();
          Swal.fire('Error', 'No se pudo conectar con el servidor', 'error');
        });
    });

    document.addEventListener("DOMContentLoaded", function () {
      const fechaInput = document.getElementById("fecha");
      const horaSelect = document.getElementById("horaSelect");

      function cargarHorarios() {
        const fecha = fechaInput.value;
        if (!fecha) return;

        fetch(`include/ObtenerHorariosDisponibles.php?fecha=${fecha}`)
          .then(res => res.json())
          .then(data => {
            horaSelect.innerHTML = '<option value="">Selecciona un horario</option>';
            if (data.length === 0) {
              horaSelect.innerHTML += `<option value="">No hay horarios disponibles</option>`;
              return;
            }

            data.forEach(h => {
              const label = `${h.inicio} - ${h.fin}`;
              const option = document.createElement("option");
              option.value = `${h.inicio}-${h.fin}`;
              option.textContent = h.disponible ? label : `${label} (No disponible)`;
              if (!h.disponible) option.disabled = true;
              horaSelect.appendChild(option);
            });
          })
          .catch(err => {
            console.error(err);
            horaSelect.innerHTML = '<option value="">Error al cargar horarios</option>';
          });
      }

      fechaInput.addEventListener("change", cargarHorarios);
    });

  </script>

</body>

</html>