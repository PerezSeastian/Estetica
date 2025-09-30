// Datos de ejemplo para las mascotas
let pets = [
    {
        name: "Max",
        species: "Perro",
        breed: "Golden Retriever",
        age: "3 años",
        notes: "Le encanta jugar en el parque"
    },
    {
        name: "Luna",
        species: "Gato", 
        breed: "Siames",
        age: "2 años",
        notes: "Timida pero cariñosa"
    }
];

// Cargar mascotas al iniciar
document.addEventListener('DOMContentLoaded', function() {
    loadPets();
});

// Función para cargar las mascotas en el HTML
function loadPets() {
    const petsContainer = document.getElementById('petsContainer');
    petsContainer.innerHTML = '';

    pets.forEach((pet, index) => {
        const petCard = `
            <div class="pet-card">
                <div class="pet-header">
                    <div class="pet-avatar">
                        <span class="fa fa-paw"></span>
                    </div>
                    <div class="pet-info">
                        <h5>${pet.name}</h5>
                        <span class="badge badge-info">${pet.species}</span>
                    </div>
                </div>
                <div class="pet-details">
                    <div class="pet-detail">
                        <strong>Raza:</strong> ${pet.breed}
                    </div>
                    <div class="pet-detail">
                        <strong>Edad:</strong> ${pet.age}
                    </div>
                    <div class="pet-detail">
                        <strong>Notas:</strong> ${pet.notes}
                    </div>
                </div>
                <div class="pet-actions">
                    <button class="btn-action btn-edit-pet" onclick="editPet(${index})">
                        <span class="fa fa-edit mr-1"></span>Editar
                    </button>
                    <button class="btn-action btn-delete-pet" onclick="showDeleteConfirm(${index})">
                        <span class="fa fa-trash mr-1"></span>Eliminar
                    </button>
                </div>
            </div>
        `;
        petsContainer.innerHTML += petCard;
    });
}

// Función para guardar el perfil
function saveProfile() {
    const name = document.getElementById('editName').value;
    const email = document.getElementById('editEmail').value;
    const phone = document.getElementById('editPhone').value;
    const address = document.getElementById('editAddress').value;

    document.getElementById('userName').textContent = name;
    document.getElementById('userEmail').textContent = email;
    document.getElementById('userPhone').textContent = phone;
    document.getElementById('userAddress').textContent = address;

    $('#editProfileModal').modal('hide');
    alert('Perfil actualizado correctamente!');
}

function showAddPetModal() {
    document.getElementById('petModalTitle').textContent = 'Agregar Mascota';
    document.getElementById('editPetIndex').value = '';
    document.getElementById('petForm').reset();
}

function editPet(index) {
    const pet = pets[index];
    document.getElementById('petModalTitle').textContent = 'Editar Mascota';
    document.getElementById('editPetIndex').value = index;
    document.getElementById('petName').value = pet.name;
    document.getElementById('petSpecies').value = pet.species;
    document.getElementById('petBreed').value = pet.breed;
    document.getElementById('petAge').value = pet.age;
    document.getElementById('petNotes').value = pet.notes;
    $('#petModal').modal('show');
}

function savePet() {
    const index = document.getElementById('editPetIndex').value;
    const petData = {
        name: document.getElementById('petName').value,
        species: document.getElementById('petSpecies').value,
        breed: document.getElementById('petBreed').value,
        age: document.getElementById('petAge').value,
        notes: document.getElementById('petNotes').value
    };

    if (index === '') {
        pets.push(petData);
    } else {
        pets[index] = petData;
    }

    loadPets();
    $('#petModal').modal('hide');
    alert('Mascota guardada correctamente!');
}

function showDeleteConfirm(index) {
    document.getElementById('deletePetIndex').value = index;
    $('#deleteConfirmModal').modal('show');
}

function confirmDeletePet() {
    const index = document.getElementById('deletePetIndex').value;
    pets.splice(index, 1);
    loadPets();
    $('#deleteConfirmModal').modal('hide');
    alert('Mascota eliminada correctamente!');
}