// Función para eliminar un coche
function eliminarCoche(id) {
    // Mostrar el ID en la consola
    console.log("ID del coche a eliminar:", id);

    // Preguntar al usuario si está seguro de eliminar el coche, incluyendo el ID
    if (confirm(`¿Estás seguro de que quieres eliminar el coche con ID: ${id}?`)) {
        fetch(`eliminar-coche.php?id=${id}`, {
            method: 'DELETE',
        })
        .then(response => {
            if (response.ok) {
                alert("Coche eliminado correctamente.");
                location.reload(); // Recargar la página para ver los cambios
            } else {
                alert("Hubo un problema al eliminar el coche.");
            }
        });
    }
}

