<?php
session_start();
require_once 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nom = $_POST['nombre'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $rol = 'veterinario';
    
    $password_hasheada = password_hash($password, PASSWORD_DEFAULT);
    
    $stmt = $mysqli->prepare("INSERT INTO usuarios (nombre, email, password, rol) VALUES (?, ?, ?, 'veterinario')");

    if (!$stmt) {
        die("Error en la preparación de la consulta: " . $mysqli->error);
    }
    
    $stmt->bind_param("sss", $nom, $email, $password_hasheada);
    
    if ($stmt->execute()) {
        echo "Registro exitoso. Ahora puedes <a href='login.php'>iniciar sesión</a>.";
    } else {
        echo "Error en el registro: " . $stmt->error;
    }
    //7. Cerramos la declaración (conexion)
    $stmt->close();
    $mysqli->close();
}

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            min-height: 100vh;
        }

        .login-container {
            width: 400px;
            max-width: 90%;
            padding: 50px 40px;
            border-radius: 12px;
            background: #ffffff;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
            color: #1a1a1a;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        h2 {
            margin-bottom: 30px;
            font-size: 2rem;
            color: #1e3c72;
            font-weight: 700;
            letter-spacing: -0.5px;
        }

        .error-message {
            width: 100%;
            text-align: center;
            background: #fef2f2;
            color: #dc2626;
            padding: 14px 16px;
            margin-bottom: 20px;
            border-radius: 8px;
            border-left: 4px solid #dc2626;
            animation: fadeIn 0.5s ease;
            font-size: 0.95rem;
            font-weight: 500;
        }

        form {
            width: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        form input {
            width: 100%;
            padding: 14px 16px;
            margin: 10px 0;
            border-radius: 8px;
            border: 1.5px solid #e5e7eb;
            outline: none;
            background: #f9fafb;
            color: #1a1a1a;
            font-size: 0.95rem;
            transition: all 0.3s ease;
        }

        form input::placeholder {
            color: #9ca3af;
            font-weight: 500;
        }

        form input:focus {
            background: #ffffff;
            border-color: #2a5298;
            box-shadow: 0 0 0 3px rgba(42, 82, 152, 0.1);
        }

        form input[type="submit"] {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            color: #ffffff;
            font-weight: 600;
            letter-spacing: 0.5px;
            cursor: pointer;
            border: none;
            margin-top: 10px;
            transition: all 0.3s ease;
        }

        form input[type="submit"]:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(30, 60, 114, 0.3);
        }

        form input[type="submit"]:active {
            transform: translateY(0);
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body>
    <div class="login-container">
        <h2>Registro de Usuario</h2>
        <!-- CREO EL FORMULARIO PARA NOM EMAIL PASSWORD -->
        <form method="POST" action="register.php">
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" required><br><br>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required><br><br>

            <label for="password">Contraseña:</label>
            <input type="password" id="password" name="password" required><br><br>

            <input type="submit" value="Registrar">
        </form>
    </div>

</body>

</html>