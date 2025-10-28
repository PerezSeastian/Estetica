function saveProfile() {
    const nombre = document.getElementById('editName').value;
    const email = document.getElementById('editEmail').value;
    const telefono = document.getElementById('editPhone').value;
    const direccion = document.getElementById('editAddress').value;

    if (!nombre || !email) {
        alert('Completa nombre y email.');
        return false;
    }

    Swal.fire({
        title: 'Guardando...',
        text: 'Actualizando perfil 🐾',
        icon: 'info',
        allowOutsideClick: false,
        showConfirmButton: false,
        didOpen: () => Swal.showLoading()
    });

    $.ajax({
        url: 'include/guardar_perfil.php',
        type: 'POST',
        data: { nombre, email, telefono, direccion },
        dataType: 'json',
        success: (response) => {
            Swal.close();
            if (response.success) {
                document.getElementById('userName').textContent = nombre;
                document.getElementById('userEmail').textContent = email;
                document.getElementById('userPhone').textContent = telefono;
                document.getElementById('userAddress').textContent = direccion;
                $('#editProfileModal').modal('hide');
                Swal.fire('¡Perfecto!', response.message + ' 🐾', 'success');
            } else {
                Swal.fire('Error', response.message, 'error');
            }
        },
        error: () => {
            Swal.close();
            Swal.fire('Error', 'Error de conexión', 'error');
        }
    });

    return false;
}

function showAddPetModal() {
    document.getElementById('petModalTitle').textContent = 'Agregar Mascota';
    document.getElementById('petForm').reset();
    document.getElementById('editPetId').value = '';
    const preview = document.getElementById('previewImage');
    const noPhotoText = document.getElementById('noPhotoText');
    if (preview) preview.style.display = 'none';
    if (noPhotoText) noPhotoText.style.display = 'block';
}

