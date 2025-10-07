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
});