<?php
session_start(); // Iniciar sesión
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiénes Somos - Concesionario Manolín</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/styles1.css"> <!--Elegimos el estilo styles1.css para la página-->
    <style>
        // Estilo para  el cuerpo
        body {
            margin: 0; /* Elimina el margen predeterminado */
            background-color: #1a1a1a; /* Color de fondo de la página */
            color: #ffffff; /* Color del texto */
            font-family: 'Roboto', sans-serif; /* Fuente de la página */
        }

        // Estilo para el footer 
        footer {
            text-align: center; /* Centra el texto del pie de página */
            background-color: #333; /* Color de fondo para el footer */
            padding: 10px 0; /* Espaciado interno */
            color: #ffffff; /* Color del texto del footer */
        }

        // Estilo para el main 
        main {
            padding: 20px; /* Espaciado interno para el contenido */
            max-width: 800px; /* Ancho máximo para que no se extienda demasiado */
            margin: 0 auto; /* Centra el contenido */
        }

        // Estilo para el contenedor de valores
        .valores-container {
            display: flex; /*Centrar el contenido */
            justify-content: center; /* Centrar horizontalmente */
            align-items: center; /* Centrar verticalmente */
            margin-top: 20px; /* Espacio superior */
        }

        // Estilo para la sección de valores 
        .valores-list {
            text-align: left; /* Alinear el texto a la izquierda */
            margin-left: 50px; /* Sangrado uniforme a la izquierda */
            list-style-type: none; /* Eliminar los puntos de la lista */
            padding: 0; /* Eliminar el padding predeterminado */
        }

        .valores-list li {
            margin-bottom: 10px; /* Espacio entre cada elemento de la lista */
        }

        // Estilo para la imagen del concesionario 
        .concesionario-image {
            max-width: 300px; /* Ajusta el ancho máximo deseado */
            height: auto; /* Mantiene la proporción de la imagen */
            margin-top: 30px;
            border-radius: 15px;
        }
    </style>
</head>
<body>
<!--Encabezado. Vinculamos los ficheros con sus respectivas páginas-->
<header>
    <div class="logo">Concesionario Manolín</div>
    <nav>
        <ul>
            <li><a href="index.php">Inicio</a></li>
            <li><a href="quienes-somos.php">Quiénes Somos</a></li>
            <li><a href="items.php">Listado de Coches</a></li>
            <li><a href="contacto.php">Contacto</a></li>
        </ul>
    </nav>
<!--Botones de Registro e Inicio de sesión-->
    <div class="auth-buttons">
        <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
            <a href="show_user.php" id="profile-btn" class="auth-btn">Perfil</a>
            <a href="logout.php" class="auth-btn">Cerrar Sesión</a>
        <?php else: ?>
            <a href="login.html" id="login-btn" class="auth-btn">Iniciar Sesión</a>
            <a href="register.html" id="register-btn" class="auth-btn">Registro</a>
        <?php endif; ?>
    </div>
</header>
<!--Cuerpo de la página. Escribimos los mensajes que queremos que se lean.-->
<main>
    <h1>Quiénes Somos</h1>
    <p>En el <strong>Concesionario Manolín</strong>, llevamos más de 15 años en Bilbao ofreciendo vehículos de alta gama. Nos apasiona ayudar a nuestros clientes a encontrar el coche perfecto que se adapte a sus necesidades y estilo de vida. Nuestra amplia experiencia en el sector nos permite ofrecer un servicio excepcional, siempre con una atención personalizada.</p>

    <h2>Nuestra Misión</h2>
    <p>Proporcionar una experiencia de compra única y personalizada, ofreciendo una selección de vehículos de alta calidad y un servicio al cliente excepcional. Creemos que cada cliente es único y merece un trato que refleje sus expectativas y necesidades individuales.</p>

    <h2>Nuestra Visión</h2>
    <p>Ser el concesionario de referencia en Bilbao, reconocido por nuestra integridad, calidad y compromiso con la satisfacción del cliente. Aspiramos a expandir nuestra red y establecer alianzas con marcas líderes para ofrecer aún más opciones a nuestros clientes.</p>

    <h2>Valores</h2>
    <div class="valores-container">
        <ul class="valores-list">
            <li>🔹 <strong>Calidad</strong>: Seleccionamos solo los mejores vehículos, garantizando estándares altos en cada compra.</li>
            <li>🔹 <strong>Confianza</strong>: Nos comprometemos a ser transparentes y honestos en todas nuestras interacciones, construyendo relaciones duraderas.</li>
            <li>🔹 <strong>Compromiso</strong>: Estamos dedicados a brindar el mejor servicio posible a nuestros clientes, asegurando su satisfacción total.</li>
            <li>🔹 <strong>Innovación</strong>: Nos mantenemos al día con las últimas tendencias y tecnologías en el sector automotriz, incorporando lo mejor para nuestros clientes.</li>
        </ul>
    </div>

    <h2>¿Por Qué Elegirnos?</h2>
    <p>En el <strong>Concesionario Manolín</strong>, no solo vendemos coches, sino que creamos relaciones. Nuestro equipo de expertos está siempre listo para asesorarte y acompañarte en cada paso del proceso de compra. Nos enorgullece ser parte de tu viaje hacia la adquisición del coche de tus sueños. Además, ofrecemos un servicio post-venta para asegurar que tu experiencia con nosotros sea siempre positiva.</p>
<!--URLs de redes sociales-->
    <div style="margin-top: 30px;">
        <h2>Síguenos en nuestras redes sociales</h2>
        <p><a href="https://instagram.com/ConcesionarioManolin" target="_blank">Instagram</a></p>
        <p><a href="https://facebook.com/ConcesionarioManolinBilbao" target="_blank">Facebook</a></p>
        <p><a href="https://twitter.com/ManolinCoches" target="_blank">Twitter</a></p>
    </div>

    <!-- Imagen del concesionario -->
    <img src="concesionario.jpg" alt="Imagen del concesionario" class="concesionario-image">

</main>
<!--Pie de página-->
<footer>
    <p>&copy; 2024 Concesionario Manolín - Todos los derechos reservados.</p>
</footer>

<?php
// Incluimos el contenido de quienes-somos.html, si es necesario
// include 'quienes-somos.html';
?>

</body>
</html>

