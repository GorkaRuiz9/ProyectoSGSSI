function validarFormulario() {
    // Recopilar la informacion de los campos correspondientes
    const nombre = document.getElementById("nombre").value;
    const apellidos = document.getElementById("apellidos").value;
    const dni = document.getElementById("dni").value;
    const telefono = document.getElementById("telefono").value;
    const fechaNacimiento = document.getElementById("fecha_nacimiento").value;
    const email = document.getElementById("email").value;
    let errores = []; // Array para almacenar los mensajes de error

    // Validación de nombre y apellidos (solo permite letras y espacios)
    const nombreRegex = /^[\p{L}\s]+$/u;
    if (!nombreRegex.test(nombre)) {
        errores.push("El nombre solo debe contener letras.");
    }
    if (!nombreRegex.test(apellidos)) {
        errores.push("Los apellidos solo deben contener letras.");
    }

    // Validación de DNI (Formato 11111111-Z)
    const dniRegex = /^[0-9]{8}-[A-Z]$/; // Formato de DNI (8 dígitos seguidos de un guion y una letra)
    const letrasDNI = "TRWAGMYFPDXBNJZSQVHLCKE"; // Letras válidas según el número de DNI
    if (!dniRegex.test(dni)) {
        errores.push("El DNI debe tener el formato 11111111-Z.");
    } else {
        const numeroDNI = parseInt(dni.substr(0, 8), 10); // Extraer el número de los primeros 8 caracteres del DNI
        const letraDNI = dni.substr(-1); // Extraer la letra del último carácter
        if (letrasDNI[numeroDNI % 23] !== letraDNI) {
            errores.push("La letra del DNI no corresponde con el número.");
        }
    }

    // Validación de teléfono (solo 9 dígitos)
    const telefonoRegex = /^[0-9]{9}$/;
    if (!telefonoRegex.test(telefono)) {
        errores.push("El teléfono debe contener 9 dígitos.");
    }

    // Validación de fecha de nacimiento (formato aaaa-mm-dd)
    const fechaRegex = /^\d{4}-\d{2}-\d{2}$/;
    if (!fechaRegex.test(fechaNacimiento)) {
        errores.push("La fecha debe tener el formato aaaa-mm-dd.");
    }

    // Validación de email
    const emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/; // Acepta emails válidos con caracteres, números y dominios
    if (!emailRegex.test(email)) {
        errores.push("El formato del email no es válido.");
    }

    // Si hay errores, mostramos un mensaje y evitamos que el formulario se envíe
    if (errores.length > 0) {
        alert(errores.join("\n"));
        return false; // Impedir el envío del formulario
    }

    return true; // Si todo es correcto, permitimos el envío del formulario
}

