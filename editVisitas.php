<?php
session_start();
require 'config.php';
if ($_SESSION['user_rol'] !== 'admin') exit("Sin permisos");
$id = (int) $_GET['id'];
$result = $mysqli->query("SELECT * FROM visitas WHERE id = $id");
$animal = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fecha = $_POST['fecha'];
    $diagnostico = $_POST['diagnostico'];
    $tratamiento = $_POST['tratamiento'];
    $fechaCreación = $_POST['created_at'];


    $stmt = $mysqli->prepare(
        "UPDATE visitas SET fecha=?, diagnostico=?, tratamiento=?, created_at=? WHERE id=?"
    );
    $stmt->bind_param("ssssi", $fecha, $diagnostico, $tratamiento, $fechaCreación, $id);
    $stmt->execute();
    header("Location: adminVisites.php");
    exit;
}
?>
<style>
    body {
        background: linear-gradient(135deg, #232526 0%, #414345 100%);
        min-height: 100vh;
        margin: 0;
        font-family: 'Segoe UI', 'Roboto', Arial, sans-serif;
        color: #fff;
    }

    .form-container {
        max-width: 500px;
        margin: 60px auto;
        background: rgba(34, 40, 49, 0.97);
        border-radius: 18px;
        box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.25);
        padding: 40px 30px;
        text-align: left;
    }

    .form-container label {
        font-weight: 600;
        color: #38ef7d;
        margin-bottom: 6px;
        display: block;
    }

    .form-container input[type="text"],
    .form-container textarea {
        width: 100%;
        padding: 10px 12px;
        margin-bottom: 18px;
        border: none;
        border-radius: 7px;
        background: #232526;
        color: #fff;
        font-size: 1rem;
        box-shadow: 0 2px 8px rgba(56, 239, 125, 0.08);
        transition: background 0.2s, box-shadow 0.2s;
    }

    .form-container input[type="text"]:focus,
    .form-container textarea:focus {
        background: #414345;
        outline: none;
        box-shadow: 0 4px 16px rgba(56, 239, 125, 0.18);
    }

    .form-container textarea {
        min-height: 80px;
        resize: vertical;
    }

    .form-container input[type="submit"] {
        width: 100%;
        padding: 12px 0;
        background: linear-gradient(90deg, #11998e 0%, #38ef7d 100%);
        color: #fff;
        font-size: 1.1rem;
        font-weight: 700;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        box-shadow: 0 2px 8px rgba(56, 239, 125, 0.15);
        transition: background 0.2s, transform 0.2s;
    }

    .form-container input[type="submit"]:hover {
        background: linear-gradient(90deg, #38ef7d 0%, #11998e 100%);
        color: #232526;
        transform: translateY(-2px) scale(1.03);
    }
</style>
<div class="form-container">
    <form method="POST">
        <label>Fecha:</label><br>
        <input type="text" name="fecha" value="<?= $animal['fecha'] ?>" required><br><br>

        <label>Diagnostico:</label><br>
        <input type="text" name="diagnostico" value="<?= $animal['diagnostico'] ?>"><br><br>

        <label>Tratamiento:</label><br>
        <textarea name="tratamiento" value="<?= $animal['tratamiento'] ?>" required></textarea><br><br>

        <label>Fecha de la edición:</label><br>
        <input type="text" name="rol" value="<?= $animal['created_at'] ?>"><br><br>

        <input type="submit" value="Guardar Cambios">
    </form>
</div>