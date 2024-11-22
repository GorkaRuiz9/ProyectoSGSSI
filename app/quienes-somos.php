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
    <style>
        /* Estilos globales */
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #1a1a1a;
            color: #fff;
        }

        /* Estilos del header */
        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #333;
            padding: 20px;
        }

        .logo {
            font-size: 1.5em;
            font-weight: bold;
            color: #fff;
        }

        nav ul {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
        }

        nav ul li {
            margin-right: 20px;
        }

        nav ul li a {
            color: #fff;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        nav ul li a:hover {
            color: #6c63ff;
        }

        /* Botones de autenticación */
        .auth-buttons {
            float: right;
        }

        .auth-btn {
            background-color: #6c63ff;
            color: #fff;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            margin-left: 10px;
        }

        .auth-btn:hover {
            background-color: #5851db;
        }

        /* Estilos del main */
        main {
            padding: 20px;
            max-width: 800px;
            margin: 0 auto;
        }

        h1 {
            font-size: 2.5em;
            color: #6c63ff;
        }

        h2 {
            margin-top: 30px;
        }

        p {
            font-size: 1.2em;
            margin-bottom: 20px;
        }

        /* Estilos de la lista de valores */
        .valores-container {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        .valores-list {
            text-align: left;
            margin-left: 50px;
            list-style-type: none;
            padding: 0;
        }

        .valores-list li {
            margin-bottom: 10px;
        }

        /* Estilos de la imagen del concesionario */
        .concesionario-image {
            max-width: 300px;
            height: auto;
            margin-top: 30px;
            border-radius: 15px;
        }

        /* Estilos del footer */
        footer {
            text-align: center;
            padding: 20px;
            background-color: #333;
            color: #fff;
        }

        footer p:hover {
            color: #6c63ff;
        }
    </style>
</head>
<body>
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

    <div style="margin-top: 30px;">
        <h2>Síguenos en nuestras redes sociales</h2>
        <p><a href="https://instagram.com/ConcesionarioManolin" target="_blank">Instagram</a></p>
        <p><a href="https://facebook.com/ConcesionarioManolinBilbao" target="_blank">Facebook</a></p>
        <p><a href="https://twitter.com/ManolinCoches" target="_blank">Twitter</a></p>
    </div>

    <img src="concesionario.jpg" alt="Imagen del concesionario" class="concesionario-image">
</main>
<footer>
    <p>&copy; 2024 Concesionario Manolín - Todos los derechos reservados.</p>
</footer>
</body>
</html>

