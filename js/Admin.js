// Vista inicial del dmin //
document.querySelector('.search-box input').addEventListener('input', function () {
    const busqueda = this.value.toLowerCase();
    document.querySelectorAll('.user-card-pro').forEach(tarjeta => {
        const texto = tarjeta.textContent.toLowerCase();
        tarjeta.style.display = texto.includes(busqueda) ? 'block' : 'none';
    });
});

function cambiarEstadoRapido() {
    const estadoElement = document.getElementById('modalEstado');
    const userId = estadoElement.getAttribute('data-user-id');
    const estadoActual = estadoElement.getAttribute('data-current-state');
    const nombre = document.getElementById('modalNombre').textContent;

    cambiarEstadoUsuario(userId, estadoActual, nombre);
}

// Función para cambiar estado de USUARIO - ESTA FALTA
function cambiarEstadoUsuario(id, estadoActual, nombre) {
    const nuevoEstado = estadoActual === 'activo' ? 'inactivo' : 'activo';
    const accion = nuevoEstado === 'activo' ? 'activar' : 'inactivar';

    Swal.fire({
        title: `¿${accion.toUpperCase()} usuario?`,
        html: `¿Estás seguro de querer <strong>${accion}</strong> a <strong>${nombre}</strong>?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: `Sí, ${accion}`,
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch('include/cambiar_estado_usuario.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    id_usuario: id,
                    estado: nuevoEstado
                })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire('¡Éxito!', `Usuario ${accion}do correctamente`, 'success').then(() => {
                            $('#userModal').modal('hide');
                            location.reload();
                        });
                    } else {
                        Swal.fire('Error', data.message, 'error');
                    }
                })
                .catch(error => {
                    Swal.fire('Error', 'Error de conexión', 'error');
                });
        }
    });
}

function cargarUsuario(id) {
    fetch(`include/obtener_usuario_admin.php?id=${id}`)
        .then(response => response.json())
        .then(usuario => {

            document.getElementById('modalNombre').textContent = usuario.nombre_completo;
            document.getElementById('modalEmail').textContent = usuario.correo;
            document.getElementById('modalTelefono').textContent = usuario.telefono;
            document.getElementById('modalDireccion').textContent = usuario.direccion;

            const estadoElement = document.getElementById('modalEstado');
            estadoElement.textContent = usuario.estado === 'activo' ? '✅ Activo' : '⏸️ Inactivo';
            estadoElement.className = usuario.estado === 'activo' ? 'user-status status-active' : 'user-status status-inactive';

            estadoElement.setAttribute('data-user-id', usuario.id_usuario);
            estadoElement.setAttribute('data-current-state', usuario.estado);
            cargarMascotasEnModal(usuario.mascotas);

            $('#userModal').modal('show');
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire('Error', 'No se pudo cargar el usuario', 'error');
        });
}

function agregarEventListenersMascotas() {
    document.querySelectorAll('.estado-mascota-select').forEach(select => {
        select.addEventListener('change', function () {
            const mascotaId = this.getAttribute('data-mascota-id');
            const nuevoEstado = this.value;
            const nombreMascota = this.closest('.pet-card-modal').querySelector('h6').textContent;

            cambiarEstadoMascota(mascotaId, nuevoEstado, nombreMascota);
        });
    });
}


function cambiarEstadoMascota(mascotaId, nuevoEstado, nombreMascota) {
    console.log('🔄 Cambiando estado de mascota:', mascotaId, nuevoEstado, nombreMascota);

    const estadosQueRequierenConfirmacion = ['fallecido', 'abandono_estetica', 'abandonado'];

    if (estadosQueRequierenConfirmacion.includes(nuevoEstado)) {
        const mensajes = {
            'fallecido': `¿Confirmas que <strong>${nombreMascota}</strong> ha fallecido?`,
            'abandono_estetica': `¿Confirmas que <strong>${nombreMascota}</strong> abandonó la estética?`,
            'abandonado': `¿Confirmas que <strong>${nombreMascota}</strong> fue abandonado por su dueño?`
        };

        Swal.fire({
            title: 'Confirmar cambio de estado',
            html: mensajes[nuevoEstado],
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, confirmar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                enviarCambioEstadoMascota(mascotaId, nuevoEstado, nombreMascota);
            } else {
                const select = document.querySelector(`[data-mascota-id="${mascotaId}"]`);
                location.reload();
            }
        });
    } else {
        enviarCambioEstadoMascota(mascotaId, nuevoEstado, nombreMascota);
    }
}


function enviarCambioEstadoMascota(mascotaId, nuevoEstado, nombreMascota) {
    fetch('include/cambiar_estado_mascota.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
            id_mascota: mascotaId,
            estado: nuevoEstado
        })
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Swal.fire({
                    title: '¡Estado actualizado!',
                    html: `El estado de <strong>${nombreMascota}</strong> se actualizó correctamente`,
                    icon: 'success',
                    timer: 2000,
                    showConfirmButton: false
                });
            } else {
                Swal.fire('Error', data.message, 'error');
                location.reload();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire('Error', 'Error de conexión', 'error');
            location.reload();
        });
}

function cargarMascotasEnModal(mascotas) {
    const contenedorMascotas = document.getElementById('modalMascotas');

    if (!mascotas || mascotas.length === 0) {
        contenedorMascotas.innerHTML = '<p class="text-muted">Este usuario no tiene mascotas registradas.</p>';
        return;
    }

    let htmlMascotas = '';

    mascotas.forEach(mascota => {
        const foto = mascota.foto
            ? `<img src="uploads/mascotas/${mascota.foto}" alt="${mascota.nombre}" class="pet-image-modal">`
            : `<div class="no-photo-modal"><span class="fa fa-paw"></span></div>`;

        htmlMascotas += `
            <div class="pet-card-modal" data-mascota-id="${mascota.id_mascota}">
                <div class="pet-photo-modal">
                    ${foto}
                </div>
                <div class="pet-info-modal">
                    <h6>${mascota.nombre}</h6>
                    <p><strong>Especie:</strong> ${mascota.especie}</p>
                    <p><strong>Raza:</strong> ${mascota.raza || 'No especificada'}</p>
                    <p><strong>Edad:</strong> ${mascota.edad || 'No especificada'}</p>
                    <div class="pet-status-control">
                        <small><strong>Estado:</strong></small>
                        <select class="form-control form-control-sm estado-mascota-select" 
                                data-mascota-id="${mascota.id_mascota}">
                            <option value="activo" ${mascota.estado === 'activo' ? 'selected' : ''}>
                                ✅ Activo - Viene regularmente
                            </option>
                            <option value="fallecido" ${mascota.estado === 'fallecido' ? 'selected' : ''}>
                                💀 Fallecido
                            </option>
                            <option value="cambio_peluqueria" ${mascota.estado === 'cambio_peluqueria' ? 'selected' : ''}>
                                ✂️ Cambió de peluquería
                            </option>
                            <option value="cambio_casa" ${mascota.estado === 'cambio_casa' ? 'selected' : ''}>
                                🏠 Cambió de casa
                            </option>
                            <option value="cambio_ciudad" ${mascota.estado === 'cambio_ciudad' ? 'selected' : ''}>
                                🏙️ Cambió de ciudad
                            </option>
                            <option value="abandono_estetica" ${mascota.estado === 'abandono_estetica' ? 'selected' : ''}>
                                🚪 Abandonó la estética
                            </option>
                            <option value="abandonado" ${mascota.estado === 'abandonado' ? 'selected' : ''}>
                                😢 Abandonado por dueño
                            </option>
                        </select>
                    </div>
                </div>
            </div>
        `;
    });

    contenedorMascotas.innerHTML = htmlMascotas;

    agregarEventListenersMascotas();
}