function editPet(id) {
    fetch(`include/obtener_mascota.php?id=${id}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const mascota = data.mascota;

                document.getElementById('editPetId').value = mascota.id_mascota;
                document.getElementById('petName').value = mascota.nombre;
                document.getElementById('petSpecies').value = mascota.especie;
                document.getElementById('petBreed').value = mascota.raza;
                document.getElementById('petAge').value = mascota.edad;

                const preview = document.getElementById('previewImage');
                const noPhotoText = document.getElementById('noPhotoText');

                if (mascota.foto) {
                    preview.src = '../uploads/mascotas/' + mascota.foto;
                    preview.style.display = 'block';
                    noPhotoText.style.display = 'none';
                } else {
                    preview.style.display = 'none';
                    noPhotoText.style.display = 'block';
                }

                document.getElementById('petModalTitle').textContent = 'Editar Mascota';
                $('#petModal').modal('show');
            } else {
                Swal.fire('Error', data.message, 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire('Error', 'Error al cargar los datos', 'error');
        });
}

function showDeleteConfirm(id) {
    document.getElementById('deletePetIndex').value = id;
    $('#deleteConfirmModal').modal('show');
}

function confirmDeletePet() {
    const id_mascota = document.getElementById('deletePetIndex').value;

    Swal.fire({
        title: '¿Estás seguro?',
        text: "¡Esta acción no se puede deshacer!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: 'Eliminando...',
                text: 'Eliminando mascota 🐾',
                icon: 'info',
                allowOutsideClick: false,
                showConfirmButton: false,
                didOpen: () => Swal.showLoading()
            });

            $.ajax({
                url: 'include/eliminar_mascota.php',
                type: 'POST',
                data: {
                    id_mascota: id_mascota
                },
                dataType: 'json',
                success: function (response) {
                    Swal.close();

                    if (response.success) {
                        $('#deleteConfirmModal').modal('hide');
                        Swal.fire({
                            title: '¡Eliminado!',
                            text: response.message,
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            title: 'Error',
                            text: response.message,
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                },
                error: function () {
                    Swal.close();
                    Swal.fire({
                        title: 'Error',
                        text: 'Error de conexión',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            });
        }
    });
}

function savePet() {
    const nombre = document.getElementById('petName').value;
    const especie = document.getElementById('petSpecies').value;
    const foto = document.getElementById('petPhoto').files[0];
    const editId = document.getElementById('editPetId').value;

    if (!foto) {
        alert('Debes seleccionar una foto de la mascota');
        return false;
    }
    const formData = new FormData();
    formData.append('nombre', nombre);
    formData.append('especie', especie);
    formData.append('raza', document.getElementById('petBreed').value);
    formData.append('edad', document.getElementById('petAge').value);
    formData.append('editId', editId);
    formData.append('foto', foto);

    Swal.fire({
        title: editId ? 'Actualizando...' : 'Guardando...',
        text: editId ? 'Actualizando mascota 🐾' : 'Registrando mascota 🐾',
        icon: 'info',
        allowOutsideClick: false,
        showConfirmButton: false,
        didOpen: () => Swal.showLoading()
    });

    $.ajax({
        url: 'include/guardar_mascota.php',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json',
        success: (response) => {
            Swal.close();
            if (response.success) {
                $('#petModal').modal('hide');
                const mensaje = editId ? 'Mascota actualizada! 🐶' : 'Mascota registrada! 🐶';
                Swal.fire('¡Éxito!', mensaje, 'success').then(() => location.reload());
            } else {
                Swal.fire('Error', response.message, 'error');
            }
        },
        error: () => {
            Swal.close();
            Swal.fire('Error', 'Error de conexión', 'error');
        }
    });

    return false;
}

document.addEventListener('DOMContentLoaded', () => {
    const petPhotoInput = document.getElementById('petPhoto');
    if (petPhotoInput) {
        petPhotoInput.addEventListener('change', (e) => {
            const file = e.target.files[0];
            const preview = document.getElementById('previewImage');
            const noPhotoText = document.getElementById('noPhotoText');

            if (file) {
                if (file.size > 2 * 1024 * 1024) {
                    alert('Imagen muy grande. Máximo 2MB.');
                    this.value = '';
                    return;
                }
                const reader = new FileReader();
                reader.onload = (e) => {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                    if (noPhotoText) noPhotoText.style.display = 'none';
                }
                reader.readAsDataURL(file);
            } else {
                if (preview) preview.style.display = 'none';
                if (noPhotoText) noPhotoText.style.display = 'block';
            }
        });
    }

    cargarMisCitas();
});

function cargarMisCitas() {
    fetch('include/obtenercitasusuario.php')
        .then(response => response.json())
        .then(citas => {
            document.getElementById('cargandoCitas').style.display = 'none';

            const listaCitas = document.getElementById('listaCitas');
            const sinCitas = document.getElementById('sinCitas');

            if (citas.length === 0) {
                sinCitas.style.display = 'block';
                listaCitas.innerHTML = '';
            } else {
                sinCitas.style.display = 'none';
                listaCitas.innerHTML = '';

                citas.forEach(cita => {
                    // ✅ CORRECCIÓN: Formateo manual de fecha
                    const partes = cita.fecha.split('-');
                    const fecha = `${partes[2]}/${partes[1]}/${partes[0]}`;
                    
                    const estadoClass = `estado-${cita.estado.toLowerCase().replace(' ', '-')}`;
                    // Solo mostrar botón cancelar si está pendiente
                    const puedeCancelar = cita.estado === 'pendiente';

                    listaCitas.innerHTML += `
                        <div class="cita-card ${cita.estado === 'cancelada' ? 'cita-cancelada' : ''}">
                            <div class="cita-header">
                                <div class="cita-mascota">🐾 ${cita.nombre_mascota}</div>
                                <span class="estado-cita ${estadoClass}">${cita.estado}</span>
                            </div>
                            <div class="cita-info">
                                <div class="cita-detalle">
                                    <span class="fa fa-calendar"></span>
                                    <strong>Fecha:</strong> ${fecha}
                                </div>
                                <div class="cita-detalle">
                                    <span class="fa fa-clock-o"></span>
                                    <strong>Hora:</strong> ${cita.hora}
                                </div>
                                <div class="cita-detalle">
                                    <span class="fa fa-scissors"></span>
                                    <strong>Servicio:</strong> ${cita.servicio}
                                </div>
                                <div class="cita-detalle">
                                    <span class="fa fa-map-marker"></span>
                                    <strong>Sucursal:</strong> ${cita.sucursal}
                                </div>
                                <div class="cita-detalle">
                                    <span class="fa fa-info-circle"></span>
                                    <strong>ID Cita:</strong> #${cita.id_cita}
                                </div>
                            </div>
                            ${puedeCancelar ? `
                            <div class="cita-actions">
                                <button class="btn btn-cancelar-cita" 
                                        onclick="cancelarCita(${cita.id_cita}, '${cita.nombre_mascota}')">
                                    <span class="fa fa-times"></span> Cancelar Cita
                                </button>
                            </div>
                            ` : ''}
                        </div>
                    `;
                });
            }
        })
        .catch(error => {
            console.error('Error:', error);
            document.getElementById('cargandoCitas').innerHTML =
                '<p>Error al cargar las citas. Intenta más tarde.</p>';
        });
}

function cancelarCita(id_cita, nombre_mascota) {
    Swal.fire({
        title: '¿Cancelar cita?',
        html: `¿Estás seguro de que quieres cancelar la cita de <strong>${nombre_mascota}</strong>?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#08922bff',
        confirmButtonText: 'Sí, cancelar',
        cancelButtonText: 'Mantener cita'
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: 'Cancelando...',
                text: 'Cancelando cita 🐾',
                icon: 'info',
                allowOutsideClick: false,
                showConfirmButton: false,
                didOpen: () => Swal.showLoading()
            });

            fetch('include/cancelarCita.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ id_cita: id_cita })
            })
                .then(response => response.json())
                .then(data => {
                    Swal.close();
                    if (data.success) {
                        Swal.fire('¡Cita cancelada!', data.message, 'success').then(() => {
                            cargarMisCitas();
                        });
                    } else {
                        Swal.fire('Error', data.message, 'error');
                    }
                })
                .catch(error => {
                    Swal.close();
                    Swal.fire('Error', 'Error de conexión', 'error');
                });
        }
    });
}