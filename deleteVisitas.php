<?php
    session_start();
    require 'config.php';

    if ($_SESSION['user_rol'] !== 'admin') exit("Sense permisos");

    $id = (int) $_GET['id'];
    $stmt = $mysqli->prepare("DELETE FROM visitas WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    header("Location: adminVisites.php");
exit;