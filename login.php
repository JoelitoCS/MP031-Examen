<?php
session_start(); 

require_once 'config.php';

$mensajeError = ""; 

if ($_SERVER["REQUEST_METHOD"] == "POST"){
    // Comprueba si el formulario se ha enviado usando el método POST

    $email = trim($_POST['email']);
    // Obtiene el email ingresado y elimina espacios en blanco al inicio y final

    $password = $_POST['password'];
    // Obtiene la contraseña ingresada

    $stmt = $mysqli->prepare("SELECT id, nom, email, password, rol FROM usuarios WHERE email = ?");
    // Prepara una consulta segura para buscar un usuario por email

    $stmt->bind_param("s", $email);
    // Asigna el email como parámetro a la consulta preparada (tipo string "s")

    $stmt->execute();
    // Ejecuta la consulta

    $result = $stmt->get_result();
    // Obtiene el resultado de la consulta como un objeto de resultado

    if ($result->num_rows === 1){
        // Si se encontró exactamente un usuario con ese email

        $user = $result->fetch_assoc();
        // Extrae los datos del usuario como un array asociativo

        if (password_verify($password, $user['password']) || $password === $user['password']){

            if (!password_get_info($user['password'])['algo']) {

                // Si la contraseña almacenada no está hasheada

                $hashed = password_hash($password, PASSWORD_DEFAULT);
                // Hashea la contraseña usando el algoritmo por defecto

                $stmt_update = $mysqli->prepare("UPDATE usuarios SET password = ? WHERE id = ?");
              

                $stmt_update->bind_param("si", $hashed, $user['id']);
                

                $stmt_update->execute();
                // Ejecuta la actualización de la contraseña

                $stmt_update->close();
                // Cierra la consulta de actualización
            }

            $_SESSION['user_id'] = $user['id'];
            // Guarda el id del usuario en la sesión

            $_SESSION['user_name'] = $user['nombre'];
            // Guarda el nombre del usuario en la sesión

            $_SESSION['user_email'] = $user['email'];
            // Guarda el email del usuario en la sesión

            $_SESSION['user_rol'] = $user['rol'];
            // Guarda el rol del usuario en la sesión (user/admin)

            header("Location: index.php");
            // Redirige al usuario a index.php después de iniciar sesión

            exit();
            // Finaliza la ejecución del script para evitar que se ejecute código adicional
        } else {
            $mensajeError = "Contraseña incorrecta, inténtalo de nuevo.";
            // Mensaje de error si la contraseña no coincide
        }
    } else {
        $mensajeError = "No se encontró ningún usuario con ese email.";
        // Mensaje de error si el email no está registrado
    }

    $stmt->close();
    // Cierra la consulta de selección

    $mysqli->close();
    // Cierra la conexión a la base de datos
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login de Usuario</title>
<style>
/* RESET de estilos */
* { margin:0; padding:0; box-sizing:border-box; font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }

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
    from {opacity:0; transform: translateY(-10px);}
    to {opacity:1; transform: translateY(0);}
}
/* Animación para que los elementos de error aparezcan suavemente */
</style>
</head>
<body>
<div class="login-container">
    <h2>Login de Usuario</h2>

    <!-- Muestra el mensaje de error si $error no está vacío -->
    <?php if(!empty($error)) { echo '<div class="error-message">'.$error.'</div>'; } ?>

    <form method="POST" action="login.php">
        <input type="email" id="email" name="email" placeholder="Email" required>
        <input type="password" id="password" name="password" placeholder="Contraseña" required>
        <input type="submit" value="Iniciar Sesión">
    </form>
</div>
</body>
</html>