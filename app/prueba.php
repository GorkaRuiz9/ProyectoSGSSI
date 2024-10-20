<!DOCTYPE html>
<html lang="es">
<head> 
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aurora - Concesionario</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f4f8;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #e8eaf6;
            padding: 20px;
            text-align: center;
        }

        header h1 {
            color: #607d8b;
            font-size: 36px;
            margin: 0;
        }

        nav {
            margin-top: 10px;
            display: flex;
            justify-content: center;
            background-color: #cfd8dc;
        }

        nav a {
            color: #455a64;
            padding: 15px 20px;
            text-decoration: none;
            font-size: 18px;
            transition: background-color 0.3s;
        }

        nav a:hover {
            background-color: #b0bec5;
        }

        section {
            padding: 40px;
            text-align: center;
        }

        section h2 {
            color: #546e7a;
            font-size: 28px;
            margin-bottom: 20px;
        }

        .car-grid {
            display: flex;
            justify-content: center;
            gap: 20px;
            flex-wrap: wrap;
        }

        .car-item {
            background-color: #ffffff;
            border: 1px solid #b0bec5;
            border-radius: 10px;
            padding: 20px;
            width: 280px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: box-shadow 0.3s;
        }

        .car-item:hover {
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }

        .car-item img {
            max-width: 100%;
            height: auto;
            border-radius: 10px;
        }

        .car-item h3 {
            color: #37474f;
            font-size: 22px;
            margin: 15px 0;
        }

        .car-item p {
            color: #607d8b;
        }

        footer {
            background-color: #e8eaf6;
            text-align: center;
            padding: 10px 0;
            position: fixed;
            bottom: 0;
            width: 100%;
        }

        footer p {
            color: #78909c;
            font-size: 16px;
        }
    </style>
</head>
<body>
    <header>
        <h1>Bienvenidos a Concesionario Aurora</h1>
        <nav>
            <a href="#">Inicio</a>
            <a href="#">Modelos</a>
            <a href="#">Servicios</a>
            <a href="#">Contacto</a>
        </nav>
    </header>

    <section>
        <h2>Descubre Nuestros Modelos</h2>
        <div class="car-grid">
            <div class="car-item">
                <img src="car1.jpg" alt="Modelo 1">
                <h3>Aurora Sedan 2024</h3>
                <p>Un coche familiar con tecnología avanzada y confort.</p>
            </div>
            <div class="car-item">
                <img src="car2.jpg" alt="Modelo 2">
                <h3>Aurora SUV 2024</h3>
                <p>El poder y el estilo se combinan en este SUV moderno.</p>
            </div>
            <div class="car-item">
                <img src="car3.jpg" alt="Modelo 3">
                <h3>Aurora Eléctrico 2024</h3>
                <p>La movilidad del futuro con cero emisiones y máximo rendimiento.</p>
            </div>
        </div>
    </section>

    <footer>
        <p>&copy; 2024 Concesionario Aurora. Todos los derechos reservados.</p>
    </footer>
</body>
</html>

