// Función para cargar los coches desde el archivo PHP
document.addEventListener("DOMContentLoaded", function() {
    fetch('listado-coches.php')
        .then(response => response.json())
        .then(data => {
            let select = document.getElementById("coches");

            // Limpiar el dropdown antes de añadir opciones
            select.innerHTML = ""; // Limpia las opciones existentes

            // Crear las opciones del dropdown
            data.forEach(coche => {
                let option = document.createElement("option");
                option.value = coche.id; // Cambiado para usar ID en el value
                option.setAttribute("data-info", coche.marca + " " + coche.nombre);
                option.textContent = coche.nombre + " (" + coche.marca + ")";
                select.appendChild(option);
            });
        });
});

// Función que se ejecuta cuando seleccionamos un coche
function mostrarCoche() {
    var select = document.getElementById("coches");
    var selectedOption = select.options[select.selectedIndex];
    var cocheInfo = selectedOption.getAttribute("data-info");

    // Mostrar la marca y nombre del coche en la columna vacía
    document.getElementById("coche-seleccionado").innerHTML = cocheInfo;
}

// Función para eliminar un coche
function eliminarCoche() {
    var select = document.getElementById("coches");
    var cocheId = select.value; // Obtener el ID del coche seleccionado

    // Confirmación antes de eliminar
    if (confirm("¿Estás seguro de que deseas eliminar este coche?")) {
        fetch(`eliminar-coche.php?id=${cocheId}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    location.reload(); // Recargar la página para actualizar la lista de coches
                } else {
                    alert(data.message);
                }
            })
            .catch(error => {
                console.error("Error:", error);
                alert("Hubo un problema al eliminar el coche.");
            });
    }
}

// Función para validar y enviar el formulario
function validarFormulario(event) {
    event.preventDefault(); // Evitar que se envíe el formulario automáticamente

    // Obtener valores de los campos
    const nombre = document.getElementById("nombre").value.trim();
    const marca = document.getElementById("marca").value.trim();
    const kilometros = parseInt(document.getElementById("kilometros").value);
    const plazas = parseInt(document.getElementById("plazas").value);
    const precio = parseFloat(document.getElementById("precio").value);

    // Validaciones
    if (nombre === "" || marca === "") {
        alert("Los campos Nombre y Marca no pueden estar vacíos.");
        return;
    }
    if (kilometros < 0) {
        alert("Los kilómetros no pueden ser negativos.");
        return;
    }
    if (plazas <= 0) {
        alert("El número de plazas debe ser mayor que cero.");
        return;
    }
    if (precio <= 0) {
        alert("El precio debe ser mayor que cero.");
        return;
    }

    // Si todas las validaciones pasan, enviar el formulario
    const form = document.getElementById("coche-form");
    form.submit();
}

