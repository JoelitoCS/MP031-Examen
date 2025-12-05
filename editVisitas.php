<?php
session_start();
require 'config.php';
if ($_SESSION['user_rol'] !== 'admin') exit("Sin permisos");
$id = (int) $_GET['id'];
$result = $mysqli->query("SELECT * FROM visitas WHERE id = $id");
$visita = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fecha = $_POST['fecha'];
    $diagnostico = $_POST['diagnostico'];
    $tratamiento = $_POST['tratamiento'];
    $fechaCreacion = $_POST['created_at'];

    $stmt = $mysqli->prepare(
        "UPDATE visitas SET fecha=?, diagnostico=?, tratamiento=?, created_at=? WHERE id=?"
    );
    $stmt->bind_param("ssssi", $fecha, $diagnostico, $tratamiento, $fechaCreacion, $id);
    $stmt->execute();
    header("Location: adminVisites.php");
    exit;
}
?>
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
<div class="login-container">
    <form method="POST">
        <label>Fecha:</label><br>
        <input type="text" name="fecha" value="<?= $visita['fecha'] ?>" required><br><br>

        <label>Diagnostico:</label><br>
        <input type="text" name="diagnostico" value="<?= $visita['diagnostico'] ?>"><br><br>

        <label>Tratamiento:</label><br>
        <textarea name="tratamiento" value="<?= $visita['tratamiento'] ?>" required></textarea><br><br>

        <label>Fecha de la edición:</label><br>
        <input type="text" name="created_at" value="<?= $visita['created_at'] ?>"><br><br>

        <input type="submit" value="Guardar Cambios">
    </form>
</div>