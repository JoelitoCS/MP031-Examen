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
* { margin:0; padding:0; box-sizing:border-box; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }

body {
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    background: linear-gradient(135deg, #4e54c8, #8f94fb);
    background-size: 400% 400%;
    animation: gradientBG 10s ease infinite;
}
/* Crea un fondo animado de gradiente que cambia de posición continuamente */

@keyframes gradientBG {
    0% {background-position:0% 50%;}
    50% {background-position:100% 50%;}
    100% {background-position:0% 50%;}
}
/* Animación que mueve el gradiente de fondo de izquierda a derecha */

.login-container {
    width: 350px;
    max-width: 90%;
    padding: 40px 30px;
    border-radius: 20px;
    background: rgba(255,255,255,0.1);
    backdrop-filter: blur(15px);
    box-shadow: 0 15px 30px rgba(0,0,0,0.3);
    color: #fff;
    display: flex;
    flex-direction: column;
    align-items: center;
}
/* Card central del login con fondo semi-transparente, blur y sombra */

h2 {
    margin-bottom: 20px;
    font-size: 2rem;
    text-shadow: 2px 2px 8px rgba(0,0,0,0.3);
}
/* Título del login con sombra para destacar */

.error-message {
    width: 100%;
    text-align: center;
    background: rgba(255,0,0,0.3);
    color: #fff;
    padding: 12px 15px;
    margin-bottom: 15px;
    border-radius: 15px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    animation: fadeIn 0.5s ease;
}
/* Mensaje de error dentro del card con animación fadeIn */

form {
    width: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
}
/* Estilo del formulario: columnas centradas */

form input {
    width: 100%;
    padding: 15px 20px;
    margin: 10px 0;
    border-radius: 50px;
    border: none;
    outline: none;
    background: rgba(255,255,255,0.2);
    color: #fff;
    font-size: 1rem;
    transition: all 0.3s ease;
}
/* Inputs del formulario con fondo semitransparente y bordes redondeados */

form input::placeholder { color: rgba(255,255,255,0.7); }
/* Color del placeholder */

form input:focus {
    background: rgba(255,255,255,0.3);
    box-shadow: 0 0 10px rgba(255,255,255,0.5);
}
/* Estilo al enfocar el input */

form input[type="submit"] {
    background: linear-gradient(135deg, #ff416c, #ff4b2b);
    font-weight: bold;
    letter-spacing: 1px;
    cursor: pointer;
    transition: all 0.4s ease;
}
/* Botón de submit con gradiente y efecto hover */

form input[type="submit"]:hover {
    transform: scale(1.05);
    box-shadow: 0 5px 20px rgba(255,75,43,0.5);
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