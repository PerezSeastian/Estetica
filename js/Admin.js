// Vista inicial del dmin //
document.querySelector('.search-box input').addEventListener('input', function () {
    const busqueda = this.value.toLowerCase();
    document.querySelectorAll('.user-card-pro').forEach(tarjeta => {
        const texto = tarjeta.textContent.toLowerCase();
        tarjeta.style.display = texto.includes(busqueda) ? 'block' : 'none';
    });
});

function eliminarUsuario(id_usuario, nombre) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: `Vas a eliminar a ${nombre} y todas sus mascotas`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#1269bbff',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            const boton = event.target;
            boton.innerHTML = '<span class="fa fa-spinner fa-spin"></span> Eliminando...';
            boton.disabled = true;

            $.ajax({
                url: 'include/eliminar_usuario.php',
                type: 'POST',
                data: { id_usuario: id_usuario },
                dataType: 'json',
                success: function (data) {
                    if (data.success) {
                        Swal.fire({
                            title: '¡Eliminado!',
                            text: data.message,
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                location.reload(); // ← ESTA LÍNEA FALTA
                            }
                        });
                    } else {
                        Swal.fire('Error', data.message, 'error');
                        boton.innerHTML = '<span class="fa fa-trash"></span> Eliminar';
                        boton.disabled = false;
                    }
                },
                error: function () {
                    Swal.fire('Error', 'Error de conexión', 'error');
                    boton.innerHTML = '<span class="fa fa-trash"></span> Eliminar';
                    boton.disabled = false;
                }
            });
        }
    });
}

function cargarUsuario(id_usuario) {
    $.ajax({
        url: 'include/obtenerusuario.php',
        type: 'POST',
        data: { id_usuario: id_usuario },
        dataType: 'json',
        success: function (data) {
            if (data.success) {
                // Llenar el modal con datos reales
                $('#userModal .modal-title').text('Información de ' + data.usuario.nombre_completo);
                $('#userModal .modal-body').html(`
                    <h6>Datos Personales</h6>
                    <p><strong>Nombre:</strong> ${data.usuario.nombre_completo}</p>
                    <p><strong>Email:</strong> ${data.usuario.correo}</p>
                    <p><strong>Teléfono:</strong> ${data.usuario.telefono}</p>
                    <p><strong>Dirección:</strong> ${data.usuario.direccion}</p>
                    <hr>
                    <h6>Mascotas</h6>
                    ${data.mascotas.length > 0 ?
                        data.mascotas.map(mascota => `
                            <div class="pet-card">
                                <div class="pet-photo">
                                    ${mascota.foto ?
                                `<img src="uploads/mascotas/${mascota.foto}" alt="${mascota.nombre}" class="pet-image">` :
                                `<div class="no-photo"><span class="fa fa-paw"></span></div>`
                            }
                                </div>
                                <div class="pet-info">
                                    <h6>${mascota.nombre}</h6>
                                    <p><strong>Especie:</strong> ${mascota.especie}</p>
                                    <p><strong>Raza:</strong> ${mascota.raza || 'No especificada'}</p>
                                    <p><strong>Edad:</strong> ${mascota.edad || 'No especificada'}</p>
                                </div>
                            </div>
                        `).join('') :
                        '<p>No tiene mascotas registradas</p>'
                    }
                `);
                $('#userModal').modal('show');
            } else {
                Swal.fire('Error', data.message, 'error');
            }
        },
        error: function () {
            Swal.fire('Error', 'Error al cargar los datos', 'error');
        }
    });
}